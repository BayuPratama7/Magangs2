<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_role([5]); // role mahasiswa
        $this->load->model([
            'Mahasiswa_model',
            'Proposal_model',
            'Logbook_model',
            'Laporan_model',
            'Desiminasi_model',
            'Dashboard_model',
            'Dosen_model'
        ]);
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $mahasiswa = $this->Mahasiswa_model->get_by_user($user_id);

        if (!$mahasiswa) {
            show_error('Data mahasiswa tidak ditemukan');
        }

        // Get proposal
        $proposal = $this->Proposal_model->get_by_mahasiswa($mahasiswa->mahasiswa_id);

        // Get surat pengantar
        $surat_pengantar = null;
        if ($proposal) {
            $this->db->select('*')
                ->from('surat_pengantar')
                ->where('mahasiswa_id', $mahasiswa->mahasiswa_id);
            $surat_pengantar = $this->db->get()->row();
        }

        // Get DPL info
        $dpl = null;
        if ($mahasiswa->dosen_dpl_id) {
            $dpl = $this->Dosen_model->get_by_id($mahasiswa->dosen_dpl_id);
        }

        // Get logbook count
        $logbooks = $this->Logbook_model->get_by_mahasiswa($mahasiswa->mahasiswa_id);

        // Get laporan
        $laporan = $this->Laporan_model->get_latest_by_mahasiswa($mahasiswa->mahasiswa_id);

        // Get desiminasi
        $desiminasi = $this->Desiminasi_model->get_by_mahasiswa($mahasiswa->mahasiswa_id);

        // Get hasil desiminasi for detailed status
        $hasil_desiminasi = null;
        if ($desiminasi) {
            $this->load->model('Administrasi_model');
            $hasil_desiminasi = $this->Administrasi_model->get_hasil_by_desiminasi($desiminasi->desiminasi_id);
        }

        // Stats
        $stats = new stdClass();
        $stats->status_proposal = $proposal ? ucfirst($proposal->status_kaprodi) : 'Belum';
        $stats->logbook_count = count($logbooks);
        $stats->laporan_status = $laporan ? ucfirst($laporan->status_dpl) : 'Belum';
        
        // Detailed desiminasi status
        if ($hasil_desiminasi && $hasil_desiminasi->status_laporan_akhir == 'disetujui') {
            $stats->desiminasi_status = 'Selesai';
        } elseif ($hasil_desiminasi && $hasil_desiminasi->status_laporan_akhir == 'menunggu_revisi') {
            $stats->desiminasi_status = 'Revisi Diupload';
        } elseif ($hasil_desiminasi && $hasil_desiminasi->status_laporan_akhir == 'revisi') {
            $stats->desiminasi_status = 'Perlu Revisi';
        } elseif ($hasil_desiminasi && $hasil_desiminasi->status_laporan_akhir == 'menunggu') {
            $stats->desiminasi_status = 'Menunggu ACC';
        } elseif ($hasil_desiminasi && $hasil_desiminasi->status_kelulusan) {
            $stats->desiminasi_status = ucfirst(str_replace('_', ' ', $hasil_desiminasi->status_kelulusan));
        } elseif ($desiminasi) {
            $stats->desiminasi_status = ucfirst($desiminasi->status_pengajuan);
        } else {
            $stats->desiminasi_status = 'Belum';
        }

        // Dashboard info
        $mitra = $this->Dashboard_model->get_all_mitra();
        $sebaran_jenis = $this->Dashboard_model->get_sebaran_by_jenis();

        $data = [
            'page_title' => 'Dashboard Mahasiswa',
            'mahasiswa' => $mahasiswa,
            'proposal' => $proposal,
            'surat_pengantar' => $surat_pengantar,
            'dpl' => $dpl,
            'stats' => $stats,
            'mitra' => $mitra,
            'sebaran_jenis' => $sebaran_jenis
        ];

        $data['content'] = $this->load->view('dashboard/mahasiswa_content', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }
}

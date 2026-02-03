<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_role([4]); // role DPL
        $this->load->model([
            'Dosen_model',
            'Mahasiswa_model',
            'Logbook_model',
            'Laporan_model',
            'Administrasi_model'
        ]);
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $dosen = $this->Dosen_model->get_by_user($user_id);

        if (!$dosen) {
            show_error('Data dosen tidak ditemukan');
        }

        // Get mahasiswa bimbingan
        $mahasiswa_bimbingan = $this->Dosen_model->get_mahasiswa_bimbingan($dosen->dosen_id);

        // Add logbook count and desiminasi status for each mahasiswa
        foreach ($mahasiswa_bimbingan as &$m) {
            $m->logbook_count = $this->Logbook_model->count_complete_logbook($m->mahasiswa_id);
            $laporan = $this->Laporan_model->get_latest_by_mahasiswa($m->mahasiswa_id);
            $m->laporan_status = $laporan ? $laporan->status_dpl : 'belum';
            
            // Get desiminasi status
            $this->db->select('d.status_pengajuan, h.status_kelulusan, h.status_laporan_akhir')
                ->from('desiminasi d')
                ->join('hasil_desiminasi h', 'h.desiminasi_id = d.desiminasi_id', 'left')
                ->where('d.mahasiswa_id', $m->mahasiswa_id);
            $desiminasi = $this->db->get()->row();
            
            if ($desiminasi && $desiminasi->status_laporan_akhir == 'disetujui') {
                $m->desiminasi_status = 'selesai';
            } elseif ($desiminasi && $desiminasi->status_laporan_akhir == 'menunggu_revisi') {
                $m->desiminasi_status = 'revisi_uploaded';
            } elseif ($desiminasi && $desiminasi->status_laporan_akhir == 'revisi') {
                $m->desiminasi_status = 'perlu_revisi';
            } elseif ($desiminasi && $desiminasi->status_laporan_akhir == 'menunggu') {
                $m->desiminasi_status = 'menunggu_acc';
            } elseif ($desiminasi && $desiminasi->status_kelulusan) {
                $m->desiminasi_status = $desiminasi->status_kelulusan;
            } elseif ($desiminasi) {
                $m->desiminasi_status = 'proses';
            } else {
                $m->desiminasi_status = 'belum';
            }
        }

        // Get pending laporan review
        $pending_laporan = $this->Laporan_model->get_pending_review_by_dpl($dosen->dosen_id);

        // Get recent logbooks
        $recent_logbooks = $this->Logbook_model->get_all_by_dpl($dosen->dosen_id);

        // Get jadwal desiminasi mahasiswa bimbingan
        $this->db->select('j.*, m.nim, m.nama_mahasiswa')
            ->from('jadwal_desiminasi j')
            ->join('mahasiswa m', 'm.mahasiswa_id = j.mahasiswa_id')
            ->where('m.dosen_dpl_id', $dosen->dosen_id)
            ->where('j.tanggal_desiminasi >=', date('Y-m-d'))
            ->order_by('j.tanggal_desiminasi', 'ASC');
        $jadwal_desiminasi = $this->db->get()->result();

        // Stats
        $stats = new stdClass();
        $stats->total_mahasiswa = count($mahasiswa_bimbingan);
        $stats->pending_logbook = $this->db
            ->join('mahasiswa m', 'm.mahasiswa_id = logbook_magang.mahasiswa_id')
            ->where('m.dosen_dpl_id', $dosen->dosen_id)
            ->where('logbook_magang.status_dpl', 'belum_review')
            ->count_all_results('logbook_magang');
        $stats->pending_laporan = count($pending_laporan);
        $stats->upcoming_desiminasi = count($jadwal_desiminasi);

        $data = [
            'page_title' => 'Dashboard DPL',
            'dosen' => $dosen,
            'mahasiswa_bimbingan' => $mahasiswa_bimbingan,
            'pending_laporan' => $pending_laporan,
            'recent_logbooks' => $recent_logbooks,
            'jadwal_desiminasi' => $jadwal_desiminasi,
            'stats' => $stats
        ];

        $data['content'] = $this->load->view('dashboard/dosen_content', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }
}

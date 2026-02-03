<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sekretaris extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_role([3]); // role sekretaris
        $this->load->model([
            'Mahasiswa_model',
            'Administrasi_model',
            'Dashboard_model',
            'Desiminasi_model',
            'Dosen_model'
        ]);
    }

    public function index()
    {
        // Get mahasiswa tanpa DPL
        $pending_dpl = $this->Administrasi_model->get_mahasiswa_tanpa_dpl();

        // Get upcoming jadwal
        $upcoming_jadwal = $this->Administrasi_model->get_upcoming_jadwal();

        // Get pending desiminasi (belum ada penguji)
        $pending_penguji = $this->Desiminasi_model->get_all_pending();

        // Stats
        $stats = new stdClass();
        $stats->pending_dpl = count($pending_dpl);

        // Count mahasiswa yang sudah ACC tapi belum ada surat
        $this->db->select('m.mahasiswa_id')
            ->from('mahasiswa m')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id')
            ->join('surat_pengantar s', 's.mahasiswa_id = m.mahasiswa_id', 'left')
            ->where('p.status_kaprodi', 'disetujui')
            ->where('s.surat_id IS NULL');
        $stats->pending_surat = $this->db->count_all_results();

        $stats->pending_penguji = count($pending_penguji);

        // Count desiminasi yang sudah ada penguji tapi belum dijadwalkan
        $this->db->select('d.desiminasi_id')
            ->from('desiminasi d')
            ->join('jadwal_desiminasi j', 'j.desiminasi_id = d.desiminasi_id', 'left')
            ->where('d.penguji_id IS NOT NULL')
            ->where('d.konfirmasi_penguji', 'bersedia')
            ->where('j.jadwal_id IS NULL');
        $stats->pending_jadwal = $this->db->count_all_results();

        $stats->total_mitra = $this->Dashboard_model->count_mitra();
        $stats->total_sebaran = $this->db->count_all('sebaran_magang');

        $data = [
            'page_title' => 'Dashboard Sekretaris',
            'pending_dpl' => $pending_dpl,
            'upcoming_jadwal' => $upcoming_jadwal,
            'stats' => $stats
        ];

        $data['content'] = $this->load->view('dashboard/sekretaris_content', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }
}

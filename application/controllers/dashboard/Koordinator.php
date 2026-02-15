<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Koordinator extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_role([2]); // role koordinator
        $this->load->model([
            'Proposal_model',
            'Logbook_model',
            'Mahasiswa_model',
            'Desiminasi_model',
            'Administrasi_model',
            'Dashboard_model'
        ]);
    }

    public function index()
    {
        // Get pending proposals
        $pending_proposals = $this->Proposal_model->get_pending_koordinator();

        // Get recent logbooks
        $recent_logbooks = $this->Logbook_model->get_all_for_koordinator();

        // Get recent hasil desiminasi
        $this->db->select('h.*, m.nama_mahasiswa, m.nim')
            ->from('hasil_desiminasi h')
            ->join('mahasiswa m', 'm.mahasiswa_id = h.mahasiswa_id')
            ->where('h.status_kelulusan IS NOT NULL')
            ->order_by('h.created_at', 'DESC')
            ->limit(5);
        $recent_hasil = $this->db->get()->result();

        // Get mahasiswa progress for monitoring
        $this->db->select('m.mahasiswa_id, m.nim, m.nama_mahasiswa, p.instansi_tujuan, p.status_koordinator, p.status_kaprodi,
                          d.status_pengajuan as desiminasi_status, h.status_kelulusan, h.status_laporan_akhir')
            ->from('mahasiswa m')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id', 'left')
            ->join('desiminasi d', 'd.mahasiswa_id = m.mahasiswa_id', 'left')
            ->join('hasil_desiminasi h', 'h.mahasiswa_id = m.mahasiswa_id', 'left')
            ->where('p.status_koordinator', 'disetujui')
            ->order_by('m.nama_mahasiswa', 'ASC')
            ->limit(10);
        $mahasiswa_progress = $this->db->get()->result();

        // Stats
        $stats = new stdClass();
        $stats->pending_proposal = count($pending_proposals);
        $stats->approved_proposal = count($this->Proposal_model->get_approved_by_koordinator());
        $stats->total_logbook = $this->db->count_all('logbook_magang');
        $stats->total_mahasiswa = $this->db->where_in('status_magang', ['sedang_magang', 'diterima'])->count_all_results('mahasiswa');
        
        // Count desiminasi selesai
        $stats->desiminasi_selesai = $this->db
            ->where('status_laporan_akhir', 'disetujui')
            ->count_all_results('hasil_desiminasi');

        // Get sebaran jenis magang
        $sebaran_jenis = $this->Dashboard_model->get_sebaran_by_jenis();

        $data = [
            'page_title' => 'Dashboard Koordinator',
            'pending_proposals' => $pending_proposals,
            'recent_logbooks' => $recent_logbooks,
            'recent_hasil' => $recent_hasil,
            'mahasiswa_progress' => $mahasiswa_progress,
            'stats' => $stats,
            'sebaran_jenis' => $sebaran_jenis
        ];

        $data['content'] = $this->load->view('dashboard/koordinator_content', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }
}

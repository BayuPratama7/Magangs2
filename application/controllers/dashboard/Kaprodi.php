<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaprodi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_role([1]); // role kaprodi
        $this->load->model(['Proposal_model', 'Dashboard_model', 'Mahasiswa_model']);
    }

    public function index()
    {
        // Get pending proposals (sudah di-ACC koordinator)
        $pending_proposals = $this->Proposal_model->get_pending_kaprodi();

        // Get sebaran data
        $sebaran_jenis = $this->Dashboard_model->get_sebaran_by_jenis();
        $sebaran_wilayah = $this->Dashboard_model->get_sebaran_by_wilayah();

        // Stats
        $stats = new stdClass();
        $stats->pending_proposal = count($pending_proposals);
        $stats->approved_proposal = count($this->Proposal_model->get_approved());
        $stats->total_mahasiswa = $this->db->where_in('status_magang', ['sedang_magang', 'diterima', 'selesai'])->count_all_results('mahasiswa');
        $stats->total_mitra = $this->Dashboard_model->count_mitra();

        $data = [
            'page_title' => 'Dashboard Kaprodi',
            'pending_proposals' => $pending_proposals,
            'sebaran_jenis' => $sebaran_jenis,
            'sebaran_wilayah' => $sebaran_wilayah,
            'stats' => $stats
        ];

        $data['content'] = $this->load->view('dashboard/kaprodi_content', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    /**
     * Lihat hasil desiminasi yang sudah selesai (ACC penguji)
     */
    public function hasil()
    {
        // Get hasil desiminasi yang sudah ACC penguji
        $this->db->select('h.*, m.nim, m.nama_mahasiswa, p.judul_proposal, p.instansi_tujuan, d.tanggal_pengajuan, dos.nama_dosen as nama_penguji, dpl.nama_dosen as nama_dpl')
            ->from('hasil_desiminasi h')
            ->join('mahasiswa m', 'm.mahasiswa_id = h.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id', 'left')
            ->join('desiminasi d', 'd.desiminasi_id = h.desiminasi_id')
            ->join('dosen dos', 'dos.dosen_id = d.penguji_id', 'left')
            ->join('dosen dpl', 'dpl.dosen_id = m.dosen_dpl_id', 'left')
            ->where('h.status_kelulusan IS NOT NULL')
            ->order_by('h.tanggal_acc_laporan_akhir', 'DESC')
            ->order_by('h.hasil_id', 'DESC');
        $hasil = $this->db->get()->result();

        $data = [
            'page_title' => 'Hasil Desiminasi',
            'hasil' => $hasil
        ];

        $data['content'] = $this->load->view('dashboard/kaprodi_hasil', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }
}

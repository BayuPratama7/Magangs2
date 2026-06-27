<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penguji extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_role([6]); // role penguji
        $this->load->model(['Dosen_model', 'Desiminasi_model', 'Administrasi_model', 'Dashboard_model']);
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $dosen = $this->Dosen_model->get_by_user($user_id);

        if (!$dosen) {
            show_error('Data dosen tidak ditemukan');
        }

        // Get pending konfirmasi
        $pending_konfirmasi = $this->Desiminasi_model->get_pending_konfirmasi($dosen->dosen_id);

        // Get jadwal menguji
        $this->db->select('j.*, m.nim, m.nama_mahasiswa, p.judul_proposal')
            ->from('jadwal_desiminasi j')
            ->join('desiminasi d', 'd.desiminasi_id = j.desiminasi_id')
            ->join('mahasiswa m', 'm.mahasiswa_id = j.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id', 'left')
            ->where('d.penguji_id', $dosen->dosen_id)
            ->where('j.tanggal_desiminasi >=', date('Y-m-d'))
            ->where('j.status', 'terjadwal')
            ->order_by('j.tanggal_desiminasi', 'ASC');
        $jadwal_menguji = $this->db->get()->result();

        // Get pending laporan akhir ACC
        $this->db->select('h.*, m.nim, m.nama_mahasiswa, p.judul_proposal, j.tanggal_desiminasi')
            ->from('hasil_desiminasi h')
            ->join('desiminasi d', 'd.desiminasi_id = h.desiminasi_id')
            ->join('mahasiswa m', 'm.mahasiswa_id = h.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id', 'left')
            ->join('jadwal_desiminasi j', 'j.desiminasi_id = h.desiminasi_id', 'left')
            ->where('d.penguji_id', $dosen->dosen_id)
            ->where('h.status_laporan_akhir', 'menunggu')
            ->order_by('j.tanggal_desiminasi', 'ASC');
        $pending_laporan_akhir = $this->db->get()->result();

        // Stats
        $stats = new stdClass();
        $stats->pending_konfirmasi = count($pending_konfirmasi);
        $stats->upcoming_desiminasi = count($jadwal_menguji);
        $stats->pending_laporan_akhir = count($pending_laporan_akhir);
        $stats->total_diuji = $this->db
            ->join('desiminasi d', 'd.desiminasi_id = hasil_desiminasi.desiminasi_id')
            ->where('d.penguji_id', $dosen->dosen_id)
            ->where('hasil_desiminasi.status_kelulusan IS NOT NULL')
            ->count_all_results('hasil_desiminasi');

        $data = [
            'page_title' => 'Dashboard Penguji',
            'dosen' => $dosen,
            'pending_konfirmasi' => $pending_konfirmasi,
            'jadwal_menguji' => $jadwal_menguji,
            'pending_laporan_akhir' => $pending_laporan_akhir,
            'stats' => $stats,
            'sebaran_jenis' => $this->Dashboard_model->get_sebaran_by_jenis(),
            'tahun_akademik_list' => $this->Dashboard_model->get_tahun_akademik_list(),
            'provinsi_list' => $this->Dashboard_model->get_provinsi_list(),
            'sebaran_provinsi' => $this->Dashboard_model->get_sebaran_by_provinsi()
        ];

        $data['content'] = $this->load->view('dashboard/penguji_content', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function sebaran_filter()
    {
        if (!$this->input->is_ajax_request()) show_404();
        $mode = $this->input->get('mode') ?? 'jenis';
        if ($mode === 'provinsi') {
            $data = $this->Dashboard_model->get_sebaran_by_provinsi();
            $result = array_map(function($d) { return ['label' => $d->provinsi, 'total' => (int) $d->total]; }, $data);
        } else {
            $provinsi = $this->input->get('provinsi');
            $tahun = $this->input->get('tahun');
            $jenis = $this->input->get('jenis');
            $data = $this->Dashboard_model->get_sebaran_by_jenis_provinsi($provinsi, $tahun, $jenis);
            $result = array_map(function($d) { return ['label' => strtoupper($d->jenis_magang), 'key' => $d->jenis_magang, 'total' => (int) $d->total]; }, $data);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
}

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

        // Count mahasiswa yang sudah ACC, BUTUH surat, tapi belum ada surat
        $this->db->select('m.mahasiswa_id')
            ->from('mahasiswa m')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id')
            ->join('surat_pengantar s', 's.mahasiswa_id = m.mahasiswa_id', 'left')
            ->where('p.status_kaprodi', 'disetujui')
            ->where('p.butuh_surat_pengantar', 1)
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

        // Get sebaran jenis magang & provinsi
        $sebaran_jenis = $this->Dashboard_model->get_sebaran_by_jenis();
        $provinsi_list = $this->Dashboard_model->get_provinsi_list();
        $sebaran_provinsi = $this->Dashboard_model->get_sebaran_by_provinsi();

        $dosen_list = $this->Dosen_model->get_all_dpl();

        $data = [
            'page_title' => 'Dashboard Sekretaris',
            'pending_dpl' => $pending_dpl,
            'upcoming_jadwal' => $upcoming_jadwal,
            'stats' => $stats,
            'sebaran_jenis' => $sebaran_jenis,
            'tahun_akademik_list' => $this->Dashboard_model->get_tahun_akademik_list(),
            'provinsi_list' => $provinsi_list,
            'sebaran_provinsi' => $sebaran_provinsi,
            'dosen_list' => $dosen_list
        ];

        $data['content'] = $this->load->view('dashboard/sekretaris_content', $data, TRUE);
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

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_role([5]); // hanya mahasiswa
        $this->load->model(['Mahasiswa_model', 'Laporan_model', 'Proposal_model', 'Logbook_model']);
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $mahasiswa = $this->Mahasiswa_model->get_by_user($user_id);

        if (!$mahasiswa) {
            show_error('Data mahasiswa tidak ditemukan');
        }

        // Get all laporan
        $laporan = $this->Laporan_model->get_by_mahasiswa($mahasiswa->mahasiswa_id);

        // Check if can submit (logbook complete)
        $logbook_count = $this->Logbook_model->count_complete_logbook($mahasiswa->mahasiswa_id);
        $can_submit = $logbook_count >= 3;

        // Check if has ACC for desiminasi
        $has_acc_desiminasi = $this->Laporan_model->has_acc_desiminasi($mahasiswa->mahasiswa_id);

        $data = [
            'page_title' => 'Laporan Magang',
            'mahasiswa' => $mahasiswa,
            'laporan' => $laporan,
            'can_submit' => $can_submit,
            'has_acc_desiminasi' => $has_acc_desiminasi,
            'logbook_count' => $logbook_count
        ];

        $data['content'] = $this->load->view('laporan/index', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function store()
    {
        $user_id = $this->session->userdata('user_id');
        $mahasiswa = $this->Mahasiswa_model->get_by_user($user_id);

        if (!$mahasiswa) {
            $this->session->set_flashdata('error', 'Data mahasiswa tidak ditemukan');
            redirect('laporan');
            return;
        }

        $proposal = $this->Proposal_model->get_by_mahasiswa($mahasiswa->mahasiswa_id);

        $data = [
            'mahasiswa_id' => $mahasiswa->mahasiswa_id,
            'proposal_id' => $proposal ? $proposal->proposal_id : null,
            'jenis_laporan' => $this->input->post('jenis_laporan'),
            'link_laporan' => $this->input->post('link_laporan'),
            'link_penilaian_mitra' => $this->input->post('link_penilaian_mitra')
        ];

        if ($this->Laporan_model->insert($data)) {
            $this->session->set_flashdata('success', 'Laporan berhasil diupload');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupload laporan');
        }

        redirect('laporan');
    }
}

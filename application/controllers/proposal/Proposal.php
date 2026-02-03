<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposal extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_role([5]); // hanya mahasiswa
        $this->load->model('Proposal_model');
    }

    public function index()
    {
        $this->load->model('Mahasiswa_model');

        $user_id = $this->session->userdata('user_id');

        $mahasiswa = $this->Mahasiswa_model->get_by_user($user_id);

        if (!$mahasiswa) {
            show_error('Data mahasiswa tidak ditemukan');
        }

        $data['mahasiswa'] = $mahasiswa;
        $data['proposal'] = $this->Proposal_model
            ->get_by_mahasiswa($mahasiswa->mahasiswa_id);
        $data['page_title'] = 'Proposal Magang';
        $data['content'] = $this->load->view('proposal/index', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }


    public function store()
    {
        $this->load->model('Mahasiswa_model');

        $user_id = $this->session->userdata('user_id');
        $mahasiswa = $this->Mahasiswa_model->get_by_user($user_id);

        if (!$mahasiswa) {
            $this->session->set_flashdata('error', 'Data mahasiswa tidak ditemukan');
            redirect('proposal');
            return;
        }

        $data = [
            'mahasiswa_id' => $mahasiswa->mahasiswa_id,
            'judul_proposal' => $this->input->post('judul_proposal'),
            'instansi_tujuan' => $this->input->post('instansi_tujuan'),
            'jenis_magang' => $this->input->post('jenis_magang'),
            'tanggal_pengajuan' => $this->input->post('tanggal_pengajuan'),
            'link_proposal' => $this->input->post('link_proposal'),
            'status_koordinator' => 'menunggu',
            'status_kaprodi' => 'menunggu'
        ];

        $existing = $this->Proposal_model
            ->get_by_mahasiswa($mahasiswa->mahasiswa_id);

        if ($existing) {
            $this->session->set_flashdata('error', 'Proposal sudah pernah diajukan');
            redirect('proposal');
            return;
        }

        if ($this->Proposal_model->insert($data)) {
            $this->session->set_flashdata('success', 'Proposal berhasil diajukan');
        } else {
            $this->session->set_flashdata('error', 'Proposal gagal diajukan');
        }

        redirect('proposal');
    }


}

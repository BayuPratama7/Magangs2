<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaprodi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_role([1]); // Kaprodi
        $this->load->model('Proposal_model');
    }

    public function index()
    {
        $data['proposals'] = $this->Proposal_model->get_pending_kaprodi();
        $data['page_title'] = 'Proposal - ACC Kaprodi';
        $data['content'] = $this->load->view('proposal/kaprodi', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function acc($id)
    {
        if ($this->Proposal_model->update_status_kaprodi($id, 'disetujui')) {
            $this->session->set_flashdata('success', 'Proposal berhasil di-ACC Final');
        } else {
            $this->session->set_flashdata('error', 'Gagal ACC proposal');
        }
        redirect('proposal/kaprodi');
    }

    public function reject($id)
    {
        $catatan = $this->input->post('catatan');
        if ($this->Proposal_model->update_status_kaprodi($id, 'ditolak', $catatan)) {
            $this->session->set_flashdata('success', 'Proposal berhasil ditolak');
        } else {
            $this->session->set_flashdata('error', 'Gagal menolak proposal');
        }
        redirect('proposal/kaprodi');
    }
}

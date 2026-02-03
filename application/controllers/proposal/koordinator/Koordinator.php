<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Koordinator extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_role([2]); // role koordinator
        $this->load->model('Proposal_model');
    }

    public function index()
    {
        $data['proposals'] = $this->Proposal_model->get_pending_koordinator();
        $data['page_title'] = 'Proposal - ACC Koordinator';
        $data['content'] = $this->load->view('proposal/koordinator', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function acc($id)
    {
        $this->Proposal_model->update_status_koordinator($id, 'disetujui');
        $this->session->set_flashdata('success', 'Proposal berhasil di-ACC');
        redirect('proposal/koordinator');
    }

    public function reject($id)
    {
        $catatan = $this->input->post('catatan');
        $this->Proposal_model->update_status_koordinator($id, 'ditolak', $catatan);
        $this->session->set_flashdata('success', 'Proposal berhasil ditolak');
        redirect('proposal/koordinator');
    }

    public function detail($id)
    {
        $data['proposal'] = $this->Proposal_model->get_by_id($id);
        $data['page_title'] = 'Detail Proposal';
        $data['content'] = $this->load->view('proposal/detail', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }
}

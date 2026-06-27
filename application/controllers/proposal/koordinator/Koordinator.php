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
        $proposal = $this->Proposal_model->get_by_id($id);
        if (!$proposal) {
            $this->session->set_flashdata('error', 'Proposal tidak ditemukan');
            redirect('proposal/koordinator');
        }

        // Get Mahasiswa & DPL info
        $dpl = null;
        $mahasiswa = null;
        if ($proposal->mahasiswa_id) {
            $mahasiswa = $this->db->get_where('mahasiswa', ['mahasiswa_id' => $proposal->mahasiswa_id])->row();
            if ($mahasiswa && $mahasiswa->dosen_dpl_id) {
                $dpl = $this->db->get_where('dosen', ['dosen_id' => $mahasiswa->dosen_dpl_id])->row();
            }
        }

        $data = [
            'page_title' => 'Detail Proposal',
            'proposal' => $proposal,
            'mahasiswa' => $mahasiswa,
            'dpl' => $dpl
        ];
        
        $data['content'] = $this->load->view('admin/detail_proposal', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }
}

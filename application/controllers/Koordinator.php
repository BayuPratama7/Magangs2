<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Koordinator extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_role([2]); // role koordinator
        $this->load->model(['Proposal_model', 'Logbook_model', 'Mahasiswa_model', 'Administrasi_model']);
    }

    // Index - redirect to proposal list
    public function index()
    {
        $data['proposals'] = $this->Proposal_model->get_pending_koordinator();
        $data['page_title'] = 'Proposal - ACC Koordinator';
        $data['content'] = $this->load->view('proposal/koordinator', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    // ACC proposal
    public function acc($id)
    {
        if ($this->Proposal_model->update_status_koordinator($id, 'disetujui')) {
            $this->session->set_flashdata('success', 'Proposal berhasil di-ACC');
        } else {
            $this->session->set_flashdata('error', 'Gagal ACC proposal');
        }
        redirect('koordinator');
    }

    // Reject proposal
    public function reject($id)
    {
        $catatan = $this->input->post('catatan');
        if ($this->Proposal_model->update_status_koordinator($id, 'ditolak', $catatan)) {
            $this->session->set_flashdata('success', 'Proposal berhasil ditolak');
        } else {
            $this->session->set_flashdata('error', 'Gagal menolak proposal');
        }
        redirect('koordinator');
    }

    // Detail proposal
    public function detail($id)
    {
        $proposal = $this->Proposal_model->get_by_id($id);
        if (!$proposal) {
            $this->session->set_flashdata('error', 'Proposal tidak ditemukan');
            redirect('koordinator');
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

    // Logbook monitoring
    public function logbook()
    {
        $logbooks = $this->Logbook_model->get_all_for_koordinator();

        $data = [
            'page_title' => 'Monitoring Logbook',
            'logbooks' => $logbooks
        ];

        $data['content'] = $this->load->view('koordinator/logbook', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    // View hasil desiminasi
    public function hasil()
    {
        $this->db->select('h.*, m.nim, m.nama_mahasiswa, p.judul_proposal, p.instansi_tujuan')
            ->from('hasil_desiminasi h')
            ->join('mahasiswa m', 'm.mahasiswa_id = h.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id', 'left')
            ->where('h.status_kelulusan IS NOT NULL')
            ->order_by('h.created_at', 'DESC');
        $hasil = $this->db->get()->result();

        $data = [
            'page_title' => 'Hasil Desiminasi',
            'hasil' => $hasil
        ];

        $data['content'] = $this->load->view('koordinator/hasil', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }
}

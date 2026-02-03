<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logbook extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_role([5]); // hanya mahasiswa
        $this->load->model(['Mahasiswa_model', 'Logbook_model', 'Proposal_model']);
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $mahasiswa = $this->Mahasiswa_model->get_by_user($user_id);

        if (!$mahasiswa) {
            show_error('Data mahasiswa tidak ditemukan');
        }

        // Check if proposal approved
        $proposal = $this->Proposal_model->get_by_mahasiswa($mahasiswa->mahasiswa_id);

        // Get logbooks
        $logbooks = $this->Logbook_model->get_by_mahasiswa($mahasiswa->mahasiswa_id);

        $data = [
            'page_title' => 'Logbook Magang',
            'mahasiswa' => $mahasiswa,
            'proposal' => $proposal,
            'logbooks' => $logbooks
        ];

        $data['content'] = $this->load->view('logbook/index', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function store()
    {
        $user_id = $this->session->userdata('user_id');
        $mahasiswa = $this->Mahasiswa_model->get_by_user($user_id);

        if (!$mahasiswa) {
            $this->session->set_flashdata('error', 'Data mahasiswa tidak ditemukan');
            redirect('logbook');
            return;
        }

        $bulan_ke = $this->input->post('bulan_ke');
        $link_logbook = $this->input->post('link_logbook');

        // Check if already exists
        $existing = $this->Logbook_model->get_by_mahasiswa_bulan($mahasiswa->mahasiswa_id, $bulan_ke);

        if ($existing) {
            // Update
            $this->Logbook_model->update($existing->logbook_id, [
                'link_logbook' => $link_logbook,
                'status_dpl' => 'belum_review',
                'status_koordinator' => 'belum_review'
            ]);
            $this->session->set_flashdata('success', 'Logbook bulan ke-' . $bulan_ke . ' berhasil diupdate');
        } else {
            // Get proposal
            $proposal = $this->Proposal_model->get_by_mahasiswa($mahasiswa->mahasiswa_id);

            // Insert
            $data = [
                'mahasiswa_id' => $mahasiswa->mahasiswa_id,
                'proposal_id' => $proposal ? $proposal->proposal_id : null,
                'bulan_ke' => $bulan_ke,
                'link_logbook' => $link_logbook
            ];

            if ($this->Logbook_model->insert($data)) {
                $this->session->set_flashdata('success', 'Logbook bulan ke-' . $bulan_ke . ' berhasil disimpan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan logbook');
            }
        }

        redirect('logbook');
    }
}

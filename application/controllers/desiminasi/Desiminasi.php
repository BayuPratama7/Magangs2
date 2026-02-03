<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Desiminasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_role([5]); // hanya mahasiswa
        $this->load->model([
            'Mahasiswa_model',
            'Desiminasi_model',
            'Laporan_model',
            'Proposal_model',
            'Administrasi_model'
        ]);
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $mahasiswa = $this->Mahasiswa_model->get_by_user($user_id);

        if (!$mahasiswa) {
            show_error('Data mahasiswa tidak ditemukan');
        }

        // Get desiminasi
        $desiminasi = $this->Desiminasi_model->get_by_mahasiswa($mahasiswa->mahasiswa_id);

        // Check if can apply (has ACC desiminasi from DPL)
        $can_apply = $this->Laporan_model->has_acc_desiminasi($mahasiswa->mahasiswa_id);

        // Get hasil desiminasi
        $hasil = $this->Administrasi_model->get_hasil_by_mahasiswa($mahasiswa->mahasiswa_id);

        $data = [
            'page_title' => 'Desiminasi',
            'mahasiswa' => $mahasiswa,
            'desiminasi' => $desiminasi,
            'can_apply' => $can_apply,
            'hasil' => $hasil
        ];

        $data['content'] = $this->load->view('desiminasi/index', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function store()
    {
        $user_id = $this->session->userdata('user_id');
        $mahasiswa = $this->Mahasiswa_model->get_by_user($user_id);

        if (!$mahasiswa) {
            $this->session->set_flashdata('error', 'Data mahasiswa tidak ditemukan');
            redirect('desiminasi');
            return;
        }

        // Check if already applied
        $existing = $this->Desiminasi_model->get_by_mahasiswa($mahasiswa->mahasiswa_id);
        if ($existing) {
            $this->session->set_flashdata('error', 'Anda sudah mengajukan desiminasi');
            redirect('desiminasi');
            return;
        }

        // Get laporan yang sudah ACC
        $laporan = $this->Laporan_model->get_draft_by_mahasiswa($mahasiswa->mahasiswa_id);
        $proposal = $this->Proposal_model->get_by_mahasiswa($mahasiswa->mahasiswa_id);

        $data = [
            'mahasiswa_id' => $mahasiswa->mahasiswa_id,
            'proposal_id' => $proposal ? $proposal->proposal_id : null,
            'laporan_id' => $laporan ? $laporan->laporan_id : null,
            'status_pengajuan' => 'menunggu'
        ];

        if ($this->Desiminasi_model->insert($data)) {
            $this->session->set_flashdata('success', 'Pengajuan desiminasi berhasil');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengajukan desiminasi');
        }

        redirect('desiminasi');
    }

    public function upload_laporan_akhir()
    {
        $user_id = $this->session->userdata('user_id');
        $mahasiswa = $this->Mahasiswa_model->get_by_user($user_id);

        if (!$mahasiswa) {
            $this->session->set_flashdata('error', 'Data mahasiswa tidak ditemukan');
            redirect('desiminasi');
            return;
        }

        $desiminasi = $this->Desiminasi_model->get_by_mahasiswa($mahasiswa->mahasiswa_id);

        if (!$desiminasi) {
            $this->session->set_flashdata('error', 'Data desiminasi tidak ditemukan');
            redirect('desiminasi');
            return;
        }

        $hasil = $this->Administrasi_model->get_hasil_by_desiminasi($desiminasi->desiminasi_id);

        if ($hasil) {
            // Check if this is a revision upload
            $is_revision = ($hasil->status_laporan_akhir == 'revisi');
            
            $this->Administrasi_model->update_hasil($hasil->hasil_id, [
                'link_laporan_akhir' => $this->input->post('link_laporan_akhir'),
                'status_laporan_akhir' => $is_revision ? 'menunggu_revisi' : 'menunggu'
            ]);
            
            $flash_message = $is_revision ? 'Laporan revisi berhasil diupload' : 'Laporan akhir berhasil diupload';
        } else {
            $this->Administrasi_model->insert_hasil([
                'desiminasi_id' => $desiminasi->desiminasi_id,
                'mahasiswa_id' => $mahasiswa->mahasiswa_id,
                'link_laporan_akhir' => $this->input->post('link_laporan_akhir'),
                'status_laporan_akhir' => 'menunggu'
            ]);
            $flash_message = 'Laporan akhir berhasil diupload';
        }

        $this->session->set_flashdata('success', $flash_message);
        redirect('desiminasi');
    }
}

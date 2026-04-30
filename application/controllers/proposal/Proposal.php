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
        $this->load->model(['Mahasiswa_model', 'Administrasi_model']);

        $user_id = $this->session->userdata('user_id');

        $mahasiswa = $this->Mahasiswa_model->get_by_user($user_id);

        if (!$mahasiswa) {
            show_error('Data mahasiswa tidak ditemukan');
        }

        $proposal = $this->Proposal_model
            ->get_by_mahasiswa($mahasiswa->mahasiswa_id);

        // Get surat pengantar jika ada
        $surat = null;
        if ($proposal) {
            $surat = $this->Administrasi_model->get_surat_by_proposal($proposal->proposal_id);
        }

        // Get DPL info
        $mahasiswa_with_dpl = $this->Mahasiswa_model->get_with_dpl($mahasiswa->mahasiswa_id);

        $data['mahasiswa'] = $mahasiswa_with_dpl;
        $data['proposal'] = $proposal;
        $data['surat'] = $surat;
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
            // Allow new proposal only if mitra rejected the previous one
            if ($existing->status_mitra != 'ditolak') {
                $this->session->set_flashdata('error', 'Proposal sudah pernah diajukan');
                redirect('proposal');
                return;
            }

            // Replace old proposal with new one
            if ($this->Proposal_model->update($existing->proposal_id, $data)) {
                $this->session->set_flashdata('success', 'Proposal baru berhasil diajukan');
            } else {
                $this->session->set_flashdata('error', 'Proposal gagal diajukan');
            }
        } else {
            // Insert new proposal
            if ($this->Proposal_model->insert($data)) {
                $this->session->set_flashdata('success', 'Proposal berhasil diajukan');
            } else {
                $this->session->set_flashdata('error', 'Proposal gagal diajukan');
            }
        }

        redirect('proposal');
    }


    /**
     * Resubmit proposal yang ditolak
     */
    public function resubmit($proposal_id)
    {
        $this->load->model('Mahasiswa_model');

        $user_id = $this->session->userdata('user_id');
        $mahasiswa = $this->Mahasiswa_model->get_by_user($user_id);

        if (!$mahasiswa) {
            $this->session->set_flashdata('error', 'Data mahasiswa tidak ditemukan');
            redirect('proposal');
            return;
        }

        // Pastikan proposal ini milik mahasiswa yang login
        $proposal = $this->Proposal_model->get_by_id($proposal_id);
        if (!$proposal || $proposal->mahasiswa_id != $mahasiswa->mahasiswa_id) {
            $this->session->set_flashdata('error', 'Proposal tidak ditemukan');
            redirect('proposal');
            return;
        }

        // Pastikan proposal memang ditolak
        if ($proposal->status_koordinator != 'ditolak' && $proposal->status_kaprodi != 'ditolak') {
            $this->session->set_flashdata('error', 'Proposal tidak dalam status ditolak');
            redirect('proposal');
            return;
        }

        $data = [
            'judul_proposal' => $this->input->post('judul_proposal'),
            'instansi_tujuan' => $this->input->post('instansi_tujuan'),
            'jenis_magang' => $this->input->post('jenis_magang'),
            'tanggal_pengajuan' => date('Y-m-d'),
            'link_proposal' => $this->input->post('link_proposal'),
            'alamat_instansi' => $this->input->post('alamat_instansi'),
            'status_koordinator' => 'menunggu',
            'status_kaprodi' => 'menunggu',
            'catatan_koordinator' => null,
            'catatan_kaprodi' => null
        ];

        if ($this->Proposal_model->update($proposal_id, $data)) {
            $this->session->set_flashdata('success', 'Proposal berhasil diajukan ulang dan diarahkan ke Koordinator untuk review.');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengajukan ulang proposal');
        }

        redirect('proposal');
    }


    /**
     * Upload surat balasan penerimaan mitra
     */
    public function upload_balasan($proposal_id)
    {
        $this->load->model('Mahasiswa_model');

        $user_id = $this->session->userdata('user_id');
        $mahasiswa = $this->Mahasiswa_model->get_by_user($user_id);

        if (!$mahasiswa) {
            $this->session->set_flashdata('error', 'Data mahasiswa tidak ditemukan');
            redirect('proposal');
            return;
        }

        // Pastikan proposal ini milik mahasiswa yang login
        $proposal = $this->Proposal_model->get_by_id($proposal_id);
        if (!$proposal || $proposal->mahasiswa_id != $mahasiswa->mahasiswa_id) {
            $this->session->set_flashdata('error', 'Proposal tidak ditemukan');
            redirect('proposal');
            return;
        }

        // Pastikan proposal sudah disetujui kaprodi
        if ($proposal->status_kaprodi != 'disetujui') {
            $this->session->set_flashdata('error', 'Proposal belum disetujui oleh Kaprodi');
            redirect('proposal');
            return;
        }

        // Validasi input
        $status_mitra = $this->input->post('status_mitra');
        $link_balasan = $this->input->post('link_surat_penerimaan');

        if (!in_array($status_mitra, ['diterima', 'ditolak'])) {
            $this->session->set_flashdata('error', 'Status mitra tidak valid');
            redirect('proposal');
            return;
        }

        // CONDITIONAL: Link surat balasan hanya wajib jika status = 'diterima'
        if ($status_mitra === 'diterima' && empty($link_balasan)) {
            $this->session->set_flashdata('error', 'Link surat balasan wajib diisi jika status Diterima');
            redirect('proposal');
            return;
        }

        // Update proposal
        $data = [
            'link_surat_penerimaan' => $link_balasan,
            'status_mitra' => $status_mitra,
            'tanggal_balasan_mitra' => date('Y-m-d H:i:s')
        ];

        if ($this->Proposal_model->update($proposal_id, $data)) {
            if ($status_mitra == 'diterima') {
                $this->session->set_flashdata('success', 'Balasan mitra berhasil di-upload. DPL akan segera ditugaskan.');
            } else {
                $this->session->set_flashdata('success', 'Balasan ditolak telah dicatat. Silakan ajukan ke instansi lain.');
            }
        } else {
            $this->session->set_flashdata('error', 'Gagal upload balasan');
        }

        redirect('proposal');
    }

}

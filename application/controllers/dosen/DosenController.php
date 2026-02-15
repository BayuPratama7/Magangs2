<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DosenController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_role([4]); // role DPL
        $this->load->model(['Dosen_model', 'Mahasiswa_model', 'Logbook_model', 'Laporan_model']);
    }

    // Bimbingan - Lihat semua mahasiswa bimbingan
    public function bimbingan()
    {
        $user_id = $this->session->userdata('user_id');
        $dosen = $this->Dosen_model->get_by_user($user_id);

        $mahasiswa = $this->Dosen_model->get_mahasiswa_bimbingan($dosen->dosen_id);

        $data = [
            'page_title' => 'Mahasiswa Bimbingan',
            'mahasiswa' => $mahasiswa
        ];

        $data['content'] = $this->load->view('dosen/bimbingan', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    // Detail mahasiswa
    public function detail($mahasiswa_id)
    {
        $user_id = $this->session->userdata('user_id');
        $dosen = $this->Dosen_model->get_by_user($user_id);

        $mahasiswa = $this->Mahasiswa_model->get_by_id($mahasiswa_id);

        // Verify this is DPL's student
        if ($mahasiswa->dosen_dpl_id != $dosen->dosen_id) {
            $this->session->set_flashdata('error', 'Akses ditolak');
            redirect('dosen/bimbingan');
        }

        $logbooks = $this->Logbook_model->get_by_mahasiswa($mahasiswa_id);
        $laporan = $this->Laporan_model->get_by_mahasiswa($mahasiswa_id);

        $data = [
            'page_title' => 'Detail Mahasiswa',
            'mahasiswa' => $mahasiswa,
            'logbooks' => $logbooks,
            'laporan' => $laporan
        ];

        $data['content'] = $this->load->view('dosen/detail', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    // Logbook - Review logbook mahasiswa
    public function logbook()
    {
        $user_id = $this->session->userdata('user_id');
        $dosen = $this->Dosen_model->get_by_user($user_id);

        $logbooks = $this->Logbook_model->get_all_by_dpl($dosen->dosen_id);

        $data = [
            'page_title' => 'Review Logbook',
            'logbooks' => $logbooks
        ];

        $data['content'] = $this->load->view('dosen/logbook', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function logbook_review($logbook_id, $status)
    {
        $catatan = $this->input->post('catatan_dpl');

        $data = [
            'status_dpl' => $status,
            'catatan_dpl' => $catatan,
            'tanggal_review_dpl' => date('Y-m-d H:i:s')
        ];

        if ($this->Logbook_model->update($logbook_id, $data)) {
            $this->session->set_flashdata('success', 'Logbook berhasil direview');
        } else {
            $this->session->set_flashdata('error', 'Gagal mereview logbook');
        }

        redirect('dosen/logbook');
    }

    // Laporan - Review laporan mahasiswa
    public function laporan_list()
    {
        $user_id = $this->session->userdata('user_id');
        $dosen = $this->Dosen_model->get_by_user($user_id);

        $laporan = $this->Laporan_model->get_all_by_dpl($dosen->dosen_id);

        $data = [
            'page_title' => 'Review Laporan',
            'laporan' => $laporan
        ];

        $data['content'] = $this->load->view('dosen/laporan', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function laporan_acc($laporan_id)
    {
        $catatan = $this->input->post('catatan_dpl');

        $data = [
            'status_dpl' => 'disetujui',
            'catatan_dpl' => $catatan,
            'tanggal_review_dpl' => date('Y-m-d H:i:s'),
            'is_acc_desiminasi' => true // otomatis ACC desiminasi saat laporan disetujui
        ];

        if ($this->Laporan_model->update($laporan_id, $data)) {
            $this->session->set_flashdata('success', 'Laporan berhasil di-ACC dan siap desiminasi');
        } else {
            $this->session->set_flashdata('error', 'Gagal ACC laporan');
        }

        redirect('dosen/laporan');
    }

    public function laporan_revisi($laporan_id)
    {
        $catatan = $this->input->post('catatan_dpl');

        $data = [
            'status_dpl' => 'revisi',
            'catatan_dpl' => $catatan,
            'tanggal_review_dpl' => date('Y-m-d H:i:s')
        ];

        if ($this->Laporan_model->update($laporan_id, $data)) {
            $this->session->set_flashdata('success', 'Laporan dikembalikan untuk revisi');
        } else {
            $this->session->set_flashdata('error', 'Gagal memproses laporan');
        }

        redirect('dosen/laporan');
    }

    // Jadwal desiminasi mahasiswa bimbingan
    public function jadwal()
    {
        $user_id = $this->session->userdata('user_id');
        $dosen = $this->Dosen_model->get_by_user($user_id);

        // Get jadwal desiminasi for bimbingan students with hasil status
        $this->db->select('j.*, m.nim, m.nama_mahasiswa, p.judul_proposal, h.status_kelulusan, h.status_laporan_akhir, h.link_laporan_akhir, h.tanggal_acc_laporan_akhir')
            ->from('jadwal_desiminasi j')
            ->join('mahasiswa m', 'm.mahasiswa_id = j.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id', 'left')
            ->join('desiminasi d', 'd.mahasiswa_id = m.mahasiswa_id', 'left')
            ->join('hasil_desiminasi h', 'h.desiminasi_id = d.desiminasi_id', 'left')
            ->where('m.dosen_dpl_id', $dosen->dosen_id)
            ->order_by('j.tanggal_desiminasi', 'ASC');
        $jadwal = $this->db->get()->result();

        $data = [
            'page_title' => 'Jadwal Desiminasi',
            'jadwal' => $jadwal
        ];

        $data['content'] = $this->load->view('dosen/jadwal', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }
}

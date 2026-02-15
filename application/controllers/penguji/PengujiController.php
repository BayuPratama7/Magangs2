<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PengujiController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_role([6]); // role penguji
        $this->load->model(['Dosen_model', 'Desiminasi_model', 'Administrasi_model']);
    }

    // Konfirmasi kesediaan menguji
    public function konfirmasi()
    {
        $user_id = $this->session->userdata('user_id');
        $dosen = $this->Dosen_model->get_by_user($user_id);

        $pending = $this->Desiminasi_model->get_pending_konfirmasi($dosen->dosen_id);

        $data = [
            'page_title' => 'Konfirmasi Menguji',
            'pending' => $pending
        ];

        $data['content'] = $this->load->view('penguji/konfirmasi', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function konfirmasi_terima($desiminasi_id)
    {
        if ($this->Desiminasi_model->konfirmasi_penguji($desiminasi_id, 'bersedia')) {
            $this->session->set_flashdata('success', 'Berhasil menyatakan bersedia menguji');
        } else {
            $this->session->set_flashdata('error', 'Gagal memproses konfirmasi');
        }

        redirect('penguji/konfirmasi');
    }

    public function konfirmasi_tolak($desiminasi_id)
    {
        if ($this->Desiminasi_model->konfirmasi_penguji($desiminasi_id, 'tidak_bersedia')) {
            // Reset penguji assignment
            $this->Desiminasi_model->update($desiminasi_id, ['penguji_id' => null]);
            $this->session->set_flashdata('info', 'Penugasan dikembalikan ke sekretaris');
        } else {
            $this->session->set_flashdata('error', 'Gagal memproses konfirmasi');
        }

        redirect('penguji/konfirmasi');
    }

    // Jadwal menguji
    public function jadwal()
    {
        $user_id = $this->session->userdata('user_id');
        $dosen = $this->Dosen_model->get_by_user($user_id);

        $this->db->select('j.*, m.nim, m.nama_mahasiswa, p.judul_proposal')
            ->from('jadwal_desiminasi j')
            ->join('desiminasi d', 'd.desiminasi_id = j.desiminasi_id')
            ->join('mahasiswa m', 'm.mahasiswa_id = j.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id', 'left')
            ->where('d.penguji_id', $dosen->dosen_id)
            ->order_by('j.tanggal_desiminasi', 'ASC');
        $jadwal = $this->db->get()->result();

        $data = [
            'page_title' => 'Jadwal Menguji',
            'jadwal' => $jadwal
        ];

        $data['content'] = $this->load->view('penguji/jadwal', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    // Input hasil desiminasi
    public function input_hasil($desiminasi_id)
    {
        $desiminasi = $this->Desiminasi_model->get_detail($desiminasi_id);

        if (!$desiminasi) {
            $this->session->set_flashdata('error', 'Data desiminasi tidak ditemukan');
            redirect('penguji/jadwal');
        }

        $hasil = $this->Administrasi_model->get_hasil_by_desiminasi($desiminasi_id);

        // Jika record hasil belum ada, buat otomatis
        if (!$hasil) {
            $this->Administrasi_model->insert_hasil([
                'desiminasi_id' => $desiminasi_id,
                'mahasiswa_id' => $desiminasi->mahasiswa_id
            ]);
            $hasil = $this->Administrasi_model->get_hasil_by_desiminasi($desiminasi_id);
        }

        $data = [
            'page_title' => 'Input Hasil Desiminasi',
            'hasil' => $hasil,
            'desiminasi' => $desiminasi
        ];

        $data['content'] = $this->load->view('penguji/input_hasil', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function simpan_hasil($hasil_id)
    {
        $data = [
            'nilai' => $this->input->post('nilai'),
            'status_kelulusan' => $this->input->post('status_kelulusan'),
            'catatan_revisi' => $this->input->post('catatan_revisi')
        ];

        if ($this->Administrasi_model->update_hasil($hasil_id, $data)) {
            $this->session->set_flashdata('success', 'Hasil desiminasi berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan hasil');
        }

        redirect('penguji/jadwal');
    }

    // Index laporan akhir
    public function laporan()
    {
        $user_id = $this->session->userdata('user_id');
        $dosen = $this->Dosen_model->get_by_user($user_id);

        $this->db->select('h.*, m.nim, m.nama_mahasiswa, p.judul_proposal')
            ->from('hasil_desiminasi h')
            ->join('desiminasi d', 'd.desiminasi_id = h.desiminasi_id')
            ->join('mahasiswa m', 'm.mahasiswa_id = h.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id', 'left')
            ->where('d.penguji_id', $dosen->dosen_id)
            ->where('h.status_kelulusan IS NOT NULL')
            ->order_by('h.created_at', 'DESC');
        $laporan = $this->db->get()->result();

        $data = [
            'page_title' => 'Laporan Akhir Mahasiswa',
            'laporan' => $laporan
        ];

        $data['content'] = $this->load->view('penguji/laporan', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function laporan_acc($hasil_id)
    {
        $data = [
            'status_laporan_akhir' => 'disetujui',
            'tanggal_acc_laporan_akhir' => date('Y-m-d H:i:s')
        ];

        if ($this->Administrasi_model->update_hasil($hasil_id, $data)) {
            $this->session->set_flashdata('success', 'Laporan akhir berhasil di-ACC');
        } else {
            $this->session->set_flashdata('error', 'Gagal ACC laporan');
        }

        redirect('penguji/laporan');
    }

    public function laporan_revisi($hasil_id)
    {
        $catatan = $this->input->post('catatan_revisi');

        $data = [
            'status_laporan_akhir' => 'revisi',
            'catatan_penguji' => $catatan
        ];

        if ($this->Administrasi_model->update_hasil($hasil_id, $data)) {
            $this->session->set_flashdata('success', 'Laporan dikembalikan untuk revisi');
        } else {
            $this->session->set_flashdata('error', 'Gagal memproses');
        }

        redirect('penguji/laporan');
    }
}

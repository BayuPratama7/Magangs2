<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sekretaris Desiminasi Controller
 * Mengelola proses pengajuan desiminasi mahasiswa
 */
class Desiminasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_role([3]); // role sekretaris
        $this->load->model([
            'Desiminasi_model',
            'Jadwal_model',
            'Dosen_model',
            'Mahasiswa_model'
        ]);
    }

    /**
     * Daftar pengajuan desiminasi pending
     */
    public function index()
    {
        $pending = $this->Desiminasi_model->get_all_pending();

        $data = [
            'page_title' => 'Pengajuan Desiminasi',
            'pending' => $pending
        ];

        $data['content'] = $this->load->view('sekretaris/desiminasi_index', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    /**
     * Form proses desiminasi - input jadwal + assign penguji
     */
    public function proses($desiminasi_id)
    {
        $desiminasi = $this->Desiminasi_model->get_detail($desiminasi_id);

        if (!$desiminasi) {
            $this->session->set_flashdata('error', 'Data desiminasi tidak ditemukan');
            redirect('sekretaris/desiminasi');
        }

        // Get daftar penguji (dosen dengan is_penguji = true)
        $penguji_list = $this->Dosen_model->get_all_penguji();

        $data = [
            'page_title' => 'Proses Desiminasi',
            'desiminasi' => $desiminasi,
            'penguji_list' => $penguji_list
        ];

        $data['content'] = $this->load->view('sekretaris/desiminasi_proses', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    /**
     * Simpan jadwal + assign penguji
     */
    public function simpan()
    {
        $desiminasi_id = $this->input->post('desiminasi_id');
        $penguji_id = $this->input->post('penguji_id');
        $tanggal = $this->input->post('tanggal_desiminasi');
        $waktu_mulai = $this->input->post('waktu_mulai');
        $waktu_selesai = $this->input->post('waktu_selesai');
        $ruangan = $this->input->post('ruangan');
        $link_online = $this->input->post('link_online');

        // Validasi
        if (!$desiminasi_id || !$penguji_id || !$tanggal || !$waktu_mulai) {
            $this->session->set_flashdata('error', 'Semua field wajib harus diisi');
            redirect('sekretaris/desiminasi/proses/' . $desiminasi_id);
        }

        $this->db->trans_start();

        // Get desiminasi detail untuk mahasiswa_id
        $desiminasi = $this->Desiminasi_model->get_by_id($desiminasi_id);

        // 1. Update desiminasi - assign penguji
        $this->Desiminasi_model->update($desiminasi_id, [
            'penguji_id' => $penguji_id,
            'status_pengajuan' => 'diterima'
        ]);

        // 2. Insert jadwal desiminasi
        $jadwal_data = [
            'desiminasi_id' => $desiminasi_id,
            'mahasiswa_id' => $desiminasi->mahasiswa_id,
            'tanggal_desiminasi' => $tanggal,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
            'ruangan' => $ruangan,
            'link_online' => $link_online,
            'status' => 'menunggu_konfirmasi'
        ];
        $this->Jadwal_model->insert($jadwal_data);

        // 3. Buat record hasil_desiminasi agar penguji bisa input hasil & mahasiswa bisa upload laporan
        $this->load->model('Administrasi_model');
        $existing_hasil = $this->Administrasi_model->get_hasil_by_desiminasi($desiminasi_id);
        if (!$existing_hasil) {
            $this->Administrasi_model->insert_hasil([
                'desiminasi_id' => $desiminasi_id,
                'mahasiswa_id' => $desiminasi->mahasiswa_id
            ]);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->session->set_flashdata('success', 'Jadwal dan penguji berhasil disimpan. Menunggu konfirmasi penguji.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data');
        }

        redirect('sekretaris/desiminasi');
    }

    /**
     * Tolak pengajuan desiminasi
     */
    public function tolak($desiminasi_id)
    {
        $catatan = $this->input->post('catatan');

        $this->Desiminasi_model->update($desiminasi_id, [
            'status_pengajuan' => 'ditolak',
            'catatan_sekretaris' => $catatan
        ]);

        $this->session->set_flashdata('info', 'Pengajuan desiminasi ditolak');
        redirect('sekretaris/desiminasi');
    }

    /**
     * Lihat hasil desiminasi yang sudah selesai (ACC penguji)
     */
    public function hasil()
    {
        $this->load->model('Administrasi_model');

        // Get hasil desiminasi yang sudah ACC penguji
        $this->db->select('h.*, m.nim, m.nama_mahasiswa, p.judul_proposal, p.instansi_tujuan, d.tanggal_pengajuan, dos.nama_dosen as nama_penguji')
            ->from('hasil_desiminasi h')
            ->join('mahasiswa m', 'm.mahasiswa_id = h.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id', 'left')
            ->join('desiminasi d', 'd.desiminasi_id = h.desiminasi_id')
            ->join('dosen dos', 'dos.dosen_id = d.penguji_id', 'left')
            ->where('h.status_kelulusan IS NOT NULL')
            ->order_by('h.tanggal_acc_laporan_akhir', 'DESC')
            ->order_by('h.hasil_id', 'DESC');
        $hasil = $this->db->get()->result();

        $data = [
            'page_title' => 'Hasil Desiminasi',
            'hasil' => $hasil
        ];

        $data['content'] = $this->load->view('sekretaris/desiminasi_hasil', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_role([3]); // hanya sekretaris
        $this->load->model([
            'Administrasi_model',
            'Dosen_model',
            'Mahasiswa_model',
            'Desiminasi_model',
            'Dashboard_model',
            'Proposal_model'
        ]);
    }

    // ==========================================
    // PENUGASAN DPL
    // ==========================================

    public function dpl()
    {
        $pending = $this->Administrasi_model->get_mahasiswa_tanpa_dpl();
        $assigned = $this->Administrasi_model->get_mahasiswa_dengan_dpl();
        $dosen_list = $this->Dosen_model->get_all_dpl();

        $data = [
            'page_title' => 'Penugasan DPL',
            'pending' => $pending,
            'assigned' => $assigned,
            'dosen_list' => $dosen_list
        ];

        $data['content'] = $this->load->view('admin/dpl', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function assign_dpl()
    {
        $mahasiswa_id = $this->input->post('mahasiswa_id');
        $dosen_id = $this->input->post('dosen_id');

        if ($this->Administrasi_model->assign_dpl($mahasiswa_id, $dosen_id)) {
            // Update status mahasiswa
            $this->Mahasiswa_model->update_status($mahasiswa_id, 'diterima');
            $this->session->set_flashdata('success', 'DPL berhasil ditugaskan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menugaskan DPL');
        }

        redirect('admin/dpl');
    }

    // ==========================================
    // SURAT PENGANTAR
    // ==========================================

    public function surat()
    {
        // Get mahasiswa yang belum ada surat
        $this->db->select('m.*, p.proposal_id, p.instansi_tujuan, p.alamat_instansi')
            ->from('mahasiswa m')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id')
            ->join('surat_pengantar s', 's.mahasiswa_id = m.mahasiswa_id', 'left')
            ->where('p.status_kaprodi', 'disetujui')
            ->where('s.surat_id IS NULL');
        $pending = $this->db->get()->result();

        $surat_list = $this->Administrasi_model->get_all_surat();

        $data = [
            'page_title' => 'Surat Pengantar',
            'pending' => $pending,
            'surat_list' => $surat_list
        ];

        $data['content'] = $this->load->view('admin/surat', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function create_surat()
    {
        $user_id = $this->session->userdata('user_id');

        $data = [
            'proposal_id' => $this->input->post('proposal_id'),
            'mahasiswa_id' => $this->input->post('mahasiswa_id'),
            'nomor_surat' => $this->input->post('nomor_surat'),
            'tanggal_surat' => $this->input->post('tanggal_surat'),
            'perihal' => $this->input->post('perihal'),
            'tujuan_instansi' => $this->input->post('tujuan_instansi'),
            'file_surat' => $this->input->post('file_surat'),
            'created_by' => $user_id
        ];

        if ($this->Administrasi_model->insert_surat($data)) {
            $this->session->set_flashdata('success', 'Surat pengantar berhasil dibuat');
        } else {
            $this->session->set_flashdata('error', 'Gagal membuat surat pengantar');
        }

        redirect('admin/surat');
    }

    // ==========================================
    // PENUGASAN PENGUJI
    // ==========================================

    public function penguji()
    {
        $pending = $this->Desiminasi_model->get_all_pending();
        $penguji_list = $this->Dosen_model->get_all_penguji();

        $data = [
            'page_title' => 'Penugasan Penguji Desiminasi',
            'pending' => $pending,
            'penguji_list' => $penguji_list
        ];

        $data['content'] = $this->load->view('admin/penguji', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function assign_penguji()
    {
        $desiminasi_id = $this->input->post('desiminasi_id');
        $penguji_id = $this->input->post('penguji_id');

        if ($this->Desiminasi_model->assign_penguji($desiminasi_id, $penguji_id)) {
            $this->session->set_flashdata('success', 'Penguji berhasil ditugaskan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menugaskan penguji');
        }

        redirect('admin/penguji');
    }

    // ==========================================
    // JADWAL DESIMINASI
    // ==========================================

    public function jadwal()
    {
        // Get desiminasi yang sudah bersedia tapi belum dijadwalkan
        $this->db->select('d.*, m.mahasiswa_id, m.nim, m.nama_mahasiswa, ds.nama_dosen as nama_penguji, p.judul_proposal')
            ->from('desiminasi d')
            ->join('mahasiswa m', 'm.mahasiswa_id = d.mahasiswa_id')
            ->join('dosen ds', 'ds.dosen_id = d.penguji_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = d.mahasiswa_id', 'left')
            ->join('jadwal_desiminasi j', 'j.desiminasi_id = d.desiminasi_id', 'left')
            ->where('d.konfirmasi_penguji', 'bersedia')
            ->where('j.jadwal_id IS NULL');
        $pending = $this->db->get()->result();

        $jadwal_list = $this->Administrasi_model->get_all_jadwal();

        $data = [
            'page_title' => 'Jadwal Desiminasi',
            'pending' => $pending,
            'jadwal_list' => $jadwal_list
        ];

        $data['content'] = $this->load->view('admin/jadwal', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function create_jadwal()
    {
        $user_id = $this->session->userdata('user_id');

        $desiminasi_id = $this->input->post('desiminasi_id');

        // Get desiminasi info
        $desiminasi = $this->Desiminasi_model->get_by_id($desiminasi_id);

        $data = [
            'desiminasi_id' => $desiminasi_id,
            'mahasiswa_id' => $desiminasi->mahasiswa_id,
            'tanggal_desiminasi' => $this->input->post('tanggal_desiminasi'),
            'waktu_mulai' => $this->input->post('waktu_mulai'),
            'waktu_selesai' => $this->input->post('waktu_selesai'),
            'ruangan' => $this->input->post('ruangan'),
            'link_online' => $this->input->post('link_online'),
            'created_by' => $user_id
        ];

        if ($this->Administrasi_model->insert_jadwal($data)) {
            // Create hasil desiminasi record
            $this->Administrasi_model->insert_hasil([
                'desiminasi_id' => $desiminasi_id,
                'mahasiswa_id' => $desiminasi->mahasiswa_id
            ]);

            $this->session->set_flashdata('success', 'Jadwal desiminasi berhasil dibuat');
        } else {
            $this->session->set_flashdata('error', 'Gagal membuat jadwal');
        }

        redirect('admin/jadwal');
    }

    // ==========================================
    // MITRA KERJASAMA
    // ==========================================

    public function mitra()
    {
        $mitra_list = $this->Dashboard_model->get_all_mitra();

        $data = [
            'page_title' => 'Kelola Mitra Kerjasama',
            'mitra_list' => $mitra_list
        ];

        $data['content'] = $this->load->view('admin/mitra', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function create_mitra()
    {
        $user_id = $this->session->userdata('user_id');

        $data = [
            'nama_mitra' => $this->input->post('nama_mitra'),
            'jenis_mitra' => $this->input->post('jenis_mitra'),
            'alamat' => $this->input->post('alamat'),
            'kota' => $this->input->post('kota'),
            'provinsi' => $this->input->post('provinsi'),
            'website' => $this->input->post('website'),
            'email_kontak' => $this->input->post('email_kontak'),
            'no_telp' => $this->input->post('no_telp'),
            'deskripsi' => $this->input->post('deskripsi'),
            'created_by' => $user_id
        ];

        if ($this->Dashboard_model->insert_mitra($data)) {
            $this->session->set_flashdata('success', 'Mitra berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan mitra');
        }

        redirect('admin/mitra');
    }

    public function delete_mitra($id)
    {
        if ($this->Dashboard_model->delete_mitra($id)) {
            $this->session->set_flashdata('success', 'Mitra berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus mitra');
        }

        redirect('admin/mitra');
    }

    // ==========================================
    // SEBARAN MAGANG
    // ==========================================

    public function sebaran()
    {
        $sebaran_list = $this->Dashboard_model->get_all_sebaran();
        $periode_list = $this->Dashboard_model->get_available_periode();

        $data = [
            'page_title' => 'Kelola Sebaran Magang',
            'sebaran_list' => $sebaran_list,
            'periode_list' => $periode_list
        ];

        $data['content'] = $this->load->view('admin/sebaran', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function create_sebaran()
    {
        $user_id = $this->session->userdata('user_id');

        $data = [
            'periode' => $this->input->post('periode'),
            'tahun_akademik' => $this->input->post('tahun_akademik'),
            'semester' => $this->input->post('semester'),
            'wilayah' => $this->input->post('wilayah'),
            'provinsi' => $this->input->post('provinsi'),
            'jenis_magang' => $this->input->post('jenis_magang'),
            'jumlah_mahasiswa' => $this->input->post('jumlah_mahasiswa'),
            'nama_instansi' => $this->input->post('nama_instansi'),
            'created_by' => $user_id
        ];

        if ($this->Dashboard_model->insert_sebaran($data)) {
            $this->session->set_flashdata('success', 'Data sebaran berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan data sebaran');
        }

        redirect('admin/sebaran');
    }

    public function delete_sebaran($id)
    {
        if ($this->Dashboard_model->delete_sebaran($id)) {
            $this->session->set_flashdata('success', 'Data sebaran berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data');
        }

        redirect('admin/sebaran');
    }
}

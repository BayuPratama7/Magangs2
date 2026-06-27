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
    // DATA MAHASISWA
    // ==========================================

    public function mahasiswa()
    {
        $this->load->model('User_model');
        $mahasiswa_list = $this->Mahasiswa_model->get_all_with_proposal();

        $data = [
            'page_title' => 'Data Mahasiswa',
            'mahasiswa_list' => $mahasiswa_list
        ];

        $data['content'] = $this->load->view('admin/mahasiswa', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function mahasiswa_store()
    {
        $this->load->model('User_model');

        // Cek NIM sudah ada
        $existing = $this->Mahasiswa_model->get_by_nim($this->input->post('nim'));
        if ($existing) {
            $this->session->set_flashdata('error', 'NIM sudah terdaftar dalam sistem');
            redirect('admin/mahasiswa');
            return;
        }

        // Cek email sudah ada
        $email = $this->input->post('email');
        $email_exists = $this->db->get_where('users', ['email' => $email])->row();
        if ($email_exists) {
            $this->session->set_flashdata('error', 'Email sudah terdaftar dalam sistem');
            redirect('admin/mahasiswa');
            return;
        }

        // Buat user account dulu
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

        $user_data = [
            'email' => $email,
            'password' => $password,
            'nama_lengkap' => $this->input->post('nama_mahasiswa'),
            'role_id' => 5, // Mahasiswa
            'is_active' => TRUE,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('users', $user_data);
        $user_id = $this->db->insert_id();

        if (!$user_id) {
            $this->session->set_flashdata('error', 'Gagal membuat akun user');
            redirect('admin/mahasiswa');
            return;
        }

        // Insert ke user_roles agar bisa login
        $this->db->insert('user_roles', [
            'user_id' => $user_id,
            'role_id' => 5, // Mahasiswa
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Buat data mahasiswa
        $mhs_data = [
            'user_id' => $user_id,
            'nim' => $this->input->post('nim'),
            'nama_mahasiswa' => $this->input->post('nama_mahasiswa'),
            'prodi' => $this->input->post('prodi') ?: 'Sistem Informasi',
            'angkatan' => $this->input->post('angkatan'),
            'kelas' => $this->input->post('kelas'),
            'no_hp' => $this->input->post('no_hp'),
            'alamat' => $this->input->post('alamat'),
            'status_magang' => 'belum_magang',
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->Mahasiswa_model->insert($mhs_data)) {
            $this->session->set_flashdata('success', 'Data mahasiswa berhasil ditambahkan');
        } else {
            // Rollback user jika gagal insert mahasiswa
            $this->db->where('user_id', $user_id)->delete('users');
            $this->session->set_flashdata('error', 'Gagal menambahkan data mahasiswa');
        }

        redirect('admin/mahasiswa');
    }

    public function mahasiswa_update($id)
    {
        $mahasiswa = $this->Mahasiswa_model->get_by_id($id);
        if (!$mahasiswa) {
            $this->session->set_flashdata('error', 'Data mahasiswa tidak ditemukan');
            redirect('admin/mahasiswa');
            return;
        }

        $mhs_data = [
            'nim' => $this->input->post('nim'),
            'nama_mahasiswa' => $this->input->post('nama_mahasiswa'),
            'prodi' => $this->input->post('prodi'),
            'angkatan' => $this->input->post('angkatan'),
            'alamat' => $this->input->post('alamat'),
            'status_magang' => $this->input->post('status_magang')
        ];

        if ($this->Mahasiswa_model->update($id, $mhs_data)) {
            // Update juga nama di tabel users
            $this->db->where('user_id', $mahasiswa->user_id)
                     ->update('users', [
                         'nama_lengkap' => $this->input->post('nama_mahasiswa'),
                         'updated_at' => date('Y-m-d H:i:s')
                     ]);
            $this->session->set_flashdata('success', 'Data mahasiswa berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data mahasiswa');
        }

        redirect('admin/mahasiswa');
    }

    public function mahasiswa_delete($id)
    {
        $mahasiswa = $this->Mahasiswa_model->get_by_id($id);
        if (!$mahasiswa) {
            $this->session->set_flashdata('error', 'Data mahasiswa tidak ditemukan');
            redirect('admin/mahasiswa');
            return;
        }

        // Hapus semua data terkait mahasiswa (foreign key dependencies)
        $this->db->trans_start();

        $this->db->where('mahasiswa_id', $id)->delete('hasil_desiminasi');
        $this->db->where('mahasiswa_id', $id)->delete('jadwal_desiminasi');
        $this->db->where('mahasiswa_id', $id)->delete('desiminasi');
        $this->db->where('mahasiswa_id', $id)->delete('laporan_magang');
        $this->db->where('mahasiswa_id', $id)->delete('logbook_magang');
        $this->db->where('mahasiswa_id', $id)->delete('surat_pengantar');
        $this->db->where('mahasiswa_id', $id)->delete('proposal_magang');

        // Hapus data mahasiswa
        $this->Mahasiswa_model->delete($id);

        // Hapus user_roles dan user account
        $this->db->where('user_id', $mahasiswa->user_id)->delete('user_roles');
        $this->db->where('user_id', $mahasiswa->user_id)->delete('users');

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->session->set_flashdata('success', 'Data mahasiswa dan semua data terkait berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data mahasiswa');
        }

        redirect('admin/mahasiswa');
    }

    // ==========================================
    // PENUGASAN DPL
    // ==========================================

    public function dpl()
    {
        $pending = $this->Administrasi_model->get_mahasiswa_tanpa_dpl();
        $assigned = $this->Administrasi_model->get_mahasiswa_dengan_dpl();
        $dosen_list = $this->Dosen_model->get_all_dpl();

        // Get mahasiswa dengan balasan mitra yang sudah di-upload
        $balasan_list = $this->db
            ->select('m.*, p.instansi_tujuan, p.link_surat_penerimaan, p.status_mitra, p.tanggal_balasan_mitra')
            ->from('mahasiswa m')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id', 'left')
            ->where('p.link_surat_penerimaan IS NOT NULL')
            ->order_by('p.tanggal_balasan_mitra', 'DESC')
            ->get()
            ->result();

        $data = [
            'page_title' => 'Penugasan DPL',
            'pending' => $pending,
            'assigned' => $assigned,
            'dosen_list' => $dosen_list,
            'balasan_list' => $balasan_list
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
            $this->Mahasiswa_model->update_status($mahasiswa_id, 'sedang_magang');
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
        // Get mahasiswa yang belum ada surat dan BUTUH surat pengantar
        $this->db->select('m.*, p.proposal_id, p.instansi_tujuan, p.alamat_instansi, p.jenis_magang')
            ->from('mahasiswa m')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id')
            ->join('surat_pengantar s', 's.mahasiswa_id = m.mahasiswa_id', 'left')
            ->where('p.status_kaprodi', 'disetujui')
            ->where('p.butuh_surat_pengantar', 1)
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

    public function detail_proposal($id = null)
    {
        if (!$id) {
            die("Error: Proposal ID is missing from the URL.");
        }
        $proposal = $this->Proposal_model->get_by_id($id);
        if (!$proposal) {
            die("Proposal not found for ID: " . $id);
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
        $selected_tahun = $this->input->get('tahun_akademik');
        $selected_jenis = $this->input->get('jenis_magang');
        $sebaran_list = $this->Dashboard_model->get_all_sebaran($selected_tahun, $selected_jenis);
        $tahun_akademik_list = $this->Dashboard_model->get_available_tahun_akademik();
        $provinsi_list = $this->db->get('provinsi')->result();

        $data = [
            'page_title' => 'Kelola Sebaran Magang',
            'sebaran_list' => $sebaran_list,
            'tahun_akademik_list' => $tahun_akademik_list,
            'provinsi_list' => $provinsi_list,
            'selected_tahun' => $selected_tahun,
            'selected_jenis' => $selected_jenis
        ];

        $data['content'] = $this->load->view('admin/sebaran', $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function create_sebaran()
    {
        $user_id = $this->session->userdata('user_id');

        $data = [
            'periode' => $this->input->post('tahun_akademik'), // Using tahun_akademik as periode fallback
            'tahun_akademik' => $this->input->post('tahun_akademik'),
            'semester' => $this->input->post('semester'),
            'wilayah' => '-',
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

    public function edit_sebaran($id)
    {
        $data = [
            'tahun_akademik' => $this->input->post('tahun_akademik'),
            'provinsi' => $this->input->post('provinsi'),
            'jenis_magang' => $this->input->post('jenis_magang'),
            'jumlah_mahasiswa' => $this->input->post('jumlah_mahasiswa'),
            'nama_instansi' => $this->input->post('nama_instansi')
        ];

        if ($id == 0) {
            // Override dynamic data: insert it into sebaran_magang
            $data['semester'] = 'ganjil'; // Default value since it's removed from view
            $data['wilayah'] = '-';
            $data['created_by'] = $this->session->userdata('user_id');
            
            if ($this->Dashboard_model->insert_sebaran($data)) {
                $this->session->set_flashdata('success', 'Data berhasil diperbarui dan disimpan sebagai data manual');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data sebaran');
            }
        } else {
            if ($this->Dashboard_model->update_sebaran($id, $data)) {
                $this->session->set_flashdata('success', 'Data sebaran berhasil diperbarui');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data sebaran');
            }
        }

        redirect('admin/sebaran');
    }

    public function delete_sebaran($id)
    {
        if ($id == 0) {
            $this->session->set_flashdata('error', 'Data otomatis dari mahasiswa tidak dapat dihapus secara manual. Hapus proposal terkait jika ingin mengubah angkanya.');
            redirect('admin/sebaran');
            return;
        }

        if ($this->Dashboard_model->delete_sebaran($id)) {
            $this->session->set_flashdata('success', 'Data sebaran berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data');
        }

        redirect('admin/sebaran');
    }
}

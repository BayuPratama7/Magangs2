<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login()
    {
        $this->load->view('auth/login');
    }

    public function process()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->User_model->get_by_email($email);

        if ($user && password_verify($password, $user->password)) {

            // Get nama_lengkap based on role
            $nama_lengkap = 'User';
            $role_nama = '';

            switch ((int) $user->role_id) {
                case 1:
                    $role_nama = 'Kaprodi';
                    $this->db->where('user_id', $user->user_id);
                    $dosen = $this->db->get('dosen')->row();
                    if ($dosen)
                        $nama_lengkap = $dosen->nama_dosen;
                    break;
                case 2:
                    $role_nama = 'Koordinator';
                    $this->db->where('user_id', $user->user_id);
                    $dosen = $this->db->get('dosen')->row();
                    if ($dosen)
                        $nama_lengkap = $dosen->nama_dosen;
                    break;
                case 3:
                    $role_nama = 'Sekretaris';
                    $nama_lengkap = 'Sekretaris';
                    break;
                case 4:
                    $role_nama = 'Dosen Pembimbing';
                    $this->db->where('user_id', $user->user_id);
                    $dosen = $this->db->get('dosen')->row();
                    if ($dosen)
                        $nama_lengkap = $dosen->nama_dosen;
                    break;
                case 5:
                    $role_nama = 'Mahasiswa';
                    $this->db->where('user_id', $user->user_id);
                    $mahasiswa = $this->db->get('mahasiswa')->row();
                    if ($mahasiswa)
                        $nama_lengkap = $mahasiswa->nama_mahasiswa;
                    break;
                case 6:
                    $role_nama = 'Penguji';
                    $this->db->where('user_id', $user->user_id);
                    $dosen = $this->db->get('dosen')->row();
                    if ($dosen)
                        $nama_lengkap = $dosen->nama_dosen;
                    break;
            }

            $this->session->set_userdata([
                'user_id' => $user->user_id,
                'role_id' => (int) $user->role_id,
                'nama_lengkap' => $nama_lengkap,
                'role_nama' => $role_nama,
                'logged_in' => TRUE
            ]);

            // 🔥 REDIRECT OTOMATIS SESUAI ROLE
            switch ((int) $user->role_id) {
                case 1:
                    redirect('dashboard/kaprodi');
                    break;
                case 2:
                    redirect('dashboard/koordinator');
                    break;
                case 3:
                    redirect('dashboard/sekretaris');
                    break;
                case 4:
                    redirect('dashboard/dosen');
                    break;
                case 5:
                    redirect('dashboard/mahasiswa');
                    break;
                case 6:
                    redirect('dashboard/penguji');
                    break;
                default:
                    redirect('auth/login');
            }

        } else {
            $this->session->set_flashdata('error', 'Login gagal');
            redirect('auth/login');
        }
    }



    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}

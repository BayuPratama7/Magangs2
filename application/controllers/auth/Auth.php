<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{

    /**
     * Prioritas role untuk menentukan active_role default
     * Urutan: sekretaris > koordinator > kaprodi > mahasiswa > dosen > penguji
     */
    private $role_priority = [
        'sekretaris',
        'koordinator',
        'kaprodi',
        'mahasiswa',
        'dosen',
        'penguji',
    ];

    /**
     * Mapping role name → label display
     */
    private $role_label_map = [
        'kaprodi' => 'Kaprodi',
        'koordinator' => 'Koordinator',
        'sekretaris' => 'Sekretaris',
        'dosen' => 'Dosen Pembimbing',
        'mahasiswa' => 'Mahasiswa',
        'penguji' => 'Penguji',
    ];

    /**
     * Mapping role name → dashboard redirect URL
     */
    private $role_dashboard_map = [
        'kaprodi' => 'dashboard/kaprodi',
        'koordinator' => 'dashboard/koordinator',
        'sekretaris' => 'dashboard/sekretaris',
        'dosen' => 'dashboard/dosen',
        'mahasiswa' => 'dashboard/mahasiswa',
        'penguji' => 'dashboard/penguji',
    ];

    /**
     * Mapping role name → role_id (backward compat)
     */
    private $role_name_id_map = [
        'kaprodi' => 1,
        'koordinator' => 2,
        'sekretaris' => 3,
        'dosen' => 4,
        'mahasiswa' => 5,
        'penguji' => 6,
    ];

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

        $user = $this->User_model->getUserByEmail($email);

        if ($user && password_verify($password, $user->password)) {

            // Ambil semua role dari tabel user_roles
            $roles = $this->User_model->getRolesByUser($user->user_id);

            if (empty($roles)) {
                $this->session->set_flashdata('error', 'User tidak memiliki role. Hubungi admin.');
                redirect('auth/login');
                return;
            }

            // Tentukan active_role berdasarkan prioritas
            $active_role = $this->determineActiveRole($roles);

            // Get nama_lengkap berdasarkan jabatan/tipe user
            $nama_lengkap = $this->getNamaLengkap($user);

            // Role label untuk display
            $role_nama = isset($this->role_label_map[$active_role])
                ? $this->role_label_map[$active_role]
                : ucfirst($active_role);

            // Role ID untuk backward compatibility
            $role_id = isset($this->role_name_id_map[$active_role])
                ? $this->role_name_id_map[$active_role]
                : 0;

            // Set session data
            $this->session->set_userdata([
                'user_id' => $user->user_id,
                'roles' => $roles,           // array: ['sekretaris','dosen','penguji']
                'active_role' => $active_role,     // string: 'sekretaris'
                'role_id' => $role_id,         // int: backward compat
                'nama_lengkap' => $nama_lengkap,
                'role_nama' => $role_nama,
                'logged_in' => TRUE
            ]);

            // Redirect ke dashboard sesuai active_role
            $dashboard = isset($this->role_dashboard_map[$active_role])
                ? $this->role_dashboard_map[$active_role]
                : 'auth/login';

            redirect($dashboard);

        } else {
            $this->session->set_flashdata('error', 'Login gagal. Email atau password salah.');
            redirect('auth/login');
        }
    }

    /**
     * Switch active role (untuk fitur switch role di masa depan)
     */
    public function switch_role()
    {
        $new_role = $this->input->post('role');
        $roles = $this->session->userdata('roles');

        if (!$roles || !in_array($new_role, $roles)) {
            $this->session->set_flashdata('error', 'Role tidak valid.');
            redirect('auth/login');
            return;
        }

        $role_nama = isset($this->role_label_map[$new_role])
            ? $this->role_label_map[$new_role]
            : ucfirst($new_role);

        $role_id = isset($this->role_name_id_map[$new_role])
            ? $this->role_name_id_map[$new_role]
            : 0;

        $this->session->set_userdata([
            'active_role' => $new_role,
            'role_id' => $role_id,
            'role_nama' => $role_nama,
        ]);

        $dashboard = isset($this->role_dashboard_map[$new_role])
            ? $this->role_dashboard_map[$new_role]
            : 'auth/login';

        redirect($dashboard);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    // ========================================
    // PRIVATE METHODS
    // ========================================

    /**
     * Tentukan active_role berdasarkan prioritas
     */
    private function determineActiveRole($roles)
    {
        foreach ($this->role_priority as $priority_role) {
            if (in_array($priority_role, $roles)) {
                return $priority_role;
            }
        }

        // Fallback: ambil role pertama
        return $roles[0];
    }

    /**
     * Get nama_lengkap dari tabel dosen atau mahasiswa
     */
    private function getNamaLengkap($user)
    {
        // Cek di tabel dosen
        $dosen = $this->db->where('user_id', $user->user_id)->get('dosen')->row();
        if ($dosen) {
            return $dosen->nama_dosen;
        }

        // Cek di tabel mahasiswa
        $mahasiswa = $this->db->where('user_id', $user->user_id)->get('mahasiswa')->row();
        if ($mahasiswa) {
            return $mahasiswa->nama_mahasiswa;
        }

        // Fallback ke nama_lengkap di tabel users
        return $user->nama_lengkap ?? 'User';
    }
}

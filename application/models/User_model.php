<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{

    protected $table = 'users';

    /**
     * Mapping jabatan → role_id array
     */
    private $jabatan_role_map = [
        'sekretaris' => [3, 4, 6], // sekretaris + dosen + penguji
        'koordinator' => [2, 4, 6], // koordinator + dosen + penguji
        'kaprodi' => [1, 4, 6], // kaprodi + dosen + penguji
        'dosen' => [4, 6],    // dosen + penguji
        'mahasiswa' => [5],       // mahasiswa saja
    ];

    /**
     * Mapping role_id → nama_role (untuk backward compat)
     */
    private $role_id_name_map = [
        1 => 'kaprodi',
        2 => 'koordinator',
        3 => 'sekretaris',
        4 => 'dosen',
        5 => 'mahasiswa',
        6 => 'penguji',
    ];

    /**
     * Mapping nama_role → role_id (untuk backward compat)
     */
    private $role_name_id_map = [
        'kaprodi' => 1,
        'koordinator' => 2,
        'sekretaris' => 3,
        'dosen' => 4,
        'mahasiswa' => 5,
        'penguji' => 6,
    ];

    // ========================================
    // BACKWARD COMPATIBLE (existing methods)
    // ========================================

    public function get_by_email($email)
    {
        return $this->db
            ->where('email', $email)
            ->get($this->table)
            ->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // ========================================
    // MULTI-ROLE METHODS
    // ========================================

    /**
     * Get user by email (alias)
     */
    public function getUserByEmail($email)
    {
        return $this->get_by_email($email);
    }

    /**
     * Get semua role name milik user dari tabel user_roles
     * @return array ['sekretaris', 'dosen', 'penguji']
     */
    public function getRolesByUser($user_id)
    {
        $result = $this->db
            ->select('r.role_id, r.nama_role')
            ->from('user_roles ur')
            ->join('roles r', 'r.role_id = ur.role_id')
            ->where('ur.user_id', $user_id)
            ->get()
            ->result();

        $roles = [];
        foreach ($result as $row) {
            $role_name = $this->mapRoleIdToName($row->role_id);
            if ($role_name) {
                $roles[] = $role_name;
            }
        }

        return $roles;
    }

    /**
     * Assign roles berdasarkan jabatan (idempotent, transactional)
     */
    public function assignRolesByJabatan($user_id, $jabatan)
    {
        $jabatan = strtolower(trim($jabatan));

        if (!isset($this->jabatan_role_map[$jabatan])) {
            return FALSE;
        }

        $role_ids = $this->jabatan_role_map[$jabatan];

        $this->db->trans_start();

        // Hapus role lama
        $this->removeExistingRolesBeforeReassign($user_id);

        // Insert role baru
        foreach ($role_ids as $role_id) {
            $this->safeInsertRole($user_id, $role_id);
        }

        // Update jabatan di tabel users
        $this->db->where('user_id', $user_id)->update($this->table, ['jabatan' => $jabatan]);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Insert role jika belum ada (prevent duplikat)
     */
    public function safeInsertRole($user_id, $role_id)
    {
        $exists = $this->db
            ->where('user_id', $user_id)
            ->where('role_id', $role_id)
            ->get('user_roles')
            ->row();

        if (!$exists) {
            $this->db->insert('user_roles', [
                'user_id' => $user_id,
                'role_id' => $role_id,
            ]);
        }

        return TRUE;
    }

    /**
     * Hapus semua role user sebelum reassign
     */
    public function removeExistingRolesBeforeReassign($user_id)
    {
        return $this->db->where('user_id', $user_id)->delete('user_roles');
    }

    // ========================================
    // HELPER INTERNAL
    // ========================================

    /**
     * Map role_id integer ke nama role string
     */
    public function mapRoleIdToName($role_id)
    {
        return isset($this->role_id_name_map[$role_id]) ? $this->role_id_name_map[$role_id] : NULL;
    }

    /**
     * Map nama role string ke role_id integer
     */
    public function mapRoleNameToId($role_name)
    {
        $role_name = strtolower(trim($role_name));
        return isset($this->role_name_id_map[$role_name]) ? $this->role_name_id_map[$role_name] : NULL;
    }

    /**
     * Get role_id_name_map (untuk dipakai di auth_helper)
     */
    public function getRoleIdNameMap()
    {
        return $this->role_id_name_map;
    }
}

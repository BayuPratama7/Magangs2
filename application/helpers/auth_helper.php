<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cek apakah user sudah login
 */
function check_login()
{
    $CI =& get_instance();

    if (!$CI->session->userdata('logged_in')) {
        redirect('auth/login');
    }
}

/**
 * Cek apakah user memiliki akses berdasarkan role.
 * 
 * Cek terhadap SEMUA roles user (bukan hanya active_role).
 * Jadi dosen yang punya roles ['dosen','penguji'] bisa akses
 * controller DPL (check_role([4])) DAN Penguji (check_role([6])).
 *
 * Mendukung:
 * - Integer array (backward compat): check_role([3])
 * - String array (baru): check_role(['sekretaris','dosen'])
 *
 * @param array $allowed_roles
 */
function check_role($allowed_roles = [])
{
    $CI =& get_instance();

    if (!$CI->session->userdata('logged_in')) {
        redirect('auth/login');
    }

    // Mapping role_id → nama_role
    $role_id_name_map = [
        1 => 'kaprodi',
        2 => 'koordinator',
        3 => 'sekretaris',
        4 => 'dosen',
        5 => 'mahasiswa',
        6 => 'penguji',
    ];

    $user_roles = $CI->session->userdata('roles');

    if (!is_array($user_roles) || empty($user_roles)) {
        show_error('Anda tidak memiliki akses ke halaman ini', 403);
        return;
    }

    // Konversi allowed_roles integer ke nama role
    $allowed_names = [];
    foreach ($allowed_roles as $role) {
        if (is_int($role) || is_numeric($role)) {
            $role = (int) $role;
            if (isset($role_id_name_map[$role])) {
                $allowed_names[] = $role_id_name_map[$role];
            }
        } else {
            $allowed_names[] = strtolower($role);
        }
    }

    // Cek: salah satu role user harus ada di allowed_names
    $has_access = FALSE;
    foreach ($user_roles as $user_role) {
        if (in_array($user_role, $allowed_names)) {
            $has_access = TRUE;
            break;
        }
    }

    if (!$has_access) {
        show_error('Anda tidak memiliki akses ke halaman ini', 403);
    }
}

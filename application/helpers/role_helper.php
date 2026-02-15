<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cek apakah user memiliki role tertentu
 *
 * @param string $role nama role (e.g. 'sekretaris', 'dosen', 'penguji')
 * @return bool
 */
function has_role($role)
{
    $CI =& get_instance();
    $roles = $CI->session->userdata('roles');

    if (!is_array($roles)) {
        return FALSE;
    }

    return in_array(strtolower($role), $roles);
}

/**
 * Get active role dari session
 *
 * @return string|null
 */
function get_active_role()
{
    $CI =& get_instance();
    return $CI->session->userdata('active_role');
}

/**
 * Get semua role user dari session
 *
 * @return array
 */
function get_user_roles()
{
    $CI =& get_instance();
    $roles = $CI->session->userdata('roles');
    return is_array($roles) ? $roles : [];
}

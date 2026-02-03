<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function check_login()
{
    $CI =& get_instance();

    if (!$CI->session->userdata('logged_in')) {
        redirect('auth/login');
    }
}

function check_role($allowed_roles = [])
{
    $CI =& get_instance();

    $role_id = (int) $CI->session->userdata('role_id');

    if (!in_array($role_id, $allowed_roles)) {
        show_error('Anda tidak memiliki akses ke halaman ini', 403);
    }
}

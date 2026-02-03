<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    protected $table = 'users';

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
}

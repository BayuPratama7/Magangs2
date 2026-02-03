<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model {

    protected $table = 'roles';

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['role_id' => $id])->row();
    }
}

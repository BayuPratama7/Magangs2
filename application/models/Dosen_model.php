<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen_model extends CI_Model
{

    protected $table = 'dosen';

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['dosen_id' => $id])->row();
    }

    public function get_by_user($user_id)
    {
        return $this->db->get_where($this->table, ['user_id' => $user_id])->row();
    }

    public function get_all_dpl()
    {
        return $this->db
            ->where('is_dpl', TRUE)
            ->get($this->table)
            ->result();
    }

    public function get_all_penguji()
    {
        return $this->db
            ->where('is_penguji', TRUE)
            ->get($this->table)
            ->result();
    }

    public function get_mahasiswa_bimbingan($dosen_id)
    {
        return $this->db
            ->select('m.*, p.judul_proposal, p.instansi_tujuan, p.status_koordinator, p.status_kaprodi')
            ->from('mahasiswa m')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id', 'left')
            ->where('m.dosen_dpl_id', $dosen_id)
            ->get()
            ->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db
            ->where('dosen_id', $id)
            ->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db
            ->where('dosen_id', $id)
            ->delete($this->table);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa_model extends CI_Model
{

    protected $table = 'mahasiswa';

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['mahasiswa_id' => $id])->row();
    }

    public function get_by_user($user_id)
    {
        return $this->db
            ->where('user_id', $user_id)
            ->get($this->table)
            ->row();
    }

    public function get_by_nim($nim)
    {
        return $this->db->get_where($this->table, ['nim' => $nim])->row();
    }

    public function get_with_dpl($mahasiswa_id)
    {
        return $this->db
            ->select('m.*, d.nama_dosen as nama_dpl, d.email as email_dpl, d.no_hp as hp_dpl')
            ->from('mahasiswa m')
            ->join('dosen d', 'd.dosen_id = m.dosen_dpl_id', 'left')
            ->where('m.mahasiswa_id', $mahasiswa_id)
            ->get()
            ->row();
    }

    public function get_all_with_proposal()
    {
        return $this->db
            ->select('m.*, p.judul_proposal, p.instansi_tujuan, p.jenis_magang, 
                      p.status_koordinator, p.status_kaprodi, d.nama_dosen as nama_dpl')
            ->from('mahasiswa m')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id', 'left')
            ->join('dosen d', 'd.dosen_id = m.dosen_dpl_id', 'left')
            ->order_by('m.nim', 'ASC')
            ->get()
            ->result();
    }

    public function get_by_dpl($dosen_id)
    {
        return $this->db
            ->select('m.*, p.judul_proposal, p.instansi_tujuan, p.status_koordinator, p.status_kaprodi')
            ->from('mahasiswa m')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id', 'left')
            ->where('m.dosen_dpl_id', $dosen_id)
            ->order_by('m.nim', 'ASC')
            ->get()
            ->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db
            ->where('mahasiswa_id', $id)
            ->update($this->table, $data);
    }

    public function update_status($id, $status)
    {
        return $this->db
            ->where('mahasiswa_id', $id)
            ->update($this->table, [
                'status_magang' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function assign_dpl($mahasiswa_id, $dosen_id)
    {
        return $this->db
            ->where('mahasiswa_id', $mahasiswa_id)
            ->update($this->table, [
                'dosen_dpl_id' => $dosen_id,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function delete($id)
    {
        return $this->db
            ->where('mahasiswa_id', $id)
            ->delete($this->table);
    }
}

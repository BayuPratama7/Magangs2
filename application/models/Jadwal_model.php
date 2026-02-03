<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_model extends CI_Model
{

    protected $table = 'jadwal_desiminasi';

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['jadwal_id' => $id])->row();
    }

    public function get_by_desiminasi($desiminasi_id)
    {
        return $this->db->get_where($this->table, ['desiminasi_id' => $desiminasi_id])->row();
    }

    public function get_upcoming($limit = 10)
    {
        return $this->db
            ->select('j.*, d.mahasiswa_id, m.nim, m.nama_mahasiswa, 
                      ds.nama_dosen as nama_penguji, p.judul_proposal')
            ->from('jadwal_desiminasi j')
            ->join('desiminasi d', 'd.desiminasi_id = j.desiminasi_id')
            ->join('mahasiswa m', 'm.mahasiswa_id = d.mahasiswa_id')
            ->join('dosen ds', 'ds.dosen_id = d.penguji_id', 'left')
            ->join('proposal_magang p', 'p.mahasiswa_id = d.mahasiswa_id', 'left')
            ->where('j.tanggal_desiminasi >=', date('Y-m-d'))
            ->where('j.status', 'terkonfirmasi')
            ->order_by('j.tanggal_desiminasi', 'ASC')
            ->order_by('j.waktu_mulai', 'ASC')
            ->limit($limit)
            ->get()
            ->result();
    }

    public function get_by_penguji($dosen_id)
    {
        return $this->db
            ->select('j.*, d.mahasiswa_id, m.nim, m.nama_mahasiswa, p.judul_proposal')
            ->from('jadwal_desiminasi j')
            ->join('desiminasi d', 'd.desiminasi_id = j.desiminasi_id')
            ->join('mahasiswa m', 'm.mahasiswa_id = d.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = d.mahasiswa_id', 'left')
            ->where('d.penguji_id', $dosen_id)
            ->where('j.tanggal_desiminasi >=', date('Y-m-d'))
            ->order_by('j.tanggal_desiminasi', 'ASC')
            ->get()
            ->result();
    }

    public function insert($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db
            ->where('jadwal_id', $id)
            ->update($this->table, $data);
    }

    public function update_status($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }

    public function delete($id)
    {
        return $this->db
            ->where('jadwal_id', $id)
            ->delete($this->table);
    }
}

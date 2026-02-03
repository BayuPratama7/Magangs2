<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logbook_model extends CI_Model
{

    protected $table = 'logbook_magang';

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['logbook_id' => $id])->row();
    }

    public function get_by_mahasiswa($mahasiswa_id)
    {
        return $this->db
            ->where('mahasiswa_id', $mahasiswa_id)
            ->order_by('bulan_ke', 'ASC')
            ->get($this->table)
            ->result();
    }

    public function get_by_mahasiswa_bulan($mahasiswa_id, $bulan_ke)
    {
        return $this->db
            ->where('mahasiswa_id', $mahasiswa_id)
            ->where('bulan_ke', $bulan_ke)
            ->get($this->table)
            ->row();
    }

    public function get_all_by_dpl($dosen_id)
    {
        return $this->db
            ->select('l.*, m.nim, m.nama_mahasiswa, p.judul_proposal, p.instansi_tujuan')
            ->from('logbook_magang l')
            ->join('mahasiswa m', 'm.mahasiswa_id = l.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = l.mahasiswa_id', 'left')
            ->where('m.dosen_dpl_id', $dosen_id)
            ->order_by('l.tanggal_upload', 'DESC')
            ->get()
            ->result();
    }

    public function get_all_for_koordinator()
    {
        return $this->db
            ->select('l.*, m.nim, m.nama_mahasiswa, p.judul_proposal, p.instansi_tujuan')
            ->from('logbook_magang l')
            ->join('mahasiswa m', 'm.mahasiswa_id = l.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = l.mahasiswa_id', 'left')
            ->order_by('l.tanggal_upload', 'DESC')
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
            ->where('logbook_id', $id)
            ->update($this->table, $data);
    }

    public function update_status_dpl($id, $status, $catatan = null)
    {
        $data = [
            'status_dpl' => $status,
            'catatan_dpl' => $catatan,
            'tanggal_review_dpl' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->db
            ->where('logbook_id', $id)
            ->update($this->table, $data);
    }

    public function update_status_koordinator($id, $status)
    {
        $data = [
            'status_koordinator' => $status,
            'tanggal_review_koordinator' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->db
            ->where('logbook_id', $id)
            ->update($this->table, $data);
    }

    public function count_complete_logbook($mahasiswa_id)
    {
        return $this->db
            ->where('mahasiswa_id', $mahasiswa_id)
            ->where('status_dpl', 'sudah_review')
            ->count_all_results($this->table);
    }

    public function delete($id)
    {
        return $this->db
            ->where('logbook_id', $id)
            ->delete($this->table);
    }
}

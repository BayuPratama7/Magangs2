<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposal_model extends CI_Model
{

    protected $table = 'proposal_magang';

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['proposal_id' => $id])->row();
    }

    public function get_all()
    {
        return $this->db
            ->order_by('proposal_id', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function get_by_mahasiswa($mahasiswa_id)
    {
        return $this->db
            ->where('mahasiswa_id', $mahasiswa_id)
            ->get($this->table)
            ->row();
    }

    public function get_all_with_mahasiswa()
    {
        return $this->db
            ->select('p.*, m.nim, m.nama_mahasiswa, m.prodi')
            ->from('proposal_magang p')
            ->join('mahasiswa m', 'm.mahasiswa_id = p.mahasiswa_id')
            ->order_by('p.proposal_id', 'DESC')
            ->get()
            ->result();
    }

    // For Koordinator - get proposals pending ACC tahap 1
    public function get_pending_koordinator()
    {
        return $this->db
            ->select('p.*, m.nim, m.nama_mahasiswa, m.prodi')
            ->from('proposal_magang p')
            ->join('mahasiswa m', 'm.mahasiswa_id = p.mahasiswa_id')
            ->where('p.status_koordinator', 'menunggu')
            ->order_by('p.tanggal_pengajuan', 'ASC')
            ->get()
            ->result();
    }

    // For Kaprodi - get proposals pending ACC tahap 2 (sudah di-ACC koordinator)
    public function get_pending_kaprodi()
    {
        return $this->db
            ->select('p.*, m.nim, m.nama_mahasiswa, m.prodi')
            ->from('proposal_magang p')
            ->join('mahasiswa m', 'm.mahasiswa_id = p.mahasiswa_id')
            ->where('p.status_koordinator', 'disetujui')
            ->where('p.status_kaprodi', 'menunggu')
            ->order_by('p.tanggal_pengajuan', 'ASC')
            ->get()
            ->result();
    }

    // Get approved proposals (both ACC)
    public function get_approved()
    {
        return $this->db
            ->select('p.*, m.nim, m.nama_mahasiswa, m.prodi')
            ->from('proposal_magang p')
            ->join('mahasiswa m', 'm.mahasiswa_id = p.mahasiswa_id')
            ->where('p.status_koordinator', 'disetujui')
            ->where('p.status_kaprodi', 'disetujui')
            ->order_by('p.tanggal_pengajuan', 'DESC')
            ->get()
            ->result();
    }

    // Get proposals approved by koordinator only (for koordinator dashboard)
    public function get_approved_by_koordinator()
    {
        return $this->db
            ->select('p.*, m.nim, m.nama_mahasiswa, m.prodi')
            ->from('proposal_magang p')
            ->join('mahasiswa m', 'm.mahasiswa_id = p.mahasiswa_id')
            ->where('p.status_koordinator', 'disetujui')
            ->order_by('p.tanggal_pengajuan', 'DESC')
            ->get()
            ->result();
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db
            ->where('proposal_id', $id)
            ->update($this->table, $data);
    }

    public function update_status_koordinator($id, $status, $catatan = null)
    {
        $data = [
            'status_koordinator' => $status,
            'catatan_koordinator' => $catatan,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        if ($status == 'disetujui') {
            $data['tanggal_acc_koordinator'] = date('Y-m-d H:i:s');
        }
        return $this->db
            ->where('proposal_id', $id)
            ->update($this->table, $data);
    }

    public function update_status_kaprodi($id, $status, $catatan = null)
    {
        $data = [
            'status_kaprodi' => $status,
            'catatan_kaprodi' => $catatan,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        if ($status == 'disetujui') {
            $data['tanggal_acc_kaprodi'] = date('Y-m-d H:i:s');
        }
        return $this->db
            ->where('proposal_id', $id)
            ->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db
            ->where('proposal_id', $id)
            ->delete($this->table);
    }
}

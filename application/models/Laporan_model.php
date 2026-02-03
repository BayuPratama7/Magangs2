<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model
{

    protected $table = 'laporan_magang';

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['laporan_id' => $id])->row();
    }

    public function get_by_mahasiswa($mahasiswa_id)
    {
        return $this->db
            ->where('mahasiswa_id', $mahasiswa_id)
            ->order_by('tanggal_upload', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function get_latest_by_mahasiswa($mahasiswa_id)
    {
        return $this->db
            ->where('mahasiswa_id', $mahasiswa_id)
            ->order_by('tanggal_upload', 'DESC')
            ->limit(1)
            ->get($this->table)
            ->row();
    }

    public function get_draft_by_mahasiswa($mahasiswa_id)
    {
        return $this->db
            ->where('mahasiswa_id', $mahasiswa_id)
            ->where('jenis_laporan', 'draft')
            ->order_by('tanggal_upload', 'DESC')
            ->get($this->table)
            ->row();
    }

    public function get_all_by_dpl($dosen_id)
    {
        return $this->db
            ->select('l.*, m.nim, m.nama_mahasiswa, p.judul_proposal, p.instansi_tujuan')
            ->from('laporan_magang l')
            ->join('mahasiswa m', 'm.mahasiswa_id = l.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = l.mahasiswa_id', 'left')
            ->where('m.dosen_dpl_id', $dosen_id)
            ->order_by('l.tanggal_upload', 'DESC')
            ->get()
            ->result();
    }

    public function get_pending_review_by_dpl($dosen_id)
    {
        return $this->db
            ->select('l.*, m.nim, m.nama_mahasiswa, p.judul_proposal, p.instansi_tujuan')
            ->from('laporan_magang l')
            ->join('mahasiswa m', 'm.mahasiswa_id = l.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = l.mahasiswa_id', 'left')
            ->where('m.dosen_dpl_id', $dosen_id)
            ->where('l.status_dpl', 'menunggu')
            ->order_by('l.tanggal_upload', 'ASC')
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
            ->where('laporan_id', $id)
            ->update($this->table, $data);
    }

    public function update_status_dpl($id, $status, $catatan = null, $is_acc_desiminasi = false)
    {
        $data = [
            'status_dpl' => $status,
            'catatan_dpl' => $catatan,
            'tanggal_review_dpl' => date('Y-m-d H:i:s'),
            'is_acc_desiminasi' => $is_acc_desiminasi,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->db
            ->where('laporan_id', $id)
            ->update($this->table, $data);
    }

    public function has_acc_desiminasi($mahasiswa_id)
    {
        return $this->db
            ->where('mahasiswa_id', $mahasiswa_id)
            ->where('is_acc_desiminasi', TRUE)
            ->count_all_results($this->table) > 0;
    }

    public function delete($id)
    {
        return $this->db
            ->where('laporan_id', $id)
            ->delete($this->table);
    }
}

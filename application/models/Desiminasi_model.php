<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Desiminasi_model extends CI_Model
{

    protected $table = 'desiminasi';

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['desiminasi_id' => $id])->row();
    }

    public function get_detail($id)
    {
        return $this->db
            ->select('d.*, m.nim, m.nama_mahasiswa, m.dosen_dpl_id, p.judul_proposal, p.instansi_tujuan, 
                      l.link_laporan, l.jenis_laporan, dpl.nama_dosen as nama_dpl')
            ->from('desiminasi d')
            ->join('mahasiswa m', 'm.mahasiswa_id = d.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = d.mahasiswa_id', 'left')
            ->join('laporan_magang l', 'l.laporan_id = d.laporan_id', 'left')
            ->join('dosen dpl', 'dpl.dosen_id = m.dosen_dpl_id', 'left')
            ->where('d.desiminasi_id', $id)
            ->get()
            ->row();
    }

    public function get_by_mahasiswa($mahasiswa_id)
    {
        return $this->db
            ->select('d.*, j.tanggal_desiminasi, j.waktu_mulai, j.ruangan, j.link_online, j.status as status_jadwal, 
                      ds.nama_dosen as nama_penguji, h.status_kelulusan, h.nilai, h.catatan_revisi')
            ->from('desiminasi d')
            ->join('jadwal_desiminasi j', 'j.desiminasi_id = d.desiminasi_id', 'left')
            ->join('dosen ds', 'ds.dosen_id = d.penguji_id', 'left')
            ->join('hasil_desiminasi h', 'h.desiminasi_id = d.desiminasi_id', 'left')
            ->where('d.mahasiswa_id', $mahasiswa_id)
            ->get()
            ->row();
    }

    public function get_all_pending()
    {
        return $this->db
            ->select('d.*, m.nim, m.nama_mahasiswa, m.dosen_dpl_id, p.judul_proposal, p.instansi_tujuan, ds.nama_dosen as nama_dpl')
            ->from('desiminasi d')
            ->join('mahasiswa m', 'm.mahasiswa_id = d.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = d.mahasiswa_id', 'left')
            ->join('dosen ds', 'ds.dosen_id = m.dosen_dpl_id', 'left')
            ->where('d.status_pengajuan', 'menunggu')
            ->order_by('d.tanggal_pengajuan', 'ASC')
            ->get()
            ->result();
    }

    public function get_all_pengajuan()
    {
        return $this->db
            ->select('d.*, m.nim, m.nama_mahasiswa, m.dosen_dpl_id, p.judul_proposal, p.instansi_tujuan, ds.nama_dosen as nama_dpl, penguji.nama_dosen as nama_penguji, j.tanggal_desiminasi, j.waktu_mulai, j.waktu_selesai, j.ruangan')
            ->from('desiminasi d')
            ->join('mahasiswa m', 'm.mahasiswa_id = d.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = d.mahasiswa_id', 'left')
            ->join('dosen ds', 'ds.dosen_id = m.dosen_dpl_id', 'left')
            ->join('dosen penguji', 'penguji.dosen_id = d.penguji_id', 'left')
            ->join('jadwal_desiminasi j', 'j.desiminasi_id = d.desiminasi_id', 'left')
            ->order_by("CASE d.status_pengajuan WHEN 'menunggu' THEN 1 WHEN 'diterima' THEN 2 WHEN 'ditolak' THEN 3 ELSE 4 END", 'ASC', FALSE)
            ->order_by('d.tanggal_pengajuan', 'DESC')
            ->get()
            ->result();
    }

    public function get_by_penguji($dosen_id)
    {
        return $this->db
            ->select('d.*, m.nim, m.nama_mahasiswa, p.judul_proposal, p.instansi_tujuan,
                      j.tanggal_desiminasi, j.waktu_mulai, j.ruangan, j.link_online')
            ->from('desiminasi d')
            ->join('mahasiswa m', 'm.mahasiswa_id = d.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = d.mahasiswa_id', 'left')
            ->join('jadwal_desiminasi j', 'j.desiminasi_id = d.desiminasi_id', 'left')
            ->where('d.penguji_id', $dosen_id)
            ->order_by('j.tanggal_desiminasi', 'ASC')
            ->get()
            ->result();
    }

    public function get_pending_konfirmasi($dosen_id)
    {
        return $this->db
            ->select('d.*, m.nim, m.nama_mahasiswa, p.judul_proposal, p.instansi_tujuan, j.tanggal_desiminasi, j.waktu_mulai, j.waktu_selesai, j.ruangan')
            ->from('desiminasi d')
            ->join('mahasiswa m', 'm.mahasiswa_id = d.mahasiswa_id')
            ->join('proposal_magang p', 'p.mahasiswa_id = d.mahasiswa_id', 'left')
            ->join('jadwal_desiminasi j', 'j.desiminasi_id = d.desiminasi_id', 'left')
            ->where('d.penguji_id', $dosen_id)
            ->where('d.konfirmasi_penguji', 'menunggu')
            ->order_by('d.tanggal_pengajuan', 'ASC')
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
            ->where('desiminasi_id', $id)
            ->update($this->table, $data);
    }

    public function update_konfirmasi($id, $konfirmasi)
    {
        $data = [
            'konfirmasi_penguji' => $konfirmasi,
            'tanggal_konfirmasi' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->db
            ->where('desiminasi_id', $id)
            ->update($this->table, $data);
    }

    public function assign_penguji($id, $penguji_id)
    {
        $data = [
            'penguji_id' => $penguji_id,
            'status_pengajuan' => 'diterima',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->db
            ->where('desiminasi_id', $id)
            ->update($this->table, $data);
    }

    /**
     * Alias for update_konfirmasi - used by PengujiController
     */
    public function konfirmasi_penguji($id, $status)
    {
        return $this->update_konfirmasi($id, $status);
    }
}

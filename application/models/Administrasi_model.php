<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrasi_model extends CI_Model
{

    // ==========================================
    // SURAT PENGANTAR
    // ==========================================

    public function get_surat_by_id($id)
    {
        return $this->db->get_where('surat_pengantar', ['surat_id' => $id])->row();
    }

    public function get_surat_by_mahasiswa($mahasiswa_id)
    {
        return $this->db->get_where('surat_pengantar', ['mahasiswa_id' => $mahasiswa_id])->row();
    }

    public function get_surat_by_proposal($proposal_id)
    {
        return $this->db->get_where('surat_pengantar', ['proposal_id' => $proposal_id])->row();
    }

    public function get_all_surat()
    {
        return $this->db
            ->select('s.*, m.nim, m.nama_mahasiswa, p.instansi_tujuan')
            ->from('surat_pengantar s')
            ->join('mahasiswa m', 'm.mahasiswa_id = s.mahasiswa_id')
            ->join('proposal_magang p', 'p.proposal_id = s.proposal_id', 'left')
            ->order_by('s.tanggal_surat', 'DESC')
            ->get()
            ->result();
    }

    public function insert_surat($data)
    {
        return $this->db->insert('surat_pengantar', $data);
    }

    public function update_surat($id, $data)
    {
        return $this->db
            ->where('surat_id', $id)
            ->update('surat_pengantar', $data);
    }

    // ==========================================
    // JADWAL DESIMINASI
    // ==========================================

    public function get_jadwal_by_id($id)
    {
        return $this->db->get_where('jadwal_desiminasi', ['jadwal_id' => $id])->row();
    }

    public function get_jadwal_by_desiminasi($desiminasi_id)
    {
        return $this->db->get_where('jadwal_desiminasi', ['desiminasi_id' => $desiminasi_id])->row();
    }

    public function get_all_jadwal()
    {
        return $this->db
            ->select('j.*, m.nim, m.nama_mahasiswa, d.nama_dosen as nama_penguji, p.judul_proposal')
            ->from('jadwal_desiminasi j')
            ->join('mahasiswa m', 'm.mahasiswa_id = j.mahasiswa_id')
            ->join('desiminasi ds', 'ds.desiminasi_id = j.desiminasi_id', 'left')
            ->join('dosen d', 'd.dosen_id = ds.penguji_id', 'left')
            ->join('proposal_magang p', 'p.mahasiswa_id = j.mahasiswa_id', 'left')
            ->order_by('j.tanggal_desiminasi', 'ASC')
            ->get()
            ->result();
    }

    public function get_upcoming_jadwal()
    {
        return $this->db
            ->select('j.*, m.nim, m.nama_mahasiswa, d.nama_dosen as nama_penguji')
            ->from('jadwal_desiminasi j')
            ->join('mahasiswa m', 'm.mahasiswa_id = j.mahasiswa_id')
            ->join('desiminasi ds', 'ds.desiminasi_id = j.desiminasi_id', 'left')
            ->join('dosen d', 'd.dosen_id = ds.penguji_id', 'left')
            ->where('j.tanggal_desiminasi >=', date('Y-m-d'))
            ->where('j.status', 'terjadwal')
            ->order_by('j.tanggal_desiminasi', 'ASC')
            ->get()
            ->result();
    }

    public function insert_jadwal($data)
    {
        return $this->db->insert('jadwal_desiminasi', $data);
    }

    public function update_jadwal($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db
            ->where('jadwal_id', $id)
            ->update('jadwal_desiminasi', $data);
    }

    // ==========================================
    // HASIL DESIMINASI
    // ==========================================

    public function get_hasil_by_desiminasi($desiminasi_id)
    {
        return $this->db->get_where('hasil_desiminasi', ['desiminasi_id' => $desiminasi_id])->row();
    }

    public function get_hasil_by_mahasiswa($mahasiswa_id)
    {
        return $this->db->get_where('hasil_desiminasi', ['mahasiswa_id' => $mahasiswa_id])->row();
    }

    public function insert_hasil($data)
    {
        return $this->db->insert('hasil_desiminasi', $data);
    }

    public function update_hasil($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db
            ->where('hasil_id', $id)
            ->update('hasil_desiminasi', $data);
    }

    public function update_hasil_by_desiminasi($desiminasi_id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db
            ->where('desiminasi_id', $desiminasi_id)
            ->update('hasil_desiminasi', $data);
    }

    public function acc_laporan_akhir($desiminasi_id, $catatan = null)
    {
        $data = [
            'status_laporan_akhir' => 'disetujui',
            'catatan_penguji' => $catatan,
            'tanggal_acc_laporan_akhir' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->db
            ->where('desiminasi_id', $desiminasi_id)
            ->update('hasil_desiminasi', $data);
    }

    // ==========================================
    // PENUGASAN DPL
    // ==========================================

    public function assign_dpl($mahasiswa_id, $dosen_id)
    {
        return $this->db
            ->where('mahasiswa_id', $mahasiswa_id)
            ->update('mahasiswa', [
                'dosen_dpl_id' => $dosen_id,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function get_mahasiswa_tanpa_dpl()
    {
        return $this->db
            ->select('DISTINCT m.mahasiswa_id, m.user_id, m.nim, m.nama_mahasiswa, m.prodi, m.angkatan, m.kelas, m.no_hp, m.alamat, m.dosen_dpl_id, m.status_magang, m.created_at, m.updated_at, p.proposal_id, p.judul_proposal, p.instansi_tujuan, p.status_kaprodi, p.status_mitra, p.tanggal_balasan_mitra')
            ->from('mahasiswa m')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id')
            ->where('m.dosen_dpl_id IS NULL')
            ->where('p.status_kaprodi', 'disetujui')
            ->where('p.status_mitra', 'diterima')
            ->get()
            ->result();
    }

    public function get_mahasiswa_dengan_dpl()
    {
        return $this->db
            ->select('m.*, p.judul_proposal, p.instansi_tujuan, d.nama_dosen as nama_dpl')
            ->from('mahasiswa m')
            ->join('proposal_magang p', 'p.mahasiswa_id = m.mahasiswa_id')
            ->join('dosen d', 'd.dosen_id = m.dosen_dpl_id', 'left')
            ->where('m.dosen_dpl_id IS NOT NULL')
            ->get()
            ->result();
    }
}

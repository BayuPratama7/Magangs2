<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

    // ==========================================
    // MITRA KERJASAMA
    // ==========================================

    public function get_all_mitra()
    {
        return $this->db
            ->where('is_active', TRUE)
            ->order_by('nama_mitra', 'ASC')
            ->get('mitra_kerjasama')
            ->result();
    }

    public function get_mitra_by_id($id)
    {
        return $this->db->get_where('mitra_kerjasama', ['mitra_id' => $id])->row();
    }

    public function get_mitra_by_jenis($jenis)
    {
        return $this->db
            ->where('jenis_mitra', $jenis)
            ->where('is_active', TRUE)
            ->get('mitra_kerjasama')
            ->result();
    }

    public function count_mitra()
    {
        return $this->db->where('is_active', TRUE)->count_all_results('mitra_kerjasama');
    }

    public function insert_mitra($data)
    {
        return $this->db->insert('mitra_kerjasama', $data);
    }

    public function update_mitra($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db
            ->where('mitra_id', $id)
            ->update('mitra_kerjasama', $data);
    }

    public function delete_mitra($id)
    {
        return $this->db
            ->where('mitra_id', $id)
            ->update('mitra_kerjasama', ['is_active' => FALSE]);
    }

    // ==========================================
    // SEBARAN MAGANG
    // ==========================================

    public function get_all_sebaran()
    {
        return $this->db
            ->order_by('periode', 'DESC')
            ->order_by('wilayah', 'ASC')
            ->get('sebaran_magang')
            ->result();
    }

    public function get_sebaran_by_periode($periode)
    {
        return $this->db
            ->where('periode', $periode)
            ->order_by('wilayah', 'ASC')
            ->get('sebaran_magang')
            ->result();
    }

    public function get_sebaran_by_wilayah($periode = null)
    {
        $this->db->select('wilayah, provinsi, SUM(jumlah_mahasiswa) as total');
        $this->db->from('sebaran_magang');
        if ($periode) {
            $this->db->where('periode', $periode);
        }
        $this->db->group_by('wilayah, provinsi');
        $this->db->order_by('total', 'DESC');
        return $this->db->get()->result();
    }

    public function get_sebaran_by_jenis($periode = null)
    {
        $this->db->select('jenis_magang, SUM(jumlah_mahasiswa) as total');
        $this->db->from('sebaran_magang');
        if ($periode) {
            $this->db->where('periode', $periode);
        }
        $this->db->group_by('jenis_magang');
        $this->db->order_by('total', 'DESC');
        return $this->db->get()->result();
    }

    public function get_available_periode()
    {
        return $this->db
            ->select('DISTINCT(periode) as periode')
            ->order_by('periode', 'DESC')
            ->get('sebaran_magang')
            ->result();
    }

    public function insert_sebaran($data)
    {
        return $this->db->insert('sebaran_magang', $data);
    }

    public function update_sebaran($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db
            ->where('sebaran_id', $id)
            ->update('sebaran_magang', $data);
    }

    public function delete_sebaran($id)
    {
        return $this->db
            ->where('sebaran_id', $id)
            ->delete('sebaran_magang');
    }

    // ==========================================
    // STATISTIK DASHBOARD
    // ==========================================

    public function get_statistik()
    {
        $stats = new stdClass();

        // Total mahasiswa magang aktif
        $stats->total_mahasiswa_aktif = $this->db
            ->where_in('status_magang', ['sedang_magang', 'mengajukan', 'diterima'])
            ->count_all_results('mahasiswa');

        // Total proposal pending
        $stats->total_proposal_pending = $this->db
            ->where('status_koordinator', 'menunggu')
            ->count_all_results('proposal_magang');

        // Total proposal disetujui
        $stats->total_proposal_disetujui = $this->db
            ->where('status_koordinator', 'disetujui')
            ->where('status_kaprodi', 'disetujui')
            ->count_all_results('proposal_magang');

        // Total mitra aktif
        $stats->total_mitra = $this->count_mitra();

        // Total desiminasi pending
        $stats->total_desiminasi_pending = $this->db
            ->where('status_pengajuan', 'menunggu')
            ->count_all_results('desiminasi');

        return $stats;
    }

    // ==========================================
    // NOTIFIKASI
    // ==========================================

    public function get_notifikasi($user_id, $limit = 10)
    {
        return $this->db
            ->where('user_id', $user_id)
            ->order_by('created_at', 'DESC')
            ->limit($limit)
            ->get('notifikasi')
            ->result();
    }

    public function get_unread_count($user_id)
    {
        return $this->db
            ->where('user_id', $user_id)
            ->where('is_read', FALSE)
            ->count_all_results('notifikasi');
    }

    public function insert_notifikasi($data)
    {
        return $this->db->insert('notifikasi', $data);
    }

    public function mark_as_read($notifikasi_id)
    {
        return $this->db
            ->where('notifikasi_id', $notifikasi_id)
            ->update('notifikasi', ['is_read' => TRUE]);
    }

    public function mark_all_as_read($user_id)
    {
        return $this->db
            ->where('user_id', $user_id)
            ->update('notifikasi', ['is_read' => TRUE]);
    }
}

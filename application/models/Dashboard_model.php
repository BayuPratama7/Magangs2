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

    public function get_latest_mitra($limit = 5)
    {
        return $this->db
            ->where('is_active', TRUE)
            ->order_by('mitra_id', 'DESC')
            ->limit($limit)
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

    public function get_all_sebaran($tahun_akademik = null, $jenis_magang = null)
    {
        $this->db->select('tahun_akademik, provinsi, jenis_magang, instansi_tujuan as nama_instansi, COUNT(*) as jumlah_mahasiswa, 0 as sebaran_id');
        $this->db->from('proposal_magang');
        $this->db->where('status_koordinator', 'disetujui');
        if ($tahun_akademik) {
            $this->db->where('tahun_akademik', $tahun_akademik);
        }
        if ($jenis_magang) {
            $this->db->where('jenis_magang', $jenis_magang);
        }
        $this->db->group_by(['tahun_akademik', 'provinsi', 'jenis_magang', 'instansi_tujuan']);
        $this->db->order_by('tahun_akademik', 'DESC');
        $this->db->order_by('provinsi', 'ASC');
        
        $sebarans = $this->db->get()->result();
        
        // Return results. Note: since this is dynamic, sebaran_id is 0. 
        // We might want to include "empty" sebaran from sebaran_magang table if it doesn't exist in proposals?
        // Let's also fetch empty ones from sebaran_magang to support the "0" request
        $this->db->select('tahun_akademik, provinsi, jenis_magang, nama_instansi, jumlah_mahasiswa, sebaran_id');
        $this->db->from('sebaran_magang');
        if ($tahun_akademik) {
            $this->db->where('tahun_akademik', $tahun_akademik);
        }
        if ($jenis_magang) {
            $this->db->where('jenis_magang', $jenis_magang);
        }
        $manual_sebarans = $this->db->get()->result();

        // Create a map of manual sebarans
        $manual_map = [];
        foreach ($manual_sebarans as $m) {
            $key = $m->tahun_akademik . '|' . $m->provinsi . '|' . strtolower($m->jenis_magang) . '|' . $m->nama_instansi;
            $manual_map[$key] = $m;
        }

        // Create a map of dynamic sebarans
        $final_sebarans = [];
        foreach ($sebarans as $s) {
            $key = $s->tahun_akademik . '|' . $s->provinsi . '|' . strtolower($s->jenis_magang) . '|' . $s->nama_instansi;
            // If there's a manual override, skip the dynamic one
            if (!isset($manual_map[$key])) {
                $final_sebarans[] = $s;
            }
        }

        // Add all manual sebarans
        foreach ($manual_sebarans as $m) {
            $final_sebarans[] = $m;
        }

        // Sort by tahun_akademik DESC
        usort($final_sebarans, function($a, $b) {
            return strcmp($b->tahun_akademik, $a->tahun_akademik);
        });

        return $final_sebarans;
    }

    public function get_sebaran_by_periode($periode)
    {
        return $this->db
            ->where('periode', $periode)
            ->order_by('wilayah', 'ASC')
            ->get('sebaran_magang')
            ->result();
    }

    public function get_sebaran_by_wilayah($tahun_akademik = null)
    {
        $this->db->select('provinsi as wilayah, provinsi, COUNT(*) as total');
        $this->db->from('proposal_magang');
        $this->db->where('status_koordinator', 'disetujui');
        $this->db->where('provinsi IS NOT NULL');
        if ($tahun_akademik) {
            $this->db->where('tahun_akademik', $tahun_akademik);
        }
        $this->db->group_by('provinsi');
        $this->db->order_by('total', 'DESC');
        return $this->db->get()->result();
    }

    public function get_sebaran_by_jenis($tahun_akademik = null)
    {
        $this->db->select('jenis_magang, COUNT(*) as total');
        $this->db->from('proposal_magang');
        $this->db->where('status_koordinator', 'disetujui');
        if ($tahun_akademik) {
            $this->db->where('tahun_akademik', $tahun_akademik);
        }
        $this->db->group_by('jenis_magang');
        $this->db->order_by('total', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Get sebaran by jenis_magang filtered by provinsi
     * Uses proposal_magang table for real-time data
     */
    public function get_sebaran_by_jenis_provinsi($provinsi = null, $tahun_akademik = null, $jenis = null)
    {
        $this->db->select('p.jenis_magang, COUNT(*) as total');
        $this->db->from('proposal_magang p');
        $this->db->where('p.status_koordinator', 'disetujui');
        if ($provinsi && $provinsi !== 'semua') {
            $this->db->where('p.provinsi', $provinsi);
        }
        if ($tahun_akademik && $tahun_akademik !== 'semua') {
            $this->db->where('p.tahun_akademik', $tahun_akademik);
        }
        if ($jenis && $jenis !== 'semua') {
            $this->db->where('p.jenis_magang', $jenis);
        }
        $this->db->group_by('p.jenis_magang');
        $this->db->order_by('total', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Get list of all distinct tahun_akademik from proposal_magang
     */
    public function get_tahun_akademik_list()
    {
        $this->db->select('tahun_akademik');
        $this->db->from('proposal_magang');
        $this->db->where('tahun_akademik IS NOT NULL');
        $this->db->group_by('tahun_akademik');
        $this->db->order_by('tahun_akademik', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Get list of all provinsi from provinsi table
     */
    public function get_provinsi_list()
    {
        return $this->db
            ->order_by('nama_provinsi', 'ASC')
            ->get('provinsi')
            ->result();
    }

    /**
     * Get distinct provinsi that have proposals (for active filter)
     */
    public function get_provinsi_with_proposals()
    {
        return $this->db
            ->select('DISTINCT(provinsi) as provinsi')
            ->from('proposal_magang')
            ->where('provinsi IS NOT NULL')
            ->where('provinsi !=', '')
            ->where('status_koordinator', 'disetujui')
            ->order_by('provinsi', 'ASC')
            ->get()
            ->result();
    }

    /**
     * Get sebaran grouped by provinsi from proposal_magang
     * Returns provinsi name and count of students
     */
    public function get_sebaran_by_provinsi()
    {
        return $this->db
            ->select('provinsi, COUNT(*) as total')
            ->from('proposal_magang')
            ->where('provinsi IS NOT NULL')
            ->where('provinsi !=', '')
            ->where('status_koordinator', 'disetujui')
            ->group_by('provinsi')
            ->order_by('total', 'DESC')
            ->get()
            ->result();
    }

    public function get_available_tahun_akademik()
    {
        return $this->db
            ->select('DISTINCT(tahun_akademik) as tahun_akademik')
            ->order_by('tahun_akademik', 'DESC')
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
        $this->load->model('Mahasiswa_model');
        $this->Mahasiswa_model->sync_all_statuses();

        $stats = new stdClass();

        // Total mahasiswa magang aktif
        $stats->total_mahasiswa_aktif = $this->db
            ->where_in('status_magang', ['sedang_magang', 'mengajukan'])
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

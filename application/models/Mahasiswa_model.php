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
        $this->sync_status_magang($id);
        return $this->db->get_where($this->table, ['mahasiswa_id' => $id])->row();
    }

    public function get_by_user($user_id)
    {
        $mahasiswa = $this->db->get_where($this->table, ['user_id' => $user_id])->row();
        if ($mahasiswa) {
            $this->sync_status_magang($mahasiswa->mahasiswa_id);
            return $this->db->get_where($this->table, ['mahasiswa_id' => $mahasiswa->mahasiswa_id])->row();
        }
        return null;
    }

    public function get_by_nim($nim)
    {
        $mahasiswa = $this->db->get_where($this->table, ['nim' => $nim])->row();
        if ($mahasiswa) {
            $this->sync_status_magang($mahasiswa->mahasiswa_id);
            return $this->db->get_where($this->table, ['mahasiswa_id' => $mahasiswa->mahasiswa_id])->row();
        }
        return null;
    }

    public function get_with_dpl($mahasiswa_id)
    {
        $this->sync_status_magang($mahasiswa_id);
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
        $this->sync_all_statuses();
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

    public function sync_status_magang($mahasiswa_id)
    {
        // Fetch raw mahasiswa record directly from db to avoid recursion
        $mahasiswa = $this->db->get_where($this->table, ['mahasiswa_id' => $mahasiswa_id])->row();
        if (!$mahasiswa) {
            return 'belum_magang';
        }

        // 1. Cek Kelulusan / Selesai (laporan akhir di-ACC penguji)
        $this->db->select('h.status_laporan_akhir')
            ->from('hasil_desiminasi h')
            ->where('h.mahasiswa_id', $mahasiswa_id)
            ->where('h.status_laporan_akhir', 'disetujui');
        $selesai = $this->db->get()->row();

        if ($selesai) {
            $status = 'selesai_magang';
        } else {
            // 2. Cek Sedang Magang (punya logbook minimal 1 ATAU dosen_dpl_id terisi ATAU proposal di-ACC kaprodi & status_mitra = diterima)
            $this->db->where('mahasiswa_id', $mahasiswa_id);
            $logbook_count = $this->db->count_all_results('logbook_magang');

            if ($logbook_count > 0 || $mahasiswa->dosen_dpl_id) {
                $status = 'sedang_magang';
            } else {
                $this->db->select('proposal_id')
                    ->from('proposal_magang')
                    ->where('mahasiswa_id', $mahasiswa_id)
                    ->where('status_kaprodi', 'disetujui')
                    ->group_start()
                        ->where('status_mitra', 'diterima')
                        ->or_where('link_surat_penerimaan IS NOT NULL')
                    ->group_end();
                $proposal_diterima = $this->db->get()->row();

                if ($proposal_diterima) {
                    $status = 'sedang_magang';
                } else {
                    // 3. Default: Belum Magang
                    $status = 'belum_magang';
                }
            }
        }

        // Only update database if status changed
        if ($mahasiswa->status_magang !== $status) {
            $this->db->where('mahasiswa_id', $mahasiswa_id)
                ->update($this->table, [
                    'status_magang' => $status,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
        }

        return $status;
    }

    public function sync_all_statuses()
    {
        $mahasiswa = $this->db->select('mahasiswa_id')->get($this->table)->result();
        foreach ($mahasiswa as $m) {
            $this->sync_status_magang($m->mahasiswa_id);
        }
    }
}

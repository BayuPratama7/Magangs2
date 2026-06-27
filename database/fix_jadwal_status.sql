-- =====================================================
-- FIX: Update jadwal_desiminasi status
-- Jadwal yang pengujinya sudah bersedia tapi status jadwal masih 'menunggu_konfirmasi'
-- harus diupdate ke 'terkonfirmasi'
-- =====================================================

-- Update jadwal yang pengujinya sudah bersedia → status harus 'terkonfirmasi'
UPDATE jadwal_desiminasi j
SET status = 'terkonfirmasi', updated_at = NOW()
FROM desiminasi d
WHERE d.desiminasi_id = j.desiminasi_id
  AND d.konfirmasi_penguji = 'bersedia'
  AND j.status = 'menunggu_konfirmasi';

-- Verifikasi
SELECT j.jadwal_id, j.status, d.konfirmasi_penguji, m.nama_mahasiswa
FROM jadwal_desiminasi j
JOIN desiminasi d ON d.desiminasi_id = j.desiminasi_id
JOIN mahasiswa m ON m.mahasiswa_id = j.mahasiswa_id
ORDER BY j.jadwal_id;

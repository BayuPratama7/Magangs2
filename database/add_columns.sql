-- Add missing columns to proposal_magang table
ALTER TABLE proposal_magang 
ADD COLUMN IF NOT EXISTS status_mitra VARCHAR(20) DEFAULT 'menunggu' CHECK (status_mitra IN ('menunggu', 'diterima', 'ditolak')),
ADD COLUMN IF NOT EXISTS tanggal_balasan_mitra TIMESTAMP;

-- Add missing column to proposal_magang table
ALTER TABLE proposal_magang
ADD COLUMN IF NOT EXISTS butuh_surat_pengantar SMALLINT DEFAULT 1 CHECK (butuh_surat_pengantar IN (0, 1));

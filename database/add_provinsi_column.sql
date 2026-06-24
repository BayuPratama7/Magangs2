-- Add provinsi column to proposal_magang table
ALTER TABLE proposal_magang
ADD COLUMN IF NOT EXISTS provinsi VARCHAR(100);

-- =====================================================
-- MULTI-ROLE MIGRATION
-- Sistem Pengelolaan Magang - PostgreSQL
-- SAFE: Tidak menghapus tabel/kolom existing
-- =====================================================

-- 1. Tambah kolom jabatan di tabel users
ALTER TABLE users ADD COLUMN IF NOT EXISTS jabatan VARCHAR(20);

-- 2. Buat tabel pivot user_roles
CREATE TABLE IF NOT EXISTS user_roles (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES users(user_id) ON DELETE CASCADE,
    role_id INTEGER NOT NULL REFERENCES roles(role_id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(user_id, role_id)
);

CREATE INDEX IF NOT EXISTS idx_user_roles_user ON user_roles(user_id);
CREATE INDEX IF NOT EXISTS idx_user_roles_role ON user_roles(role_id);

-- 3. Populate jabatan dari role_id existing
UPDATE users SET jabatan = 'kaprodi'     WHERE role_id = 1 AND jabatan IS NULL;
UPDATE users SET jabatan = 'koordinator' WHERE role_id = 2 AND jabatan IS NULL;
UPDATE users SET jabatan = 'sekretaris'  WHERE role_id = 3 AND jabatan IS NULL;
UPDATE users SET jabatan = 'dosen'       WHERE role_id = 4 AND jabatan IS NULL;
UPDATE users SET jabatan = 'mahasiswa'   WHERE role_id = 5 AND jabatan IS NULL;
UPDATE users SET jabatan = 'dosen'       WHERE role_id = 6 AND jabatan IS NULL;

-- 4. Populate user_roles sesuai aturan jabatan
-- Mahasiswa → mahasiswa saja
INSERT INTO user_roles (user_id, role_id)
SELECT user_id, 5 FROM users WHERE jabatan = 'mahasiswa'
ON CONFLICT (user_id, role_id) DO NOTHING;

-- Dosen → dosen + penguji
INSERT INTO user_roles (user_id, role_id)
SELECT user_id, 4 FROM users WHERE jabatan = 'dosen'
ON CONFLICT (user_id, role_id) DO NOTHING;

INSERT INTO user_roles (user_id, role_id)
SELECT user_id, 6 FROM users WHERE jabatan = 'dosen'
ON CONFLICT (user_id, role_id) DO NOTHING;

-- Sekretaris → sekretaris + dosen + penguji
INSERT INTO user_roles (user_id, role_id)
SELECT user_id, 3 FROM users WHERE jabatan = 'sekretaris'
ON CONFLICT (user_id, role_id) DO NOTHING;

INSERT INTO user_roles (user_id, role_id)
SELECT user_id, 4 FROM users WHERE jabatan = 'sekretaris'
ON CONFLICT (user_id, role_id) DO NOTHING;

INSERT INTO user_roles (user_id, role_id)
SELECT user_id, 6 FROM users WHERE jabatan = 'sekretaris'
ON CONFLICT (user_id, role_id) DO NOTHING;

-- Koordinator → koordinator + dosen + penguji
INSERT INTO user_roles (user_id, role_id)
SELECT user_id, 2 FROM users WHERE jabatan = 'koordinator'
ON CONFLICT (user_id, role_id) DO NOTHING;

INSERT INTO user_roles (user_id, role_id)
SELECT user_id, 4 FROM users WHERE jabatan = 'koordinator'
ON CONFLICT (user_id, role_id) DO NOTHING;

INSERT INTO user_roles (user_id, role_id)
SELECT user_id, 6 FROM users WHERE jabatan = 'koordinator'
ON CONFLICT (user_id, role_id) DO NOTHING;

-- Kaprodi → kaprodi + dosen + penguji
INSERT INTO user_roles (user_id, role_id)
SELECT user_id, 1 FROM users WHERE jabatan = 'kaprodi'
ON CONFLICT (user_id, role_id) DO NOTHING;

INSERT INTO user_roles (user_id, role_id)
SELECT user_id, 4 FROM users WHERE jabatan = 'kaprodi'
ON CONFLICT (user_id, role_id) DO NOTHING;

INSERT INTO user_roles (user_id, role_id)
SELECT user_id, 6 FROM users WHERE jabatan = 'kaprodi'
ON CONFLICT (user_id, role_id) DO NOTHING;

-- 5. Buat record dosen untuk sekretaris/koordinator/kaprodi
-- (Agar bisa akses fitur DPL & Penguji tanpa error)
INSERT INTO dosen (user_id, nama_dosen, is_dpl, is_penguji, created_at)
SELECT u.user_id, u.nama_lengkap, TRUE, TRUE, NOW()
FROM users u
WHERE u.jabatan IN ('sekretaris', 'koordinator', 'kaprodi')
AND NOT EXISTS (SELECT 1 FROM dosen d WHERE d.user_id = u.user_id);

-- Done!
SELECT 'Multi-role migration completed!' as status;

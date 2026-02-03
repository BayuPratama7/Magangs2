-- =====================================================
-- SISTEM PENGELOLAAN MAGANG PRODI SISTEM INFORMASI
-- Database Migration Script for PostgreSQL
-- =====================================================
-- CATATAN: Script ini akan DROP semua tabel yang ada dan membuat ulang

-- DROP EXISTING TABLES (dalam urutan yang benar karena foreign key)
DROP TABLE IF EXISTS notifikasi CASCADE;
DROP TABLE IF EXISTS sebaran_magang CASCADE;
DROP TABLE IF EXISTS mitra_kerjasama CASCADE;
DROP TABLE IF EXISTS hasil_desiminasi CASCADE;
DROP TABLE IF EXISTS jadwal_desiminasi CASCADE;
DROP TABLE IF EXISTS desiminasi CASCADE;
DROP TABLE IF EXISTS laporan_magang CASCADE;
DROP TABLE IF EXISTS logbook_magang CASCADE;
DROP TABLE IF EXISTS surat_pengantar CASCADE;
DROP TABLE IF EXISTS proposal_magang CASCADE;
DROP TABLE IF EXISTS mahasiswa CASCADE;
DROP TABLE IF EXISTS dosen CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS roles CASCADE;

-- 1. ROLES TABLE
-- =====================================================
CREATE TABLE roles (
    role_id SERIAL PRIMARY KEY,
    nama_role VARCHAR(50) NOT NULL UNIQUE,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default roles
INSERT INTO roles (role_id, nama_role, deskripsi) VALUES 
(1, 'Ketua Program Studi', 'Kaprodi - ACC tahap 2 proposal'),
(2, 'Koordinator Pengelola Magang', 'ACC tahap 1 proposal, monitoring logbook'),
(3, 'Sekretaris Program Studi', 'Administrasi magang lengkap'),
(4, 'Dosen Pembimbing Lapangan', 'DPL - Review logbook & laporan mahasiswa'),
(5, 'Mahasiswa', 'Peserta magang'),
(6, 'Penguji Desiminasi', 'Review & ACC laporan akhir');

-- 2. USERS TABLE
-- =====================================================
CREATE TABLE users (
    user_id SERIAL PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    role_id INTEGER REFERENCES roles(role_id),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. DOSEN TABLE
-- =====================================================
CREATE TABLE dosen (
    dosen_id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(user_id) ON DELETE CASCADE,
    nidn VARCHAR(20) UNIQUE,
    nama_dosen VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    no_hp VARCHAR(20),
    bidang_keahlian VARCHAR(100),
    is_dpl BOOLEAN DEFAULT FALSE,
    is_penguji BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. MAHASISWA TABLE
-- =====================================================
CREATE TABLE mahasiswa (
    mahasiswa_id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(user_id) ON DELETE CASCADE,
    nim VARCHAR(20) UNIQUE NOT NULL,
    nama_mahasiswa VARCHAR(100) NOT NULL,
    prodi VARCHAR(50) DEFAULT 'Sistem Informasi',
    angkatan INTEGER,
    kelas VARCHAR(10),
    no_hp VARCHAR(20),
    alamat TEXT,
    dosen_dpl_id INTEGER REFERENCES dosen(dosen_id),
    status_magang VARCHAR(30) DEFAULT 'belum_magang',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. PROPOSAL MAGANG TABLE
-- =====================================================
CREATE TABLE proposal_magang (
    proposal_id SERIAL PRIMARY KEY,
    mahasiswa_id INTEGER REFERENCES mahasiswa(mahasiswa_id) ON DELETE CASCADE,
    judul_proposal VARCHAR(255) NOT NULL,
    instansi_tujuan VARCHAR(200) NOT NULL,
    alamat_instansi TEXT,
    jenis_magang VARCHAR(20) NOT NULL CHECK (jenis_magang IN ('reguler', 'bumn', 'mbkm')),
    tanggal_mulai DATE,
    tanggal_selesai DATE,
    tanggal_pengajuan DATE DEFAULT CURRENT_DATE,
    link_proposal VARCHAR(500),
    link_surat_penerimaan VARCHAR(500),
    status_koordinator VARCHAR(20) DEFAULT 'menunggu' CHECK (status_koordinator IN ('menunggu', 'disetujui', 'ditolak')),
    catatan_koordinator TEXT,
    tanggal_acc_koordinator TIMESTAMP,
    status_kaprodi VARCHAR(20) DEFAULT 'menunggu' CHECK (status_kaprodi IN ('menunggu', 'disetujui', 'ditolak')),
    catatan_kaprodi TEXT,
    tanggal_acc_kaprodi TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 6. SURAT PENGANTAR TABLE
-- =====================================================
CREATE TABLE surat_pengantar (
    surat_id SERIAL PRIMARY KEY,
    proposal_id INTEGER REFERENCES proposal_magang(proposal_id) ON DELETE CASCADE,
    mahasiswa_id INTEGER REFERENCES mahasiswa(mahasiswa_id),
    nomor_surat VARCHAR(50) UNIQUE,
    tanggal_surat DATE DEFAULT CURRENT_DATE,
    perihal VARCHAR(200),
    tujuan_instansi VARCHAR(200),
    file_surat VARCHAR(500),
    created_by INTEGER REFERENCES users(user_id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 7. LOGBOOK MAGANG TABLE
-- =====================================================
CREATE TABLE logbook_magang (
    logbook_id SERIAL PRIMARY KEY,
    mahasiswa_id INTEGER REFERENCES mahasiswa(mahasiswa_id) ON DELETE CASCADE,
    proposal_id INTEGER REFERENCES proposal_magang(proposal_id),
    bulan_ke INTEGER NOT NULL CHECK (bulan_ke BETWEEN 1 AND 3),
    link_logbook VARCHAR(500) NOT NULL,
    tanggal_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status_dpl VARCHAR(20) DEFAULT 'belum_review' CHECK (status_dpl IN ('belum_review', 'sudah_review', 'revisi')),
    catatan_dpl TEXT,
    tanggal_review_dpl TIMESTAMP,
    status_koordinator VARCHAR(20) DEFAULT 'belum_review' CHECK (status_koordinator IN ('belum_review', 'sudah_review')),
    tanggal_review_koordinator TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(mahasiswa_id, bulan_ke)
);

-- 8. LAPORAN MAGANG TABLE
-- =====================================================
CREATE TABLE laporan_magang (
    laporan_id SERIAL PRIMARY KEY,
    mahasiswa_id INTEGER REFERENCES mahasiswa(mahasiswa_id) ON DELETE CASCADE,
    proposal_id INTEGER REFERENCES proposal_magang(proposal_id),
    jenis_laporan VARCHAR(30) NOT NULL CHECK (jenis_laporan IN ('draft', 'final', 'revisi')),
    link_laporan VARCHAR(500) NOT NULL,
    tanggal_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status_dpl VARCHAR(20) DEFAULT 'menunggu' CHECK (status_dpl IN ('menunggu', 'disetujui', 'revisi')),
    catatan_dpl TEXT,
    tanggal_review_dpl TIMESTAMP,
    is_acc_desiminasi BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 9. DESIMINASI TABLE
-- =====================================================
CREATE TABLE desiminasi (
    desiminasi_id SERIAL PRIMARY KEY,
    mahasiswa_id INTEGER REFERENCES mahasiswa(mahasiswa_id) ON DELETE CASCADE,
    proposal_id INTEGER REFERENCES proposal_magang(proposal_id),
    laporan_id INTEGER REFERENCES laporan_magang(laporan_id),
    penguji_id INTEGER REFERENCES dosen(dosen_id),
    status_pengajuan VARCHAR(20) DEFAULT 'menunggu' CHECK (status_pengajuan IN ('menunggu', 'diterima', 'ditolak')),
    tanggal_pengajuan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    konfirmasi_penguji VARCHAR(20) DEFAULT 'menunggu' CHECK (konfirmasi_penguji IN ('menunggu', 'bersedia', 'tidak_bersedia')),
    tanggal_konfirmasi TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 10. JADWAL DESIMINASI TABLE
-- =====================================================
CREATE TABLE jadwal_desiminasi (
    jadwal_id SERIAL PRIMARY KEY,
    desiminasi_id INTEGER REFERENCES desiminasi(desiminasi_id) ON DELETE CASCADE,
    mahasiswa_id INTEGER REFERENCES mahasiswa(mahasiswa_id),
    tanggal_desiminasi DATE NOT NULL,
    waktu_mulai TIME NOT NULL,
    waktu_selesai TIME,
    ruangan VARCHAR(50),
    link_online VARCHAR(500),
    status VARCHAR(20) DEFAULT 'terjadwal' CHECK (status IN ('terjadwal', 'selesai', 'batal')),
    created_by INTEGER REFERENCES users(user_id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 11. HASIL DESIMINASI TABLE
-- =====================================================
CREATE TABLE hasil_desiminasi (
    hasil_id SERIAL PRIMARY KEY,
    desiminasi_id INTEGER REFERENCES desiminasi(desiminasi_id) ON DELETE CASCADE,
    mahasiswa_id INTEGER REFERENCES mahasiswa(mahasiswa_id),
    nilai DECIMAL(5,2),
    status_kelulusan VARCHAR(20) CHECK (status_kelulusan IN ('lulus', 'tidak_lulus', 'lulus_bersyarat')),
    catatan_revisi TEXT,
    link_laporan_akhir VARCHAR(500),
    status_laporan_akhir VARCHAR(20) DEFAULT 'menunggu' CHECK (status_laporan_akhir IN ('menunggu', 'disetujui', 'revisi')),
    catatan_penguji TEXT,
    tanggal_acc_laporan_akhir TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 12. MITRA KERJASAMA TABLE
-- =====================================================
CREATE TABLE mitra_kerjasama (
    mitra_id SERIAL PRIMARY KEY,
    nama_mitra VARCHAR(200) NOT NULL,
    jenis_mitra VARCHAR(50),
    alamat TEXT,
    kota VARCHAR(100),
    provinsi VARCHAR(100),
    website VARCHAR(200),
    email_kontak VARCHAR(100),
    no_telp VARCHAR(20),
    deskripsi TEXT,
    logo VARCHAR(500),
    is_active BOOLEAN DEFAULT TRUE,
    created_by INTEGER REFERENCES users(user_id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 13. SEBARAN MAGANG TABLE
-- =====================================================
CREATE TABLE sebaran_magang (
    sebaran_id SERIAL PRIMARY KEY,
    periode VARCHAR(20) NOT NULL,
    tahun_akademik VARCHAR(10),
    semester VARCHAR(10),
    wilayah VARCHAR(100) NOT NULL,
    provinsi VARCHAR(100),
    jenis_magang VARCHAR(20) NOT NULL CHECK (jenis_magang IN ('reguler', 'bumn', 'mbkm')),
    jumlah_mahasiswa INTEGER DEFAULT 0,
    nama_instansi VARCHAR(200),
    created_by INTEGER REFERENCES users(user_id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 14. NOTIFIKASI TABLE
-- =====================================================
CREATE TABLE notifikasi (
    notifikasi_id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(user_id) ON DELETE CASCADE,
    judul VARCHAR(200) NOT NULL,
    pesan TEXT,
    link VARCHAR(500),
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================================
-- INDEXES FOR BETTER PERFORMANCE
-- =====================================================
CREATE INDEX idx_users_role ON users(role_id);
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_mahasiswa_user ON mahasiswa(user_id);
CREATE INDEX idx_mahasiswa_nim ON mahasiswa(nim);
CREATE INDEX idx_mahasiswa_dpl ON mahasiswa(dosen_dpl_id);
CREATE INDEX idx_dosen_user ON dosen(user_id);
CREATE INDEX idx_proposal_mahasiswa ON proposal_magang(mahasiswa_id);
CREATE INDEX idx_proposal_status ON proposal_magang(status_koordinator, status_kaprodi);
CREATE INDEX idx_logbook_mahasiswa ON logbook_magang(mahasiswa_id);
CREATE INDEX idx_laporan_mahasiswa ON laporan_magang(mahasiswa_id);
CREATE INDEX idx_desiminasi_mahasiswa ON desiminasi(mahasiswa_id);
CREATE INDEX idx_jadwal_tanggal ON jadwal_desiminasi(tanggal_desiminasi);
CREATE INDEX idx_sebaran_periode ON sebaran_magang(periode);
CREATE INDEX idx_notifikasi_user ON notifikasi(user_id, is_read);

-- =====================================================
-- SAMPLE DATA FOR TESTING
-- Password: password123 (hashed)
-- =====================================================

INSERT INTO users (email, password, nama_lengkap, role_id) VALUES
('kaprodi@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Dr. Ahmad Kaprodi', 1),
('koordinator@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Koordinator Magang', 2),
('sekretaris@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Sekretaris Prodi', 3),
('dpl@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Dosen Pembimbing', 4),
('mhs@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Mahasiswa Test', 5),
('penguji@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Penguji Desiminasi', 6);

-- Sample dosen
INSERT INTO dosen (user_id, nidn, nama_dosen, email, is_dpl, is_penguji) VALUES
((SELECT user_id FROM users WHERE email = 'dpl@magang.test'), '0001018501', 'Dosen Pembimbing', 'dpl@magang.test', TRUE, FALSE),
((SELECT user_id FROM users WHERE email = 'penguji@magang.test'), '0002028502', 'Penguji Desiminasi', 'penguji@magang.test', FALSE, TRUE);

-- Sample mahasiswa
INSERT INTO mahasiswa (user_id, nim, nama_mahasiswa, prodi, angkatan, kelas) VALUES
((SELECT user_id FROM users WHERE email = 'mhs@magang.test'), '202110370311001', 'Mahasiswa Test', 'Sistem Informasi', 2021, 'A');

-- Sample mitra kerjasama
INSERT INTO mitra_kerjasama (nama_mitra, jenis_mitra, kota, provinsi, deskripsi) VALUES
('PT Telekomunikasi Indonesia', 'BUMN', 'Bandung', 'Jawa Barat', 'Telkom Indonesia'),
('PT Bank Rakyat Indonesia', 'BUMN', 'Jakarta', 'DKI Jakarta', 'BRI'),
('Tokopedia', 'Startup', 'Jakarta', 'DKI Jakarta', 'E-commerce'),
('Gojek', 'Startup', 'Jakarta', 'DKI Jakarta', 'Super App'),
('Dinas Kominfo Malang', 'Instansi Pemerintah', 'Malang', 'Jawa Timur', 'Dinas Komunikasi dan Informatika');

-- Sample sebaran magang
INSERT INTO sebaran_magang (periode, tahun_akademik, semester, wilayah, provinsi, jenis_magang, jumlah_mahasiswa) VALUES
('2024/2025 Ganjil', '2024/2025', 'Ganjil', 'Jakarta', 'DKI Jakarta', 'reguler', 15),
('2024/2025 Ganjil', '2024/2025', 'Ganjil', 'Surabaya', 'Jawa Timur', 'reguler', 12),
('2024/2025 Ganjil', '2024/2025', 'Ganjil', 'Malang', 'Jawa Timur', 'mbkm', 8),
('2024/2025 Ganjil', '2024/2025', 'Ganjil', 'Bandung', 'Jawa Barat', 'bumn', 10),
('2024/2025 Ganjil', '2024/2025', 'Ganjil', 'Yogyakarta', 'DIY', 'reguler', 6);

-- Done!
SELECT 'Migration completed successfully!' as status;

-- ==============================================
-- SQL Script untuk membuat user Mahasiswa baru untuk testing
-- Jalankan script ini di pgAdmin atau database client lainnya
-- ==============================================

-- Password: password (sudah di-hash dengan bcrypt)
-- Role ID 5 = Mahasiswa

-- 1. Insert ke tabel users
INSERT INTO users (username, password, email, role_id, is_active) 
VALUES (
    'mhs_test2', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    'mhstest2@mail.com', 
    5, 
    TRUE
);

-- 2. Insert ke tabel mahasiswa (ganti user_id sesuai hasil insert di atas)
-- Jalankan query ini setelah mendapat user_id dari insert di atas
INSERT INTO mahasiswa (user_id, nim, nama_mahasiswa, prodi, angkatan, kelas, no_hp, alamat, status_magang) 
VALUES (
    (SELECT user_id FROM users WHERE username = 'mhs_test2'),
    '20211037031102',
    'Mahasiswa Test Dua',
    'Sistem Informasi',
    2021,
    'A',
    '081234567891',
    'Alamat Test',
    'belum_magang'
);

-- ==============================================
-- INFORMASI LOGIN:
-- Username: mhs_test2
-- Password: password
-- NIM: 20211037031102
-- ==============================================

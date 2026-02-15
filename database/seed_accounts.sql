-- Reset mhstest2
DO $$
DECLARE
  v_user_id INT;
  v_mhs_id INT;
BEGIN
  SELECT user_id INTO v_user_id FROM users WHERE email = 'mhstest2@mail.com';
  IF v_user_id IS NOT NULL THEN
    SELECT mahasiswa_id INTO v_mhs_id FROM mahasiswa WHERE user_id = v_user_id;
    IF v_mhs_id IS NOT NULL THEN
      DELETE FROM hasil_desiminasi WHERE mahasiswa_id = v_mhs_id;
      DELETE FROM jadwal_desiminasi WHERE mahasiswa_id = v_mhs_id;
      DELETE FROM desiminasi WHERE mahasiswa_id = v_mhs_id;
      DELETE FROM logbook WHERE mahasiswa_id = v_mhs_id;
      DELETE FROM laporan_magang WHERE mahasiswa_id = v_mhs_id;
      DELETE FROM surat_pengantar WHERE mahasiswa_id = v_mhs_id;
      DELETE FROM proposal_magang WHERE mahasiswa_id = v_mhs_id;
      DELETE FROM mahasiswa WHERE mahasiswa_id = v_mhs_id;
    END IF;
    DELETE FROM user_roles WHERE user_id = v_user_id;
    DELETE FROM users WHERE user_id = v_user_id;
  END IF;
END $$;

-- Buat 4 akun mahasiswa (password: password123)
INSERT INTO users (email, password, nama_lengkap, role_id, jabatan, is_active, created_at)
VALUES
('mahasiswa1@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Mahasiswa Satu', 5, 'mahasiswa', TRUE, NOW()),
('mahasiswa2@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Mahasiswa Dua', 5, 'mahasiswa', TRUE, NOW()),
('mahasiswa3@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Mahasiswa Tiga', 5, 'mahasiswa', TRUE, NOW()),
('mahasiswa4@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Mahasiswa Empat', 5, 'mahasiswa', TRUE, NOW());

-- Buat record mahasiswa
INSERT INTO mahasiswa (user_id, nim, nama_mahasiswa, prodi, angkatan, kelas, status_magang, created_at)
SELECT user_id, 'NIM00' || user_id, nama_lengkap, 'Sistem Informasi', 2024, 'A', 'belum_magang', NOW()
FROM users WHERE email IN ('mahasiswa1@magang.test','mahasiswa2@magang.test','mahasiswa3@magang.test','mahasiswa4@magang.test');

-- Assign role mahasiswa
INSERT INTO user_roles (user_id, role_id)
SELECT user_id, 5 FROM users WHERE email IN ('mahasiswa1@magang.test','mahasiswa2@magang.test','mahasiswa3@magang.test','mahasiswa4@magang.test')
ON CONFLICT (user_id, role_id) DO NOTHING;

-- Buat 2 akun dosen (password: password123)
INSERT INTO users (email, password, nama_lengkap, role_id, jabatan, is_active, created_at)
VALUES
('dosen1@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Dosen Satu', 4, 'dosen', TRUE, NOW()),
('dosen2@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Dosen Dua', 4, 'dosen', TRUE, NOW());

-- Buat record dosen
INSERT INTO dosen (user_id, nama_dosen, is_dpl, is_penguji, created_at)
SELECT user_id, nama_lengkap, TRUE, TRUE, NOW()
FROM users WHERE email IN ('dosen1@magang.test','dosen2@magang.test');

-- Assign role dosen + penguji
INSERT INTO user_roles (user_id, role_id)
SELECT user_id, 4 FROM users WHERE email IN ('dosen1@magang.test','dosen2@magang.test')
ON CONFLICT (user_id, role_id) DO NOTHING;

INSERT INTO user_roles (user_id, role_id)
SELECT user_id, 6 FROM users WHERE email IN ('dosen1@magang.test','dosen2@magang.test')
ON CONFLICT (user_id, role_id) DO NOTHING;

SELECT 'Semua akun berhasil dibuat!' as status;

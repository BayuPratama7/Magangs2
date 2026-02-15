# Walkthrough: Multi-Role Authentication

## Mapping Jabatan → Role

| Jabatan Akademik       | Role yang Aktif                |
|------------------------|--------------------------------|
| Sekretaris Prodi       | Sekretaris + DPL + Penguji     |
| Koordinator Magang     | Koordinator + DPL + Penguji    |
| Kaprodi                | Kaprodi + DPL + Penguji        |
| Dosen biasa            | DPL + Penguji                  |
| Mahasiswa              | Mahasiswa                      |

Tanpa menghapus role lama.

> Dosen biasa langsung punya akses **semua fitur DPL + Penguji** dalam satu sidebar, tanpa perlu switch role.

---

## Sidebar Dosen

Dosen login → sidebar menampilkan:

**Pembimbing:**
- Mahasiswa Bimbingan
- Review Logbook
- Review Laporan
- Jadwal Desiminasi

**Penguji:**
- Konfirmasi Menguji
- ACC Laporan Akhir

---

## Cara Test

1. Jalankan `multi_role_migration.sql` di PostgreSQL
2. Login `dpl@magang.test` (password: `password123`)
3. Sidebar harus tampil menu DPL **dan** Penguji sekaligus
4. Akses `dosen/bimbingan` → harus bisa
5. Akses `penguji/konfirmasi` → harus bisa juga

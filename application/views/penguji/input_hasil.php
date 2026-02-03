<!-- Penguji Input Hasil View -->
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1">Input Hasil Desiminasi</h4>
            <p class="text-muted mb-0">Masukkan nilai dan status kelulusan mahasiswa</p>
        </div>
        <a href="<?= base_url('penguji/jadwal') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-person me-2"></i><?= $desiminasi->nama_mahasiswa ?> (<?= $desiminasi->nim ?>)
            </div>
            <div class="card-body">
                <form method="post" action="<?= base_url('penguji/simpan_hasil/' . $hasil->hasil_id) ?>">
                    <div class="mb-4">
                        <label class="form-label"><strong>Nilai</strong></label>
                        <input type="number" name="nilai" class="form-control form-control-lg text-center" min="0"
                            max="100" value="<?= $hasil->nilai ?? '' ?>" required>
                        <small class="text-muted">Masukkan nilai 0-100</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label"><strong>Status Kelulusan</strong></label>
                        <div class="row g-2">
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="status_kelulusan" value="lulus" id="lulus"
                                    <?= ($hasil->status_kelulusan ?? '') == 'lulus' ? 'checked' : '' ?> required>
                                <label class="btn btn-outline-success w-100" for="lulus">
                                    <i class="bi bi-check-circle d-block fs-4"></i>
                                    Lulus
                                </label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="status_kelulusan" value="lulus_bersyarat"
                                    id="lulusBersyarat" <?= ($hasil->status_kelulusan ?? '') == 'lulus_bersyarat' ? 'checked' : '' ?>>
                                <label class="btn btn-outline-warning w-100" for="lulusBersyarat">
                                    <i class="bi bi-exclamation-circle d-block fs-4"></i>
                                    Lulus Bersyarat
                                </label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="status_kelulusan" value="tidak_lulus"
                                    id="tidakLulus" <?= ($hasil->status_kelulusan ?? '') == 'tidak_lulus' ? 'checked' : '' ?>>
                                <label class="btn btn-outline-danger w-100" for="tidakLulus">
                                    <i class="bi bi-x-circle d-block fs-4"></i>
                                    Tidak Lulus
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label"><strong>Catatan Revisi</strong></label>
                        <textarea name="catatan_revisi" class="form-control" rows="4"
                            placeholder="Catatan untuk perbaikan laporan akhir..."><?= $hasil->catatan_revisi ?? '' ?></textarea>
                        <small class="text-muted">Wajib diisi jika Lulus Bersyarat atau Tidak Lulus</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-save me-2"></i>Simpan Hasil
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
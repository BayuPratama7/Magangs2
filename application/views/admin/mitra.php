<!-- Admin Mitra View -->
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1">Kelola Mitra Kerjasama</h4>
            <p class="text-muted mb-0">Data mitra kerjasama magang Prodi Sistem Informasi</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMitraModal">
            <i class="bi bi-plus-lg me-2"></i>Tambah Mitra
        </button>
    </div>
</div>

<div class="row g-4">
    <?php if (!empty($mitra_list)): ?>
        <?php foreach ($mitra_list as $m): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span
                                class="badge bg-<?= $m->jenis_mitra == 'BUMN' ? 'primary' : ($m->jenis_mitra == 'Startup' ? 'success' : 'secondary') ?>">
                                <?= $m->jenis_mitra ?>
                            </span>
                            <a href="<?= base_url('admin/delete_mitra/' . $m->mitra_id) ?>" class="text-danger"
                                onclick="return confirm('Hapus mitra ini?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                        <h5 class="card-title"><?= $m->nama_mitra ?></h5>
                        <p class="card-text text-muted small">
                            <i class="bi bi-geo-alt me-1"></i><?= $m->kota ?>, <?= $m->provinsi ?>
                        </p>
                        <?php if ($m->website): ?>
                            <a href="<?= $m->website ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-globe me-1"></i>Website
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-building display-1 text-muted"></i>
                    <p class="text-muted mt-3">Belum ada data mitra kerjasama</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Add Mitra Modal -->
<div class="modal fade" id="addMitraModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Mitra Kerjasama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="<?= base_url('admin/create_mitra') ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Mitra</label>
                        <input type="text" name="nama_mitra" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Mitra</label>
                        <select name="jenis_mitra" class="form-select" required>
                            <option value="Perusahaan">Perusahaan Swasta</option>
                            <option value="BUMN">BUMN</option>
                            <option value="Startup">Startup</option>
                            <option value="Instansi Pemerintah">Instansi Pemerintah</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kota</label>
                            <input type="text" name="kota" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="provinsi" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Website</label>
                        <input type="url" name="website" class="form-control" placeholder="https://...">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email_kontak" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. Telp</label>
                            <input type="text" name="no_telp" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Admin Sebaran View -->
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1">Kelola Sebaran Magang</h4>
            <p class="text-muted mb-0">Data sebaran mahasiswa magang berdasarkan wilayah dan jenis</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSebaranModal">
            <i class="bi bi-plus-lg me-2"></i>Tambah Data
        </button>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <i class="bi bi-geo-alt me-2"></i>Data Sebaran Magang
        </div>
        <form method="get" action="<?= base_url('admin/sebaran') ?>" class="d-flex align-items-center">
            <select name="tahun_akademik" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                <option value="">-- Semua Tahun Akademik --</option>
                <?php if (isset($tahun_akademik_list)): ?>
                    <?php foreach ($tahun_akademik_list as $ta): ?>
                        <option value="<?= $ta->tahun_akademik ?>" <?= (isset($selected_tahun) && $selected_tahun == $ta->tahun_akademik) ? 'selected' : '' ?>>
                            <?= $ta->tahun_akademik ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <select name="jenis_magang" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">-- Semua Jenis --</option>
                <option value="reguler" <?= (isset($selected_jenis) && $selected_jenis == 'reguler') ? 'selected' : '' ?>>Reguler</option>
                <option value="bumn" <?= (isset($selected_jenis) && $selected_jenis == 'bumn') ? 'selected' : '' ?>>BUMN</option>
                <option value="mbkm" <?= (isset($selected_jenis) && $selected_jenis == 'mbkm') ? 'selected' : '' ?>>MBKM</option>
            </select>
        </form>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($sebaran_list)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Tahun Akademik</th>
                            <th>Provinsi</th>
                            <th>Jenis Magang</th>
                            <th>Jumlah</th>
                            <th>Instansi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sebaran_list as $s): ?>
                            <tr>
                                <td><?= $s->tahun_akademik ?></td>
                                <td><?= $s->provinsi ?></td>
                                <td><span class="badge bg-secondary"><?= strtoupper($s->jenis_magang) ?></span></td>
                                <td><strong><?= $s->jumlah_mahasiswa ?></strong></td>
                                <td><small><?= $s->nama_instansi ?></small></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#editSebaranModal<?= $s->sebaran_id ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <a href="<?= base_url('admin/delete_sebaran/' . $s->sebaran_id) ?>"
                                        class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-geo display-1 text-muted"></i>
                <p class="text-muted mt-3">Belum ada data sebaran</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add Sebaran Modal -->
<div class="modal fade" id="addSebaranModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Sebaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="<?= base_url('admin/create_sebaran') ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Tahun Akademik</label>
                            <input type="text" name="tahun_akademik" class="form-control" placeholder="2024/2025"
                                required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <select name="semester" class="form-select" required>
                            <option value="ganjil">Ganjil</option>
                            <option value="genap">Genap</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Provinsi</label>
                            <select name="provinsi" class="form-select" required>
                                <option value="">-- Pilih Provinsi --</option>
                                <?php if (isset($provinsi_list) && !empty($provinsi_list)): ?>
                                    <?php foreach ($provinsi_list as $p): ?>
                                        <option value="<?= $p->nama_provinsi ?>"><?= $p->nama_provinsi ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Magang</label>
                            <select name="jenis_magang" class="form-select" required>
                                <option value="reguler">Reguler</option>
                                <option value="bumn">BUMN</option>
                                <option value="mbkm">MBKM</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah Mahasiswa</label>
                            <input type="number" name="jumlah_mahasiswa" class="form-control" min="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Instansi (Optional)</label>
                        <input type="text" name="nama_instansi" class="form-control">
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

<!-- Edit Sebaran Modals -->
<?php if (!empty($sebaran_list)): ?>
    <?php foreach ($sebaran_list as $s): ?>
        <div class="modal fade" id="editSebaranModal<?= $s->sebaran_id ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Sebaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post" action="<?= base_url('admin/edit_sebaran/' . $s->sebaran_id) ?>">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Tahun Akademik</label>
                                    <input type="text" name="tahun_akademik" class="form-control" value="<?= htmlspecialchars($s->tahun_akademik) ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Provinsi</label>
                                    <select name="provinsi" class="form-select" required>
                                        <option value="">-- Pilih Provinsi --</option>
                                        <?php if (isset($provinsi_list) && !empty($provinsi_list)): ?>
                                            <?php foreach ($provinsi_list as $p): ?>
                                                <option value="<?= $p->nama_provinsi ?>" <?= ($s->provinsi == $p->nama_provinsi) ? 'selected' : '' ?>><?= $p->nama_provinsi ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Magang</label>
                                    <select name="jenis_magang" class="form-select" required>
                                        <option value="reguler" <?= (strtolower($s->jenis_magang) == 'reguler') ? 'selected' : '' ?>>Reguler</option>
                                        <option value="bumn" <?= (strtolower($s->jenis_magang) == 'bumn') ? 'selected' : '' ?>>BUMN</option>
                                        <option value="mbkm" <?= (strtolower($s->jenis_magang) == 'mbkm') ? 'selected' : '' ?>>MBKM</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jumlah Mahasiswa</label>
                                    <input type="number" name="jumlah_mahasiswa" class="form-control" min="0" value="<?= $s->jumlah_mahasiswa ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Instansi (Optional)</label>
                                <input type="text" name="nama_instansi" class="form-control" value="<?= htmlspecialchars($s->nama_instansi ?? '') ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
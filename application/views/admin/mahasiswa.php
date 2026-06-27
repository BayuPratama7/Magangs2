<!-- Admin Data Mahasiswa View -->
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="mb-1">Data Mahasiswa</h4>
            <p class="text-muted mb-0">Kelola data mahasiswa Prodi Sistem Informasi</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMahasiswaModal">
            <i class="bi bi-plus-lg me-2"></i>Tambah Mahasiswa
        </button>
    </div>
</div>

<!-- Flash Messages -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i><?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 bg-primary bg-opacity-10">
            <div class="card-body text-center py-3">
                <h3 class="mb-0 text-primary"><?= count($mahasiswa_list) ?></h3>
                <small class="text-muted">Total Mahasiswa</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 bg-warning bg-opacity-10">
            <div class="card-body text-center py-3">
                <h3 class="mb-0 text-warning"><?= count(array_filter($mahasiswa_list, function($m) { return $m->status_magang === 'belum_magang'; })) ?></h3>
                <small class="text-muted">Belum Magang</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 bg-info bg-opacity-10">
            <div class="card-body text-center py-3">
                <h3 class="mb-0 text-info"><?= count(array_filter($mahasiswa_list, function($m) { return $m->status_magang === 'sedang_magang'; })) ?></h3>
                <small class="text-muted">Sedang Magang</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 bg-success bg-opacity-10">
            <div class="card-body text-center py-3">
                <h3 class="mb-0 text-success"><?= count(array_filter($mahasiswa_list, function($m) { return in_array($m->status_magang, ['selesai', 'selesai_magang']); })) ?></h3>
                <small class="text-muted">Selesai Magang</small>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="mahasiswaTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px">No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Angkatan</th>
                        <th>Instansi</th>
                        <th>Status</th>
                        <th style="width: 120px" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($mahasiswa_list)): ?>
                        <?php $no = 1; foreach ($mahasiswa_list as $m): ?>
                            <?php
                            $status_badges = [
                                'belum_magang' => 'secondary',
                                'sedang_magang' => 'primary',
                                'selesai_magang' => 'success',
                                'selesai' => 'success'
                            ];
                            $badge_color = $status_badges[$m->status_magang] ?? 'secondary';
                            $status_label = ucwords(str_replace('_', ' ', $m->status_magang));
                            if ($m->status_magang === 'selesai') $status_label = 'Selesai Magang';
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($m->nim) ?></strong></td>
                                <td><?= htmlspecialchars($m->nama_mahasiswa) ?></td>
                                <td><?= htmlspecialchars($m->angkatan) ?></td>
                                <td><?= htmlspecialchars($m->kelas ?? '-') ?></td>
                                <td>
                                    <span class="badge bg-<?= $badge_color ?>"><?= $status_label ?></span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-info me-1" title="Detail"
                                        data-bs-toggle="modal" data-bs-target="#detailModal<?= $m->mahasiswa_id ?>">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning me-1" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editModal<?= $m->mahasiswa_id ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal<?= $m->mahasiswa_id ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-mortarboard display-4 text-muted d-block mb-3"></i>
                                <p class="text-muted">Belum ada data mahasiswa</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modals di luar tabel -->
<?php if (!empty($mahasiswa_list)): ?>
    <?php foreach ($mahasiswa_list as $m): ?>
        <?php
        $status_badges = [
            'belum_magang' => 'secondary',
            'sedang_magang' => 'primary',
            'selesai_magang' => 'success',
            'selesai' => 'success'
        ];
        $badge_color = $status_badges[$m->status_magang] ?? 'secondary';
        $status_label = ucwords(str_replace('_', ' ', $m->status_magang));
        if ($m->status_magang === 'selesai') $status_label = 'Selesai Magang';
        ?>

        <!-- Detail Modal -->
        <div class="modal fade" id="detailModal<?= $m->mahasiswa_id ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title"><i class="bi bi-person-badge me-2"></i>Detail Mahasiswa</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless mb-0">
                            <tr><th width="140">NIM</th><td><?= htmlspecialchars($m->nim) ?></td></tr>
                            <tr><th>Nama</th><td><?= htmlspecialchars($m->nama_mahasiswa) ?></td></tr>
                            <tr><th>Angkatan</th><td><?= htmlspecialchars($m->angkatan ?? '-') ?></td></tr>
                            <tr><th>Instansi</th><td><?= htmlspecialchars($m->kelas ?? '-') ?></td></tr>
                            <tr><th>Alamat Instansi</th><td><?= htmlspecialchars($m->no_hp ?? '-') ?></td></tr>
                            <tr><th>Status</th><td><span class="badge bg-<?= $badge_color ?>"><?= $status_label ?></span></td></tr>
                            <tr><th>DPL</th><td><?= htmlspecialchars($m->nama_dpl ?? 'Belum ditugaskan') ?></td></tr>
                            <?php if (!empty($m->judul_proposal)): ?>
                                <tr><th>Proposal</th><td><?= htmlspecialchars($m->judul_proposal) ?></td></tr>
                                <tr><th>Instansi</th><td><?= htmlspecialchars($m->instansi_tujuan ?? '-') ?></td></tr>
                            <?php endif; ?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal<?= $m->mahasiswa_id ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Mahasiswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post" action="<?= base_url('admin/mahasiswa_update/' . $m->mahasiswa_id) ?>">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIM <span class="text-danger">*</span></label>
                                    <input type="text" name="nim" class="form-control" value="<?= htmlspecialchars($m->nim) ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Mahasiswa <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_mahasiswa" class="form-control" value="<?= htmlspecialchars($m->nama_mahasiswa) ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Angkatan <span class="text-danger">*</span></label>
                                    <input type="text" name="angkatan" class="form-control" value="<?= htmlspecialchars($m->angkatan) ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Instansi</label>
                                    <input type="text" name="kelas" class="form-control bg-light" placeholder="Nama Instansi" value="<?= htmlspecialchars($m->kelas ?? '') ?>" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Alamat Instansi</label>
                                    <input type="text" name="no_hp" class="form-control bg-light" placeholder="Alamat lengkap instansi" value="<?= htmlspecialchars($m->no_hp ?? '') ?>" disabled>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Magang</label>
                                    <select name="status_magang" class="form-select">
                                        <option value="belum_magang" <?= $m->status_magang === 'belum_magang' ? 'selected' : '' ?>>Belum Magang</option>
                                        <option value="sedang_magang" <?= $m->status_magang === 'sedang_magang' ? 'selected' : '' ?>>Sedang Magang</option>
                                        <option value="selesai_magang" <?= in_array($m->status_magang, ['selesai', 'selesai_magang']) ? 'selected' : '' ?>>Selesai Magang</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-save me-1"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal<?= $m->mahasiswa_id ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data mahasiswa berikut?</p>
                        <div class="alert alert-light border">
                            <strong><?= htmlspecialchars($m->nim) ?></strong> — <?= htmlspecialchars($m->nama_mahasiswa) ?>
                        </div>
                        <p class="text-danger small mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Akun user dan semua data terkait mahasiswa ini akan dihapus secara permanen.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <a href="<?= base_url('admin/mahasiswa_delete/' . $m->mahasiswa_id) ?>" class="btn btn-danger">
                            <i class="bi bi-trash me-1"></i>Hapus
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
<?php endif; ?>

<!-- Add Mahasiswa Modal -->
<div class="modal fade" id="addMahasiswaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Tambah Mahasiswa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="<?= base_url('admin/mahasiswa_store') ?>">
                <div class="modal-body">
                    <h6 class="text-muted mb-3"><i class="bi bi-key me-1"></i> Informasi Akun</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" minlength="6" required>
                        </div>
                    </div>

                    <hr class="my-3">
                    <h6 class="text-muted mb-3"><i class="bi bi-person me-1"></i> Data Mahasiswa</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIM <span class="text-danger">*</span></label>
                            <input type="text" name="nim" class="form-control" placeholder="Nomor Induk Mahasiswa" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_mahasiswa" class="form-control" placeholder="Nama lengkap mahasiswa" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Angkatan <span class="text-danger">*</span></label>
                            <input type="text" name="angkatan" class="form-control" placeholder="2023" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Instansi</label>
                            <input type="text" name="kelas" class="form-control bg-light" placeholder="Diisi oleh mahasiswa" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Alamat Instansi</label>
                            <input type="text" name="no_hp" class="form-control bg-light" placeholder="Diisi oleh mahasiswa" disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    #mahasiswaTable th {
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
</style>

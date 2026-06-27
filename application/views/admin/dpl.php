<!-- Admin DPL View -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Penugasan Dosen Pembimbing Lapangan</h4>
        <p class="text-muted mb-0">Assign DPL untuk mahasiswa yang sudah menerima balasan dari mitra</p>
    </div>
</div>

<div class="row g-4">
    <!-- Pending Assignment -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-plus me-2"></i>Mahasiswa Menunggu DPL
            </div>
            <div class="card-body p-0">
                <?php if (!empty($pending)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Judul Proposal</th>
                                    <th>Instansi</th>
                                    <th>Surat Pengantar</th>
                                    <th>Balasan Mitra</th>
                                    <th>Pilih DPL</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pending as $m): ?>
                                    <tr>
                                        <td><?= $m->nim ?></td>
                                        <td><?= $m->nama_mahasiswa ?></td>
                                        <td><small><?= $m->judul_proposal ?></small></td>
                                        <td><?= $m->instansi_tujuan ?></td>
                                        <td>
                                            <?php if (isset($m->butuh_surat_pengantar) && $m->butuh_surat_pengantar == 0): ?>
                                                <span class="badge bg-info">Tidak Membutuhkan</span>
                                            <?php elseif (!empty($m->file_surat)): ?>
                                                <span class="badge bg-success">Sudah</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Belum</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (isset($m->status_mitra) && $m->status_mitra == 'diterima'): ?>
                                                <span class="badge bg-success">Diterima ✓</span>
                                            <?php elseif (isset($m->status_mitra) && $m->status_mitra == 'ditolak'): ?>
                                                <span class="badge bg-danger">Ditolak</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Menunggu</span>
                                            <?php endif; ?>
                                        </td>
                                        <td colspan="2">
                                            <?php if (isset($m->status_mitra) && $m->status_mitra == 'diterima'): ?>
                                                <form method="post" action="<?= base_url('admin/assign_dpl') ?>" class="d-flex gap-2">
                                                    <input type="hidden" name="mahasiswa_id" value="<?= $m->mahasiswa_id ?>">
                                                    <select name="dosen_id" class="form-select form-select-sm" style="width: auto;" required>
                                                        <option value="">-- Pilih DPL --</option>
                                                        <?php foreach ($dosen_list as $d): ?>
                                                            <option value="<?= $d->dosen_id ?>"><?= $d->nama_dosen ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class="bi bi-check me-1"></i>Assign
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <small class="text-muted">Tunggu balasan mitra</small>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-check-circle display-1 text-success"></i>
                        <p class="text-muted mt-3">Semua mahasiswa sudah memiliki DPL</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Assigned List -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-people me-2"></i>Daftar Penugasan DPL
            </div>
            <div class="card-body p-0">
                <?php if (!empty($assigned)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Instansi</th>
                                    <th>Dosen Pembimbing</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assigned as $m): ?>
                                    <tr>
                                        <td><?= $m->nim ?></td>
                                        <td><?= $m->nama_mahasiswa ?></td>
                                        <td><?= $m->instansi_tujuan ?></td>
                                        <td><span class="badge bg-primary"><?= $m->nama_dpl ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">Belum ada penugasan DPL</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Balasan Mitra Section -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-inbox-check me-2"></i>Balasan Mitra yang Diterima
            </div>
            <div class="card-body p-0">
                <?php if (isset($balasan_list) && !empty($balasan_list)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Mahasiswa</th>
                                    <th>Instansi</th>
                                    <th>Status Balasan</th>
                                    <th>Tanggal</th>
                                    <th>Link Balasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($balasan_list as $b): ?>
                                    <tr>
                                        <td><?= $b->nim ?></td>
                                        <td><?= $b->nama_mahasiswa ?></td>
                                        <td><?= $b->instansi_tujuan ?></td>
                                        <td>
                                            <span class="badge bg-<?= (isset($b->status_mitra) && $b->status_mitra == 'diterima') ? 'success' : 'danger' ?>">
                                                <?= isset($b->status_mitra) ? ucfirst($b->status_mitra) : 'menunggu' ?>
                                            </span>
                                        </td>
                                        <td><?= (isset($b->tanggal_balasan_mitra) && $b->tanggal_balasan_mitra) ? format_indo('d M Y', strtotime($b->tanggal_balasan_mitra)) : '-' ?></td>
                                        <td>
                                            <?php if (isset($b->link_surat_penerimaan) && $b->link_surat_penerimaan): ?>
                                                <a href="<?= $b->link_surat_penerimaan ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-link-45deg me-1"></i>Lihat
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">Belum ada balasan mitra</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

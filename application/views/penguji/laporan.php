<!-- Penguji Laporan View -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Laporan Akhir Mahasiswa</h4>
        <p class="text-muted mb-0">ACC laporan akhir setelah revisi desiminasi</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-file-earmark-check me-2"></i>Daftar Laporan Akhir
    </div>
    <div class="card-body p-0">
        <?php if (!empty($laporan)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Laporan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($laporan as $l): ?>
                            <tr>
                                <td><?= $l->nim ?></td>
                                <td><?= $l->nama_mahasiswa ?></td>
                                <td><small><?= substr($l->judul_proposal, 0, 40) ?>...</small></td>
                                <td>
                                    <span
                                        class="badge bg-<?= $l->status_laporan_akhir == 'disetujui' ? 'success' : ($l->status_laporan_akhir == 'revisi' ? 'warning' : 'secondary') ?>">
                                        <?= ucfirst($l->status_laporan_akhir ?? 'menunggu') ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($l->link_laporan_akhir): ?>
                                        <a href="<?= $l->link_laporan_akhir ?>" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Belum upload</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($l->link_laporan_akhir && $l->status_laporan_akhir != 'disetujui'): ?>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#accModal<?= $l->hasil_id ?>">
                                            <i class="bi bi-check"></i> ACC
                                        </button>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#revisiModal<?= $l->hasil_id ?>">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    <?php elseif ($l->status_laporan_akhir == 'disetujui'): ?>
                                        <span class="badge bg-success"><i class="bi bi-check"></i> Sudah ACC</span>
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
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <p class="text-muted mt-3">Belum ada laporan akhir</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modals di luar table agar tidak ngeblink -->
<?php if (!empty($laporan)): ?>
    <?php foreach ($laporan as $l): ?>
        <?php if ($l->link_laporan_akhir && $l->status_laporan_akhir != 'disetujui'): ?>
            <!-- Modal ACC -->
            <div class="modal fade" id="accModal<?= $l->hasil_id ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title"><i class="bi bi-check-circle me-2"></i>Konfirmasi ACC Laporan</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center mb-3">
                                <i class="bi bi-file-earmark-check display-4 text-success"></i>
                            </div>
                            <div class="card bg-light mb-3">
                                <div class="card-body py-2">
                                    <table class="table table-borderless table-sm mb-0">
                                        <tr>
                                            <td width="100"><strong>NIM</strong></td>
                                            <td><?= $l->nim ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nama</strong></td>
                                            <td><?= $l->nama_mahasiswa ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Judul</strong></td>
                                            <td><?= $l->judul_proposal ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Laporan</strong></td>
                                            <td>
                                                <a href="<?= $l->link_laporan_akhir ?>" target="_blank" class="text-primary">
                                                    <i class="bi bi-box-arrow-up-right me-1"></i>Lihat Laporan
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <p class="text-center text-muted mb-0">
                                Apakah Anda yakin ingin <strong>menyetujui (ACC)</strong> laporan akhir mahasiswa ini?
                                Tindakan ini tidak dapat dibatalkan.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x me-1"></i>Batal
                            </button>
                            <a href="<?= base_url('penguji/laporan_acc/' . $l->hasil_id) ?>" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Ya, ACC Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Revisi -->
            <div class="modal fade" id="revisiModal<?= $l->hasil_id ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Minta Revisi Laporan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="post" action="<?= base_url('penguji/laporan_revisi/' . $l->hasil_id) ?>">
                            <div class="modal-body">
                                <div class="card bg-light mb-3">
                                    <div class="card-body py-2">
                                        <small class="text-muted">Mahasiswa</small>
                                        <p class="mb-0"><strong><?= $l->nama_mahasiswa ?></strong> (<?= $l->nim ?>)</p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Catatan Revisi</strong></label>
                                    <textarea name="catatan_revisi" class="form-control" rows="4"
                                        placeholder="Jelaskan bagian mana yang perlu diperbaiki..." required></textarea>
                                    <small class="text-muted">Catatan ini akan ditampilkan ke mahasiswa</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-send me-1"></i>Kirim Revisi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
<!-- Laporan Index View -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Laporan Magang</h4>
        <p class="text-muted mb-0">Upload laporan hasil magang untuk review DPL</p>
    </div>
</div>

<?php if (!$can_submit): ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-exclamation-circle display-1 text-warning"></i>
            <h5 class="mt-3">Logbook Belum Lengkap</h5>
            <p class="text-muted">Anda harus melengkapi 3 logbook bulanan sebelum dapat mengupload laporan</p>
            <p class="mb-3">Progress: <strong><?= $logbook_count ?>/3</strong> logbook sudah di-review</p>
            <a href="<?= base_url('logbook') ?>" class="btn btn-primary">Lengkapi Logbook</a>
        </div>
    </div>
<?php else: ?>

    <div class="row g-4">
        <!-- Form Upload -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-cloud-upload me-2"></i>Upload Laporan
                </div>
                <div class="card-body">
                    <form method="post" action="<?= base_url('laporan/store') ?>">
                        <div class="mb-3">
                            <label class="form-label">Jenis Laporan</label>
                            <select name="jenis_laporan" class="form-select" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="draft">Draft Laporan</option>
                                <option value="revisi">Revisi Laporan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Link Google Drive Laporan</label>
                            <input type="url" name="link_laporan" class="form-control"
                                placeholder="https://drive.google.com/..." required>
                            <small class="text-muted">Pastikan link dapat diakses oleh DPL</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Link Google Drive Penilaian Mitra <span class="text-muted">(Opsional)</span></label>
                            <input type="url" name="link_penilaian_mitra" class="form-control"
                                placeholder="https://drive.google.com/...">
                            <small class="text-muted">Pastikan link dapat diakses oleh DPL</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-upload me-2"></i>Upload Laporan
                        </button>
                    </form>
                </div>
            </div>

            <?php if ($has_acc_desiminasi): ?>
                <div class="card mt-4 border-success">
                    <div class="card-header bg-success text-white">
                        <i class="bi bi-check-circle me-2"></i>Siap Desiminasi!
                    </div>
                    <div class="card-body">
                        <p class="mb-3">Laporan Anda sudah di-ACC oleh DPL. Anda dapat mengajukan desiminasi sekarang.</p>
                        <a href="<?= base_url('desiminasi') ?>" class="btn btn-primary w-100">
                            <i class="bi bi-easel me-2"></i>Ajukan Desiminasi
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- List Laporan -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-file-earmark-text me-2"></i>Riwayat Laporan
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($laporan)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jenis</th>
                                        <th>Link</th>
                                        <th>Status DPL</th>
                                        <th>ACC Desiminasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($laporan as $l): ?>
                                        <tr>
                                            <td><?= format_indo('d M Y', strtotime($l->tanggal_upload)) ?></td>
                                            <td><span class="badge bg-secondary"><?= ucfirst($l->jenis_laporan) ?></span></td>
                                            <td>
                                                <a href="<?= $l->link_laporan ?>" target="_blank"
                                                    class="btn btn-sm btn-outline-primary" title="Lihat Laporan">
                                                    <i class="bi bi-file-earmark-text"></i> Laporan
                                                </a>
                                                <?php if(!empty($l->link_penilaian_mitra)): ?>
                                                    <a href="<?= $l->link_penilaian_mitra ?>" target="_blank"
                                                        class="btn btn-sm btn-outline-info" title="Lihat Penilaian Mitra">
                                                        <i class="bi bi-star"></i> Penilaian
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?= $l->status_dpl ?>">
                                                    <?= ucfirst($l->status_dpl) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($l->is_acc_desiminasi === true || $l->is_acc_desiminasi === 't' || $l->is_acc_desiminasi === '1'): ?>
                                                    <span class="badge bg-success"><i class="bi bi-check"></i> Ya</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Belum</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-file-earmark display-4 text-muted"></i>
                            <p class="text-muted mt-3">Belum ada laporan yang diupload</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Catatan DPL -->
            <?php foreach ($laporan as $l): ?>
                <?php if (!empty($l->catatan_dpl)): ?>
                    <div class="card mt-3 border-warning">
                        <div class="card-header bg-warning-subtle">
                            <i class="bi bi-chat-text me-2"></i>Catatan DPL - <?= format_indo('d M Y', strtotime($l->tanggal_upload)) ?>
                        </div>
                        <div class="card-body">
                            <p class="mb-0"><?= nl2br($l->catatan_dpl) ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

<?php endif; ?>

<!-- Logbook Index View -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Logbook Magang</h4>
        <p class="text-muted mb-0">Input link Google Drive logbook bulanan Anda</p>
    </div>
</div>

<?php if (!isset($proposal) || $proposal->status_kaprodi != 'disetujui'): ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-exclamation-circle display-1 text-warning"></i>
            <h5 class="mt-3">Proposal Belum Disetujui</h5>
            <p class="text-muted">Anda harus menunggu proposal disetujui oleh Kaprodi sebelum dapat mengisi logbook</p>
            <a href="<?= base_url('proposal') ?>" class="btn btn-primary">Lihat Status Proposal</a>
        </div>
    </div>
<?php else: ?>

    <div class="row g-4">
        <!-- Form Input -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-plus-circle me-2"></i>Input Logbook
                </div>
                <div class="card-body">
                    <form method="post" action="<?= base_url('logbook/store') ?>">
                        <div class="mb-3">
                            <label class="form-label">Bulan Ke</label>
                            <select name="bulan_ke" class="form-select" required>
                                <option value="">-- Pilih Bulan --</option>
                                <?php for ($i = 1; $i <= 3; $i++): ?>
                                    <option value="<?= $i ?>">Bulan ke-<?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Link Google Drive Logbook</label>
                            <input type="url" name="link_logbook" class="form-control"
                                placeholder="https://drive.google.com/..." required>
                            <small class="text-muted">Pastikan link dapat diakses</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save me-2"></i>Simpan Logbook
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- List Logbook -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-journal-text me-2"></i>Daftar Logbook
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Bulan</th>
                                    <th>Link</th>
                                    <th>Status DPL</th>
                                    <th>Status Koordinator</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $logbook_map = [];
                                foreach ($logbooks as $l) {
                                    $logbook_map[$l->bulan_ke] = $l;
                                }
                                for ($i = 1; $i <= 3; $i++):
                                    $l = isset($logbook_map[$i]) ? $logbook_map[$i] : null;
                                    ?>
                                    <tr>
                                        <td><strong>Bulan ke-<?= $i ?></strong></td>
                                        <td>
                                            <?php if ($l): ?>
                                                <a href="<?= $l->link_logbook ?>" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-box-arrow-up-right"></i> Lihat
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Belum diisi</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($l): ?>
                                                <span
                                                    class="badge badge-<?= $l->status_dpl == 'sudah_review' ? 'disetujui' : ($l->status_dpl == 'revisi' ? 'revisi' : 'menunggu') ?>">
                                                    <?= ucfirst(str_replace('_', ' ', $l->status_dpl)) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($l): ?>
                                                <span
                                                    class="badge badge-<?= $l->status_koordinator == 'sudah_review' ? 'disetujui' : 'menunggu' ?>">
                                                    <?= ucfirst(str_replace('_', ' ', $l->status_koordinator)) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Catatan DPL -->
            <?php foreach ($logbooks as $l): ?>
                <?php if (!empty($l->catatan_dpl)): ?>
                    <div class="card mt-3">
                        <div class="card-header bg-warning-subtle">
                            <i class="bi bi-chat-text me-2"></i>Catatan DPL - Bulan ke-<?= $l->bulan_ke ?>
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
<!-- Dosen Logbook Review View -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Review Logbook Mahasiswa</h4>
        <p class="text-muted mb-0">Review dan berikan catatan pada logbook mahasiswa bimbingan</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-journal-text me-2"></i>Daftar Logbook
    </div>
    <div class="card-body p-0">
        <?php if (!empty($logbooks)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Mahasiswa</th>
                            <th>Bulan</th>
                            <th>Link</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logbooks as $l): ?>
                            <tr>
                                <td>
                                    <strong><?= $l->nama_mahasiswa ?></strong><br>
                                    <small class="text-muted"><?= $l->nim ?></small>
                                </td>
                                <td>Bulan ke-<?= $l->bulan_ke ?></td>
                                <td>
                                    <a href="<?= $l->link_logbook ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-box-arrow-up-right"></i> Lihat
                                    </a>
                                </td>
                                <td>
                                    <span
                                        class="badge badge-<?= $l->status_dpl == 'sudah_review' ? 'disetujui' : ($l->status_dpl == 'revisi' ? 'revisi' : 'menunggu') ?>">
                                        <?= ucfirst(str_replace('_', ' ', $l->status_dpl)) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($l->status_dpl == 'belum_review'): ?>
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#reviewModal<?= $l->logbook_id ?>">
                                            <i class="bi bi-check-circle me-1"></i>Review
                                        </button>
                                    <?php else: ?>
                                        <span class="text-muted">Sudah direview</span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <!-- Review Modal -->
                            <div class="modal fade" id="reviewModal<?= $l->logbook_id ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Review Logbook</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="post"
                                            action="<?= base_url('dosen/logbook_review/' . $l->logbook_id . '/sudah_review') ?>">
                                            <div class="modal-body">
                                                <div class="alert alert-info">
                                                    <strong><?= $l->nama_mahasiswa ?></strong> - Bulan ke-<?= $l->bulan_ke ?>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Catatan (Optional)</label>
                                                    <textarea name="catatan_dpl" class="form-control" rows="3"
                                                        placeholder="Catatan untuk mahasiswa..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="bi bi-check me-1"></i>ACC
                                                </button>
                                                <button type="submit"
                                                    formaction="<?= base_url('dosen/logbook_review/' . $l->logbook_id . '/revisi') ?>"
                                                    class="btn btn-warning">
                                                    <i class="bi bi-pencil me-1"></i>Revisi
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <p class="text-muted mt-3">Belum ada logbook untuk direview</p>
            </div>
        <?php endif; ?>
    </div>
</div>
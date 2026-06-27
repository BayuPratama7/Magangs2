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
            <?php
                // Group logbooks by mahasiswa
                $grouped_logbooks = [];
                foreach ($logbooks as $l) {
                    if (!isset($grouped_logbooks[$l->mahasiswa_id])) {
                        $grouped_logbooks[$l->mahasiswa_id] = [
                            'nama' => $l->nama_mahasiswa,
                            'nim' => $l->nim,
                            'logbooks' => []
                        ];
                    }
                    $grouped_logbooks[$l->mahasiswa_id]['logbooks'][] = $l;
                }
            ?>
            <div class="accordion accordion-flush" id="accordionLogbooks">
                <?php foreach ($grouped_logbooks as $m_id => $group): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?= $m_id ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#collapse<?= $m_id ?>" aria-expanded="false" aria-controls="collapse<?= $m_id ?>">
                                <strong><?= $group['nama'] ?></strong> &nbsp; <span class="text-muted">(<?= $group['nim'] ?>)</span>
                                <span class="badge bg-primary ms-auto me-3"><?= count($group['logbooks']) ?> Logbook</span>
                            </button>
                        </h2>
                        <div id="collapse<?= $m_id ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $m_id ?>" data-bs-parent="#accordionLogbooks">
                            <div class="accordion-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Bulan</th>
                                                <th>Link</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($group['logbooks'] as $l): ?>
                                                <tr>
                                                    <td>Bulan ke-<?= $l->bulan_ke ?></td>
                                                    <td>
                                                        <a href="<?= $l->link_logbook ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-box-arrow-up-right"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-<?= $l->status_dpl == 'sudah_review' ? 'disetujui' : ($l->status_dpl == 'revisi' ? 'revisi' : 'menunggu') ?>">
                                                            <?= ucfirst(str_replace('_', ' ', $l->status_dpl)) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if ($l->status_dpl == 'belum_review'): ?>
                                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#reviewModal<?= $l->logbook_id ?>">
                                                                <i class="bi bi-check-circle me-1"></i>Review
                                                            </button>
                                                        <?php else: ?>
                                                            <span class="text-muted">Sudah direview</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <p class="text-muted mt-3">Belum ada logbook untuk direview</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modals harus di luar table agar tidak ngeblink -->
<?php if (!empty($logbooks)): ?>
    <?php foreach ($logbooks as $l): ?>
        <div class="modal fade" id="reviewModal<?= $l->logbook_id ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Review Logbook</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post" action="<?= base_url('dosen/logbook_review/' . $l->logbook_id . '/sudah_review') ?>">
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
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
<?php endif; ?>
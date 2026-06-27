<!-- Dosen Laporan Review View -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Review Laporan Magang</h4>
        <p class="text-muted mb-0">Review laporan mahasiswa bimbingan dan ACC untuk desiminasi</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-file-earmark-text me-2"></i>Daftar Laporan
    </div>
    <div class="card-body p-0">
        <?php if (!empty($laporan)): ?>
            <?php
                // Group laporan by mahasiswa
                $grouped_laporan = [];
                foreach ($laporan as $l) {
                    if (!isset($grouped_laporan[$l->mahasiswa_id])) {
                        $grouped_laporan[$l->mahasiswa_id] = [
                            'nama' => $l->nama_mahasiswa,
                            'nim' => $l->nim,
                            'laporans' => []
                        ];
                    }
                    $grouped_laporan[$l->mahasiswa_id]['laporans'][] = $l;
                }
            ?>
            <div class="accordion accordion-flush" id="accordionLaporan">
                <?php foreach ($grouped_laporan as $m_id => $group): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?= $m_id ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#collapse<?= $m_id ?>" aria-expanded="false" aria-controls="collapse<?= $m_id ?>">
                                <strong><?= $group['nama'] ?></strong> &nbsp; <span class="text-muted">(<?= $group['nim'] ?>)</span>
                                <span class="badge bg-primary ms-auto me-3"><?= count($group['laporans']) ?> Laporan</span>
                            </button>
                        </h2>
                        <div id="collapse<?= $m_id ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $m_id ?>" data-bs-parent="#accordionLaporan">
                            <div class="accordion-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Jenis</th>
                                                <th>Tanggal Upload</th>
                                                <th>Status</th>
                                                <th>ACC Desiminasi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($group['laporans'] as $l): ?>
                                                <tr>
                                                    <td><span class="badge bg-secondary"><?= ucfirst($l->jenis_laporan) ?></span></td>
                                                    <td><?= format_indo('d M Y', strtotime($l->tanggal_upload)) ?></td>
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
                                                    <td>
                                                        <a href="<?= $l->link_laporan ?>" target="_blank" class="btn btn-sm btn-outline-primary" title="Lihat Laporan">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <?php if (!empty($l->link_penilaian_mitra)): ?>
                                                            <a href="<?= $l->link_penilaian_mitra ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Lihat Penilaian Mitra">
                                                                <i class="bi bi-star"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if ($l->status_dpl == 'menunggu'): ?>
                                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#reviewModal<?= $l->laporan_id ?>">
                                                                <i class="bi bi-check-circle"></i>
                                                            </button>
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
                <p class="text-muted mt-3">Belum ada laporan</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modals di luar table agar tidak ngeblink -->
<?php if (!empty($laporan)): ?>
    <?php foreach ($laporan as $l): ?>
        <?php if ($l->status_dpl == 'menunggu'): ?>
        <div class="modal fade" id="reviewModal<?= $l->laporan_id ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="bi bi-file-earmark-text me-2"></i>Review Laporan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post" action="<?= base_url('dosen/laporan_acc/' . $l->laporan_id) ?>">
                        <div class="modal-body">
                            <div class="card bg-light mb-3">
                                <div class="card-body py-2">
                                    <table class="table table-borderless table-sm mb-0">
                                        <tr>
                                            <td width="120"><strong>Mahasiswa</strong></td>
                                            <td><?= $l->nama_mahasiswa ?> (<?= $l->nim ?>)</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Jenis Laporan</strong></td>
                                            <td><span class="badge bg-secondary"><?= ucfirst($l->jenis_laporan) ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Laporan</strong></td>
                                            <td>
                                                <a href="<?= $l->link_laporan ?>" target="_blank" class="text-primary">
                                                    <i class="bi bi-box-arrow-up-right me-1"></i>Lihat Laporan
                                                </a>
                                            </td>
                                        </tr>
                                        <?php if (!empty($l->link_penilaian_mitra)): ?>
                                        <tr>
                                            <td><strong>Penilaian Mitra</strong></td>
                                            <td>
                                                <a href="<?= $l->link_penilaian_mitra ?>" target="_blank" class="text-info">
                                                    <i class="bi bi-star me-1"></i>Lihat Penilaian Mitra
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    </table>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Catatan (Optional)</strong></label>
                                <textarea name="catatan_dpl" class="form-control" rows="3"
                                    placeholder="Berikan catatan untuk mahasiswa..."></textarea>
                            </div>
                            <div class="alert alert-success mb-0 py-2">
                                <i class="bi bi-info-circle me-2"></i>
                                <small>ACC laporan akan otomatis mengizinkan mahasiswa mengajukan desiminasi</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" formaction="<?= base_url('dosen/laporan_revisi/' . $l->laporan_id) ?>"
                                class="btn btn-warning">
                                <i class="bi bi-pencil me-1"></i>Revisi
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>ACC
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

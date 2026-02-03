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
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Mahasiswa</th>
                            <th>Jenis</th>
                            <th>Tanggal Upload</th>
                            <th>Status</th>
                            <th>ACC Desiminasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($laporan as $l): ?>
                            <tr>
                                <td>
                                    <strong><?= $l->nama_mahasiswa ?></strong><br>
                                    <small class="text-muted"><?= $l->nim ?></small>
                                </td>
                                <td><span class="badge bg-secondary"><?= ucfirst($l->jenis_laporan) ?></span></td>
                                <td><?= date('d M Y', strtotime($l->tanggal_upload)) ?></td>
                                <td>
                                    <span class="badge badge-<?= $l->status_dpl ?>">
                                        <?= ucfirst($l->status_dpl) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($l->is_acc_desiminasi): ?>
                                        <span class="badge bg-success"><i class="bi bi-check"></i> Ya</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Belum</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= $l->link_laporan ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if ($l->status_dpl == 'menunggu'): ?>
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#reviewModal<?= $l->laporan_id ?>">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <!-- Review Modal -->
                            <div class="modal fade" id="reviewModal<?= $l->laporan_id ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Review Laporan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="post" action="<?= base_url('dosen/laporan_acc/' . $l->laporan_id) ?>">
                                            <div class="modal-body">
                                                <div class="alert alert-info">
                                                    <strong><?= $l->nama_mahasiswa ?></strong> -
                                                    <?= ucfirst($l->jenis_laporan) ?>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Catatan (Optional)</label>
                                                    <textarea name="catatan_dpl" class="form-control" rows="3"></textarea>
                                                </div>
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" name="is_acc_desiminasi"
                                                        value="1" id="accDesiminasi<?= $l->laporan_id ?>">
                                                    <label class="form-check-label" for="accDesiminasi<?= $l->laporan_id ?>">
                                                        <strong>ACC untuk Desiminasi</strong><br>
                                                        <small class="text-muted">Centang jika mahasiswa siap untuk
                                                            desiminasi</small>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="bi bi-check me-1"></i>ACC
                                                </button>
                                                <button type="submit"
                                                    formaction="<?= base_url('dosen/laporan_revisi/' . $l->laporan_id) ?>"
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
                <p class="text-muted mt-3">Belum ada laporan</p>
            </div>
        <?php endif; ?>
    </div>
</div>
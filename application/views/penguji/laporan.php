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
                                        <a href="<?= base_url('penguji/laporan_acc/' . $l->hasil_id) ?>"
                                            class="btn btn-sm btn-success" onclick="return confirm('ACC laporan akhir ini?')">
                                            <i class="bi bi-check"></i> ACC
                                        </a>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#revisiModal<?= $l->hasil_id ?>">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <!-- Revisi Modal -->
                                        <div class="modal fade" id="revisiModal<?= $l->hasil_id ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Minta Revisi</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="post"
                                                        action="<?= base_url('penguji/laporan_revisi/' . $l->hasil_id) ?>">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Catatan Revisi</label>
                                                                <textarea name="catatan_revisi" class="form-control" rows="4"
                                                                    required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-warning">Minta Revisi</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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
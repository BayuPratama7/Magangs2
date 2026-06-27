<!-- Koordinator Proposal ACC View -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">ACC Proposal Magang</h4>
        <p class="text-muted mb-0">Verifikasi dan setujui proposal magang mahasiswa tahap 1</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-file-earmark-check me-2"></i>Daftar Proposal Menunggu ACC
    </div>
    <div class="card-body p-0">
        <?php if (!empty($proposals)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mahasiswa</th>
                            <th>Judul Proposal</th>
                            <th>Instansi</th>
                            <th>Tahun Akademik</th>
                            <th>Jenis</th>
                            <th>Link</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($proposals as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <strong><?= isset($p->nama_mahasiswa) ? $p->nama_mahasiswa : '-' ?></strong><br>
                                    <small class="text-muted"><?= isset($p->nim) ? $p->nim : '-' ?></small>
                                </td>
                                <td><?= $p->judul_proposal ?></td>
                                <td><?= $p->instansi_tujuan ?></td>
                                <td><?= isset($p->tahun_akademik) ? $p->tahun_akademik : '-' ?></td>
                                <td>
                                    <span class="badge bg-primary"><?= strtoupper($p->jenis_magang) ?></span>
                                </td>
                                <td>
                                    <a href="<?= $p->link_proposal ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-box-arrow-up-right"></i> Lihat
                                    </a>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $p->status_koordinator ?>">
                                        <?= ucfirst($p->status_koordinator) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($p->status_koordinator == 'menunggu'): ?>
                                        <a href="<?= base_url('koordinator/acc/' . $p->proposal_id) ?>"
                                            class="btn btn-sm btn-primary" onclick="return confirm('Setujui proposal ini?')">
                                            <i class="bi bi-check-circle me-1"></i>ACC
                                        </a>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#rejectModal<?= $p->proposal_id ?>">
                                            <i class="bi bi-x-circle me-1"></i>Tolak
                                        </button>
                                    <?php else: ?>
                                        <span class="text-muted">Sudah diproses</span>
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
                <p class="text-muted mt-3">Tidak ada proposal yang menunggu ACC</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modals di luar table agar tidak ngeblink -->
<?php if (!empty($proposals)): ?>
    <?php foreach ($proposals as $p): ?>
        <?php if ($p->status_koordinator == 'menunggu'): ?>
            <div class="modal fade" id="rejectModal<?= $p->proposal_id ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tolak Proposal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="post" action="<?= base_url('koordinator/reject/' . $p->proposal_id) ?>">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Alasan Penolakan</label>
                                    <textarea name="catatan" class="form-control" rows="3"
                                        placeholder="Jelaskan alasan penolakan..." required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Tolak Proposal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
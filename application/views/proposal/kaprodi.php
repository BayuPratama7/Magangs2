<!-- Kaprodi Proposal ACC View -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">ACC Proposal - Ketua Program Studi</h4>
        <p class="text-muted mb-0">Verifikasi dan setujui proposal magang tahap akhir</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-file-earmark-check me-2"></i>Daftar Proposal Menunggu ACC Final
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
                            <th>Link</th>
                            <th>Status Koordinator</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($proposals as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <strong><?= isset($p->nama_mahasiswa) ? $p->nama_mahasiswa : '-' ?></strong><br>
                                    <small class="text-muted"><?= isset($p->nim) ? $p->nim : '-' ?></small>
                                </td>
                                <td><?= $p->judul_proposal ?></td>
                                <td><?= $p->instansi_tujuan ?></td>
                                <td>
                                    <a href="<?= $p->link_proposal ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-box-arrow-up-right"></i> Lihat
                                    </a>
                                </td>
                                <td>
                                    <span class="badge badge-disetujui">
                                        <i class="bi bi-check-circle me-1"></i>Disetujui
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= base_url('proposal/kaprodi/acc/' . $p->proposal_id) ?>" 
                                       class="btn btn-sm btn-success"
                                       onclick="return confirm('ACC Final proposal ini?')">
                                        <i class="bi bi-check2-all me-1"></i>ACC Final
                                    </a>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                            data-bs-target="#rejectModal<?= $p->proposal_id ?>">
                                        <i class="bi bi-x-circle me-1"></i>Tolak
                                    </button>
                                    
                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal<?= $p->proposal_id ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tolak Proposal</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form method="post" action="<?= base_url('proposal/kaprodi/reject/' . $p->proposal_id) ?>">
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
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <p class="text-muted mt-3">Tidak ada proposal yang menunggu ACC tahap 2</p>
            </div>
        <?php endif; ?>
    </div>
</div>
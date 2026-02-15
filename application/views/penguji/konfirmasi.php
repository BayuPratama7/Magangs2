<!-- Penguji Konfirmasi View -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Konfirmasi Kesediaan Menguji</h4>
        <p class="text-muted mb-0">Konfirmasi kesediaan Anda untuk menguji desiminasi mahasiswa</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-question-circle me-2"></i>Permintaan Menguji
    </div>
    <div class="card-body p-0">
        <?php if (!empty($pending)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Judul Proposal</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending as $p): ?>
                            <tr>
                                <td><?= $p->nim ?></td>
                                <td><?= $p->nama_mahasiswa ?></td>
                                <td><small><?= $p->judul_proposal ?></small></td>
                                <td><?= date('d M Y', strtotime($p->tanggal_pengajuan)) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#terimaModal<?= $p->desiminasi_id ?>">
                                        <i class="bi bi-check me-1"></i>Bersedia
                                    </button>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#tolakModal<?= $p->desiminasi_id ?>">
                                        <i class="bi bi-x me-1"></i>Tidak Bersedia
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <p class="text-muted mt-3">Tidak ada permintaan menguji</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modals -->
<?php if (!empty($pending)): ?>
    <?php foreach ($pending as $p): ?>
        <!-- Modal Bersedia -->
        <div class="modal fade" id="terimaModal<?= $p->desiminasi_id ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="bi bi-check-circle me-2"></i>Konfirmasi Bersedia Menguji</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <i class="bi bi-person-check display-4 text-success"></i>
                        </div>
                        <div class="card bg-light mb-3">
                            <div class="card-body py-2">
                                <table class="table table-borderless table-sm mb-0">
                                    <tr>
                                        <td width="100"><strong>NIM</strong></td>
                                        <td><?= $p->nim ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nama</strong></td>
                                        <td><?= $p->nama_mahasiswa ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Judul</strong></td>
                                        <td><?= $p->judul_proposal ?></td>
                                    </tr>
                                    <?php if (!empty($p->instansi_tujuan)): ?>
                                    <tr>
                                        <td><strong>Instansi</strong></td>
                                        <td><?= $p->instansi_tujuan ?></td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                        <p class="text-center text-muted mb-0">
                            Apakah Anda <strong>bersedia</strong> menjadi penguji desiminasi untuk mahasiswa ini?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x me-1"></i>Batal
                        </button>
                        <a href="<?= base_url('penguji/konfirmasi_terima/' . $p->desiminasi_id) ?>" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i>Ya, Saya Bersedia
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tidak Bersedia -->
        <div class="modal fade" id="tolakModal<?= $p->desiminasi_id ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title"><i class="bi bi-x-circle me-2"></i>Tolak Penugasan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <i class="bi bi-person-x display-4 text-danger"></i>
                        </div>
                        <div class="card bg-light mb-3">
                            <div class="card-body py-2">
                                <table class="table table-borderless table-sm mb-0">
                                    <tr>
                                        <td width="100"><strong>NIM</strong></td>
                                        <td><?= $p->nim ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nama</strong></td>
                                        <td><?= $p->nama_mahasiswa ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Judul</strong></td>
                                        <td><?= $p->judul_proposal ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <p class="text-center text-muted mb-0">
                            Apakah Anda yakin <strong>tidak bersedia</strong> menguji mahasiswa ini?
                            Penugasan akan dikembalikan ke sekretaris.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-arrow-left me-1"></i>Batal
                        </button>
                        <a href="<?= base_url('penguji/konfirmasi_tolak/' . $p->desiminasi_id) ?>" class="btn btn-danger">
                            <i class="bi bi-x-circle me-1"></i>Ya, Tidak Bersedia
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
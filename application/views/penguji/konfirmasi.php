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
                                    <a href="<?= base_url('penguji/konfirmasi_terima/' . $p->desiminasi_id) ?>"
                                        class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi bersedia menguji?')">
                                        <i class="bi bi-check me-1"></i>Bersedia
                                    </a>
                                    <a href="<?= base_url('penguji/konfirmasi_tolak/' . $p->desiminasi_id) ?>"
                                        class="btn btn-sm btn-danger" onclick="return confirm('Tolak penugasan ini?')">
                                        <i class="bi bi-x me-1"></i>Tidak Bersedia
                                    </a>
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
<!-- Dosen Bimbingan View -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Mahasiswa Bimbingan</h4>
        <p class="text-muted mb-0">Daftar mahasiswa yang Anda bimbing</p>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <?php if (!empty($mahasiswa)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Instansi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mahasiswa as $m): ?>
                            <tr>
                                <td><?= $m->nim ?></td>
                                <td><?= $m->nama_mahasiswa ?></td>
                                <td><?= $m->instansi_tujuan ?? '-' ?></td>
                                <td>
                                    <span
                                        class="badge bg-<?= $m->status_magang == 'selesai' ? 'success' : ($m->status_magang == 'sedang_magang' ? 'primary' : 'secondary') ?>">
                                        <?= ucfirst(str_replace('_', ' ', $m->status_magang)) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= base_url('dosen/detail/' . $m->mahasiswa_id) ?>"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-person-x display-1 text-muted"></i>
                <p class="text-muted mt-3">Belum ada mahasiswa bimbingan</p>
            </div>
        <?php endif; ?>
    </div>
</div>
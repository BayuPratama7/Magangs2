<!-- Dosen Detail Mahasiswa View -->
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1">Detail Mahasiswa</h4>
            <p class="text-muted mb-0"><?= $mahasiswa->nama_mahasiswa ?> (<?= $mahasiswa->nim ?>)</p>
        </div>
        <a href="<?= base_url('dosen/bimbingan') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <!-- Info Mahasiswa -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-person me-2"></i>Informasi Mahasiswa
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td width="150"><strong>NIM</strong></td>
                        <td><?= $mahasiswa->nim ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td><?= $mahasiswa->nama_mahasiswa ?></td>
                    </tr>
                    <tr>
                        <td><strong>Prodi</strong></td>
                        <td><?= $mahasiswa->prodi ?? 'Sistem Informasi' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            <span
                                class="badge bg-<?= $mahasiswa->status_magang == 'selesai' ? 'success' : 'primary' ?>">
                                <?= ucfirst(str_replace('_', ' ', $mahasiswa->status_magang)) ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Logbook Status -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-journal-text me-2"></i>Status Logbook
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Link</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $logbook_map = [];
                        foreach ($logbooks as $l) {
                            $logbook_map[$l->bulan_ke] = $l;
                        }
                        for ($i = 1; $i <= 3; $i++):
                            $l = isset($logbook_map[$i]) ? $logbook_map[$i] : null;
                            ?>
                            <tr>
                                <td>Bulan ke-<?= $i ?></td>
                                <td>
                                    <?php if ($l): ?>
                                        <a href="<?= $l->link_logbook ?>" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($l): ?>
                                        <span
                                            class="badge badge-<?= $l->status_dpl == 'sudah_review' ? 'disetujui' : ($l->status_dpl == 'revisi' ? 'revisi' : 'menunggu') ?>">
                                            <?= ucfirst(str_replace('_', ' ', $l->status_dpl)) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">Belum diisi</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <!-- Riwayat Laporan -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-file-earmark-text me-2"></i>Riwayat Laporan
            </div>
            <div class="card-body p-0">
                <?php if (!empty($laporan)): ?>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Status</th>
                                    <th>ACC Desiminasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($laporan as $l): ?>
                                    <tr>
                                        <td><?= date('d M Y', strtotime($l->tanggal_upload)) ?></td>
                                        <td><?= ucfirst($l->jenis_laporan) ?></td>
                                        <td>
                                            <span class="badge badge-<?= $l->status_dpl ?>">
                                                <?= ucfirst($l->status_dpl) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($l->is_acc_desiminasi): ?>
                                                <i class="bi bi-check-circle text-success"></i>
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
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">Belum ada laporan</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
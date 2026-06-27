<!-- Desiminasi Index View -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Desiminasi Magang</h4>
        <p class="text-muted mb-0">Ajukan desiminasi dan lihat hasil ujian</p>
    </div>
</div>

<?php if (!$can_apply && !$desiminasi): ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-hourglass-split display-1 text-warning"></i>
            <h5 class="mt-3">Belum Dapat Mengajukan Desiminasi</h5>
            <p class="text-muted">Laporan Anda harus di-ACC oleh DPL terlebih dahulu sebelum dapat mengajukan desiminasi</p>
            <a href="<?= base_url('laporan') ?>" class="btn btn-primary">Lihat Status Laporan</a>
        </div>
    </div>
<?php elseif (!$desiminasi): ?>

    <!-- Form Pengajuan -->
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-easel me-2"></i>Pengajuan Desiminasi
                </div>
                <div class="card-body text-center py-4">
                    <i class="bi bi-check-circle display-1 text-success"></i>
                    <h5 class="mt-3">Anda Siap Desiminasi!</h5>
                    <p class="text-muted">Laporan Anda sudah di-ACC oleh DPL. Silakan ajukan desiminasi.</p>
                    <form method="post" action="<?= base_url('desiminasi/store') ?>">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="bi bi-send me-2"></i>Ajukan Desiminasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>

    <div class="row g-4">
        <!-- Status Desiminasi -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>Status Pengajuan
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td width="180"><strong>Status Pengajuan</strong></td>
                            <td>
                                <span class="badge badge-<?= $desiminasi->status_pengajuan ?>">
                                    <?= ucfirst($desiminasi->status_pengajuan) ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Pengajuan</strong></td>
                            <td><?= format_indo('d M Y H:i', strtotime($desiminasi->tanggal_pengajuan)) ?></td>
                        </tr>
                        <?php if ($desiminasi->nama_penguji): ?>
                            <tr>
                                <td><strong>Penguji</strong></td>
                                <td><?= $desiminasi->nama_penguji ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($desiminasi->tanggal_desiminasi): ?>
                            <tr>
                                <td><strong>Tanggal Desiminasi</strong></td>
                                <td>
                                    <i class="bi bi-calendar me-1"></i>
                                    <?= format_indo('d M Y', strtotime($desiminasi->tanggal_desiminasi)) ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Waktu</strong></td>
                                <td>
                                    <i class="bi bi-clock me-1"></i>
                                    <?= date('H:i', strtotime($desiminasi->waktu_mulai)) ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Ruangan</strong></td>
                                <td>
                                    <i class="bi bi-geo-alt me-1"></i>
                                    <?= $desiminasi->ruangan ?? 'Online' ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>

        <!-- Hasil Desiminasi -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-trophy me-2"></i>Hasil Desiminasi
                </div>
                <div class="card-body">
                    <?php if ($hasil && $hasil->status_kelulusan): ?>
                        <div class="text-center py-3">
                            <?php if ($hasil->status_kelulusan == 'lulus'): ?>
                                <i class="bi bi-trophy display-1 text-success"></i>
                                <h4 class="text-success mt-3">LULUS</h4>
                            <?php elseif ($hasil->status_kelulusan == 'lulus_bersyarat'): ?>
                                <i class="bi bi-patch-exclamation display-1 text-warning"></i>
                                <h4 class="text-warning mt-3">LULUS BERSYARAT</h4>
                            <?php else: ?>
                                <i class="bi bi-x-circle display-1 text-danger"></i>
                                <h4 class="text-danger mt-3">TIDAK LULUS</h4>
                            <?php endif; ?>
                        </div>

                        <?php if ($hasil->catatan_revisi): ?>
                            <hr>
                            <h6><i class="bi bi-chat-text me-2"></i>Catatan Revisi Desiminasi:</h6>
                            <p class="bg-light p-3 rounded"><?= nl2br($hasil->catatan_revisi) ?></p>
                        <?php endif; ?>

                        <?php if (!empty($hasil->catatan_penguji)): ?>
                            <?php if (empty($hasil->catatan_revisi)): ?><hr><?php endif; ?>
                            <div class="card bg-light mb-3 border-0 shadow-sm">
                                <div class="card-body py-3">
                                    <h6 class="mb-2 text-dark"><i class="bi bi-pencil-square me-2"></i>Catatan Revisi Laporan dari Penguji:</h6>
                                    <p class="mb-0 text-secondary" style="word-break: break-word;"><?= nl2br($hasil->catatan_penguji) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Upload Laporan Akhir -->
                        <?php if ($hasil->status_laporan_akhir == 'disetujui'): ?>
                            <hr>
                            <div class="alert alert-success mb-0">
                                <i class="bi bi-check-circle me-2"></i>
                                <strong>Selamat!</strong> Laporan akhir Anda sudah di-ACC oleh penguji.
                            </div>
                        <?php elseif (!empty($hasil->link_laporan_akhir) && $hasil->status_laporan_akhir == 'menunggu'): ?>
                            <hr>
                            <div class="alert alert-info mb-0">
                                <i class="bi bi-hourglass-split me-2"></i>
                                <strong>Laporan akhir berhasil diupload!</strong><br>
                                <small>Menunggu ACC dari penguji.</small>
                            </div>
                        <?php elseif (!empty($hasil->link_laporan_akhir) && $hasil->status_laporan_akhir == 'menunggu_revisi'): ?>
                            <hr>
                            <div class="alert alert-success mb-0">
                                <i class="bi bi-check2-circle me-2"></i>
                                <strong>Laporan revisi berhasil diupload!</strong><br>
                                <small>Menunggu ACC dari penguji untuk laporan revisi Anda.</small>
                            </div>
                        <?php elseif ($hasil->status_laporan_akhir == 'revisi'): ?>
                            <hr>
                            <div class="alert alert-warning mb-3 border-0 shadow-sm">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Revisi Diperlukan!</strong><br>
                                Silakan upload ulang laporan akhir Anda setelah diperbaiki.
                            </div>
                            <h6><i class="bi bi-upload me-2"></i>Upload Laporan Akhir (Revisi)</h6>
                            <form method="post" action="<?= base_url('desiminasi/upload_laporan_akhir') ?>">
                                <div class="mb-3">
                                    <input type="url" name="link_laporan_akhir" class="form-control"
                                        value="<?= $hasil->link_laporan_akhir ?? '' ?>" placeholder="https://drive.google.com/..."
                                        required>
                                </div>
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="bi bi-upload me-2"></i>Upload Laporan Revisi
                                </button>
                            </form>
                        <?php else: ?>
                            <hr>
                            <h6><i class="bi bi-upload me-2"></i>Upload Laporan Akhir</h6>
                            <form method="post" action="<?= base_url('desiminasi/upload_laporan_akhir') ?>">
                                <div class="mb-3">
                                    <input type="url" name="link_laporan_akhir" class="form-control"
                                        placeholder="https://drive.google.com/..." required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-upload me-2"></i>Upload Laporan Akhir
                                </button>
                            </form>
                        <?php endif; ?>

                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-hourglass display-4 text-muted"></i>
                            <p class="text-muted mt-3">Hasil desiminasi belum tersedia</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>


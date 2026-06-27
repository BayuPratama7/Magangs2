<!-- Penguji Jadwal View -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Jadwal Menguji</h4>
        <p class="text-muted mb-0">Jadwal desiminasi yang harus Anda uji</p>
    </div>
</div>

<?php if (!empty($jadwal)): ?>
    <div class="row g-4">
        <?php foreach ($jadwal as $j): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-header bg-<?= $j->status == 'selesai' ? 'success' : 'primary' ?> text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong><?= format_indo('d M Y', strtotime($j->tanggal_desiminasi)) ?></strong>
                            <span class="badge bg-light text-dark"><?= date('H:i', strtotime($j->waktu_mulai)) ?></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $j->nama_mahasiswa ?></h5>
                        <p class="card-text text-muted small"><?= $j->nim ?></p>
                        <p class="card-text small"><?= substr($j->judul_proposal, 0, 100) ?>...</p>
                        <hr>
                        <p class="mb-1">
                            <i class="bi bi-geo-alt me-2"></i><?= $j->ruangan ?? 'Online' ?>
                        </p>
                        <?php if ($j->link_online): ?>
                            <a href="<?= $j->link_online ?>" target="_blank" class="btn btn-sm btn-outline-primary w-100 mt-2">
                                <i class="bi bi-camera-video me-1"></i>Join Meeting
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        <?php if ($j->status == 'selesai'): ?>
                            <!-- Sudah dinilai - tampilkan tombol lihat/edit hasil -->
                            <a href="<?= base_url('penguji/input_hasil/' . $j->desiminasi_id) ?>"
                                class="btn btn-primary btn-sm w-100">
                                <i class="bi bi-eye me-1"></i>Lihat Hasil
                            </a>
                        <?php elseif (in_array($j->status, ['terjadwal', 'terkonfirmasi'])): ?>
                            <!-- Jadwal aktif - tampilkan tombol input hasil -->
                            <a href="<?= base_url('penguji/input_hasil/' . $j->desiminasi_id) ?>"
                                class="btn btn-primary btn-sm w-100">
                                <i class="bi bi-pencil me-1"></i>Input Hasil
                            </a>
                        <?php elseif ($j->status == 'menunggu_konfirmasi'): ?>
                            <!-- Menunggu konfirmasi - tampilkan info -->
                            <span class="badge bg-warning text-dark w-100 py-2">Menunggu Konfirmasi</span>
                        <?php else: ?>
                            <!-- Status lainnya (batal, dll) -->
                            <span class="badge bg-secondary w-100 py-2"><?= ucfirst(str_replace('_', ' ', $j->status)) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-calendar-x display-1 text-muted"></i>
            <p class="text-muted mt-3">Tidak ada jadwal menguji</p>
        </div>
    </div>
<?php endif; ?>


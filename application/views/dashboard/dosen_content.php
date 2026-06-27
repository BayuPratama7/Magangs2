<!-- Dashboard DPL Content -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Dashboard Dosen Pembimbing Lapangan</h4>
        <p class="text-muted mb-0">Pantau dan bimbing mahasiswa magang Anda</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card purple">
            <h3><?= $stats->total_mahasiswa ?? 0 ?></h3>
            <p>Mahasiswa Bimbingan</p>
            <i class="bi bi-people"></i>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card blue">
            <h3><?= $stats->pending_logbook ?? 0 ?></h3>
            <p>Logbook Perlu Review</p>
            <i class="bi bi-journal-text"></i>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card green">
            <h3><?= $stats->pending_laporan ?? 0 ?></h3>
            <p>Laporan Perlu Review</p>
            <i class="bi bi-file-earmark-text"></i>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card orange">
            <h3><?= $stats->upcoming_desiminasi ?? 0 ?></h3>
            <p>Desiminasi Mendatang</p>
            <i class="bi bi-calendar-event"></i>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Mahasiswa Bimbingan -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-people me-2"></i>Daftar Mahasiswa Bimbingan</span>
                <a href="<?= base_url('dosen/bimbingan') ?>" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <?php if (isset($mahasiswa_bimbingan) && !empty($mahasiswa_bimbingan)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Instansi</th>
                                    <th>Logbook</th>
                                    <th>Laporan</th>
                                    <th>Desiminasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($mahasiswa_bimbingan as $m): ?>
                                    <tr>
                                        <td><?= $m->nim ?></td>
                                        <td><?= $m->nama_mahasiswa ?></td>
                                        <td><?= $m->instansi_tujuan ?? '-' ?></td>
                                        <td>
                                            <span class="badge bg-<?= ($m->logbook_count ?? 0) >= 3 ? 'success' : 'warning' ?>">
                                                <?= $m->logbook_count ?? 0 ?>/3
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?= $m->laporan_status ?? 'menunggu' ?>">
                                                <?= ucfirst($m->laporan_status ?? 'Belum') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php 
                                            $status = $m->desiminasi_status ?? 'belum';
                                            $badge_class = 'secondary';
                                            $label = 'Belum';
                                            if ($status == 'selesai') {
                                                $badge_class = 'success';
                                                $label = 'Selesai';
                                            } elseif ($status == 'revisi_uploaded') {
                                                $badge_class = 'info';
                                                $label = 'Revisi Diupload';
                                            } elseif ($status == 'perlu_revisi') {
                                                $badge_class = 'warning';
                                                $label = 'Perlu Revisi';
                                            } elseif ($status == 'menunggu_acc') {
                                                $badge_class = 'primary';
                                                $label = 'Menunggu ACC';
                                            } elseif ($status == 'lulus') {
                                                $badge_class = 'success';
                                                $label = 'Lulus';
                                            } elseif ($status == 'lulus_bersyarat') {
                                                $badge_class = 'warning';
                                                $label = 'Lulus Bersyarat';
                                            } elseif ($status == 'tidak_lulus') {
                                                $badge_class = 'danger';
                                                $label = 'Tidak Lulus';
                                            } elseif ($status == 'proses') {
                                                $badge_class = 'info';
                                                $label = 'Proses';
                                            }
                                            ?>
                                            <span class="badge bg-<?= $badge_class ?>">
                                                <?= $label ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('dosen/detail/' . $m->mahasiswa_id) ?>"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
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

        <!-- Laporan Pending Review -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="bi bi-file-earmark-check me-2"></i>Laporan Menunggu Review
            </div>
            <div class="card-body p-0">
                <?php if (isset($pending_laporan) && !empty($pending_laporan)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Mahasiswa</th>
                                    <th>Jenis</th>
                                    <th>Tanggal Upload</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pending_laporan as $l): ?>
                                    <tr>
                                        <td>
                                            <strong><?= $l->nama_mahasiswa ?></strong><br>
                                            <small class="text-muted"><?= $l->nim ?></small>
                                        </td>
                                        <td><span class="badge bg-secondary"><?= ucfirst($l->jenis_laporan) ?></span></td>
                                        <td><?= format_indo('d M Y', strtotime($l->tanggal_upload)) ?></td>
                                        <td>
                                            <a href="<?= $l->link_laporan ?>" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#accModal<?= $l->laporan_id ?>">
                                                <i class="bi bi-check"></i> ACC
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#revisiModal<?= $l->laporan_id ?>">
                                                <i class="bi bi-pencil"></i> Revisi
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">Tidak ada laporan yang menunggu review</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">

        <!-- Sebaran Magang -->
        <?php $this->load->view('dashboard/_sebaran_cards', ['filter_url' => base_url('dashboard/dosen/sebaran_filter')]); ?>

        <!-- Jadwal Desiminasi -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-calendar-event me-2"></i>Jadwal Desiminasi Mahasiswa
            </div>
            <div class="card-body">
                <?php if (isset($jadwal_desiminasi) && !empty($jadwal_desiminasi)): ?>
                    <?php foreach ($jadwal_desiminasi as $j): ?>
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <div>
                                <strong class="d-block"><?= $j->nama_mahasiswa ?></strong>
                                <small class="text-muted"><?= format_indo('d M Y', strtotime($j->tanggal_desiminasi)) ?></small>
                            </div>
                            <span class="badge bg-primary"><?= date('H:i', strtotime($j->waktu_mulai)) ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">Belum ada jadwal desiminasi</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<!-- Modals for Laporan Review - Placed at End of Page for Proper Z-Index -->
<?php if (isset($pending_laporan) && !empty($pending_laporan)): ?>
    <?php foreach ($pending_laporan as $l): ?>
        <!-- ACC Modal -->
        <div class="modal fade" id="accModal<?= $l->laporan_id ?>" tabindex="-1"
            aria-labelledby="accModalLabel<?= $l->laporan_id ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="accModalLabel<?= $l->laporan_id ?>">
                            <i class="bi bi-check-circle me-2"></i>ACC Laporan
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form method="post" action="<?= base_url('dosen/laporan_acc/' . $l->laporan_id) ?>">
                        <div class="modal-body">
                            <div class="alert alert-info">
                                <strong><?= $l->nama_mahasiswa ?></strong> - <?= ucfirst($l->jenis_laporan) ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan (Optional)</label>
                                <textarea name="catatan_dpl" class="form-control" rows="3"
                                    placeholder="Catatan untuk mahasiswa..."></textarea>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="is_acc_desiminasi" value="1"
                                    id="accDesiminasi<?= $l->laporan_id ?>">
                                <label class="form-check-label" for="accDesiminasi<?= $l->laporan_id ?>">
                                    ACC untuk Desiminasi
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check me-1"></i>ACC Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Revisi Modal -->
        <div class="modal fade" id="revisiModal<?= $l->laporan_id ?>" tabindex="-1"
            aria-labelledby="revisiModalLabel<?= $l->laporan_id ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="revisiModalLabel<?= $l->laporan_id ?>">
                            <i class="bi bi-pencil me-2"></i>Kembalikan untuk Revisi
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="<?= base_url('dosen/laporan_revisi/' . $l->laporan_id) ?>">
                        <div class="modal-body">
                            <div class="alert alert-warning">
                                <strong><?= $l->nama_mahasiswa ?></strong> - <?= ucfirst($l->jenis_laporan) ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan Revisi <span class="text-danger">*</span></label>
                                <textarea name="catatan_dpl" class="form-control" rows="3" required
                                    placeholder="Jelaskan apa yang perlu direvisi..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-pencil me-1"></i>Kirim Revisi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>


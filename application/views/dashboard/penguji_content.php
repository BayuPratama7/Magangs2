<!-- Dashboard Penguji Content -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Dashboard Penguji Desiminasi</h4>
        <p class="text-muted mb-0">Kelola ujian desiminasi dan ACC laporan akhir mahasiswa</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card purple">
            <h3><?= $stats->pending_konfirmasi ?? 0 ?></h3>
            <p>Menunggu Konfirmasi</p>
            <i class="bi bi-question-circle"></i>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card blue">
            <h3><?= $stats->upcoming_desiminasi ?? 0 ?></h3>
            <p>Desiminasi Mendatang</p>
            <i class="bi bi-calendar-event"></i>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card green">
            <h3><?= $stats->pending_laporan_akhir ?? 0 ?></h3>
            <p>Laporan Akhir Pending</p>
            <i class="bi bi-file-earmark-check"></i>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card orange">
            <h3><?= $stats->total_diuji ?? 0 ?></h3>
            <p>Total Mahasiswa Diuji</p>
            <i class="bi bi-people"></i>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Konfirmasi Menguji -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-check2-circle me-2"></i>Permintaan Menguji
            </div>
            <div class="card-body p-0">
                <?php if (isset($pending_konfirmasi) && !empty($pending_konfirmasi)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Mahasiswa</th>
                                    <th>Judul</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pending_konfirmasi as $p): ?>
                                    <tr>
                                        <td>
                                            <strong><?= $p->nama_mahasiswa ?></strong><br>
                                            <small class="text-muted"><?= $p->nim ?></small>
                                        </td>
                                        <td><small><?= substr($p->judul_proposal, 0, 50) ?>...</small></td>
                                        <td>
                                            <a href="<?= base_url('penguji/konfirmasi_terima/' . $p->desiminasi_id) ?>"
                                                class="btn btn-sm btn-success">
                                                <i class="bi bi-check"></i> Bersedia
                                            </a>
                                            <a href="<?= base_url('penguji/konfirmasi_tolak/' . $p->desiminasi_id) ?>"
                                                class="btn btn-sm btn-danger">
                                                <i class="bi bi-x"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-inbox display-4 text-muted"></i>
                        <p class="text-muted mt-2 mb-0">Tidak ada permintaan menguji</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Jadwal Desiminasi -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-calendar-event me-2"></i>Jadwal Menguji
            </div>
            <div class="card-body">
                <?php if (isset($jadwal_menguji) && !empty($jadwal_menguji)): ?>
                    <?php foreach ($jadwal_menguji as $j): ?>
                        <div class="card bg-light mb-3">
                            <div class="card-body py-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1"><?= $j->nama_mahasiswa ?></h6>
                                        <small class="text-muted"><?= $j->nim ?></small>
                                    </div>
                                    <span class="badge bg-primary">
                                        <?= date('d M Y', strtotime($j->tanggal_desiminasi)) ?>
                                    </span>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between">
                                    <small><i class="bi bi-clock me-1"></i><?= $j->waktu_mulai ?></small>
                                    <small><i class="bi bi-geo-alt me-1"></i><?= $j->ruangan ?? 'Online' ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-calendar-x display-4 text-muted"></i>
                        <p class="text-muted mt-2">Tidak ada jadwal mendatang</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Laporan Akhir Pending ACC -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-file-earmark-check me-2"></i>Laporan Akhir Menunggu ACC</span>
                <a href="<?= base_url('penguji/laporan') ?>" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <?php if (isset($pending_laporan_akhir) && !empty($pending_laporan_akhir)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Judul</th>
                                    <th>Tanggal Desiminasi</th>
                                    <th>Status Revisi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pending_laporan_akhir as $l): ?>
                                    <tr>
                                        <td><?= $l->nim ?></td>
                                        <td><?= $l->nama_mahasiswa ?></td>
                                        <td><small><?= $l->judul_proposal ?></small></td>
                                        <td><?= date('d M Y', strtotime($l->tanggal_desiminasi)) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $l->link_laporan_akhir ? 'info' : 'warning' ?>">
                                                <?= $l->link_laporan_akhir ? 'Sudah Upload' : 'Belum Upload' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($l->link_laporan_akhir): ?>
                                                <a href="<?= $l->link_laporan_akhir ?>" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?= base_url('penguji/laporan_acc/' . $l->hasil_id) ?>"
                                                    class="btn btn-sm btn-success">
                                                    <i class="bi bi-check"></i> ACC
                                                </a>
                                                <a href="<?= base_url('penguji/laporan_revisi/' . $l->hasil_id) ?>"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Menunggu upload</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-check-circle display-1 text-success"></i>
                        <p class="text-muted mt-3">Semua laporan akhir sudah di-ACC</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
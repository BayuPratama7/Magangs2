<!-- Dashboard Sekretaris Content -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Dashboard Sekretaris Program Studi</h4>
        <p class="text-muted mb-0">Kelola administrasi magang dan konten dashboard</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card purple">
            <h3><?= $stats->pending_dpl ?? 0 ?></h3>
            <p>Mahasiswa Belum DPL</p>
            <i class="bi bi-person-plus"></i>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card blue">
            <h3><?= $stats->pending_surat ?? 0 ?></h3>
            <p>Surat Belum Dibuat</p>
            <i class="bi bi-envelope"></i>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card green">
            <h3><?= $stats->pending_penguji ?? 0 ?></h3>
            <p>Desiminasi Belum Penguji</p>
            <i class="bi bi-person-check"></i>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card orange">
            <h3><?= $stats->pending_jadwal ?? 0 ?></h3>
            <p>Desiminasi Belum Jadwal</p>
            <i class="bi bi-calendar-event"></i>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Quick Actions -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-lightning me-2"></i>Aksi Cepat
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="<?= base_url('admin/dpl') ?>" class="btn btn-outline-primary w-100 py-3">
                            <i class="bi bi-person-plus d-block fs-3 mb-2"></i>
                            Assign DPL
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= base_url('admin/surat') ?>" class="btn btn-outline-success w-100 py-3">
                            <i class="bi bi-envelope d-block fs-3 mb-2"></i>
                            Buat Surat
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= base_url('sekretaris/desiminasi') ?>" class="btn btn-outline-warning w-100 py-3">
                            <i class="bi bi-calendar-check d-block fs-3 mb-2"></i>
                            Proses Desiminasi
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= base_url('admin/jadwal') ?>" class="btn btn-outline-danger w-100 py-3">
                            <i class="bi bi-calendar-event d-block fs-3 mb-2"></i>
                            Lihat Jadwal
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mahasiswa Pending DPL -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-people me-2"></i>Mahasiswa Menunggu Penugasan DPL</span>
                <a href="<?= base_url('admin/dpl') ?>" class="btn btn-sm btn-primary">Kelola</a>
            </div>
            <div class="card-body p-0">
                <?php if (isset($pending_dpl) && !empty($pending_dpl)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Instansi Tujuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($pending_dpl, 0, 5) as $m): ?>
                                    <tr>
                                        <td><?= $m->nim ?></td>
                                        <td><?= $m->nama_mahasiswa ?></td>
                                        <td><?= $m->instansi_tujuan ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/dpl/assign/' . $m->mahasiswa_id) ?>"
                                                class="btn btn-sm btn-primary">
                                                Assign DPL
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-check-circle display-1 text-success"></i>
                        <p class="text-muted mt-3">Semua mahasiswa sudah memiliki DPL</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Upcoming Desiminasi -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-calendar-week me-2"></i>Jadwal Desiminasi Mendatang
            </div>
            <div class="card-body">
                <?php if (isset($upcoming_jadwal) && !empty($upcoming_jadwal)): ?>
                    <?php foreach (array_slice($upcoming_jadwal, 0, 5) as $j): ?>
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <div>
                                <strong class="d-block"><?= $j->nama_mahasiswa ?></strong>
                                <small class="text-muted"><?= date('d M Y', strtotime($j->tanggal_desiminasi)) ?></small>
                            </div>
                            <span class="badge bg-primary"><?= $j->waktu_mulai ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">Tidak ada jadwal mendatang</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Dashboard Content Stats -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-bar-chart me-2"></i>Konten Dashboard
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span><i class="bi bi-building me-2"></i>Mitra Kerjasama</span>
                    <span class="badge bg-primary"><?= $stats->total_mitra ?? 0 ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span><i class="bi bi-geo-alt me-2"></i>Data Sebaran</span>
                    <span class="badge bg-secondary"><?= $stats->total_sebaran ?? 0 ?></span>
                </div>
                <hr>
                <a href="<?= base_url('admin/mitra') ?>" class="btn btn-outline-primary btn-sm w-100 mb-2">Kelola
                    Mitra</a>
                <a href="<?= base_url('admin/sebaran') ?>" class="btn btn-outline-secondary btn-sm w-100">Kelola
                    Sebaran</a>
            </div>
        </div>
    </div>
</div>
<!-- Dashboard Kaprodi Content -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Dashboard Ketua Program Studi</h4>
        <p class="text-muted mb-0">Persetujuan proposal magang dan monitoring</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card purple">
            <h3><?= $stats->pending_proposal ?? 0 ?></h3>
            <p>Proposal Menunggu ACC</p>
            <i class="bi bi-hourglass-split"></i>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card green">
            <h3><?= $stats->approved_proposal ?? 0 ?></h3>
            <p>Proposal Disetujui</p>
            <i class="bi bi-check-circle"></i>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card blue">
            <h3><?= $stats->total_mahasiswa ?? 0 ?></h3>
            <p>Total Mahasiswa Magang</p>
            <i class="bi bi-people"></i>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card orange">
            <h3><?= $stats->total_mitra ?? 0 ?></h3>
            <p>Mitra Kerjasama</p>
            <i class="bi bi-building"></i>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Proposal Pending ACC -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-file-earmark-check me-2"></i>Proposal Menunggu Persetujuan (Tahap 2)</span>
                <a href="<?= base_url('proposal/kaprodi') ?>" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <?php if (isset($pending_proposals) && !empty($pending_proposals)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Instansi</th>
                                    <th>Jenis</th>
                                    <th>ACC Koordinator</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pending_proposals as $p): ?>
                                    <tr>
                                        <td><?= $p->nim ?></td>
                                        <td><?= $p->nama_mahasiswa ?></td>
                                        <td><?= $p->instansi_tujuan ?></td>
                                        <td><span class="badge bg-secondary"><?= strtoupper($p->jenis_magang) ?></span></td>
                                        <td>
                                            <span class="badge badge-disetujui">
                                                <i class="bi bi-check-circle"></i> Disetujui
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= $p->link_proposal ?>" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('proposal/kaprodi/acc/' . $p->proposal_id) ?>"
                                                class="btn btn-sm btn-success">
                                                <i class="bi bi-check"></i> ACC
                                            </a>
                                            <a href="<?= base_url('proposal/kaprodi/reject/' . $p->proposal_id) ?>"
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
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <p class="text-muted mt-3">Tidak ada proposal yang menunggu persetujuan</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar Stats -->
    <div class="col-lg-4">
        <!-- Sebaran per Jenis -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-pie-chart me-2"></i>Sebaran Jenis Magang
            </div>
            <div class="card-body">
                <?php if (isset($sebaran_jenis) && !empty($sebaran_jenis)): ?>
                    <?php
                    $colors = ['reguler' => 'primary', 'bumn' => 'success', 'mbkm' => 'warning'];
                    foreach ($sebaran_jenis as $s):
                        ?>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>
                                <span class="badge bg-<?= $colors[$s->jenis_magang] ?? 'secondary' ?> me-2">&nbsp;</span>
                                <?= strtoupper($s->jenis_magang) ?>
                            </span>
                            <strong><?= $s->total ?></strong>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">Data belum tersedia</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Top Wilayah -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-geo-alt me-2"></i>Top Wilayah Magang
            </div>
            <div class="card-body">
                <?php if (isset($sebaran_wilayah) && !empty($sebaran_wilayah)): ?>
                    <?php foreach (array_slice($sebaran_wilayah, 0, 5) as $s): ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><?= $s->wilayah ?></span>
                            <span class="badge bg-secondary"><?= $s->total ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">Data belum tersedia</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
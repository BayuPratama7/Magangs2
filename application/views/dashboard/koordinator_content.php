<!-- Dashboard Koordinator Content -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Dashboard Koordinator Pengelola Magang</h4>
        <p class="text-muted mb-0">Kelola proposal magang dan monitoring logbook mahasiswa</p>
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
            <h3><?= $stats->desiminasi_selesai ?? 0 ?></h3>
            <p>Desiminasi Selesai</p>
            <i class="bi bi-trophy"></i>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card orange">
            <h3><?= $stats->total_mahasiswa ?? 0 ?></h3>
            <p>Mahasiswa Aktif</p>
            <i class="bi bi-people"></i>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Proposal Pending -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-file-earmark-text me-2"></i>Proposal Menunggu Persetujuan</span>
                <a href="<?= base_url('koordinator') ?>" class="btn btn-sm btn-primary">Lihat Semua</a>
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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($pending_proposals, 0, 5) as $p): ?>
                                    <tr>
                                        <td><?= $p->nim ?></td>
                                        <td><?= $p->nama_mahasiswa ?></td>
                                        <td><?= $p->instansi_tujuan ?></td>
                                        <td><span class="badge bg-secondary"><?= strtoupper($p->jenis_magang) ?></span></td>
                                        <td>
                                            <a href="<?= base_url('koordinator/detail/' . $p->proposal_id) ?>"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('koordinator/acc/' . $p->proposal_id) ?>"
                                                class="btn btn-sm btn-success">
                                                <i class="bi bi-check"></i>
                                            </a>
                                            <a href="<?= base_url('koordinator/reject/' . $p->proposal_id) ?>"
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

    <!-- Recent Logbooks -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-journal-text me-2"></i>Logbook Terbaru
            </div>
            <div class="card-body">
                <?php if (isset($recent_logbooks) && !empty($recent_logbooks)): ?>
                    <?php foreach (array_slice($recent_logbooks, 0, 5) as $l): ?>
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <strong class="d-block"><?= $l->nama_mahasiswa ?></strong>
                                <small class="text-muted">Bulan ke-<?= $l->bulan_ke ?></small>
                            </div>
                            <a href="<?= $l->link_logbook ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">Belum ada logbook</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Hasil Desiminasi Terakhir -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="bi bi-trophy me-2"></i>Hasil Desiminasi Terbaru
            </div>
            <div class="card-body">
                <?php if (isset($recent_hasil) && !empty($recent_hasil)): ?>
                    <?php foreach (array_slice($recent_hasil, 0, 3) as $h): ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><?= $h->nama_mahasiswa ?></span>
                            <span class="badge <?= $h->status_kelulusan == 'lulus' ? 'bg-success' : 'bg-warning' ?>">
                                <?= ucfirst($h->status_kelulusan) ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">Belum ada hasil desiminasi</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Progress Mahasiswa -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-bar-chart me-2"></i>Progress Mahasiswa Magang</span>
                <a href="<?= base_url('koordinator/hasil') ?>" class="btn btn-sm btn-primary">Lihat Hasil</a>
            </div>
            <div class="card-body p-0">
                <?php if (isset($mahasiswa_progress) && !empty($mahasiswa_progress)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Instansi</th>
                                    <th>Proposal</th>
                                    <th>Desiminasi</th>
                                    <th>Status Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($mahasiswa_progress as $m): ?>
                                    <tr>
                                        <td><?= $m->nim ?></td>
                                        <td><?= $m->nama_mahasiswa ?></td>
                                        <td><?= $m->instansi_tujuan ?? '-' ?></td>
                                        <td>
                                            <?php if ($m->status_kaprodi == 'disetujui'): ?>
                                                <span class="badge bg-success">ACC Kaprodi</span>
                                            <?php elseif ($m->status_koordinator == 'disetujui'): ?>
                                                <span class="badge bg-info">ACC Koordinator</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($m->status_kelulusan): ?>
                                                <?php 
                                                $badge = 'secondary';
                                                if ($m->status_kelulusan == 'lulus') $badge = 'success';
                                                elseif ($m->status_kelulusan == 'lulus_bersyarat') $badge = 'warning';
                                                elseif ($m->status_kelulusan == 'tidak_lulus') $badge = 'danger';
                                                ?>
                                                <span class="badge bg-<?= $badge ?>">
                                                    <?= ucfirst(str_replace('_', ' ', $m->status_kelulusan)) ?>
                                                </span>
                                            <?php elseif ($m->desiminasi_status): ?>
                                                <span class="badge bg-info">Proses</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Belum</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($m->status_laporan_akhir == 'disetujui'): ?>
                                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Selesai</span>
                                            <?php elseif ($m->status_laporan_akhir == 'revisi'): ?>
                                                <span class="badge bg-warning">Revisi</span>
                                            <?php elseif ($m->status_kelulusan): ?>
                                                <span class="badge bg-info">Menunggu Laporan</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">Belum ada data mahasiswa</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<style>
    .stat-custom { border: none; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    .bg-figma-green { background-color: #399d5a !important; color: white; }
    .bg-figma-blue { background-color: #3a7ef0 !important; color: white; }
    .bg-figma-yellow { background-color: #f7b92f !important; color: white; }
    .bg-figma-cyan { background-color: #15c3d2 !important; color: white; }
    .table-header-custom th { font-size: 0.75rem; color: #6c757d; font-weight: 600; text-transform: uppercase; border-bottom: 2px solid #f1f5f9; padding: 1rem 0.75rem; background: transparent; }
</style>

<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1"><i class="bi bi-check-circle me-2"></i>Hasil Desiminasi Mahasiswa</h4>
        <p class="text-muted mb-0">Data mahasiswa yang telah menyelesaikan desiminasi dan di-ACC penguji</p>
    </div>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Summary Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-custom bg-figma-green">
            <div class="card-body text-center py-4">
                <h2 class="mb-1 fw-bold"><?= count(array_filter($hasil ?? [], function($h) { return isset($h->status_laporan_akhir) && $h->status_laporan_akhir == 'disetujui'; })) ?></h2>
                <small class="fw-medium">Selesai (ACC Penguji)</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-custom bg-figma-blue">
            <div class="card-body text-center py-4">
                <h2 class="mb-1 fw-bold"><?= count(array_filter($hasil ?? [], function($h) { return $h->status_kelulusan == 'lulus'; })) ?></h2>
                <small class="fw-medium">Lulus</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-custom bg-figma-yellow">
            <div class="card-body text-center py-4">
                <h2 class="mb-1 fw-bold"><?= count(array_filter($hasil ?? [], function($h) { return $h->status_kelulusan == 'lulus_bersyarat'; })) ?></h2>
                <small class="fw-medium">Lulus Bersyarat</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-custom bg-figma-cyan">
            <div class="card-body text-center py-4">
                <h2 class="mb-1 fw-bold"><?= count($hasil ?? []) ?></h2>
                <small class="fw-medium">Total Hasil</small>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-2">
        <span class="fw-bold" style="color: #4b5563;"><i class="bi bi-inbox me-2"></i>Data Hasil Desiminasi</span>
    </div>
    <div class="card-body p-0">
        <?php if (empty($hasil)): ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <p class="text-muted mt-3">Belum ada hasil desiminasi</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-header-custom">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Judul/Instansi</th>
                            <th>Penguji</th>
                            <th class="text-center">Nilai</th>
                            <th>Status Kelulusan</th>
                            <th>Laporan Akhir</th>
                            <th>Status Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($hasil as $h): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $h->nim ?></td>
                                <td><strong><?= $h->nama_mahasiswa ?></strong></td>
                                <td>
                                    <strong><?= isset($h->judul_proposal) ? $h->judul_proposal : '-' ?></strong><br>
                                    <small class="text-muted"><?= isset($h->instansi_tujuan) ? $h->instansi_tujuan : '-' ?></small>
                                </td>
                                <td><?= isset($h->nama_penguji) ? $h->nama_penguji : '-' ?></td>
                                <td class="text-center">
                                    <span class="fs-5 fw-bold"><?= isset($h->nilai) ? $h->nilai : '-' ?></span>
                                </td>
                                <td>
                                    <?php
                                    $status = $h->status_kelulusan;
                                    $badge = 'secondary';
                                    if ($status == 'lulus') $badge = 'success';
                                    elseif ($status == 'lulus_bersyarat') $badge = 'warning';
                                    elseif ($status == 'tidak_lulus') $badge = 'danger';
                                    ?>
                                    <span class="badge bg-<?= $badge ?>">
                                        <?= ucfirst(str_replace('_', ' ', $status)) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($h->link_laporan_akhir)): ?>
                                        <a href="<?= $h->link_laporan_akhir ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-file-earmark-pdf me-1"></i>Lihat
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Belum upload</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $lap_status = isset($h->status_laporan_akhir) ? $h->status_laporan_akhir : null;
                                    if ($lap_status == 'disetujui'): ?>
                                        <span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i>ACC PENGUJI</span>
                                        <?php if (isset($h->tanggal_acc_laporan_akhir) && $h->tanggal_acc_laporan_akhir): ?>
                                            <br><small class="text-success"><?= format_indo('d M Y', strtotime($h->tanggal_acc_laporan_akhir)) ?></small>
                                        <?php endif; ?>
                                    <?php elseif ($lap_status == 'menunggu_revisi'): ?>
                                        <span class="badge bg-info">Revisi Diupload</span>
                                    <?php elseif ($lap_status == 'revisi'): ?>
                                        <span class="badge bg-warning">Perlu Revisi</span>
                                    <?php elseif ($lap_status == 'menunggu'): ?>
                                        <span class="badge bg-primary">Menunggu ACC</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Proses</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>



<!-- Dosen Jadwal Desiminasi View -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Jadwal Desiminasi</h4>
        <p class="text-muted mb-0">Jadwal desiminasi mahasiswa bimbingan Anda</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-calendar-event me-2"></i>Daftar Jadwal
    </div>
    <div class="card-body p-0">
        <?php if (!empty($jadwal)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Mahasiswa</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Ruangan</th>
                            <th>Status Jadwal</th>
                            <th>Hasil</th>
                            <th>Laporan Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jadwal as $j): ?>
                            <tr>
                                <td>
                                    <strong><?= $j->nama_mahasiswa ?></strong><br>
                                    <small class="text-muted"><?= $j->nim ?></small>
                                </td>
                                <td><?= isset($j->judul_proposal) ? $j->judul_proposal : '-' ?></td>
                                <td><?= date('d M Y', strtotime($j->tanggal_desiminasi)) ?></td>
                                <td><?= date('H:i', strtotime($j->waktu_mulai)) ?> -
                                    <?= date('H:i', strtotime($j->waktu_selesai)) ?></td>
                                <td><?= $j->ruangan ?></td>
                                <td>
                                    <?php
                                    $today = date('Y-m-d');
                                    if ($j->tanggal_desiminasi < $today) {
                                        echo '<span class="badge bg-secondary">Selesai</span>';
                                    } elseif ($j->tanggal_desiminasi == $today) {
                                        echo '<span class="badge bg-success">Hari Ini</span>';
                                    } else {
                                        echo '<span class="badge bg-primary">Akan Datang</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if (isset($j->status_kelulusan) && $j->status_kelulusan): ?>
                                        <?php
                                        $badge = 'secondary';
                                        if ($j->status_kelulusan == 'lulus') $badge = 'success';
                                        elseif ($j->status_kelulusan == 'lulus_bersyarat') $badge = 'warning';
                                        elseif ($j->status_kelulusan == 'tidak_lulus') $badge = 'danger';
                                        ?>
                                        <span class="badge bg-<?= $badge ?>">
                                            <?= ucfirst(str_replace('_', ' ', $j->status_kelulusan)) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Belum</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (isset($j->status_laporan_akhir) && $j->status_laporan_akhir == 'disetujui'): ?>
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>ACC Penguji</span>
                                        <?php if ($j->tanggal_acc_laporan_akhir): ?>
                                            <br><small class="text-muted"><?= date('d M Y', strtotime($j->tanggal_acc_laporan_akhir)) ?></small>
                                        <?php endif; ?>
                                    <?php elseif (isset($j->status_laporan_akhir) && $j->status_laporan_akhir == 'menunggu_revisi'): ?>
                                        <span class="badge bg-info">Revisi Diupload</span>
                                    <?php elseif (isset($j->status_laporan_akhir) && $j->status_laporan_akhir == 'revisi'): ?>
                                        <span class="badge bg-warning">Perlu Revisi</span>
                                    <?php elseif (isset($j->status_laporan_akhir) && $j->status_laporan_akhir == 'menunggu'): ?>
                                        <span class="badge bg-primary">Menunggu ACC</span>
                                    <?php elseif (isset($j->link_laporan_akhir) && $j->link_laporan_akhir): ?>
                                        <span class="badge bg-info">Diupload</span>
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
            <div class="text-center py-5">
                <i class="bi bi-calendar-x display-1 text-muted"></i>
                <p class="text-muted mt-3">Belum ada jadwal desiminasi</p>
            </div>
        <?php endif; ?>
    </div>
</div>
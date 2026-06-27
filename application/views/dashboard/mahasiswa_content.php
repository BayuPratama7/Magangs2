<!-- Dashboard Mahasiswa Content -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Selamat Datang, <?= $mahasiswa->nama_mahasiswa ?? 'Mahasiswa' ?></h4>
        <p class="text-muted mb-0">NIM: <?= $mahasiswa->nim ?? '-' ?> | <?= $mahasiswa->prodi ?? 'Sistem Informasi' ?></p>
    </div>
</div>

<!-- Status Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card purple">
            <h3><?= $stats->status_proposal ?? 'Belum' ?></h3>
            <p>Status Proposal</p>
            <i class="bi bi-file-earmark-text"></i>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card blue">
            <h3><?= $stats->logbook_count ?? 0 ?>/3</h3>
            <p>Logbook Terisi</p>
            <i class="bi bi-journal-text"></i>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card green">
            <h3><?= $stats->laporan_status ?? 'Belum' ?></h3>
            <p>Status Laporan</p>
            <i class="bi bi-file-earmark-pdf"></i>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <?php
        $desi_status = $stats->desiminasi_status ?? 'Belum';
        $desi_card_class = 'orange'; // default
        if (in_array($desi_status, ['Lulus', 'Selesai'])) {
            $desi_card_class = 'green';
        } elseif (in_array($desi_status, ['Tidak lulus', 'Perlu Revisi'])) {
            $desi_card_class = 'red';
        } elseif (in_array($desi_status, ['Terjadwal', 'Menunggu ACC', 'Lulus bersyarat'])) {
            $desi_card_class = 'blue';
        }
        ?>
        <div class="stat-card <?= $desi_card_class ?>">
            <h3><?= $desi_status ?></h3>
            <p>Status Desiminasi</p>
            <i class="bi bi-easel"></i>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Alur Magang -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-diagram-3 me-2"></i>Alur Proses Magang</span>
                <!-- Link Drive Panduan Magang (Silakan sesuaikan link URL nya) -->
                <a href="https://drive.google.com/file/d/1jkedpmmJuEwWl5CL6nDIMs3TUA8Oy__C/view?usp=drive_link" target="_blank" class="btn btn-primary btn-sm shadow-sm" style="border-radius: 6px;">
                    <i class="bi bi-book me-1"></i>Panduan Magang
                </a>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col">
                        <a href="<?= base_url('proposal') ?>" class="text-decoration-none">
                            <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center <?= isset($proposal) ? 'bg-success' : 'bg-secondary' ?>"
                                style="width: 50px; height: 50px; cursor: pointer; transition: transform 0.2s;">
                                <i class="bi bi-1-circle-fill text-white fs-5"></i>
                            </div>
                            <small class="d-block text-dark">Proposal</small>
                        </a>
                    </div>
                    <div class="col">
                        <?php
                        $butuh_surat_dashboard = isset($proposal) && isset($proposal->butuh_surat_pengantar) ? (int)$proposal->butuh_surat_pengantar : 1;
                        $surat_step_done = ($butuh_surat_dashboard == 0) || (isset($surat_pengantar) && $surat_pengantar);
                        ?>
                        <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center <?= $surat_step_done ? 'bg-success' : 'bg-secondary' ?>"
                            style="width: 50px; height: 50px;">
                            <i class="bi bi-2-circle-fill text-white fs-5"></i>
                        </div>
                        <small class="d-block"><?= $butuh_surat_dashboard == 0 ? 'Tanpa Surat' : 'Surat Pengantar' ?></small>
                    </div>
                    <div class="col">
                        <a href="<?= base_url('logbook') ?>" class="text-decoration-none">
                            <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center <?= ($stats->logbook_count ?? 0) >= 3 ? 'bg-success' : 'bg-secondary' ?>"
                                style="width: 50px; height: 50px; cursor: pointer; transition: transform 0.2s;">
                                <i class="bi bi-3-circle-fill text-white fs-5"></i>
                            </div>
                            <small class="d-block text-dark">Logbook</small>
                        </a>
                    </div>
                    <div class="col">
                        <a href="<?= base_url('laporan') ?>" class="text-decoration-none">
                            <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center <?= ($stats->laporan_status ?? 'Belum') != 'Belum' ? 'bg-success' : 'bg-secondary' ?>"
                                style="width: 50px; height: 50px; cursor: pointer; transition: transform 0.2s;">
                                <i class="bi bi-4-circle-fill text-white fs-5"></i>
                            </div>
                            <small class="d-block text-dark">Laporan</small>
                        </a>
                    </div>
                    <div class="col">
                        <a href="<?= base_url('desiminasi') ?>" class="text-decoration-none">
                            <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center <?= ($stats->desiminasi_status ?? 'Belum') != 'Belum' ? 'bg-success' : 'bg-secondary' ?>"
                                style="width: 50px; height: 50px; cursor: pointer; transition: transform 0.2s;">
                                <i class="bi bi-5-circle-fill text-white fs-5"></i>
                            </div>
                            <small class="d-block text-dark">Desiminasi</small>
                        </a>
                    </div>
                    <div class="col">
                        <?php
                        $selesai_done = (isset($hasil_desiminasi) && $hasil_desiminasi && $hasil_desiminasi->status_laporan_akhir == 'disetujui');
                        ?>
                        <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center <?= $selesai_done ? 'bg-success' : 'bg-secondary' ?>"
                            style="width: 50px; height: 50px;">
                            <i class="bi bi-check-circle-fill text-white fs-5"></i>
                        </div>
                        <small class="d-block"><?= $selesai_done ? '<strong class="text-success">Selesai ✓</strong>' : 'Selesai' ?></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Proposal -->
        <?php if (isset($proposal)): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <i class="bi bi-file-earmark-text me-2"></i>Detail Proposal Magang
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td width="200"><strong>Judul Proposal</strong></td>
                            <td><?= $proposal->judul_proposal ?></td>
                        </tr>
                        <tr>
                            <td><strong>Instansi Tujuan</strong></td>
                            <td><?= $proposal->instansi_tujuan ?></td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Magang</strong></td>
                            <td><span class="badge bg-primary"><?= strtoupper($proposal->jenis_magang) ?></span></td>
                        </tr>
                        <tr>
                            <td><strong>Status Koordinator</strong></td>
                            <td>
                                <span class="badge badge-<?= $proposal->status_koordinator ?>">
                                    <?= ucfirst($proposal->status_koordinator) ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Status Kaprodi</strong></td>
                            <td>
                                <span class="badge badge-<?= $proposal->status_kaprodi ?>">
                                    <?= ucfirst($proposal->status_kaprodi) ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Link Proposal</strong></td>
                            <td><a href="<?= $proposal->link_proposal ?>" target="_blank"
                                    class="btn btn-sm btn-outline-primary"><i
                                        class="bi bi-box-arrow-up-right me-1"></i>Buka</a></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Surat Pengantar -->
            <?php
            $butuh_surat_mhs = isset($proposal->butuh_surat_pengantar) ? (int)$proposal->butuh_surat_pengantar : 1;
            ?>
            <?php if ($butuh_surat_mhs == 1 && isset($surat_pengantar) && $surat_pengantar): ?>
                <div class="card mt-4">
                    <div class="card-header bg-success text-white">
                        <i class="bi bi-envelope-check me-2"></i>Surat Pengantar Magang
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success mb-3">
                            <i class="bi bi-check-circle me-2"></i>
                            Surat pengantar Anda sudah tersedia untuk didownload!
                        </div>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td width="200"><strong>Nomor Surat</strong></td>
                                <td><?= $surat_pengantar->nomor_surat ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Surat</strong></td>
                                <td><?= format_indo('d F Y', strtotime($surat_pengantar->tanggal_surat)) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tujuan</strong></td>
                                <td><?= $surat_pengantar->tujuan_instansi ?></td>
                            </tr>
                            <?php if ($surat_pengantar->perihal): ?>
                            <tr>
                                <td><strong>Perihal</strong></td>
                                <td><?= $surat_pengantar->perihal ?></td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <td><strong>Download Surat</strong></td>
                                <td>
                                    <a href="<?= $surat_pengantar->file_surat ?>" target="_blank" class="btn btn-primary">
                                        <i class="bi bi-download me-2"></i>Download Surat Pengantar
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php elseif ($proposal->status_kaprodi == 'disetujui' && $butuh_surat_mhs == 1): ?>
                <div class="card mt-4">
                    <div class="card-header">
                        <i class="bi bi-envelope me-2"></i>Surat Pengantar Magang
                    </div>
                    <div class="card-body text-center py-4">
                        <i class="bi bi-hourglass-split display-4 text-warning"></i>
                        <p class="text-muted mt-3 mb-0">Proposal Anda sudah disetujui. Surat pengantar sedang diproses oleh sekretaris.</p>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="card mt-4">
                <div class="card-body text-center py-5">
                    <i class="bi bi-file-earmark-plus display-1 text-muted"></i>
                    <h5 class="mt-3">Belum Ada Proposal</h5>
                    <p class="text-muted">Silakan ajukan proposal magang terlebih dahulu</p>
                    <a href="<?= base_url('proposal') ?>" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i>Ajukan Proposal
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Status Balasan Mitra (jika proposal approved) -->
        <?php if (isset($proposal) && $proposal && $proposal->status_kaprodi == 'disetujui'): ?>
            <?php $butuh_surat_status = isset($proposal->butuh_surat_pengantar) ? (int)$proposal->butuh_surat_pengantar : 1; ?>
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-inbox-check me-2"></i>Status Balasan Mitra
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Surat Pengantar</h6>
                            <?php if ($butuh_surat_status == 0): ?>
                                <div class="badge bg-secondary">Tidak Diperlukan</div>
                                <small class="d-block mt-2 text-muted">Langsung upload balasan mitra</small>
                            <?php elseif (isset($surat_pengantar) && $surat_pengantar): ?>
                                <div class="badge bg-success">Sudah Dibuat</div>
                                <small class="d-block mt-2"><strong><?= $surat_pengantar->nomor_surat ?></strong></small>
                            <?php else: ?>
                                <div class="badge bg-warning">Dalam Proses</div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Balasan Mitra</h6>
                            <?php if ($proposal->status_mitra == 'diterima'): ?>
                                <div class="badge bg-success">Diterima ✓</div>
                                <small class="d-block mt-2 text-success"><strong>Menunggu Penugasan DPL</strong></small>
                            <?php elseif ($proposal->status_mitra == 'ditolak'): ?>
                                <div class="badge bg-danger">Ditolak</div>
                            <?php else: ?>
                                <div class="badge bg-warning">Menunggu Upload</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <hr>
                    <a href="<?= base_url('proposal') ?>" class="btn btn-sm btn-info">Lihat Detail</a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Info DPL -->
        <?php if (isset($dpl) && $dpl): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <i class="bi bi-person-badge me-2"></i>Dosen Pembimbing Lapangan
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                            style="width: 60px; height: 60px; font-size: 1.5rem;">
                            <?= strtoupper(substr($dpl->nama_dosen, 0, 1)) ?>
                        </div>
                        <div>
                            <h6 class="mb-1"><?= $dpl->nama_dosen ?></h6>
                            <p class="text-muted mb-0 small"><?= $dpl->email ?? '-' ?></p>
                            <p class="text-muted mb-0 small"><?= $dpl->no_hp ?? '-' ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Jadwal Desiminasi -->
        <?php if (isset($desiminasi) && $desiminasi && $desiminasi->tanggal_desiminasi): ?>
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-calendar-event me-2"></i>Jadwal Desiminasi
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                    style="width: 45px; height: 45px; min-width: 45px;">
                                    <i class="bi bi-calendar-date text-primary fs-5"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Tanggal</small>
                                    <strong><?= format_indo('d F Y', strtotime($desiminasi->tanggal_desiminasi)) ?></strong>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                    style="width: 45px; height: 45px; min-width: 45px;">
                                    <i class="bi bi-clock text-success fs-5"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Waktu</small>
                                    <strong><?= date('H:i', strtotime($desiminasi->waktu_mulai)) ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                    style="width: 45px; height: 45px; min-width: 45px;">
                                    <i class="bi bi-geo-alt text-warning fs-5"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Ruangan</small>
                                    <strong><?= $desiminasi->ruangan ?? 'Online' ?></strong>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                    style="width: 45px; height: 45px; min-width: 45px;">
                                    <i class="bi bi-person-workspace text-info fs-5"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Penguji</small>
                                    <strong><?= $desiminasi->nama_penguji ?? '-' ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (isset($hasil_desiminasi) && $hasil_desiminasi && $hasil_desiminasi->status_kelulusan): ?>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-trophy me-1"></i>Hasil:
                                <strong class="text-<?= $hasil_desiminasi->status_kelulusan == 'lulus' ? 'success' : ($hasil_desiminasi->status_kelulusan == 'lulus_bersyarat' ? 'warning' : 'danger') ?>">
                                    <?= strtoupper(str_replace('_', ' ', $hasil_desiminasi->status_kelulusan)) ?>
                                </strong>
                            </span>
                            <a href="<?= base_url('desiminasi') ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-arrow-right me-1"></i>Detail
                            </a>
                        </div>
                        <?php if ($hasil_desiminasi->status_laporan_akhir == 'disetujui'): ?>
                            <div class="alert alert-success mt-3 mb-0 py-2">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <strong>Selamat!</strong> Seluruh proses magang Anda telah selesai.
                            </div>
                        <?php elseif (empty($hasil_desiminasi->link_laporan_akhir) && in_array($hasil_desiminasi->status_kelulusan, ['lulus', 'lulus_bersyarat'])): ?>
                            <div class="alert alert-info mt-3 mb-0 py-2">
                                <i class="bi bi-info-circle me-2"></i>
                                Silakan <a href="<?= base_url('desiminasi') ?>" class="alert-link">upload laporan akhir</a> untuk diserahkan ke penguji.
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <hr class="my-2">
                        <div class="text-center">
                            <a href="<?= base_url('desiminasi') ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-arrow-right me-1"></i>Lihat Detail Desiminasi
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-lg-4">
        <!-- Sebaran Magang -->
        <?php $this->load->view('dashboard/_sebaran_cards', ['filter_url' => base_url('dashboard/mahasiswa/sebaran_filter')]); ?>

        <!-- Mitra Kerjasama -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-building me-2"></i>Mitra Kerjasama
            </div>
            <div class="card-body">
                <?php if (isset($mitra) && !empty($mitra)): ?>
                    <ul class="list-unstyled mb-0">
                        <?php foreach (array_slice($mitra, 0, 5) as $m): ?>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <small><?= $m->nama_mitra ?></small>
                                <span class="badge bg-light text-dark float-end"><?= $m->kota ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                <?php else: ?>
                    <p class="text-muted mb-0 small">Data belum tersedia</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>



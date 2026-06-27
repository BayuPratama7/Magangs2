<!-- Daftar Pengajuan Desiminasi -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Pengajuan Desiminasi</h4>
        <p class="text-muted mb-0">Kelola pengajuan desiminasi mahasiswa</p>
    </div>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('info')): ?>
    <div class="alert alert-info alert-dismissible fade show">
        <?= $this->session->flashdata('info') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <?php if (!empty($pengajuan)): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-white">
                        <tr>
                            <th class="text-secondary border-bottom-0 text-uppercase" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; padding: 1.5rem 1.25rem;">NIM</th>
                            <th class="text-secondary border-bottom-0 text-uppercase" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; padding: 1.5rem 1.25rem;">Nama Mahasiswa</th>

                            <th class="text-secondary border-bottom-0 text-uppercase" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; padding: 1.5rem 1.25rem;">Penguji</th>
                            <th class="text-secondary border-bottom-0 text-uppercase" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; padding: 1.5rem 1.25rem;">Tanggal Dijadwalkan</th>
                            <th class="text-secondary border-bottom-0 text-uppercase" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; padding: 1.5rem 1.25rem;">Ruangan</th>
                            <th class="text-secondary border-bottom-0 text-uppercase" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; padding: 1.5rem 1.25rem;">Status</th>
                            <th class="text-secondary border-bottom-0 text-uppercase" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; padding: 1.5rem 1.25rem;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pengajuan as $d): ?>
                            <tr>
                                <td style="padding: 1.25rem; font-size: 0.9rem; font-weight: 600; color: #2d3748;"><?= $d->nim ?></td>
                                <td style="padding: 1.25rem; font-size: 0.9rem; font-weight: 500; color: #4a5568; max-width: 120px;">
                                    <?= $d->nama_mahasiswa ?>
                                </td>

                                <td style="padding: 1.25rem; font-size: 0.9rem; color: #4a5568;">
                                    <?= $d->nama_penguji ?? '-' ?>
                                </td>
                                <td style="padding: 1.25rem;">
                                    <?php if ($d->tanggal_desiminasi): ?>
                                        <div class="d-flex flex-column">
                                            <span style="font-size: 0.9rem; font-weight: 500; color: #2d3748;"><?= format_indo('d M Y', strtotime($d->tanggal_desiminasi)) ?></span>
                                            <span class="text-muted" style="font-size: 0.8rem;"><?= format_indo('H:i', strtotime($d->waktu_mulai)) ?> - <?= $d->waktu_selesai ? format_indo('H:i', strtotime($d->waktu_selesai)) : 'Selesai' ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted" style="font-size: 0.9rem;">-</span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 1.25rem; font-size: 0.9rem; font-weight: 600; color: #2d3748;">
                                    <?= $d->ruangan ?? '-' ?>
                                </td>
                                <td style="padding: 1.25rem;">
                                    <?php
                                        if ($d->status_pengajuan == 'menunggu') {
                                            echo '<span class="badge" style="background-color: #edf2f7; color: #4a5568; font-weight: 500; padding: 0.5em 0.8em; border-radius: 6px;">Menunggu Proses</span>';
                                        } elseif ($d->status_pengajuan == 'diterima') {
                                            if ($d->konfirmasi_penguji == 'menunggu') {
                                                echo '<span class="badge" style="background-color: #fbd38d; color: #975a16; font-weight: 600; padding: 0.5em 0.8em; border-radius: 6px;">Menunggu Konfirmasi</span>';
                                            } elseif ($d->konfirmasi_penguji == 'bersedia') {
                                                echo '<span class="badge" style="background-color: #c6f6d5; color: #22543d; font-weight: 600; padding: 0.5em 0.8em; border-radius: 6px;">Terkonfirmasi</span>';
                                            } elseif ($d->konfirmasi_penguji == 'ditolak') {
                                                echo '<span class="badge" style="background-color: #fed7d7; color: #822727; font-weight: 600; padding: 0.5em 0.8em; border-radius: 6px;">Ditolak Penguji</span>';
                                            }
                                        } elseif ($d->status_pengajuan == 'ditolak') {
                                            echo '<span class="badge" style="background-color: #fed7d7; color: #822727; font-weight: 600; padding: 0.5em 0.8em; border-radius: 6px;">Ditolak Sekretaris</span>';
                                        }
                                    ?>
                                </td>
                                <td style="padding: 1.25rem;">
                                    <?php if ($d->status_pengajuan == 'menunggu'): ?>
                                        <a href="<?= base_url('sekretaris/desiminasi/proses/' . $d->desiminasi_id) ?>"
                                            class="btn btn-sm" style="color: #4285f4; border: 1px solid #c6d8fc; background-color: transparent; border-radius: 6px; padding: 0.35rem 0.75rem; font-weight: 500;">
                                            <i class="bi bi-gear me-1"></i> Proses
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('sekretaris/desiminasi/proses/' . $d->desiminasi_id) ?>" class="btn btn-sm" style="color: #4285f4; border: 1px solid #c6d8fc; background-color: transparent; border-radius: 6px; padding: 0.35rem 0.75rem; font-weight: 500;">
                                            <i class="bi bi-eye me-1"></i> Detail
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <div style="width: 80px; height: 80px; border-radius: 50%; border: 4px solid #48bb78; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                    <i class="bi bi-check-lg" style="font-size: 3rem; color: #48bb78;"></i>
                </div>
                <p class="text-muted">Tidak ada pengajuan desiminasi yang menunggu proses</p>
            </div>
        <?php endif; ?>
    </div>
</div>

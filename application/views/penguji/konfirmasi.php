<!-- Penguji Konfirmasi View -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Konfirmasi Kesediaan Menguji</h4>
        <p class="text-muted mb-0">Konfirmasi kesediaan Anda untuk menguji desiminasi mahasiswa</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-question-circle me-2"></i>Permintaan Menguji</h6>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($pending)): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-secondary border-bottom-0" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px; padding: 1rem 1.25rem;">NIM</th>
                            <th class="text-secondary border-bottom-0" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px; padding: 1rem 1.25rem;">NAMA MAHASISWA</th>
                            <th class="text-secondary border-bottom-0 text-uppercase" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px; padding: 1rem 1.25rem;">INSTANSI</th>

                            <th class="text-secondary border-bottom-0" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px; padding: 1rem 1.25rem;">JADWAL DESIMINASI</th>
                            <th class="text-secondary border-bottom-0" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px; padding: 1rem 1.25rem;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending as $p): ?>
                            <tr>
                                <td style="padding: 1rem 1.25rem; font-size: 0.9rem;"><?= $p->nim ?></td>
                                <td style="padding: 1rem 1.25rem; font-size: 0.9rem; font-weight: 500; color: #2d3748;"><?= $p->nama_mahasiswa ?></td>
                                <td style="padding: 1rem 1.25rem; font-size: 0.85rem; color: #4a5568; max-width: 150px; line-height: 1.4;"><?= $p->instansi_tujuan ?></td>

                                <td style="padding: 1rem 1.25rem;">
                                    <?php if ($p->tanggal_desiminasi): ?>
                                        <div class="d-flex flex-column">
                                            <span style="font-size: 0.85rem; font-weight: 600; color: #4a5568;"><i class="bi bi-calendar-event me-1"></i> <?= format_indo('d M Y', strtotime($p->tanggal_desiminasi)) ?></span>
                                            <span class="text-muted" style="font-size: 0.8rem;"><i class="bi bi-clock me-1"></i> <?= format_indo('H:i', strtotime($p->waktu_mulai)) ?> - <?= $p->waktu_selesai ? format_indo('H:i', strtotime($p->waktu_selesai)) : 'Selesai' ?></span>
                                            <span class="text-muted" style="font-size: 0.8rem;"><i class="bi bi-geo-alt me-1"></i> <?= $p->ruangan ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Belum Dijadwalkan</span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 1rem 1.25rem;">
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm" style="background-color: #3b82f6; color: white; border: none; padding: 0.4rem 1rem; border-radius: 6px; font-weight: 600; font-size: 0.85rem;" data-bs-toggle="modal"
                                            data-bs-target="#terimaModal<?= $p->desiminasi_id ?>">
                                            Konfirmasi
                                        </button>
                                        <a href="<?= base_url('penguji/detail/' . $p->desiminasi_id) ?>" class="btn btn-sm" style="background-color: transparent; color: #3b82f6; border: 1px solid #3b82f6; padding: 0.4rem 1rem; border-radius: 6px; font-weight: 600; font-size: 0.85rem; text-decoration: none;">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <p class="text-muted mt-3">Tidak ada permintaan menguji</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modals -->
<?php if (!empty($pending)): ?>
    <?php foreach ($pending as $p): ?>
        <!-- Modal Bersedia -->
        <div class="modal fade" id="terimaModal<?= $p->desiminasi_id ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="bi bi-check-circle me-2"></i>Konfirmasi Bersedia Menguji</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <i class="bi bi-person-check display-4 text-success"></i>
                        </div>
                        <div class="card bg-light mb-3">
                            <div class="card-body py-2">
                                <table class="table table-borderless table-sm mb-0">
                                    <tr>
                                        <td width="100"><strong>NIM</strong></td>
                                        <td><?= $p->nim ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nama</strong></td>
                                        <td><?= $p->nama_mahasiswa ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Judul</strong></td>
                                        <td><?= $p->judul_proposal ?></td>
                                    </tr>
                                    <?php if (!empty($p->instansi_tujuan)): ?>
                                    <tr>
                                        <td><strong>Instansi</strong></td>
                                        <td><?= $p->instansi_tujuan ?></td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                        <p class="text-center text-muted mb-0">
                            Apakah Anda <strong>bersedia</strong> menjadi penguji desiminasi untuk mahasiswa ini?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x me-1"></i>Batal
                        </button>
                        <a href="<?= base_url('penguji/konfirmasi_terima/' . $p->desiminasi_id) ?>" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Ya, Saya Bersedia
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ubah Jadwal -->
        <div class="modal fade" id="ubahJadwalModal<?= $p->desiminasi_id ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="<?= base_url('penguji/proses_ubah_jadwal/' . $p->desiminasi_id) ?>" method="POST">
                        <div class="modal-header text-dark" style="background-color: #ecc94b; border-bottom: none;">
                            <h5 class="modal-title" style="color: #744210;"><i class="bi bi-calendar-x me-2"></i>Ubah Jadwal Desiminasi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-warning" style="background-color: #fefcbf; border-color: #f6e05e; color: #744210; border-radius: 8px;">
                                <i class="bi bi-info-circle me-2"></i>Silakan tentukan jadwal alternatif. Jadwal akan otomatis diperbarui dan disetujui.
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small text-uppercase">Tanggal Desiminasi</label>
                                <input type="date" class="form-control" name="tanggal_desiminasi" value="<?= $p->tanggal_desiminasi ?>" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-secondary small text-uppercase">Waktu Mulai</label>
                                    <input type="time" class="form-control" name="waktu_mulai" value="<?= format_indo('H:i', strtotime($p->waktu_mulai)) ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-secondary small text-uppercase">Waktu Selesai</label>
                                    <input type="time" class="form-control" name="waktu_selesai" value="<?= $p->waktu_selesai ? format_indo('H:i', strtotime($p->waktu_selesai)) : '' ?>" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-secondary small text-uppercase">Ruangan</label>
                                    <input type="text" class="form-control" name="ruangan" value="<?= $p->ruangan ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-secondary small text-uppercase">Link Online</label>
                                    <input type="url" class="form-control" name="link_online" value="<?= isset($p->link_online) ? $p->link_online : '' ?>" placeholder="https://...">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn" style="background-color: #ecc94b; color: #744210; font-weight: 500;">
                                <i class="bi bi-save me-1"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

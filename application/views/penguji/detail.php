<!-- Detail Mahasiswa View -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Detail Mahasiswa</h4>
        <p class="text-muted mb-0">Detail mahasiswa yang ditugaskan kepada Anda sebagai penguji desiminasi.</p>
    </div>
</div>

<div class="row">
    <!-- Left Card: Data Mahasiswa -->
    <div class="col-md-5 mb-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-person me-2"></i>Data Mahasiswa</h6>
            </div>
            <div class="card-body p-4">
                <table class="table table-borderless table-sm mb-4">
                    <tr>
                        <td width="130" class="text-muted">NIM</td>
                        <td width="10">:</td>
                        <td class="fw-semibold text-dark"><?= $desiminasi->nim ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Nama</td>
                        <td>:</td>
                        <td class="fw-semibold text-dark"><?= $desiminasi->nama_mahasiswa ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Instansi</td>
                        <td>:</td>
                        <td class="fw-semibold text-dark"><?= $desiminasi->instansi_tujuan ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Diajukan Oleh</td>
                        <td>:</td>
                        <td class="fw-semibold text-dark"><?= $desiminasi->nama_mahasiswa ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal Pengajuan</td>
                        <td>:</td>
                        <td class="fw-semibold text-dark"><?= format_indo('d F Y', strtotime($desiminasi->tanggal_pengajuan)) ?></td>
                    </tr>
                </table>

                <?php if (!empty($desiminasi->link_laporan)): ?>
                <a href="<?= $desiminasi->link_laporan ?>" target="_blank" class="btn btn-outline-primary w-100" style="border-radius: 8px; font-weight: 500;">
                    <i class="bi bi-file-earmark-text me-2"></i>Lihat Laporan
                </a>
                <?php else: ?>
                <button class="btn btn-outline-secondary w-100" style="border-radius: 8px; font-weight: 500;" disabled>
                    <i class="bi bi-file-earmark-text me-2"></i>Laporan Belum Diunggah
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Right Card: Jadwal Desiminasi -->
    <div class="col-md-7 mb-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-calendar-event me-2"></i>Jadwal Desiminasi</h6>
            </div>
            <div class="card-body p-4">
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark small">Tanggal</label>
                        <div class="position-relative">
                            <input type="text" class="form-control bg-light" value="<?= isset($jadwal->tanggal_desiminasi) ? format_indo('d F Y', strtotime($jadwal->tanggal_desiminasi)) : '' ?>" readonly style="padding-right: 35px;">
                            <i class="bi bi-calendar3 position-absolute text-muted" style="right: 12px; top: 50%; transform: translateY(-50%);"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark small">Waktu</label>
                        <div class="position-relative">
                            <?php 
                                $waktu_mulai = isset($jadwal->waktu_mulai) ? format_indo('H:i', strtotime($jadwal->waktu_mulai)) : '';
                                $waktu_selesai = isset($jadwal->waktu_selesai) && $jadwal->waktu_selesai ? format_indo('H:i', strtotime($jadwal->waktu_selesai)) : '';
                                $waktu_teks = ($waktu_mulai && $waktu_selesai) ? $waktu_mulai . ' - ' . $waktu_selesai : $waktu_mulai;
                            ?>
                            <input type="text" class="form-control bg-light" value="<?= $waktu_teks ?>" readonly style="padding-right: 35px;">
                            <i class="bi bi-clock position-absolute text-muted" style="right: 12px; top: 50%; transform: translateY(-50%);"></i>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark small">Ruangan</label>
                    <input type="text" class="form-control bg-light" value="<?= isset($jadwal->ruangan) ? $jadwal->ruangan : '' ?>" readonly>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark small">Link Online (jika ada)</label>
                    <input type="url" class="form-control bg-light" value="<?= isset($jadwal->link_online) ? $jadwal->link_online : '-' ?>" readonly>
                </div>

                <div class="alert mb-4" style="background-color: #f0f7ff; color: #1e40af; border: none; border-radius: 8px;">
                    <div class="d-flex">
                        <i class="bi bi-info-circle me-2 mt-1"></i>
                        <div>
                            Jadwal di atas dibuat oleh Sekretaris Prodi.<br>
                            Anda dapat mengubah jadwal jika diperlukan.
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button type="button" class="btn btn-outline-primary flex-grow-1 d-flex align-items-center justify-content-center" style="border-radius: 8px; font-weight: 500;" data-bs-toggle="modal" data-bs-target="#ubahJadwalModal">
                        <i class="bi bi-pencil me-2"></i>Ubah Jadwal
                    </button>
                    <a href="<?= base_url('penguji/konfirmasi_terima/' . $desiminasi->desiminasi_id) ?>" class="btn btn-primary flex-grow-1 d-flex align-items-center justify-content-center" style="background-color: #2563eb; border-radius: 8px; font-weight: 500;">
                        <i class="bi bi-check me-2"></i>Konfirmasi Jadwal
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ubah Jadwal -->
<div class="modal fade" id="ubahJadwalModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px;">
            <div class="modal-header text-white" style="background-color: #0277bd; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <h5 class="modal-title fw-semibold">Ubah Jadwal Diseminasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('penguji/proses_ubah_jadwal/' . $desiminasi->desiminasi_id) ?>" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-4 p-3" style="background-color: #e0f2fe; border-radius: 8px;">
                        <div class="fw-bold" style="color: #0369a1; font-size: 0.95rem; margin-bottom: 0.2rem;"><?= $desiminasi->nama_mahasiswa ?> (<?= $desiminasi->nim ?>)</div>
                        <div style="color: #0284c7; font-size: 0.85rem;">Instansi: <?= $desiminasi->instansi_tujuan ?></div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Tanggal</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="tanggal_desiminasi" value="<?= isset($jadwal->tanggal_desiminasi) ? $jadwal->tanggal_desiminasi : '' ?>" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold text-secondary small">Waktu Mulai</label>
                            <input type="time" class="form-control" name="waktu_mulai" value="<?= isset($jadwal->waktu_mulai) ? format_indo('H:i', strtotime($jadwal->waktu_mulai)) : '' ?>" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold text-secondary small">Waktu Selesai</label>
                            <input type="time" class="form-control" name="waktu_selesai" value="<?= isset($jadwal->waktu_selesai) && $jadwal->waktu_selesai ? format_indo('H:i', strtotime($jadwal->waktu_selesai)) : '' ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Ruangan</label>
                        <input type="text" class="form-control" name="ruangan" value="<?= isset($jadwal->ruangan) ? $jadwal->ruangan : '' ?>" required>
                    </div>
                    
                    <div class="mb-0">
                        <label class="form-label fw-semibold text-secondary small">Link Online (Optional)</label>
                        <input type="url" class="form-control" name="link_online" value="<?= isset($jadwal->link_online) ? $jadwal->link_online : '' ?>">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-secondary px-4" style="border-radius: 6px; font-weight: 500;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4" style="background-color: #0277bd; border: none; border-radius: 6px; font-weight: 500;">Ubah Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>


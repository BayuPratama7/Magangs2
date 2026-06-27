<!-- Proses Desiminasi - Input Jadwal + Assign Penguji -->
<div class="row mb-4">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('sekretaris/desiminasi') ?>">Pengajuan Desiminasi</a>
                </li>
                <li class="breadcrumb-item active">Proses Desiminasi</li>
            </ol>
        </nav>
        <h4 class="mb-1">Proses Pengajuan Desiminasi</h4>
        <p class="text-muted mb-0">Input jadwal dan assign penguji untuk desiminasi mahasiswa</p>
    </div>
</div>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <!-- Info Mahasiswa -->
    <div class="col-lg-4">
        <div class="card mb-4 border-0 shadow-sm rounded-3">
            <div class="card-header border-0 text-white" style="background-color: #0277bd; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; padding: 1rem 1.25rem;">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person me-2"></i>Data Mahasiswa</h6>
            </div>
            <div class="card-body p-4">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td width="100"><span style="font-size: 0.85rem; font-weight: 700; color: #495057;">NIM</span></td>
                        <td><span class="text-secondary" style="font-size: 0.9rem;"><?= $desiminasi->nim ?></span></td>
                    </tr>
                    <tr>
                        <td><span style="font-size: 0.85rem; font-weight: 700; color: #495057;">Nama</span></td>
                        <td><span class="text-secondary" style="font-size: 0.9rem;"><?= $desiminasi->nama_mahasiswa ?></span></td>
                    </tr>

                    <tr>
                        <td><span style="font-size: 0.85rem; font-weight: 700; color: #495057;">Instansi</span></td>
                        <td><span class="text-secondary" style="font-size: 0.9rem;"><?= $desiminasi->instansi_tujuan ?></span></td>
                    </tr>
                    <tr>
                        <td><span style="font-size: 0.85rem; font-weight: 700; color: #495057;">DPL</span></td>
                        <td><span class="badge" style="background-color: #e2e8f0; color: #4a5568; font-weight: 500; font-size: 0.85rem; padding: 0.4em 0.8em; border-radius: 6px;"><?= $desiminasi->nama_dpl ?? '-' ?></span></td>
                    </tr>
                    <tr>
                        <td><span style="font-size: 0.85rem; font-weight: 700; color: #495057;">Pengajuan</span></td>
                        <td><span class="text-secondary" style="font-size: 0.9rem;"><?= format_indo('d M Y', strtotime($desiminasi->tanggal_pengajuan)) ?></span></td>
                    </tr>
                </table>

                <?php if ($desiminasi->link_laporan): ?>
                    <hr class="text-muted opacity-25 my-4">
                    <a href="<?= $desiminasi->link_laporan ?>" target="_blank" class="btn w-100" style="color: #4285f4; border: 1px solid #c6d8fc; background-color: transparent; border-radius: 6px; padding: 0.5rem 1rem; font-weight: 500;">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Lihat Laporan
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Form Input Jadwal + Penguji -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header border-0 text-white" style="background-color: #0277bd; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; padding: 1rem 1.25rem;">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-calendar-check me-2"></i>Input Jadwal & Penguji</h6>
            </div>
            <div class="card-body p-4 p-lg-5">
                <form method="post" action="<?= base_url('sekretaris/desiminasi/simpan') ?>">
                    <input type="hidden" name="desiminasi_id" value="<?= $desiminasi->desiminasi_id ?>">

                    <!-- Pilih Penguji -->
                    <div class="mb-4">
                        <label class="form-label text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">PENGUJI DESIMINASI <span class="text-danger">*</span></label>
                        <select name="penguji_id" class="form-select form-select-lg" style="font-size: 0.9rem; border-color: #dee2e6; color: #495057;" required>
                            <option value="">Pilih dosen yang akan menjadi penguji desiminasi</option>
                            <?php foreach ($penguji_list as $p): ?>
                                <option value="<?= $p->dosen_id ?>" <?= ($desiminasi->penguji_id == $p->dosen_id) ? 'selected' : '' ?>>
                                    <?= $p->nama_dosen ?> (<?= $p->bidang_keahlian ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted" style="font-size: 0.7rem;">Pilih dosen yang akan menjadi penguji desiminasi</small>
                    </div>

                    <hr class="text-muted opacity-25 my-4">

                    <!-- Jadwal -->
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">TANGGAL DESIMINASI <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_desiminasi" class="form-control form-control-lg" style="font-size: 0.9rem; border-color: #dee2e6; color: #495057;" required
                                min="<?= format_indo('Y-m-d') ?>" value="<?= isset($jadwal->tanggal_desiminasi) ? $jadwal->tanggal_desiminasi : '' ?>">
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">WAKTU MULAI <span class="text-danger">*</span></label>
                            <input type="time" name="waktu_mulai" class="form-control form-control-lg" style="font-size: 0.9rem; border-color: #dee2e6; color: #495057;" required value="<?= isset($jadwal->waktu_mulai) ? format_indo('H:i', strtotime($jadwal->waktu_mulai)) : '' ?>">
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">WAKTU SELESAI <span class="text-danger">*</span></label>
                            <input type="time" name="waktu_selesai" class="form-control form-control-lg" style="font-size: 0.9rem; border-color: #dee2e6; color: #495057;" value="<?= isset($jadwal->waktu_selesai) ? format_indo('H:i', strtotime($jadwal->waktu_selesai)) : '' ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">RUANGAN <span class="text-danger">*</span></label>
                            <input type="text" name="ruangan" class="form-control form-control-lg" style="font-size: 0.9rem; border-color: #dee2e6; color: #495057;" placeholder="Contoh: Ruang Sidang 1" required value="<?= isset($jadwal->ruangan) ? $jadwal->ruangan : '' ?>">
                        </div>
                        <div class="col-md-8 mb-4">
                            <label class="form-label text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">LINK ONLINE</label>
                            <input type="url" name="link_online" class="form-control form-control-lg" style="font-size: 0.9rem; border-color: #dee2e6; color: #495057;"
                                placeholder="https://meet.google.com/..." value="<?= isset($jadwal->link_online) ? $jadwal->link_online : '' ?>">
                            <small class="text-muted" style="font-size: 0.7rem;">Jika desiminasi dilakukan secara online</small>
                        </div>
                    </div>

                    <hr class="text-muted opacity-25 my-4">

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="<?= base_url('sekretaris/desiminasi') ?>" class="btn px-4 py-2" style="background-color: #6c757d; color: white; border-radius: 6px; font-weight: 500; font-size: 0.9rem; border: none;">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn px-4 py-2" style="background-color: #0277bd; color: white; border-radius: 6px; font-weight: 500; font-size: 0.9rem; border: none;">
                            <i class="bi bi-check-circle me-2"></i>Simpan & Proses
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

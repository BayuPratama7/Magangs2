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
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-person me-2"></i>Data Mahasiswa
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td><strong>NIM</strong></td>
                        <td><?= $desiminasi->nim ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td><?= $desiminasi->nama_mahasiswa ?></td>
                    </tr>
                    <tr>
                        <td><strong>Judul</strong></td>
                        <td><small><?= $desiminasi->judul_proposal ?></small></td>
                    </tr>
                    <tr>
                        <td><strong>Instansi</strong></td>
                        <td><?= $desiminasi->instansi_tujuan ?></td>
                    </tr>
                    <tr>
                        <td><strong>Pengajuan</strong></td>
                        <td><?= date('d M Y', strtotime($desiminasi->tanggal_pengajuan)) ?></td>
                    </tr>
                </table>

                <?php if ($desiminasi->link_laporan): ?>
                    <hr>
                    <a href="<?= $desiminasi->link_laporan ?>" target="_blank" class="btn btn-outline-primary w-100">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Lihat Laporan
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Form Input Jadwal + Penguji -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <i class="bi bi-calendar-check me-2"></i>Input Jadwal & Penguji
            </div>
            <div class="card-body">
                <form method="post" action="<?= base_url('sekretaris/desiminasi/simpan') ?>">
                    <input type="hidden" name="desiminasi_id" value="<?= $desiminasi->desiminasi_id ?>">

                    <!-- Pilih Penguji -->
                    <div class="mb-4">
                        <label class="form-label"><strong>Penguji Desiminasi</strong> <span
                                class="text-danger">*</span></label>
                        <select name="penguji_id" class="form-select" required>
                            <option value="">-- Pilih Dosen Penguji --</option>
                            <?php foreach ($penguji_list as $p): ?>
                                <option value="<?= $p->dosen_id ?>"><?= $p->nama_dosen ?> (<?= $p->bidang_keahlian ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Pilih dosen yang akan menjadi penguji desiminasi</small>
                    </div>

                    <hr>

                    <!-- Jadwal -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Tanggal Desiminasi</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_desiminasi" class="form-control" required
                                min="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><strong>Waktu Mulai</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="time" name="waktu_mulai" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><strong>Waktu Selesai</strong></label>
                            <input type="time" name="waktu_selesai" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Ruangan</strong></label>
                            <input type="text" name="ruangan" class="form-control" placeholder="Contoh: Ruang Sidang 1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Link Online</strong></label>
                            <input type="url" name="link_online" class="form-control"
                                placeholder="https://meet.google.com/...">
                            <small class="text-muted">Jika desiminasi dilakukan secara online</small>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('sekretaris/desiminasi') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                        <div>
                            <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal"
                                data-bs-target="#tolakModal">
                                <i class="bi bi-x-circle me-2"></i>Tolak
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle me-2"></i>Simpan & Proses
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div class="modal fade" id="tolakModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Tolak Pengajuan Desiminasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="<?= base_url('sekretaris/desiminasi/tolak/' . $desiminasi->desiminasi_id) ?>">
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Anda akan menolak pengajuan desiminasi dari <strong><?= $desiminasi->nama_mahasiswa ?></strong>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan</label>
                        <textarea name="catatan" class="form-control" rows="3"
                            placeholder="Jelaskan alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle me-2"></i>Tolak Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
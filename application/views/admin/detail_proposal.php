<!-- Admin Detail Proposal View -->
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1 text-primary"><i class="bi bi-card-heading me-2"></i>Detail Proposal Magang</h4>
            <p class="text-muted mb-0">Rincian lengkap pengajuan proposal mahasiswa</p>
        </div>

    </div>
</div>

<div class="row g-4">
    <!-- Kolom Utama: Informasi Magang -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h6 class="text-uppercase fw-bold text-muted mb-0">Informasi Magang</h6>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <p class="text-muted mb-1 small text-uppercase fw-bold">Judul Proposal</p>
                    <h5 class="fw-semibold text-dark mb-0"><?= $proposal->judul_proposal ?></h5>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <p class="text-muted mb-1 small text-uppercase fw-bold"><i class="bi bi-building me-2"></i>Instansi Tujuan</p>
                            <p class="mb-0 fw-medium"><?= $proposal->instansi_tujuan ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <p class="text-muted mb-1 small text-uppercase fw-bold"><i class="bi bi-geo-alt me-2"></i>Provinsi</p>
                            <p class="mb-0 fw-medium"><?= isset($proposal->provinsi) ? htmlspecialchars($proposal->provinsi) : '-' ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <p class="text-muted mb-1 small text-uppercase fw-bold"><i class="bi bi-calendar3 me-2"></i>Tahun Akademik</p>
                            <p class="mb-0 fw-medium"><?= isset($proposal->tahun_akademik) ? htmlspecialchars($proposal->tahun_akademik) : '-' ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <p class="text-muted mb-1 small text-uppercase fw-bold"><i class="bi bi-tags me-2"></i>Jenis Magang</p>
                            <p class="mb-0 fw-medium">
                                <?php if($proposal->jenis_magang == 'reguler'): ?>
                                    <span class="badge bg-primary px-3 py-2">Reguler</span>
                                <?php elseif($proposal->jenis_magang == 'bumn'): ?>
                                    <span class="badge bg-success px-3 py-2">BUMN</span>
                                <?php elseif($proposal->jenis_magang == 'mbkm'): ?>
                                    <span class="badge bg-warning text-dark px-3 py-2">MBKM</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary px-3 py-2">-</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small text-uppercase fw-bold"><i class="bi bi-clock-history me-2"></i>Tanggal Pengajuan</p>
                        <p class="mb-0 fw-medium"><?= isset($proposal->tanggal_pengajuan) ? format_indo('d M Y', strtotime($proposal->tanggal_pengajuan)) : '-' ?></p>
                    </div>
                    <div>
                        <a href="<?= $proposal->link_proposal ?>" target="_blank" class="btn btn-outline-primary shadow-sm px-4">
                            <i class="bi bi-box-arrow-up-right me-2"></i>Buka Dokumen
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Samping: Status & DPL -->
    <div class="col-lg-4">

        <?php if ($this->session->userdata('role_id') == 3): ?>
        <div class="mt-3 text-end">
            <button class="btn btn-primary shadow-sm px-4 btn-buat-surat"
                data-mahasiswa-id="<?= $proposal->mahasiswa_id ?>"
                data-proposal-id="<?= $proposal->proposal_id ?>"
                data-nama="<?= htmlspecialchars($mahasiswa ? $mahasiswa->nama_mahasiswa : 'Mahasiswa') ?>"
                data-nim="<?= htmlspecialchars($mahasiswa ? $mahasiswa->nim : '-') ?>"
                data-instansi="<?= htmlspecialchars($proposal->instansi_tujuan) ?>">
                <i class="bi bi-envelope-plus me-2"></i>Buat Surat Pengantar
            </button>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if ($this->session->userdata('role_id') == 3): ?>
<!-- Modal Buat Surat -->
<div class="modal fade" id="suratModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Surat Pengantar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="<?= base_url('admin/create_surat') ?>">
                <input type="hidden" name="mahasiswa_id" id="modal_mahasiswa_id">
                <input type="hidden" name="proposal_id" id="modal_proposal_id">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong id="modal_nama"></strong> (<span id="modal_nim"></span>)<br>
                        <small>Instansi: <span id="modal_instansi_info"></span></small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor Surat</label>
                            <input type="text" name="nomor_surat" class="form-control"
                                placeholder="B/001/SI/2024" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Surat</label>
                            <input type="date" name="tanggal_surat" class="form-control"
                                value="<?= format_indo('Y-m-d') ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Perihal</label>
                        <input type="text" name="perihal" class="form-control"
                            value="Permohonan Izin Magang" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tujuan Instansi</label>
                        <input type="text" name="tujuan_instansi" id="modal_instansi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link File Surat (Google Drive)</label>
                        <input type="url" name="file_surat" class="form-control"
                            placeholder="https://drive.google.com/...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Surat</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle button click to open modal
    document.querySelectorAll('.btn-buat-surat').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var mahasiswaId = this.getAttribute('data-mahasiswa-id');
            var proposalId = this.getAttribute('data-proposal-id');
            var nama = this.getAttribute('data-nama');
            var nim = this.getAttribute('data-nim');
            var instansi = this.getAttribute('data-instansi');
            
            document.getElementById('modal_mahasiswa_id').value = mahasiswaId;
            document.getElementById('modal_proposal_id').value = proposalId;
            document.getElementById('modal_nama').textContent = nama;
            document.getElementById('modal_nim').textContent = nim;
            document.getElementById('modal_instansi_info').textContent = instansi;
            document.getElementById('modal_instansi').value = instansi;
            
            var modal = new bootstrap.Modal(document.getElementById('suratModal'));
            modal.show();
        });
    });
});
</script>
<?php endif; ?>



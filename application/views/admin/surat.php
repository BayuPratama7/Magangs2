<!-- Admin Surat Pengantar View -->
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1">Surat Pengantar Magang</h4>
            <p class="text-muted mb-0">Buat surat pengantar untuk mahasiswa yang proposalnya sudah disetujui</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Pending Surat -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-envelope-plus me-2"></i>Menunggu Surat Pengantar
            </div>
            <div class="card-body p-0">
                <?php if (!empty($pending)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Instansi Tujuan</th>
                                    <th>Alamat Instansi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pending as $m): ?>
                                    <tr>
                                        <td><?= $m->nim ?></td>
                                        <td><?= $m->nama_mahasiswa ?></td>
                                        <td><?= $m->instansi_tujuan ?></td>
                                        <td><small><?= $m->alamat_instansi ?></small></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary btn-buat-surat"
                                                data-mahasiswa-id="<?= $m->mahasiswa_id ?>"
                                                data-proposal-id="<?= $m->proposal_id ?>"
                                                data-nama="<?= htmlspecialchars($m->nama_mahasiswa) ?>"
                                                data-nim="<?= $m->nim ?>"
                                                data-instansi="<?= htmlspecialchars($m->instansi_tujuan) ?>">
                                                <i class="bi bi-envelope-plus me-1"></i>Buat Surat
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle display-4 text-success"></i>
                        <p class="text-muted mt-2">Semua proposal yang disetujui sudah memiliki surat pengantar</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Surat List -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-envelope me-2"></i>Daftar Surat Pengantar
            </div>
            <div class="card-body p-0">
                <?php if (!empty($surat_list)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No. Surat</th>
                                    <th>Tanggal</th>
                                    <th>Mahasiswa</th>
                                    <th>Tujuan</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($surat_list as $s): ?>
                                    <tr>
                                        <td><strong><?= $s->nomor_surat ?></strong></td>
                                        <td><?= date('d M Y', strtotime($s->tanggal_surat)) ?></td>
                                        <td>
                                            <?= $s->nama_mahasiswa ?><br>
                                            <small class="text-muted"><?= $s->nim ?></small>
                                        </td>
                                        <td><?= $s->tujuan_instansi ?></td>
                                        <td>
                                            <?php if ($s->file_surat): ?>
                                                <a href="<?= $s->file_surat ?>" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-file-earmark-pdf"></i>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">Belum ada surat pengantar</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Single Modal for Surat -->
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
                                value="<?= date('Y-m-d') ?>" required>
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
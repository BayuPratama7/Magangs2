<!-- Admin Jadwal Desiminasi View -->
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1">Jadwal Desiminasi</h4>
            <p class="text-muted mb-0">Atur jadwal presentasi desiminasi mahasiswa</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Pending Jadwal -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-calendar-plus me-2"></i>Menunggu Penjadwalan
            </div>
            <div class="card-body p-0">
                <?php if (!empty($pending)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Judul</th>
                                    <th>Penguji</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pending as $d): ?>
                                    <tr>
                                        <td><?= $d->nim ?></td>
                                        <td><?= $d->nama_mahasiswa ?></td>
                                        <td><small><?= substr($d->judul_proposal, 0, 50) ?>...</small></td>
                                        <td><span class="badge bg-primary"><?= $d->nama_penguji ?></span></td>
                                        <td>
                                            <button class="btn btn-sm btn-success btn-buat-jadwal"
                                                data-desiminasi-id="<?= $d->desiminasi_id ?>"
                                                data-mahasiswa-id="<?= $d->mahasiswa_id ?>"
                                                data-nama="<?= htmlspecialchars($d->nama_mahasiswa) ?>"
                                                data-nim="<?= $d->nim ?>"
                                                data-penguji="<?= htmlspecialchars($d->nama_penguji) ?>">
                                                <i class="bi bi-calendar-plus me-1"></i>Buat Jadwal
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
                        <p class="text-muted mt-2">Semua desiminasi sudah dijadwalkan</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Jadwal List -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-calendar-event me-2"></i>Daftar Jadwal Desiminasi
            </div>
            <div class="card-body p-0">
                <?php if (!empty($jadwal_list)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Mahasiswa</th>
                                    <th>Ruangan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jadwal_list as $j): ?>
                                    <tr>
                                        <td><?= date('d M Y', strtotime($j->tanggal_desiminasi)) ?></td>
                                        <td><?= $j->waktu_mulai ?> - <?= $j->waktu_selesai ?></td>
                                        <td>
                                            <strong><?= $j->nama_mahasiswa ?></strong><br>
                                            <small class="text-muted"><?= $j->nim ?></small>
                                        </td>
                                        <td><?= $j->ruangan ?? 'Online' ?></td>
                                        <td>
                                            <span
                                                class="badge bg-<?= $j->status == 'terjadwal' ? 'primary' : ($j->status == 'selesai' ? 'success' : 'secondary') ?>">
                                                <?= ucfirst($j->status) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">Belum ada jadwal desiminasi</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Single Modal for Jadwal -->
<div class="modal fade" id="jadwalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Jadwalkan Desiminasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="<?= base_url('admin/create_jadwal') ?>">
                <input type="hidden" name="desiminasi_id" id="modal_desiminasi_id">
                <input type="hidden" name="mahasiswa_id" id="modal_jadwal_mahasiswa_id">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong id="modal_jadwal_nama"></strong> (<span id="modal_jadwal_nim"></span>)<br>
                        <small>Penguji: <span id="modal_jadwal_penguji"></span></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Desiminasi</label>
                        <input type="date" name="tanggal_desiminasi" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Waktu Mulai</label>
                            <input type="time" name="waktu_mulai" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Waktu Selesai</label>
                            <input type="time" name="waktu_selesai" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ruangan</label>
                        <input type="text" name="ruangan" class="form-control" placeholder="Lab SI 1 / Online">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link Online (Optional)</label>
                        <input type="url" name="link_online" class="form-control"
                            placeholder="https://meet.google.com/...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-buat-jadwal').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var desiminasiId = this.getAttribute('data-desiminasi-id');
            var mahasiswaId = this.getAttribute('data-mahasiswa-id');
            var nama = this.getAttribute('data-nama');
            var nim = this.getAttribute('data-nim');
            var penguji = this.getAttribute('data-penguji');
            
            document.getElementById('modal_desiminasi_id').value = desiminasiId;
            document.getElementById('modal_jadwal_mahasiswa_id').value = mahasiswaId;
            document.getElementById('modal_jadwal_nama').textContent = nama;
            document.getElementById('modal_jadwal_nim').textContent = nim;
            document.getElementById('modal_jadwal_penguji').textContent = penguji;
            
            var modal = new bootstrap.Modal(document.getElementById('jadwalModal'));
            modal.show();
        });
    });
});
</script>
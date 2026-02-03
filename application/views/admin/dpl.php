<!-- Admin DPL View -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Penugasan Dosen Pembimbing Lapangan</h4>
        <p class="text-muted mb-0">Assign DPL untuk mahasiswa yang proposalnya sudah disetujui</p>
    </div>
</div>

<div class="row g-4">
    <!-- Pending Assignment -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-plus me-2"></i>Mahasiswa Menunggu DPL
            </div>
            <div class="card-body p-0">
                <?php if (!empty($pending)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Judul Proposal</th>
                                    <th>Instansi</th>
                                    <th>Pilih DPL</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pending as $m): ?>
                                    <tr>
                                        <td><?= $m->nim ?></td>
                                        <td><?= $m->nama_mahasiswa ?></td>
                                        <td><small><?= $m->judul_proposal ?></small></td>
                                        <td><?= $m->instansi_tujuan ?></td>
                                        <td colspan="2">
                                            <form method="post" action="<?= base_url('admin/assign_dpl') ?>" class="d-flex gap-2">
                                                <input type="hidden" name="mahasiswa_id" value="<?= $m->mahasiswa_id ?>">
                                                <select name="dosen_id" class="form-select form-select-sm" style="width: auto;" required>
                                                    <option value="">-- Pilih DPL --</option>
                                                    <?php foreach ($dosen_list as $d): ?>
                                                        <option value="<?= $d->dosen_id ?>"><?= $d->nama_dosen ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="bi bi-check me-1"></i>Assign
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-check-circle display-1 text-success"></i>
                        <p class="text-muted mt-3">Semua mahasiswa sudah memiliki DPL</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Assigned List -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-people me-2"></i>Daftar Penugasan DPL
            </div>
            <div class="card-body p-0">
                <?php if (!empty($assigned)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Instansi</th>
                                    <th>Dosen Pembimbing</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assigned as $m): ?>
                                    <tr>
                                        <td><?= $m->nim ?></td>
                                        <td><?= $m->nama_mahasiswa ?></td>
                                        <td><?= $m->instansi_tujuan ?></td>
                                        <td><span class="badge bg-primary"><?= $m->nama_dpl ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">Belum ada penugasan DPL</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
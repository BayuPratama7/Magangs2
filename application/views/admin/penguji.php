<!-- Admin Penguji View -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Penugasan Penguji Desiminasi</h4>
        <p class="text-muted mb-0">Assign penguji untuk desiminasi mahasiswa</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-person-check me-2"></i>Desiminasi Menunggu Penguji
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
                            <th>Tanggal Pengajuan</th>
                            <th>Pilih Penguji</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending as $d): ?>
                            <tr>
                                <td><?= $d->nim ?></td>
                                <td><?= $d->nama_mahasiswa ?></td>
                                <td><small><?= $d->judul_proposal ?></small></td>
                                <td><?= date('d M Y', strtotime($d->tanggal_pengajuan)) ?></td>
                                <td colspan="2">
                                    <form method="post" action="<?= base_url('admin/assign_penguji') ?>" class="d-flex gap-2">
                                        <input type="hidden" name="desiminasi_id" value="<?= $d->desiminasi_id ?>">
                                        <select name="penguji_id" class="form-select form-select-sm" style="width: auto;" required>
                                            <option value="">-- Pilih Penguji --</option>
                                            <?php foreach ($penguji_list as $p): ?>
                                                <option value="<?= $p->dosen_id ?>"><?= $p->nama_dosen ?></option>
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
                <p class="text-muted mt-3">Semua desiminasi sudah memiliki penguji</p>
            </div>
        <?php endif; ?>
    </div>
</div>
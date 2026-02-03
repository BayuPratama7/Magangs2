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

<div class="card">
    <div class="card-header">
        <i class="bi bi-list-check me-2"></i>Pengajuan Desiminasi Menunggu Proses
    </div>
    <div class="card-body p-0">
        <?php if (!empty($pending)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Judul Proposal</th>
                            <th>Instansi</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending as $d): ?>
                            <tr>
                                <td><?= $d->nim ?></td>
                                <td><strong><?= $d->nama_mahasiswa ?></strong></td>
                                <td><small><?= substr($d->judul_proposal, 0, 40) ?>...</small></td>
                                <td><small><?= $d->instansi_tujuan ?></small></td>
                                <td><?= date('d M Y', strtotime($d->tanggal_pengajuan)) ?></td>
                                <td>
                                    <a href="<?= base_url('sekretaris/desiminasi/proses/' . $d->desiminasi_id) ?>"
                                        class="btn btn-sm btn-primary">
                                        <i class="bi bi-gear"></i> Proses
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-check-circle display-1 text-success"></i>
                <p class="text-muted mt-3">Tidak ada pengajuan desiminasi yang menunggu proses</p>
            </div>
        <?php endif; ?>
    </div>
</div>
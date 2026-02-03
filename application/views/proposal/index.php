<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1">Proposal Magang</h4>
        <p class="text-muted mb-0">Ajukan proposal magang Anda di sini</p>
    </div>
</div>

<?php if (!$proposal): ?>

    <div class="card">
        <div class="card-header">
            <i class="bi bi-file-earmark-plus me-2"></i>Form Pengajuan Proposal
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('proposal/store') ?>">
                <div class="mb-3">
                    <label class="form-label">Judul Proposal</label>
                    <input type="text" name="judul_proposal" class="form-control" required
                        placeholder="Masukkan judul proposal magang">
                </div>

                <div class="mb-3">
                    <label class="form-label">Instansi Tujuan Magang</label>
                    <input type="text" name="instansi_tujuan" class="form-control" required
                        placeholder="Nama instansi/perusahaan">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Magang</label>
                        <select name="jenis_magang" class="form-select" required>
                            <option value="">-- Pilih Jenis Magang --</option>
                            <option value="reguler">Reguler</option>
                            <option value="bumn">BUMN</option>
                            <option value="mbkm">MBKM</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Pengajuan</label>
                        <input type="date" name="tanggal_pengajuan" class="form-control" required
                            value="<?= date('Y-m-d') ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Instansi</label>
                    <textarea name="alamat_instansi" class="form-control" rows="2"
                        placeholder="Alamat lengkap instansi"></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Link Proposal (Google Drive)</label>
                    <input type="url" name="link_proposal" class="form-control" required
                        placeholder="https://drive.google.com/...">
                    <small class="text-muted">Upload proposal Anda ke Google Drive lalu paste linknya di sini</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-1"></i>Ajukan Proposal
                </button>
            </form>
        </div>
    </div>

<?php else: ?>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-file-earmark-text me-2"></i>Detail Proposal</span>
            <div>
                <?php
                switch ($proposal->status_kaprodi) {
                    case 'disetujui':
                        $status_class = 'bg-success';
                        break;
                    case 'ditolak':
                        $status_class = 'bg-danger';
                        break;
                    default:
                        $status_class = 'bg-warning';
                }
                ?>
                <span class="badge <?= $status_class ?>"><?= ucfirst($proposal->status_kaprodi) ?></span>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="200">Judul Proposal</th>
                    <td><?= $proposal->judul_proposal ?></td>
                </tr>
                <tr>
                    <th>Instansi Tujuan</th>
                    <td><?= $proposal->instansi_tujuan ?></td>
                </tr>
                <tr>
                    <th>Jenis Magang</th>
                    <td><span class="badge bg-primary"><?= strtoupper($proposal->jenis_magang) ?></span></td>
                </tr>
                <tr>
                    <th>Tanggal Pengajuan</th>
                    <td><?= isset($proposal->tanggal_pengajuan) ? date('d M Y', strtotime($proposal->tanggal_pengajuan)) : '-' ?>
                    </td>
                </tr>
                <tr>
                    <th>Link Proposal</th>
                    <td>
                        <a href="<?= $proposal->link_proposal ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-box-arrow-up-right me-1"></i>Buka Proposal
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>Status Koordinator</th>
                    <td>
                        <?php
                        switch ($proposal->status_koordinator) {
                            case 'disetujui':
                                $coord_class = 'bg-success';
                                break;
                            case 'ditolak':
                                $coord_class = 'bg-danger';
                                break;
                            default:
                                $coord_class = 'bg-warning';
                        }
                        ?>
                        <span class="badge <?= $coord_class ?>"><?= ucfirst($proposal->status_koordinator) ?></span>
                    </td>
                </tr>
                <tr>
                    <th>Status Kaprodi</th>
                    <td>
                        <span class="badge <?= $status_class ?>"><?= ucfirst($proposal->status_kaprodi) ?></span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <?php if ($proposal->status_kaprodi == 'disetujui'): ?>
        <div class="alert alert-success mt-3">
            <i class="bi bi-check-circle me-2"></i>
            Selamat! Proposal Anda telah disetujui. Silakan lanjutkan ke tahap berikutnya.
        </div>
    <?php elseif ($proposal->status_kaprodi == 'ditolak'): ?>
        <div class="alert alert-danger mt-3">
            <i class="bi bi-x-circle me-2"></i>
            Proposal Anda ditolak. Silakan hubungi koordinator untuk informasi lebih lanjut.
        </div>
    <?php else: ?>
        <div class="alert alert-info mt-3">
            <i class="bi bi-hourglass-split me-2"></i>
            Proposal Anda sedang dalam proses review. Mohon tunggu.
        </div>
    <?php endif; ?>

<?php endif; ?>
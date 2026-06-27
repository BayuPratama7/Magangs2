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
                                    <th>Jenis Magang</th>
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
                                        <td>
                                            <?php if($m->jenis_magang == 'reguler'): ?>
                                                <span class="badge bg-primary">Reguler</span>
                                            <?php elseif($m->jenis_magang == 'bumn'): ?>
                                                <span class="badge bg-success">BUMN</span>
                                            <?php elseif($m->jenis_magang == 'mbkm'): ?>
                                                <span class="badge bg-warning text-dark">MBKM</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $m->instansi_tujuan ?></td>
                                        <td><small><?= $m->alamat_instansi ?></small></td>
                                        <td>
                                            <a href="<?= base_url('admin/detail_proposal/' . $m->proposal_id) ?>" class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-file-earmark-text me-1"></i>Detail
                                            </a>
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
                                    <th>Jenis Magang</th>
                                    <th>Tujuan</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($surat_list as $s): ?>
                                    <tr>
                                        <td><strong><?= $s->nomor_surat ?></strong></td>
                                        <td><?= format_indo('d M Y', strtotime($s->tanggal_surat)) ?></td>
                                        <td>
                                            <?= $s->nama_mahasiswa ?><br>
                                            <small class="text-muted"><?= $s->nim ?></small>
                                        </td>
                                        <td>
                                            <?php if(isset($s->jenis_magang)): ?>
                                                <?php if($s->jenis_magang == 'reguler'): ?>
                                                    <span class="badge bg-primary">Reguler</span>
                                                <?php elseif($s->jenis_magang == 'bumn'): ?>
                                                    <span class="badge bg-success">BUMN</span>
                                                <?php elseif($s->jenis_magang == 'mbkm'): ?>
                                                    <span class="badge bg-warning text-dark">MBKM</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">-</span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">-</span>
                                            <?php endif; ?>
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


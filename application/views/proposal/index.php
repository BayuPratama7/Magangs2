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
                <tr>
                    <th>DPL (Dosen Pembimbing Lapangan)</th>
                    <td>
                        <?php if (isset($mahasiswa) && $mahasiswa->dosen_dpl_id): ?>
                            <strong><?= $mahasiswa->nama_dosen ?? 'DPL' ?></strong>
                            <?php if (!empty($mahasiswa->kontak_dosen)): ?>
                                <br><small class="text-muted">Kontak: <?= htmlspecialchars($mahasiswa->kontak_dosen) ?></small>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="badge bg-warning">Belum Ditugaskan</span>
                            <?php if ($proposal->status_kaprodi == 'disetujui' && $proposal->status_mitra == 'diterima'): ?>
                                <br><small class="text-muted">DPL akan ditugaskan segera</small>
                            <?php elseif ($proposal->status_kaprodi == 'disetujui'): ?>
                                <br><small class="text-muted">DPL akan ditugaskan setelah balasan mitra diterima</small>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <?php if ($proposal->status_koordinator == 'ditolak'): ?>
        <!-- Ditolak oleh Koordinator -->
        <div class="alert alert-danger mt-3">
            <i class="bi bi-x-circle me-2"></i>
            <strong>Proposal ditolak oleh Koordinator.</strong>
        </div>

        <?php if (!empty($proposal->catatan_koordinator)): ?>
            <div class="card mt-3 border-danger">
                <div class="card-header bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-chat-left-text me-2"></i><strong>Alasan Penolakan dari Koordinator</strong>
                </div>
                <div class="card-body">
                    <p class="mb-0"><?= nl2br(htmlspecialchars($proposal->catatan_koordinator)) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Form Ajukan Ulang -->
        <div class="card mt-3">
            <div class="card-header">
                <i class="bi bi-arrow-repeat me-2"></i>Ajukan Ulang Proposal
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Perbaiki proposal Anda sesuai catatan di atas, lalu ajukan kembali.</p>
                <form method="post" action="<?= base_url('proposal/resubmit/' . $proposal->proposal_id) ?>">
                    <div class="mb-3">
                        <label class="form-label">Judul Proposal</label>
                        <input type="text" name="judul_proposal" class="form-control" required
                            value="<?= htmlspecialchars($proposal->judul_proposal) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Instansi Tujuan Magang</label>
                        <input type="text" name="instansi_tujuan" class="form-control" required
                            value="<?= htmlspecialchars($proposal->instansi_tujuan) ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Magang</label>
                            <select name="jenis_magang" class="form-select" required>
                                <option value="reguler" <?= $proposal->jenis_magang == 'reguler' ? 'selected' : '' ?>>Reguler</option>
                                <option value="bumn" <?= $proposal->jenis_magang == 'bumn' ? 'selected' : '' ?>>BUMN</option>
                                <option value="mbkm" <?= $proposal->jenis_magang == 'mbkm' ? 'selected' : '' ?>>MBKM</option>
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
                        <textarea name="alamat_instansi" class="form-control" rows="2"><?= htmlspecialchars($proposal->alamat_instansi ?? '') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Link Proposal (Google Drive)</label>
                        <input type="url" name="link_proposal" class="form-control" required
                            value="<?= htmlspecialchars($proposal->link_proposal) ?>"
                            placeholder="https://drive.google.com/...">
                        <small class="text-muted">Upload proposal yang sudah diperbaiki ke Google Drive lalu paste linknya di sini</small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-1"></i>Ajukan Ulang
                    </button>
                </form>
            </div>
        </div>

    <?php elseif ($proposal->status_kaprodi == 'ditolak'): ?>
        <!-- Ditolak oleh Kaprodi -->
        <div class="alert alert-danger mt-3">
            <i class="bi bi-x-circle me-2"></i>
            <strong>Proposal ditolak oleh Kaprodi.</strong>
        </div>

        <?php if (!empty($proposal->catatan_kaprodi)): ?>
            <div class="card mt-3 border-danger">
                <div class="card-header bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-chat-left-text me-2"></i><strong>Alasan Penolakan dari Kaprodi</strong>
                </div>
                <div class="card-body">
                    <p class="mb-0"><?= nl2br(htmlspecialchars($proposal->catatan_kaprodi)) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Form Ajukan Ulang -->
        <div class="card mt-3">
            <div class="card-header">
                <i class="bi bi-arrow-repeat me-2"></i>Ajukan Ulang Proposal
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Perbaiki proposal Anda sesuai catatan di atas, lalu ajukan kembali.</p>
                <form method="post" action="<?= base_url('proposal/resubmit/' . $proposal->proposal_id) ?>">
                    <div class="mb-3">
                        <label class="form-label">Judul Proposal</label>
                        <input type="text" name="judul_proposal" class="form-control" required
                            value="<?= htmlspecialchars($proposal->judul_proposal) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Instansi Tujuan Magang</label>
                        <input type="text" name="instansi_tujuan" class="form-control" required
                            value="<?= htmlspecialchars($proposal->instansi_tujuan) ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Magang</label>
                            <select name="jenis_magang" class="form-select" required>
                                <option value="reguler" <?= $proposal->jenis_magang == 'reguler' ? 'selected' : '' ?>>Reguler</option>
                                <option value="bumn" <?= $proposal->jenis_magang == 'bumn' ? 'selected' : '' ?>>BUMN</option>
                                <option value="mbkm" <?= $proposal->jenis_magang == 'mbkm' ? 'selected' : '' ?>>MBKM</option>
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
                        <textarea name="alamat_instansi" class="form-control" rows="2"><?= htmlspecialchars($proposal->alamat_instansi ?? '') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Link Proposal (Google Drive)</label>
                        <input type="url" name="link_proposal" class="form-control" required
                            value="<?= htmlspecialchars($proposal->link_proposal) ?>"
                            placeholder="https://drive.google.com/...">
                        <small class="text-muted">Upload proposal yang sudah diperbaiki ke Google Drive lalu paste linknya di sini</small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-1"></i>Ajukan Ulang
                    </button>
                </form>
            </div>
        </div>

    <?php elseif ($proposal->status_kaprodi == 'disetujui'): ?>
        <!-- DISETUJUI KAPRODI - Show Surat & Balasan Section -->
        <div class="alert alert-success mt-3">
            <i class="bi bi-check-circle me-2"></i>
            Selamat! Proposal Anda telah disetujui. Silakan download surat pengantar dan upload balasan mitra.
        </div>

        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                <i class="bi bi-check-circle me-2"></i>Surat Pengantar & Balasan Mitra
            </div>
            <div class="card-body">
                <!-- 1. SURAT PENGANTAR -->
                <h6 class="mb-3"><i class="bi bi-file-earmark me-1"></i>Surat Pengantar</h6>
                <?php if (isset($surat) && $surat): ?>
                    <div class="alert alert-info mb-3">
                        <strong><?= $surat->nomor_surat ?></strong><br>
                        Tanggal: <?= date('d M Y', strtotime($surat->tanggal_surat)) ?><br>
                        <a href="<?= $surat->file_surat ?>" target="_blank" class="btn btn-sm btn-primary mt-2">
                            <i class="bi bi-download me-1"></i>Download Surat
                        </a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning mb-3">
                        <i class="bi bi-hourglass-split me-2"></i>Surat pengantar sedang disiapkan oleh Sekretaris
                    </div>
                <?php endif; ?>

                <!-- 2. BALASAN MITRA -->
                <hr class="my-3">
                <h6 class="mb-3"><i class="bi bi-inbox me-1"></i>Balasan Mitra</h6>

                <?php if ($proposal->status_mitra == 'diterima'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        Selamat! Mitra telah menerima aplikasi magang Anda. DPL sedang dalam proses penugasan.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif ($proposal->status_mitra == 'ditolak'): ?>
                    <div class="alert alert-warning mt-2">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        Silahkan mengajukan proposal kembali
                    </div>

                    <!-- Form Ajukan Proposal Baru -->
                    <div class="card mt-3">
                        <div class="card-header bg-warning text-dark">
                            <i class="bi bi-file-earmark-plus me-2"></i>Pengajuan Proposal Baru
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">Silakan isi data proposal untuk mengajukan ke mitra lain</p>
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

                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-send me-1"></i>Ajukan Proposal Baru
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Form Upload Balasan (hanya jika surat sudah ada) -->
                <?php if ((isset($surat) && $surat) && $proposal->status_mitra == 'menunggu'): ?>
                    <form method="post" action="<?= base_url('proposal/upload_balasan/' . $proposal->proposal_id) ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status Balasan Mitra <span class="text-danger">*</span></label>
                                <select id="statusMitra" name="status_mitra" class="form-select" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="diterima">Diterima</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Link Surat Balasan (Google Drive)
                                    <span class="text-danger" id="requiredBadge" style="display: none;">*</span>
                                </label>
                                <input type="url" id="linkSuratBalasan" name="link_surat_penerimaan" class="form-control"
                                    placeholder="https://drive.google.com/...">
                                <small class="text-muted">Upload balasan mitra ke Google Drive (Required jika Diterima)</small>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload me-1"></i>Upload Balasan
                        </button>
                    </form>

                    <script>
                        // Conditional required: link only required if status = diterima
                        const statusSelect = document.getElementById('statusMitra');
                        const linkInput = document.getElementById('linkSuratBalasan');
                        const requiredBadge = document.getElementById('requiredBadge');

                        function updateLinkRequired() {
                            if (statusSelect.value === 'diterima') {
                                linkInput.required = true;
                                requiredBadge.style.display = 'inline';
                            } else {
                                linkInput.required = false;
                                requiredBadge.style.display = 'none';
                            }
                        }

                        statusSelect.addEventListener('change', updateLinkRequired);
                        // Initialize on page load
                        updateLinkRequired();
                    </script>
                <?php elseif ((isset($surat) && $surat) && $proposal->status_mitra != 'menunggu'): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Balasan mitra sudah ter-upload dengan status: <strong><?= ucfirst($proposal->status_mitra) ?></strong>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info mt-3">
            <i class="bi bi-hourglass-split me-2"></i>
            Proposal Anda sedang dalam proses review. Mohon tunggu.
        </div>
    <?php endif; ?>

<?php endif; ?>
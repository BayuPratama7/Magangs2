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
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tahun Akademik</label>
                        <select name="tahun_akademik" class="form-select" required>
                            <option value="">-- Pilih Tahun Akademik --</option>
                            <?php if (isset($tahun_akademik_list)): ?>
                                <?php foreach ($tahun_akademik_list as $ta): ?>
                                    <option value="<?= htmlspecialchars($ta->tahun_akademik) ?>"><?= htmlspecialchars($ta->tahun_akademik) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jenis Magang</label>
                        <select name="jenis_magang" class="form-select" required>
                            <option value="">-- Pilih Jenis Magang --</option>
                            <option value="reguler">Reguler</option>
                            <option value="bumn">BUMN</option>
                            <option value="mbkm">MBKM</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Pengajuan</label>
                        <input type="date" name="tanggal_pengajuan" class="form-control" required
                            value="<?= format_indo('Y-m-d') ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Provinsi</label>
                    <div class="searchable-select" id="provinsiWrapper1">
                        <div class="searchable-select-trigger form-select" onclick="toggleProvinsiDropdown('provinsiWrapper1')">
                            <span class="searchable-select-placeholder">-- Pilih Provinsi --</span>
                        </div>
                        <div class="searchable-select-dropdown">
                            <div class="searchable-select-search">
                                <i class="bi bi-search"></i>
                                <input type="text" placeholder="Cari provinsi..." oninput="filterProvinsi(this, 'provinsiWrapper1')">
                            </div>
                            <div class="searchable-select-options" data-target="provinsi1"></div>
                        </div>
                        <input type="hidden" name="provinsi" id="provinsi1" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Instansi</label>
                    <textarea name="alamat_instansi" class="form-control" rows="2"
                        placeholder="Alamat lengkap instansi"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Link Proposal (Google Drive)</label>
                    <input type="url" name="link_proposal" class="form-control" required
                        placeholder="https://drive.google.com/...">
                    <small class="text-muted">Upload proposal Anda ke Google Drive lalu paste linknya di sini</small>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Apakah Anda memerlukan Surat Pengantar dari Sekretaris?</label>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="butuh_surat_pengantar" id="suratYa" value="1" checked>
                        <label class="form-check-label" for="suratYa">Ya, saya butuh surat pengantar resmi dari sekretaris</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="butuh_surat_pengantar" id="suratTidak" value="0">
                        <label class="form-check-label" for="suratTidak">Tidak, saya langsung upload balasan mitra (tanpa surat pengantar)</label>
                    </div>
                    <div class="alert alert-light border-primary border-start border-3 py-2 px-3 mt-2 mb-0">
                        <small class="text-primary">
                            <i class="bi bi-info-circle me-1"></i>
                            Pilih "Ya" jika mitra memberikan surat pengantar resmi dari institusi.<br>
                            Pilih "Tidak" jika bisa langsung upload balasan dari mitra.
                        </small>
                    </div>
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
                    <th>Tahun Akademik</th>
                    <td><?= isset($proposal->tahun_akademik) ? htmlspecialchars($proposal->tahun_akademik) : '-' ?></td>
                </tr>
                <tr>
                    <th>Jenis Magang</th>
                    <td><span class="badge bg-primary"><?= strtoupper($proposal->jenis_magang) ?></span></td>
                </tr>
                <tr>
                    <th>Provinsi</th>
                    <td><?= isset($proposal->provinsi) ? htmlspecialchars($proposal->provinsi) : '-' ?></td>
                </tr>
                <tr>
                    <th>Tanggal Pengajuan</th>
                    <td><?= isset($proposal->tanggal_pengajuan) ? format_indo('d M Y', strtotime($proposal->tanggal_pengajuan)) : '-' ?>
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
                            <strong><?= $mahasiswa->nama_dpl ?? 'DPL' ?></strong>
                            <?php if (!empty($mahasiswa->email_dpl) || !empty($mahasiswa->hp_dpl)): ?>
                                <br><small class="text-muted">
                                    <?php if (!empty($mahasiswa->email_dpl)): ?>
                                        Email: <a href="mailto:<?= $mahasiswa->email_dpl ?>"><?= htmlspecialchars($mahasiswa->email_dpl) ?></a>
                                    <?php endif; ?>
                                    <?php if (!empty($mahasiswa->hp_dpl)): ?>
                                        <?php if (!empty($mahasiswa->email_dpl)) echo '<br>'; ?>
                                        HP: <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $mahasiswa->hp_dpl) ?>" target="_blank"><?= htmlspecialchars($mahasiswa->hp_dpl) ?></a>
                                    <?php endif; ?>
                                </small>
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
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tahun Akademik</label>
                            <select name="tahun_akademik" class="form-select" required>
                                <option value="">-- Pilih Tahun Akademik --</option>
                                <?php if (isset($tahun_akademik_list)): ?>
                                    <?php foreach ($tahun_akademik_list as $ta): ?>
                                        <option value="<?= htmlspecialchars($ta->tahun_akademik) ?>" <?= (isset($proposal->tahun_akademik) && $proposal->tahun_akademik == $ta->tahun_akademik) ? 'selected' : '' ?>><?= htmlspecialchars($ta->tahun_akademik) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jenis Magang</label>
                            <select name="jenis_magang" class="form-select" required>
                                <option value="reguler" <?= $proposal->jenis_magang == 'reguler' ? 'selected' : '' ?>>Reguler</option>
                                <option value="bumn" <?= $proposal->jenis_magang == 'bumn' ? 'selected' : '' ?>>BUMN</option>
                                <option value="mbkm" <?= $proposal->jenis_magang == 'mbkm' ? 'selected' : '' ?>>MBKM</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tanggal Pengajuan</label>
                            <input type="date" name="tanggal_pengajuan" class="form-control" required
                                value="<?= format_indo('Y-m-d') ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Provinsi</label>
                        <div class="searchable-select" id="provinsiWrapperR1">
                            <div class="searchable-select-trigger form-select" onclick="toggleProvinsiDropdown('provinsiWrapperR1')">
                                <span class="searchable-select-placeholder"><?= isset($proposal->provinsi) && $proposal->provinsi ? htmlspecialchars($proposal->provinsi) : '-- Pilih Provinsi --' ?></span>
                            </div>
                            <div class="searchable-select-dropdown">
                                <div class="searchable-select-search">
                                    <i class="bi bi-search"></i>
                                    <input type="text" placeholder="Cari provinsi..." oninput="filterProvinsi(this, 'provinsiWrapperR1')">
                                </div>
                                <div class="searchable-select-options" data-target="provinsiR1"></div>
                            </div>
                            <input type="hidden" name="provinsi" id="provinsiR1" value="<?= htmlspecialchars($proposal->provinsi ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Instansi</label>
                        <textarea name="alamat_instansi" class="form-control" rows="2"><?= htmlspecialchars($proposal->alamat_instansi ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link Proposal (Google Drive)</label>
                        <input type="url" name="link_proposal" class="form-control" required
                            value="<?= htmlspecialchars($proposal->link_proposal) ?>"
                            placeholder="https://drive.google.com/...">
                        <small class="text-muted">Upload proposal yang sudah diperbaiki ke Google Drive lalu paste linknya di sini</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Apakah Anda memerlukan Surat Pengantar dari Sekretaris?</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="butuh_surat_pengantar" id="suratYaR1" value="1" <?= (!isset($proposal->butuh_surat_pengantar) || (int)$proposal->butuh_surat_pengantar == 1) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="suratYaR1">Ya, saya butuh surat pengantar resmi dari sekretaris</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="butuh_surat_pengantar" id="suratTidakR1" value="0" <?= (isset($proposal->butuh_surat_pengantar) && (int)$proposal->butuh_surat_pengantar == 0) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="suratTidakR1">Tidak, saya langsung upload balasan mitra (tanpa surat pengantar)</label>
                        </div>
                        <div class="alert alert-light border-primary border-start border-3 py-2 px-3 mt-2 mb-0">
                            <small class="text-primary">
                                <i class="bi bi-info-circle me-1"></i>
                                Pilih "Ya" jika mitra memerlukan surat pengantar resmi dari institusi.<br>
                                Pilih "Tidak" jika bisa langsung upload balasan dari mitra.
                            </small>
                        </div>
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
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tahun Akademik</label>
                            <select name="tahun_akademik" class="form-select" required>
                                <option value="">-- Pilih Tahun Akademik --</option>
                                <?php if (isset($tahun_akademik_list)): ?>
                                    <?php foreach ($tahun_akademik_list as $ta): ?>
                                        <option value="<?= htmlspecialchars($ta->tahun_akademik) ?>" <?= (isset($proposal->tahun_akademik) && $proposal->tahun_akademik == $ta->tahun_akademik) ? 'selected' : '' ?>><?= htmlspecialchars($ta->tahun_akademik) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jenis Magang</label>
                            <select name="jenis_magang" class="form-select" required>
                                <option value="reguler" <?= $proposal->jenis_magang == 'reguler' ? 'selected' : '' ?>>Reguler</option>
                                <option value="bumn" <?= $proposal->jenis_magang == 'bumn' ? 'selected' : '' ?>>BUMN</option>
                                <option value="mbkm" <?= $proposal->jenis_magang == 'mbkm' ? 'selected' : '' ?>>MBKM</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tanggal Pengajuan</label>
                            <input type="date" name="tanggal_pengajuan" class="form-control" required
                                value="<?= format_indo('Y-m-d') ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Provinsi</label>
                        <div class="searchable-select" id="provinsiWrapperR2">
                            <div class="searchable-select-trigger form-select" onclick="toggleProvinsiDropdown('provinsiWrapperR2')">
                                <span class="searchable-select-placeholder"><?= isset($proposal->provinsi) && $proposal->provinsi ? htmlspecialchars($proposal->provinsi) : '-- Pilih Provinsi --' ?></span>
                            </div>
                            <div class="searchable-select-dropdown">
                                <div class="searchable-select-search">
                                    <i class="bi bi-search"></i>
                                    <input type="text" placeholder="Cari provinsi..." oninput="filterProvinsi(this, 'provinsiWrapperR2')">
                                </div>
                                <div class="searchable-select-options" data-target="provinsiR2"></div>
                            </div>
                            <input type="hidden" name="provinsi" id="provinsiR2" value="<?= htmlspecialchars($proposal->provinsi ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Instansi</label>
                        <textarea name="alamat_instansi" class="form-control" rows="2"><?= htmlspecialchars($proposal->alamat_instansi ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link Proposal (Google Drive)</label>
                        <input type="url" name="link_proposal" class="form-control" required
                            value="<?= htmlspecialchars($proposal->link_proposal) ?>"
                            placeholder="https://drive.google.com/...">
                        <small class="text-muted">Upload proposal yang sudah diperbaiki ke Google Drive lalu paste linknya di sini</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Apakah Anda memerlukan Surat Pengantar dari Sekretaris?</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="butuh_surat_pengantar" id="suratYaR2" value="1" <?= (!isset($proposal->butuh_surat_pengantar) || (int)$proposal->butuh_surat_pengantar == 1) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="suratYaR2">Ya, saya butuh surat pengantar resmi dari sekretaris</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="butuh_surat_pengantar" id="suratTidakR2" value="0" <?= (isset($proposal->butuh_surat_pengantar) && (int)$proposal->butuh_surat_pengantar == 0) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="suratTidakR2">Tidak, saya langsung upload balasan mitra (tanpa surat pengantar)</label>
                        </div>
                        <div class="alert alert-light border-primary border-start border-3 py-2 px-3 mt-2 mb-0">
                            <small class="text-primary">
                                <i class="bi bi-info-circle me-1"></i>
                                Pilih "Ya" jika mitra memerlukan surat pengantar resmi dari institusi.<br>
                                Pilih "Tidak" jika bisa langsung upload balasan dari mitra.
                            </small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-1"></i>Ajukan Ulang
                    </button>
                </form>
            </div>
        </div>

    <?php elseif ($proposal->status_kaprodi == 'disetujui'): ?>
        <!-- DISETUJUI KAPRODI - Show Surat & Balasan Section -->
        <?php $butuh_surat_val = isset($proposal->butuh_surat_pengantar) ? (int)$proposal->butuh_surat_pengantar : 1; ?>
        <div class="alert alert-success mt-3">
            <i class="bi bi-check-circle me-2"></i>
            Selamat! Proposal Anda telah disetujui.
            <?= $butuh_surat_val == 0 ? 'Silakan langsung upload balasan mitra.' : 'Silakan download surat pengantar dan upload balasan mitra.' ?>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                <i class="bi bi-check-circle me-2"></i><?= $butuh_surat_val == 0 ? 'Balasan Mitra' : 'Surat Pengantar & Balasan Mitra' ?>
            </div>
            <div class="card-body">
                <?php if ($butuh_surat_val == 1): ?>
                    <?php if (isset($surat) && $surat): ?>
                    <!-- 1. SURAT PENGANTAR (hanya jika butuh dan sudah ready) -->
                    <h6 class="mb-3"><i class="bi bi-file-earmark me-1"></i>Surat Pengantar</h6>
                        <div class="alert alert-info mb-3 d-flex justify-content-between align-items-center border-0 shadow-sm" style="background-color: #e8f4fd;">
                            <div>
                                <h6 class="mb-1 text-dark fw-bold"><i class="bi bi-file-text me-2 text-primary"></i><?= htmlspecialchars($surat->nomor_surat) ?></h6>
                                <p class="mb-0 text-muted small ms-4"><i class="bi bi-calendar-event me-1"></i>Tanggal: <?= format_indo('d M Y', strtotime($surat->tanggal_surat)) ?></p>
                            </div>
                            <a href="<?= $surat->file_surat ?>" target="_blank" class="btn btn-primary shadow-sm px-4">
                                <i class="bi bi-download me-2"></i>Download Surat
                            </a>
                        </div>
                        <!-- 2. BALASAN MITRA -->
                        <hr class="my-3">
                    <?php endif; ?>
                <?php endif; ?>

                <h6 class="mb-3"><i class="bi bi-inbox me-1"></i>Balasan Mitra</h6>

                <?php if ($proposal->status_mitra == 'diterima'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        <?php if (isset($mahasiswa) && $mahasiswa->dosen_dpl_id): ?>
                            Selamat! Mitra telah menerima aplikasi magang Anda. DPL sudah ditugaskan.
                        <?php else: ?>
                            Selamat! Mitra telah menerima aplikasi magang Anda. DPL sedang dalam proses penugasan.
                        <?php endif; ?>
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
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tahun Akademik</label>
                                        <select name="tahun_akademik" class="form-select" required>
                                            <option value="">-- Pilih Tahun Akademik --</option>
                                            <?php if (isset($tahun_akademik_list)): ?>
                                                <?php foreach ($tahun_akademik_list as $ta): ?>
                                                    <option value="<?= htmlspecialchars($ta->tahun_akademik) ?>"><?= htmlspecialchars($ta->tahun_akademik) ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Jenis Magang</label>
                                        <select name="jenis_magang" class="form-select" required>
                                            <option value="">-- Pilih Jenis Magang --</option>
                                            <option value="reguler">Reguler</option>
                                            <option value="bumn">BUMN</option>
                                            <option value="mbkm">MBKM</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tanggal Pengajuan</label>
                                        <input type="date" name="tanggal_pengajuan" class="form-control" required
                                            value="<?= format_indo('Y-m-d') ?>">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Provinsi</label>
                                    <div class="searchable-select" id="provinsiWrapperNew">
                                        <div class="searchable-select-trigger form-select" onclick="toggleProvinsiDropdown('provinsiWrapperNew')">
                                            <span class="searchable-select-placeholder">-- Pilih Provinsi --</span>
                                        </div>
                                        <div class="searchable-select-dropdown">
                                            <div class="searchable-select-search">
                                                <i class="bi bi-search"></i>
                                                <input type="text" placeholder="Cari provinsi..." oninput="filterProvinsi(this, 'provinsiWrapperNew')">
                                            </div>
                                            <div class="searchable-select-options" data-target="provinsiNew"></div>
                                        </div>
                                        <input type="hidden" name="provinsi" id="provinsiNew" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat Instansi</label>
                                    <textarea name="alamat_instansi" class="form-control" rows="2"
                                        placeholder="Alamat lengkap instansi"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Link Proposal (Google Drive)</label>
                                    <input type="url" name="link_proposal" class="form-control" required
                                        placeholder="https://drive.google.com/...">
                                    <small class="text-muted">Upload proposal Anda ke Google Drive lalu paste linknya di sini</small>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Apakah Anda memerlukan Surat Pengantar dari Sekretaris?</label>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="butuh_surat_pengantar" id="suratYaBaru" value="1" checked>
                                        <label class="form-check-label" for="suratYaBaru">Ya, saya butuh surat pengantar resmi dari sekretaris</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="butuh_surat_pengantar" id="suratTidakBaru" value="0">
                                        <label class="form-check-label" for="suratTidakBaru">Tidak, saya langsung upload balasan mitra (tanpa surat pengantar)</label>
                                    </div>
                                    <div class="alert alert-light border-primary border-start border-3 py-2 px-3 mt-2 mb-0">
                                        <small class="text-primary">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Pilih "Ya" jika mitra memerlukan surat pengantar resmi dari institusi.<br>
                                            Pilih "Tidak" jika bisa langsung upload balasan dari mitra.
                                        </small>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-send me-1"></i>Ajukan Proposal Baru
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Form Upload Balasan -->
                <?php
                // Upload hanya boleh jika proposal sudah disetujui kaprodi
                $bisa_upload = ($butuh_surat_val == 0) || (isset($surat) && $surat);
                ?>
                <?php if ($bisa_upload && $proposal->status_mitra == 'menunggu'): ?>
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
                <?php elseif ($proposal->status_mitra != 'menunggu'): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Balasan mitra sudah ter-upload dengan status: <strong><?= ucfirst($proposal->status_mitra) ?></strong>
                    </div>
                <?php elseif ($butuh_surat_val == 1 && !(isset($surat) && $surat)): ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-hourglass-split me-2"></i>
                        Surat pengantar sedang diproses oleh sekretaris. Form upload balasan mitra akan tersedia setelah surat selesai dibuat.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <?php $butuh_surat_else = isset($proposal->butuh_surat_pengantar) ? (int)$proposal->butuh_surat_pengantar : 1; ?>
        <?php if ($butuh_surat_else == 0 && $proposal->status_mitra != 'menunggu'): ?>
            <div class="alert alert-info mt-3">
                <i class="bi bi-info-circle me-2"></i>
                Balasan mitra sudah ter-upload dengan status: <strong><?= ucfirst($proposal->status_mitra) ?></strong>
            </div>
        <?php else: ?>
            <div class="alert alert-info mt-3">
                <i class="bi bi-hourglass-split me-2"></i>
                Proposal Anda sedang dalam proses review. Mohon tunggu.
            </div>
        <?php endif; ?>
    <?php endif; ?>

<?php endif; ?>

<style>
/* Searchable Select Dropdown */
.searchable-select {
    position: relative;
}

.searchable-select-trigger {
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: calc(1.5em + 1.25rem + 2px);
    user-select: none;
}

.searchable-select-trigger .searchable-select-placeholder {
    flex: 1;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.searchable-select-trigger.has-value .searchable-select-placeholder {
    color: #1e293b;
}

.searchable-select-dropdown {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 1050;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    margin-top: 4px;
    max-height: 320px;
    overflow: hidden;
    display: none;
}

.searchable-select.open .searchable-select-dropdown {
    display: block;
    animation: dropdownFadeIn 0.2s ease;
}

@keyframes dropdownFadeIn {
    from { opacity: 0; transform: translateY(-4px); }
    to { opacity: 1; transform: translateY(0); }
}

.searchable-select-search {
    padding: 0.6rem 0.8rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: #f8fafc;
    border-radius: 8px 8px 0 0;
}

.searchable-select-search i {
    color: #94a3b8;
    font-size: 0.85rem;
}

.searchable-select-search input {
    border: none;
    outline: none;
    width: 100%;
    font-size: 0.85rem;
    font-family: 'Inter', sans-serif;
    background: transparent;
    color: #1e293b;
}

.searchable-select-search input::placeholder {
    color: #94a3b8;
}

.searchable-select-options {
    max-height: 250px;
    overflow-y: auto;
    padding: 0.25rem 0;
}

.searchable-select-options::-webkit-scrollbar {
    width: 5px;
}

.searchable-select-options::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.searchable-select-option {
    padding: 0.5rem 0.8rem;
    font-size: 0.85rem;
    cursor: pointer;
    transition: background 0.15s ease;
    color: #334155;
}

.searchable-select-option:hover {
    background: #f0f7ff;
    color: #0073AC;
}

.searchable-select-option.selected {
    background: #e0f2fe;
    color: #0073AC;
    font-weight: 600;
}

.searchable-select-option.hidden {
    display: none;
}

.searchable-select-no-result {
    padding: 0.8rem;
    text-align: center;
    color: #94a3b8;
    font-size: 0.8rem;
    display: none;
}
</style>

<script>
// Daftar Provinsi dari Database
const daftarProvinsi = [
    <?php if (isset($provinsi_list) && !empty($provinsi_list)): ?>
        <?php foreach ($provinsi_list as $p): ?>
            '<?= addslashes($p->nama_provinsi) ?>',
        <?php endforeach; ?>
    <?php endif; ?>
];

// Initialize all searchable select dropdowns
document.addEventListener('DOMContentLoaded', function() {
    const wrappers = document.querySelectorAll('.searchable-select');
    wrappers.forEach(function(wrapper) {
        const optionsContainer = wrapper.querySelector('.searchable-select-options');
        const hiddenInput = wrapper.querySelector('input[type="hidden"]');
        const trigger = wrapper.querySelector('.searchable-select-trigger');
        const placeholder = trigger.querySelector('.searchable-select-placeholder');
        const currentVal = hiddenInput.value;

        // Build options
        let html = '';
        daftarProvinsi.forEach(function(prov) {
            const isSelected = (currentVal === prov) ? ' selected' : '';
            html += '<div class="searchable-select-option' + isSelected + '" data-value="' + prov + '" onclick="selectProvinsi(this)">' + prov + '</div>';
        });
        html += '<div class="searchable-select-no-result">Provinsi tidak ditemukan</div>';
        optionsContainer.innerHTML = html;

        // Set initial value display
        if (currentVal) {
            placeholder.textContent = currentVal;
            trigger.classList.add('has-value');
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        wrappers.forEach(function(wrapper) {
            if (!wrapper.contains(e.target)) {
                wrapper.classList.remove('open');
            }
        });
    });
});

function toggleProvinsiDropdown(wrapperId) {
    const wrapper = document.getElementById(wrapperId);
    // Close all others
    document.querySelectorAll('.searchable-select.open').forEach(function(el) {
        if (el.id !== wrapperId) el.classList.remove('open');
    });
    wrapper.classList.toggle('open');

    if (wrapper.classList.contains('open')) {
        const searchInput = wrapper.querySelector('.searchable-select-search input');
        setTimeout(function() { searchInput.focus(); }, 100);
    }
}

function filterProvinsi(input, wrapperId) {
    const wrapper = document.getElementById(wrapperId);
    const options = wrapper.querySelectorAll('.searchable-select-option');
    const noResult = wrapper.querySelector('.searchable-select-no-result');
    const keyword = input.value.toLowerCase();
    let found = 0;

    options.forEach(function(opt) {
        if (opt.dataset.value.toLowerCase().includes(keyword)) {
            opt.classList.remove('hidden');
            found++;
        } else {
            opt.classList.add('hidden');
        }
    });

    noResult.style.display = found === 0 ? 'block' : 'none';
}

function selectProvinsi(optionEl) {
    const wrapper = optionEl.closest('.searchable-select');
    const hiddenInput = wrapper.querySelector('input[type="hidden"]');
    const trigger = wrapper.querySelector('.searchable-select-trigger');
    const placeholder = trigger.querySelector('.searchable-select-placeholder');
    const value = optionEl.dataset.value;

    // Remove previous selection
    wrapper.querySelectorAll('.searchable-select-option.selected').forEach(function(el) {
        el.classList.remove('selected');
    });

    // Set new selection
    optionEl.classList.add('selected');
    hiddenInput.value = value;
    placeholder.textContent = value;
    trigger.classList.add('has-value');

    // Close dropdown
    wrapper.classList.remove('open');

    // Reset search
    const searchInput = wrapper.querySelector('.searchable-select-search input');
    searchInput.value = '';
    wrapper.querySelectorAll('.searchable-select-option').forEach(function(opt) {
        opt.classList.remove('hidden');
    });
    wrapper.querySelector('.searchable-select-no-result').style.display = 'none';
}
</script>

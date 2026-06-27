<?php if ($this->session->flashdata('success')): ?>
    <div style="background-color:#d4edda;padding:10px;margin-bottom:15px;border-radius:5px;">
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>

<h2><i class="bi bi-journal-text me-2"></i>Monitoring Logbook Mahasiswa</h2>
<p class="text-muted mb-4">Lihat semua logbook yang telah dikumpulkan oleh mahasiswa magang</p>

<?php if (empty($logbooks)): ?>
    <div style="text-align:center;padding:50px;background:#f8f9fa;border-radius:10px;">
        <p style="color:#666;font-size:18px;">Belum ada logbook yang dikumpulkan</p>
    </div>
<?php else: ?>
    <?php
        // Group logbooks by mahasiswa
        $grouped_logbooks = [];
        foreach ($logbooks as $l) {
            if (!isset($grouped_logbooks[$l->mahasiswa_id])) {
                $grouped_logbooks[$l->mahasiswa_id] = [
                    'nama' => isset($l->nama_mahasiswa) ? $l->nama_mahasiswa : '-',
                    'nim' => isset($l->nim) ? $l->nim : '-',
                    'logbooks' => []
                ];
            }
            $grouped_logbooks[$l->mahasiswa_id]['logbooks'][] = $l;
        }
    ?>
    <div class="card mt-4">
        <div class="card-body p-0">
            <div class="accordion accordion-flush" id="accordionLogbooks">
                <?php foreach ($grouped_logbooks as $m_id => $group): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?= $m_id ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#collapse<?= $m_id ?>" aria-expanded="false" aria-controls="collapse<?= $m_id ?>">
                                <strong><?= $group['nama'] ?></strong> &nbsp; <span class="text-muted">(<?= $group['nim'] ?>)</span>
                                <span class="badge bg-primary ms-auto me-3"><?= count($group['logbooks']) ?> Logbook</span>
                            </button>
                        </h2>
                        <div id="collapse<?= $m_id ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $m_id ?>" data-bs-parent="#accordionLogbooks">
                            <div class="accordion-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Bulan Ke</th>
                                                <th>Status DPL</th>
                                                <th>Tanggal Upload</th>
                                                <th>Link</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($group['logbooks'] as $l): ?>
                                                <tr>
                                                    <td>Bulan <?= $l->bulan_ke ?></td>
                                                    <td>
                                                        <?php
                                                        $status = isset($l->status_dpl) ? $l->status_dpl : 'belum_review';
                                                        switch ($status) {
                                                            case 'sudah_review':
                                                                $badge_color = 'success';
                                                                break;
                                                            case 'revisi':
                                                                $badge_color = 'warning text-dark';
                                                                break;
                                                            default:
                                                                $badge_color = 'secondary';
                                                        }
                                                        ?>
                                                        <span class="badge bg-<?= $badge_color ?>">
                                                            <?= ucfirst(str_replace('_', ' ', $status)) ?>
                                                        </span>
                                                    </td>
                                                    <td><?= format_indo('d M Y', strtotime($l->tanggal_upload)) ?></td>
                                                    <td>
                                                        <a href="<?= $l->link_logbook ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-box-arrow-up-right"></i> Lihat
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

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
    <table border="1" cellpadding="10" style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="background-color:#f4f4f4;">
                <th>No</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Bulan Ke</th>
                <th>Status DPL</th>
                <th>Tanggal Upload</th>
                <th>Link</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($logbooks as $l): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= isset($l->nim) ? $l->nim : '-' ?></td>
                    <td><?= isset($l->nama_mahasiswa) ? $l->nama_mahasiswa : '-' ?></td>
                    <td>Bulan <?= $l->bulan_ke ?></td>
                    <td>
                        <?php
                        $status = isset($l->status_dpl) ? $l->status_dpl : 'belum_review';
                        switch ($status) {
                            case 'sudah_review':
                                $badge_color = '#28a745';
                                break;
                            case 'revisi':
                                $badge_color = '#ffc107';
                                break;
                            default:
                                $badge_color = '#6c757d';
                        }
                        ?>
                        <span
                            style="background:<?= $badge_color ?>;color:#fff;padding:3px 8px;border-radius:3px;font-size:12px;">
                            <?= ucfirst(str_replace('_', ' ', $status)) ?>
                        </span>
                    </td>
                    <td><?= date('d M Y', strtotime($l->tanggal_upload)) ?></td>
                    <td>
                        <a href="<?= $l->link_logbook ?>" target="_blank" style="color:#007bff;">
                            <i class="bi bi-box-arrow-up-right"></i> Lihat
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<br><br>
<a href="<?= base_url('dashboard/koordinator') ?>" class="btn btn-secondary">&larr; Kembali ke Dashboard</a>
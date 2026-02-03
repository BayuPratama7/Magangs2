<h2>Dashboard Koordinator Magang</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>NIM</th>
        <th>Prodi</th>
        <th>Judul</th>
        <th>Instansi</th>
        <th>Jenis</th>
        <th>Tanggal</th>
        <th>Proposal</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

<?php foreach ($proposals as $p): ?>
<tr>
    <td><?= $p->nim ?></td>
    <td><?= $p->prodi ?></td>
    <td><?= $p->judul_proposal ?></td>
    <td><?= $p->instansi_tujuan ?></td>
    <td><?= strtoupper($p->jenis_magang) ?></td>
    <td><?= $p->tanggal_pengajuan ?></td>
    <td>
        <a href="<?= $p->link_proposal ?>" target="_blank">Lihat</a>
    </td>
    <td><?= ucfirst($p->status_koordinator) ?></td>
    <td>
        <?php if ($p->status_koordinator == 'menunggu'): ?>
            <a href="<?= base_url('koordinator/acc/'.$p->proposal_id) ?>">✅ ACC</a> |
            <a href="<?= base_url('koordinator/reject/'.$p->proposal_id) ?>">❌ Tolak</a>
        <?php else: ?>
            -
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>

</table>

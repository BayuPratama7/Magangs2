<!-- ============================================================ -->
<!-- Sebaran Magang: Side by Side filters for sidebar             -->
<!-- ============================================================ -->
<div class="card mb-4" id="sebaranJenisCard">
    <div class="card-header">
        <i class="bi bi-pie-chart me-2"></i>Sebaran Magang
    </div>
    <div class="card-body">
        <!-- Filters -->
        <div class="row g-2 mb-4">
            <div class="col-12">
                        <select class="form-select" id="tahunFilterJenis" onchange="filterSebaranJenis()"
                            style="border-radius: 10px; padding: 0.55rem 1rem; font-size: 0.85rem; border: 1px solid #e2e8f0; background-color: #f8fafc; cursor: pointer;">
                            <option value="semua">Semua Tahun Akademik</option>
                            <?php if (isset($tahun_akademik_list) && !empty($tahun_akademik_list)): ?>
                                <?php foreach ($tahun_akademik_list as $thn): ?>
                                    <option value="<?= htmlspecialchars($thn->tahun_akademik) ?>"><?= htmlspecialchars($thn->tahun_akademik) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
            <div class="col-12">
                        <select class="form-select" id="jenisFilterJenis" onchange="filterSebaranJenis()"
                            style="border-radius: 10px; padding: 0.55rem 1rem; font-size: 0.85rem; border: 1px solid #e2e8f0; background-color: #f8fafc; cursor: pointer;">
                            <option value="semua">Semua Jenis Magang</option>
                            <option value="reguler">Reguler</option>
                            <option value="bumn">BUMN</option>
                            <option value="mbkm">MBKM</option>
                        </select>
                    </div>
            <div class="col-12">
                        <select class="form-select" id="provinsiFilterJenis" onchange="filterSebaranJenis()"
                            style="border-radius: 10px; padding: 0.55rem 1rem; font-size: 0.85rem; border: 1px solid #e2e8f0; background-color: #f8fafc; cursor: pointer;">
                            <option value="semua">Semua Provinsi</option>
                            <?php if (isset($provinsi_list) && !empty($provinsi_list)): ?>
                                <?php foreach ($provinsi_list as $prov): ?>
                                    <option value="<?= htmlspecialchars($prov->nama_provinsi) ?>"><?= htmlspecialchars($prov->nama_provinsi) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <?php if (isset($sebaran_jenis) && !empty($sebaran_jenis)): ?>
                    <div class="text-center mb-3">
                        <canvas id="chartJenis" style="max-height: 200px;"></canvas>
                    </div>
                    <?php $jenis_colors = ['reguler' => '#6366f1', 'bumn' => '#22c55e', 'mbkm' => '#f59e0b']; ?>
                    <div class="d-flex justify-content-center gap-3 mb-3 flex-wrap" id="legendJenis">
                        <?php foreach ($sebaran_jenis as $s): ?>
                            <span class="d-flex align-items-center gap-1" style="font-size: 0.8rem; color: #475569;">
                                <span style="display:inline-block; width:10px; height:10px; border-radius:50%; background:<?= $jenis_colors[$s->jenis_magang] ?? '#94a3b8' ?>;"></span>
                                <?= strtoupper($s->jenis_magang) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <hr style="border-color: #e2e8f0; margin: 0.75rem 0;">
                    <div id="detailJenis">
                        <?php foreach ($sebaran_jenis as $s): ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span style="font-weight: 600; font-size: 0.95rem; color: #1e293b;"><?= strtoupper($s->jenis_magang) ?></span>
                                <span style="background: <?= $jenis_colors[$s->jenis_magang] ?? '#94a3b8' ?>; color: white; padding: 0.3rem 0.8rem; border-radius: 8px; font-size: 0.8rem; font-weight: 600;">
                                    <?= $s->total ?> mahasiswa
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-pie-chart display-4 text-muted"></i>
                        <p class="text-muted mt-2 mb-0">Data belum tersedia</p>
                    </div>
                <?php endif; ?>
            </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== Chart 1: Sebaran by Jenis ==========
    var ctxJenis = document.getElementById('chartJenis');
    if (ctxJenis) {
        window.chartJenis = new Chart(ctxJenis.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: [<?php if (isset($sebaran_jenis)): foreach ($sebaran_jenis as $s): ?>'<?= strtoupper($s->jenis_magang) ?>',<?php endforeach; endif; ?>],
                datasets: [{
                    data: [<?php if (isset($sebaran_jenis)): foreach ($sebaran_jenis as $s): ?><?= $s->total ?>,<?php endforeach; endif; ?>],
                    backgroundColor: ['#6366f1', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6'],
                    borderWidth: 3, borderColor: '#fff', hoverBorderWidth: 4, hoverOffset: 8
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: true, cutout: '60%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b', cornerRadius: 8, padding: 10,
                        titleFont: { size: 13, weight: '600' }, bodyFont: { size: 12 },
                        callbacks: { label: function(ctx) { return ctx.label + ': ' + ctx.raw + ' mahasiswa'; } }
                    }
                },
                animation: { animateRotate: true, animateScale: true, duration: 800, easing: 'easeOutQuart' }
            }
        });
    }
});

// ========== AJAX Filter: Jenis by Provinsi ==========
var jenisColorMap = { 'reguler': '#6366f1', 'bumn': '#22c55e', 'mbkm': '#f59e0b' };
var jenisDefColors = ['#6366f1', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6'];

function filterSebaranJenis() {
    var chart = document.getElementById('chartJenis');
    if (chart) chart.style.opacity = '0.5';

    var provinsi = document.getElementById('provinsiFilterJenis').value;
    var tahun = document.getElementById('tahunFilterJenis').value;
    var jenis = document.getElementById('jenisFilterJenis').value;

    fetch('<?= $filter_url ?? base_url("dashboard/koordinator/sebaran_filter") ?>?mode=jenis&provinsi=' + encodeURIComponent(provinsi) + '&tahun=' + encodeURIComponent(tahun) + '&jenis=' + encodeURIComponent(jenis), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (chart) chart.style.opacity = '1';

        if (data.length === 0) {
            if (window.chartJenis) {
                window.chartJenis.data.labels = ['Tidak ada data'];
                window.chartJenis.data.datasets[0].data = [1];
                window.chartJenis.data.datasets[0].backgroundColor = ['#e2e8f0'];
                window.chartJenis.update('active');
            }
            document.getElementById('legendJenis').innerHTML = '<span class="text-muted" style="font-size:0.85rem;">Tidak ada data untuk provinsi ini</span>';
            document.getElementById('detailJenis').innerHTML = '<div class="text-center py-3"><p class="text-muted mb-0">Tidak ada data magang di provinsi ini</p></div>';
            return;
        }

        var labels = [], values = [], colors = [];
        for (var i = 0; i < data.length; i++) {
            labels.push(data[i].label);
            values.push(data[i].total);
            colors.push(jenisColorMap[data[i].key] || jenisDefColors[i % jenisDefColors.length]);
        }

        if (window.chartJenis) {
            window.chartJenis.data.labels = labels;
            window.chartJenis.data.datasets[0].data = values;
            window.chartJenis.data.datasets[0].backgroundColor = colors;
            window.chartJenis.update('active');
        }

        var legendHtml = '';
        for (var i = 0; i < data.length; i++) {
            var c = jenisColorMap[data[i].key] || '#94a3b8';
            legendHtml += '<span class="d-flex align-items-center gap-1" style="font-size:0.8rem;color:#475569;">' +
                '<span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:' + c + ';"></span>' +
                data[i].label + '</span>';
        }
        document.getElementById('legendJenis').innerHTML = legendHtml;

        var detailHtml = '';
        for (var i = 0; i < data.length; i++) {
            var c = jenisColorMap[data[i].key] || '#94a3b8';
            detailHtml += '<div class="d-flex justify-content-between align-items-center mb-3">' +
                '<span style="font-weight:600;font-size:0.95rem;color:#1e293b;">' + data[i].label + '</span>' +
                '<span style="background:' + c + ';color:white;padding:0.3rem 0.8rem;border-radius:8px;font-size:0.8rem;font-weight:600;">' +
                data[i].total + ' mahasiswa</span></div>';
        }
        document.getElementById('detailJenis').innerHTML = detailHtml;
    })
    .catch(function(err) {
        console.error('Filter error:', err);
        if (chart) chart.style.opacity = '1';
    });
}
</script>

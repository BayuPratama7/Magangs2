<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>Sistem Magang SI</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f1f5f9;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: var(--sidebar-bg);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.5rem;
            background: var(--primary-gradient);
            text-align: center;
        }

        .sidebar-brand h4 {
            margin: 0;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .sidebar-brand small {
            opacity: 0.8;
            font-size: 0.75rem;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu .menu-header {
            padding: 0.75rem 1.5rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            font-weight: 600;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.875rem;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: var(--sidebar-hover);
            color: white;
            border-left: 3px solid #667eea;
        }

        .sidebar-menu a i {
            width: 24px;
            margin-right: 10px;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Top Navbar */
        .top-navbar {
            background: white;
            padding: 1rem 1.5rem;
            box-shadow: var(--card-shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Page Content */
        .page-content {
            padding: 1.5rem;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            padding: 1rem 1.25rem;
        }

        /* Stat Cards */
        .stat-card {
            border-radius: 12px;
            padding: 1.5rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
        }

        .stat-card.purple {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-card.blue {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-card.green {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .stat-card.orange {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .stat-card.red {
            background: linear-gradient(135deg, #ff5858 0%, #f857a6 100%);
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-card p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.875rem;
        }

        .stat-card i {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 3rem;
            opacity: 0.3;
        }

        /* Tables */
        .table {
            margin-bottom: 0;
        }

        .table th {
            background: #f8fafc;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
            border-bottom: 2px solid #e2e8f0;
        }

        .table td {
            vertical-align: middle;
            font-size: 0.875rem;
        }

        /* Badges */
        .badge {
            font-weight: 500;
            padding: 0.4em 0.8em;
            border-radius: 6px;
        }

        .badge-menunggu {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-disetujui {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-ditolak {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-revisi {
            background: #dbeafe;
            color: #1e40af;
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        /* Forms */
        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        }

        .form-label {
            font-weight: 500;
            color: #475569;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        /* Alert */
        .alert {
            border: none;
            border-radius: 10px;
            font-size: 0.875rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h4><i class="bi bi-mortarboard-fill"></i> SISTEM MAGANG</h4>
            <small>Prodi Sistem Informasi</small>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-header">Menu Utama</div>

            <?php
            $role_id = $this->session->userdata('role_id');
            $current_url = uri_string();
            ?>

            <?php if ($role_id == 5): // Mahasiswa ?>
                <a href="<?= base_url('dashboard/mahasiswa') ?>"
                    class="<?= strpos($current_url, 'dashboard/mahasiswa') !== false ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="<?= base_url('proposal') ?>"
                    class="<?= strpos($current_url, 'proposal') !== false ? 'active' : '' ?>">
                    <i class="bi bi-file-earmark-text"></i> Proposal Magang
                </a>
                <a href="<?= base_url('logbook') ?>"
                    class="<?= strpos($current_url, 'logbook') !== false ? 'active' : '' ?>">
                    <i class="bi bi-journal-text"></i> Logbook
                </a>
                <a href="<?= base_url('laporan') ?>"
                    class="<?= strpos($current_url, 'laporan') !== false ? 'active' : '' ?>">
                    <i class="bi bi-file-earmark-pdf"></i> Laporan Magang
                </a>
                <a href="<?= base_url('desiminasi') ?>"
                    class="<?= strpos($current_url, 'desiminasi') !== false ? 'active' : '' ?>">
                    <i class="bi bi-easel"></i> Desiminasi
                </a>

            <?php elseif ($role_id == 2): // Koordinator ?>
                <a href="<?= base_url('dashboard/koordinator') ?>"
                    class="<?= strpos($current_url, 'dashboard/koordinator') !== false ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="<?= base_url('koordinator') ?>"
                    class="<?= strpos($current_url, 'koordinator') !== false && strpos($current_url, 'dashboard') === false ? 'active' : '' ?>">
                    <i class="bi bi-file-earmark-check"></i> ACC Proposal
                </a>
                <a href="<?= base_url('koordinator/logbook') ?>"
                    class="<?= strpos($current_url, 'koordinator/logbook') !== false ? 'active' : '' ?>">
                    <i class="bi bi-journal-text"></i> Monitoring Logbook
                </a>
                <a href="<?= base_url('koordinator/hasil') ?>"
                    class="<?= strpos($current_url, 'koordinator/hasil') !== false ? 'active' : '' ?>">
                    <i class="bi bi-clipboard-check"></i> Hasil Desiminasi
                </a>

            <?php elseif ($role_id == 1): // Kaprodi ?>
                <a href="<?= base_url('dashboard/kaprodi') ?>"
                    class="<?= strpos($current_url, 'dashboard/kaprodi') !== false && strpos($current_url, 'hasil') === false ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="<?= base_url('proposal/kaprodi') ?>"
                    class="<?= strpos($current_url, 'proposal/kaprodi') !== false ? 'active' : '' ?>">
                    <i class="bi bi-file-earmark-check"></i> ACC Proposal
                </a>
                <a href="<?= base_url('dashboard/kaprodi/hasil') ?>"
                    class="<?= strpos($current_url, 'dashboard/kaprodi/hasil') !== false ? 'active' : '' ?>">
                    <i class="bi bi-trophy"></i> Hasil Desiminasi
                </a>

            <?php elseif ($role_id == 3): // Sekretaris ?>
                <a href="<?= base_url('dashboard/sekretaris') ?>"
                    class="<?= strpos($current_url, 'dashboard/sekretaris') !== false ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <div class="menu-header">Administrasi</div>
                <a href="<?= base_url('admin/dpl') ?>"
                    class="<?= strpos($current_url, 'admin/dpl') !== false ? 'active' : '' ?>">
                    <i class="bi bi-person-plus"></i> Penugasan DPL
                </a>
                <a href="<?= base_url('admin/surat') ?>"
                    class="<?= strpos($current_url, 'admin/surat') !== false ? 'active' : '' ?>">
                    <i class="bi bi-envelope"></i> Surat Pengantar
                </a>
                <a href="<?= base_url('admin/penguji') ?>"
                    class="<?= strpos($current_url, 'admin/penguji') !== false ? 'active' : '' ?>">
                    <i class="bi bi-person-check"></i> Penugasan Penguji
                </a>
                <a href="<?= base_url('admin/jadwal') ?>"
                    class="<?= strpos($current_url, 'admin/jadwal') !== false ? 'active' : '' ?>">
                    <i class="bi bi-calendar-event"></i> Jadwal Desiminasi
                </a>
                <div class="menu-header">Hasil Magang</div>
                <a href="<?= base_url('sekretaris/desiminasi') ?>"
                    class="<?= strpos($current_url, 'sekretaris/desiminasi') !== false && strpos($current_url, 'hasil') === false ? 'active' : '' ?>">
                    <i class="bi bi-hourglass"></i> Pengajuan Desiminasi
                </a>
                <a href="<?= base_url('sekretaris/desiminasi/hasil') ?>"
                    class="<?= strpos($current_url, 'sekretaris/desiminasi/hasil') !== false ? 'active' : '' ?>">
                    <i class="bi bi-trophy"></i> Hasil Desiminasi
                </a>
                <div class="menu-header">Konten Dashboard</div>
                <a href="<?= base_url('admin/mitra') ?>"
                    class="<?= strpos($current_url, 'admin/mitra') !== false ? 'active' : '' ?>">
                    <i class="bi bi-building"></i> Mitra Kerjasama
                </a>
                <a href="<?= base_url('admin/sebaran') ?>"
                    class="<?= strpos($current_url, 'admin/sebaran') !== false ? 'active' : '' ?>">
                    <i class="bi bi-geo-alt"></i> Sebaran Magang
                </a>

            <?php elseif ($role_id == 4): // DPL ?>
                <a href="<?= base_url('dashboard/dosen') ?>"
                    class="<?= strpos($current_url, 'dashboard/dosen') !== false ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="<?= base_url('dosen/bimbingan') ?>"
                    class="<?= strpos($current_url, 'dosen/bimbingan') !== false ? 'active' : '' ?>">
                    <i class="bi bi-people"></i> Mahasiswa Bimbingan
                </a>
                <a href="<?= base_url('dosen/logbook') ?>"
                    class="<?= strpos($current_url, 'dosen/logbook') !== false ? 'active' : '' ?>">
                    <i class="bi bi-journal-text"></i> Review Logbook
                </a>
                <a href="<?= base_url('dosen/laporan') ?>"
                    class="<?= strpos($current_url, 'dosen/laporan') !== false ? 'active' : '' ?>">
                    <i class="bi bi-file-earmark-check"></i> Review Laporan
                </a>
                <a href="<?= base_url('dosen/jadwal') ?>"
                    class="<?= strpos($current_url, 'dosen/jadwal') !== false ? 'active' : '' ?>">
                    <i class="bi bi-calendar"></i> Jadwal Desiminasi
                </a>

            <?php elseif ($role_id == 6): // Penguji ?>
                <a href="<?= base_url('dashboard/penguji') ?>"
                    class="<?= strpos($current_url, 'dashboard/penguji') !== false ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="<?= base_url('penguji/konfirmasi') ?>"
                    class="<?= strpos($current_url, 'penguji/konfirmasi') !== false ? 'active' : '' ?>">
                    <i class="bi bi-check2-circle"></i> Konfirmasi Menguji
                </a>
                <a href="<?= base_url('penguji/jadwal') ?>"
                    class="<?= strpos($current_url, 'penguji/jadwal') !== false ? 'active' : '' ?>">
                    <i class="bi bi-calendar-event"></i> Jadwal Desiminasi
                </a>
                <a href="<?= base_url('penguji/laporan') ?>"
                    class="<?= strpos($current_url, 'penguji/laporan') !== false ? 'active' : '' ?>">
                    <i class="bi bi-file-earmark-check"></i> ACC Laporan Akhir
                </a>
            <?php endif; ?>

            <div class="menu-header">Akun</div>
            <a href="<?= base_url('auth/logout') ?>">
                <i class="bi bi-box-arrow-left"></i> Logout
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div>
                <button class="btn btn-sm btn-light d-lg-none" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
                <span class="ms-2 fw-semibold"><?= isset($page_title) ? $page_title : 'Dashboard' ?></span>
            </div>
            <div class="user-info">
                <div class="user-avatar">
                    <?= strtoupper(substr($this->session->userdata('nama_lengkap') ?? 'U', 0, 1)) ?>
                </div>
                <div>
                    <div class="fw-semibold" style="font-size: 0.875rem">
                        <?= $this->session->userdata('nama_lengkap') ?? 'User' ?></div>
                    <small class="text-muted"><?= $this->session->userdata('role_nama') ?? '' ?></small>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= $this->session->flashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?= $this->session->flashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?= $content ?>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('toggleSidebar')?.addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('show');
        });
    </script>
</body>

</html>
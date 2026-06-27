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

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

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
            transition: transform 0.3s ease;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .sidebar-brand {
            padding: 0.8rem 1rem 0.8rem 3.2rem;
            background: #D5E5FF;
            flex-shrink: 0;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 0.8rem;
            height: auto;
            min-height: 70px;
            width: 100%;
            box-sizing: border-box;
            overflow: visible;
        }

        .sidebar-brand-icon {
            color: #0073AC;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            overflow: visible;
        }

        .sidebar-brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .sidebar-brand-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            gap: 0.05rem;
            flex: 0;
            overflow: visible;
        }

        .sidebar-brand h4 {
            margin: 0;
            padding: 0;
            font-weight: 700;
            font-size: 1rem;
            color: #0073AC;
            font-family: 'Arial', sans-serif;
            line-height: 1.2;
            white-space: nowrap;
            overflow: visible;
        }

        .sidebar-brand small {
            margin: 0;
            padding: 0;
            font-size: 0.7rem;
            color: #0073AC;
            font-family: 'Arial', sans-serif;
            font-weight: 400;
            line-height: 1.2;
            white-space: nowrap;
            overflow: visible;
        }

        .sidebar-close {
            position: absolute;
            top: 50%;
            left: 0.5rem;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #0073AC;
            width: 40px;
            height: 40px;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.8rem;
            transition: transform 0.2s ease;
            padding: 0;
        }

        .sidebar-close:hover {
            transform: translateY(-50%) scale(1.1);
        }

        .sidebar-menu {
            padding: 0.75rem 0;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #475569 transparent;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background-color: #475569;
            border-radius: 4px;
        }

        .sidebar-menu .menu-header {
            padding: 0.6rem 1.5rem 0.3rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            font-weight: 600;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.6rem 1.5rem;
            color: #cbd5e1;
            text-decoration: none;
            transition: background 0.2s ease, color 0.2s ease;
            font-size: 0.875rem;
            border-left: 3px solid transparent;
            white-space: nowrap;
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
            transition: margin-left 0.3s ease;
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

        #toggleSidebar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
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
        }

        .card:hover {
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

        /* Alert Notifications */
        .alert {
            border: none;
            border-radius: 10px;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            padding: 0.9rem 1.2rem;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            max-width: 100%;
            text-align: left;
        }

        .alert-success {
            background: #D4EDDA;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-success .bi {
            color: #28a745;
            font-size: 1.2rem;
        }

        .alert-danger {
            background: #F8D7DA;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-danger .bi {
            color: #dc3545;
            font-size: 1.2rem;
        }

        .alert-info {
            background: #D1ECF1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        .alert-info .bi {
            color: #17a2b8;
            font-size: 1.2rem;
        }

        .alert-warning {
            background: #FFF3CD;
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        .alert-warning .bi {
            color: #ffc107;
            font-size: 1.2rem;
        }

        .alert i {
            margin-right: 0.8rem;
            flex-shrink: 0;
        }

        .alert-dismissible {
            padding-right: 1rem;
        }

        .alert .btn-close {
            opacity: 0.5;
            flex-shrink: 0;
            margin-left: auto;
            margin-right: 0;
        }

        .alert .btn-close:hover {
            opacity: 0.75;
        }

        /* ====================================
         * GLOBAL MODAL STYLING
         * Semua modal header menggunakan warna biru sidebar
         * ==================================== */
        .modal-header {
            background: var(--primary-gradient) !important;
            color: white !important;
            border-bottom: none;
        }

        .modal-header .modal-title {
            color: white !important;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
        }

        .modal-content {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .modal-footer {
            border-top: 1px solid #e2e8f0;
        }

        /* Override tombol aksi utama di modal agar konsisten biru */
        .modal-footer .btn-success,
        .modal-footer .btn-primary {
            background: var(--primary-gradient) !important;
            border: none !important;
        }

        .modal-footer .btn-success:hover,
        .modal-footer .btn-primary:hover {
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        /* Icon di dalam modal body mengikuti tema */
        .modal-body .text-success.display-4,
        .modal-body .text-success.display-1 {
            color: #667eea !important;
        }

        /* Responsive - Sidebar toggle */
        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .main-content.expanded {
            margin-left: 0;
        }

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

            .sidebar-close {
                display: flex;
            }

        }

        /* Preloader */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #f1f5f9;
            z-index: 99999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.5s ease, visibility 0.5s;
        }

        .metaball-container {
            width: 100px;
            height: 100px;
            position: relative;
            filter: url('#gooey');
        }

        .blob {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 35px;
            height: 35px;
            background: #667eea;
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        .blob-1 {
            animation: metaball-move 1.2s infinite alternate ease-in-out;
        }

        .blob-2 {
            animation: metaball-move 1.2s infinite alternate-reverse ease-in-out;
            background: #764ba2;
        }

        @keyframes metaball-move {
            0% { transform: translate(-50%, -50%) translateX(-25px); }
            100% { transform: translate(-50%, -50%) translateX(25px); }
        }
    </style>
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="metaball-container">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
        </div>
        <!-- SVG Filter for Metaball -->
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="display:none;">
            <defs>
                <filter id="gooey">
                    <feGaussianBlur in="SourceGraphic" stdDeviation="8" result="blur" />
                    <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo" />
                    <feBlend in="SourceGraphic" in2="goo" />
                </filter>
            </defs>
        </svg>
    </div>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <button class="sidebar-close" id="closeSidebar" aria-label="Tutup menu">
                <i class="bi bi-list"></i>
            </button>
            <div class="sidebar-brand-icon">
                <img src="<?= base_url('public/images/logo/sipmagang.png') ?>" alt="SIPMAGANG Logo" style="width: 40px; height: 40px; object-fit: contain;">
            </div>
            <div class="sidebar-brand-text">
                <h4>SIPMAGANG</h4>
                <small>Prodi Sistem Informasi</small>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-header">Menu Utama</div>

            <?php
            $active_role = $this->session->userdata('active_role');
            $current_url = uri_string();
            ?>

            <?php if ($active_role == 'mahasiswa'): ?>
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

            <?php elseif ($active_role == 'koordinator'): ?>
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
                <div class="menu-header">Pembimbing</div>
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
                <div class="menu-header">Penguji</div>
                <a href="<?= base_url('penguji/konfirmasi') ?>"
                    class="<?= strpos($current_url, 'penguji/konfirmasi') !== false ? 'active' : '' ?>">
                    <i class="bi bi-check2-circle"></i> Konfirmasi Menguji
                </a>
                <a href="<?= base_url('penguji/jadwal') ?>"
                    class="<?= strpos($current_url, 'penguji/jadwal') !== false || strpos($current_url, 'penguji/input_hasil') !== false ? 'active' : '' ?>">
                    <i class="bi bi-calendar-check"></i> Jadwal Menguji
                </a>
                <a href="<?= base_url('penguji/laporan') ?>"
                    class="<?= strpos($current_url, 'penguji/laporan') !== false ? 'active' : '' ?>">
                    <i class="bi bi-file-earmark-check"></i> ACC Laporan Akhir
                </a>

            <?php elseif ($active_role == 'kaprodi'): ?>
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
                <div class="menu-header">Pembimbing</div>
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
                <div class="menu-header">Penguji</div>
                <a href="<?= base_url('penguji/konfirmasi') ?>"
                    class="<?= strpos($current_url, 'penguji/konfirmasi') !== false ? 'active' : '' ?>">
                    <i class="bi bi-check2-circle"></i> Konfirmasi Menguji
                </a>
                <a href="<?= base_url('penguji/jadwal') ?>"
                    class="<?= strpos($current_url, 'penguji/jadwal') !== false || strpos($current_url, 'penguji/input_hasil') !== false ? 'active' : '' ?>">
                    <i class="bi bi-calendar-check"></i> Jadwal Menguji
                </a>
                <a href="<?= base_url('penguji/laporan') ?>"
                    class="<?= strpos($current_url, 'penguji/laporan') !== false ? 'active' : '' ?>">
                    <i class="bi bi-file-earmark-check"></i> ACC Laporan Akhir
                </a>

            <?php elseif ($active_role == 'sekretaris'): ?>
                <a href="<?= base_url('dashboard/sekretaris') ?>"
                    class="<?= strpos($current_url, 'dashboard/sekretaris') !== false ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <div class="menu-header">Administrasi</div>
                <a href="<?= base_url('admin/mahasiswa') ?>"
                    class="<?= strpos($current_url, 'admin/mahasiswa') !== false ? 'active' : '' ?>">
                    <i class="bi bi-mortarboard"></i> Data Mahasiswa
                </a>
                <a href="<?= base_url('admin/dpl') ?>"
                    class="<?= strpos($current_url, 'admin/dpl') !== false ? 'active' : '' ?>">
                    <i class="bi bi-person-plus"></i> Penugasan DPL
                </a>
                <a href="<?= base_url('admin/surat') ?>"
                    class="<?= strpos($current_url, 'admin/surat') !== false ? 'active' : '' ?>">
                    <i class="bi bi-envelope"></i> Surat Pengantar
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
                <div class="menu-header">Pembimbing</div>
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
                <div class="menu-header">Penguji</div>
                <a href="<?= base_url('penguji/konfirmasi') ?>"
                    class="<?= strpos($current_url, 'penguji/konfirmasi') !== false ? 'active' : '' ?>">
                    <i class="bi bi-check2-circle"></i> Konfirmasi Menguji
                </a>
                <a href="<?= base_url('penguji/jadwal') ?>"
                    class="<?= strpos($current_url, 'penguji/jadwal') !== false || strpos($current_url, 'penguji/input_hasil') !== false ? 'active' : '' ?>">
                    <i class="bi bi-calendar-check"></i> Jadwal Menguji
                </a>
                <a href="<?= base_url('penguji/laporan') ?>"
                    class="<?= strpos($current_url, 'penguji/laporan') !== false ? 'active' : '' ?>">
                    <i class="bi bi-file-earmark-check"></i> ACC Laporan Akhir
                </a>

            <?php elseif ($active_role == 'dosen'): ?>
                <a href="<?= base_url('dashboard/dosen') ?>"
                    class="<?= strpos($current_url, 'dashboard/dosen') !== false ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <div class="menu-header">Pembimbing</div>
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
                <div class="menu-header">Penguji</div>
                <a href="<?= base_url('penguji/konfirmasi') ?>"
                    class="<?= strpos($current_url, 'penguji/konfirmasi') !== false ? 'active' : '' ?>">
                    <i class="bi bi-check2-circle"></i> Konfirmasi Menguji
                </a>
                <a href="<?= base_url('penguji/jadwal') ?>"
                    class="<?= strpos($current_url, 'penguji/jadwal') !== false || strpos($current_url, 'penguji/input_hasil') !== false ? 'active' : '' ?>">
                    <i class="bi bi-calendar-check"></i> Jadwal Menguji
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
    <main class="main-content" id="mainContent">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div>
                <button class="btn btn-sm btn-light" id="toggleSidebar">
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
                        <?= $this->session->userdata('nama_lengkap') ?? 'User' ?>
                    </div>
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
        (function() {
            var sidebar = document.getElementById('sidebar');
            var mainContent = document.getElementById('mainContent');
            var toggleBtn = document.getElementById('toggleSidebar');
            var closeBtn = document.getElementById('closeSidebar');

            function isMobileView() {
                return window.innerWidth <= 992;
            }

            function closeSidebarMobile() {
                sidebar.classList.remove('show');
            }

            // Tombol X di sidebar untuk tutup
            if (closeBtn) {
                closeBtn.addEventListener('click', closeSidebarMobile);
            }

            // Toggle sidebar
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    if (isMobileView()) {
                        sidebar.classList.toggle('show');
                        return;
                    }

                    sidebar.classList.toggle('hidden');
                    mainContent.classList.toggle('expanded');
                });
            }

            function syncSidebarState() {
                if (isMobileView()) {
                    sidebar.classList.remove('hidden');
                    mainContent.classList.remove('expanded');
                    return;
                }

                sidebar.classList.remove('show');
            }

            window.addEventListener('resize', syncSidebarState);
            syncSidebarState();

            // Auto-dismiss alerts setelah 5 detik
            document.addEventListener('DOMContentLoaded', function() {
                const alerts = document.querySelectorAll('.alert.alert-success, .alert.alert-danger');
                alerts.forEach(function(alert) {
                    setTimeout(function() {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }, 5000); // 5 detik
                });
            });
        })();

        // Preloader Logic
        window.addEventListener('load', function () {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                setTimeout(() => {
                    preloader.style.opacity = '0';
                    setTimeout(() => {
                        preloader.style.visibility = 'hidden';
                        preloader.style.display = 'none';
                    }, 400); // Tunggu efek fade out selesai
                }, 400); // Tahan preloader selama 0.8 detik
            }
        });
    </script>
</body>

</html>

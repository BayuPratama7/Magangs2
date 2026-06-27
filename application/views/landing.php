<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPMAGANG - Sistem Informasi Pengelolaan Magang</title>
    <meta name="description" content="SIPMAGANG - Platform terintegrasi untuk memudahkan mahasiswa dalam menjalani proses magang secara terstruktur, jelas, dan efisien.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: #1e293b;
            background: #ffffff;
            overflow-x: hidden;
        }

        /* ========================
           NAVBAR
        ======================== */
        .landing-navbar {
            background: linear-gradient(135deg, #005580 0%, #0073AC 60%, #0090D9 100%);
            padding: 0.9rem 3rem;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.12);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
        }

        .navbar-brand img {
            width: 34px;
            height: 34px;
            object-fit: contain;
        }

        .navbar-brand-text {
            display: flex;
            flex-direction: column;
        }

        .navbar-brand-text h4 {
            font-size: 1rem;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
            line-height: 1.2;
            letter-spacing: 0.5px;
        }

        .navbar-brand-text small {
            font-size: 0.6rem;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 400;
            letter-spacing: 0.2px;
        }

        /* ========================
           HERO SECTION
        ======================== */
        .hero-section {
            background: #F0F7FF;
            padding: 4rem 3rem 3rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 3rem;
            min-height: 480px;
            position: relative;
            overflow: hidden;
        }

        /* Decorative elements */
        .hero-section::before {
            content: '';
            position: absolute;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            background: rgba(0, 115, 172, 0.04);
            top: -120px;
            right: 30%;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(0, 115, 172, 0.03);
            bottom: -60px;
            left: 5%;
        }

        .hero-text {
            flex: 1;
            max-width: 520px;
            position: relative;
            z-index: 1;
        }

        .hero-text h1 {
            font-size: 2.4rem;
            font-weight: 800;
            color: #1e293b;
            line-height: 1.25;
            margin-bottom: 1rem;
        }

        .hero-text h1 span {
            color: #0073AC;
            display: block;
        }

        .hero-text p {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 2rem;
            max-width: 420px;
        }

        .btn-hero-login {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 2rem;
            background: linear-gradient(135deg, #005580 0%, #0073AC 50%, #0090D9 100%);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.3px;
        }

        .btn-hero-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.5s ease;
        }

        .btn-hero-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 115, 172, 0.35);
            color: #ffffff;
            text-decoration: none;
        }

        .btn-hero-login:hover::before {
            left: 100%;
        }

        .hero-image {
            flex: 1;
            max-width: 420px;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            mix-blend-mode: multiply;
        }

        .hero-image img {
            width: 100%;
            max-width: 380px;
            height: auto;
            animation: heroFloat 3s ease-in-out infinite;
        }

        @keyframes heroFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* ========================
           ALUR PROSES SECTION
        ======================== */
        .alur-section {
            padding: 4rem 3rem;
            background: #ffffff;
            text-align: center;
        }

        .section-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .section-subtitle {
            color: #94a3b8;
            font-size: 0.9rem;
            margin-bottom: 2.5rem;
        }

        /* Step numbers row */
        .steps-timeline {
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 850px;
            margin: 0 auto 2rem;
            position: relative;
        }

        .step-number {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #005580, #0073AC);
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            z-index: 2;
            box-shadow: 0 3px 10px rgba(0, 115, 172, 0.25);
        }

        .step-line {
            flex: 1;
            height: 3px;
            background: linear-gradient(90deg, #0073AC, #60b8e0);
            position: relative;
            z-index: 1;
        }

        /* Step cards */
        .steps-cards {
            display: flex;
            gap: 1.25rem;
            justify-content: center;
            max-width: 900px;
            margin: 0 auto;
            flex-wrap: wrap;
        }

        .step-card {
            background: #ffffff;
            border: 1px solid #e8eef4;
            border-radius: 14px;
            padding: 1.5rem 1.2rem 1.2rem;
            width: 160px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .step-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 115, 172, 0.12);
            border-color: #b3d8f0;
        }

        .step-card-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            background: #F0F7FF;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.8rem;
        }

        .step-card-icon i {
            font-size: 1.4rem;
            color: #0073AC;
        }

        .step-card h4 {
            font-size: 0.8rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .step-card p {
            font-size: 0.7rem;
            color: #94a3b8;
            line-height: 1.5;
            margin: 0;
        }

        /* ========================
           DAFTAR MITRA SECTION
        ======================== */
        .mitra-section {
            padding: 3.5rem 3rem;
            background: #f8fafc;
            text-align: center;
        }

        .mitra-grid {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
        }

        .mitra-item {
            background: #ffffff;
            border: 1px solid #e8eef4;
            border-radius: 12px;
            padding: 1.2rem 1.5rem;
            min-width: 130px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
        }

        .mitra-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        .mitra-item .mitra-logo {
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mitra-item .mitra-logo img {
            transition: transform 0.3s ease-in-out;
        }

        .mitra-item:hover .mitra-logo img {
            transform: scale(1.25);
        }

        .mitra-item .mitra-logo i {
            font-size: 2rem;
            color: #0073AC;
        }

        .mitra-item .mitra-name {
            font-size: 0.7rem;
            font-weight: 600;
            color: #64748b;
            text-align: center;
        }

        /* ========================
           FOOTER
        ======================== */
        .landing-footer {
            background: linear-gradient(135deg, #0a1628 0%, #1e293b 100%);
            color: #94a3b8;
            padding: 3rem 3rem 1.5rem;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            gap: 2rem;
            flex-wrap: wrap;
            max-width: 1100px;
            margin: 0 auto;
            padding-bottom: 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .footer-brand {
            max-width: 240px;
        }

        .footer-brand h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 0.5rem;
            letter-spacing: 0.5px;
        }

        .footer-brand p {
            font-size: 0.75rem;
            line-height: 1.6;
            color: #94a3b8;
            margin-bottom: 0;
        }

        .footer-university {
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            max-width: 240px;
        }

        .footer-university .uni-badge {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background: linear-gradient(135deg, #d4a017, #f0c040);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .footer-university .uni-badge i {
            font-size: 1.5rem;
            color: #1e293b;
        }

        .footer-university .uni-text {
            font-size: 0.7rem;
            color: #94a3b8;
            line-height: 1.5;
        }

        .footer-university .uni-text strong {
            color: #ffffff;
            display: block;
            font-size: 0.75rem;
            margin-bottom: 0.2rem;
        }

        .footer-contact h5,
        .footer-social h5 {
            font-size: 0.85rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 0.8rem;
        }

        .footer-contact .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.75rem;
            color: #94a3b8;
            line-height: 1.5;
        }

        .footer-contact .contact-item i {
            color: #60b8e0;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .footer-social-icons {
            display: flex;
            gap: 0.6rem;
        }

        .footer-social-icons a {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-social-icons a:hover {
            background: #0073AC;
            color: #ffffff;
            transform: translateY(-2px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 1.2rem;
            font-size: 0.7rem;
            color: #64748b;
            max-width: 1100px;
            margin: 0 auto;
        }

        /* ========================
           RESPONSIVE
        ======================== */
        @media (max-width: 992px) {
            .hero-section {
                flex-direction: column;
                padding: 3rem 2rem;
                text-align: center;
            }

            .hero-text {
                max-width: 100%;
            }

            .hero-text p {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-text h1 {
                font-size: 2rem;
            }

            .hero-image {
                max-width: 320px;
            }

            .btn-hero-login {
                margin: 0 auto;
            }

            .steps-cards {
                gap: 1rem;
            }

            .step-card {
                width: 140px;
            }

            .footer-content {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 768px) {
            .landing-navbar {
                padding: 0.8rem 1.5rem;
            }

            .hero-section {
                padding: 2.5rem 1.5rem;
            }

            .hero-text h1 {
                font-size: 1.6rem;
            }

            .alur-section,
            .mitra-section {
                padding: 2.5rem 1.5rem;
            }

            .steps-timeline {
                display: none;
            }

            .step-card {
                width: 130px;
                padding: 1.2rem 1rem 1rem;
            }

            .mitra-grid {
                gap: 1rem;
            }

            .mitra-item {
                min-width: 110px;
                padding: 1rem;
            }

            .landing-footer {
                padding: 2rem 1.5rem 1rem;
            }
        }

        @media (max-width: 576px) {
            .hero-text h1 {
                font-size: 1.4rem;
            }

            .section-title {
                font-size: 1.3rem;
            }

            .steps-cards {
                gap: 0.75rem;
            }

            .step-card {
                width: calc(50% - 0.75rem);
            }

            .mitra-item {
                min-width: calc(50% - 1rem);
            }
        }
    </style>
</head>

<body>

    <!-- ==================== NAVBAR ==================== -->
    <nav class="landing-navbar" id="navbar">
        <a class="navbar-brand" href="<?= base_url() ?>">
            <img src="<?= base_url('public/images/logo/sipmagang.png') ?>" alt="SIPMAGANG Logo">
            <div class="navbar-brand-text">
                <h4>SIPMAGANG</h4>
                <small>Sistem Informasi Pengelolaan Magang</small>
            </div>
        </a>
    </nav>

    <!-- ==================== HERO ==================== -->
    <section class="hero-section" id="hero">
        <div class="hero-text">
            <h1>Sistem Informasi
                <span>Pengelolaan Magang</span>
            </h1>
            <p>Platform terintegrasi untuk memudahkan mahasiswa dalam menjalani proses magang secara terstruktur,
                jelas, dan efisien.</p>
            <a href="<?= base_url('index.php/auth/auth/login') ?>" class="btn-hero-login" id="btnHeroLogin">
                Login
            </a>
        </div>
        <div class="hero-image">
            <img src="<?= base_url('public/images/landing_illustration.png') ?>" alt="Ilustrasi Magang">
        </div>
    </section>

    <!-- ==================== ALUR PROSES MAGANG ==================== -->
    <section class="alur-section" id="alurProses">
        <h2 class="section-title">Alur Proses Magang</h2>
        <p class="section-subtitle">Berikut adalah tahapan dalam proses magang di prodi Sistem Informasi</p>

        <!-- Timeline Numbers -->
        <div class="steps-timeline">
            <div class="step-number">1</div>
            <div class="step-line"></div>
            <div class="step-number">2</div>
            <div class="step-line"></div>
            <div class="step-number">3</div>
            <div class="step-line"></div>
            <div class="step-number">4</div>
            <div class="step-line"></div>
            <div class="step-number">5</div>
        </div>

        <!-- Step Cards -->
        <div class="steps-cards">
            <div class="step-card">
                <div class="step-card-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h4>Pengajuan Proposal</h4>
                <p>Mahasiswa mengajukan permohonan magang melalui pembuatan proposal.</p>
            </div>
            <div class="step-card">
                <div class="step-card-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h4>Pelaksanaan Magang</h4>
                <p>Mahasiswa melaksanakan kegiatan magang di instansi/mitra.</p>
            </div>
            <div class="step-card">
                <div class="step-card-icon">
                    <i class="bi bi-cloud-arrow-up"></i>
                </div>
                <h4>Upload Logbook</h4>
                <p>Mahasiswa mengunggah link logbook magang melalui sistem.</p>
            </div>
            <div class="step-card">
                <div class="step-card-icon">
                    <i class="bi bi-file-earmark-arrow-up"></i>
                </div>
                <h4>Upload Laporan</h4>
                <p>Mahasiswa mengunggah link laporan magang melalui sistem.</p>
            </div>
            <div class="step-card">
                <div class="step-card-icon">
                    <i class="bi bi-easel"></i>
                </div>
                <h4>Diseminasi &amp; Penilaian</h4>
                <p>Mahasiswa melakukan diseminasi dengan presentasi dan dosen memberikan penilaian.</p>
            </div>
        </div>
    </section>

    <!-- ==================== DAFTAR MITRA ==================== -->
    <section class="mitra-section" id="daftarMitra">
        <h2 class="section-title">Daftar Mitra</h2>
        <p class="section-subtitle">Daftar instansi/perusahaan yang telah bekerja sama dengan prodi Sistem Informasi</p>

        <div class="mitra-grid">
            <div class="mitra-item">
                <div class="mitra-logo">
                    <img src="<?= base_url('public/images/mitra/METRODATA.jpg') ?>" alt="PT. Metrodata Electronics" style="max-height: 45px; width: auto; object-fit: contain;">
                </div>
                <div class="mitra-name">PT. Metrodata Electronics</div>
            </div>
            <div class="mitra-item">
                <div class="mitra-logo">
                    <img src="<?= base_url('public/images/mitra/MAXY ACADEMY.jpg') ?>" alt="Maxy Academy" style="max-height: 45px; width: auto; object-fit: contain;">
                </div>
                <div class="mitra-name">Maxy Academy</div>
            </div>
            <div class="mitra-item">
                <div class="mitra-logo">
                    <img src="<?= base_url('public/images/mitra/TAM.jpg') ?>" alt="PT. TAM GROUP" style="max-height: 45px; width: auto; object-fit: contain;">
                </div>
                <div class="mitra-name">PT.TAM GROUP</div>
            </div>
            <div class="mitra-item">
                <div class="mitra-logo">
                    <img src="<?= base_url('public/images/mitra/SEVEN INC.png') ?>" alt="CV Sanjaya 57" style="max-height: 45px; width: auto; object-fit: contain;">
                </div>
                <div class="mitra-name">CV Sanjaya 57</div>
            </div>
            <div class="mitra-item">
                <div class="mitra-logo">
                    <img src="<?= base_url('public/images/mitra/KHRAFTAUS.jpg') ?>" alt="PT. Krafthaus Indonesia" style="max-height: 45px; width: auto; object-fit: contain;">
                </div>
                <div class="mitra-name">PT. Krafthaus Indonesia</div>
            </div>
            <div class="mitra-item">
                <div class="mitra-logo">
                    <img src="<?= base_url('public/images/mitra/KPU.png') ?>" alt="KPU Kabupaten Bantul" style="max-height: 45px; width: auto; object-fit: contain;">
                </div>
                <div class="mitra-name">KPU Kabupaten Bantul</div>
            </div>
        </div>
    </section>

    <!-- ==================== FOOTER ==================== -->
    <footer class="landing-footer" id="footer">
        <div class="footer-content">
            <!-- Brand -->
            <div class="footer-brand">
                <h3>SIPMAGANG</h3>
                <p>Sistem Informasi Pengelolaan Magang untuk manajemen program magang mahasiswa yang modern dan sistematis.</p>
            </div>

            <!-- University -->
            <div class="footer-university" style="flex-direction: column; align-items: center; text-align: center; gap: 0.8rem;">
                <img src="<?= base_url('public/images/logo/akreditasi_unggul.png') ?>" alt="Akreditasi Unggul" style="width: 120px; height: auto;">
                <div class="uni-text">
                    <strong>Universitas Alma Ata</strong>
                    Telah Terakreditasi UNGGUL<br>Oleh Badan Akreditasi Nasional<br>Perguruan Tinggi.
                </div>
            </div>

            <!-- Contact -->
            <div class="footer-contact">
                <h5>Kontak</h5>
                <div class="contact-item">
                    <i class="bi bi-telephone"></i>
                    <span>(0274) 434 2288</span>
                </div>
                <div class="contact-item">
                    <i class="bi bi-envelope"></i>
                    <span>si@almaata.ac.id</span>
                </div>
                <div class="contact-item">
                    <i class="bi bi-geo-alt"></i>
                    <span>Jl. Brawijaya No.99, Jadan, Tamantirto, Kec. Kasihan, Kabupaten Bantul, DIY 55183</span>
                </div>
            </div>

            <!-- Social Media -->
            <div class="footer-social">
                <h5>Ikuti Kami</h5>
                <div class="footer-social-icons">
                    <a href="#" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            &copy; <?= format_indo('Y') ?> SIPMAGANG. All rights reserved.
        </div>
    </footer>

</body>

</html>


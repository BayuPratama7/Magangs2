<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPMAGANG</title>
    <meta name="description" content="Login ke SIPMAGANG - Sistem Informasi Pengelolaan Magang Prodi Sistem Informasi">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f0f4f8;
            overflow-x: hidden;
        }

        /* ========================
           MAIN CONTAINER
        ======================== */
        .login-wrapper {
            display: flex;
            flex: 1;
            min-height: calc(100vh - 56px);
        }

        /* ========================
           LEFT PANEL - Hero
        ======================== */
        .login-hero {
            flex: 1;
            background: #F0F7FF;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2.5rem 3.5rem;
            position: relative;
            overflow: hidden;
            min-height: 100%;
        }

        /* Decorative circles */
        .login-hero::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(0, 115, 172, 0.04);
            top: -100px;
            right: -100px;
        }

        .login-hero::after {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: rgba(0, 115, 172, 0.03);
            bottom: 50px;
            left: -80px;
        }

        .hero-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .hero-logo img {
            width: 36px;
            height: 36px;
            object-fit: contain;
            /* keep original logo colors */
        }

        .hero-logo-text {
            display: flex;
            flex-direction: column;
        }

        .hero-logo-text h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0073AC;
            margin: 0;
            line-height: 1.2;
            letter-spacing: 0.5px;
        }

        .hero-logo-text small {
            font-size: 0.65rem;
            color: #64748b;
            font-weight: 400;
            letter-spacing: 0.3px;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 2.2rem;
            font-weight: 300;
            color: #1e293b;
            line-height: 1.3;
            margin-bottom: 0.3rem;
        }

        .hero-content h1 strong {
            font-weight: 800;
            display: block;
            font-size: 2.6rem;
            letter-spacing: -0.5px;
        }

        .hero-content p {
            color: #64748b;
            font-size: 0.9rem;
            line-height: 1.7;
            max-width: 400px;
            margin-top: 1rem;
        }

        .hero-illustration {
            position: relative;
            z-index: 1;
            margin-top: 2rem;
            text-align: center;
            mix-blend-mode: multiply;
        }

        .hero-illustration img {
            max-width: 340px;
            width: 100%;
            height: auto;
            animation: floatUp 3s ease-in-out infinite;
        }

        @keyframes floatUp {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-8px);
            }
        }

        /* ========================
           RIGHT PANEL - Form
        ======================== */
        .login-form-panel {
            width: 480px;
            min-width: 420px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: #f0f4f8;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            border-radius: 16px;
            padding: 2.5rem 2rem;
            box-shadow:
                0 4px 24px rgba(0, 0, 0, 0.06),
                0 1px 4px rgba(0, 0, 0, 0.04);
        }

        .login-card-logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .login-card-logo img {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }

        .login-card-logo span {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0073AC;
            letter-spacing: 0.5px;
        }

        .login-card h2 {
            text-align: center;
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.3rem;
        }

        .login-card .subtitle {
            text-align: center;
            font-size: 0.8rem;
            color: #94a3b8;
            margin-bottom: 1.75rem;
        }

        /* Alert for errors */
        .login-alert {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-left: 4px solid #ef4444;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            animation: shakeX 0.5s ease-in-out;
        }

        .login-alert i {
            color: #ef4444;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .login-alert span {
            font-size: 0.8rem;
            color: #991b1b;
            line-height: 1.4;
        }

        @keyframes shakeX {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-6px); }
            40% { transform: translateX(6px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
        }

        /* Form fields */
        .form-group {
            margin-bottom: 1rem;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper .input-icon {
            position: absolute;
            left: 14px;
            color: #94a3b8;
            font-size: 1rem;
            pointer-events: none;
            transition: color 0.3s ease;
        }

        .input-wrapper input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.875rem;
            font-family: 'Inter', sans-serif;
            color: #1e293b;
            background: #ffffff;
            transition: all 0.3s ease;
            outline: none;
        }

        .input-wrapper input::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .input-wrapper input:focus {
            border-color: #0073AC;
            box-shadow: 0 0 0 3px rgba(0, 115, 172, 0.1);
        }

        .input-wrapper input:focus~.input-icon {
            color: #0073AC;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            font-size: 1.1rem;
            padding: 4px;
            transition: color 0.3s ease;
            line-height: 1;
        }

        .toggle-password:hover {
            color: #0073AC;
        }

        /* Login button */
        .btn-login {
            display: block;
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #005580 0%, #0073AC 50%, #0090D9 100%);
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.3px;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 115, 172, 0.35);
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(0, 115, 172, 0.3);
        }

        /* Back link */
        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .back-link a {
            color: #64748b;
            font-size: 0.85rem;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .back-link a:hover {
            color: #0073AC;
        }

        /* ========================
           FOOTER
        ======================== */
        .login-footer {
            background: #1e293b;
            text-align: center;
            padding: 1rem 2rem;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
            letter-spacing: 0.3px;
            flex-shrink: 0;
        }

        /* ========================
           RESPONSIVE
        ======================== */
        @media (max-width: 992px) {
            .login-wrapper {
                flex-direction: column;
                min-height: auto;
            }

            .login-hero {
                padding: 2.5rem 2rem;
                min-height: auto;
            }

            .hero-content h1 {
                font-size: 1.6rem;
            }

            .hero-content h1 strong {
                font-size: 2rem;
            }

            .hero-illustration img {
                max-width: 280px;
            }

            .login-form-panel {
                width: 100%;
                min-width: unset;
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .login-hero {
                padding: 2rem 1.5rem;
            }

            .hero-content h1 {
                font-size: 1.3rem;
            }

            .hero-content h1 strong {
                font-size: 1.6rem;
            }

            .hero-content p {
                font-size: 0.8rem;
            }

            .hero-illustration img {
                max-width: 220px;
            }

            .login-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>

<body>

    <!-- Main Login Layout -->
    <div class="login-wrapper">

        <!-- LEFT: Hero Panel -->
        <div class="login-hero">
            <div class="hero-logo">
                <img src="<?= base_url('public/images/logo/sipmagang.png') ?>" alt="SIPMAGANG Logo">
                <div class="hero-logo-text">
                    <h3>SIPMAGANG</h3>
                    <small>Sistem Informasi Pengelolaan Magang</small>
                </div>
            </div>

            <div class="hero-content">
                <h1>Selamat Datang di
                    <strong>SIPMAGANG</strong>
                </h1>
                <p>Platform terintegrasi untuk memudahkan mahasiswa dalam menjalani proses magang secara terstruktur,
                    jelas, dan efisien.</p>
            </div>

            <div class="hero-illustration">
                <img src="<?= base_url('public/images/login_illustration.png') ?>" alt="Ilustrasi Tim Bekerja">
            </div>
        </div>

        <!-- RIGHT: Login Form Panel -->
        <div class="login-form-panel">
            <div class="login-card">
                <div class="login-card-logo">
                    <img src="<?= base_url('public/images/logo/sipmagang.png') ?>" alt="Logo">
                    <span>SIPMAGANG</span>
                </div>

                <h2>Login ke SIPMAGANG</h2>
                <p class="subtitle">Silakan masuk untuk mengakses sistem</p>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="login-alert">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span><?= $this->session->flashdata('error') ?></span>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('index.php/auth/auth/process') ?>" id="loginForm">

                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="text" name="email" id="inputEmail" placeholder="Email Alma Ata atau NIM"
                                required autocomplete="email">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" name="password" id="inputPassword" placeholder="Password" required
                                autocomplete="current-password">
                            <button type="button" class="toggle-password" id="togglePassword" aria-label="Tampilkan password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-login" id="btnLogin">Login</button>

                </form>

                <div class="back-link">
                    <a href="<?= base_url('index.php/welcome') ?>"><i class="bi bi-arrow-left"></i> Kembali</a>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="login-footer">
        &copy; <?= format_indo('Y') ?> SIPMAGANG - Sistem Informasi Pengelolaan Magang
    </footer>

    <script>
        // Toggle password visibility
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('inputPassword');

        toggleBtn.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    </script>

</body>

</html>


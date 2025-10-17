<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<style>
    /* ===================== MODERN REGISTER THEME ===================== */
    .content {
        --bg: #f8fafc;
        --card: #ffffff;
        --text: #1e293b;
        --muted: #64748b;
        --border: #e2e8f0;
        --border-hover: #cbd5e1;
        --ring: #3b82f6;
        --primary: #3b82f6;
        --primary-hover: #2563eb;
        --primary-light: #dbeafe;
        --success: #22c55e;
        --success-hover: #16a34a;
        --success-light: #dcfce7;
        --danger: #ef4444;
        --danger-hover: #dc2626;
        --danger-light: #fee2e2;
        --info: #06b6d4;
        --info-hover: #0891b2;
        --info-light: #cffafe;
        --radius: 12px;
        --radius-lg: 16px;
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-xl: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        position: relative;
        padding: 24px 0 40px !important;
        color: var(--text);
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        width: 100%;
        display: block;
        visibility: visible;
    }

    html[data-theme="dark"] .content {
        --bg: #0f172a;
        --card: #1e293b;
        --text: #f1f5f9;
        --muted: #94a3b8;
        --border: #334155;
        --border-hover: #475569;
        --ring: #60a5fa;
        --primary: #60a5fa;
        --primary-hover: #3b82f6;
        --primary-light: #1e3a8a;
        --success: #34d399;
        --success-hover: #10b981;
        --success-light: #064e3b;
        --danger: #f87171;
        --danger-hover: #ef4444;
        --danger-light: #7f1d1d;
        --info: #22d3ee;
        --info-hover: #06b6d4;
        --info-light: #164e63;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    }

    .content .page-wrap {
        max-width: 600px;
        margin: 0 auto;
        padding: 0 24px;
        width: 100%;
        display: block;
        visibility: visible;
    }

    .content .toolbar {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 32px;
        padding: 24px 0;
    }

    .content .toolbar h3 {
        margin: 0;
        font-weight: 700;
        font-size: 1.875rem;
        letter-spacing: -0.025em;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 12px;
        text-align: center;
    }

    .content .toolbar h3::before {
        content: "👤";
        font-size: 1.5rem;
        color: var(--primary);
    }

    .content .toolbar p {
        margin: 4px 0 0 0;
        color: var(--muted);
        font-size: 0.9rem;
        text-align: center;
    }

    .content .form-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        transition: all 0.2s ease;
        padding: 32px;
        margin: 0 auto;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .content .form-card:hover {
        box-shadow: var(--shadow-xl);
    }

    .content .form-group {
        margin-bottom: 32px;
        padding-top: 8px;
    }

    .content .form-group:first-child {
        padding-top: 16px;
    }

    .content .form-group label {
        display: block;
        margin-bottom: 12px;
        font-weight: 600;
        color: var(--text);
        font-size: 0.9rem;
    }

    .content .form-control {
        width: 100%;
        padding: 14px 18px;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        background: var(--card);
        color: var(--text);
        font-size: 0.9rem;
        transition: all 0.2s ease;
        box-sizing: border-box;
        min-height: 48px;
        display: block;
        margin: 0;
    }

    .content .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .content .form-control:hover {
        border-color: var(--border-hover);
    }

    .content .form-control::placeholder {
        color: var(--muted);
    }

    .content .form-control.is-invalid {
        border-color: var(--danger);
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .content .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 10px;
        font-size: 0.8rem;
        color: var(--danger);
        font-weight: 500;
        padding: 8px 12px;
        background: rgba(239, 68, 68, 0.1);
        border-radius: 6px;
        border-left: 3px solid var(--danger);
    }

    .content .btn {
        border-radius: var(--radius);
        line-height: 1.5;
        padding: 10px 20px;
        font-weight: 600;
        font-size: 0.85rem;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .content .btn:focus-visible {
        outline: 2px solid var(--ring);
        outline-offset: 2px;
    }

    .content .btn:active {
        transform: translateY(1px);
    }

    .content .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        border: none;
        box-shadow: 0 4px 14px 0 rgba(16, 185, 129, 0.3);
    }

    .content .btn-success:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        box-shadow: 0 6px 20px 0 rgba(16, 185, 129, 0.4);
        transform: translateY(-2px);
        color: #ffffff;
    }

    .content .alert {
        border-radius: var(--radius);
        border: none;
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: var(--shadow);
    }

    .content .alert-success {
        background: var(--success-light);
        color: var(--success-hover);
        border-left: 4px solid var(--success);
    }

    .content .alert-danger {
        background: var(--danger-light);
        color: var(--danger-hover);
        border-left: 4px solid var(--danger);
    }

    .content .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        flex-wrap: wrap;
        justify-content: center;
        width: 100%;
        box-sizing: border-box;
    }

    .content .btn-secondary {
        background: var(--card);
        color: var(--text);
        border-color: var(--border);
        box-shadow: var(--shadow);
    }

    .content .btn-secondary:hover {
        background: var(--primary-light);
        border-color: var(--primary);
        color: var(--primary);
    }

    /* ===================== MODERN RESPONSIVE DESIGN ===================== */

    /* Desktop & Tablet Landscape */
    @media (min-width: 1025px) {
        .content .page-wrap {
            max-width: 600px;
            padding: 0 24px;
        }

        .content .toolbar {
            margin-bottom: 40px;
            padding: 32px 0;
        }

        .content .toolbar h3 {
            font-size: 2rem;
            margin-bottom: 8px;
        }

        .content .form-card {
            padding: 40px;
            margin: 0;
            width: 100%;
        }

        .content .form-group {
            margin-bottom: 32px;
            padding-top: 8px;
        }

        .content .form-group:first-child {
            padding-top: 16px;
        }

        .content .btn-group {
            gap: 16px;
            margin-top: 40px;
        }

        .content .btn {
            padding: 12px 24px;
            font-size: 0.9rem;
            min-width: 140px;
        }
    }

    /* Tablet Portrait */
    @media (max-width: 1024px) and (min-width: 769px) {
        .content .page-wrap {
            max-width: 100%;
            padding: 0 20px;
        }

        .content .toolbar {
            margin-bottom: 36px;
            padding: 28px 0;
        }

        .content .toolbar h3 {
            font-size: 1.75rem;
            margin-bottom: 8px;
        }

        .content .form-card {
            padding: 32px;
            margin: 0;
            width: 100%;
        }

        .content .form-group {
            margin-bottom: 28px;
            padding-top: 6px;
        }

        .content .form-group:first-child {
            padding-top: 12px;
        }

        .content .btn-group {
            gap: 16px;
            width: 100%;
            justify-content: center;
            margin-top: 36px;
        }

        .content .btn {
            padding: 12px 24px;
            font-size: 0.9rem;
            min-width: 140px;
        }
    }

    /* Mobile Landscape & Small Tablet */
    @media (max-width: 768px) and (min-width: 577px) {
        .content .page-wrap {
            padding: 0 16px;
        }

        .content .toolbar {
            margin-bottom: 32px;
            padding: 24px 0;
        }

        .content .toolbar h3 {
            font-size: 1.5rem;
            margin-bottom: 6px;
        }

        .content .toolbar p {
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .content .form-card {
            padding: 24px;
            margin: 0;
            width: 100%;
        }

        .content .form-group {
            margin-bottom: 24px;
            padding-top: 6px;
        }

        .content .form-group:first-child {
            padding-top: 10px;
        }

        .content .btn-group {
            flex-direction: row;
            gap: 12px;
            width: 100%;
            justify-content: center;
            margin-top: 32px;
        }

        .content .btn {
            padding: 10px 20px;
            font-size: 0.8rem;
            min-width: 120px;
        }
    }

    /* Mobile Portrait */
    @media (max-width: 576px) {
        .content {
            padding: 16px 0 24px !important;
        }

        .content .page-wrap {
            padding: 0 12px;
        }

        .content .toolbar {
            margin-bottom: 24px;
            padding: 20px 0;
        }

        .content .toolbar h3 {
            font-size: 1.4rem;
            margin-bottom: 4px;
        }

        .content .toolbar p {
            font-size: 0.85rem;
            margin-bottom: 16px;
        }

        .content .form-card {
            padding: 20px;
            margin: 0;
            width: 100%;
        }

        .content .form-group {
            margin-bottom: 20px;
            padding-top: 4px;
        }

        .content .form-group:first-child {
            padding-top: 8px;
        }

        .content .form-group label {
            margin-bottom: 8px;
            font-size: 0.85rem;
        }

        .content .form-control {
            padding: 12px 16px;
            font-size: 0.85rem;
            min-height: 44px;
        }

        .content .btn-group {
            flex-direction: column;
            gap: 12px;
            width: 100%;
            margin-top: 28px;
        }

        .content .btn {
            width: 100%;
            padding: 12px 20px;
            font-size: 0.8rem;
            justify-content: center;
        }

        .content .invalid-feedback {
            font-size: 0.75rem;
            padding: 6px 10px;
        }
    }

    /* Small Mobile */
    @media (max-width: 480px) {
        .content .page-wrap {
            padding: 0 8px;
        }

        .content .toolbar {
            margin-bottom: 20px;
            padding: 16px 0;
        }

        .content .toolbar h3 {
            font-size: 1.25rem;
            margin-bottom: 4px;
        }

        .content .toolbar p {
            font-size: 0.8rem;
            margin-bottom: 14px;
        }

        .content .form-card {
            padding: 16px;
            margin: 0;
            width: 100%;
        }

        .content .form-group {
            margin-bottom: 18px;
            padding-top: 4px;
        }

        .content .form-group:first-child {
            padding-top: 6px;
        }

        .content .form-group label {
            margin-bottom: 6px;
            font-size: 0.8rem;
        }

        .content .form-control {
            padding: 10px 14px;
            font-size: 0.8rem;
            min-height: 40px;
        }

        .content .btn-group {
            width: 100%;
            gap: 10px;
            margin-top: 24px;
        }

        .content .btn {
            padding: 10px 16px;
            font-size: 0.75rem;
        }

        .content .invalid-feedback {
            font-size: 0.7rem;
            padding: 4px 8px;
        }
    }
</style>

<div class="content">
    <div class="page-wrap">
        <div class="toolbar">
            <div>
                <h3>Daftar Petugas Baru</h3>
                <p>Buat akun petugas untuk sistem absensi</p>
            </div>
        </div>

        <div class="form-card">
            <?= view('Myth\Auth\Views\_message_block') ?>

            <form action="<?= url_to('register') ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="email">📧 Email</label>
                    <input type="email" id="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="Masukkan email petugas" value="<?= old('email') ?>">
                    <?php if (session('errors.email')) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors.email') ?>
                        </div>
                    <?php endif ?>
                </div>

                <div class="form-group">
                    <label for="username">👤 Username</label>
                    <input type="text" id="username" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="Masukkan username" value="<?= old('username') ?>">
                    <?php if (session('errors.username')) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors.username') ?>
                        </div>
                    <?php endif ?>
                </div>

                <div class="form-group">
                    <label for="password">🔒 Password</label>
                    <input type="password" id="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" autocomplete="off" placeholder="Masukkan password">
                    <?php if (session('errors.password')) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors.password') ?>
                        </div>
                    <?php endif ?>
                </div>

                <div class="form-group">
                    <label for="pass_confirm">🔐 Konfirmasi Password</label>
                    <input type="password" id="pass_confirm" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" autocomplete="off" placeholder="Ulangi password">
                    <?php if (session('errors.pass_confirm')) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors.pass_confirm') ?>
                        </div>
                    <?php endif ?>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-success">
                        <span>💾</span>
                        Simpan
                    </button>
                    <a href="<?= base_url('admin/petugas'); ?>" class="btn btn-secondary">
                        <span>↩️</span>
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const emailInput = document.getElementById('email');
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');
        const passConfirmInput = document.getElementById('pass_confirm');

        // Real-time validation functions
        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function validateUsername(username) {
            const usernameRegex = /^[a-zA-Z0-9_]{3,20}$/;
            return usernameRegex.test(username);
        }

        function validatePassword(password) {
            return password.length >= 6;
        }

        function validatePasswordMatch(password, confirmPassword) {
            return password === confirmPassword;
        }

        // Show error message
        function showError(input, message) {
            input.classList.add('is-invalid');
            let errorDiv = input.parentNode.querySelector('.invalid-feedback');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                input.parentNode.appendChild(errorDiv);
            }
            errorDiv.textContent = message;
        }

        // Clear error message
        function clearError(input) {
            input.classList.remove('is-invalid');
            const errorDiv = input.parentNode.querySelector('.invalid-feedback');
            if (errorDiv) {
                errorDiv.remove();
            }
        }

        // Email validation
        emailInput.addEventListener('blur', function() {
            const email = this.value.trim();
            if (email === '') {
                showError(this, 'Email tidak boleh kosong');
            } else if (!validateEmail(email)) {
                showError(this, 'Format email tidak valid');
            } else {
                clearError(this);
            }
        });

        // Username validation
        usernameInput.addEventListener('blur', function() {
            const username = this.value.trim();
            if (username === '') {
                showError(this, 'Username tidak boleh kosong');
            } else if (!validateUsername(username)) {
                showError(this, 'Username harus 3-20 karakter, hanya huruf, angka, dan underscore');
            } else {
                clearError(this);
            }
        });

        // Password validation
        passwordInput.addEventListener('blur', function() {
            const password = this.value;
            if (password === '') {
                showError(this, 'Password tidak boleh kosong');
            } else if (!validatePassword(password)) {
                showError(this, 'Password minimal 6 karakter');
            } else {
                clearError(this);
            }
        });

        // Password confirmation validation
        passConfirmInput.addEventListener('blur', function() {
            const password = passwordInput.value;
            const confirmPassword = this.value;
            if (confirmPassword === '') {
                showError(this, 'Konfirmasi password tidak boleh kosong');
            } else if (!validatePasswordMatch(password, confirmPassword)) {
                showError(this, 'Password tidak cocok');
            } else {
                clearError(this);
            }
        });

        // Real-time password match validation
        passwordInput.addEventListener('input', function() {
            if (passConfirmInput.value !== '') {
                if (validatePasswordMatch(this.value, passConfirmInput.value)) {
                    clearError(passConfirmInput);
                } else {
                    showError(passConfirmInput, 'Password tidak cocok');
                }
            }
        });

        // Form submission validation
        form.addEventListener('submit', function(e) {
            let isValid = true;

            // Validate all fields
            const email = emailInput.value.trim();
            const username = usernameInput.value.trim();
            const password = passwordInput.value;
            const confirmPassword = passConfirmInput.value;

            // Email validation
            if (email === '') {
                showError(emailInput, 'Email tidak boleh kosong');
                isValid = false;
            } else if (!validateEmail(email)) {
                showError(emailInput, 'Format email tidak valid');
                isValid = false;
            }

            // Username validation
            if (username === '') {
                showError(usernameInput, 'Username tidak boleh kosong');
                isValid = false;
            } else if (!validateUsername(username)) {
                showError(usernameInput, 'Username harus 3-20 karakter, hanya huruf, angka, dan underscore');
                isValid = false;
            }

            // Password validation
            if (password === '') {
                showError(passwordInput, 'Password tidak boleh kosong');
                isValid = false;
            } else if (!validatePassword(password)) {
                showError(passwordInput, 'Password minimal 6 karakter');
                isValid = false;
            }

            // Password confirmation validation
            if (confirmPassword === '') {
                showError(passConfirmInput, 'Konfirmasi password tidak boleh kosong');
                isValid = false;
            } else if (!validatePasswordMatch(password, confirmPassword)) {
                showError(passConfirmInput, 'Password tidak cocok');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                const firstError = form.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstError.focus();
                }
            }
        });

        // Clear errors on input
        [emailInput, usernameInput, passwordInput, passConfirmInput].forEach(input => {
            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    clearError(this);
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>
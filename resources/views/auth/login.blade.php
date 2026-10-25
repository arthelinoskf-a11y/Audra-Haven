<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Audra Haven</title>

    <script src="{{ asset('js/audra.js') }}"></script>

    <style>
        /* ============ RESET ============ */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: #faf6ef;
            transition: background 0.3s;
        }

        [data-theme="dark"] body {
            background: #3a2e22;
        }

        /* ============ CARD ============ */
        .login-card {
            background: #fffdf8;
            padding: 44px 40px;
            border-radius: 14px;
            width: 100%;
            max-width: 440px;
            border: 1px solid #e8dfd0;
            box-shadow: 0 10px 40px rgba(61, 47, 31, 0.10);
            transition: background 0.3s, border-color 0.3s, box-shadow 0.3s;
        }

        [data-theme="dark"] .login-card {
            background: #4a3b28;
            border-color: #6b5738;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        }

        /* ============ LOGO ============ */
        .login-logo {
            display: block;
            margin: 0 auto 24px;
            width: 100%;
            max-width: 240px;
            height: auto;
            object-fit: contain;
            /* Tambahan untuk paksa center */
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

        /* ============ TITLE ============ */
        .login-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 4px;
            color: #3d2f1f;
            margin: 0 0 8px 0;
        }

        [data-theme="dark"] .login-title {
            color: #faf0d8;
        }

        .login-subtitle {
            text-align: center;
            font-size: 12px;
            font-style: italic;
            letter-spacing: 1px;
            color: #8b7355;
            margin-bottom: 32px;
        }

        [data-theme="dark"] .login-subtitle {
            color: #d8c4a0;
        }

        /* ============ DIVIDER ============ */
        .login-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #d4c4a8, transparent);
            margin: 0 0 28px;
        }

        [data-theme="dark"] .login-divider {
            background: linear-gradient(to right, transparent, #6b5738, transparent);
        }

        /* ============ FORM ============ */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            color: #3d2f1f;
        }

        [data-theme="dark"] .form-group label {
            color: #faf0d8;
        }

        .form-group input {
            width: 100%;
            padding: 13px 16px;
            font-size: 14px;
            font-family: inherit;
            color: #3d2f1f;
            background: #fffdf8;
            border: 1.5px solid #e8dfd0;
            border-radius: 8px;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.3s;
        }

        [data-theme="dark"] .form-group input {
            color: #faf0d8;
            background: #3a2e22;
            border-color: #6b5738;
        }

        .form-group input:focus {
            outline: none;
            border-color: #b8935a;
            box-shadow: 0 0 0 4px rgba(184, 147, 90, 0.15);
        }

        [data-theme="dark"] .form-group input:focus {
            border-color: #e8c890;
            box-shadow: 0 0 0 4px rgba(232, 200, 144, 0.15);
        }

        /* ============ BUTTON ============ */
        .login-btn {
            width: 100%;
            padding: 15px;
            font-size: 15px;
            font-weight: bold;
            font-family: inherit;
            letter-spacing: 3px;
            color: #2d2317;
            background: linear-gradient(135deg, #d4b483 0%, #b8935a 100%);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 12px;
            transition: all 0.25s;
            box-shadow: 0 4px 12px rgba(184, 147, 90, 0.25);
        }

        .login-btn:hover {
            background: linear-gradient(135deg, #c4a06a 0%, #9a7a44 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(184, 147, 90, 0.35);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        /* ============ FORM OPTIONS (Remember + Forgot) ============ */
.form-options {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    font-size: 13px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    color: #3d2f1f;
    font-weight: normal;
    user-select: none;
}

[data-theme="dark"] .checkbox-label {
    color: #faf0d8;
}

.checkbox-label input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: #b8935a;
    cursor: pointer;
    padding: 0;
    border: 1.5px solid #e8dfd0;
    border-radius: 3px;
}

[data-theme="dark"] .checkbox-label input[type="checkbox"] {
    accent-color: #e8c890;
}

.forgot-link {
    color: #b8935a;
    text-decoration: none;
    font-size: 12px;
    transition: color 0.2s;
}

.forgot-link:hover {
    color: #9a7a44;
    text-decoration: underline;
}

[data-theme="dark"] .forgot-link {
    color: #e8c890;
}

[data-theme="dark"] .forgot-link:hover {
    color: #f5dfb0;
}

/* ============ INFO: BELUM PUNYA AKUN ============ */
.register-info {
    text-align: center;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid #e8dfd0;
    font-size: 12px;
    color: #8b7355;
}

[data-theme="dark"] .register-info {
    border-top-color: #6b5738;
    color: #d8c4a0;
}

.register-info p {
    margin: 0;
    line-height: 1.6;
}

.register-info a {
    color: #b8935a;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
}

.register-info a:hover {
    color: #9a7a44;
    text-decoration: underline;
}

[data-theme="dark"] .register-info a {
    color: #e8c890;
}

[data-theme="dark"] .register-info a:hover {
    color: #f5dfb0;
}

        /* ============ ALERT ============ */
        .alert {
            padding: 13px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            line-height: 1.4;
        }

        .alert-error {
            background: #f5e3e2;
            border: 1.5px solid #b85450;
            color: #9d4541;
        }

        .alert-success {
            background: #e8f0e5;
            border: 1.5px solid #7a9471;
            color: #5a7351;
        }

        [data-theme="dark"] .alert-error {
            background: rgba(240, 168, 160, 0.15);
            border-color: #f0a8a0;
            color: #f0a8a0;
        }

        [data-theme="dark"] .alert-success {
            background: rgba(184, 212, 168, 0.15);
            border-color: #b8d4a8;
            color: #b8d4a8;
        }

        /* ============ FOOTER ============ */
        .login-footer {
            text-align: center;
            font-size: 11px;
            color: #b8a284;
            margin-top: 28px;
            letter-spacing: 0.5px;
        }

        [data-theme="dark"] .login-footer {
            color: #a89370;
        }

        /* ============ TOGGLE ============ */
        .theme-toggle-wrapper {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 100;
        }

        .theme-toggle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #fffdf8;
            border: 1px solid #e8dfd0;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            transition: all 0.25s;
            box-shadow: 0 2px 8px rgba(61, 47, 31, 0.08);
        }

        [data-theme="dark"] .theme-toggle {
            background: #4a3b28;
            border-color: #6b5738;
        }

        .theme-toggle:hover {
            background: #b8935a;
            color: #fff;
            transform: rotate(20deg);
            box-shadow: 0 4px 12px rgba(184, 147, 90, 0.35);
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 480px) {
            .login-card {
                padding: 32px 24px;
            }
            .login-logo {
                max-width: 200px;
            }
            .login-title {
                font-size: 20px;
                letter-spacing: 2px;
            }
        }
    </style>
</head>
<body>

    {{-- Toggle Tema --}}
    <div class="theme-toggle-wrapper">
        <button id="themeToggle" class="theme-toggle" title="Ganti Tema">🌙</button>
    </div>

    <div class="login-card">

        {{-- Logo --}}
        <img src="{{ asset('images/logo.png') }}" alt="Audra Haven" class="login-logo">

        {{-- Judul --}}
       
        <div class="login-divider"></div>

        {{-- Alert --}}
        @if ($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                value="{{ old('email') }}"
                placeholder="nama@email.com"
                required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password"
                placeholder="••••••••"
                required>
        </div>

        {{-- Remember Me + Lupa Password --}}
        <div class="form-options">
            <label class="checkbox-label">
                <input type="checkbox" name="remember" value="1"
                    {{ old('remember') ? 'checked' : '' }}>
                <span>Ingat saya</span>
            </label>
            <a href="#" onclick="alert('Silakan hubungi resepsionis untuk reset password.'); return false;"
            class="forgot-link">Lupa password?</a>
        </div>

        <button type="submit" class="login-btn">MASUK</button>
    </form>

{{-- Info: Belum punya akun --}}
<div class="register-info">
    <p>
        Belum punya akun?
        <a href="{{ route('register') }}">
            Daftar di sini
        </a>
    </p>
</div>

        <p class="login-footer">
            &copy; {{ date('Y') }} Audra Haven Suites &amp; Residences
        </p>
    </div>

</body>
</html>
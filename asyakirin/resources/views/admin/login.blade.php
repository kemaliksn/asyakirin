<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - ZIS Asy-Syaakiriin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green-dark:  #0f4c28;
            --green-main:  #1a6b3c;
            --green-mid:   #22813f;
            --green-light: #2ea84f;
            --green-pale:  #e8f5ee;
            --gold:        #d4a017;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0f1f15;
            overflow: hidden;
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            width: 52%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(145deg, #0a2e18 0%, #1a6b3c 50%, #145c33 100%);
            overflow: hidden;
        }

        /* Decorative circles */
        .left-panel::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,.06);
            top: -150px; left: -150px;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,.06);
            bottom: -100px; right: -100px;
        }

        .circle-deco {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,.08);
        }
        .c1 { width: 300px; height: 300px; top: 10%; right: 5%; }
        .c2 { width: 200px; height: 200px; bottom: 15%; left: 10%; }
        .c3 { width: 150px; height: 150px; top: 40%; left: 30%; background: rgba(255,255,255,.02); }

        /* Dot grid pattern */
        .dot-grid {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,.08) 1px, transparent 1px);
            background-size: 32px 32px;
            opacity: .5;
        }

        .left-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 40px;
            max-width: 440px;
        }

        .brand-logo {
            width: 80px; height: 80px;
            background: rgba(255,255,255,.12);
            border: 2px solid rgba(255,255,255,.2);
            border-radius: 22px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 28px;
            backdrop-filter: blur(10px);
        }
        .brand-logo svg { width: 40px; height: 40px; color: #fff; }

        .brand-name {
            font-size: 32px; font-weight: 800;
            color: #fff; line-height: 1.1;
            margin-bottom: 8px;
            letter-spacing: -.5px;
        }
        .brand-sub {
            font-size: 14px; color: rgba(255,255,255,.6);
            font-weight: 500; margin-bottom: 48px;
            line-height: 1.5;
        }

        /* Stats row */
        .stats-row {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 16px; margin-bottom: 40px;
        }
        .stat-box {
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 14px;
            padding: 16px 12px;
            backdrop-filter: blur(8px);
        }
        .stat-box-val { font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 4px; }
        .stat-box-lbl { font-size: 11px; color: rgba(255,255,255,.55); font-weight: 500; }

        /* Quote */
        .quote-box {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 16px;
            padding: 20px 24px;
            text-align: left;
        }
        .quote-text {
            font-size: 20px;
            color: rgba(255,255,255,.9);
            font-weight: 500;
            line-height: 1.5;
            margin-bottom: 10px;
            font-style: italic;
        }
        .quote-source {
            font-size: 12px;
            color: rgba(255,255,255,.45);
            font-weight: 600;
            letter-spacing: .5px;
        }

        /* ── RIGHT PANEL ── */
        .right-panel {
            flex: 1;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            position: relative;
        }

        /* subtle top border accent */
        .right-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--green-main), var(--green-light), var(--gold));
        }

        .login-box { width: 100%; max-width: 400px; }

        .login-header { margin-bottom: 32px; }
        .login-tag {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--green-pale);
            color: var(--green-main);
            font-size: 11.5px; font-weight: 700;
            padding: 5px 12px; border-radius: 20px;
            margin-bottom: 16px;
            letter-spacing: .3px;
        }
        .login-tag::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--green-light);
        }
        .login-title {
            font-size: 28px; font-weight: 800;
            color: #0f1f15; margin-bottom: 6px;
            line-height: 1.2;
        }
        .login-title span { color: var(--green-main); }
        .login-desc { font-size: 13.5px; color: #888; font-weight: 500; }

        /* Error alert */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            display: flex; align-items: flex-start; gap: 10px;
        }
        .alert-error svg { width: 16px; height: 16px; color: #dc2626; flex-shrink: 0; margin-top: 1px; }
        .alert-error p { font-size: 13px; color: #b91c1c; font-weight: 500; }

        /* Form */
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            font-size: 13px; font-weight: 700;
            color: #222; margin-bottom: 8px;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }
        .input-icon svg { width: 17px; height: 17px; }
        .form-input {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 11px;
            padding: 12px 14px 12px 44px;
            font-size: 14px; font-family: inherit;
            color: #111; outline: none;
            transition: border-color .2s, box-shadow .2s;
            background: #fafafa;
        }
        .form-input:focus {
            border-color: var(--green-main);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(26,107,60,.1);
        }
        .form-input::placeholder { color: #bbb; }

        /* Show/hide password */
        .toggle-pw {
            position: absolute; right: 14px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: #aaa; padding: 0;
        }
        .toggle-pw:hover { color: var(--green-main); }
        .toggle-pw svg { width: 17px; height: 17px; }

        /* Remember me */
        .remember-row {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 24px;
        }
        .remember-row input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--green-main);
            cursor: pointer;
        }
        .remember-row label { font-size: 13px; color: #555; cursor: pointer; font-weight: 500; }

        /* Submit button */
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, var(--green-mid), var(--green-main));
            color: #fff;
            border: none;
            border-radius: 11px;
            padding: 14px;
            font-size: 15px; font-weight: 700;
            cursor: pointer;
            font-family: inherit;
            transition: opacity .2s, transform .1s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            box-shadow: 0 4px 16px rgba(26,107,60,.3);
        }
        .btn-login:hover { opacity: .92; transform: translateY(-1px); }
        .btn-login:active { transform: translateY(0); }
        .btn-login svg { width: 18px; height: 18px; }

        /* Footer */
        .login-footer {
            margin-top: 28px;
            text-align: center;
            font-size: 12px; color: #bbb;
        }
        .login-footer span { color: var(--green-main); font-weight: 600; }

        /* Input error state */
        .form-input.is-error { border-color: #fca5a5; background: #fff5f5; }

        /* Fade-in animation */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .login-box { animation: fadeUp .5s ease both; }
        .left-content { animation: fadeUp .6s ease .1s both; }
    </style>
</head>
<body>

<!-- ════════ LEFT PANEL ════════ -->
<div class="left-panel">
    <div class="dot-grid"></div>
    <div class="circle-deco c1"></div>
    <div class="circle-deco c2"></div>
    <div class="circle-deco c3"></div>

    <div class="left-content">
        <div class="brand-logo">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
        </div>

        <h1 class="brand-name">ZIS Asy-Syaakiriin</h1>
        <p class="brand-sub">
            YPDI Pondok Bambu<br>
            Sistem Manajemen Zakat, Infaq & Shodaqoh
        </p>

        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-box-val">5+</div>
                <div class="stat-box-lbl">Jenis Zakat</div>
            </div>
            <div class="stat-box">
                <div class="stat-box-val">BSI</div>
                <div class="stat-box-lbl">Bank Partner</div>
            </div>
            <div class="stat-box">
                <div class="stat-box-val">PDF</div>
                <div class="stat-box-lbl">Auto Invoice</div>
            </div>
        </div>

        <div class="quote-box">
            <p class="quote-text">
                "Ambillah zakat dari sebagian harta mereka, dengan zakat itu kamu membersihkan dan mensucikan mereka."
            </p>
            <p class="quote-source">— QS. AT-TAUBAH: 103</p>
        </div>
    </div>
</div>

<!-- ════════ RIGHT PANEL ════════ -->
<div class="right-panel">
    <div class="login-box">

        <div class="login-header">
            <div class="login-tag">Admin Portal</div>
            <h2 class="login-title">Selamat <span>Datang</span> 👋</h2>
            <p class="login-desc">Masuk ke panel admin untuk mengelola data ZIS</p>
        </div>

        {{-- Error message --}}
        @if($errors->any() || session('error'))
        <div class="alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <p>
                {{ session('error') ?? $errors->first() }}
            </p>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </span>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input {{ $errors->has('email') ? 'is-error' : '' }}"
                        placeholder="admin@example.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                </div>
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0110 0v4"/>
                        </svg>
                    </span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input {{ $errors->has('password') ? 'is-error' : '' }}"
                        placeholder="••••••••"
                        required
                    >
                    <button type="button" class="toggle-pw" onclick="togglePassword()">
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Remember me --}}
            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat saya selama 7 hari</label>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-login">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/>
                </svg>
                Masuk ke Dashboard
            </button>
        </form>

        <div class="login-footer">
            &copy; {{ date('Y') }} <span>YPDI Asy-Syaakiriin</span> · Sistem ZIS Internal
        </div>

    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eye-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
}
</script>

</body>
</html>
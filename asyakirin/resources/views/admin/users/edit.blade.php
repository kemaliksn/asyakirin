<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Akun - ASY-SYAAKIRIIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar { background: linear-gradient(180deg, #145c33 0%, #1a6b3c 40%, #1f7d46 100%); width: 220px; min-height: 100vh; position: fixed; top: 0; left: 0; display: flex; flex-direction: column; z-index: 100; box-shadow: 4px 0 20px rgba(0,0,0,.18); }
        .sidebar-logo { padding: 20px 18px 16px; border-bottom: 1px solid rgba(255,255,255,.12); }
        .sidebar-logo-text h2 { color: #fff; font-size: 15px; font-weight: 700; line-height: 1.2; }
        .sidebar-logo-text p { color: rgba(255,255,255,.65); font-size: 10.5px; margin-top: 2px; }
        .sidebar-nav { flex: 1; padding: 14px 10px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; color: rgba(255,255,255,.75); font-size: 13.5px; font-weight: 500; cursor: pointer; transition: all .2s; margin-bottom: 3px; text-decoration: none; border: none; background: none; width: 100%; }
        .nav-item:hover { background: rgba(255,255,255,.12); color: #fff; }
        .nav-item.active { background: rgba(255,255,255,.18); color: #fff; font-weight: 700; }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
        .sidebar-footer { padding: 14px 10px; border-top: 1px solid rgba(255,255,255,.12); }
        .topbar { position: fixed; top: 0; left: 220px; right: 0; height: 64px; background: #fff; border-bottom: 1px solid #e5ede8; display: flex; align-items: center; padding: 0 28px; gap: 14px; z-index: 99; box-shadow: 0 2px 12px rgba(26,107,60,.07); }
        .main-content { margin-left: 220px; padding-top: 64px; background: #f4f8f5; min-height: 100vh; }
        .content-inner { padding: 28px; max-width: 800px; }
        .page-title { font-size: 26px; font-weight: 800; color: #111; margin-bottom: 22px; }
        .page-title span { color: #1a6b3c; }
        .form-card { background: #fff; border-radius: 14px; border: 1px solid #e2ece6; box-shadow: 0 2px 10px rgba(26,107,60,.05); padding: 28px; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #333; margin-bottom: 6px; }
        .form-input, .form-select { width: 100%; border: 1px solid #d3e8da; border-radius: 9px; padding: 10px 14px; font-size: 13.5px; background: #f8fdf9; color: #333; outline: none; font-family: inherit; }
        .form-input:focus, .form-select:focus { border-color: #1a6b3c; background: #fff; }
        .form-input[readonly] { background: #f3f4f6; color: #888; cursor: not-allowed; }
        .form-error { font-size: 12px; color: #b91c1c; margin-top: 4px; }
        .btn-primary { background: linear-gradient(135deg, #22813f, #1a6b3c); color: #fff; border: none; border-radius: 9px; padding: 11px 24px; font-size: 14px; font-weight: 700; cursor: pointer; font-family: inherit; transition: opacity .2s; }
        .btn-primary:hover { opacity: .88; }
        .btn-secondary { background: #f1f7f3; color: #555; border: 1px solid #d3e8da; border-radius: 9px; padding: 11px 24px; font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: none; font-family: inherit; }
        .btn-secondary:hover { background: #daf0e4; }
        .form-actions { display: flex; gap: 10px; margin-top: 28px; }
        .info-box { border-radius: 10px; padding: 14px; font-size: 12.5px; margin-bottom: 20px; }
        .info-box.warning { background: #fef9c3; border: 1px solid #fde047; color: #854d0e; }
        .info-box.info    { background: #e0f2fe; border: 1px solid #7dd3fc; color: #075985; }
        .source-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; }
        .source-badge.admins { background: #f3e8fd; color: #7c3aed; }
        .source-badge.users  { background: #e0f2fe; color: #075985; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo flex items-center gap-3">
        <div style="width:44px;height:44px;background:rgba(255,255,255,.15);border-radius:10px;display:flex;align-items:center;justify-content:center;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8" style="width:24px;height:24px;">
                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
        </div>
        <div class="sidebar-logo-text">
            <h2>Dashboard Admin ZIS</h2>
            <p>YPDI Asy-Syaakiriin</p>
        </div>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        @if((auth('admin')->check() && auth('admin')->user()->role === 'admin') || (auth('web')->check() && auth('web')->user()->role === 'admin'))
        <a href="{{ route('admin.users.index') }}" class="nav-item active">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
            </svg>
            Kelola Akun
        </a>
        @endif
        {{-- <a href="{{ route('admin.transaksi') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Transaksi
        </a>
        <a href="{{ route('admin.laporan') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Laporan
        </a> --}}
        <a href="{{ route('admin.rekap') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
            Rekap
        </a>
        {{-- <a href="{{ route('admin.settings') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
            Settings
        </a> --}}
    </nav>
    <div class="sidebar-footer">
        {{-- <a href="{{ route('admin.akun') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Akun
        </a> --}}
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>

<!-- TOPBAR -->
<header class="topbar">
    <div style="display:flex;align-items:center;gap:8px;">
        <a href="{{ route('admin.dashboard') }}" style="color:#888;font-size:13px;text-decoration:none;">Dashboard</a>
        <span style="color:#ccc;">/</span>
        <a href="{{ route('admin.users.index') }}" style="color:#888;font-size:13px;text-decoration:none;">Kelola Akun</a>
        <span style="color:#ccc;">/</span>
        <span style="font-size:13px;font-weight:600;color:#1a6b3c;">Edit Akun</span>
    </div>
    <div style="flex:1;"></div>
</header>

<!-- MAIN -->
<main class="main-content">
<div class="content-inner">

    <h1 class="page-title">Edit <span>Akun</span></h1>

    {{-- Info tabel sumber --}}
    <div class="info-box info" style="display:flex;align-items:center;gap:10px;">
        ℹ️ Mengedit akun dari tabel:
        <span class="source-badge {{ $user->source ?? 'admins' }}">
            {{ ($user->source ?? 'admins') === 'admins' ? '🔐 Admins' : '👤 Users' }}
        </span>
    </div>

    <div class="info-box warning">
        ⚠️ Kosongkan field password jika tidak ingin mengubahnya.
    </div>

    <div class="form-card">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            {{-- Kirim info tabel sumber agar controller tahu update ke mana --}}
            <input type="hidden" name="source" value="{{ $user->source ?? 'admins' }}">

            <div class="form-group">
                <label class="form-label">Nama Lengkap *</label>
                <input type="text" name="name" class="form-input"
                       value="{{ old('name', $user->name) }}"
                       placeholder="Contoh: Ahmad Fauzan" required>
                @error('name')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-input"
                       value="{{ old('email', $user->email) }}"
                       placeholder="contoh@email.com" required>
                @error('email')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password Baru <span style="color:#aaa;font-weight:400;">(opsional)</span></label>
                <input type="password" name="password" class="form-input"
                       placeholder="Kosongkan jika tidak ingin ubah password">
                @error('password')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-input"
                       placeholder="Ketik ulang password baru">
            </div>

            <div class="form-group">
                <label class="form-label">Role *</label>
                <select name="role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin"    {{ old('role', $user->role) === 'admin'    ? 'selected' : '' }}>Admin</option>
                    <option value="pengurus" {{ old('role', $user->role) === 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                </select>
                @error('role')
                <div class="form-error">{{ $message }}</div>
                @enderror
                <div style="font-size:12px;color:#888;margin-top:4px;">
                    • <strong>Admin:</strong> Akses penuh ke semua fitur termasuk kelola akun<br>
                    • <strong>Pengurus:</strong> Akses terbatas, bisa input data zakat
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Status *</label>
                <select name="is_active" class="form-select" required>
                    <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>✅ Aktif</option>
                    <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>❌ Nonaktif</option>
                </select>
                @error('is_active')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    ✓ Simpan Perubahan
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>
</main>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Zakat - ASY-SYAAKIRIIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Sidebar (sama dengan dashboard) ── */
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

        /* ── Topbar ── */
        .topbar { position: fixed; top: 0; left: 220px; right: 0; height: 64px; background: #fff; border-bottom: 1px solid #e5ede8; display: flex; align-items: center; padding: 0 28px; gap: 14px; z-index: 99; box-shadow: 0 2px 12px rgba(26,107,60,.07); }
        .admin-chip { display: flex; align-items: center; gap: 9px; background: #f1f7f3; border: 1px solid #d3e8da; border-radius: 10px; padding: 6px 12px; cursor: pointer; }
        .admin-avatar { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, #22813f, #1a6b3c); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 12px; font-weight: 700; }
        .notif-btn { position: relative; background: #f1f7f3; border: 1px solid #d3e8da; border-radius: 10px; padding: 8px 10px; cursor: pointer; display: flex; }
        .notif-btn svg { width: 18px; height: 18px; color: #555; }
        .notif-badge { position: absolute; top: -5px; right: -5px; background: #e53e3e; color: #fff; font-size: 9px; font-weight: 700; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid #fff; }

        /* ── Main ── */
        .main-content { margin-left: 220px; padding-top: 64px; background: #f4f8f5; min-height: 100vh; }
        .content-inner { padding: 28px; }

        /* ── Breadcrumb ── */
        .breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 12.5px; color: #888; margin-bottom: 16px; }
        .breadcrumb a { color: #888; text-decoration: none; }
        .breadcrumb a:hover { color: #1a6b3c; }
        .breadcrumb .sep { color: #ccc; }
        .breadcrumb .active { color: #1a6b3c; font-weight: 600; }

        /* ── Page title ── */
        .page-title { font-size: 26px; font-weight: 800; color: #111; margin-bottom: 22px; }
        .page-title span { color: #1a6b3c; }

        /* ── Stat cards per jenis ── */
        .jenis-cards { display: grid; grid-template-columns: repeat(5, 1fr); gap: 14px; margin-bottom: 24px; }
        .jenis-card {
            border-radius: 14px; padding: 16px 18px;
            display: flex; align-items: center; gap: 12px;
            cursor: pointer; transition: transform .15s, box-shadow .15s;
            text-decoration: none;
        }
        .jenis-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.12); }
        .jenis-card.fitrah  { background: linear-gradient(135deg, #1a6b3c, #22813f); }
        .jenis-card.maal    { background: linear-gradient(135deg, #145c33, #1a6b3c); }
        .jenis-card.infaq   { background: linear-gradient(135deg, #b45309, #d97706); }
        .jenis-card.yatim   { background: linear-gradient(135deg, #c05621, #dd6b20); }
        .jenis-card.fidyah  { background: linear-gradient(135deg, #276749, #38a169); }
        .jenis-card-icon { width: 38px; height: 38px; border-radius: 10px; background: rgba(255,255,255,.18); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .jenis-card-icon svg { width: 20px; height: 20px; color: #fff; }
        .jenis-card-label { font-size: 11.5px; color: rgba(255,255,255,.85); font-weight: 500; margin-bottom: 3px; }
        .jenis-card-value { font-size: 15px; font-weight: 800; color: #fff; line-height: 1; }

        /* ── Filter bar ── */
        .filter-card { background: #fff; border-radius: 14px; border: 1px solid #e2ece6; padding: 16px 20px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; box-shadow: 0 2px 10px rgba(26,107,60,.05); }
        .filter-select { border: 1px solid #d3e8da; border-radius: 9px; padding: 8px 12px; font-size: 13px; background: #f8fdf9; color: #333; outline: none; cursor: pointer; font-family: inherit; }
        .filter-input { border: 1px solid #d3e8da; border-radius: 9px; padding: 8px 14px; font-size: 13px; background: #f8fdf9; color: #333; outline: none; font-family: inherit; width: 200px; }
        .filter-input:focus { border-color: #1a6b3c; background: #fff; }
        .filter-spacer { flex: 1; }
        .btn-filter { background: linear-gradient(135deg, #22813f, #1a6b3c); color: #fff; border: none; border-radius: 9px; padding: 8px 20px; font-size: 13px; font-weight: 700; cursor: pointer; transition: opacity .2s; font-family: inherit; }
        .btn-filter:hover { opacity: .88; }
        .btn-search { background: linear-gradient(135deg, #1a6b3c, #145c33); color: #fff; border: none; border-radius: 9px; padding: 8px 20px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit; display: flex; align-items: center; gap: 6px; }
        .btn-search:hover { opacity: .88; }
        .btn-reset { background: #f1f7f3; border: 1px solid #d3e8da; border-radius: 9px; padding: 8px 14px; font-size: 13px; font-weight: 600; color: #555; cursor: pointer; font-family: inherit; text-decoration: none; }
        .btn-reset:hover { background: #daf0e4; }

        /* ── Table card ── */
        .table-card { background: #fff; border-radius: 14px; border: 1px solid #e2ece6; box-shadow: 0 2px 10px rgba(26,107,60,.05); overflow: hidden; }
        .table-card-header { padding: 16px 22px; border-bottom: 1px solid #f0f5f1; display: flex; align-items: center; gap: 10px; }
        .table-card-header h3 { font-size: 15px; font-weight: 700; color: #145c33; flex: 1; }
        .btn-export { background: linear-gradient(135deg, #22813f, #1a6b3c); color: #fff; border: none; border-radius: 9px; padding: 8px 16px; font-size: 12.5px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; text-decoration: none; font-family: inherit; }
        .btn-export:hover { opacity: .88; }

        table.rekap-table { width: 100%; border-collapse: collapse; }
        table.rekap-table thead tr { background: #f0f7f3; }
        table.rekap-table th { padding: 12px 18px; font-size: 12.5px; font-weight: 700; color: #3d7a55; text-align: left; white-space: nowrap; }
        table.rekap-table td { padding: 13px 18px; font-size: 13px; color: #333; border-top: 1px solid #f3f7f4; vertical-align: middle; }
        table.rekap-table tbody tr:hover { background: #f8fdf9; }

        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 700; }
        .badge.lunas       { background: #dcfce7; color: #15803d; }
        .badge.pending     { background: #fef9c3; color: #854d0e; }
        .badge.batal       { background: #fee2e2; color: #b91c1c; }
        .badge::before     { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

        .btn-detail { background: #1a6b3c; color: #fff; border: none; border-radius: 7px; padding: 5px 14px; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; font-family: inherit; transition: background .15s; }
        .btn-detail:hover { background: #145c33; }

        .invoice-tag { font-weight: 700; color: #1a6b3c; font-size: 13px; }

        /* ── Pagination ── */
        .pagination-wrap { padding: 16px 22px; display: flex; align-items: center; gap: 8px; border-top: 1px solid #f0f5f1; }
        .page-info { font-size: 12.5px; color: #888; flex: 1; }
        .page-btn { width: 34px; height: 34px; border-radius: 8px; border: 1px solid #d3e8da; background: #f8fdf9; color: #555; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all .15s; font-family: inherit; }
        .page-btn:hover { background: #e8f5ee; border-color: #1a6b3c; color: #1a6b3c; }
        .page-btn.active { background: #1a6b3c; border-color: #1a6b3c; color: #fff; }
        .page-btn.disabled { opacity: .4; cursor: not-allowed; pointer-events: none; }

        /* ── Empty state ── */
        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state-icon { font-size: 48px; margin-bottom: 12px; }
        .empty-state p { color: #aaa; font-size: 14px; }

        @media (max-width: 1200px) { .jenis-cards { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 768px) { .jenis-cards { grid-template-columns: repeat(2, 1fr); } .sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } .topbar { left: 0; } }
    </style>
</head>
<body>

<!-- ════════ SIDEBAR ════════ -->
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
        <a href="{{ route('admin.transaksi') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Transaksi
        </a>
        <a href="{{ route('admin.laporan') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Laporan
        </a>
        <a href="{{ route('admin.rekap') }}" class="nav-item active">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
            Rekap
        </a>
        <a href="{{ route('admin.settings') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
            Settings
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="{{ route('admin.akun') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Akun
        </a>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>

<!-- ════════ TOPBAR ════════ -->
<header class="topbar">
    <div style="display:flex;align-items:center;gap:8px;">
        <a href="{{ route('admin.dashboard') }}" style="color:#888;font-size:13px;text-decoration:none;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;display:inline;vertical-align:-3px;"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <span style="color:#ccc;">/</span>
        <span style="font-size:13px;font-weight:600;color:#1a6b3c;">Rekap Zakat dan Donasi</span>
    </div>
    <div style="flex:1;"></div>
    <button class="notif-btn">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
    </button>
    <div class="admin-chip">
        <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
        <span style="font-size:13px;font-weight:600;color:#222;">{{ auth()->user()->name ?? 'Admin Ahmad' }}</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;color:#888;"><path d="M19 9l-7 7-7-7"/></svg>
    </div>
</header>

<!-- ════════ MAIN ════════ -->
<main class="main-content">
<div class="content-inner">

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sep">/</span>
        <span class="active">Rekap Zakat dan Donasi</span>
    </div>

    <!-- Page Title -->
    <h1 class="page-title">Rekap Zakat <span>dan Donasi</span></h1>

    <!-- ── STAT CARDS PER JENIS ── -->
    <div class="jenis-cards">

        <a href="{{ request()->fullUrlWithQuery(['jenis' => 'Fitrah']) }}" class="jenis-card fitrah">
            <div class="jenis-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <div>
                <div class="jenis-card-label">Zakat Fitrah</div>
                <div class="jenis-card-value">Rp {{ number_format($statJenis['Zakat Fitrah'], 0, ',', '.') }}</div>
            </div>
        </a>

        <a href="{{ request()->fullUrlWithQuery(['jenis' => 'Maal']) }}" class="jenis-card maal">
            <div class="jenis-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            </div>
            <div>
                <div class="jenis-card-label">Zakat Maal</div>
                <div class="jenis-card-value">Rp {{ number_format($statJenis['Zakat Maal'], 0, ',', '.') }}</div>
            </div>
        </a>

        <a href="{{ request()->fullUrlWithQuery(['jenis' => 'Infaq']) }}" class="jenis-card infaq">
            <div class="jenis-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </div>
            <div>
                <div class="jenis-card-label">Infaq/Shodaqoh</div>
                <div class="jenis-card-value">Rp {{ number_format($statJenis['Infaq/Shodaqoh'], 0, ',', '.') }}</div>
            </div>
        </a>

        <a href="{{ request()->fullUrlWithQuery(['jenis' => 'Yatim']) }}" class="jenis-card yatim">
            <div class="jenis-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div>
                <div class="jenis-card-label">Yatim</div>
                <div class="jenis-card-value">Rp {{ number_format($statJenis['Yatim'], 0, ',', '.') }}</div>
            </div>
        </a>

        <a href="{{ request()->fullUrlWithQuery(['jenis' => 'Fidyah']) }}" class="jenis-card fidyah">
            <div class="jenis-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"/></svg>
            </div>
            <div>
                <div class="jenis-card-label">Fidyah</div>
                <div class="jenis-card-value">Rp {{ number_format($statJenis['Fidyah'], 0, ',', '.') }}</div>
            </div>
        </a>

    </div><!-- /jenis-cards -->

    <!-- ── FILTER BAR ── -->
    <form method="GET" action="{{ route('admin.rekap') }}">
        <div class="filter-card">

            <!-- Jenis Pembayaran -->
            <select name="jenis" class="filter-select">
                <option value="">Jenis Pembayaran</option>
                <option value="Fitrah"  {{ $filterJenis === 'Fitrah'  ? 'selected' : '' }}>Zakat Fitrah</option>
                <option value="Maal"    {{ $filterJenis === 'Maal'    ? 'selected' : '' }}>Zakat Maal</option>
                <option value="Infaq"   {{ $filterJenis === 'Infaq'   ? 'selected' : '' }}>Infaq/Shodaqoh</option>
                <option value="Yatim"   {{ $filterJenis === 'Yatim'   ? 'selected' : '' }}>Yatim</option>
                <option value="Fidyah"  {{ $filterJenis === 'Fidyah'  ? 'selected' : '' }}>Fidyah</option>
            </select>

            <!-- Bulan -->
            <select name="bulan" class="filter-select">
                @foreach($daftarBulan as $num => $nama)
                <option value="{{ $num }}" {{ (int)$filterBulan === $num ? 'selected' : '' }}>
                    {{ $nama }}
                </option>
                @endforeach
            </select>

            <!-- Tahun -->
            <select name="tahun" class="filter-select">
                @for($y = now()->year; $y >= now()->year - 3; $y--)
                <option value="{{ $y }}" {{ (int)$filterTahun === $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>

            <!-- Status -->
            <select name="status" class="filter-select">
                <option value="">Semua Status</option>
                <option value="Lunas"       {{ $filterStatus === 'Lunas'       ? 'selected' : '' }}>Lunas</option>
                <option value="Belum Lunas" {{ $filterStatus === 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                <option value="Batal"       {{ $filterStatus === 'Batal'       ? 'selected' : '' }}>Batal</option>
            </select>

            <!-- Tombol Filter -->
            <button type="submit" class="btn-filter">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;display:inline;margin-right:4px;"><path d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/></svg>
                Filter
            </button>

            <div class="filter-spacer"></div>

            <!-- Cari Nama -->
            <input type="text" name="nama" class="filter-input"
                   placeholder="Cari Nama..."
                   value="{{ $filterNama }}">

            <button type="submit" class="btn-search">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                Search
            </button>

            @if($filterJenis || $filterStatus || $filterNama)
            <a href="{{ route('admin.rekap') }}" class="btn-reset">✕ Reset</a>
            @endif

        </div>
    </form>

    <!-- ── TABLE ── -->
    <div class="table-card">
        <div class="table-card-header">
            <h3>
                Data Rekap
                @if($filterJenis) — {{ $filterJenis }} @endif
                @if($filterStatus) — {{ $filterStatus }} @endif
            </h3>
            <span style="font-size:12px;background:#e8f5ee;color:#1a6b3c;padding:2px 10px;border-radius:20px;font-weight:600;">
                {{ $total }} data
            </span>
            <a href="{{ route('admin.laporan') }}" class="btn-export" style="margin-left:8px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export Excel
            </a>
        </div>

        <div style="overflow-x:auto;">
            <table class="rekap-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Invoice</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $i => $row)
                    <tr>
                        <td style="color:#aaa;font-size:12.5px;">{{ ($currentPage - 1) * $perPage + $i + 1 }}.</td>
                        <td><span class="invoice-tag">{{ $row->invoice }}</span></td>
                        <td style="font-weight:600;">{{ $row->nama }}</td>
                        <td>
                            @php
                                $jenisBadge = [
                                    'Zakat Fitrah'   => '#e8f5ee|#1a6b3c',
                                    'Zakat Maal'     => '#e0f2f7|#0e7490',
                                    'Infaq - Shodaqoh' => '#fef9c3|#854d0e',
                                    'Infaq/Shodaqoh' => '#fef9c3|#854d0e',
                                    'Yatim'          => '#f3e8fd|#7c3aed',
                                    'Fidyah'         => '#dcfce7|#15803d',
                                ];
                                $colors = $jenisBadge[$row->jenis] ?? '#f3f4f6|#555';
                                [$bg, $fg] = explode('|', $colors);
                            @endphp
                            <span style="background:{{ $bg }};color:{{ $fg }};padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;">
                                {{ $row->jenis }}
                            </span>
                        </td>
                        <td style="font-weight:700;color:#111;">Rp {{ number_format($row->nominal, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $cls = match($row->status) {
                                    'Lunas'       => 'lunas',
                                    'Belum Lunas' => 'pending',
                                    'Batal'       => 'batal',
                                    default       => 'pending',
                                };
                            @endphp
                            <span class="badge {{ $cls }}">{{ $row->status }}</span>
                        </td>
                        <td style="color:#888;white-space:nowrap;">{{ $row->tanggal }}</td>
                        <td>
                            <a href="{{ route('admin.transaksi.show', $row->id) }}" class="btn-detail">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-state-icon">📭</div>
                                <p>Tidak ada data untuk filter yang dipilih.</p>
                                <a href="{{ route('admin.rekap') }}" style="color:#1a6b3c;font-weight:600;font-size:13px;">Tampilkan semua data</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ── PAGINATION ── -->
        @if($lastPage > 1)
        <div class="pagination-wrap">
            <span class="page-info">
                Menampilkan {{ ($currentPage - 1) * $perPage + 1 }}–{{ min($currentPage * $perPage, $total) }}
                dari {{ $total }} data
            </span>

            {{-- Prev --}}
            @if($currentPage > 1)
            <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage - 1]) }}" class="page-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M15 18l-6-6 6-6"/></svg>
            </a>
            @else
            <span class="page-btn disabled">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M15 18l-6-6 6-6"/></svg>
            </span>
            @endif

            {{-- Page numbers --}}
            @for($p = max(1, $currentPage - 2); $p <= min($lastPage, $currentPage + 2); $p++)
            <a href="{{ request()->fullUrlWithQuery(['page' => $p]) }}"
               class="page-btn {{ $p === $currentPage ? 'active' : '' }}">
                {{ $p }}
            </a>
            @endfor

            {{-- Next --}}
            @if($currentPage < $lastPage)
            <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}" class="page-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M9 18l6-6-6-6"/></svg>
            </a>
            @else
            <span class="page-btn disabled">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M9 18l6-6-6-6"/></svg>
            </span>
            @endif
        </div>
        @endif

    </div><!-- /table-card -->

</div>
</main>

</body>
</html>
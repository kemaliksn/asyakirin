<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin ZIS - ASY-SYAAKIRIIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        :root { --green-primary: #1a6b3c; --green-mid: #22813f; }
        .sidebar { background: linear-gradient(180deg, #145c33 0%, #1a6b3c 40%, #1f7d46 100%); width: 220px; min-height: 100vh; position: fixed; top: 0; left: 0; display: flex; flex-direction: column; z-index: 100; box-shadow: 4px 0 20px rgba(0,0,0,.18); }
        .sidebar-logo { padding: 20px 18px 16px; border-bottom: 1px solid rgba(255,255,255,.12); }
        .sidebar-logo-text h2 { color: #fff; font-size: 15px; font-weight: 700; line-height: 1.2; }
        .sidebar-logo-text p { color: rgba(255,255,255,.65); font-size: 10.5px; margin-top: 2px; }
        .sidebar-nav { flex: 1; padding: 14px 10px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; color: rgba(255,255,255,.75); font-size: 13.5px; font-weight: 500; cursor: pointer; transition: all .2s; margin-bottom: 3px; text-decoration: none; }
        .nav-item:hover { background: rgba(255,255,255,.12); color: #fff; }
        .nav-item.active { background: rgba(255,255,255,.18); color: #fff; font-weight: 700; }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
        .sidebar-footer { padding: 14px 10px; border-top: 1px solid rgba(255,255,255,.12); }
        .topbar { position: fixed; top: 0; left: 220px; right: 0; height: 64px; background: #fff; border-bottom: 1px solid #e5ede8; display: flex; align-items: center; padding: 0 28px; gap: 14px; z-index: 99; box-shadow: 0 2px 12px rgba(26,107,60,.07); }
        .topbar-greeting { font-size: 22px; font-weight: 800; color: #145c33; }
        .topbar-greeting span { color: #1f7d46; }
        .topbar-spacer { flex: 1; }
        .topbar-search { display: flex; align-items: center; gap: 8px; background: #f1f7f3; border-radius: 10px; padding: 7px 14px; border: 1px solid #d3e8da; }
        .topbar-search input { background: none; border: none; outline: none; font-size: 13px; color: #333; width: 180px; }
        .notif-btn { position: relative; background: #f1f7f3; border: 1px solid #d3e8da; border-radius: 10px; padding: 8px 10px; cursor: pointer; display: flex; }
        .notif-btn svg { width: 18px; height: 18px; color: #555; }
        .admin-chip { display: flex; align-items: center; gap: 9px; background: #f1f7f3; border: 1px solid #d3e8da; border-radius: 10px; padding: 6px 12px; cursor: pointer; }
        .admin-avatar { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, #22813f, #1a6b3c); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 12px; font-weight: 700; }
        .admin-name { font-size: 13px; font-weight: 600; color: #222; }
        .main-content { margin-left: 220px; padding-top: 64px; background: #f4f8f5; min-height: 100vh; }
        .content-inner { padding: 28px; }
        .stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; margin-bottom: 22px; }
        .stat-card { background: #fff; border-radius: 16px; padding: 22px 22px 18px; border: 1px solid #e2ece6; box-shadow: 0 2px 12px rgba(26,107,60,.06); transition: transform .2s, box-shadow .2s; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 6px 22px rgba(26,107,60,.12); }
        .stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }
        .stat-icon svg { width: 22px; height: 22px; }
        .stat-icon.green  { background: #e8f5ee; color: #1a6b3c; }
        .stat-icon.teal   { background: #e0f2f7; color: #0e7490; }
        .stat-icon.gold   { background: #fdf3d7; color: #b7860a; }
        .stat-icon.purple { background: #f3e8fd; color: #7c3aed; }
        .stat-icon.orange { background: #fff2e8; color: #c05621; }
        .stat-label { font-size: 12.5px; color: #6b7280; font-weight: 500; margin-bottom: 5px; }
        .stat-value { font-size: 22px; font-weight: 800; color: #111; line-height: 1; }
        .stat-sub { font-size: 11.5px; color: #6b7280; font-weight: 500; margin-top: 6px; }
        .two-col { display: grid; grid-template-columns: 1fr 340px; gap: 20px; margin-bottom: 22px; }
        .card { background: #fff; border-radius: 16px; border: 1px solid #e2ece6; box-shadow: 0 2px 12px rgba(26,107,60,.05); overflow: hidden; }
        .card-header { padding: 18px 22px 14px; border-bottom: 1px solid #f0f5f1; display: flex; align-items: center; gap: 10px; }
        .card-header h3 { font-size: 15px; font-weight: 700; color: #145c33; flex: 1; }
        .filter-bar { padding: 14px 22px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #f0f5f1; flex-wrap: wrap; }
        .filter-spacer { flex: 1; }
        .btn-export { background: linear-gradient(135deg, #22813f, #1a6b3c); color: #fff; border: none; border-radius: 9px; padding: 8px 16px; font-size: 12.5px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: opacity .2s; text-decoration: none; }
        .btn-export:hover { opacity: .88; }
        .filter-tag { border: 1px solid #d3e8da; border-radius: 9px; padding: 6px 12px; font-size: 12px; background: #f8fdf9; color: #1a6b3c; font-weight: 500; text-decoration: none; transition: background .15s; }
        .filter-tag:hover { background: #daf0e4; }
        .table-wrap { overflow-x: auto; }
        table.data-table { width: 100%; border-collapse: collapse; }
        table.data-table thead tr { background: #f0f7f3; }
        table.data-table th { padding: 11px 16px; font-size: 12px; font-weight: 700; color: #3d7a55; text-align: left; white-space: nowrap; }
        table.data-table td { padding: 12px 16px; font-size: 13px; color: #333; border-top: 1px solid #f3f7f4; }
        table.data-table tbody tr:hover { background: #f8fdf9; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge.lunas   { background: #dcfce7; color: #15803d; }
        .badge.pending { background: #fef9c3; color: #854d0e; }
        .badge.batal   { background: #fee2e2; color: #b91c1c; }
        .tbl-footer { padding: 14px 22px; display: flex; align-items: center; border-top: 1px solid #f0f5f1; }
        .btn-lihat-semua { background: #f1f7f3; border: 1px solid #d3e8da; border-radius: 8px; padding: 7px 14px; font-size: 12.5px; font-weight: 600; color: #1a6b3c; cursor: pointer; transition: background .2s; text-decoration: none; }
        .btn-lihat-semua:hover { background: #daf0e4; }
        .tbl-footer-right { margin-left: auto; font-size: 13px; font-weight: 600; color: #1a6b3c; text-decoration: none; }
        .tbl-footer-right:hover { text-decoration: underline; }
        .right-panel { display: flex; flex-direction: column; gap: 18px; }
        .jenis-list { padding: 14px 20px; }
        .jenis-item { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f3f7f4; }
        .jenis-item:last-child { border-bottom: none; }
        .jenis-dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
        .jenis-name { font-size: 13px; color: #444; flex: 1; }
        .jenis-amount { font-size: 13px; font-weight: 700; color: #145c33; }
        .btn-rekap { display: block; margin: 4px 20px 16px; background: linear-gradient(135deg, #22813f, #1a6b3c); color: #fff; text-align: center; border-radius: 10px; padding: 11px; font-size: 13px; font-weight: 700; cursor: pointer; border: none; transition: opacity .2s; text-decoration: none; }
        .btn-rekap:hover { opacity: .88; }
        .qris-card { padding: 18px 20px; }
        .qris-inner { display: flex; align-items: center; gap: 16px; background: #f8fdf9; border: 1px dashed #aed4bc; border-radius: 12px; padding: 14px; }
        .qris-img { width: 70px; height: 70px; background: #e0e0e0; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #888; text-align: center; flex-shrink: 0; overflow: hidden; }
        .qris-info p { font-size: 11px; color: #555; margin-bottom: 4px; }
        .qris-info strong { font-size: 12.5px; color: #145c33; display: block; margin-bottom: 2px; }
        .btn-wa { display: flex; align-items: center; gap: 8px; background: #25d366; color: #fff; border: none; border-radius: 10px; padding: 10px 16px; font-size: 12.5px; font-weight: 700; cursor: pointer; width: calc(100% - 40px); margin: 0 20px 18px; justify-content: center; transition: background .2s; text-decoration: none; }
        .btn-wa:hover { background: #1dbb59; }
        .chart-container { padding: 18px 22px; height: 220px; }
        .empty-state { text-align: center; padding: 40px 20px; color: #aaa; font-size: 13px; }
        @media (max-width: 1100px) { .two-col { grid-template-columns: 1fr; } }
        @media (max-width: 768px) { .stat-grid { grid-template-columns: 1fr 1fr; } .sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } .topbar { left: 0; } }
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
        <a href="{{ route('admin.dashboard') }}" class="nav-item active">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <!-- Menu Kelola Akun - HANYA TAMPIL UNTUK ADMIN -->
        @if((auth('admin')->check() && auth('admin')->user()->role === 'admin') || (auth('web')->check() && auth('web')->user()->role === 'admin'))
        <a href="{{ route('admin.users.index') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
            </svg>
            Kelola Akun
        </a>
        @endif
        <a href="{{ route('admin.zakat.create') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><path d="M12 4v16m8-8H4"/></svg>
            Input Data Zakat
        </a>
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
            <button type="submit" class="nav-item w-full text-left" style="border:none;background:none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>

<!-- ════════ TOPBAR ════════ -->
<header class="topbar">
    <div>
        <p style="font-size:12px;color:#888;font-weight:500;">Assalamu'alaikum</p>
        @php
            $currentUser = auth('admin')->check() ? auth('admin')->user() : auth('web')->user();
        @endphp
        <h1 class="topbar-greeting">Admin <span>{{ $currentUser->name ?? 'Ahmad' }}</span></h1>
    </div>
    <div class="topbar-spacer"></div>
    {{-- <div class="topbar-search"> --}}
        {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;color:#888;"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" placeholder="Cari transaksi, donatur..."> --}}
    {{-- </div> --}}
    {{-- <button class="notif-btn">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
    </button> --}}
    <div class="admin-chip">
        <div class="admin-avatar">{{ strtoupper(substr($currentUser->name ?? 'A', 0, 1)) }}</div>
        <span class="admin-name">{{ $currentUser->name ?? 'Admin' }}</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;color:#888;"><path d="M19 9l-7 7-7-7"/></svg>
    </div>
</header>

<!-- ════════ MAIN ════════ -->
<main class="main-content">
<div class="content-inner">

    <!-- STAT CARDS -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon green">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 3H8a2 2 0 00-2 2v2h12V5a2 2 0 00-2-2z"/></svg>
            </div>
            <div class="stat-label">Total Transaksi Hari Ini</div>
            <div class="stat-value">Rp {{ number_format($totalHariIni, 0, ',', '.') }}</div>
            <div class="stat-sub">{{ now()->translatedFormat('d F Y') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon teal">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            </div>
            <div class="stat-label">Total Bulan Ini</div>
            <div class="stat-value">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</div>
            <div class="stat-sub">{{ now()->translatedFormat('F Y') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon gold">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            </div>
            <div class="stat-label">Total Pengumpulan</div>
            <div class="stat-value">Rp {{ number_format($totalPengumpulan, 0, ',', '.') }}</div>
            <div class="stat-sub">Sepanjang {{ now()->year }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
            </div>
            <div class="stat-label">Total Donatur</div>
            <div class="stat-value">{{ $totalDonatur }} Orang</div>
            <div class="stat-sub">Donatur unik tahun {{ now()->year }}</div>
        </div>
        <div class="stat-card" style="grid-column: span 2;">
            <div class="stat-icon orange">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div class="stat-label">Total Jiwa Membayar Zakat (Bulan Ini)</div>
            <div class="stat-value">{{ number_format($totalJiwa, 0, ',', '.') }} Jiwa</div>
            <div class="stat-sub">Bulan {{ now()->translatedFormat('F Y') }}</div>
        </div>
    </div>

    <!-- TWO COLUMN -->
    <div class="two-col">

        <!-- LEFT -->
        <div style="display:flex;flex-direction:column;gap:20px;">

            <!-- Chart Bulanan -->
            <div class="card">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#1a6b3c" stroke-width="2" style="width:18px;height:18px;"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                    <h3>Grafik Pengumpulan Bulanan {{ now()->year }}</h3>
                </div>
                <div class="chart-container">
                    <canvas id="chartBulanan"></canvas>
                </div>
            </div>

            <!-- Tabel Transaksi Terbaru -->
            <div class="card">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#1a6b3c" stroke-width="2" style="width:18px;height:18px;"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <h3>Rekap Pembayaran Terbaru</h3>
                    <span style="font-size:11px;background:#e8f5ee;color:#1a6b3c;padding:2px 9px;border-radius:20px;font-weight:600;">
                        {{ $transaksi->count() }} data
                    </span>
                </div>
                <div class="filter-bar">
                    <a href="{{ route('admin.transaksi') }}?status=Belum+Lunas" class="filter-tag">⏳ Belum Lunas</a>
                    <a href="{{ route('admin.transaksi') }}?status=Batal" class="filter-tag">❌ Batal</a>
                    <div class="filter-spacer"></div>
                    <a href="{{ route('admin.laporan') }}" class="btn-export">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Export Excel
                    </a>
                </div>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Diinput Oleh</th> <!-- ← kolom baru -->
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksi as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><span style="font-weight:700;color:#1a6b3c;">{{ $row->invoice }}</span></td>
                                <td>{{ $row->nama }}</td>
                                <td style="max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $row->jenis }}">
                                    {{ $row->jenis ?: '-' }}
                                </td>
                                <td style="font-weight:700;">Rp {{ number_format($row->nominal, 0, ',', '.') }}</td>
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
                                    @if($row->input_by === 'Donatur')
                                    <span style="color:#888;font-size:12px;">🌐 Donatur Langsung</span>
                                    @else
                                    <span style="color:#1a6b3c;font-size:12px;font-weight:600;">👤 {{ $row->input_by }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.transaksi.show', $row->id) }}"
                                       style="color:#1a6b3c;font-size:12px;font-weight:600;text-decoration:none;">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="empty-state">
                                    📭 Belum ada transaksi. Data akan muncul setelah form zakat diisi.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="tbl-footer">
                    <a href="{{ route('admin.transaksi') }}" class="btn-lihat-semua">Lihat Semua</a>
                    <a href="{{ route('admin.transaksi') }}" class="tbl-footer-right">Lihat Semua &rsaquo;</a>
                </div>
            </div>

        </div><!-- /left -->

        <!-- RIGHT -->
        <div class="right-panel">

            <!-- Statistik Per Jenis -->
            <div class="card">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#1a6b3c" stroke-width="2" style="width:18px;height:18px;"><path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                    <h3>Statistik Per-Jenis <small style="font-size:11px;font-weight:500;color:#888;">(Bulan Ini)</small></h3>
                </div>
                <div class="chart-container" style="height:160px;">
                    <canvas id="chartJenis"></canvas>
                </div>
                <div class="jenis-list">
                    @php
                        $jenisColors = [
                            'Zakat Fitrah' => '#22813f',
                            'Zakat Maal'   => '#0e7490',
                            'Infaq'        => '#d97706',
                            'Yatim'        => '#7c3aed',
                            'Fidyah'       => '#dc2626',
                        ];
                        $jenisLabels = [
                            'Infaq' => 'Infaq / Shodaqoh',
                        ];
                    @endphp
                    @foreach($statJenis as $jenis => $jumlah)
                    <div class="jenis-item">
                        <div class="jenis-dot" style="background:{{ $jenisColors[$jenis] ?? '#888' }};"></div>
                        <span class="jenis-name">{{ $jenisLabels[$jenis] ?? $jenis }}</span>
                        <span class="jenis-amount">Rp {{ number_format($jumlah, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('admin.rekap') }}" class="btn-rekap">Lihat Rekap</a>
            </div>

            <!-- QRIS -->
            <div class="card">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#1a6b3c" stroke-width="2" style="width:18px;height:18px;"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3M17 17h3M14 20h3"/></svg>
                    <h3>Info Pembayaran</h3>
                </div>
                <div class="qris-card">
                    <div class="qris-inner">
                        <div class="qris-img">
                            <img src="{{ asset('icons/qris-code.png') }}"
                                 style="width:70px;height:70px;object-fit:contain;"
                                 onerror="this.outerHTML='<span style=\'font-size:10px;color:#888;text-align:center;\'>QRIS Code</span>'">
                        </div>
                        <div class="qris-info">
                            <p>🏦 Bank Syariah Indonesia (BSI)</p>
                            <strong>Rek. Infaq: 1548 734130</strong>
                            <strong>Rek. Zakat: 4504 504560</strong>
                        </div>
                    </div>
                </div>
                <a href="https://wa.me/{{ $noWa }}" target="_blank" class="btn-wa">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:17px;height:17px;"><path d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.985-1.406A9.953 9.953 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18a7.95 7.95 0 01-4.073-1.117l-.293-.175-3.037.856.808-3.102-.19-.31A7.96 7.96 0 014 12c0-4.418 3.582-8 8-8s8 3.582 8 8-3.582 8-8 8z"/></svg>
                    Kirim Ulang Invoice WA
                </a>
            </div>

        </div><!-- /right -->
    </div>

</div>
</main>

<!-- CHART.JS -->
<script>
const chartBulananData = @json($chartBulanan);
const bulanAktif = {{ now()->month - 1 }};

new Chart(document.getElementById('chartBulanan').getContext('2d'), {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'],
        datasets: [{
            data: chartBulananData,
            backgroundColor: chartBulananData.map((_, i) => i === bulanAktif ? '#1a6b3c' : '#a7d4b4'),
            borderRadius: 7, borderSkipped: false,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { ticks: { callback: v => 'Rp ' + (v/1000000).toFixed(0) + 'jt', font: { size: 10 } }, grid: { color: '#f0f0f0' } },
            x: { ticks: { font: { size: 11 } }, grid: { display: false } }
        }
    }
});

new Chart(document.getElementById('chartJenis').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: @json(array_keys($statJenis)),
        datasets: [{
            data: @json(array_values($statJenis)),
            backgroundColor: ['#22813f','#0e7490','#d97706','#7c3aed','#dc2626'],
            borderWidth: 2, borderColor: '#fff', hoverOffset: 6,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false, cutout: '65%',
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => ' Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw) } }
        }
    }
});
</script>

</body>
</html>

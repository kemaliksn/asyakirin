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

        :root {
            --green-primary: #1a6b3c;
            --green-mid:     #22813f;
            --green-light:   #2ea84f;
            --green-pale:    #e8f5ee;
            --gold:          #d4a017;
            --gold-light:    #fdf3d7;
        }

        /* ── Sidebar ── */
        .sidebar {
            background: linear-gradient(180deg, #145c33 0%, #1a6b3c 40%, #1f7d46 100%);
            width: 220px;
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            box-shadow: 4px 0 20px rgba(0,0,0,.18);
        }
        .sidebar-logo {
            padding: 20px 18px 16px;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }
        .sidebar-logo img { width: 44px; height: 44px; object-fit: contain; }
        .sidebar-logo-text h2 { color: #fff; font-size: 15px; font-weight: 700; line-height: 1.2; }
        .sidebar-logo-text p  { color: rgba(255,255,255,.65); font-size: 10.5px; margin-top: 2px; }

        .sidebar-nav { flex: 1; padding: 14px 10px; }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 10px;
            color: rgba(255,255,255,.75); font-size: 13.5px; font-weight: 500;
            cursor: pointer; transition: all .2s; margin-bottom: 3px;
            text-decoration: none;
        }
        .nav-item:hover { background: rgba(255,255,255,.12); color: #fff; }
        .nav-item.active {
            background: rgba(255,255,255,.18);
            color: #fff;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0,0,0,.12);
        }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
        .nav-badge {
            margin-left: auto;
            background: #d4a017; color: #fff;
            font-size: 10px; font-weight: 700;
            padding: 1px 7px; border-radius: 20px;
        }

        .sidebar-footer {
            padding: 14px 10px;
            border-top: 1px solid rgba(255,255,255,.12);
        }

        /* ── Topbar ── */
        .topbar {
            position: fixed; top: 0; left: 220px; right: 0; height: 64px;
            background: #fff;
            border-bottom: 1px solid #e5ede8;
            display: flex; align-items: center;
            padding: 0 28px; gap: 14px;
            z-index: 99;
            box-shadow: 0 2px 12px rgba(26,107,60,.07);
        }
        .topbar-greeting { font-size: 22px; font-weight: 800; color: #145c33; }
        .topbar-greeting span { color: #1f7d46; }
        .topbar-spacer { flex: 1; }
        .topbar-search {
            display: flex; align-items: center; gap: 8px;
            background: #f1f7f3; border-radius: 10px;
            padding: 7px 14px; border: 1px solid #d3e8da;
        }
        .topbar-search input {
            background: none; border: none; outline: none;
            font-size: 13px; color: #333; width: 180px;
        }
        .topbar-search svg { color: #888; width: 16px; height: 16px; }
        .notif-btn {
            position: relative; background: #f1f7f3;
            border: 1px solid #d3e8da; border-radius: 10px;
            padding: 8px 10px; cursor: pointer; display: flex;
        }
        .notif-btn svg { width: 18px; height: 18px; color: #555; }
        .notif-badge {
            position: absolute; top: -5px; right: -5px;
            background: #e53e3e; color: #fff;
            font-size: 9px; font-weight: 700;
            width: 18px; height: 18px;
            border-radius: 50%; display: flex;
            align-items: center; justify-content: center;
            border: 2px solid #fff;
        }
        .admin-chip {
            display: flex; align-items: center; gap: 9px;
            background: #f1f7f3; border: 1px solid #d3e8da;
            border-radius: 10px; padding: 6px 12px; cursor: pointer;
        }
        .admin-avatar {
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, #22813f, #1a6b3c);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 12px; font-weight: 700;
        }
        .admin-name { font-size: 13px; font-weight: 600; color: #222; }

        /* ── Main ── */
        .main-content {
            margin-left: 220px;
            padding-top: 64px;
            background: #f4f8f5;
            min-height: 100vh;
        }
        .content-inner { padding: 28px; }

        /* ── Stat Cards ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 22px;
        }
        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 22px 22px 18px;
            border: 1px solid #e2ece6;
            box-shadow: 0 2px 12px rgba(26,107,60,.06);
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 22px rgba(26,107,60,.12);
        }
        .stat-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 14px;
        }
        .stat-icon svg { width: 22px; height: 22px; }
        .stat-icon.green  { background: #e8f5ee; color: #1a6b3c; }
        .stat-icon.teal   { background: #e0f2f7; color: #0e7490; }
        .stat-icon.gold   { background: #fdf3d7; color: #b7860a; }
        .stat-icon.purple { background: #f3e8fd; color: #7c3aed; }
        .stat-icon.orange { background: #fff2e8; color: #c05621; }

        .stat-label { font-size: 12.5px; color: #6b7280; font-weight: 500; margin-bottom: 5px; }
        .stat-value { font-size: 22px; font-weight: 800; color: #111; line-height: 1; }
        .stat-sub   { font-size: 11.5px; color: #10b981; font-weight: 600; margin-top: 6px; }
        .stat-sub.down { color: #ef4444; }

        /* ── Two-column layout ── */
        .two-col { display: grid; grid-template-columns: 1fr 340px; gap: 20px; margin-bottom: 22px; }

        /* ── Card wrapper ── */
        .card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e2ece6;
            box-shadow: 0 2px 12px rgba(26,107,60,.05);
            overflow: hidden;
        }
        .card-header {
            padding: 18px 22px 14px;
            border-bottom: 1px solid #f0f5f1;
            display: flex; align-items: center; gap: 10px;
        }
        .card-header h3 { font-size: 15px; font-weight: 700; color: #145c33; flex: 1; }

        /* ── Filter bar ── */
        .filter-bar {
            padding: 14px 22px;
            display: flex; align-items: center; gap: 10px;
            border-bottom: 1px solid #f0f5f1;
            flex-wrap: wrap;
        }
        .filter-select {
            border: 1px solid #d3e8da; border-radius: 9px;
            padding: 7px 12px; font-size: 12.5px;
            background: #f8fdf9; color: #333; outline: none; cursor: pointer;
        }
        .btn-export {
            background: linear-gradient(135deg, #22813f, #1a6b3c);
            color: #fff; border: none; border-radius: 9px;
            padding: 8px 16px; font-size: 12.5px; font-weight: 600;
            cursor: pointer; display: flex; align-items: center; gap: 6px;
            transition: opacity .2s;
        }
        .btn-export:hover { opacity: .88; }
        .btn-search-icon {
            background: #f1f7f3; border: 1px solid #d3e8da;
            border-radius: 9px; padding: 8px 10px;
            cursor: pointer; display: flex;
        }
        .filter-spacer { flex: 1; }

        /* ── Table ── */
        .table-wrap { overflow-x: auto; }
        table.data-table { width: 100%; border-collapse: collapse; }
        table.data-table thead tr { background: #f0f7f3; }
        table.data-table th {
            padding: 11px 16px; font-size: 12px;
            font-weight: 700; color: #3d7a55;
            text-align: left; white-space: nowrap;
        }
        table.data-table td {
            padding: 12px 16px; font-size: 13px;
            color: #333; border-top: 1px solid #f3f7f4;
        }
        table.data-table tbody tr:hover { background: #f8fdf9; }
        .badge {
            display: inline-block; padding: 3px 10px;
            border-radius: 20px; font-size: 11px; font-weight: 600;
        }
        .badge.lunas  { background: #dcfce7; color: #15803d; }
        .badge.pending{ background: #fef9c3; color: #854d0e; }
        .badge.batal  { background: #fee2e2; color: #b91c1c; }

        .tbl-footer {
            padding: 14px 22px;
            display: flex; align-items: center;
            border-top: 1px solid #f0f5f1;
        }
        .btn-lihat-semua {
            background: #f1f7f3; border: 1px solid #d3e8da;
            border-radius: 8px; padding: 7px 14px;
            font-size: 12.5px; font-weight: 600; color: #1a6b3c;
            cursor: pointer; transition: background .2s;
        }
        .btn-lihat-semua:hover { background: #daf0e4; }
        .tbl-footer-right { margin-left: auto; font-size: 13px; font-weight: 600; color: #1a6b3c; cursor: pointer; }
        .tbl-footer-right:hover { text-decoration: underline; }

        /* ── Sidebar Right Panel ── */
        .right-panel { display: flex; flex-direction: column; gap: 18px; }

        /* stat per jenis */
        .jenis-list { padding: 14px 20px; }
        .jenis-item {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 0; border-bottom: 1px solid #f3f7f4;
        }
        .jenis-item:last-child { border-bottom: none; }
        .jenis-dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
        .jenis-name { font-size: 13px; color: #444; flex: 1; }
        .jenis-amount { font-size: 13px; font-weight: 700; color: #145c33; }
        .btn-rekap {
            display: block; margin: 4px 20px 16px;
            background: linear-gradient(135deg, #22813f, #1a6b3c);
            color: #fff; text-align: center; border-radius: 10px;
            padding: 11px; font-size: 13px; font-weight: 700;
            cursor: pointer; border: none; transition: opacity .2s;
        }
        .btn-rekap:hover { opacity: .88; }

        /* QRIS card */
        .qris-card { padding: 18px 20px; }
        .qris-inner {
            display: flex; align-items: center; gap: 16px;
            background: #f8fdf9; border: 1px dashed #aed4bc;
            border-radius: 12px; padding: 14px;
        }
        .qris-img {
            width: 70px; height: 70px;
            background: #e0e0e0; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; color: #888; text-align: center; flex-shrink: 0;
        }
        .qris-info p { font-size: 11px; color: #555; margin-bottom: 4px; }
        .qris-info strong { font-size: 12.5px; color: #145c33; display: block; margin-bottom: 2px; }
        .btn-wa {
            display: flex; align-items: center; gap: 8px;
            background: #25d366; color: #fff; border: none;
            border-radius: 10px; padding: 10px 16px;
            font-size: 12.5px; font-weight: 700; cursor: pointer;
            width: calc(100% - 40px); margin: 0 20px 18px;
            justify-content: center; transition: background .2s;
        }
        .btn-wa:hover { background: #1dbb59; }

        /* FAQ */
        .faq-list { padding: 4px 20px 16px; }
        .faq-item {
            padding: 10px 0;
            border-bottom: 1px solid #f3f7f4;
            font-size: 12.5px; color: #555; cursor: pointer;
            display: flex; justify-content: space-between; gap: 8px;
        }
        .faq-item:last-child { border-bottom: none; }
        .faq-item:hover { color: #1a6b3c; }
        .faq-time { color: #aaa; font-size: 11px; white-space: nowrap; }

        /* Pertanyaan Terkini */
        .question-list { padding: 4px 22px 16px; }
        .question-item {
            display: flex; align-items: flex-start; gap: 10px;
            padding: 10px 0; border-bottom: 1px solid #f3f7f4;
        }
        .question-item:last-child { border-bottom: none; }
        .q-icon {
            width: 28px; height: 28px; border-radius: 8px;
            background: #e8f5ee; display: flex; align-items: center;
            justify-content: center; flex-shrink: 0; margin-top: 1px;
        }
        .q-icon svg { width: 14px; height: 14px; color: #1a6b3c; }
        .q-text { font-size: 12.5px; color: #444; flex: 1; line-height: 1.4; }
        .q-time { font-size: 11px; color: #aaa; white-space: nowrap; margin-top: 2px; }

        /* Chart */
        .chart-container { padding: 18px 22px; height: 220px; }

        /* Responsive helpers */
        @media (max-width: 1100px) {
            .two-col { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .stat-grid { grid-template-columns: 1fr 1fr; }
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
            .topbar { left: 0; }
        }
    </style>
</head>
<body>

<!-- ════════════════════════════════════════
     SIDEBAR
════════════════════════════════════════ -->
<aside class="sidebar">

    <div class="sidebar-logo flex items-center gap-3">
        <!-- Logo placeholder — ganti dengan asset('icons/logo.png') -->
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

        <a href="{{ route('admin.transaksi') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Transaksi
            <span class="nav-badge">15</span>
        </a>

        <a href="{{ route('admin.laporan') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Laporan
        </a>

        <a href="{{ route('admin.rekap') }}" class="nav-item">
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
            <button type="submit" class="nav-item w-full text-left" style="border:none;background:none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>


<!-- ════════════════════════════════════════
     TOPBAR
════════════════════════════════════════ -->
<header class="topbar">
    <div>
        <p style="font-size:12px;color:#888;font-weight:500;">Assalamu'alaikum</p>
        <h1 class="topbar-greeting">Admin <span>{{ auth()->user()->name ?? 'Ahmad' }}</span></h1>
    </div>
    <div class="topbar-spacer"></div>

    <div class="topbar-search">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" placeholder="Cari transaksi, donatur...">
    </div>

    <button class="notif-btn">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
        <span class="notif-badge">15</span>
    </button>

    <div class="admin-chip">
        <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
        <span class="admin-name">{{ auth()->user()->name ?? 'Admin Ahmad' }}</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;color:#888;"><path d="M19 9l-7 7-7-7"/></svg>
    </div>
</header>


<!-- ════════════════════════════════════════
     MAIN CONTENT
════════════════════════════════════════ -->
<main class="main-content">
<div class="content-inner">

    <!-- ── STAT CARDS ── -->
    <div class="stat-grid">

        {{-- Card 1: Transaksi Hari Ini --}}
        <div class="stat-card">
            <div class="stat-icon green">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 3H8a2 2 0 00-2 2v2h12V5a2 2 0 00-2-2z"/></svg>
            </div>
            <div class="stat-label">Total Transaksi Hari Ini</div>
            <div class="stat-value">Rp {{ number_format($totalHariIni ?? 5500000, 0, ',', '.') }}</div>
            <div class="stat-sub">↑ +12% dari kemarin</div>
        </div>

        {{-- Card 2: Total Bulan Ini --}}
        <div class="stat-card">
            <div class="stat-icon teal">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            </div>
            <div class="stat-label">Total Bulan Ini</div>
            <div class="stat-value">Rp {{ number_format($totalBulanIni ?? 42000000, 0, ',', '.') }}</div>
            <div class="stat-sub">↑ +8% dari bulan lalu</div>
        </div>

        {{-- Card 3: Total Pengumpulan --}}
        <div class="stat-card">
            <div class="stat-icon gold">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            </div>
            <div class="stat-label">Total Pengumpulan</div>
            <div class="stat-value">Rp {{ number_format($totalPengumpulan ?? 120500000, 0, ',', '.') }}</div>
            <div class="stat-sub">Sepanjang tahun ini</div>
        </div>

        {{-- Card 4: Total Donatur --}}
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
            </div>
            <div class="stat-label">Total Donatur</div>
            <div class="stat-value">{{ $totalDonatur ?? 25 }} Orang</div>
            <div class="stat-sub">↑ +3 donatur baru</div>
        </div>

        {{-- Card 5: Total Pengtun --}}
        <div class="stat-card" style="grid-column: span 2;">
            <div class="stat-icon orange">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            </div>
            <div class="stat-label">Total Pengtun (Penerima Zakat)</div>
            <div class="stat-value">Rp {{ number_format($totalPengtun ?? 120500000, 0, ',', '.') }}</div>
            <div class="stat-sub">Tersalurkan bulan ini</div>
        </div>

    </div><!-- /stat-grid -->


    <!-- ── TWO-COLUMN ── -->
    <div class="two-col">

        <!-- LEFT: Transaksi Terbaru + Chart -->
        <div style="display:flex;flex-direction:column;gap:20px;">

            <!-- Chart Bulanan -->
            <div class="card">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#1a6b3c" stroke-width="2" style="width:18px;height:18px;"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                    <h3>Grafik Pengumpulan Bulanan</h3>
                    <select class="filter-select" style="font-size:11.5px;padding:5px 10px;">
                        <option>2026</option>
                        <option>2025</option>
                    </select>
                </div>
                <div class="chart-container">
                    <canvas id="chartBulanan"></canvas>
                </div>
            </div>

            <!-- Rekap Pembayaran Terbaru -->
            <div class="card">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#1a6b3c" stroke-width="2" style="width:18px;height:18px;"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <h3>Rekap Pembayaran Terbaru</h3>
                </div>

                <div class="filter-bar">
                    <select class="filter-select">
                        <option>Semua Jenis</option>
                        <option>Zakat Fitrah</option>
                        <option>Zakat Maal</option>
                        <option>Infaq - Shodaqoh</option>
                        <option>Yatim</option>
                        <option>Fidyah</option>
                    </select>
                    <select class="filter-select" id="filterTanggal">
                        <option>{{ now()->format('d F Y') }}</option>
                        <option>Kemarin</option>
                        <option>7 Hari Terakhir</option>
                        <option>Bulan Ini</option>
                    </select>
                    <select class="filter-select">
                        <option>Semua Status</option>
                        <option>Lunas</option>
                        <option>Pending</option>
                        <option>Batal</option>
                    </select>
                    <button class="btn-export">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Export Excel
                    </button>
                    <div class="filter-spacer"></div>
                    <button class="btn-search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#555" stroke-width="2" style="width:15px;height:15px;"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    </button>
                </div>

                <div class="table-wrap">
                    <table class="data-table">
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
                            @forelse($transaksi ?? [] as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><span style="font-weight:700;color:#1a6b3c;">{{ $row->invoice }}</span></td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->jenis }}</td>
                                <td style="font-weight:700;">Rp {{ number_format($row->nominal, 0, ',', '.') }}</td>
                                <td><span class="badge {{ strtolower($row->status) }}">{{ $row->status }}</span></td>
                                <td style="color:#888;">{{ $row->tanggal }}</td>
                                <td>
                                    <a href="{{ route('admin.transaksi.show', $row->id) }}"
                                       style="color:#1a6b3c;font-size:12px;font-weight:600;text-decoration:none;">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <!-- Data dummy untuk preview -->
                            <tr>
                                <td>1</td>
                                <td><span style="font-weight:700;color:#1a6b3c;">ZIS-010</span></td>
                                <td>Ahmad</td>
                                <td>Zakat Fitrah</td>
                                <td style="font-weight:700;">Rp 900.000</td>
                                <td><span class="badge lunas">Lunas</span></td>
                                <td style="color:#888;">Hari ini</td>
                                <td><a href="#" style="color:#1a6b3c;font-size:12px;font-weight:600;text-decoration:none;">Detail</a></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><span style="font-weight:700;color:#1a6b3c;">ZIS-010</span></td>
                                <td>Ahmad</td>
                                <td>Zakat Fitrah</td>
                                <td style="font-weight:700;">Rp 500.000</td>
                                <td><span class="badge lunas">Lunas</span></td>
                                <td style="color:#888;">23 April 2026</td>
                                <td><a href="#" style="color:#1a6b3c;font-size:12px;font-weight:600;text-decoration:none;">Detail</a></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><span style="font-weight:700;color:#1a6b3c;">ZIS-011</span></td>
                                <td>Ahmad</td>
                                <td>Infaq / Shodaqoh</td>
                                <td style="font-weight:700;">Rp 500.000</td>
                                <td><span class="badge lunas">Lunas</span></td>
                                <td style="color:#888;">Hari ini</td>
                                <td><a href="#" style="color:#1a6b3c;font-size:12px;font-weight:600;text-decoration:none;">Detail</a></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><span style="font-weight:700;color:#1a6b3c;">ZIS-010</span></td>
                                <td>Aisyah</td>
                                <td>Fidyah</td>
                                <td style="font-weight:700;">Rp 200.000</td>
                                <td><span class="badge lunas">Lunas</span></td>
                                <td style="color:#888;">23 April 2026</td>
                                <td><a href="#" style="color:#1a6b3c;font-size:12px;font-weight:600;text-decoration:none;">Detail</a></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><span style="font-weight:700;color:#1a6b3c;">ZIS-006</span></td>
                                <td>Ust. Umar</td>
                                <td>Zakat Fitrah</td>
                                <td style="font-weight:700;">Rp 600.000</td>
                                <td><span class="badge lunas">Lunas</span></td>
                                <td style="color:#888;">Hari ini</td>
                                <td><a href="#" style="color:#1a6b3c;font-size:12px;font-weight:600;text-decoration:none;">Detail</a></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="tbl-footer">
                    <button class="btn-lihat-semua" onclick="window.location='{{ route('admin.transaksi') }}'">Lihat Semua</button>
                    <span class="tbl-footer-right" onclick="window.location='{{ route('admin.transaksi') }}'">Lihat Semua &rsaquo;</span>
                </div>
            </div><!-- /card transaksi -->

            <!-- Pertanyaan Terkini -->
            <div class="card">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#1a6b3c" stroke-width="2" style="width:18px;height:18px;"><path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    <h3>Pertanyaan Terkini</h3>
                    <span style="font-size:11px;background:#fef9c3;color:#854d0e;padding:2px 9px;border-radius:20px;font-weight:600;">3 Baru</span>
                </div>
                <div class="question-list">
                    <div class="question-item">
                        <div class="q-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3M12 17h.01"/></svg>
                        </div>
                        <div style="flex:1;">
                            <div class="q-text">Bagaimana menghitung zakat maal?</div>
                            <div class="q-time">‣ 1 Menit lalu</div>
                        </div>
                    </div>
                    <div class="question-item">
                        <div class="q-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3M12 17h.01"/></svg>
                        </div>
                        <div style="flex:1;">
                            <div class="q-text">Siapa yang berhak menerima zakat?</div>
                            <div class="q-time">‣ 1 Menit lalu</div>
                        </div>
                    </div>
                    <div class="question-item">
                        <div class="q-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3M12 17h.01"/></svg>
                        </div>
                        <div style="flex:1;">
                            <div class="q-text">Kapan batas pembayaran zakat fitrah?</div>
                            <div class="q-time">‣ 5 Menit lalu</div>
                        </div>
                    </div>
                </div>
            </div><!-- /pertanyaan -->

        </div><!-- /left col -->


        <!-- RIGHT: Stats per jenis + QRIS + FAQ -->
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
                    <div class="jenis-item">
                        <div class="jenis-dot" style="background:#22813f;"></div>
                        <span class="jenis-name">Zakat Fitrah</span>
                        <span class="jenis-amount">Rp {{ number_format($statJenis['Zakat Fitrah'] ?? 7200000, 0, ',', '.') }}</span>
                    </div>
                    <div class="jenis-item">
                        <div class="jenis-dot" style="background:#0e7490;"></div>
                        <span class="jenis-name">Zakat Maal</span>
                        <span class="jenis-amount">Rp {{ number_format($statJenis['Zakat Maal'] ?? 25500000, 0, ',', '.') }}</span>
                    </div>
                    <div class="jenis-item">
                        <div class="jenis-dot" style="background:#d97706;"></div>
                        <span class="jenis-name">Infaq / Shodaqoh</span>
                        <span class="jenis-amount">Rp {{ number_format($statJenis['Infaq'] ?? 5800000, 0, ',', '.') }}</span>
                    </div>
                    <div class="jenis-item">
                        <div class="jenis-dot" style="background:#7c3aed;"></div>
                        <span class="jenis-name">Yatim</span>
                        <span class="jenis-amount">Rp {{ number_format($statJenis['Yatim'] ?? 1000000, 0, ',', '.') }}</span>
                    </div>
                    <div class="jenis-item">
                        <div class="jenis-dot" style="background:#dc2626;"></div>
                        <span class="jenis-name">Fidyah</span>
                        <span class="jenis-amount">Rp {{ number_format($statJenis['Fidyah'] ?? 2500000, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button class="btn-rekap" onclick="window.location='{{ route('admin.rekap') }}'">
                    Lihat Rekap
                </button>
            </div>

            <!-- QRIS Card -->
            <div class="card">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#1a6b3c" stroke-width="2" style="width:18px;height:18px;"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3M17 17h3M14 20h3"/></svg>
                    <h3>Info Pembayaran</h3>
                </div>
                <div class="qris-card">
                    <div class="qris-inner">
                        <div class="qris-img">
                            {{-- Ganti dengan: <img src="{{ asset('icons/qris-code.png') }}" style="width:70px;height:70px;border-radius:8px;"> --}}
                            <span>QRIS<br>Code</span>
                        </div>
                        <div class="qris-info">
                            <p>🏦 QRIS Scan Tasu Aplikasi</p>
                            <strong>Rek. Infaq: 1548 734130</strong>
                            <strong>Rek. Zakat: 4504 504560</strong>
                            <p style="margin-top:6px;">Bank Syariah Indonesia (BSI)</p>
                        </div>
                    </div>
                </div>
                <button class="btn-wa" onclick="window.open('https://wa.me/{{ $noWa ?? '6281234567890' }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:17px;height:17px;"><path d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.985-1.406A9.953 9.953 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18a7.95 7.95 0 01-4.073-1.117l-.293-.175-3.037.856.808-3.102-.19-.31A7.96 7.96 0 014 12c0-4.418 3.582-8 8-8s8 3.582 8 8-3.582 8-8 8zm4.406-5.845c-.243-.122-1.437-.713-1.66-.795-.222-.08-.384-.122-.546.122-.162.243-.628.795-.77.957-.142.162-.283.182-.525.06-.243-.122-1.025-.378-1.952-1.205-.722-.643-1.209-1.437-1.351-1.68-.142-.243-.015-.373.107-.494.11-.108.243-.283.365-.425.121-.142.162-.243.243-.405.08-.162.04-.304-.02-.426-.06-.122-.546-1.316-.748-1.802-.197-.473-.397-.409-.546-.416H8.568c-.162 0-.426.06-.648.304-.222.243-.85.832-.85 2.027s.87 2.351.99 2.513c.122.162 1.712 2.613 4.148 3.664.58.25 1.032.4 1.384.512.582.185 1.112.159 1.531.097.467-.07 1.437-.587 1.64-1.154.202-.567.202-1.053.142-1.154-.06-.102-.222-.162-.465-.284z"/></svg>
                    Kirim Ulang Invoice WA
                </button>
            </div>

            <!-- FAQ -->
            <div class="card">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#1a6b3c" stroke-width="2" style="width:18px;height:18px;"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3M12 17h.01"/></svg>
                    <h3>FAQ</h3>
                </div>
                <div class="faq-list">
                    <div class="faq-item">
                        <span>✅ Bagaimana menghitung zakat maal?</span>
                        <span class="faq-time">Terjawab</span>
                    </div>
                    <div class="faq-item">
                        <span>✅ Siapa yang berhak menerima zakat?</span>
                        <span class="faq-time">Terjawab</span>
                    </div>
                    <div class="faq-item">
                        <span>❓ Apa bedanya zakat fitrah & maal?</span>
                        <span class="faq-time">Belum</span>
                    </div>
                    <div class="faq-item">
                        <span>❓ Berapa nisab zakat penghasilan?</span>
                        <span class="faq-time">Belum</span>
                    </div>
                </div>
            </div>

        </div><!-- /right-panel -->
    </div><!-- /two-col -->

</div><!-- /content-inner -->
</main>


<!-- ════════════════════════════════════════
     CHART.JS
════════════════════════════════════════ -->
<script>
// ── Chart Bulanan ──
const ctxBulanan = document.getElementById('chartBulanan').getContext('2d');
new Chart(ctxBulanan, {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'],
        datasets: [{
            label: 'Pengumpulan (Rp)',
            data: [
                {{ $chartBulanan[0] ?? 8000000 }},
                {{ $chartBulanan[1] ?? 9500000 }},
                {{ $chartBulanan[2] ?? 7000000 }},
                {{ $chartBulanan[3] ?? 42000000 }},
                {{ $chartBulanan[4] ?? 12000000 }},
                {{ $chartBulanan[5] ?? 11000000 }},
                {{ $chartBulanan[6] ?? 9000000 }},
                {{ $chartBulanan[7] ?? 8500000 }},
                {{ $chartBulanan[8] ?? 10000000 }},
                {{ $chartBulanan[9] ?? 7500000 }},
                {{ $chartBulanan[10] ?? 6000000 }},
                {{ $chartBulanan[11] ?? 0 }},
            ],
            backgroundColor: function(ctx) {
                return ctx.dataIndex === 3 ? '#1a6b3c' : '#a7d4b4';
            },
            borderRadius: 7,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                ticks: {
                    callback: v => 'Rp ' + (v/1000000).toFixed(0) + 'jt',
                    font: { size: 10 }
                },
                grid: { color: '#f0f0f0' }
            },
            x: { ticks: { font: { size: 11 } }, grid: { display: false } }
        }
    }
});

// ── Chart Donut Per Jenis ──
const ctxJenis = document.getElementById('chartJenis').getContext('2d');
new Chart(ctxJenis, {
    type: 'doughnut',
    data: {
        labels: ['Zakat Fitrah','Zakat Maal','Infaq/Shodaqoh','Yatim','Fidyah'],
        datasets: [{
            data: [
                {{ $statJenis['Zakat Fitrah'] ?? 7200000 }},
                {{ $statJenis['Zakat Maal'] ?? 25500000 }},
                {{ $statJenis['Infaq'] ?? 5800000 }},
                {{ $statJenis['Yatim'] ?? 1000000 }},
                {{ $statJenis['Fidyah'] ?? 2500000 }},
            ],
            backgroundColor: ['#22813f','#0e7490','#d97706','#7c3aed','#dc2626'],
            borderWidth: 2,
            borderColor: '#fff',
            hoverOffset: 6,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ' Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw)
                }
            }
        }
    }
});
</script>

</body>
</html>
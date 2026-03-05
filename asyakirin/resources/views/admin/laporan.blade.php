<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - ASY-SYAAKIRIIN</title>
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
        .content-inner { padding: 28px; max-width: 1200px; }
        .page-title { font-size: 26px; font-weight: 800; color: #111; margin-bottom: 8px; }
        .page-title span { color: #1a6b3c; }
        .page-subtitle { font-size: 13px; color: #888; margin-bottom: 22px; }
        .filter-card { background: #fff; border: 1px solid #e2ece6; border-radius: 14px; padding: 20px; margin-bottom: 20px; }
        .filter-title { font-size: 14px; font-weight: 700; color: #1a6b3c; margin-bottom: 16px; }
        .filter-group { display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 12px; align-items: flex-end; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-label { font-size: 12px; font-weight: 600; color: #333; }
        .form-input, .form-select { border: 1px solid #d3e8da; border-radius: 8px; padding: 10px 12px; font-size: 13px; background: #f8fdf9; color: #333; outline: none; font-family: inherit; }
        .form-input:focus, .form-select:focus { border-color: #1a6b3c; background: #fff; }
        .btn-filter { background: linear-gradient(135deg, #22813f, #1a6b3c); color: #fff; border: none; border-radius: 8px; padding: 10px 20px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit; }
        .btn-filter:hover { opacity: .88; }
        .btn-reset { background: #f1f7f3; color: #555; border: 1px solid #d3e8da; border-radius: 8px; padding: 10px 20px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: inherit; margin-left: 6px; }
        .btn-reset:hover { background: #daf0e4; }
        .btn-export { background: #ff9800; color: #fff; border: none; border-radius: 8px; padding: 10px 20px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: inherit; display: inline-flex; align-items: center; gap: 6px; }
        .btn-export:hover { opacity: .88; }
        .table-card { background: #fff; border: 1px solid #e2ece6; border-radius: 14px; overflow: hidden; }
        .table-wrap { overflow-x: auto; }
        table.data-table { width: 100%; border-collapse: collapse; }
        table.data-table th { background: #f0f7f3; padding: 12px 14px; font-size: 12px; font-weight: 700; color: #3d7a55; text-align: left; border-bottom: 1px solid #e2ece6; }
        table.data-table td { padding: 12px 14px; font-size: 13px; border-bottom: 1px solid #f0f7f3; }
        table.data-table tr:hover { background: #f8fdf9; }
        .empty-state { text-align: center; padding: 40px 20px; color: #888; font-size: 14px; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo flex items-center gap-3">
        <div style="width:44px;height:44px;background:rgba(255,255,255,.15);border-radius:10px;display:flex;align-items:center;justify-content:center;">
            <img style="width:50px; margin-bottom:3px" src="{{ asset('icons/logomasjid.png') }}" alt="Logo Asy-Syaakiriin">
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
        <a href="{{ route('admin.rekap') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
            Rekap
        </a>
        <a href="{{ route('admin.laporan') }}" class="nav-item active">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Laporan
        </a>
    </nav>
    <div class="sidebar-footer">
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
        <span style="font-size:13px;font-weight:600;color:#1a6b3c;">Laporan</span>
    </div>
</header>

<!-- MAIN -->
<main class="main-content">
<div class="content-inner">

    <h1 class="page-title">Laporan <span>Zakat</span></h1>
    <p class="page-subtitle">Filter dan download laporan pembayaran zakat</p>

    <!-- FILTER CARD -->
    <div class="filter-card">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div class="filter-title">🔍 Filter Data</div>
            @if(request('tanggal') || request('nama_kasir'))
            <a href="{{ route('admin.laporan') }}" class="btn-reset">Reset Filter</a>
            @endif
        </div>

        <form method="GET" action="{{ route('admin.laporan') }}" style="margin-top:14px;">
            <div class="filter-group">
                <div class="form-group">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-input" value="{{ request('tanggal', '') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Kasir</label>
                    <select name="nama_kasir" class="form-select">
                        <option value="">-- Semua Kasir --</option>
                        @foreach($daftarKasir as $kasir)
                            <option value="{{ $kasir }}" {{ request('nama_kasir') == $kasir ? 'selected' : '' }}>
                                {{ $kasir }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div></div>

                <div style="display:flex;gap:8px;">
                    <button type="submit" class="btn-filter">🔍 Terapkan Filter</button>
                    <a href="{{ route('admin.laporan') }}?export=excel{{ request('tanggal') ? '&tanggal=' . request('tanggal') : '' }}{{ request('nama_kasir') ? '&nama_kasir=' . request('nama_kasir') : '' }}" class="btn-export">
                        📥 Export Excel
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- DATA TABLE -->
    <div class="table-card">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomor</th>
                        <th>Nama Muzakki</th>
                        <th>Jenis Zakat</th>
                        <th>Total Uang (Rp)</th>
                        <th>Total Beras (Kg)</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Diinput Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $i => $row)
                    <tr>
                        <td style="font-weight:600;color:#1a6b3c;">{{ $i + 1 }}</td>
                        <td>{{ $row->nomor }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->jenis ?: '-' }}</td>
                        <td style="text-align:right;">{{ number_format($row->total_uang, 0, ',', '.') }}</td>
                        <td style="text-align:right;">{{ number_format($row->total_beras, 1, ',', '.') }}</td>
                        <td>
                            <span style="
                                display:inline-block;
                                padding:4px 10px;
                                border-radius:6px;
                                font-size:12px;
                                font-weight:600;
                                {{ $row->status === 'Lunas' ? 'background:#dcfce7;color:#15803d;' : ($row->status === 'Belum Lunas' ? 'background:#fef3c7;color:#a16207;' : 'background:#fecaca;color:#991b1b;') }}
                            ">
                                {{ $row->status }}
                            </span>
                        </td>
                        <td nowrap>{{ $row->tanggal }}</td>
                        <td>
                            <span style="{{ $row->input_by === 'Donatur' ? 'color:#888;' : 'color:#1a6b3c;font-weight:600;' }}">
                                {{ $row->input_by === 'Donatur' ? '🌐 ' : '👤 ' }}{{ $row->input_by }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="empty-state">
                            📭 Tidak ada data yang sesuai dengan filter
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top:14px;font-size:12px;color:#888;">
        Total: <strong>{{ $transaksi->count() }} data</strong>
    </div>

</div>
</main>

</body>
</html>

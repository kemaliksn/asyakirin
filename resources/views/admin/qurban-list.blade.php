<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Qurban - ASY-SYAAKIRIIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('icons/logomasjid.png') }}">
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
        .admin-chip { display: flex; align-items: center; gap: 9px; background: #f1f7f3; border: 1px solid #d3e8da; border-radius: 10px; padding: 6px 12px; cursor: pointer; }
        .admin-avatar { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, #22813f, #1a6b3c); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 12px; font-weight: 700; }

        .main-content { margin-left: 220px; padding-top: 64px; background: #f4f8f5; min-height: 100vh; }
        .content-inner { padding: 28px; }

        .breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 12.5px; color: #888; margin-bottom: 16px; }
        .breadcrumb a { color: #888; text-decoration: none; }
        .breadcrumb a:hover { color: #1a6b3c; }
        .breadcrumb .sep { color: #ccc; }
        .breadcrumb .active { color: #1a6b3c; font-weight: 600; }

        .page-title { font-size: 26px; font-weight: 800; color: #111; margin-bottom: 22px; }
        .page-title span { color: #1a6b3c; }

        .stat-cards { display: grid; grid-template-columns: repeat(5, 1fr); gap: 14px; margin-bottom: 24px; }
        .stat-card { background: #fff; border-radius: 14px; padding: 18px 16px; border: 1px solid #e2ece6; box-shadow: 0 2px 10px rgba(26,107,60,.05); }
        .stat-label { font-size: 11.5px; color: #888; font-weight: 500; margin-bottom: 8px; }
        .stat-value { font-size: 24px; font-weight: 800; color: #1a6b3c; }
        .stat-card.total { border-left: 4px solid #1a6b3c; }
        .stat-card.lunas { border-left: 4px solid #38a169; }
        .stat-card.belum { border-left: 4px solid #ed8936; }
        .stat-card.batal { border-left: 4px solid #f56565; }

        .filter-card { background: #fff; border-radius: 14px; border: 1px solid #e2ece6; padding: 16px 20px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; box-shadow: 0 2px 10px rgba(26,107,60,.05); }
        .filter-input { border: 1px solid #d3e8da; border-radius: 9px; padding: 8px 14px; font-size: 13px; background: #f8fdf9; color: #333; outline: none; font-family: inherit; }
        .filter-select { border: 1px solid #d3e8da; border-radius: 9px; padding: 8px 12px; font-size: 13px; background: #f8fdf9; color: #333; outline: none; cursor: pointer; font-family: inherit; }
        .btn-filter { background: linear-gradient(135deg, #22813f, #1a6b3c); color: #fff; border: none; border-radius: 9px; padding: 8px 16px; font-size: 13px; font-weight: 700; cursor: pointer; transition: opacity .2s; font-family: inherit; }
        .btn-filter:hover { opacity: .88; }
        .btn-reset { background: #f1f7f3; border: 1px solid #d3e8da; border-radius: 9px; padding: 8px 14px; font-size: 13px; font-weight: 600; color: #555; cursor: pointer; font-family: inherit; text-decoration: none; }
        .btn-reset:hover { background: #daf0e4; }

        .table-card { background: #fff; border-radius: 14px; border: 1px solid #e2ece6; overflow: hidden; box-shadow: 0 2px 10px rgba(26,107,60,.05); }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f8fdf9; }
        th { padding: 14px 16px; text-align: left; font-size: 12.5px; font-weight: 700; color: #555; border-bottom: 1px solid #e2ece6; white-space: nowrap; }
        td { padding: 12px 16px; border-bottom: 1px solid #e2ece6; font-size: 13px; color: #333; }
        tbody tr:hover { background: #f8fdf9; }
        tbody tr:last-child td { border-bottom: none; }

        .status-badge { display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; }
        .status-lunas { background: #c6f6d5; color: #22543d; }
        .status-belum { background: #feebc8; color: #7c2d12; }
        .status-batal { background: #fed7d7; color: #742a2a; }

        .action-btn { padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none; cursor: pointer; border: none; display: inline-block; transition: .2s; }
        .action-lihat { background: #e6f3ff; color: #1a4b6b; }
        .action-lihat:hover { background: #b3d9ff; }
        .action-edit { background: #fffde6; color: #6b5a14; }
        .action-edit:hover { background: #ffffb3; }
        .action-delete { background: #ffe6e6; color: #6b1414; }
        .action-delete:hover { background: #ffb3b3; }

        .pagination { display: flex; align-items: center; justify-content: center; gap: 6px; margin-top: 20px; padding: 20px 0; }
        .pagination a, .pagination span { padding: 8px 10px; border-radius: 6px; font-size: 12px; text-decoration: none; }
        .pagination a { background: #fff; border: 1px solid #d3e8da; color: #1a6b3c; cursor: pointer; }
        .pagination a:hover { background: #f1f7f3; }
        .pagination .active { background: #1a6b3c; color: #fff; border-color: #1a6b3c; }
    </style>
</head>
<body class="bg-gray-50">

{{-- SIDEBAR --}}
<div class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-text">
            <h2>ASY-SYAAKIRIIN</h2>
            <p>Admin Dashboard</p>
        </div>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v7a1 1 0 001 1h12a1 1 0 001-1V9m-9 4v4m0 0H9m3 0h3" /></svg>
            Dashboard
        </a>
        <a href="{{ route('admin.rekap') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            Rekap Zakat
        </a>
        <a href="{{ route('admin.qurban') }}" class="nav-item active">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            Data Qurban
        </a>
    </nav>
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-item" style="width: 100%; text-align: left;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                Logout
            </button>
        </form>
    </div>
</div>

{{-- TOPBAR --}}
<div class="topbar">
    <div style="flex: 1;"></div>
    <div class="admin-chip">
        <div class="admin-avatar">{{ substr(auth('admin')->user()->name ?? auth('web')->user()->name, 0, 1) }}</div>
        <div>
            <div style="font-size: 12px; font-weight: 600; color: #333;">{{ auth('admin')->user()->name ?? auth('web')->user()->name }}</div>
            <div style="font-size: 11px; color: #888;">{{ ucfirst(auth('admin')->user()->role ?? auth('web')->user()->role) }}</div>
        </div>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="main-content">
    <div class="content-inner">
        {{-- Breadcrumb --}}
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="sep">›</span>
            <span class="active">Data Qurban</span>
        </div>

        {{-- Page Title --}}
        <h1 class="page-title">Data Pembayaran <span>Qurban</span></h1>

        {{-- Stat Cards --}}
        <div class="stat-cards">
            <div class="stat-card total">
                <div class="stat-label">Total Pembayaran</div>
                <div class="stat-value">{{ $totalRecord }}</div>
            </div>
            <div class="stat-card lunas">
                <div class="stat-label">Lunas</div>
                <div class="stat-value">{{ $lunas }}</div>
            </div>
            <div class="stat-card belum">
                <div class="stat-label">Belum Lunas</div>
                <div class="stat-value">{{ $belumLunas }}</div>
            </div>
            <div class="stat-card batal">
                <div class="stat-label">Batal</div>
                <div class="stat-value">{{ $batal }}</div>
            </div>
            <div class="stat-card total">
                <div class="stat-label">Total Uang</div>
                <div class="stat-value" style="font-size: 16px;">Rp {{ number_format($totalUang, 0, ',', '.') }}</div>
            </div>
        </div>

        {{-- Filter --}}
        <form method="GET" action="{{ route('admin.qurban') }}" class="filter-card">
            <input type="text" name="nama" placeholder="Cari nama pembayar..." class="filter-input" value="{{ request('nama') }}">
            <select name="status" class="filter-select">
                <option value="">-- Status --</option>
                <option value="Lunas" {{ request('status') === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="Belum Lunas" {{ request('status') === 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                <option value="Batal" {{ request('status') === 'Batal' ? 'selected' : '' }}>Batal</option>
            </select>
            <input type="date" name="dari_tanggal" class="filter-input" value="{{ request('dari_tanggal') }}" placeholder="Dari tanggal">
            <input type="date" name="sampai_tanggal" class="filter-input" value="{{ request('sampai_tanggal') }}" placeholder="Sampai tanggal">
            <div style="flex: 1;"></div>
            <button type="submit" class="btn-filter">Cari</button>
            <a href="{{ route('admin.qurban') }}" class="btn-reset">Reset</a>
        </form>

        {{-- Table --}}
        <div class="table-card">
            @if($qurbans->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>No. Referensi</th>
                        <th>Nama Pembayar</th>
                        <th>Telpon</th>
                        <th>Tanggal</th>
                        <th>Total Uang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($qurbans as $qurban)
                    <tr>
                        <td>{{ $qurban->nomor }}</td>
                        <td>{{ $qurban->nama }}</td>
                        <td>{{ $qurban->telpon }}</td>
                        <td>{{ $qurban->tanggal?->format('d M Y') ?? '-' }}</td>
                        <td>Rp {{ number_format($qurban->total_uang, 0, ',', '.') }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $qurban->status)) }}">
                                {{ $qurban->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.qurban.show', $qurban->id) }}" class="action-btn action-lihat">Lihat</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="pagination">
                @if($qurbans->onFirstPage())
                    <span>«</span>
                @else
                    <a href="{{ $qurbans->previousPageUrl() }}">«</a>
                @endif

                @foreach($qurbans->getUrlRange(max(1, $qurbans->currentPage() - 2), min($qurbans->lastPage(), $qurbans->currentPage() + 2)) as $page => $url)
                    @if($page == $qurbans->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($qurbans->hasMorePages())
                    <a href="{{ $qurbans->nextPageUrl() }}">»</a>
                @else
                    <span>»</span>
                @endif
            </div>
            @else
            <div style="padding: 40px; text-align: center; color: #888;">
                <p style="font-size: 14px;">Tidak ada data qurban</p>
            </div>
            @endif
        </div>
    </div>
</div>

</body>
</html>

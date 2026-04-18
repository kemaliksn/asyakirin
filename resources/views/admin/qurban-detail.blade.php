<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Qurban - ASY-SYAAKIRIIN</title>
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
        .breadcrumb .sep { color: #ccc; }
        .breadcrumb .active { color: #1a6b3c; font-weight: 600; }

        .page-title { font-size: 26px; font-weight: 800; color: #111; margin-bottom: 22px; }

        .form-card { background: #fff; border-radius: 14px; border: 1px solid #e2ece6; padding: 28px; box-shadow: 0 2px 10px rgba(26,107,60,.05); margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 700; color: #333; margin-bottom: 6px; }
        .form-input, .form-select { width: 100%; border: 1px solid #d3e8da; border-radius: 8px; padding: 10px 12px; font-size: 13px; background: #f8fdf9; color: #333; outline: none; font-family: inherit; }
        .form-input:focus, .form-select:focus { border-color: #1a6b3c; background: #fff; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }

        .status-badge { display: inline-block; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; }
        .status-lunas { background: #c6f6d5; color: #22543d; }
        .status-belum { background: #feebc8; color: #7c2d12; }
        .status-batal { background: #fed7d7; color: #742a2a; }

        .info-box { background: #f1f7f3; border-left: 4px solid #1a6b3c; border-radius: 8px; padding: 14px; margin-bottom: 20px; }
        .info-label { font-size: 11px; color: #888; font-weight: 600; text-transform: uppercase; margin-bottom: 4px; }
        .info-value { font-size: 16px; font-weight: 700; color: #1a6b3c; }

        .btn-submit { background: linear-gradient(135deg, #22813f, #1a6b3c); color: #fff; border: none; border-radius: 8px; padding: 12px 24px; font-size: 13px; font-weight: 700; cursor: pointer; transition: opacity .2s; font-family: inherit; }
        .btn-submit:hover { opacity: .88; }
        .btn-back { background: #f1f7f3; border: 1px solid #d3e8da; border-radius: 8px; padding: 12px 24px; font-size: 13px; font-weight: 700; color: #555; cursor: pointer; font-family: inherit; text-decoration: none; display: inline-block; }
        .btn-back:hover { background: #daf0e4; }
        .btn-print { background: #e6f3ff; color: #1a4b6b; border: none; border-radius: 8px; padding: 12px 24px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit; }
        .btn-print:hover { background: #b3d9ff; }
        .btn-delete { background: #ffe6e6; color: #6b1414; border: none; border-radius: 8px; padding: 12px 24px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit; }
        .btn-delete:hover { background: #ffb3b3; }

        .button-group { display: flex; gap: 10px; margin-top: 28px; }
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
            <a href="{{ route('admin.qurban') }}">Data Qurban</a>
            <span class="sep">›</span>
            <span class="active">{{ $qurban->nomor }}</span>
        </div>

        {{-- Messages --}}
        @if(session('success'))
        <div style="background: #c6f6d5; border: 1px solid #9ae6b4; color: #22543d; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;">
            {{ session('success') }}
        </div>
        @endif

        {{-- Page Title --}}
        <h1 class="page-title">Detail Pembayaran Qurban</h1>

        {{-- Info Boxes --}}
        <div class="grid-3" style="margin-bottom: 24px;">
            <div class="info-box">
                <div class="info-label">No. Referensi</div>
                <div class="info-value">{{ $qurban->nomor }}</div>
            </div>
            <div class="info-box">
                <div class="info-label">Status</div>
                <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $qurban->status)) }}">
                    {{ $qurban->status }}
                </span>
            </div>
            <div class="info-box">
                <div class="info-label">Total Uang</div>
                <div class="info-value">Rp {{ number_format($qurban->total_uang, 0, ',', '.') }}</div>
            </div>
        </div>

        {{-- Form Edit --}}
        <form method="POST" action="{{ route('admin.qurban.update', $qurban->id) }}" class="form-card" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h2 style="font-size: 18px; font-weight: 700; color: #111; margin-bottom: 20px;">Informasi Pembayar</h2>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Nama Pembayar *</label>
                    <input type="text" name="nama" class="form-input" value="{{ $qurban->nama }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">No. Telpon *</label>
                    <input type="text" name="telpon" class="form-input" value="{{ $qurban->telpon }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-input" value="{{ $qurban->alamat }}">
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Profesi</label>
                    <input type="text" name="profesi" class="form-input" value="{{ $qurban->profesi }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Status Pembayaran *</label>
                    <select name="status" class="form-select" required>
                        <option value="Lunas" {{ $qurban->status === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="Belum Lunas" {{ $qurban->status === 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                        <option value="Batal" {{ $qurban->status === 'Batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Tanggal *</label>
                <input type="date" name="tanggal" class="form-input" value="{{ $qurban->tanggal?->format('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Upload Bukti Pembayaran (Opsional)</label>
                <input type="file" name="bukti" class="form-input" accept="image/*">
                @if($qurban->bukti)
                <p style="font-size: 12px; color: #888; margin-top: 8px;">File saat ini: {{ basename($qurban->bukti) }}</p>
                @endif
            </div>

            <h3 style="font-size: 16px; font-weight: 700; color: #111; margin-top: 28px; margin-bottom: 16px;">Detail Qurban</h3>
            <div style="background: #f8fdf9; border: 1px solid #e2ece6; border-radius: 8px; padding: 14px; margin-bottom: 20px;">
                @foreach($qurban->items ?? [] as $item)
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e2ece6;">
                    <div>
                        <div style="font-weight: 600; color: #333;">{{ $item['jenis'] ?? '' }}</div>
                        <div style="font-size: 12px; color: #888;">{{ $item['keterangan'] ?? '' }}</div>
                    </div>
                    <div style="font-weight: 700; color: #1a6b3c;">Rp {{ number_format($item['uang'] ?? 0, 0, ',', '.') }}</div>
                </div>
                @endforeach
                <div style="display: flex; justify-content: space-between; padding: 12px 0; border-top: 2px solid #1a6b3c; margin-top: 8px; font-weight: 700; color: #1a6b3c;">
                    <span>Total</span>
                    <span>Rp {{ number_format($qurban->total_uang, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Button Group --}}
            <div class="button-group">
                <a href="{{ route('admin.qurban') }}" class="btn-back">← Kembali</a>
                <button type="submit" class="btn-submit">💾 Simpan Perubahan</button>
                <a href="{{ route('qurban.cetak-ulang', $qurban->id) }}" target="_blank" class="btn-print">🖨️ Cetak Invoice</a>
                <form action="{{ route('admin.qurban.destroy', $qurban->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?')">🗑️ Hapus</button>
                </form>
            </div>
        </form>
    </div>
</div>

</body>
</html>

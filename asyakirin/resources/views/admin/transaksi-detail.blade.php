<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi - ASY-SYAAKIRIIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* copy same styles from rekap for sidebar/topbar/main etc */
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
        .notif-btn { position: relative; background: #f1f7f3; border: 1px solid #d3e8da; border-radius: 10px; padding: 8px 10px; cursor: pointer; display: flex; }
        .notif-btn svg { width: 18px; height: 18px; color: #555; }
        .notif-badge { position: absolute; top: -5px; right: -5px; background: #e53e3e; color: #fff; font-size: 9px; font-weight: 700; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid #fff; }
        .main-content { margin-left: 220px; padding-top: 64px; background: #f4f8f5; min-height: 100vh; }
        .content-inner { padding: 28px; }
        .breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 12.5px; color: #888; margin-bottom: 16px; }
        .breadcrumb a { color: #888; text-decoration: none; }
        .breadcrumb a:hover { color: #1a6b3c; }
        .breadcrumb .sep { color: #ccc; }
        .breadcrumb .active { color: #1a6b3c; font-weight: 600; }
        .page-title { font-size: 26px; font-weight: 800; color: #111; margin-bottom: 22px; }
        .page-title span { color: #1a6b3c; }
        /* simple form styles */
        .form-card { background: #fff; border-radius: 14px; border: 1px solid #e2ece6; padding: 24px; box-shadow: 0 2px 10px rgba(26,107,60,.05); }
        .form-row { display: flex; gap: 20px; flex-wrap: wrap; }
        .form-group { flex: 1 1 300px; display: flex; flex-direction: column; margin-bottom: 16px; }
        .form-group label { font-size: 13px; font-weight: 600; color: #333; margin-bottom: 6px; }
        .form-group input, .form-group select, .form-group textarea { border: 1px solid #d3e8da; border-radius: 9px; padding: 8px 12px; font-size: 13px; background: #f8fdf9; outline: none; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #1a6b3c; background: #fff; }
        .btn-primary { background: linear-gradient(135deg, #22813f, #1a6b3c); color: #fff; border: none; border-radius: 9px; padding: 8px 20px; font-size: 13px; font-weight: 700; cursor: pointer; transition: opacity .2s; }
        .btn-primary:hover { opacity: .88; }
        .btn-danger { background: #e53e3e; color: #fff; border: none; border-radius: 9px; padding: 8px 20px; font-size: 13px; font-weight: 700; cursor: pointer; transition: opacity .2s; }
        .btn-danger:hover { opacity: .88; }
        .btn-secondary { background: #f1f7f3; color: #555; border: 1px solid #d3e8da; border-radius: 9px; padding: 8px 20px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; }
        .btn-secondary:hover { background: #daf0e4; }
        img.bukti { max-width: 240px; border: 1px solid #d3e8da; border-radius: 8px; }
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
            <!-- home icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        @if((auth('admin')->check() && auth('admin')->user()->role === 'admin') || (auth('web')->check() && auth('web')->user()->role === 'admin'))
        <a href="{{ route('admin.users.index') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
            </svg>
            Kelola Akun
        </a>
        @endif
        <a href="{{ route('admin.rekap') }}" class="nav-item active">
            <!-- pie chart icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
            Rekap
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
        <a href="{{ route('admin.dashboard') }}" style="color:#888;font-size:13px;text-decoration:none;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;display:inline;vertical-align:-3px;"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <span style="color:#ccc;">/</span>
        <span style="font-size:13px;font-weight:600;color:#1a6b3c;">Detail Transaksi</span>
    </div>
    <div style="flex:1;"></div>
    @php
        $currentUser = auth('admin')->check() ? auth('admin')->user() : auth('web')->user();
    @endphp
    <div class="admin-chip">
        <div class="admin-avatar">{{ strtoupper(substr($currentUser->name ?? 'A', 0, 1)) }}</div>
        <span style="font-size:13px;font-weight:600;color:#222;">{{ $currentUser->name ?? 'Admin Ahmad' }}</span>
    </div>
</header>

<!-- MAIN -->
<main class="main-content">
<div class="content-inner">

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sep">/</span>
        <a href="{{ route('admin.rekap') }}">Rekap</a>
        <span class="sep">/</span>
        <span class="active">Detail Transaksi</span>
    </div>

    <h1 class="page-title">Detail Transaksi</h1>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded">
        {{ session('success') }}
    </div>
    @endif

    <div class="form-card">
        <form method="POST" action="{{ route('admin.transaksi.update', $record->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label>Nomor Invoice</label>
                    <input type="text" value="{{ $record->nomor }}" readonly>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    @php
                        $currentUser = auth('admin')->check() ? auth('admin')->user() : auth('web')->user();
                    @endphp
                    <select name="status" {{ !in_array($currentUser->role, ['admin','kasir']) ? 'disabled' : '' }}>
                        <option value="Lunas" {{ $record->status==='Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="Belum Lunas" {{ $record->status==='Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                        <option value="Batal" {{ $record->status==='Batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $record->nama) }}" {{ !in_array($currentUser->role, ['admin','kasir']) ? 'readonly' : '' }}>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $record->alamat) }}" {{ !in_array($currentUser->role, ['admin','kasir']) ? 'readonly' : '' }}>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Telepon</label>
                    <input type="text" name="telpon" value="{{ old('telpon', $record->telpon) }}" {{ !in_array($currentUser->role, ['admin','kasir']) ? 'readonly' : '' }}>
                </div>
                <div class="form-group">
                    <label>Profesi</label>
                    @php
                        $options = ['PNS','Pegawai Swasta','Wiraswasta','Pedagang','Guru','Pensiunan','Pelayan Jasa','Lainnya'];
                        $current = old('profesi', $record->profesi);
                    @endphp
                    <select name="profesi" {{ !in_array($currentUser->role, ['admin','kasir']) ? 'disabled' : '' }}>
                        @foreach($options as $opt)
                            <option value="{{ $opt }}" {{ $current === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                        @if($current && !in_array($current, $options))
                            <option value="{{ $current }}" selected>{{ $current }}</option>
                        @endif
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Jumlah Jiwa</label>
                    <input type="number" name="jumlah_jiwa" value="{{ old('jumlah_jiwa', $record->jumlah_jiwa) }}" min="1" {{ !in_array($currentUser->role, ['admin','kasir']) ? 'readonly' : '' }}>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $record->tanggal->format('Y-m-d')) }}" {{ !in_array($currentUser->role, ['admin','kasir']) ? 'readonly' : '' }}>
                </div>
            </div>

            <!-- items breakdown, display only -->
            <div class="form-row">
                <div class="form-group" style="flex:1 1 100%;">
                    <label>Rincian Jenis</label>
                    <ul class="ml-4 list-disc">
                        @foreach(is_array($record->items)?$record->items:json_decode($record->items,true) as $it)
                            <li>{{ $it['jenis'] ?? '-' }} &mdash; Rp {{ number_format($it['uang'] ?? 0,0,',','.') }} @if(isset($it['beras'])) ({{ $it['beras'] }} kg)@endif</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Total Uang</label>
                    <input type="text" value="Rp {{ number_format($record->total_uang,0,',','.') }}" readonly>
                </div>
                <div class="form-group">
                    <label>Total Beras</label>
                    <input type="text" value="{{ $record->total_beras }} kg" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="flex:1 1 100%;">
                    <label>Bukti Pembayaran</label>
                    @if($record->bukti)
                        <div class="mb-2" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                            <a href="{{ asset('storage/'.$record->bukti) }}" target="_blank" rel="noopener" title="Klik untuk lihat ukuran penuh">
                                <img src="{{ asset('storage/'.$record->bukti) }}" alt="Bukti" class="bukti">
                            </a>
                            <div style="display:flex;flex-direction:column;gap:8px;">
                                <a href="{{ asset('storage/'.$record->bukti) }}" target="_blank" rel="noopener" class="btn-secondary" style="display:inline-flex;align-items:center;gap:6px;text-decoration:none;">
                                    👁️ Lihat
                                </a>
                                <a href="{{ asset('storage/'.$record->bukti) }}" download="{{ basename($record->bukti) }}" class="btn-primary" style="display:inline-flex;align-items:center;gap:6px;text-decoration:none;">
                                    ⬇️ Download
                                </a>
                            </div>
                        </div>
                    @endif
                    @if(in_array($currentUser->role, ['admin','kasir']))
                        <input type="file" name="bukti" accept="image/*">
                    @endif
                </div>
            </div>

            @if(in_array($currentUser->role, ['admin','kasir']))
            <div class="form-row" style="margin-top:20px; gap:10px;">
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>
            @endif
        </form>

        @if(in_array($currentUser->role, ['admin','kasir']))
        <form method="POST" action="{{ route('admin.transaksi.destroy', $record->id) }}" onsubmit="return confirm('Hapus transaksi ini?');" style="margin-top:10px;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger">Hapus</button>
        </form>
        @endif
    </div>

</div>
</main>

</body>
</html>

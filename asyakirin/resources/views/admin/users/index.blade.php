<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Akun Pengurus - ASY-SYAAKIRIIN</title>
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
        .content-inner { padding: 28px; }
        .page-title { font-size: 26px; font-weight: 800; color: #111; margin-bottom: 22px; }
        .page-title span { color: #1a6b3c; }
        .card { background: #fff; border-radius: 14px; border: 1px solid #e2ece6; box-shadow: 0 2px 10px rgba(26,107,60,.05); overflow: hidden; }
        .card-header { padding: 18px 22px; border-bottom: 1px solid #f0f5f1; display: flex; align-items: center; gap: 10px; }
        .card-header h3 { font-size: 15px; font-weight: 700; color: #145c33; flex: 1; }
        .btn-primary { background: linear-gradient(135deg, #22813f, #1a6b3c); color: #fff; border: none; border-radius: 9px; padding: 9px 18px; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; font-family: inherit; transition: opacity .2s; }
        .btn-primary:hover { opacity: .88; }
        table.data-table { width: 100%; border-collapse: collapse; }
        table.data-table thead tr { background: #f0f7f3; }
        table.data-table th { padding: 12px 18px; font-size: 12.5px; font-weight: 700; color: #3d7a55; text-align: left; white-space: nowrap; }
        table.data-table td { padding: 13px 18px; font-size: 13px; color: #333; border-top: 1px solid #f3f7f4; vertical-align: middle; }
        table.data-table tbody tr:hover { background: #f8fdf9; }
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 700; }
        .badge.admin    { background: #fef3c7; color: #92400e; }
        .badge.pengurus { background: #dbeafe; color: #1e40af; }
        .badge.active   { background: #dcfce7; color: #15803d; }
        .badge.inactive { background: #fee2e2; color: #b91c1c; }
        .badge.src-admins { background: #f3e8fd; color: #7c3aed; }
        .badge.src-users  { background: #e0f2fe; color: #075985; }
        .btn-sm { padding: 5px 12px; font-size: 12px; font-weight: 600; border-radius: 7px; cursor: pointer; text-decoration: none; font-family: inherit; display: inline-flex; align-items: center; gap: 4px; transition: all .15s; border: none; }
        .btn-edit   { background: #e0f2fe; color: #075985; }
        .btn-edit:hover   { background: #bae6fd; }
        .btn-delete { background: #fee2e2; color: #b91c1c; }
        .btn-delete:hover { background: #fecaca; }
        .btn-toggle { background: #f1f7f3; color: #1a6b3c; border: 1px solid #d3e8da; }
        .btn-toggle:hover { background: #daf0e4; }
        .alert { padding: 14px 18px; border-radius: 10px; font-size: 13px; font-weight: 600; margin-bottom: 18px; display: flex; align-items: center; gap: 10px; }
        .alert.success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .alert.error   { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
        .empty-state { text-align: center; padding: 60px 20px; color: #aaa; font-size: 14px; }
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
        <a href="{{ route('admin.transaksi') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Transaksi
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
        <span style="font-size:13px;font-weight:600;color:#1a6b3c;">Kelola Akun</span>
    </div>
    <div style="flex:1;"></div>
</header>

<!-- MAIN -->
<main class="main-content">
<div class="content-inner">

    <h1 class="page-title">Kelola <span>Semua Akun</span></h1>

    @if(session('success'))
    <div class="alert success">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert error">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3>Daftar Semua Akun</h3>
            <span style="font-size:12px;background:#e8f5ee;color:#1a6b3c;padding:2px 10px;border-radius:20px;font-weight:600;">
                {{ $total }} akun
            </span>
            <a href="{{ route('admin.users.create') }}" class="btn-primary" style="margin-left:8px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><path d="M12 4v16m8-8H4"/></svg>
                Tambah Akun
            </a>
        </div>

        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tabel</th>
                        <th>Status</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $i => $user)
                    @php
                        $currentUser = auth('admin')->check() ? auth('admin')->user() : auth('web')->user();
                        $currentSource = auth('admin')->check() ? 'admins' : 'users';
                        $isSelf = ($user->id === $currentUser->id && $user->source === $currentSource);
                        $no = ($currentPage - 1) * $perPage + $i + 1;
                    @endphp
                    <tr>
                        <td style="color:#aaa;font-size:12.5px;">{{ $no }}.</td>
                        <td style="font-weight:600;">
                            {{ $user->name }}
                            @if($isSelf)
                            <span style="font-size:11px;background:#fef3c7;color:#92400e;padding:1px 7px;border-radius:10px;margin-left:4px;">Anda</span>
                            @endif
                        </td>
                        <td style="color:#555;">{{ $user->email }}</td>
                        <td><span class="badge {{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                        <td>
                            <span class="badge src-{{ $user->source }}">
                                {{ $user->source === 'admins' ? '🔐 Admins' : '👤 Users' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $user->is_active ? 'active' : 'inactive' }}">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td style="color:#888;white-space:nowrap;">
                            {{ $user->created_at->translatedFormat('d M Y') }}
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                {{-- Edit --}}
                                <a href="{{ route('admin.users.edit', $user->id) }}?source={{ $user->source }}" class="btn-sm btn-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                </a>

                                {{-- Toggle aktif --}}
                                <form action="{{ route('admin.users.toggleActive', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="source" value="{{ $user->source }}">
                                    <button type="submit" class="btn-sm btn-toggle">
                                        {{ $user->is_active ? '❌' : '✅' }}
                                    </button>
                                </form>

                                {{-- Hapus (sembunyikan untuk akun sendiri) --}}
                                @if(!$isSelf)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus akun {{ $user->name }}?')"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="source" value="{{ $user->source }}">
                                    <button type="submit" class="btn-sm btn-delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="empty-state">📭 Belum ada akun terdaftar</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination manual --}}
        @php $lastPage = max(1, (int)ceil($total / $perPage)); @endphp
        @if($lastPage > 1)
        <div style="padding:16px 22px;border-top:1px solid #f0f5f1;display:flex;gap:6px;align-items:center;">
            @for($p = 1; $p <= $lastPage; $p++)
            <a href="?page={{ $p }}"
               style="padding:5px 12px;border-radius:7px;font-size:13px;font-weight:600;text-decoration:none;
                      background:{{ $p === $currentPage ? '#1a6b3c' : '#f1f7f3' }};
                      color:{{ $p === $currentPage ? '#fff' : '#1a6b3c' }};
                      border:1px solid {{ $p === $currentPage ? '#1a6b3c' : '#d3e8da' }};">
                {{ $p }}
            </a>
            @endfor
        </div>
        @endif

    </div>
</div>
</main>

</body>
</html>

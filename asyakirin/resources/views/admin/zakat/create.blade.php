<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Zakat - ASY-SYAAKIRIIN</title>
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
        .content-inner { padding: 28px; max-width: 900px; }
        .page-title { font-size: 26px; font-weight: 800; color: #111; margin-bottom: 8px; }
        .page-title span { color: #1a6b3c; }
        .page-subtitle { font-size: 13px; color: #888; margin-bottom: 22px; }
        .form-card { background: #fff; border-radius: 14px; border: 1px solid #e2ece6; box-shadow: 0 2px 10px rgba(26,107,60,.05); padding: 28px; margin-bottom: 20px; }
        .form-section-title { font-size: 16px; font-weight: 700; color: #1a6b3c; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid #e8f5ee; }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #333; margin-bottom: 6px; }
        .form-input, .form-select { width: 100%; border: 1px solid #d3e8da; border-radius: 9px; padding: 10px 14px; font-size: 13.5px; background: #f8fdf9; color: #333; outline: none; font-family: inherit; }
        .form-input:focus, .form-select:focus { border-color: #1a6b3c; background: #fff; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-error { font-size: 12px; color: #b91c1c; margin-top: 4px; }
        .btn-primary { background: linear-gradient(135deg, #22813f, #1a6b3c); color: #fff; border: none; border-radius: 9px; padding: 12px 24px; font-size: 14px; font-weight: 700; cursor: pointer; font-family: inherit; transition: opacity .2s; }
        .btn-primary:hover { opacity: .88; }
        .btn-secondary { background: #f1f7f3; color: #555; border: 1px solid #d3e8da; border-radius: 9px; padding: 12px 24px; font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: none; font-family: inherit; }
        .btn-secondary:hover { background: #daf0e4; }
        .form-actions { display: flex; gap: 10px; margin-top: 28px; justify-content: flex-end; }
        .info-box { background: #e8f5ee; border: 1px solid #aed4bc; border-radius: 10px; padding: 14px; font-size: 12.5px; color: #145c33; margin-bottom: 20px; display: flex; align-items: start; gap: 10px; }
        .checkbox-group { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 16px; }
        .checkbox-label { display: flex; align-items: center; gap: 8px; padding: 8px 12px; border: 1px solid #d3e8da; border-radius: 8px; background: #f8fdf9; cursor: pointer; transition: all .15s; }
        .checkbox-label:hover { background: #e8f5ee; border-color: #1a6b3c; }
        .checkbox-label input:checked + span { font-weight: 700; color: #1a6b3c; }
        table.zakat-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.zakat-table th { background: #f0f7f3; padding: 10px; font-size: 12px; font-weight: 700; color: #3d7a55; text-align: left; border: 1px solid #d3e8da; }
        table.zakat-table td { padding: 10px; border: 1px solid #d3e8da; }
        table.zakat-table input { width: 100%; border: 1px solid #d3e8da; border-radius: 6px; padding: 8px; font-size: 13px; }
        .total-row { background: #f8fdf9; font-weight: 700; }
        #atasNamaWrapper { display: none; margin-top: 12px; }
        #atasNamaContainer { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    </style>
</head>
<body>

<!-- SIDEBAR (copy dari dashboard) -->
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
        <!-- Menu Kelola Akun - HANYA TAMPIL UNTUK ADMIN -->
        @if(auth('admin')->check() && auth('admin')->user()->role === 'admin')
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
        <a href="{{ route('admin.transaksi') }}" class="nav-item active">
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
        <span style="font-size:13px;font-weight:600;color:#1a6b3c;">Input Data Zakat</span>
    </div>
    <div style="flex:1;"></div>
</header>

<!-- MAIN -->
<main class="main-content">
<div class="content-inner">

    <h1 class="page-title">Input Data <span>Zakat</span></h1>
    <p class="page-subtitle">Isi data atas nama donatur yang tidak bisa mengisi sendiri</p>

    <div class="info-box">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:20px;height:20px;flex-shrink:0;margin-top:2px;">
            <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <strong>Catatan:</strong> Data yang Anda input akan tercatat atas nama <strong>auth('admin')->user()->role</strong> sebagai pengurus yang mewakilkan donatur.
        </div>
    </div>

    <form action="{{ route('admin.zakat.store') }}" method="POST" id="zakatForm">
        @csrf

        <!-- DATA DONATUR -->
        <div class="form-card">
            <div class="form-section-title">📋 Data Muzakki / Donatur</div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nama Donatur *</label>
                    <input type="text" name="nama" class="form-input" value="{{ old('nama') }}" placeholder="Nama lengkap" required>
                    @error('nama')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">No. Telpon</label>
                    <input type="text" name="telpon" class="form-input" value="{{ old('telpon') }}" placeholder="08xxxxxxxxxx">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-input" value="{{ old('alamat') }}" placeholder="Alamat lengkap">
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Profesi</label>
                    <input type="text" name="profesi" class="form-input" value="{{ old('profesi') }}" placeholder="Pekerjaan">
                </div>

                <div class="form-group">
                    <label class="form-label">Jumlah Jiwa *</label>
                    <input type="number" name="jumlah_jiwa" class="form-input" value="{{ old('jumlah_jiwa', 1) }}" min="1" id="jumlahJiwa" required>
                </div>
            </div>

            <div id="atasNamaWrapper">
                <label class="form-label">Atas Nama</label>
                <div id="atasNamaContainer"></div>
            </div>
        </div>

        <!-- JENIS ZAKAT -->
        <div class="form-card">
            <div class="form-section-title">💰 Pilih Jenis Zakat</div>

            <div class="checkbox-group">
                <label class="checkbox-label">
                    <input type="checkbox" value="Zakat Fitrah" class="zakat-checkbox" onchange="updateTable()">
                    <span>Zakat Fitrah</span>
                </label>
                <label class="checkbox-label">
                    <input type="checkbox" value="Zakat Maal" class="zakat-checkbox" onchange="updateTable()">
                    <span>Zakat Maal</span>
                </label>
                <label class="checkbox-label">
                    <input type="checkbox" value="Infaq - Shodaqoh" class="zakat-checkbox" onchange="updateTable()">
                    <span>Infaq - Shodaqoh</span>
                </label>
                <label class="checkbox-label">
                    <input type="checkbox" value="Yatim" class="zakat-checkbox" onchange="updateTable()">
                    <span>Yatim</span>
                </label>
                <label class="checkbox-label">
                    <input type="checkbox" value="Fidyah" class="zakat-checkbox" onchange="updateTable()">
                    <span>Fidyah</span>
                </label>
            </div>

            <table class="zakat-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Jenis</th>
                        <th>Uang (Rp)</th>
                        <th>Beras (Kg)</th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="2" style="text-align:right;">Total</td>
                        <td>Rp <span id="totalUang">0</span></td>
                        <td><span id="totalBeras">0</span> Kg</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.transaksi') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">✓ Simpan Data</button>
        </div>

    </form>

</div>
</main>

<script>
// Atas nama jiwa
document.getElementById('jumlahJiwa').addEventListener('input', function() {
    const jumlah = parseInt(this.value) || 0;
    const wrapper = document.getElementById('atasNamaWrapper');
    const container = document.getElementById('atasNamaContainer');

    container.innerHTML = '';

    if (jumlah > 1) {
        wrapper.style.display = 'block';
        for (let i = 1; i <= jumlah; i++) {
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'atas_nama[]';
            input.className = 'form-input';
            input.placeholder = 'Nama Jiwa ke-' + i;
            container.appendChild(input);
        }
    } else {
        wrapper.style.display = 'none';
    }
});

// Update tabel zakat
function updateTable() {
    const tbody = document.getElementById('tableBody');
    const checkboxes = document.querySelectorAll('.zakat-checkbox');

    checkboxes.forEach(cb => {
        const rowId = 'row-' + cb.value.replace(/\s+/g, '-');
        let existingRow = document.getElementById(rowId);

        if (cb.checked && !existingRow) {
            const rowCount = tbody.children.length + 1;
            const row = document.createElement('tr');
            row.id = rowId;
            row.innerHTML = `
                <td style="text-align:center;">${rowCount}</td>
                <td>
                    ${cb.value}
                    <input type="hidden" name="jenis[]" value="${cb.value}">
                </td>
                <td><input type="number" name="uang[]" class="uang" min="0" step="1000" oninput="hitungTotal()" required></td>
                <td><input type="number" name="beras[]" class="beras" min="0" step="0.1" oninput="hitungTotal()"></td>
            `;
            tbody.appendChild(row);
        }

        if (!cb.checked && existingRow) {
            existingRow.remove();
        }
    });

    updateRowNumber();
    hitungTotal();
}

function updateRowNumber() {
    const rows = document.querySelectorAll('#tableBody tr');
    rows.forEach((row, index) => {
        row.querySelector('td:first-child').innerText = index + 1;
    });
}

function hitungTotal() {
    let totalUang = 0;
    let totalBeras = 0;

    document.querySelectorAll('.uang').forEach(input => {
        totalUang += parseInt(input.value) || 0;
    });

    document.querySelectorAll('.beras').forEach(input => {
        totalBeras += parseFloat(input.value) || 0;
    });

    document.getElementById('totalUang').innerText = new Intl.NumberFormat('id-ID').format(totalUang);
    document.getElementById('totalBeras').innerText = totalBeras.toFixed(1);
}
</script>

</body>
</html>

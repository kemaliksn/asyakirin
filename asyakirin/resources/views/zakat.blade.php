<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Zakat - ASY-SYAAKIRIIN</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-4xl mx-auto py-10 px-6">
    <!-- Identity Header: Asy-Syaakiriin -->
    <div class="bg-white/90 backdrop-blur rounded-xl shadow mb-6 border border-green-100">
        <div class="p-5 md:p-6 flex flex-col md:flex-row items-start md:items-center gap-4 md:gap-6">
            <img src="{{ asset('icons/logomasjid.png') }}" alt="Logo Asy-Syaakiriin" class="w-14 h-14 md:w-16 md:h-16 object-contain">
            <div class="flex-1 min-w-0">
                <h1 class="text-xl md:text-2xl font-extrabold tracking-tight text-green-700">Masjid Asy-Syaakiriin</h1>
                <div class="mt-1 text-sm text-gray-700 leading-snug">
                    <p class="truncate md:whitespace-normal">Alamat: <span class="font-medium">[Isi alamat lengkap Masjid/YPDI Asy-Syaakiriin]</span></p>
                    <p class="truncate md:whitespace-normal">Kontak: <span class="font-medium">WA [08xx-xxxx-xxxx]</span> · Email <span class="font-medium">[email@asy-syaakiriin.or.id]</span></p>
                    <p class="truncate md:whitespace-normal">Website: <a href="#" class="text-green-700 hover:underline font-medium">[https://asy-syaakiriin.or.id]</a></p>
                </div>
            </div>
        </div>
        <div class="px-5 md:px-6 pb-4 border-t bg-green-50/50 text-xs text-green-800">
            <div class="pt-3 flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center gap-1 bg-white border border-green-200 text-green-800 px-2.5 py-1 rounded-full">Lembaga Amil</span>
                <span class="inline-flex items-center gap-1 bg-white border border-green-200 text-green-800 px-2.5 py-1 rounded-full">Transparan</span>
                <span class="inline-flex items-center gap-1 bg-white border border-green-200 text-green-800 px-2.5 py-1 rounded-full">Amanah</span>
            </div>
        </div>
    </div>

    @php
    $admin = auth('admin')->user();
    $user = auth('web')->user();
    @endphp

    @if(!$admin && !$user)
    <div class="mb-4 text-right">
        {{-- <a href="{{ route('login') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold">
            🔐 Login sebagai Petugas
        </a> --}}
    </div>
    @else
    <div class="mb-4 bg-green-50 border border-green-200 rounded p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">
                    Anda sedang mengisi atas nama donatur sebagai:
                </p>

                @if($admin)
                    <p class="font-bold text-green-700">
                        👤 {{ $admin->name }} (Petugas)
                    </p>
                @else
                    <p class="font-bold text-green-700">
                        👤 {{ $user->name }} (Petugas)
                    </p>
                @endif
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm font-semibold">
                    Logout
                </button>
            </form>
        </div>
    </div>
    @endif

    <div class="bg-white shadow-lg rounded-lg p-8">

        <h1 class="text-3xl font-bold text-green-700 mb-6">
            Form ZIS (Zakat, Infaq, Shodaqoh)
        </h1>

        <form method="POST" action="{{ route('export.pdf') }}" id="zakatForm" enctype="multipart/form-data">
            @php use Illuminate\Support\Str; @endphp

            <input type="hidden" name="form_token" value="{{ Str::uuid() }}">

            @csrf

            @if(auth('web')->check() || auth('admin')->check())
                <input type="hidden" name="status" value="Lunas">
            @endif

            <!-- DATA DONATUR -->
            <h2 class="text-xl font-semibold mb-4">Data Muzakki / Donatur</h2>

            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <input type="text" name="nama" class="border p-3 rounded" placeholder="Nama Donatur" required>
                <input type="text" name="alamat" class="border p-3 rounded" placeholder="Alamat" required>
                <input type="text" name="telpon" class="border p-3 rounded" placeholder="No. Telpon" required>
                <select name="profesi" class="border p-3 rounded" required>
                    <option value="" disabled selected>Pilih Profesi</option>
                    <option value="PNS">PNS</option>
                    <option value="Pegawai Swasta">Pegawai Swasta</option>
                    <option value="Wiraswasta">Wiraswasta</option>
                    <option value="Pedagang">Pedagang</option>
                    <option value="Guru">Guru</option>
                    <option value="Pensiunan">Pensiunan</option>
                    <option value="Pelayan Jasa">Pelayan Jasa</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <input type="number" name="jumlah_jiwa" class="border p-3 rounded" placeholder="Jumlah Jiwa" required>
                <div id="atasNamaWrapper" class="hidden col-span-2">
                    <label class="block font-medium mb-2">Atas Nama</label>
                    <div id="atasNamaContainer" class="space-y-2"></div>
                </div>
            </div>

            <!-- CHECKBOX -->
            <h2 class="text-xl font-semibold mb-4">
                Pilih Jenis Pembayaran
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                <label><input type="checkbox"   value="Zakat Fitrah" onchange="updateTable()" class="mr-2 zakat"> Zakat Fitrah</label>
                <label><input type="checkbox"   value="Zakat Maal" onchange="updateTable()" class="mr-2 zakat"> Zakat Maal</label>
                <label><input type="checkbox"   value="Infaq - Shodaqoh" onchange="updateTable()" class="mr-2 zakat"> Infaq - Shodaqoh</label>
                <label><input type="checkbox"   value="Yatim" onchange="updateTable()" class="mr-2 zakat"> Yatim</label>
                <label><input type="checkbox"   value="Fidyah" onchange="updateTable()" class="mr-2 zakat"> Fidyah</label>
            </div>

            <!-- INFO FIDYAH & ZAKAT FITRAH -->
            <div class="grid md:grid-cols-2 gap-4 mb-6">

                   <!-- Zakat Fitrah Card -->
                   <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="bg-green-600 text-white p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-green-800">Hitungan Zakat Fitrah</h3>
                    </div>
                    <p class="text-green-900 text-sm mb-3">
                        Perjiwa = Harga Beras × <span class="font-semibold">(3,5 Liter / 2,8 Kg)</span>
                    </p>
                    <div class="bg-white/60 rounded-lg p-3 text-left">
                        <p class="text-xs text-green-700 font-medium mb-1">Contoh Perhitungan:</p>
                        <p class="text-sm text-green-900">
                            Rp 15.000/L × 3,5L = <span class="font-bold text-green-700">Rp 52.500</span>/jiwa
                        </p>
                    </div>
                </div>


                <!-- Fidyah Card -->
                <div class="bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200 rounded-xl p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="bg-amber-500 text-white p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-amber-800">Hitungan Fidyah</h3>
                    </div>
                    <p class="text-amber-900 text-sm mb-3">
                        Dapat dibayarkan dalam bentuk <span class="font-semibold">makanan siap saji</span> atau <span class="font-semibold">uang</span> senilai harga 1 porsi makan.
                    </p>
                    <div class="bg-white/60 rounded-lg p-3 text-left">
                        <p class="text-xs text-amber-700 font-medium mb-1">Contoh Perhitungan:</p>
                        <p class="text-sm text-amber-900">
                            Rp 35.000/porsi × 10 Hari = <span class="font-bold text-amber-700">Rp 350.000</span>
                        </p>
                    </div>
                </div>


            </div>

            <!-- TABLE -->
            <div class="overflow-x-auto">
                <table class="w-full border border-green-600 text-center" id="zakatTable">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="border p-2">No.</th>
                            <th class="border p-2">Jenis</th>
                            <th class="border p-2">Uang (Rp)</th>
                            <th class="border p-2">Beras (Kg)</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Dynamic rows -->
                    </tbody>

                    <tfoot class="bg-gray-100 font-semibold">
                        <tr>
                            <td colspan="2" class="border p-2 text-right">Jumlah</td>
                            <td class="border p-2">
                                Rp <span id="totalUang">0</span>
                            </td>
                            <td class="border p-2">
                                <span id="totalBeras">0</span> Kg
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- TERBILANG -->
            <div class="mt-6">
                <h3 class="italic">Terbilang:</h3>
                <p id="terbilang" class="mt-2 text-gray-700"></p>
            </div>

            <!-- SCRIPT ZAKAT -->
            <script>
                // nilai default per jiwa diambil dari konfigurasi
                const DEFAULT_FITRAH_RATE = {{ config('zakat.fitrah_rate', 30000)}};

                function updateTable() {

                    let tbody = document.getElementById('tableBody');
                    let checkboxes = document.querySelectorAll('.zakat');

                    checkboxes.forEach(cb => {

                        let existingRow = document.getElementById('row-' + cb.value);

                        // Jika dicentang & belum ada row → tambahkan
                        if (cb.checked && !existingRow) {

                            let rowCount = tbody.children.length + 1;

                            let row = document.createElement("tr");
                            row.id = 'row-' + cb.value;

                            if (cb.value === 'Zakat Fitrah') {
                                // row spesial: input rate dan hitung total otomatis
                                row.innerHTML = `
                                    <td class="border p-2 row-no"></td>
                                    <td class="border p-2">
                                        Zakat Fitrah
                                        <input type="hidden" name="jenis[]" value="Zakat Fitrah">
                                    </td>
                                    <td class="border p-2">
                                        <div class="flex flex-col">
                                            <input type="number" name="fitrah_rate[]" class="fitrah-rate w-full p-1 border rounded" placeholder="Rp per jiwa" value="${DEFAULT_FITRAH_RATE}" oninput="updateFitrah()">
                                            <span class="text-sm text-gray-500 mt-1">Total: Rp <span class="fitrah-total">0</span></span>
                                            <input type="hidden" name="uang[]" class="uang">
                                        </div>
                                    </td>
                                    <td class="border p-2">
                                        <input type="number" name="beras[]" class="beras w-full p-1 border rounded" oninput="hitungTotal()">
                                    </td>
                                `;
                            } else {
                                // row biasa
                                row.innerHTML = `
                                    <td class="border p-2 row-no"></td>
                                    <td class="border p-2">
                                        ${cb.value}
                                        <input type="hidden" name="jenis[]" value="${cb.value}">
                                    </td>
                                    <td class="border p-2">
                                        <input type="number" name="uang[]" class="uang w-full p-1 border rounded" oninput="hitungTotal()">
                                    </td>
                                    <td class="border p-2">
                                        <input type="number" name="beras[]" class="beras w-full p-1 border rounded" oninput="hitungTotal()">
                                    </td>
                                `;
                            }

                            tbody.appendChild(row);

                            if (cb.value === 'Zakat Fitrah') {
                                updateFitrah();
                            }
                        }

                        // Jika tidak dicentang & ada row → hapus
                        if (!cb.checked && existingRow) {
                            existingRow.remove();
                        }
                    });

                    updateRowNumber();
                    hitungTotal();
                    }

                function updateRowNumber() {
                    let rows = document.querySelectorAll('#tableBody tr');
                    rows.forEach((row, index) => {
                        row.querySelector('.row-no').innerText = index + 1;
                    });
                }


                function hitungTotal() {

                    let totalUang = 0;
                    let totalBeras = 0;

                    document.querySelectorAll('.uang').forEach(input => {
                        totalUang += parseInt(input.value) || 0;
                    });

                    document.querySelectorAll('.beras').forEach(input => {
                        totalBeras += parseInt(input.value) || 0;
                    });

                    // Total di table
                    document.getElementById('totalUang').innerText =
                        new Intl.NumberFormat('id-ID').format(totalUang);

                    document.getElementById('totalBeras').innerText = totalBeras;

                    // 🔥 Total bawah (sinkron)
                    document.getElementById('total').innerText =
                        new Intl.NumberFormat('id-ID').format(totalUang);

                    // Terbilang
                    document.getElementById('terbilang').innerText =
                        totalUang > 0
                            ? terbilang(totalUang).replace(/\s+/g,' ').trim() + " rupiah"
                            : "";
                    }

                function terbilang(n) {
                    n = Math.floor(n);
                    let angka = [
                        "", "satu", "dua", "tiga", "empat", "lima",
                        "enam", "tujuh", "delapan", "sembilan",
                        "sepuluh", "sebelas"
                    ];

                    if (n < 12)
                        return angka[n];

                    else if (n < 20)
                        return terbilang(n - 10) + " belas";

                    else if (n < 100)
                        return terbilang(Math.floor(n / 10)) + " puluh " + terbilang(n % 10);

                    else if (n < 200)
                        return "seratus " + terbilang(n - 100);

                    else if (n < 1000)
                        return terbilang(Math.floor(n / 100)) + " ratus " + terbilang(n % 100);

                    else if (n < 2000)
                        return "seribu " + terbilang(n - 1000);

                    else if (n < 1000000)
                        return terbilang(Math.floor(n / 1000)) + " ribu " + terbilang(n % 1000);

                    else if (n < 1000000000)
                        return terbilang(Math.floor(n / 1000000)) + " juta " + terbilang(n % 1000000);

                    else if (n < 1000000000000)
                        return terbilang(Math.floor(n / 1000000000)) + " milyar " + terbilang(n % 1000000000);

                    else if (n < 1000000000000000)
                        return terbilang(Math.floor(n / 1000000000000)) + " triliun " + terbilang(n % 1000000000000);

                    else
                        return "";
                    }
            </script>

            <!-- METODE PEMBAYARAN -->
            <h2 class="text-xl font-semibold mb-4">Metode Pembayaran</h2>

            <div class="space-y-3 mb-6">

                <!-- BNI -->
                {{-- <label class="flex items-center justify-between border p-4 rounded-lg cursor-pointer hover:bg-green-50 transition">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('icons/bni.png') }}" class="w-10 h-10 object-contain">
                        <span class="font-medium">Bank Negara Indonesia</span>
                    </div>
                    <input type="radio" name="bank" value="BNI"
                        class="w-5 h-5 accent-green-600">
                </label> --}}

                <!-- BCA -->
                {{-- <label class="flex items-center justify-between border p-4 rounded-lg cursor-pointer hover:bg-green-50 transition">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('icons/bca.png') }}" class="w-10 h-10 object-contain">
                        <span class="font-medium">Bank Central Asia</span>
                    </div>
                    <input type="radio" name="bank" value="BCA"
                        class="w-5 h-5 accent-green-600">
                </label> --}}

                <!-- Mandiri -->
                {{-- <label class="flex items-center justify-between border p-4 rounded-lg cursor-pointer hover:bg-green-50 transition">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('icons/mandiri.png') }}" class="w-10 h-10 object-contain">
                        <span class="font-medium">Bank Mandiri</span>
                    </div>
                    <input type="radio" name="bank" value="Mandiri"
                        class="w-5 h-5 accent-green-600">
                </label> --}}

                <!-- BSI -->
                <label class="flex items-center justify-between border p-4 rounded-lg cursor-pointer hover:bg-green-50 transition">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('icons/bsi.png') }}" class="w-10 h-10 object-contain">
                        <span class="font-medium">Bank Syariah Indonesia</span>
                    </div>
                    <input type="radio" name="bank" value="BSI"
                        class="w-5 h-5 accent-green-600">
                </label>
                <!-- BSI DETAIL (hidden by default) -->
                <div id="bsi-detail" class="hidden border border-dashed rounded-lg p-4 mt-3 bg-gray-50">
                    <p class="font-semibold mb-1">Rekening Zakat</p>
                    <div class="text-lg font-bold text-green-700 tracking-wider">450.450.4560</div>
                    <div class="text-sm text-gray-700 mt-1">an : YPDI ASY-SYAAKIRIIN PONDOK BAMBU</div>
                </div>

                <!-- Muamalat -->
                {{-- <label class="flex items-center justify-between border p-4 rounded-lg cursor-pointer hover:bg-green-50 transition">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('icons/muamalat.png') }}" class="w-10 h-10 object-contain">
                        <span class="font-medium">Bank Muamalat</span>
                    </div>
                    <input type="radio" name="bank" value="Muamalat"
                        class="w-5 h-5 accent-green-600">
                </label> --}}

                <!-- BRI -->
                {{-- <label class="flex items-center justify-between border p-4 rounded-lg cursor-pointer hover:bg-green-50 transition">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('icons/bri.png') }}" class="w-10 h-10 object-contain">
                        <span class="font-medium">Bank Rakyat Indonesia</span>
                    </div>
                    <input type="radio" name="bank" value="BRI"
                        class="w-5 h-5 accent-green-600">
                </label> --}}

                <!-- QRIS -->
                <label class="flex items-center justify-between border p-4 rounded-lg cursor-pointer hover:bg-green-50 transition">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('icons/qris.png') }}" class="w-10 h-10 object-contain">
                        <span class="font-medium">QRIS</span>
                    </div>
                    <input type="radio" name="bank" value="QRIS"
                        class="w-5 h-5 accent-green-600"
                        onchange="toggleQRIS(this)">
                </label>

                <!-- QRIS DETAIL (hidden by default) -->
                <div id="qris-detail" class="hidden border border-dashed rounded-lg p-4 mt-3 bg-gray-50">
                    <p class="font-semibold mb-2">Scan QRIS</p>
                    <img src="{{ asset('icons/qris-code.png') }}"
                        alt="QRIS"
                        class="w-68 mx-auto object-contain">
                    <p class="text-sm text-center text-gray-600 mt-2">
                        Gunakan aplikasi e-wallet / mobile banking Anda
                    </p>
                </div>


                <!-- Cash -->
                <label class="flex items-center justify-between border p-4 rounded-lg cursor-pointer hover:bg-green-50 transition">
                    <div class="flex items-center gap-4">
                        {{-- <img src="{{ asset('icons/cash.png') }}" class="w-10 h-10 object-contain"> --}}
                        <span class="font-medium">Cash</span>
                    </div>
                    <input type="radio" name="bank" value="Cash"
                        class="w-5 h-5 accent-green-600">
                </label>

            </div>

            <!-- TOTAL -->
            <div class="bg-green-50 p-4 rounded mb-6">
                <h3 class="font-semibold text-lg">
                    Total: Rp <span id="total">0</span>
                </h3>
            </div>

            <!-- NIAT ZAKAT: Maal & Fitrah -->
            <h2 class="text-xl font-semibold mb-4">Niat Zakat Maal dan Fitrah</h2>

            <div class="bg-gray-50 p-4 rounded mb-6">
                <div class="grid md:grid-cols-2 gap-4">
                    <!-- Niat Zakat Maal -->
                    <div class="text-center border border-gray-200 rounded-lg p-4 bg-white">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Niat Zakat Maal</p>
                        <p class="text-2xl mb-2">
                            نَوَيْتُ أَنْ أُخْرِجَ زَكَاةَ مَالِي فَرْضًا لِلَّهِ تَعَالَى
                        </p>
                        <p class="italic text-sm">
                            "Nawaitu an ukhrija zakata maali fardhan lillahi ta'ala"
                        </p>
                        <p class="mt-2 text-sm text-gray-700">
                            Saya niat mengeluarkan zakat harta karena Allah Ta’ala.
                        </p>
                    </div>

                    <!-- Niat Zakat Fitrah -->
                    <div class="text-center border border-gray-200 rounded-lg p-4 bg-white">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Niat Zakat Fitrah</p>
                        <p class="text-2xl mb-2">
                            نَوَيْتُ أَنْ أُخْرِجَ زَكَاةَ الْفِطْرِ عَن نَفْسِي فَرْضًا لِلَّهِ تَعَالَى
                        </p>
                        <p class="italic text-sm">
                            "Nawaitu an ukhrija zakata al-fithri 'an nafsii fardhan lillahi ta'ala"
                        </p>
                        <p class="mt-2 text-sm text-gray-700">
                            Saya niat menunaikan zakat fitrah untuk diri saya karena Allah Ta’ala.
                        </p>
                    </div>
                </div>
            </div>

            <!-- section yang muncul saat user tekan lanjut untuk upload bukti -->
            @unless(auth('web')->check() || auth('admin')->check())
            <div id="buktiSection" class="hidden mt-4">
                <label class="block mb-2 font-medium">Unggah Bukti Pembayaran</label>
                <input type="file" name="bukti" id="buktiInput" accept="image/*" class="border p-2 rounded w/full">
                <p class="text-sm text-gray-600 mt-1">Foto / screenshot transaksi</p>
            </div>
            @endunless

            <!-- BUTTON -->
            <button
                type="button"
                onclick="handlePayment(this)"
                class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded text-lg font-semibold"
            >
                {{ (auth('web')->check() || auth('admin')->check()) ? 'Simpan & Cetak' : 'LANJUTKAN PEMBAYARAN' }}
            </button>


        </form>
    </div>
</div>

<!-- SCRIPT VALIDATE -->
<script>
    function validateForm(button) {

        let errors = [];

        @unless(auth('web')->check() || auth('admin')->check())
        // user harus memilih bukti ketika form pengupload sudah terlihat
        const buktiInput = document.getElementById('buktiInput');
        const buktiSection = document.getElementById('buktiSection');
        if (!buktiSection.classList.contains('hidden')) {
            if (!buktiInput.files || buktiInput.files.length === 0) {
                errors.push('Bukti pembayaran belum diunggah');
            }
        }
        @endunless

        if (errors.length > 0) {
            alert("⚠️ Data belum lengkap:\n\n- " + errors.join("\n- "));
            return;
        }

        // 🔥 kunci tombol
        button.disabled = true;
        button.innerText = "Memproses...";

        document.getElementById('zakatForm').submit();
    }

    function handlePayment(button) {
        @unless(auth('web')->check() || auth('admin')->check())
        const buktiSection = document.getElementById('buktiSection');
        if (buktiSection.classList.contains('hidden')) {
            // tampilkan form upload saja
            buktiSection.classList.remove('hidden');
            button.innerText = 'UPLOAD BUKTI & CETAK';
            return;
        }
        @endunless
        // lanjut ke validasi / submit
        validateForm(button);
    }

</script>


<!-- SCRIPT QRIS -->
<script>
    document.querySelectorAll('input[name="bank"]').forEach(radio => {
        radio.addEventListener('change', function () {
            const qrisDetail = document.getElementById('qris-detail');
            const bsiDetail  = document.getElementById('bsi-detail');

            if (this.value === 'QRIS') {
                qrisDetail.classList.remove('hidden');
            } else {
                qrisDetail.classList.add('hidden');
            }

            if (this.value === 'BSI') {
                bsiDetail.classList.remove('hidden');
            } else {
                bsiDetail.classList.add('hidden');
            }
        });
    });
</script>

<!-- SCRIPT JUMLAH JIWA -->
<script>
    const jumlahJiwaInput = document.querySelector('[name="jumlah_jiwa"]');
    const wrapper = document.getElementById('atasNamaWrapper');
    const container = document.getElementById('atasNamaContainer');

    function updateFitrah() {
        let jumlah = parseInt(jumlahJiwaInput.value) || 0;
        let fitrahRow = document.getElementById('row-Zakat Fitrah');
        if (fitrahRow) {
            let rateInput = fitrahRow.querySelector('.fitrah-rate');
            let totalSpan = fitrahRow.querySelector('.fitrah-total');
            let uangInput = fitrahRow.querySelector('input[name="uang[]"]');
            let rate = parseInt(rateInput.value) || 0;
            let total = rate * jumlah;
            totalSpan.innerText = new Intl.NumberFormat('id-ID').format(total);
            uangInput.value = total;
        }
        hitungTotal();
    }

    jumlahJiwaInput.addEventListener('input', function () {

        let jumlah = parseInt(this.value) || 0;

        container.innerHTML = "";

        if (jumlah > 1) {

            wrapper.classList.remove('hidden');

            for (let i = 2; i <= jumlah; i++) {

                let input = document.createElement("input");
                input.type = "text";
                input.name = "atas_nama[]";
                input.placeholder = "Nama Jiwa ke-" + i;
                input.className = "border p-3 rounded w-full atas-nama";

                container.appendChild(input);
            }

        } else {
            wrapper.classList.add('hidden');
        }

        // jika fitrah sudah dicentang, hitung ulang
        updateFitrah();
        hitungTotal();
    });
</script>



@if(!(auth('web')->check() || auth('admin')->check()))
<a href="https://wa.me/6281234567890?text=Assalamu%27alaikum%20Saya%20butuh%20bantuan" class="wa-call-center" target="_blank" rel="noopener" aria-label="WhatsApp Call Center">
    <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true" focusable="false" role="img">
        <path fill="currentColor" d="M20.52 3.48A11.94 11.94 0 0 0 12.01 0C5.39 0 .02 5.37.02 11.99c0 2.11.55 4.16 1.6 5.99L0 24l6.19-1.62a11.97 11.97 0 0 0 5.82 1.51h.01c6.62 0 11.99-5.37 11.99-11.99 0-3.2-1.25-6.21-3.49-8.43ZM12.01 22.1h-.01a10.08 10.08 0 0 1-5.14-1.41l-.37-.22-3.67.96.98-3.57-.24-.37a10.08 10.08 0 1 1 18.8-5.1c0 5.56-4.53 10.11-10.35 10.11Zm5.82-7.48c-.32-.16-1.89-.93-2.18-1.03-.29-.1-.5-.16-.71.16-.21.32-.81 1.03-.99 1.23-.18.2-.36.23-.67.08-.32-.16-1.33-.49-2.53-1.55-.94-.83-1.56-1.84-1.75-2.15-.19-.31-.02-.49.15-.64.15-.15.33-.36.48-.54.16-.19.22-.31.33-.52.11-.21.05-.39-.02-.55-.08-.16-.7-1.69-.96-2.31-.25-.61-.51-.54-.7-.55-.18-.01-.4-.01-.61-.01-.21 0-.55.08-.84.4-.29.32-1.11 1.1-1.11 2.67 0 1.57 1.13 3.08 1.29 3.28.16.21 2.23 3.35 5.4 4.7.76.32 1.35.5 1.81.64.76.24 1.45.21 2 .13.61-.09 1.87-.75 2.14-1.52.27-.75.27-1.38.19-1.52-.08-.13-.29-.21-.62-.36Z"/>
    </svg>
    <span>Call Center</span>
</a>
<style>
    .wa-call-center{position:fixed;right:16px;bottom:16px;display:inline-flex;align-items:center;gap:8px;background:#25D366;color:#fff;padding:12px 14px;border-radius:9999px;box-shadow:0 8px 24px rgba(0,0,0,.2);font-weight:700;z-index:9999;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}
    .wa-call-center svg{width:22px;height:22px;display:block}
    .wa-call-center:hover{filter:brightness(0.95)}
    .wa-call-center:focus-visible{outline:2px solid #1fa855;outline-offset:2px}
    @media (max-width:480px){.wa-call-center span{display:none}.wa-call-center{padding:12px}}
</style>
@endif

</body>

</html>

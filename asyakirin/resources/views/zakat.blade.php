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
    @guest('web')
    <div class="mb-4 text-right">
        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold">
            🔐 Login sebagai Pengurus
        </a>
    </div>
    @else
    <div class="mb-4 bg-green-50 border border-green-200 rounded p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Anda sedang mengisi atas nama donatur sebagai:</p>
                <p class="font-bold text-green-700">👤 {{ auth('web')->user()->name }} ({{ ucfirst(auth('web')->user()->role) }})</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-semibold">
                    🏠 Dashboard
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm font-semibold">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endguest

    <div class="bg-white shadow-lg rounded-lg p-8">

        <h1 class="text-3xl font-bold text-green-700 mb-6">
            Masuk Zakat
        </h1>

        <form method="POST" action="{{ route('export.pdf') }}" id="zakatForm">
            @php use Illuminate\Support\Str; @endphp

            <input type="hidden" name="form_token" value="{{ Str::uuid() }}">

            @csrf

            <!-- DATA DONATUR -->
            <h2 class="text-xl font-semibold mb-4">Data Muzakki / Donatur</h2>

            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <input type="text" name="nama" class="border p-3 rounded" placeholder="Nama Donatur" required>
                <input type="text" name="alamat" class="border p-3 rounded" placeholder="Alamat" required>
                <input type="text" name="telpon" class="border p-3 rounded" placeholder="No. Telpon" required>
                <input type="text" name="profesi" class="border p-3 rounded" placeholder="Profesi" required>
                <input type="number" name="jumlah_jiwa" class="border p-3 rounded" placeholder="Jumlah Jiwa" required>
                <div id="atasNamaWrapper" class="hidden col-span-2">
                    <label class="block font-medium mb-2">Atas Nama</label>
                    <div id="atasNamaContainer" class="space-y-2"></div>
                </div>
            </div>

            <!-- CHECKBOX -->
            <h2 class="text-xl font-semibold mb-4">
                Pilih Jenis Zakat
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                <label><input type="checkbox"   value="Zakat Fitrah" onchange="updateTable()" class="mr-2 zakat"> Zakat Fitrah</label>
                <label><input type="checkbox"   value="Zakat Maal" onchange="updateTable()" class="mr-2 zakat"> Zakat Maal</label>
                <label><input type="checkbox"   value="Infaq - Shodaqoh" onchange="updateTable()" class="mr-2 zakat"> Infaq - Shodaqoh</label>
                <label><input type="checkbox"   value="Yatim" onchange="updateTable()" class="mr-2 zakat"> Yatim</label>
                <label><input type="checkbox"   value="Fidyah" onchange="updateTable()" class="mr-2 zakat"> Fidyah</label>
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

                            tbody.appendChild(row);
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
                        class="w-48 mx-auto object-contain">
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

            <!-- NIAT ZAKAT -->
            <h2 class="text-xl font-semibold mb-4">Niat Mengeluarkan Zakat</h2>

            <div class="bg-gray-50 p-4 rounded mb-6 text-center">
                <p class="text-2xl mb-2">
                    نَوَيْتُ أَنْ أُخْرِجَ زَكَاةَ مَالِي فَرْضًا لِلَّهِ تَعَالَى
                </p>
                <p class="italic">
                    "Nawaitu an ukhrija zakata maali fardha lillahi ta’aala"
                </p>
                <p class="mt-2">
                    Saya berniat mengeluarkan zakat harta milikku karena Allah Ta’ala
                </p>
            </div>

            <!-- BUTTON -->
            <button
                type="button"
                onclick="validateForm(this)"
                class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded text-lg font-semibold"
            >
                LANJUTKAN PEMBAYARAN
            </button>


        </form>
    </div>
</div>

<!-- SCRIPT VALIDATE -->
<script>
    function validateForm(button) {

        let errors = [];

        // validasi kamu tetap

        if (errors.length > 0) {
            alert("⚠️ Data belum lengkap:\n\n- " + errors.join("\n- "));
            return;
        }

        // 🔥 kunci tombol
        button.disabled = true;
        button.innerText = "Memproses...";

        document.getElementById('zakatForm').submit();
    }

</script>


<!-- SCRIPT QRIS -->
<script>
    document.querySelectorAll('input[name="bank"]').forEach(radio => {

        radio.addEventListener('change', function () {

            const qrisDetail = document.getElementById('qris-detail');

            if (this.value === 'QRIS') {
                qrisDetail.classList.remove('hidden');
            } else {
                qrisDetail.classList.add('hidden');
            }

        });

    });
</script>

<!-- SCRIPT JUMLAH JIWA -->
<script>
    const jumlahJiwaInput = document.querySelector('[name="jumlah_jiwa"]');
    const wrapper = document.getElementById('atasNamaWrapper');
    const container = document.getElementById('atasNamaContainer');

    jumlahJiwaInput.addEventListener('input', function () {

        let jumlah = parseInt(this.value) || 0;

        container.innerHTML = "";

        if (jumlah > 1) {

            wrapper.classList.remove('hidden');

            for (let i = 1; i <= jumlah; i++) {

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

    });
</script>



</body>

</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice Siap - ASY-SYAAKIRIIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('icons/logomasjid.png') }}">
</head>
<body class="bg-gray-100">
<div class="max-w-2xl mx-auto py-10 px-6">
    <div class="bg-white shadow rounded-xl p-6">
        <h1 class="text-2xl font-extrabold text-green-700 mb-4">Invoice Qurban Siap</h1>
        <p class="text-gray-600 mb-6">Transaksi berhasil disimpan. Silakan unduh invoice atau kirim via WhatsApp kepada pembayar.</p>

        <div class="border rounded-lg p-4 bg-green-50 border-green-200 mb-6">
            <div class="grid grid-cols-1 gap-2 text-sm">
                <div><span class="font-semibold text-green-800">Nomor:</span> {{ $qurban->nomor }}</div>
                <div><span class="font-semibold text-green-800">Nama:</span> {{ $qurban->nama }}</div>
                <div><span class="font-semibold text-green-800">Tanggal:</span> {{ optional($qurban->tanggal)->format('d M Y') }}</div>
                <div><span class="font-semibold text-green-800">Total Uang:</span> Rp {{ number_format($qurban->total_uang, 0, ',', '.') }}</div>
            </div>
        </div>

        <?php
            $downloadUrl = route('qurban.public-invoice', $qurban->id);
            // Normalisasi nomor telepon: hilangkan non-digit, ganti prefix 0 jadi 62
            $raw = preg_replace('/[^0-9+]/', '', (string)($qurban->telpon ?? ''));
            if (strpos($raw, '+') === 0) { $raw = substr($raw, 1); }
            if (strpos($raw, '0') === 0) { $wa = '62' . substr($raw, 1); } else { $wa = $raw; }
            // Fallback jika kosong
            if (!$wa) { $wa = '62'; }

            $msg = "Assalamu'alaikum, berikut tautan invoice qurban Anda: $downloadUrl . Terima kasih telah berbagi berkah qurban di ASY-SYAAKIRIIN.";
            $waUrl = 'https://wa.me/' . $wa . '?text=' . urlencode($msg);
        ?>

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ $downloadUrl }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-5 h-5"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1"/><path d="M12 12v8m0 0l-4-4m4 4l4-4"/><path d="M12 12V3"/></svg>
                Download Invoice
            </a>
            <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 bg-[#25D366] hover:brightness-95 text-white font-semibold px-4 py-2 rounded-md">
                <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path fill="currentColor" d="M20.52 3.48A11.94 11.94 0 0 0 12.01 0C5.39 0 .02 5.37.02 11.99c0 2.11.55 4.16 1.6 5.99L0 24l6.19-1.62a11.97 11.97 0 0 0 5.82 1.51h.01c6.62 0 11.99-5.37 11.99-11.99 0-3.2-1.25-6.21-3.49-8.43ZM12.01 22.1h-.01a10.08 10.08 0 0 1-5.14-1.41l-.37-.22-3.67.96.98-3.57-.24-.37a10.08 10.08 0 1 1 18.8-5.1c0 5.56-4.53 10.11-10.35 10.11Zm5.82-7.48c-.32-.16-1.89-.93-2.18-1.03-.29-.1-.5-.16-.71.16-.21.32-.81 1.03-.99 1.23-.18.2-.36.23-.67.08-.32-.16-1.33-.49-2.53-1.55-.94-.83-1.56-1.84-1.75-2.15-.19-.31-.02-.49.15-.64.15-.15.33-.36.48-.54.16-.19.22-.31.33-.52.11-.21.05-.39-.02-.55-.08-.16-.7-1.69-.96-2.31-.25-.61-.51-.54-.7-.55-.18-.01-.4-.01-.61-.01-.21 0-.55.08-.84.4-.29.32-1.11 1.1-1.11 2.67 0 1.57 1.13 3.08 1.29 3.28.16.21 2.23 3.35 5.4 4.7.76.32 1.35.5 1.81.64.76.24 1.45.21 2 .13.61-.09 1.87-.75 2.14-1.52.27-.75.27-1.38.19-1.52-.08-.13-.29-.21-.62-.36Z"/></svg>
                Kirim ke WhatsApp
            </a>
        </div>

        <div class="mt-6 text-sm text-gray-500">
            <a href="/qurban" class="hover:underline">Kembali ke Form</a>
        </div>
    </div>
</div>
</body>
</html>

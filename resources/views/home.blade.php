<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Menu Utama - ASY-SYAAKIRIIN</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="icon" type="image/png" href="{{ asset('icons/logomasjid.png') }}">
    </head>
    <body class="bg-gray-100 text-slate-900">
        <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="bg-white/90 backdrop-blur rounded-3xl shadow-xl border border-green-100 overflow-hidden">
                <div class="p-5 sm:p-6 lg:p-8">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('icons/logomasjid.png') }}" alt="Logo Asy-Syaakiriin" class="w-14 h-14 md:w-16 md:h-16 object-contain">
                            <div>
                                <p class="text-sm text-green-700 font-semibold uppercase tracking-[0.2em]">Asy-Syaakiriin</p>
                                <h1 class="mt-1 text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900">Menu Utama</h1>
                                <p class="mt-2 text-sm md:text-base text-slate-600 max-w-2xl">Pilih form yang ingin dibuka: halaman Zakat atau halaman Qurban. Tema halaman ini sudah diselaraskan dengan tampilan kedua form tersebut.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid gap-4 px-5 pb-6 sm:px-6 sm:pb-8 lg:grid-cols-2 lg:px-8">
                    <a href="{{ url('/zakat') }}" class="group block rounded-[28px] border border-green-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-green-700">Zakat</p>
                            <h2 class="mt-4 text-2xl font-bold text-slate-900">Form ZIS</h2>
                            <p class="mt-3 text-sm leading-6 text-slate-600">Lanjutkan ke halaman Zakat untuk input donatur, pilih jenis zakat, dan cetak bukti.</p>
                        </div>
                        <div class="mt-6">
                            <span class="inline-flex items-center rounded-full bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm">Buka Zakat</span>
                        </div>
                    </a>

                    <a href="{{ url('/qurban') }}" class="group block rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-700">Qurban</p>
                            <h2 class="mt-4 text-2xl font-bold text-slate-900">Form Qurban</h2>
                            <p class="mt-3 text-sm leading-6 text-slate-600">Buka halaman Qurban untuk memilih paket, input data, dan cetak kupon.</p>
                        </div>
                        <div class="mt-6">
                            <span class="inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm">Buka Qurban</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>

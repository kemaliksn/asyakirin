<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 9pt;
    color: #000000;
    margin: 0;
    padding: 0;
}

/* HEADER */
table.header { width:100%; background-color:#1a7a3c; border-collapse:collapse; }
table.header td { color:#ffffff; vertical-align:middle; padding:6pt 8pt; }
.h-title   { font-size:12pt; font-weight:bold; margin-bottom:1pt; }
.h-sub     { font-size:9.5pt; font-weight:bold; margin-bottom:2pt; }
.h-addr    { font-size:7.5pt; }
.no-box    { border:1pt solid #ffffff; border-radius:4pt; padding:6pt 10pt; font-size:9pt; color:#ffffff; }

/* MAIN */
table.main { width:100%; border-collapse:collapse; }
table.main > tbody > tr > td { vertical-align:top; }
td.col-left  { width:42%; padding:6pt 6pt 3pt 8pt; }
td.col-right { width:58%; padding:6pt 8pt 3pt 4pt; }

/* LEFT */
.sec-title { text-align:center; font-size:10.5pt; font-weight:bold; margin-bottom:6pt; }
table.form-tbl { width:100%; border-collapse:collapse; }
table.form-tbl td { font-size:9pt; padding-bottom:4pt; vertical-align:bottom; }
td.f-lbl { width:42pt; white-space:nowrap; }
td.f-col { width:6pt; }
td.f-val { border-bottom:0.6pt solid #000000; min-height:12pt; padding-bottom:1pt; }
.addr-line { border-bottom:0.6pt solid #000000; min-height:12pt; padding-bottom:1pt; margin-bottom:3pt; display:block; }
.jiwa-wrap { font-size:9pt; margin:1pt 0 4pt 0; }
.jiwa-box  { border-bottom:0.6pt solid #000000; width:32pt; display:inline-block; min-height:11pt; text-align:center; }
table.name-tbl { width:100%; border-collapse:collapse; margin-top:2pt; }
table.name-tbl td { font-size:9pt; padding-bottom:3pt; vertical-align:bottom; }
td.n-num  { width:12pt; }
td.n-line { border-bottom:0.6pt solid #000000; padding-bottom:1pt; }

/* RIGHT */
table.zakat { width:100%; border-collapse:collapse; }
table.zakat th { background-color:#1a7a3c; color:#ffffff; border:1pt solid #1a7a3c; padding:4pt 4pt; font-size:9pt; text-align:center; font-weight:bold; }
table.zakat td { border:1pt solid #1a7a3c; padding:2.5pt 4pt; font-size:9pt; vertical-align:middle; }
td.t-no    { text-align:center; width:16pt; }
td.t-uang  { white-space:nowrap; width:64pt; }
td.t-beras { text-align:right; white-space:nowrap; width:42pt; }
tr.tr-total td { font-weight:bold; background-color:#edf7f0; }
td.t-terb  { font-style:italic; padding:3pt 4pt; min-height:22pt; vertical-align:top; }
.terb-bold { font-weight:bold; }

/* BOTTOM – Arab kiri, TTD kanan */
table.bottom { width:100%; border-collapse:collapse; }
table.bottom > tbody > tr > td { vertical-align:bottom; }
td.b-arabic { width:48%; padding:2pt 6pt 2pt 8pt; }
td.b-sign   { width:52%; padding:2pt 8pt 2pt 4pt; text-align:right; }

.arabic-text {
    font-family: DejaVu Sans, sans-serif;
    font-size:12pt; text-align:right; direction:rtl;
    line-height:1.6; margin-bottom:3pt;
}
.arabic-trans { font-style:italic; font-size:8pt; text-align:center; line-height:1.4; color:#333333; }

/* Tanda tangan – semua align right */
.sign-inner { display:inline-block; text-align:left; }
.sign-city  { font-size:9pt; margin-bottom:2pt; }
.sign-line  { border-bottom:0.6pt solid #000000; display:inline-block; width:100pt; }
.sign-amil  { font-size:9pt; margin-bottom:30pt; margin-top:2pt; }
.sign-box   {
    border:1pt solid #000000;
    display:inline-block;
    min-width:140pt;
    padding:2pt 6pt;
    min-height:14pt;
    font-size:9pt;
    text-align:center;
}

/* FOOTER */
table.footer { width:100%; background-color:#1a7a3c; border-collapse:collapse; margin-top:3pt; }
table.footer td { color:#ffffff; padding:6pt 8pt; vertical-align:middle; font-size:8pt; }
td.f-contact { width:32%; line-height:1.5; }
td.f-bsi     { width:36%; text-align:center; }
td.f-rek     { width:32%; line-height:1.6; }
.bsi-badge   { background-color:#ffffff; color:#1a7a3c; font-weight:bold; font-size:11pt; border-radius:3pt; padding:1pt 8pt; letter-spacing:1pt; display:inline-block; }
.bsi-sub     { font-size:7pt; color:#ffffff; margin-top:2pt; line-height:1.2; }

/* Avoid page breaks inside tables */
table, thead, tbody, tr, td, th { page-break-inside: avoid; }
</style>
</head>
<body>

{{-- HEADER --}}
<table class="header" cellspacing="0" cellpadding="0">
<tr>
    <td style="width:68pt; padding:8pt 4pt 8pt 10pt;">
        <img style="width:60pt;height:60pt;" src="{{ public_path('icons/logomasjid.png') }}" alt="">
    </td>
    <td>
        <div class="h-title">TANDA TERIMA ZAKAT INFAQ SHODAQOH (ZIS)</div>
        <div class="h-sub">YAYASAN PEMBINA DA'WAH ISLAM ASY-SYAAKIRIIN PONDOK BAMBU</div>
        <div class="h-addr">Alamat : Jl. Gading Raya RT.08 RW.08, Pondok Bambu, Duren Sawit, Jakarta Timur</div>
    </td>
    <td style="width:150pt; padding:8pt 10pt 8pt 4pt; text-align:right;">
        <div class="no-box">
            <b>No.</b> &nbsp;: &nbsp;{{ $data['nomor'] ?? '' }}
        </div>
    </td>
</tr>
</table>

{{-- MAIN --}}
<table class="main" cellspacing="0" cellpadding="0">
<tr>

{{-- KIRI --}}
<td class="col-left">
    <div class="sec-title">DATA MUZAKKI / DONATUR</div>

    <table class="form-tbl" cellspacing="0" cellpadding="0">
        <tr>
            <td class="f-lbl">Nama</td>
            <td class="f-col">:</td>
            <td class="f-val">{{ $data['nama'] ?? '' }}</td>
        </tr>
        <tr>
            <td class="f-lbl" style="vertical-align:top; padding-top:1pt;">Alamat</td>
            <td class="f-col" style="vertical-align:top; padding-top:1pt;">:</td>
            <td style="padding-bottom:5pt; vertical-align:top; padding-top:1pt;">
                <span class="addr-line">{{ $data['alamat'] ?? '' }}</span>
                <span class="addr-line">&nbsp;</span>
            </td>
        </tr>
        <tr>
            <td class="f-lbl">Hp/WA</td>
            <td class="f-col">:</td>
            <td class="f-val">{{ $data['telpon'] ?? '' }}</td>
        </tr>
        <tr>
            <td class="f-lbl">Profesi</td>
            <td class="f-col">:</td>
            <td class="f-val">{{ $data['profesi'] ?? '' }}</td>
        </tr>
        <tr>
            <td class="f-lbl">Metode</td>
            <td class="f-col">:</td>
            <td class="f-val">{{ $data['bank'] ?? '' }}</td>
        </tr>
    </table>

    <div class="jiwa-wrap">
        Jml. Jiwa :&nbsp;<span class="jiwa-box">{{ $data['jumlah_jiwa'] ?? '' }}</span>&nbsp;orang, atas nama :
    </div>

    @php $atasNama = array_pad((array)($data['atas_nama'] ?? []), 5, ''); @endphp
    <table class="name-tbl" cellspacing="0" cellpadding="0">
        @foreach($atasNama as $i => $nm)
        <tr>
            <td class="n-num">{{ $i+1 }}.</td>
            <td class="n-line">{{ $nm }}</td>
        </tr>
        @endforeach
    </table>
</td>

{{-- KANAN --}}
<td class="col-right">
    @php
        $jenisList = ['Zakat Fitrah','Zakat Maal','Infaq – Shodaqoh','Yatim','Fidyah',''];
        $itemMap   = [];
        $totalUang = 0; $totalBeras = 0;
        foreach (($data['items'] ?? []) as $it) {
            $itemMap[strtolower(trim($it['jenis'] ?? ''))] = $it;
            $totalUang  += (float)($it['uang']  ?? 0);
            $totalBeras += (float)($it['beras'] ?? 0);
        }
    @endphp
    <table class="zakat" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th style="width:18pt;">No.</th>
                <th>Jenis</th>
                <th style="width:72pt;">Uang</th>
                <th style="width:46pt;">Beras</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jenisList as $idx => $jn)
                @php
                    $it = $itemMap[strtolower(trim($jn))] ?? null;
                    $u  = $it ? (float)($it['uang']  ?? 0) : 0;
                    $b  = $it ? (float)($it['beras'] ?? 0) : 0;
                @endphp
                <tr>
                    <td class="t-no">{{ $idx+1 }}.</td>
                    <td>{{ $jn }}</td>
                    <td class="t-uang">Rp.&nbsp;@if($u > 0){{ number_format($u,0,',','.') }}@endif</td>
                    <td class="t-beras">@if($b > 0){{ number_format($b,1,',','.') }}@endif&nbsp;Lt/Kg</td>
                </tr>
            @endforeach
            <tr class="tr-total">
                <td colspan="2" class="t-no" style="text-align:center;">Jumlah</td>
                <td class="t-uang">Rp.&nbsp;@if($totalUang > 0){{ number_format($totalUang,0,',','.') }}@endif</td>
                <td class="t-beras">@if($totalBeras > 0){{ number_format($totalBeras,1,',','.') }}@endif&nbsp;Lt/Kg</td>
            </tr>
            <tr>
                <td colspan="4" class="t-terb">
                    <span class="terb-bold">Terbilang : </span>{{ $data['terbilang'] ?? '' }}
                </td>
            </tr>
        </tbody>
    </table>
</td>

</tr>
</table>

{{-- ARABIC + TANDA TANGAN --}}
<table class="bottom" cellspacing="0" cellpadding="0">
<tr>
    <td class="b-arabic">
        <div class="arabic-text">آجَرَكَ اللهُ فِيْمَا اَعْطَيْتَ، وَبَارَكَ فِيْمَا اَبْقَيْتَ وَجَعَلَهُ لَكَ طَهُوْرًا</div>
        <div class="arabic-trans">
            "Semoga Allah memberikan ganjaran pahala &nbsp;terhadap harta yang telah<br>
            engkau berikan dan menjadikannya penyuci bagimu."
        </div>
    </td>
    {{-- ← TTD rata kanan dengan text-align:right pada td, konten di dalam tetap kiri --}}
    <td class="b-sign">
        <div class="sign-city">Jakarta,&nbsp;<span class="sign-line">&nbsp;{{ $data['tanggal'] ?? '' }}</span></div>
        <div class="sign-amil">Amil / Penerima,</div>
        @php $seq = isset($data['daily_sequence']) && $data['daily_sequence'] ? str_pad($data['daily_sequence'], 2, '0', STR_PAD_LEFT) : null; @endphp
        <div class="sign-box">({{ $data['nama_amil'] ?: 'Admin UPZ' }}) @if($seq) — #{{ $seq }} @endif</div>
    </td>
</tr>
</table>

{{-- FOOTER --}}
<table class="footer" cellspacing="0" cellpadding="0">
<tr>
    <td class="f-contact">
        <div><b>Kontak :</b> (021) 8600524 (Hotline)</div>
        <div><b>Email &nbsp;:</b> ypdiaspb@gmail.com</div>
        <div><b>ig &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b> upz_ypdiaspb</div>
    </td>
    <td class="f-bsi">
        <div class="bsi-badge">BSI</div>
        <div class="bsi-sub">BANK SYARIAH<br>INDONESIA</div>
    </td>
    <td class="f-rek">
        <div><b>Rekening Zakat :</b> 450.450.4560</div>
        <div><b>an :</b> YPDI ASY-SYAAKIRIIN PONDOK BAMBU</div>
        <div style="font-weight:700;">Nomor Konfirmasi / Call Center : 0851-1156-2500 (Chat Only)</div>
    </td>
</tr>
</table>

</body>
</html>
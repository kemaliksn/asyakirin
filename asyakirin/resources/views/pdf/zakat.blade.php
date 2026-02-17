<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:5px; }
    </style>
</head>
<body>

<h2>TANDA TERIMA ZAKAT</h2>

<p>Nama: {{ $data['nama'] }}</p>
<p>Alamat: {{ $data['alamat'] }}</p>
<p>Atas Nama: </p>
<p>
    @if(is_array($data['atas_nama']))
    @foreach($data['atas_nama'] as $nama)
        {{ $nama }}<br>
    @endforeach
    @endif
</p>

<table>
    <tr>
        <th>No</th>
        <th>Jenis</th>
        <th>Uang</th>
        <th>Beras</th>
    </tr>

    @foreach($data['items'] as $index => $item)
    <tr>
        <td>{{ $index+1 }}</td>
        <td>{{ $item['jenis'] }}</td>
        <td>Rp {{ number_format($item['uang'],0,',','.') }}</td>
        <td>{{ $item['beras'] }} Kg</td>
    </tr>
    @endforeach
</table>

</body>
</html>

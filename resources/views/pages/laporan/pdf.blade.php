<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Anak - {{ now()->format('Ymd') }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #0b1c30; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #004ac6; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; margin: 0; }
        .subtitle { font-size: 14px; margin: 5px 0; color: #434655; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f1f5f9; color: #0b1c30; font-weight: bold; text-transform: uppercase; padding: 10px; border: 1px solid #e5eeff; }
        td { padding: 8px; border: 1px solid #e5eeff; text-align: left; }
        
        .info { margin-bottom: 15px; font-size: 11px; color: #434655; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #737686; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">SISTEM PENDATAAN ANAK YATIM</div>
        <div class="subtitle">Laporan Data Anak</div>
    </div>

    <div class="info">
        Filter: {{ $filter === 'under18' ? 'Anak di bawah 18 Tahun' : 'Semua Data' }} | 
        Total Data: {{ $total }} | 
        Dicetak pada: {{ $tanggal }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Registrasi</th>
                <th>Nama Anak</th>
                <th>NIK</th>
                <th>Kelamin</th>
                <th>Umur</th>
                <th>Kelurahan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($anak as $item)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>{{ $item->no_registrasi }}</td>
                <td>{{ $item->nama_lengkap }}</td>
                <td>{{ $item->nik }}</td>
                <td>{{ $item->jenis_kelamin }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} Tahun</td>
                <td>{{ $item->alamatDomisili->kelurahan->nama_kelurahan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh sistem pada {{ $tanggal }} - Halaman {PAGE_NUM}
    </div>
</body>
</html>
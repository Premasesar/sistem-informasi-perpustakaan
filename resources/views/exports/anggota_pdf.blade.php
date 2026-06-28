<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #198754; }
        .header p  { margin: 2px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #198754; color: white; padding: 8px; }
        td { padding: 6px 8px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background: #f0f9f4; }
        .footer { margin-top: 15px; font-size: 10px; color: #888; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN DATA ANGGOTA</h2>
        <p>Sistem Informasi Perpustakaan — STMIK El Rahma Yogyakarta</p>
        <p>Dicetak: {{ now()->format('d F Y, H:i') }}</p>
    </div>
    <table>
        <thead>
            <tr><th>#</th><th>Nama</th><th>Alamat</th><th>No HP</th><th>Email</th></tr>
        </thead>
        <tbody>
            @foreach($anggotas as $i => $a)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $a->nama }}</td>
                <td>{{ $a->alamat }}</td>
                <td>{{ $a->no_hp }}</td>
                <td>{{ $a->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">Total: {{ count($anggotas) }} anggota</div>
</body>
</html>
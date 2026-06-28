<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #1a3c5e; }
        .header p  { margin: 2px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #1a3c5e; color: white; padding: 8px; text-align: left; }
        td { padding: 6px 8px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background: #f0f4f8; }
        .footer { margin-top: 20px; font-size: 10px; color: #888; text-align: right; }
        .badge-dipinjam   { background: #dc3545; color: white; padding: 2px 6px; border-radius: 4px; }
        .badge-kembali    { background: #198754; color: white; padding: 2px 6px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN DATA BUKU</h2>
        <p>Sistem Informasi Perpustakaan — STMIK El Rahma Yogyakarta</p>
        <p>Dicetak: {{ now()->format('d F Y, H:i') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Kode Buku</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bukus as $i => $buku)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $buku->kode_buku }}</td>
                <td>{{ $buku->judul }}</td>
                <td>{{ $buku->penulis }}</td>
                <td>{{ $buku->penerbit }}</td>
                <td>{{ $buku->tahun }}</td>
                <td>{{ $buku->stok }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">Total: {{ count($bukus) }} buku</div>
</body>
</html>
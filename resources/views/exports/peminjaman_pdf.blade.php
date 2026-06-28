<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #1a3c5e; }
        .header p  { margin: 2px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #1a3c5e; color: white; padding: 7px; text-align: left; }
        td { padding: 5px 7px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background: #f0f4f8; }
        .badge { padding: 2px 6px; border-radius: 4px; color: white; font-size: 10px; }
        .dipinjam { background: #dc3545; }
        .kembali  { background: #198754; }
        .footer   { margin-top: 15px; font-size: 10px; color: #888; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN DATA PEMINJAMAN</h2>
        <p>Sistem Informasi Perpustakaan — STMIK El Rahma Yogyakarta</p>
        <p>Dicetak: {{ now()->format('d F Y, H:i') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Anggota</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->anggota->nama }}</td>
                <td>{{ $p->buku->judul }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('d/m/Y') }}</td>
                <td>
                    <span class="badge {{ $p->status === 'Dipinjam' ? 'dipinjam' : 'kembali' }}">
                        {{ $p->status }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">Total: {{ count($peminjamans) }} transaksi</div>
</body>
</html>
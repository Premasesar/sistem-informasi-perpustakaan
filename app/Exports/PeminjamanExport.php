<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PeminjamanExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    public function collection()
    {
        return Peminjaman::with(['anggota','buku'])->get()->map(function ($p, $i) {
            return [
                'No'          => $i + 1,
                'Anggota'     => $p->anggota->nama,
                'Buku'        => $p->buku->judul,
                'Tgl Pinjam'  => $p->tgl_pinjam,
                'Tgl Kembali' => $p->tgl_kembali,
                'Status'      => $p->status,
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Anggota', 'Judul Buku', 'Tgl Pinjam', 'Tgl Kembali', 'Status'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'dc3545']],
            ],
        ];
    }

    public function title(): string { return 'Data Peminjaman'; }
}
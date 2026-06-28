<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BukuExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    public function collection()
    {
        return Buku::select('kode_buku','judul','penulis','penerbit','tahun','stok')
            ->get()
            ->map(function ($b, $i) {
                return [
                    'No'       => $i + 1,
                    'Kode'     => $b->kode_buku,
                    'Judul'    => $b->judul,
                    'Penulis'  => $b->penulis,
                    'Penerbit' => $b->penerbit,
                    'Tahun'    => $b->tahun,
                    'Stok'     => $b->stok,
                ];
            });
    }

    public function headings(): array
    {
        return ['No', 'Kode Buku', 'Judul', 'Penulis', 'Penerbit', 'Tahun', 'Stok'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => '1a3c5e']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function title(): string { return 'Data Buku'; }
}
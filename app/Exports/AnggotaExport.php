<?php

namespace App\Exports;

use App\Models\Anggota;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AnggotaExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    public function collection()
    {
        return Anggota::all()->map(function ($a, $i) {
            return [
                'No'     => $i + 1,
                'Nama'   => $a->nama,
                'Alamat' => $a->alamat,
                'No HP'  => $a->no_hp,
                'Email'  => $a->email,
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Nama', 'Alamat', 'No HP', 'Email'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '198754']],
            ],
        ];
    }

    public function title(): string { return 'Data Anggota'; }
}
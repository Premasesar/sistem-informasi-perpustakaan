<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku     = Buku::count();
        $totalAnggota  = Anggota::count();
        $totalDipinjam = Peminjaman::where('status', 'Dipinjam')->count();
        $totalTersedia = Buku::sum('stok');

        $grafikPeminjaman = Peminjaman::select(
                DB::raw('MONTH(tgl_pinjam) as bulan'),
                DB::raw('YEAR(tgl_pinjam) as tahun'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('tgl_pinjam', date('Y'))
            ->groupBy('tahun', 'bulan')
            ->orderBy('bulan')
            ->get();

        $bulanLabel = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $grafikData = array_fill(0, 12, 0);
        foreach ($grafikPeminjaman as $g) {
            $grafikData[$g->bulan - 1] = $g->total;
        }

        $topBuku = Peminjaman::select('buku_id', DB::raw('COUNT(*) as total'))
            ->with('buku:id,judul')
            ->groupBy('buku_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $stokHampirHabis = Buku::where('stok', '<=', 2)->get();

        return view('dashboard.index', compact(
            'totalBuku', 'totalAnggota', 'totalDipinjam', 'totalTersedia',
            'bulanLabel', 'grafikData', 'topBuku', 'stokHampirHabis'
        ));
    }
}
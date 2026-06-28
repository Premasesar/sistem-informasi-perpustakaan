<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeminjamanExport;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('anggota', fn($q) => $q->where('nama', 'like', "%$search%"))
                      ->orWhereHas('buku', fn($q) => $q->where('judul', 'like', "%$search%"));
            })
            ->latest()
            ->paginate(10);

        return view('peminjaman.index', compact('peminjamans', 'search'));
    }

    public function create()
    {
        $anggotas = Anggota::all();
        $bukus    = Buku::where('stok', '>', 0)->get();
        return view('peminjaman.create', compact('anggotas', 'bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id'  => 'required|exists:anggotas,id',
            'buku_id'     => 'required|exists:bukus,id',
            'tgl_pinjam'  => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_pinjam',
        ]);

        $buku = Buku::findOrFail($request->buku_id);
        if ($buku->stok < 1) {
            return back()->with('error', 'Stok buku habis!');
        }
        $buku->decrement('stok');

        Peminjaman::create([
            'anggota_id'  => $request->anggota_id,
            'buku_id'     => $request->buku_id,
            'tgl_pinjam'  => $request->tgl_pinjam,
            'tgl_kembali' => $request->tgl_kembali,
            'status'      => 'Dipinjam',
        ]);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dicatat!');
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'Dikembalikan') {
            return back()->with('error', 'Buku sudah dikembalikan!');
        }

        $peminjaman->buku->increment('stok');

        $peminjaman->update(['status' => 'Dikembalikan']);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Buku berhasil dikembalikan!');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman dihapus!');
    }

    public function exportPdf()
    {
        $peminjamans = Peminjaman::with(['anggota','buku'])->get();
        $pdf = Pdf::loadView('exports.peminjaman_pdf', compact('peminjamans'))
                ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-peminjaman-' . date('Ymd') . '.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new PeminjamanExport, 'laporan-peminjaman-' . date('Ymd') . '.xlsx');
    }
}
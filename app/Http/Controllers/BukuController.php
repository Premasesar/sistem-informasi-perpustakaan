<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BukuExport;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Picqer\Barcode\BarcodeGeneratorPNG;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $bukus = Buku::when($search, function ($query) use ($search) {
                $query->where('judul', 'like', "%$search%")
                      ->orWhere('penulis', 'like', "%$search%")
                      ->orWhere('kode_buku', 'like', "%$search%");
            })
            ->latest()
            ->paginate(10);

        return view('buku.index', compact('bukus', 'search'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_buku' => 'required|unique:bukus',
            'judul'     => 'required',
            'penulis'   => 'required',
            'penerbit'  => 'required',
            'tahun'     => 'required|integer|min:1900|max:' . date('Y'),
            'stok'      => 'required|integer|min:0',
            'cover'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Buku::create($data);

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'kode_buku' => 'required|unique:bukus,kode_buku,' . $buku->id,
            'judul'     => 'required',
            'penulis'   => 'required',
            'penerbit'  => 'required',
            'tahun'     => 'required|integer|min:1900|max:' . date('Y'),
            'stok'      => 'required|integer|min:0',
            'cover'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('cover');

        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($data);

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }
        $buku->delete();

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil dihapus!');
    }

    public function exportPdf()
    {
        $bukus = Buku::all();
        $pdf = Pdf::loadView('exports.buku_pdf', compact('bukus'))
                ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-buku-' . date('Ymd') . '.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new BukuExport, 'laporan-buku-' . date('Ymd') . '.xlsx');
    }

    public function qrcode(Buku $buku)
    {
        $data = "Kode: {$buku->kode_buku}\nJudul: {$buku->judul}\nPenulis: {$buku->penulis}\nStok: {$buku->stok}";
        $qr   = QrCode::format('png')->size(300)->generate($data);
        return response($qr)->header('Content-Type', 'image/png');
    }

    public function barcode(Buku $buku)
    {
        $generator = new BarcodeGeneratorPNG();
        $barcode   = $generator->getBarcode($buku->kode_buku, $generator::TYPE_CODE_128, 3, 60);
        return response($barcode)->header('Content-Type', 'image/png');
    }

    public function showQrBarcode(Buku $buku)
    {
        // QR Code pakai SVG - tidak butuh imagick
        $qrSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
            ->size(300)
            ->generate("Kode: {$buku->kode_buku}\nJudul: {$buku->judul}\nPenulis: {$buku->penulis}\nStok: {$buku->stok}");

        // Barcode pakai PNG base64
        $generator     = new \Picqer\Barcode\BarcodeGeneratorPNG();
        $barcodeBase64 = base64_encode(
            $generator->getBarcode($buku->kode_buku, $generator::TYPE_CODE_128, 3, 60)
        );

        return view('buku.qrbarcode', compact('buku', 'qrSvg', 'barcodeBase64'));
    }
}
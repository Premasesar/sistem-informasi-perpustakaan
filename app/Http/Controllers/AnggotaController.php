<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AnggotaExport;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $anggotas = Anggota::when($search, function ($query) use ($search) {
                $query->where('nama', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%")
                      ->orWhere('no_hp', 'like', "%$search%");
            })
            ->latest()
            ->paginate(10);

        return view('anggota.index', compact('anggotas', 'search'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'   => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'alamat' => 'required',
            'no_hp'  => ['required', 'regex:/^(\+62[0-9]{7,10}|08[0-9]{8,11})$/'],
            'email'  => 'required|email|unique:anggotas',
        ], [
            'nama.required'  => 'Nama anggota wajib diisi.',
            'nama.regex'     => 'Nama hanya boleh berisi huruf dan spasi, tidak boleh mengandung angka atau karakter khusus.',
            'alamat.required'=> 'Alamat wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex'    => 'Nomor HP harus diawali 08 atau +62, dengan panjang 10-13 digit.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid, pastikan menggunakan tanda @.',
            'email.unique'   => 'Email ini sudah terdaftar.',
        ]);

        Anggota::create($request->all());

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function edit(Anggota $anggota)
    {
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $request->validate([
            'nama'   => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'alamat' => 'required',
            'no_hp'  => ['required', 'regex:/^(\+62[0-9]{7,10}|08[0-9]{8,11})$/'],
            'email'  => 'required|email|unique:anggotas,email,' . $anggota->id,
        ], [
            'nama.required'  => 'Nama anggota wajib diisi.',
            'nama.regex'     => 'Nama hanya boleh berisi huruf dan spasi, tidak boleh mengandung angka atau karakter khusus.',
            'alamat.required'=> 'Alamat wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex'    => 'Nomor HP harus diawali 08 atau +62, dengan panjang 10-13 digit.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid, pastikan menggunakan tanda @.',
            'email.unique'   => 'Email ini sudah terdaftar.',
        ]);

        $anggota->update($request->all());

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil diupdate!');
    }

    public function destroy(Anggota $anggota)
    {
        $anggota->delete();

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil dihapus!');
    }

    public function exportPdf()
    {
        $anggotas = Anggota::all();
        $pdf = Pdf::loadView('exports.anggota_pdf', compact('anggotas'))
                ->setPaper('a4', 'portrait');
        return $pdf->download('laporan-anggota-' . date('Ymd') . '.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new AnggotaExport, 'laporan-anggota-' . date('Ymd') . '.xlsx');
    }
}
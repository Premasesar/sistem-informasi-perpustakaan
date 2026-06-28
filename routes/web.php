<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;

// 1. Jika user mengakses halaman utama (/), otomatis lempar ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Rute spesifik untuk /login (karena file-nya ada di dalam folder auth)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// 3. Route untuk dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// ==========================================
// MODUL BUKU
// ==========================================
Route::get('/buku/export/pdf',       [BukuController::class, 'exportPdf'])->name('buku.export.pdf');
Route::get('/buku/export/excel',     [BukuController::class, 'exportExcel'])->name('buku.export.excel');
Route::get('/buku/{buku}/qrcode',    [BukuController::class, 'qrcode'])->name('buku.qrcode');
Route::get('/buku/{buku}/barcode',   [BukuController::class, 'barcode'])->name('buku.barcode');
Route::get('/buku/{buku}/qrbarcode', [BukuController::class, 'showQrBarcode'])->name('buku.qrbarcode');
Route::resource('buku', BukuController::class);


// ==========================================
// MODUL ANGGOTA
// ==========================================
Route::get('/anggota/export/pdf',    [AnggotaController::class, 'exportPdf'])->name('anggota.export.pdf');
Route::get('/anggota/export/excel',  [AnggotaController::class, 'exportExcel'])->name('anggota.export.excel');
Route::resource('anggota', AnggotaController::class)->parameters([
    'anggota' => 'anggota'
]);


// ==========================================
// MODUL PEMINJAMAN
// ==========================================
Route::get('/peminjaman/export/pdf',   [PeminjamanController::class, 'exportPdf'])->name('peminjaman.export.pdf');
Route::get('/peminjaman/export/excel', [PeminjamanController::class, 'exportExcel'])->name('peminjaman.export.excel');
Route::patch('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
Route::resource('peminjaman', PeminjamanController::class);


// ==========================================
// API & LAINNYA
// ==========================================
// Notifikasi stok habis (API endpoint untuk dashboard)
Route::get('/api/stok-habis', function () {
    $stokHabis = \App\Models\Buku::where('stok', 0)->get(['kode_buku','judul']);
    return response()->json($stokHabis);
})->name('api.stok.habis');
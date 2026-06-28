@extends('layouts.app')
@section('page-title', 'Buat Transaksi Peminjaman')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card p-3 border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf
                    
                    <h5 class="fw-bold mb-4" style="color: var(--primary-color);"><i class="fas fa-exchange-alt me-2"></i>Detail Transaksi</h5>
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">Pilih Anggota Peminjam</label>
                        <select name="anggota_id" class="form-select bg-light border-0 py-2 shadow-none @error('anggota_id') is-invalid @enderror">
                            <option value="">-- Cari atau Pilih Anggota --</option>
                            @foreach($anggotas as $anggota)
                                <option value="{{ $anggota->id }}" {{ old('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                    {{ $anggota->nama }} ({{ $anggota->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('anggota_id') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">Pilih Buku</label>
                        <select name="buku_id" class="form-select bg-light border-0 py-2 shadow-none @error('buku_id') is-invalid @enderror">
                            <option value="">-- Cari atau Pilih Buku --</option>
                            @foreach($bukus as $buku)
                                <option value="{{ $buku->id }}" {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                    {{ $buku->kode_buku }} - {{ $buku->judul }} (Stok Tersedia: {{ $buku->stok }})
                                </option>
                            @endforeach
                        </select>
                        @error('buku_id') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Tanggal Peminjaman</label>
                            <input type="date" name="tgl_pinjam" class="form-control bg-light border-0 px-3 py-2 shadow-none @error('tgl_pinjam') is-invalid @enderror" value="{{ old('tgl_pinjam', date('Y-m-d')) }}">
                            @error('tgl_pinjam') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Batas Tanggal Kembali</label>
                            <input type="date" name="tgl_kembali" class="form-control bg-light border-0 px-3 py-2 shadow-none @error('tgl_kembali') is-invalid @enderror" value="{{ old('tgl_kembali') }}">
                            @error('tgl_kembali') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm">
                            <i class="fas fa-paper-plane me-2"></i> Proses Peminjaman
                        </button>
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-light rounded-pill px-4 text-muted border">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 d-none d-lg-block">
        <div class="card p-3 border-0 rounded-4 h-100 shadow-sm" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-hover)); color: white;">
            <div class="card-body d-flex flex-column justify-content-center">
                <i class="fas fa-info-circle fa-3x mb-4 text-warning"></i>
                <h5 class="fw-bold mb-3">Aturan Peminjaman</h5>
                <ul class="small opacity-75 ps-3" style="line-height: 1.8;">
                    <li>Pastikan identitas anggota sudah benar.</li>
                    <li>Sistem otomatis hanya menampilkan buku yang stoknya lebih dari 0 (tersedia).</li>
                    <li>Stok buku akan otomatis berkurang setelah transaksi berhasil disimpan.</li>
                    <li>Tanggal kembali harus diatur lebih besar dari tanggal peminjaman.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
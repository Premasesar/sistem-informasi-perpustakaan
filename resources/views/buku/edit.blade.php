@extends('layouts.app')
@section('page-title', 'Edit Data Buku')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card p-3 border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form action="{{ route('buku.update', $buku) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-warning bg-opacity-10 p-2 rounded-3 me-3 text-warning">
                            <i class="fas fa-edit fa-lg"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-dark">Perbarui Informasi Buku</h5>
                    </div>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Kode Buku</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-barcode text-muted"></i></span>
                                <input type="text" name="kode_buku" class="form-control border-start-0 bg-light shadow-none @error('kode_buku') is-invalid @enderror" value="{{ old('kode_buku', $buku->kode_buku) }}">
                            </div>
                            @error('kode_buku') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Tahun Terbit</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-calendar-alt text-muted"></i></span>
                                <input type="number" name="tahun" class="form-control border-start-0 bg-light shadow-none @error('tahun') is-invalid @enderror" value="{{ old('tahun', $buku->tahun) }}">
                            </div>
                            @error('tahun') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark">Judul Buku</label>
                            <input type="text" name="judul" class="form-control bg-light border-0 px-3 py-2 shadow-none @error('judul') is-invalid @enderror" value="{{ old('judul', $buku->judul) }}">
                            @error('judul') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Penulis</label>
                            <input type="text" name="penulis" class="form-control bg-light border-0 px-3 py-2 shadow-none @error('penulis') is-invalid @enderror" value="{{ old('penulis', $buku->penulis) }}">
                            @error('penulis') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Penerbit</label>
                            <input type="text" name="penerbit" class="form-control bg-light border-0 px-3 py-2 shadow-none @error('penerbit') is-invalid @enderror" value="{{ old('penerbit', $buku->penerbit) }}">
                            @error('penerbit') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <hr style="border-color: #E8F5E9; margin: 2rem 0;">
                    
                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Jumlah Stok</label>
                            <input type="number" name="stok" class="form-control bg-light border-0 px-3 py-2 shadow-none @error('stok') is-invalid @enderror" value="{{ old('stok', $buku->stok) }}" min="0">
                            @error('stok') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Ganti Cover <span class="text-muted fw-normal">(Opsional)</span></label>
                            @if($buku->cover)
                                <div class="d-flex align-items-center gap-3 mb-2 p-2 bg-light rounded-3 border border-light">
                                    <img src="{{ asset('storage/'.$buku->cover) }}" class="rounded object-fit-cover shadow-sm" width="40" height="50">
                                    <small class="text-muted">Cover saat ini</small>
                                </div>
                            @endif
                            <input type="file" name="cover" class="form-control bg-light border-0 shadow-none @error('cover') is-invalid @enderror" accept="image/*">
                            @error('cover') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-warning rounded-pill px-5 shadow-sm text-dark fw-bold">
                            <i class="fas fa-save me-2"></i> Update Buku
                        </button>
                        <a href="{{ route('buku.index') }}" class="btn btn-light rounded-pill px-4 text-muted border">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 d-none d-lg-block">
        <div class="card p-3 bg-light border-0 rounded-4 h-100" style="border: 2px dashed #ffeeba !important;">
            <div class="card-body text-center text-muted d-flex flex-column justify-content-center align-items-center">
                <i class="fas fa-edit fa-4x mb-4 text-warning" style="opacity: 0.5;"></i>
                <h5 class="fw-bold text-dark">Mode Edit Data</h5>
                <p class="small mb-0">Ubah informasi buku yang diperlukan. Jika Anda tidak ingin mengganti gambar cover, biarkan saja bagian <strong>Ganti Cover</strong> tetap kosong.</p>
            </div>
        </div>
    </div>
</div>
@endsection
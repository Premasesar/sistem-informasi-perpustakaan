@extends('layouts.app')
@section('page-title', 'Tambah Buku')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card p-3 border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <h5 class="fw-bold mb-4" style="color: var(--primary-color);"><i class="fas fa-info-circle me-2"></i>Informasi Buku</h5>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Kode Buku</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-barcode text-muted"></i></span>
                                <input type="text" name="kode_buku" class="form-control border-start-0 bg-light shadow-none @error('kode_buku') is-invalid @enderror" value="{{ old('kode_buku') }}" placeholder="Contoh: BK-001">
                            </div>
                            @error('kode_buku') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Tahun Terbit</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-calendar-alt text-muted"></i></span>
                                <input type="number" name="tahun" class="form-control border-start-0 bg-light shadow-none @error('tahun') is-invalid @enderror" value="{{ old('tahun') }}" placeholder="{{ date('Y') }}">
                            </div>
                            @error('tahun') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark">Judul Buku</label>
                            <input type="text" name="judul" class="form-control bg-light border-0 px-3 py-2 shadow-none @error('judul') is-invalid @enderror" value="{{ old('judul') }}" placeholder="Masukkan judul buku lengkap">
                            @error('judul') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Penulis</label>
                            <input type="text" name="penulis" class="form-control bg-light border-0 px-3 py-2 shadow-none @error('penulis') is-invalid @enderror" value="{{ old('penulis') }}" placeholder="Nama Penulis">
                            @error('penulis') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Penerbit</label>
                            <input type="text" name="penerbit" class="form-control bg-light border-0 px-3 py-2 shadow-none @error('penerbit') is-invalid @enderror" value="{{ old('penerbit') }}" placeholder="Nama Penerbit">
                            @error('penerbit') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <hr style="border-color: #E8F5E9; margin: 2rem 0;">
                    <h5 class="fw-bold mb-4" style="color: var(--primary-color);"><i class="fas fa-boxes me-2"></i>Ketersediaan & Media</h5>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Jumlah Stok</label>
                            <input type="number" name="stok" class="form-control bg-light border-0 px-3 py-2 shadow-none @error('stok') is-invalid @enderror" value="{{ old('stok', 1) }}" min="0">
                            @error('stok') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Cover Buku <span class="text-muted fw-normal">(Opsional)</span></label>
                            <input type="file" name="cover" class="form-control bg-light border-0 shadow-none @error('cover') is-invalid @enderror" accept="image/*">
                            <small class="text-muted mt-1 d-block">Format: JPG, PNG. Maks: 2MB.</small>
                            @error('cover') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan Buku
                        </button>
                        <a href="{{ route('buku.index') }}" class="btn btn-light rounded-pill px-4 text-muted border">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 d-none d-lg-block">
        <div class="card p-3 bg-light border-0 rounded-4 h-100" style="border: 2px dashed #c3e6cb !important;">
            <div class="card-body text-center text-muted d-flex flex-column justify-content-center align-items-center">
                <i class="fas fa-book-medical fa-4x mb-4" style="color: var(--primary-color); opacity: 0.5;"></i>
                <h5 class="fw-bold text-dark">Tambah Koleksi Baru</h5>
                <p class="small mb-0">Pastikan kode buku bersifat unik. Formulir ini dirancang agar admin dapat memasukkan data buku dengan cepat dan efisien.</p>
            </div>
        </div>
    </div>
</div>
@endsection
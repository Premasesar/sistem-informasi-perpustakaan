@extends('layouts.app')
@section('page-title', 'Edit Data Anggota')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card p-3 border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning rounded-circle mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-user-edit fa-2x"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Perbarui Data Anggota</h5>
                    <p class="text-muted small">ID Anggota: <strong class="text-dark">#{{ str_pad($anggota->id, 4, '0', STR_PAD_LEFT) }}</strong></p>
                </div>

                <form action="{{ route('anggota.update', $anggota) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" name="nama" class="form-control border-start-0 bg-light shadow-none @error('nama') is-invalid @enderror" value="{{ old('nama', $anggota->nama) }}">
                            </div>
                            @error('nama') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control border-start-0 bg-light shadow-none @error('email') is-invalid @enderror" value="{{ old('email', $anggota->email) }}">
                            </div>
                            @error('email') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark">Nomor Handphone</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone-alt text-muted"></i></span>
                                <input type="text" name="no_hp" class="form-control border-start-0 bg-light shadow-none @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $anggota->no_hp) }}">
                            </div>
                            @error('no_hp') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control bg-light border-0 p-3 shadow-none @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat', $anggota->alamat) }}</textarea>
                            @error('alamat') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3 mt-5">
                        <a href="{{ route('anggota.index') }}" class="btn btn-light rounded-pill px-5 text-muted border">Batal</a>
                        <button type="submit" class="btn btn-warning rounded-pill px-5 shadow-sm fw-bold">
                            <i class="fas fa-save me-2"></i> Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
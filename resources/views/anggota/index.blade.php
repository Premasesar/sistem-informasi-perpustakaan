@extends('layouts.app')
@section('page-title', 'Data Anggota')

@section('content')
<div class="card p-3 border-0 shadow-sm rounded-4">
    <div class="card-body">

        {{-- Header: Search + Tombol --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <form class="d-flex bg-light rounded-pill px-3 py-1 align-items-center" style="border: 1px solid #E8F5E9; max-width: 400px; width: 100%;" method="GET" action="{{ route('anggota.index') }}">
                <i class="fas fa-search text-muted me-2"></i>
                <input type="text" name="search" class="form-control border-0 bg-transparent shadow-none" placeholder="Cari nama, email, no hp..." value="{{ $search }}">
            </form>
            
            <div class="d-flex gap-2">
                <a href="{{ route('anggota.export.pdf') }}" class="btn btn-outline-danger rounded-pill px-3">
                    <i class="fas fa-file-pdf me-1"></i> PDF
                </a>
                <a href="{{ route('anggota.export.excel') }}" class="btn btn-outline-success rounded-pill px-3">
                    <i class="fas fa-file-excel me-1"></i> Excel
                </a>
                <a href="{{ route('anggota.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-user-plus me-1"></i> Tambah Anggota
                </a>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="table-responsive">
            <table class="table align-middle table-hover table-borderless">
                <thead style="background-color: #F2F8F4;">
                    <tr>
                        <th class="rounded-start ps-3">Profil Anggota</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th class="text-center rounded-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggotas as $anggota)
                    <tr style="border-bottom: 1px solid #F2F8F4;">
                        <td class="ps-3 py-3">
                            <div class="d-flex align-items-center gap-3">
                                <!-- Ikon Profil dengan warna solid hijau dan flex-shrink-0 -->
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" 
                                     style="width: 42px; height: 42px; background: var(--primary-color); font-weight: bold; flex-shrink: 0;">
                                    {{ strtoupper(substr($anggota->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">{{ $anggota->nama }}</h6>
                                    <small class="text-muted">Bergabung: {{ \Carbon\Carbon::parse($anggota->created_at)->format('d M Y') }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-dark fw-medium"><i class="fas fa-envelope text-muted me-2"></i>{{ $anggota->email }}</div>
                            <small class="text-muted"><i class="fas fa-phone-alt text-muted me-2"></i>{{ $anggota->no_hp }}</small>
                        </td>
                        <td style="max-width: 250px;">
                            <p class="mb-0 text-muted small text-truncate" title="{{ $anggota->alamat }}">{{ $anggota->alamat }}</p>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('anggota.edit', $anggota) }}" class="btn btn-sm btn-light text-warning rounded-circle shadow-sm" style="width:35px;height:35px;line-height:22px;" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('anggota.destroy', $anggota) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus anggota ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-light text-danger rounded-circle shadow-sm" style="width:35px;height:35px;line-height:22px;" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-users fa-3x mb-3" style="opacity: 0.2;"></i>
                                <p class="mb-0">Tidak ada data anggota yang ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $anggotas->appends(['search' => $search])->links() }}
        </div>

    </div>
</div>
@endsection
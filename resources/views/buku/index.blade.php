@extends('layouts.app')
@section('page-title', 'Data Buku')

@section('content')
<div class="card p-3 border-0 shadow-sm rounded-4">
    <div class="card-body">

        {{-- Header: Search + Tombol --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <form class="d-flex bg-light rounded-pill px-3 py-1 align-items-center" style="border: 1px solid #E8F5E9; max-width: 400px; width: 100%;" method="GET" action="{{ route('buku.index') }}">
                <i class="fas fa-search text-muted me-2"></i>
                <input type="text" name="search" class="form-control border-0 bg-transparent shadow-none" placeholder="Cari judul, penulis, kode..." value="{{ $search }}">
            </form>
            
            <div class="d-flex gap-2">
                <a href="{{ route('buku.export.pdf') }}" class="btn btn-outline-danger rounded-pill px-3">
                    <i class="fas fa-file-pdf me-1"></i> PDF
                </a>
                <a href="{{ route('buku.export.excel') }}" class="btn btn-outline-success rounded-pill px-3">
                    <i class="fas fa-file-excel me-1"></i> Excel
                </a>
                <a href="{{ route('buku.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Buku
                </a>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="table-responsive">
            <table class="table align-middle table-hover table-borderless">
                <thead style="background-color: #F2F8F4;">
                    <tr>
                        <th class="rounded-start ps-3">Buku</th>
                        <th>Kode</th>
                        <th>Penerbit & Tahun</th>
                        <th>Stok</th>
                        <th class="text-center rounded-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bukus as $buku)
                    <tr style="border-bottom: 1px solid #F2F8F4;">
                        <td class="ps-3 py-3">
                            <div class="d-flex align-items-center gap-3">
                                @if($buku->cover)
                                    <img src="{{ asset('storage/'.$buku->cover) }}" alt="Cover" class="rounded-3 object-fit-cover shadow-sm" width="45" height="60">
                                @else
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted shadow-sm" style="width:45px; height:60px;">
                                        <i class="fas fa-book"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">{{ $buku->judul }}</h6>
                                    <small class="text-muted"><i class="fas fa-user-edit me-1"></i>{{ $buku->penulis }}</small>
                                </div>
                            </div>
                        </td>
                        <td><code class="bg-light px-2 py-1 rounded text-dark border">{{ $buku->kode_buku }}</code></td>
                        <td>
                            <div class="fw-medium text-dark">{{ $buku->penerbit }}</div>
                            <small class="text-muted">{{ $buku->tahun }}</small>
                        </td>
                        <td>
                            @if($buku->stok > 2)
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill"><i class="fas fa-check-circle me-1"></i>{{ $buku->stok }} Tersedia</span>
                            @elseif($buku->stok > 0)
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill"><i class="fas fa-exclamation-circle me-1"></i>{{ $buku->stok }} Sisa Sedikit</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill"><i class="fas fa-times-circle me-1"></i>Habis</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('buku.qrbarcode', $buku) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm" style="width:35px;height:35px;line-height:22px;" title="QR/Barcode">
                                    <i class="fas fa-qrcode"></i>
                                </a>
                                <a href="{{ route('buku.edit', $buku) }}" class="btn btn-sm btn-light text-warning rounded-circle shadow-sm" style="width:35px;height:35px;line-height:22px;" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('buku.destroy', $buku) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus buku ini?')">
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
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-book-open fa-3x mb-3" style="opacity: 0.2;"></i>
                                <p class="mb-0">Tidak ada data buku yang ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $bukus->appends(['search' => $search])->links() }}
        </div>

    </div>
</div>
@endsection
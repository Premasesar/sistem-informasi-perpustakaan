@extends('layouts.app')
@section('page-title', 'Transaksi Peminjaman')

@section('content')
<div class="card p-3 border-0 shadow-sm rounded-4">
    <div class="card-body">

        {{-- Header & Search --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <form class="d-flex bg-light rounded-pill px-3 py-1 align-items-center" style="border: 1px solid #E8F5E9; max-width: 400px; width: 100%;" method="GET" action="{{ route('peminjaman.index') }}">
                <i class="fas fa-search text-muted me-2"></i>
                <input type="text" name="search" class="form-control border-0 bg-transparent shadow-none" placeholder="Cari nama anggota atau buku..." value="{{ $search }}">
            </form>
            
            <div class="d-flex gap-2">
                <a href="{{ route('peminjaman.export.pdf') }}" class="btn btn-outline-danger rounded-pill px-3">
                    <i class="fas fa-file-pdf me-1"></i> PDF
                </a>
                <a href="{{ route('peminjaman.export.excel') }}" class="btn btn-outline-success rounded-pill px-3">
                    <i class="fas fa-file-excel me-1"></i> Excel
                </a>
                <a href="{{ route('peminjaman.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-hand-holding-heart me-1"></i> Transaksi Baru
                </a>
            </div>
        </div>

        {{-- Filter Status Pills --}}
        <div class="mb-4 d-flex gap-2">
            <a href="{{ route('peminjaman.index') }}" class="btn btn-sm rounded-pill px-3 {{ !request('status') ? 'btn-dark' : 'btn-outline-dark' }}">Semua</a>
            <a href="{{ route('peminjaman.index', ['status' => 'Dipinjam']) }}" class="btn btn-sm rounded-pill px-3 {{ request('status') == 'Dipinjam' ? 'btn-warning' : 'btn-outline-warning text-dark' }}">Dipinjam</a>
            <a href="{{ route('peminjaman.index', ['status' => 'Dikembalikan']) }}" class="btn btn-sm rounded-pill px-3 {{ request('status') == 'Dikembalikan' ? 'btn-success' : 'btn-outline-success' }}">Dikembalikan</a>
        </div>

        {{-- Tabel --}}
        <div class="table-responsive">
            <table class="table align-middle table-hover table-borderless">
                <thead style="background-color: #F2F8F4;">
                    <tr>
                        <th class="rounded-start ps-3">Peminjam</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Status</th>
                        <th class="text-center rounded-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $p)
                    <tr style="border-bottom: 1px solid #F2F8F4;">
                        <td class="ps-3 py-3">
                            <div class="d-flex align-items-center gap-3">
                                <!-- Ikon Profil dengan flex-shrink-0 agar tidak gepeng -->
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" 
                                     style="width: 38px; height: 38px; background: var(--primary-color); font-size: 0.9rem; font-weight: bold; flex-shrink: 0;">
                                    {{ strtoupper(substr($p->anggota->nama, 0, 1)) }}
                                </div>
                                <span class="fw-medium text-dark">{{ $p->anggota->nama }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="fw-medium text-dark text-truncate" style="max-width:200px;" title="{{ $p->buku->judul }}">{{ $p->buku->judul }}</div>
                            <small class="text-muted"><i class="fas fa-barcode me-1"></i>{{ $p->buku->kode_buku }}</small>
                        </td>
                        <td><span class="text-muted">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</span></td>
                        <td>
                            <span class="fw-medium text-dark">{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('d/m/Y') }}</span>
                            @if($p->status === 'Dipinjam' && \Carbon\Carbon::parse($p->tgl_kembali)->isPast())
                                <br><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1 mt-1"><i class="fas fa-exclamation-triangle me-1"></i>Terlambat</span>
                            @endif
                        </td>
                        <td>
                            @if($p->status === 'Dipinjam')
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill"><i class="fas fa-hourglass-half me-1"></i>Dipinjam</span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill"><i class="fas fa-check me-1"></i>Selesai</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                @if($p->status === 'Dipinjam')
                                <form action="{{ route('peminjaman.kembalikan', $p) }}" method="POST" onsubmit="return confirm('Proses pengembalian buku ini?')">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-success rounded-pill shadow-sm px-3" title="Tandai Dikembalikan">
                                        <i class="fas fa-undo me-1"></i> Kembali
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('peminjaman.destroy', $p) }}" method="POST" onsubmit="return confirm('Yakin hapus histori peminjaman ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-light text-danger rounded-circle shadow-sm" style="width:32px;height:32px;line-height:20px;" title="Hapus Data">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-clipboard-list fa-3x mb-3" style="opacity: 0.2;"></i>
                                <p class="mb-0">Tidak ada histori peminjaman.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $peminjamans->appends(['search' => $search])->links() }}
        </div>

    </div>
</div>
@endsection
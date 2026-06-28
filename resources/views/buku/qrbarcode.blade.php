@extends('layouts.app')
@section('page-title', 'QR Code & Barcode Buku')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card p-4 border-0 shadow-sm rounded-4">
            <div class="card-body">

                {{-- Info Header Tiket --}}
                <div class="d-flex align-items-center p-4 rounded-4 shadow-sm mb-5 position-relative overflow-hidden" 
                     style="background: linear-gradient(135deg, var(--primary-color), var(--primary-hover)); color: white;">
                    <!-- Aksen Dekoratif -->
                    <i class="fas fa-qrcode fa-10x position-absolute" style="right: -20px; bottom: -40px; opacity: 0.1;"></i>
                    
                    @if($buku->cover)
                        <img src="{{ asset('storage/'.$buku->cover) }}" height="100" class="rounded-3 shadow me-4" style="object-fit:cover; z-index: 1;">
                    @else
                        <div class="bg-white bg-opacity-25 rounded-3 d-flex align-items-center justify-content-center shadow me-4" style="width:75px; height:100px; z-index: 1;">
                            <i class="fas fa-book fa-3x text-white opacity-75"></i>
                        </div>
                    @endif
                    
                    <div style="z-index: 1;">
                        <span class="badge bg-white text-dark rounded-pill px-3 mb-2 shadow-sm">{{ $buku->kode_buku }}</span>
                        <h4 class="fw-bold mb-1">{{ $buku->judul }}</h4>
                        <div class="opacity-75 mb-2">
                            <i class="fas fa-user-edit me-1"></i> {{ $buku->penulis }} &nbsp;|&nbsp; 
                            <i class="fas fa-building me-1"></i> {{ $buku->penerbit }} ({{ $buku->tahun }})
                        </div>
                    </div>
                </div>

                {{-- Area QR Code & Barcode --}}
                <div class="row text-center g-4">
                    {{-- QR Code Card --}}
                    <div class="col-md-6">
                        <div class="card h-100 border-0 bg-light rounded-4">
                            <div class="card-body p-5">
                                <h6 class="fw-bold text-dark mb-4"><i class="fas fa-qrcode me-2" style="color: var(--primary-color);"></i>QR Code Pintar</h6>
                                
                                <div class="p-3 d-inline-block rounded-4 bg-white shadow-sm mb-4" style="border: 2px dashed #c3e6cb;">
                                    <div id="qrSvgContainer" style="width:200px; height:200px; margin:auto;">
                                        {!! $qrSvg !!}
                                    </div>
                                </div>
                                
                                <p class="text-muted small mb-4">Scan QR Code ini dengan smartphone untuk melihat metadata buku dengan cepat.</p>
                                
                                <button onclick="downloadSvgAsPng('qrSvgContainer', 'qrcode-{{ $buku->kode_buku }}.png', 300, 300)" class="btn btn-primary rounded-pill px-4 shadow-sm w-100">
                                    <i class="fas fa-download me-2"></i> Simpan QR Code
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Barcode Card --}}
                    <div class="col-md-6">
                        <div class="card h-100 border-0 bg-light rounded-4">
                            <div class="card-body p-5">
                                <h6 class="fw-bold text-dark mb-4"><i class="fas fa-barcode me-2" style="color: var(--primary-color);"></i>Label Barcode</h6>
                                
                                <div class="p-4 d-inline-block rounded-4 bg-white shadow-sm mb-4 w-100" style="border: 2px dashed #c3e6cb;">
                                    <img id="barcodeImg" src="data:image/png;base64,{{ $barcodeBase64 }}" alt="Barcode {{ $buku->kode_buku }}" class="img-fluid" style="max-height: 80px;">
                                    <div class="mt-3 text-dark fw-bold" style="letter-spacing: 2px;">{{ $buku->kode_buku }}</div>
                                </div>
                                
                                <p class="text-muted small mb-4">Gunakan scanner barcode fisik untuk memproses transaksi peminjaman lebih cepat.</p>
                                
                                <a href="data:image/png;base64,{{ $barcodeBase64 }}" download="barcode-{{ $buku->kode_buku }}.png" class="btn btn-primary rounded-pill px-4 shadow-sm w-100">
                                    <i class="fas fa-download me-2"></i> Simpan Barcode
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Panel Bawah --}}
                <div class="mt-5 p-4 rounded-4 d-flex align-items-center justify-content-between" style="background-color: #F2F8F4; border: 1px solid #E8F5E9;">
                    <div class="d-flex align-items-center text-muted">
                        <i class="fas fa-print fa-2x me-3 opacity-50"></i>
                        <div>
                            <strong class="d-block text-dark">Cetak Label Fisik</strong>
                            <span class="small">Atau Anda bisa langsung mencetak halaman ini menggunakan printer.</span>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('buku.index') }}" class="btn btn-light rounded-pill px-4 text-muted shadow-sm border">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <button onclick="window.print()" class="btn btn-dark rounded-pill px-4 shadow-sm">
                            <i class="fas fa-print me-2"></i> Print Layar
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar, .topbar, .btn, nav, .alert { display: none !important; }
    .main-content { margin-left: 0 !important; padding: 0 !important; }
    .card { box-shadow: none !important; border: none !important; }
    body { background: white !important; }
}
#qrSvgContainer svg {
    width: 100% !important;
    height: 100% !important;
}
</style>
@endsection

@section('scripts')
<script>
function downloadSvgAsPng(containerId, filename, width, height) {
    const container = document.getElementById(containerId);
    const svgEl = container.querySelector('svg');
    if (!svgEl) return alert('QR Code tidak ditemukan!');
    const svgData = new XMLSerializer().serializeToString(svgEl);
    const svgBase64 = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgData)));
    const canvas = document.createElement('canvas');
    canvas.width = width; canvas.height = height;
    const ctx = canvas.getContext('2d');
    ctx.fillStyle = '#ffffff'; ctx.fillRect(0, 0, width, height);
    const img = new Image();
    img.onload = function () {
        ctx.drawImage(img, 0, 0, width, height);
        const link = document.createElement('a');
        link.download = filename; link.href = canvas.toDataURL('image/png'); link.click();
    };
    img.src = svgBase64;
}
</script>
@endsection
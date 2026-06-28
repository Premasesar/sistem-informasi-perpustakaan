@extends('layouts.app')
@section('page-title', 'Dashboard')

@section('content')

{{-- Notifikasi Stok Habis --}}
@if($stokHampirHabis->count() > 0)
<div class="alert border-0 shadow-sm rounded-4 mb-4" style="background-color: #fff3cd; color: #856404; border-left: 5px solid #FFC107 !important;">
    <div class="d-flex align-items-center">
        <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; flex-shrink:0;">
            <i class="fas fa-exclamation-triangle fa-lg"></i>
        </div>
        <div>
            <strong class="d-block mb-1">Peringatan Stok!</strong>
            <span>Buku berikut stoknya menipis atau habis:</span>
            @foreach($stokHampirHabis as $b)
                <span class="badge {{ $b->stok == 0 ? 'bg-danger' : 'bg-warning text-dark' }} ms-1 rounded-pill px-3">
                    {{ $b->judul }} ({{ $b->stok }})
                </span>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Stat Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card text-white h-100 overflow-hidden border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #07863A, #0aab4a);">
            <div class="card-body p-4 position-relative">
                <div style="position: absolute; right: -15px; top: -15px; opacity: 0.15; transform: rotate(-15deg);">
                    <i class="fas fa-book fa-6x"></i>
                </div>
                <p class="mb-1 fw-medium" style="opacity: 0.9;">Total Buku</p>
                <h2 class="fw-bold mb-0 display-6">{{ $totalBuku }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-dark h-100 overflow-hidden border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #FFC107, #ffcd38);">
            <div class="card-body p-4 position-relative">
                <div style="position: absolute; right: -15px; top: -15px; opacity: 0.15; transform: rotate(-15deg);">
                    <i class="fas fa-users fa-6x"></i>
                </div>
                <p class="mb-1 fw-medium" style="opacity: 0.9;">Total Anggota</p>
                <h2 class="fw-bold mb-0 display-6">{{ $totalAnggota }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white h-100 overflow-hidden border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #dc3545, #e4606d);">
            <div class="card-body p-4 position-relative">
                <div style="position: absolute; right: -15px; top: -15px; opacity: 0.15; transform: rotate(-15deg);">
                    <i class="fas fa-exchange-alt fa-6x"></i>
                </div>
                <p class="mb-1 fw-medium" style="opacity: 0.9;">Buku Dipinjam</p>
                <h2 class="fw-bold mb-0 display-6">{{ $totalDipinjam }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white h-100 overflow-hidden border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #1a3c5e, #2d6a9f);">
            <div class="card-body p-4 position-relative">
                <div style="position: absolute; right: -15px; top: -15px; opacity: 0.15; transform: rotate(-15deg);">
                    <i class="fas fa-check-circle fa-6x"></i>
                </div>
                <p class="mb-1 fw-medium" style="opacity: 0.9;">Stok Tersedia</p>
                <h2 class="fw-bold mb-0 display-6">{{ $totalTersedia }}</h2>
            </div>
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="row g-4">
    <div class="col-md-8">
        <div class="card h-100 p-2 border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3" style="color: var(--primary-color);">
                        <i class="fas fa-chart-line fa-lg"></i>
                    </div>
                    <h5 class="fw-bold mb-0 text-dark">Grafik Peminjaman {{ date('Y') }}</h5>
                </div>
                <canvas id="grafikPeminjaman" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 p-2 border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-warning bg-opacity-10 p-2 rounded-3 me-3 text-warning">
                        <i class="fas fa-chart-pie fa-lg text-warning"></i>
                    </div>
                    <h5 class="fw-bold mb-0 text-dark">Top 5 Buku Terpinjam</h5>
                </div>
                @if($topBuku->count() > 0)
                    <div style="position: relative; height: 220px; width: 100%;">
                        <canvas id="grafikTopBuku"></canvas>
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-book-open fa-3x mb-3" style="opacity:0.2"></i>
                        <p>Belum ada data peminjaman</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Grafik Line (Peminjaman)
const ctx = document.getElementById('grafikPeminjaman').getContext('2d');
let gradient = ctx.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, 'rgba(7, 134, 58, 0.4)');
gradient.addColorStop(1, 'rgba(7, 134, 58, 0.0)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($bulanLabel) !!},
        datasets: [{
            label: 'Jumlah Peminjaman',
            data: {!! json_encode($grafikData) !!},
            borderColor: '#07863A',
            backgroundColor: gradient,
            borderWidth: 3,
            pointBackgroundColor: '#07863A',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7,
            fill: true,
            tension: 0.4 // Membuat kurva melengkung halus
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 },
                grid: { borderDash: [5, 5], color: '#E8F5E9' }
            },
            x: { grid: { display: false } }
        }
    }
});

// Grafik Top 5 Buku (hanya render jika ada data)
@if($topBuku->count() > 0)
const ctx2 = document.getElementById('grafikTopBuku').getContext('2d');
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($topBuku->map(fn($t) => \Illuminate\Support\Str::limit($t->buku->judul ?? '-', 20))) !!},
        datasets: [{
            data: {!! json_encode($topBuku->pluck('total')) !!},
            backgroundColor: ['#07863A', '#FFC107', '#1a3c5e', '#dc3545', '#17a2b8'],
            borderWidth: 0,
            hoverOffset: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: {family: 'Poppins'} } }
        },
        cutout: '75%'
    }
});
@endif
</script>
@endsection
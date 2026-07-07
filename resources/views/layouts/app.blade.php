<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Dashboard') - Sistem Informasi Perpustakaan</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Variabel Warna Modern - Nuansa Hijau STMIK El Rahma */
        :root {
            --primary-color: #07863A; /* Hijau utama dari poster */
            --primary-hover: #056b2e; /* Hijau lebih gelap untuk hover */
            --accent-color: #FFC107; /* Aksen kuning dari poster */
            --secondary-color: #E8F5E9; /* Hijau sangat muda untuk panel/aksen */
            --text-main: #1a2e21; /* Teks utama bernuansa hijau gelap */
            --text-muted: #798f80; /* Teks redup */
            --bg-body: #F2F8F4; /* Background body dengan hint hijau lembut */
            --white: #FFFFFF;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* Sidebar Styling Modern */
        .sidebar {
            width: 280px;
            background: var(--white);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 2rem 1.5rem;
            box-shadow: 14px 0 24px rgba(7, 134, 58, 0.06);
            z-index: 1000;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #E8F5E9;
        }

        .sidebar-logo-icon {
            background: var(--primary-color);
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(7, 134, 58, 0.3);
        }

        .nav-link {
            color: var(--text-muted);
            font-weight: 500;
            padding: 12px 20px;
            border-radius: 12px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-link:hover {
            color: var(--primary-color);
            background: var(--secondary-color);
            transform: translateX(5px);
        }

        .nav-link.active {
            background: var(--primary-color);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(7, 134, 58, 0.2);
        }

        /* Main Content Area */
        .main-content {
            margin-left: 280px;
            padding: 2rem 3rem;
            min-height: 100vh;
        }

        /* Navbar/Top Bar Styling */
        .topbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 15px 24px;
            box-shadow: 0 4px 20px rgba(7, 134, 58, 0.05);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Card Styling Modern */
        .card {
            border: none;
            border-radius: 20px;
            background: var(--white);
            box-shadow: 0 4px 24px rgba(7, 134, 58, 0.05);
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .btn {
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            box-shadow: 0 4px 12px rgba(7, 134, 58, 0.3);
        }
        
        /* Table Styling Modern */
        .table > :not(caption) > * > * {
            padding: 1rem 1rem;
            border-bottom-color: #E8F5E9;
        }
        
        thead th {
            color: var(--text-muted);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: none !important;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header d-flex align-items-center gap-3">
            <div class="sidebar-logo-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0 text-dark">Sistem Informasi Perpustakaan</h6>
                <small class="text-muted" style="font-size: 0.75rem;">STMIK El Rahma</small>
            </div>
        </div>

        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-home fa-fw"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('buku.*') ? 'active' : '' }}" href="{{ route('buku.index') }}">
                <i class="fas fa-book fa-fw"></i> Data Buku
            </a>
            <a class="nav-link {{ request()->routeIs('anggota.*') ? 'active' : '' }}" href="{{ route('anggota.index') }}">
                <i class="fas fa-users fa-fw"></i> Data Anggota
            </a>
            <a class="nav-link {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}" href="{{ route('peminjaman.index') }}">
                <i class="fas fa-exchange-alt fa-fw"></i> Peminjaman
            </a>

            <hr style="border-color: var(--secondary-color); margin: 15px 20px; opacity: 0.5;">

            <form action="{{ route('logout') }}" method="POST" class="px-2">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start" style="color: #dc3545;">
                    <i class="fas fa-sign-out-alt fa-fw"></i> Keluar
                </button>
            </form>
        </nav>
        
        <div class="mt-auto">
            <div class="p-2 bg-light rounded-3 d-flex align-items-center gap-2" style="border: 1px solid var(--secondary-color);">
                <img src="https://ui-avatars.com/api/?name=AP&background=07863A&color=fff" class="rounded-circle flex-shrink-0" width="32" alt="Admin">
                <div class="text-start overflow-hidden">
                    <h6 class="mb-0 fw-bold text-truncate" style="font-size: 0.75rem;">Admin Perpustakaan</h6>
                    <small class="text-muted" style="font-size: 0.65rem;">
                        <i class="fas fa-circle text-success me-1" style="font-size: 6px; vertical-align: middle;"></i>Online
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
        
        <div class="topbar">
            <div>
                <small class="text-muted fw-medium">Halaman Utama /</small>
                <h4 class="fw-bold mb-0" style="color: var(--text-main);">@yield('page-title')</h4>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="bg-light p-2 rounded-circle" style="cursor: pointer; color: var(--primary-color);">
                    <i class="fas fa-bell"></i>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4" role="alert" style="background-color: var(--secondary-color); color: var(--primary-color);">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Perpustakaan STMIK El Rahma</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #07863A; /* Hijau khas STMIK El Rahma */
            --primary-hover: #056b2e;
            --accent-color: #FFC107; /* Aksen kuning */
        }

        body, html {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            overflow: hidden;
        }

        /* Latar Belakang Perpustakaan dengan Banyak Buku & Overlay Hijau */
        .login-bg {
            height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Gambar rak perpustakaan megah dari Unsplash */
            background: linear-gradient(
                rgba(7, 134, 58, 0.8), 
                rgba(2, 48, 20, 0.9)
            ), 
            url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center;
            background-size: cover;
        }

        /* Efek Glassmorphism untuk Kartu Login */
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 450px;
            padding: 3rem 2.5rem;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
        }

        .logo-icon {
            background: var(--primary-color);
            color: white;
            width: 65px;
            height: 65px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.5rem auto;
            box-shadow: 0 8px 20px rgba(7, 134, 58, 0.35);
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 18px;
            border: 1px solid #dce0e5;
            background-color: #f8f9fa;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: none;
            background-color: #ffffff;
        }

        /* Styling Input Group agar serasi dengan tombol mata */
        .input-group:focus-within {
            box-shadow: 0 0 0 0.25rem rgba(7, 134, 58, 0.25);
            border-radius: 12px;
        }

        .input-group-text {
            border-radius: 12px 0 0 12px;
            background-color: transparent;
            border-right: none;
            color: #6c757d;
            border-color: #dce0e5;
        }

        .form-control.with-icon {
            border-left: none;
        }

        /* Tombol Toggle Mata */
        .btn-toggle-pass {
            border-radius: 0 12px 12px 0;
            border: 1px solid #dce0e5;
            border-left: none;
            background-color: #f8f9fa;
            color: #6c757d;
        }
        
        .btn-toggle-pass:hover, .btn-toggle-pass:focus {
            background-color: #ffffff;
            color: var(--primary-color);
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control,
        .input-group:focus-within .btn-toggle-pass {
            border-color: var(--primary-color);
            background-color: #ffffff;
        }

        /* Tombol Masuk */
        .btn-login {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 1.05rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background-color: var(--primary-hover);
            box-shadow: 0 8px 20px rgba(7, 134, 58, 0.35);
            color: white;
            transform: translateY(-2px);
        }

        /* Link Lupa Password */
        .link-forgot {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .link-forgot:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-bg">
        <div class="login-card">
            
            <div class="logo-icon">
                <i class="fas fa-book-reader"></i>
            </div>
            <div class="text-center mb-4">
                <h4 class="fw-bold text-dark mb-1">Sistem Informasi Perpustakaan</h4>
                <p><b>STMIK El RAHMA YOGYAKARTA</b></p>
            </div>

            <form action="{{ route('dashboard') }}" method="GET">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-medium text-dark small">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control with-icon" placeholder="admin@elrahma.ac.id" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-medium text-dark small d-flex justify-content-between">
                        <span>Password</span>
                        <a href="#" onclick="alert('Fitur Reset Password akan segera diaktifkan. Silakan hubungi Administrator Server STMIK El Rahma.')" class="link-forgot">Lupa Password?</a>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="passwordField" class="form-control with-icon" placeholder="••••••••" required>
                        <button class="btn btn-toggle-pass" type="button" id="togglePasswordBtn">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" style="cursor: pointer;">
                    <label class="form-check-label text-muted small" for="remember" style="cursor: pointer;">Ingat Saya</label>
                </div>

                <button type="submit" class="btn btn-login w-100 mb-3">
                    <i class="fas fa-sign-in-alt me-2"></i> MASUK
                </button>
                
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const passwordField = document.getElementById('passwordField');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePasswordBtn.addEventListener('click', function () {
            // Cek apakah tipenya saat ini password
            if (passwordField.type === 'password') {
                // Ubah menjadi text agar sandi terlihat
                passwordField.type = 'text';
                // Ganti ikon mata menjadi dicoret
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                // Kembalikan ke password agar sandi tersembunyi
                passwordField.type = 'password';
                // Ganti kembali ke ikon mata biasa
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>
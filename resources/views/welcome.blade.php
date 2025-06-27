<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang - Aplikasi Pengaduan Masyarakat</title>
    <link rel="icon" href="{{ asset('storage/foto_profil/logo-2.png') }}" type="image/png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero {
            position: relative;
            height: 100vh;
            overflow: hidden;
        }
        .hero .carousel-inner,
        .hero .carousel-item,
        .hero .carousel-item img {
            height: 100%;
        }
        .hero .carousel-item img {
        object-fit: cover;
        width: 100%;
        height: 100%;
        min-height: 1000px; /* Tambahan agar tetap terlihat di HP */
        }
        .hero-content {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 10;
            width: 100%;
            height: 100%;
            background-color: rgba(17, 57, 116, 0.6); /* Overlay gelap */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 2rem;
        }
        .btn-custom {
            background-color: #fff;
            color: #113974;
            border-radius: 30px;
            font-weight: 600;
        }
        .btn-custom:hover {
            background-color: #0d2c5c;
            color: #fff;
        }
        .section-info {
            padding: 3rem 2rem;
        }
        .icon {
            font-size: 2rem;
            color: #113974;
        }
        @media (max-width: 768px) {
            .hero {
                height: 70vh; /* Atur agar tidak terlalu tinggi di HP */
            }
            .hero .carousel-item img {
                object-position: center;
            }
            .hero-content h1 {
                font-size: 1.75rem;
            }
            .hero-content p.lead {
                font-size: 1rem;
            }
        }

    </style>
</head>
<body>

    <!-- Hero Section with Background Carousel -->
    <div class="hero">
        <!-- Carousel Background -->
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('storage/slide/slide1.jpg') }}" class="d-block w-100" alt="Slide 1">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('storage/slide/slide2.jpg') }}" class="d-block w-100" alt="Slide 2">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('storage/slide/slide3.jpg') }}" class="d-block w-100" alt="Slide 3">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('storage/slide/slide4.jpg') }}" class="d-block w-100" alt="Slide 4">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('storage/slide/slide5.jpg') }}" class="d-block w-100" alt="Slide 5">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('storage/slide/slide6.jpg') }}" class="d-block w-100" alt="Slide 6">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('storage/slide/slide7.jpg') }}" class="d-block w-100" alt="Slide 7">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('storage/slide/slide8.jpg') }}" class="d-block w-100" alt="Slide 8">
                </div>
            </div>
        </div>

        <!-- Overlay Content -->
        <div class="hero-content">
            <img src="{{ asset('storage/foto_profil/logo.png') }}" alt="Logo Desa" class="img-fluid mb-3" style="max-height: 120px;">
            <h1 class="display-5 fw-bold">Aplikasi Pengaduan Masyarakat Desa Taman</h1>
            <p class="lead mt-3">Sampaikan keluhan Anda secara cepat, mudah, dan tepat sasaran.</p>
            <div class="mt-4">
                <a href="{{ route('login') }}" class="btn btn-custom px-4 me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-light px-4">Daftar</a>
            </div>
        </div>
    </div>

    <!-- Informasi Umum -->
    <div class="section-info text-center">
        <div class="container">
            <h2 class="mb-4">Bagaimana Cara Kerja Aplikasi Ini?</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="icon mb-2"><i class="fa fa-user-plus"></i></div>
                    <h5>1. Daftar</h5>
                    <p>Buat akun dengan data sesuai identitas warga.</p>
                </div>
                <div class="col-md-3">
                    <div class="icon mb-2"><i class="fa fa-edit"></i></div>
                    <h5>2. Buat Pengaduan</h5>
                    <p>Isi formulir keluhan yang ingin disampaikan.</p>
                </div>
                <div class="col-md-3">
                    <div class="icon mb-2"><i class="fa fa-refresh"></i></div>
                    <h5>3. Pantau Proses</h5>
                    <p>Lihat status pengaduan Anda secara langsung.</p>
                </div>
                <div class="col-md-3">
                    <div class="icon mb-2"><i class="fa fa-check-circle"></i></div>
                    <h5>4. Selesai</h5>
                    <p>Terima notifikasi saat pengaduan ditindaklanjuti.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 text-muted" style="font-size: 0.9rem;">
        &copy; {{ date('Y') }} Kantor Desa Taman - Kecamatan Abiansemal. All rights reserved.
    </footer>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
</body>
</html>

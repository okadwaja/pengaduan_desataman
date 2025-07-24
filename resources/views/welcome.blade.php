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
        .btn-main {
            background-color: #113974 !important;
            color: white !important;
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
                <div class="carousel-item">
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
                <div class="carousel-item active">
                    <img src="{{ asset('storage/slide/slide9.jpg') }}" class="d-block w-100" alt="Slide 8">
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

        <div class="container my-5">
            <h3 class="mb-4 text-center text-main">Daftar Pengaduan Bulan {{ \Carbon\Carbon::createFromFormat('m', $bulan)->locale('id')->isoFormat('MMMM') }} {{ $tahun }}</h3>

            <!-- Form filter bulan -->
            <div class="d-flex justify-content-center">
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <select name="bulan" class="form-select" required>
                            @foreach(range(1, 12) as $i)
                                <option value="{{ sprintf('%02d', $i) }}" {{ $bulan == sprintf('%02d', $i) ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::createFromFormat('m', $i)->locale('id')->isoFormat('MMMM') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="tahun" class="form-control" value="{{ $tahun }}" required>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-main w-100" type="submit">Tampilkan</button>
                    </div>
                </form>
            </div>

            @if ($pengaduan->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover small table-striped">
                        <thead class="table-light text-center align-middle">
                            <tr>
                                <th>No</th>
                                <th>Nama Pelapor</th>
                                <th>Judul</th>
                                <th>Isi</th>
                                <th>Tanggal Laporan</th>
                                <th>Status</th>
                                <th>Tanggapan</th>
                                <th>Tanggal Tanggapan</th>
                                <th>Gambar</th>
                            </tr>
                        </thead>
                        <tbody class="text-start">
                            @foreach ($pengaduan as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $item->user->name ?? '-' }}</td>
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ Str::limit($item->isi, 100) }}</td>
                                    <td>{{ $item->created_at->format('d M Y') }}</td>
                                    @php
                                        $status = strtolower($item->status);
                                        $badgeClass = match($status) {
                                            'menunggu' => 'warning',
                                            'diproses' => 'primary',
                                            'dieksekusi'  => 'success',
                                            'ditolak'  => 'danger',
                                            'terverifikasi' => 'info',
                                            'berkas tidak valid' => 'danger',
                                            'ditunda' => 'dark',
                                            default    => 'secondary'
                                        };
                                    @endphp
                                    <td>
                                        <span class="badge bg-{{ $badgeClass }} text-white">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $item->tanggapan->komentar ?? '-' }}</td>
                                    <td>{{ $item->tanggapan?->created_at ? $item->tanggapan->created_at->format('d M Y') : '-' }}</td>
                                    <td>
                                        @if($item->foto)
                                            <img src="{{ asset('storage/foto_pengaduan/' . $item->foto) }}" alt="foto" style="width: 60px; cursor: pointer;" onclick="showImage('{{ asset('storage/foto_pengaduan/' . $item->foto) }}')">
                                        @else
                                            Tidak ada
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-muted">Belum ada pengaduan di bulan ini.</p>
            @endif
        </div>

    </div>

    <!-- Footer -->
    <footer class="text-center py-4 text-muted" style="font-size: 0.9rem;">
        &copy; {{ date('Y') }} Kantor Desa Taman - Kecamatan Abiansemal. All rights reserved.
    </footer>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>

    <!-- Modal Gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body text-center">
                    <img src="" id="modalImage" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </div>

    <script>
        function showImage(url) {
            const modalImage = document.getElementById('modalImage');
            modalImage.src = url;
            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            modal.show();
        }
    </script>

</body>
</html>

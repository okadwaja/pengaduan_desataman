@extends('layouts.app')

@section('content')

{{-- SweetAlert untuk pesan --}}
@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d33'
        });
    </script>
@endif

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6'
        });
    </script>
@endif

<div class="container text-main">
    <div class="mb-3">
        <h1 class="mb-0">Daftar Pengaduan Anda</h1>
        <a href="{{ route('masyarakat.pengaduan.create') }}" class="btn btn-main mt-2">
            <i class="fas fa-pen me-2"></i> Buat Pengaduan Baru
        </a>
    </div>

    @if($pengaduan->isEmpty())
        <div class="alert alert-info mt-3">Belum ada pengaduan.</div>
    @else
    <div class="d-flex flex-wrap gap-3 mt-3 justify-content-center justify-content-md-start">
        @foreach($pengaduan as $item)
            <div class="card shadow-sm position-relative" style="width: 100%; max-width: 380px; position: relative;">
                {{-- Icon Titik 3 --}}
                <div class="dropdown position-absolute end-0 mt-2 me-2" style="z-index: 10;">
                    <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('masyarakat.pengaduan.show', $item->id) }}">Detail</a></li>
                        <li><a class="dropdown-item" href="{{ route('masyarakat.pengaduan.edit', $item->id) }}">Edit</a></li>
                        @if ($item->user_id == Auth::id())
                            <li>
                                <form action="{{ route('masyarakat.pengaduan.destroy', $item->id) }}" method="POST" id="delete-form-{{ $item->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="dropdown-item text-danger" onclick="confirmDelete({{ $item->id }})">Hapus</button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>

                {{-- Gambar --}}
                @if($item->foto)
                    <img src="{{ asset('storage/foto_pengaduan/' . $item->foto) }}" class="card-img-top" style="object-fit: cover; height: 180px;" alt="Foto Pengaduan">
                @else
                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 180px;">
                        <span class="text-muted">Tidak ada foto</span>
                    </div>
                @endif

                {{-- Konten --}}
                <div class="card-body">
                    <h6 class="card-title mb-1"><strong>{{ $item->judul }}</strong></h6>
                    <p class="card-text text-truncate mb-2" style="max-height: 3em;">{{ $item->isi }}</p>
                    @php
                        $status = strtolower($item->status);
                        $badgeClass = match($status) {
                            'menunggu' => 'warning',
                            'diproses' => 'primary',
                            'dieksekusi'  => 'success',
                            'ditunda' => 'dark',
                            'ditolak'  => 'danger',
                            'terverifikasi' => 'info',
                            'berkas tidak valid' => 'danger',
                            default    => 'secondary'
                        };
                    @endphp
                    <span class="badge bg-{{ $badgeClass }} text-white">{{ ucfirst($item->status) }}</span>
                    <div class="small text-muted mt-1">
                        {{ $item->created_at->translatedFormat('d M Y H:i') }} WITA
                    </div>

                    <!-- Link ke detail -->
                    <a href="{{ route('masyarakat.pengaduan.show', $item->id) }}" class="stretched-link"></a>
                </div>
            </div>
        @endforeach
    </div>
    @endif
</div>

{{-- Script konfirmasi hapus --}}
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data pengaduan ini akan dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection

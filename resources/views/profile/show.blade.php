@extends('layouts.app')

@section('content')

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

<div class="container px-1 text-main">
    <h1 class="text-main mb-4 text-center">Profil Saya</h1>

    <div class="row justify-content-center">
        <!-- Foto Profil -->
        <div class="col-12 col-md-6 mb-4 text-center">
            <img src="{{ asset('storage/foto_profil/' . $user->foto) }}" 
                class="img-thumbnail rounded-circle mx-auto" 
                style="width: 150px; height: 150px; object-fit: cover;" 
                alt="Foto Profil">
        </div>

        <!-- Detail Profil -->
        <div class="col-12 col-md-8">
            <div class="overflow-auto">
                <ul class="list-group mb-4 border-left-main" style="min-width: 300px; white-space: nowrap;">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <strong>Nama:</strong> <span class="text-break">{{ $user->name }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <strong>NIK:</strong> <span class="text-break">{{ $user->nik }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <strong>No Telepon:</strong> <span class="text-break">{{ $user->no_telp }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <strong>Alamat:</strong> <span class="text-break">{{ $user->alamat }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <strong>Email:</strong> <span class="text-break">{{ $user->email }}</span>
                    </li>
                </ul>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary w-100 w-md-auto">Kembali</a>
                @else
                    <a href="{{ route('masyarakat.dashboard') }}" class="btn btn-secondary w-100 w-md-auto">Kembali</a>
                @endif

                <a href="{{ route('profile.edit') }}" class="btn btn-primary w-100 w-md-auto">Edit Profil</a>
            </div>
        </div>
    </div>
</div>
@endsection

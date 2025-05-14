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

<div class="container text-main">
    <h1 class="text-main mb-4 text-center">Profil Saya</h1>

    <div class="row justify-content-center">
        <div class="col-md-6 mb-4">
            <img src="{{ asset('storage/foto_profil/' . $user->foto) }}" 
                class="img-thumbnail rounded-circle mx-auto d-block" 
                style="width: 150px; height: 150px; object-fit: cover;" 
                alt="Foto Profil">
        </div>

        <div class="col-md-8">
            <ul class="list-group mb-4 border-left-main">
                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <strong>Nama:</strong> <span>{{ $user->name }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <strong>NIK:</strong> <span>{{ $user->nik }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <strong>No Telepon:</strong> <span>{{ $user->no_telp }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <strong>Alamat:</strong> <span>{{ $user->alamat }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <strong>Email:</strong> <span>{{ $user->email }}</span>
                </li>
            </ul>

            <div class="d-flex justify-content-between">
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
                @else
                    <a href="{{ route('masyarakat.dashboard') }}" class="btn btn-secondary">Kembali</a>
                @endif

                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profil</a>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container text-main">
    <h1 class="text-main mb-4 text-center">Detail Petugas</h1>

    <div class="row justify-content-center">
        <div class="col-md-6 mb-4">
            <img src="{{ asset('storage/foto_profil/' . $user->foto) }}"
                class="img-thumbnail rounded-circle mx-auto d-block"
                style="width: 150px; height: 150px; object-fit: cover;"
                alt="Foto Profil">
        </div>

        <div class="col-12 col-md-8">
            <div class="overflow-auto">
                <ul class="list-group mb-4 border-left-main" style="min-width: 300px; white-space: nowrap;">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <strong>Nama:</strong> <span>{{ $user->name }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <strong>Email:</strong> <span>{{ $user->email }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <strong>Role:</strong> <span>{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
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
                </ul>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.petugas.index') }}" class="btn btn-secondary">Kembali</a>
                {{-- Tambahkan fitur download PDF jika dibutuhkan --}}
            </div>
        </div>
    </div>
</div>
@endsection

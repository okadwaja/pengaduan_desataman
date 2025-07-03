@extends('layouts.app')

@section('content')
<div class="container text-main">
    <h1 class="text-main mb-4 text-center">Detail Petugas</h1>

    <div class="row justify-content-center">
        <div class="col-md-6 mb-4 text-center">
            @php
                $foto = $user->admin->foto ?? $user->kepalaDesa->foto ?? 'default.png';
            @endphp
            <img src="{{ asset('storage/foto_profil/' . $foto) }}" 
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

                    @if($user->role === 'admin' && $user->admin)
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <strong>NIP:</strong> <span>{{ $user->admin->nip }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <strong>Jabatan:</strong> <span>{{ $user->admin->jabatan }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <strong>No Telepon:</strong> <span>{{ $user->admin->no_telp }}</span>
                        </li>
                    @elseif($user->role === 'kepala_desa' && $user->kepalaDesa)
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <strong>NIP:</strong> <span>{{ $user->kepalaDesa->nip }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <strong>Masa Jabatan:</strong> <span>{{ $user->kepalaDesa->masa_jabatan }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <strong>No Telepon:</strong> <span>{{ $user->kepalaDesa->no_telp }}</span>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.petugas.index') }}" class="btn btn-secondary">Kembali</a>
                {{-- Export PDF (opsional, tambahkan jika diinginkan) --}}
                {{-- <a href="#" class="btn btn-danger" target="_blank">
                    <i class="fas fa-file-pdf"></i> Download PDF
                </a> --}}
            </div>
        </div>
    </div>
</div>
@endsection

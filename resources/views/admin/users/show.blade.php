@extends('layouts.app')

@section('content')
<div class="container text-main">
    <h1 class="text-main">Detail User</h1>

    <div class="card mt-3 border-top-main">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <img src="{{ asset('storage/foto_profil/' . $user->foto) }}" alt="Foto Profil" width="150">
                </div>

                <div class="col-md-4">
                    <div class="row mb-2">
                        <div class="col-sm-3 fw-semibold"><strong>Nama</strong></div>
                        <div class="col-sm-9">: {{ $user->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 fw-semibold"><strong>NIK</strong></div>
                        <div class="col-sm-9">: {{ $user->nik }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 fw-semibold"><strong>No Telp</strong></div>
                        <div class="col-sm-9">: {{ $user->no_telp }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 fw-semibold"><strong>Alamat</strong></div>
                        <div class="col-sm-9">: {{ $user->alamat }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 fw-semibold"><strong>Email</strong></div>
                        <div class="col-sm-9">: {{ $user->email }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection

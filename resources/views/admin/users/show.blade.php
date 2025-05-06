@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail User</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Alamat:</strong> {{ $user->alamat }}</p>
            <p><strong>Foto Profil:</strong></p>
            <img src="{{ asset($user->foto) }}" alt="Foto Profil" width="150">
        </div>
    </div>

    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection

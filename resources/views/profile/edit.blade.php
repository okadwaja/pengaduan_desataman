@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Profil Saya</h1>

    {{-- Tampilkan foto profil --}}
    <div class="mb-4">
        <img src="{{ asset('storage/foto_profil/' . $user->foto) }}" alt="Foto Profil" width="150">
    </div>

    {{-- Form update --}}
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        {{-- Upload foto baru --}}
        <div class="mb-3">
            <label for="foto" class="form-label">Upload Foto Baru</label>
            <input type="file" id="foto" name="foto" class="form-control">
        </div>
        {{-- Nama --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
        </div>

        {{-- NIK --}}
        <div class="mb-3">
            <label for="nik" class="form-label">NIK</label>
            <input type="text" id="nik" name="nik" class="form-control" value="{{ old('nik', $user->nik) }}" required>
        </div>

        {{-- No Telepon --}}
        <div class="mb-3">
            <label for="no_telp" class="form-label">No Telepon</label>
            <input type="text" id="no_telp" name="no_telp" class="form-control" value="{{ old('no_telp', $user->no_telp) }}" required>
        </div>

        {{-- Alamat --}}
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <select id="alamat" name="alamat" class="form-select">
                @foreach([
                    'Br. Batubayan', 'Br. Dlodpasar', 'Br. Gunung', 'Br. Jempeng',
                    'Br. Jempeng Kauh', 'Br. Ketogan', 'Br. Mambul', 'Br. Pegongan',
                    'Br. Raketan', 'Br. Sukajati', 'Br. Tabah', 'Br. Tebejero'
                ] as $alamat)
                    <option value="{{ $alamat }}" {{ $user->alamat == $alamat ? 'selected' : '' }}>
                        {{ $alamat }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        {{-- Tombol simpan --}}
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection

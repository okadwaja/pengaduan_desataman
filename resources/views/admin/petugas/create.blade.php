@extends('layouts.app')

@section('content')
<div class="container text-main">
    <h1 class="mb-4 text-center">Tambah Petugas</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.petugas.store') }}">
        @csrf

        <div class="form-group mb-3">
            <label for="name">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="role">Role</label>
            <select name="role" class="form-control" required onchange="toggleRoleFields(this.value)">
                <option value="">-- Pilih Role --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="kepala_desa" {{ old('role') == 'kepala_desa' ? 'selected' : '' }}>Kepala Desa</option>
            </select>
            @error('role') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="nik">NIK</label>
            <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" required>
            @error('nik') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="no_telp">No Telepon</label>
            <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp') }}" required>
            @error('no_telp') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="alamat">Alamat (Banjar)</label>
            <select name="alamat" class="form-control" required>
                <option value="">-- Pilih Banjar --</option>
                @foreach ([
                    'Br. Batubayan', 'Br. Dlodpasar', 'Br. Gunung', 'Br. Jempeng',
                    'Br. Jempeng Kauh', 'Br. Ketogan', 'Br. Mambul', 'Br. Pegongan',
                    'Br. Raketan', 'Br. Sukajati', 'Br. Tabah', 'Br. Tebejero'
                ] as $banjar)
                    <option value="{{ $banjar }}" {{ old('alamat') == $banjar ? 'selected' : '' }}>{{ $banjar }}</option>
                @endforeach
            </select>
            @error('alamat') <div class="text-danger">{{ $message }}</div> @enderror
        </div>


        <div class="form-group mb-3">
            <label for="password">Password</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="input-group-text" style="cursor: pointer;" onclick="togglePassword('password', 'togglePasswordIcon')">
                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                </span>
            </div>
            <small class="text-muted" style="margin-left: 30px">*Minimal 8 karakter</small>
            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password_confirmation">Konfirmasi Password</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                <span class="input-group-text" style="cursor: pointer;" onclick="togglePassword('password_confirmation', 'toggleConfirmPasswordIcon')">
                    <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i>
                </span>
            </div>
        </div>


        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.petugas.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        const isPassword = input.type === 'password';

        input.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    }
</script>
@endpush

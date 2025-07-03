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
            <label for="nip">NIP</label>
            <input type="text" name="nip" class="form-control" value="{{ old('nip') }}" required>
            @error('nip') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3" id="jabatan-field">
            <label for="jabatan">Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}">
        </div>

        <div class="form-group mb-3" id="masa-jabatan-field" style="display: none;">
            <label for="masa_jabatan">Masa Jabatan</label>
            <input type="text" name="masa_jabatan" class="form-control" value="{{ old('masa_jabatan') }}">
        </div>

        <div class="form-group mb-3">
            <label for="no_telp">No Telepon</label>
            <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp') }}" required>
            @error('no_telp') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Password dengan ikon toggle --}}
        <div class="form-group mb-3">
            <label for="password">Password</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="input-group-text" style="cursor: pointer;" onclick="togglePassword('password', 'togglePasswordIcon')">
                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                </span>
            </div>
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
    function toggleRoleFields(role) {
        const jabatan = document.getElementById('jabatan-field');
        const masaJabatan = document.getElementById('masa-jabatan-field');

        if (role === 'admin') {
            jabatan.style.display = 'block';
            masaJabatan.style.display = 'none';
        } else if (role === 'kepala_desa') {
            jabatan.style.display = 'none';
            masaJabatan.style.display = 'block';
        } else {
            jabatan.style.display = 'none';
            masaJabatan.style.display = 'none';
        }
    }

    // Panggil saat halaman pertama kali dimuat
    toggleRoleFields('{{ old('role') }}');

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

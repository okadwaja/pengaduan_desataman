@extends('layouts.auth-layout')

@section('form_content')
<div class="container">
    <div class="main-content row mx-auto bg-light">
        <div class="col-md-4 company__info text-center">
            <img src="{{ asset('storage/foto_profil/logo.png') }}" alt="Company Logo" class="img-fluid" style="max-height: 150px;">
        </div>

        <div class="col-md-8 login_form text-main">
            <h2 class="text-center mb-4">Register</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <input type="text" name="name" class="form__input" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                @error('name') <div class="text-danger">{{ $message }}</div> @enderror

                <input type="text" name="nik" class="form__input" placeholder="NIK" value="{{ old('nik') }}" maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                @error('nik') <div class="text-danger">{{ $message }}</div> @enderror

                <input type="text" name="no_telp" class="form__input" placeholder="No. Telepon" value="{{ old('no_telp') }}" maxlength="12" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                @error('no_telp') <div class="text-danger">{{ $message }}</div> @enderror

                <select name="alamat" class="form__input" required>
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

                <input type="email" name="email" class="form__input" placeholder="Email" value="{{ old('email') }}" required>
                @error('email') <div class="text-danger">{{ $message }}</div> @enderror

                <div class="position-relative">
                    <input type="password" name="password" id="password" class="form__input" placeholder="Password" required style="margin-bottom: 0;">
                    <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;" onclick="togglePassword('password', 'togglePasswordIcon')">
                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                    </span>
                </div>
                <small class="text-muted" style="margin-left: 30px">*Minimal 8 karakter</small>
                @error('password') <div class="text-danger">{{ $message }}</div> @enderror

                <div class="position-relative mt-2">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form__input" placeholder="Konfirmasi Password" required>
                    <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;" onclick="togglePassword('password_confirmation', 'toggleConfirmPasswordIcon')">
                        <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i>
                    </span>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-custom">Register</button>
                </div>

                <div class="text-center">
                    <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
                </div>
            </form>
        </div>
    </div>
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


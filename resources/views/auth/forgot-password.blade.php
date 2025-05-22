@extends('layouts.auth-layout')

@section('form_content')
<div class="container">
    <div class="main-content row mx-auto bg-light">
        <div class="col-md-4 company__info text-center">
            <img src="{{ asset('storage/foto_profil/logo.png') }}" alt="Company Logo" class="img-fluid" style="max-height: 150px;">
        </div>

        <div class="col-md-8 login_form text-main">
            <h2 class="text-center mb-4">Lupa Password</h2>

            <p class="mb-4 text-sm">
                Lupa kata sandi? Masukkan email Anda dan kami akan mengirimkan link untuk mengatur ulang kata sandi.
            </p>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <input type="email" name="email" class="form__input" placeholder="Email" value="{{ old('email') }}" required autofocus>
                @error('email') <div class="text-danger">{{ $message }}</div> @enderror

                <div class="text-center">
                    <button type="submit" class="btn btn-custom">Kirim Link Reset</button>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

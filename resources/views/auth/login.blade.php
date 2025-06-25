@extends('layouts.auth-layout')

@section('form_content')

<div class="container">
    <div class="main-content row mx-auto bg-light">
        <!-- Company Logo -->
        <div class="col-md-4 company__info text-center">
            <img src="{{ asset('storage/foto_profil/logo.png') }}" alt="Company Logo" class="img-fluid" style="max-height: 150px;">
        </div>

        <!-- Login Form -->
        <div class="col-md-8 login_form text-main">
            <h2 class="text-center mb-4">Log In</h2>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <input type="email" name="email" class="form__input" placeholder="Email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <!-- Password -->
                <div class="position-relative">
                    <input type="password" name="password" id="password" class="form__input form-control pe-5" placeholder="Password" required>
                    <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;" onclick="togglePassword()">
                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                    </span>
                </div>

                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <!-- Remember Me -->
                <div class="form-check mb-3 ms-2">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember_me">
                    <label class="form-check-label" for="remember_me">Remember Me</label>
                </div>

                <!-- Submit -->
                <div class="text-center">
                    <button type="submit" class="btn btn-custom">Login</button>
                </div>

                <!-- Forgot Password -->
                <div class="text-center mb-3">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot your password?</a>
                    @endif
                </div>

                <!-- Register -->
                <div class="text-center">
                    <p class="mb-0">Don't have an account? <a href="{{ route('register') }}">Register Here</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');
        const isPassword = passwordInput.type === 'password';

        passwordInput.type = isPassword ? 'text' : 'password';
        toggleIcon.classList.toggle('fa-eye');
        toggleIcon.classList.toggle('fa-eye-slash');
    }
</script>
@endpush


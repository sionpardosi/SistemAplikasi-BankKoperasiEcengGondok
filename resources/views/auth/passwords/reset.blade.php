@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0 text-center fw-bold">{{ __('Reset Password') }}</h4>
                </div>

                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-key-fill fs-1 text-primary mb-2"></i>
                        <p>Buat password baru untuk akun Anda.</p>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">{{ __('Alamat Email') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" readonly>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">{{ __('Password Baru') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-text text-muted small mt-2">Password harus terdiri dari minimal 8 karakter, mengandung huruf besar, huruf kecil, dan angka.</div>
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-bold">{{ __('Konfirmasi Password Baru') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock-fill"></i></span>
                                <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password baru">
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="password-strength mb-4">
                            <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" id="password-strength-bar" style="width: 0%"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">Kekuatan Password:</small>
                                <small id="password-strength-text">Lemah</small>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check2-circle me-2"></i>{{ __('Reset Password') }}
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-light py-3 text-center">
                    <p class="text-muted mb-0">Sudah ingat password lama? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Login Sekarang</a></p>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small">
                    <i class="bi bi-shield-check me-1"></i>
                    Pastikan password baru Anda cukup kuat dan tidak pernah digunakan di situs lain.
                </p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
    .card {
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .btn-primary {
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });

        // Toggle confirm password visibility
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPassword = document.getElementById('password-confirm');
        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });

        // Password strength meter
        const strengthBar = document.getElementById('password-strength-bar');
        const strengthText = document.getElementById('password-strength-text');

        password.addEventListener('input', function() {
            const val = password.value;
            let strength = 0;

            if (val.length >= 8) strength += 20;
            if (val.match(/[a-z]+/)) strength += 20;
            if (val.match(/[A-Z]+/)) strength += 20;
            if (val.match(/[0-9]+/)) strength += 20;
            if (val.match(/[^a-zA-Z0-9]+/)) strength += 20;

            strengthBar.style.width = strength + '%';

            if (strength < 40) {
                strengthBar.className = 'progress-bar bg-danger';
                strengthText.textContent = 'Lemah';
            } else if (strength < 80) {
                strengthBar.className = 'progress-bar bg-warning';
                strengthText.textContent = 'Sedang';
            } else {
                strengthBar.className = 'progress-bar bg-success';
                strengthText.textContent = 'Kuat';
            }
        });
    });
</script>
@endpush
@endsection

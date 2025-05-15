@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0 text-center fw-bold">{{ __('Konfirmasi Password') }}</h4>
                </div>

                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-shield-lock fs-1 text-primary mb-2"></i>
                        <p class="lead">{{ __('Masukkan password Anda untuk melanjutkan') }}</p>
                        <div class="alert alert-info d-inline-block">
                            <i class="bi bi-info-circle me-2"></i>
                            {{ __('Area ini memerlukan verifikasi keamanan tambahan') }}
                        </div>
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">{{ __('Password Anda') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan password Anda">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-unlock me-2"></i>{{ __('Konfirmasi Password') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-outline-secondary" href="{{ route('password.request') }}">
                                    <i class="bi bi-question-circle me-2"></i>{{ __('Lupa Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-light py-3 text-center">
                    <p class="text-muted mb-0">Kembali ke <a href="{{ route('home.index') }}" class="text-decoration-none fw-bold">Halaman Utama</a></p>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small">
                    <i class="bi bi-clock-history me-1"></i>
                    Konfirmasi password akan aktif selama 30 menit ke depan setelah berhasil diverifikasi.
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
    });
</script>
@endpush
@endsection

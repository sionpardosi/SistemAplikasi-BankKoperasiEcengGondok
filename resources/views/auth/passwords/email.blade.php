@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0 text-center fw-bold">{{ __('Lupa Password') }}</h4>
                </div>

                <div class="card-body p-4">
                    @if (session('status'))
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>{{ session('status') }}</div>
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <i class="bi bi-envelope-paper fs-1 text-primary mb-2"></i>
                        <p>Masukkan email Anda untuk menerima tautan reset password.</p>
                    </div>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">{{ __('Alamat Email') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nama@email.com">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-text text-muted small mt-2">Kami akan mengirimkan tautan reset password ke email yang terdaftar.</div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-send me-2"></i>{{ __('Kirim Tautan Reset Password') }}
                            </button>
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>{{ __('Kembali ke Halaman Login') }}
                            </a>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-light py-3 text-center">
                    <p class="text-muted mb-0">Sudah ingat password? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Login Sekarang</a></p>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small">
                    <i class="bi bi-shield-lock me-1"></i>
                    Keamanan akun Anda adalah prioritas kami. Pastikan untuk membuat password yang kuat.
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
@endsection

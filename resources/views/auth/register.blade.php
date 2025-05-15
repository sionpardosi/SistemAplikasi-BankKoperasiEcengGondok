@extends('layouts.app')

@section('content')
    <style>
        .text-danger {
            color: #e53935 !important;
        }
    </style>
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="login-register container">
            <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore active" id="register-tab" data-bs-toggle="tab"
                        href="#tab-item-register" role="tab" aria-controls="tab-item-register"
                        aria-selected="true">DAFTAR AKUN</a>
                </li>
            </ul>
            <div class="tab-content pt-2" id="login_register_tab_content">
                <div class="tab-pane fade show active" id="tab-item-register" role="tabpanel"
                    aria-labelledby="register-tab">
                    <div class="register-form">
                        @if (session('error'))
                            <div class="alert alert-danger mb-4">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('verification.send') }}" name="register-form"
                            class="needs-validation" novalidate>
                            @csrf
                            <div class="form-floating mb-3">
                                <input class="form-control form-control_gray @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required autocomplete="name"
                                    autofocus minlength="3" maxlength="255">
                                <label for="name">Nama Lengkap <span class="text-danger">*</span></label>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @else
                                    <div class="invalid-feedback">
                                        Nama lengkap harus diisi (minimal 3 karakter)
                                    </div>
                                @enderror
                            </div>

                            <div class="pb-3"></div>

                            <div class="form-floating mb-3">
                                <input id="email" type="email"
                                    class="form-control form-control_gray @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">
                                <label for="email">Alamat Email <span class="text-danger">*</span></label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @else
                                    <div class="invalid-feedback">
                                        Masukkan alamat email yang valid
                                    </div>
                                @enderror
                            </div>

                            <div class="pb-3"></div>

                            <div class="mb-3">
                                <div class="phone-input-group">
                                    <div class="form-floating">
                                        <div class="input-group">
                                            <span class="input-group-text">+62</span>
                                            <input id="mobile" type="tel"
                                                class="form-control form-control_gray @error('mobile') is-invalid @enderror"
                                                name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile"
                                                pattern="^8[1-9][0-9]{6,12}$" placeholder="8xxxxxxxxxx">
                                            <label for="mobile">Nomor Telepon <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                @error('mobile')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @else
                                    <small class="text-muted mt-1 d-block">Format: 8xxxxxxxxxx (tanpa awalan 0)</small>
                                    <div class="invalid-feedback">
                                        Masukkan nomor telepon yang valid (8-13 digit, dimulai dengan 8)
                                    </div>
                                @enderror
                            </div>

                            <div class="pb-3"></div>

                            <div class="form-floating mb-3 password-container">
                                <input id="password" type="password"
                                    class="form-control form-control_gray @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password" minlength="8">
                                <label for="password">Kata Sandi <span class="text-danger">*</span></label>
                                <span class="password-toggle" onclick="togglePassword('password')">
                                    <i class="fa fa-eye-slash" id="password-icon"></i>
                                </span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @else
                                    <div class="invalid-feedback">
                                        Kata sandi minimal 8 karakter
                                    </div>
                                    <div class="password-strength mt-1" id="password-strength">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar" id="password-strength-bar" role="progressbar"
                                                style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small class="text-muted" id="password-strength-text">Kekuatan kata sandi</small>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3 password-container">
                                <input id="password-confirm" type="password" class="form-control form-control_gray"
                                    name="password_confirmation" required autocomplete="new-password" minlength="8">
                                <label for="password-confirm">Konfirmasi Kata Sandi <span
                                        class="text-danger">*</span></label>
                                <span class="password-toggle" onclick="togglePassword('password-confirm')">
                                    <i class="fa fa-eye-slash" id="password-confirm-icon"></i>
                                </span>
                                <div class="invalid-feedback">
                                    Konfirmasi kata sandi harus sama dengan kata sandi
                                </div>
                            </div>

                            <div class="form-check mb-3 pb-2">
                                <input class="form-check-input @error('privacy_policy') is-invalid @enderror"
                                    type="checkbox" value="1" id="privacy-policy" name="privacy_policy" required>
                                <label class="form-check-label" for="privacy-policy">
                                    Data pribadi Anda akan digunakan untuk mendukung pengalaman Anda di
                                    seluruh situs ini, untuk mengelola akses ke akun Anda, dan untuk keperluan lain
                                    sebagaimana dijelaskan
                                    dalam <a href="{{ route('home.privacy-policy') }}" target="_blank"
                                        class="text-danger">kebijakan
                                        privasi</a> kami.
                                </label>
                                @error('privacy_policy')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @else
                                    <div class="invalid-feedback">
                                        Anda harus menyetujui kebijakan privasi kami
                                    </div>
                                @enderror
                            </div>

                            <button class="btn btn-primary btn-register w-100 text-uppercase" type="submit"
                                id="submit-button">
                                <span>Lanjutkan</span>
                                <i class="fa fa-arrow-right ms-2"></i>
                            </button>

                            <div class="customer-option mt-4 text-center">
                                <span class="text-secondary">Sudah punya akun?</span>
                                <a href="{{ route('login') }}" class="btn-text js-show-register">Masuk ke Akun Anda</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Form validation
                const form = document.querySelector('.needs-validation');
                const submitButton = document.getElementById('submit-button');

                // Password strength meter
                const passwordInput = document.getElementById('password');
                const passwordConfirm = document.getElementById('password-confirm');
                const strengthBar = document.getElementById('password-strength-bar');
                const strengthText = document.getElementById('password-strength-text');

                // Password strength calculation
                function checkPasswordStrength(password) {
                    let strength = 0;
                    if (password.length >= 8) strength += 20;
                    if (password.match(/[a-z]+/)) strength += 20;
                    if (password.match(/[A-Z]+/)) strength += 20;
                    if (password.match(/[0-9]+/)) strength += 20;
                    if (password.match(/[^a-zA-Z0-9]+/)) strength += 20;

                    return strength;
                }

                // Update strength meter
                passwordInput.addEventListener('input', function() {
                    const strength = checkPasswordStrength(this.value);
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

                // Check password match
                passwordConfirm.addEventListener('input', function() {
                    if (this.value !== passwordInput.value) {
                        this.setCustomValidity('Kata sandi tidak cocok');
                    } else {
                        this.setCustomValidity('');
                    }
                });

                // Indonesian phone number format
                const mobileInput = document.getElementById('mobile');
                mobileInput.addEventListener('input', function() {
                    // Remove non-numeric characters
                    this.value = this.value.replace(/\D/g, '');

                    // Remove leading zeros
                    if (this.value.startsWith('0')) {
                        this.value = this.value.substring(1);
                    }

                    // Validate format (must start with 8)
                    if (this.value && !this.value.startsWith('8')) {
                        this.setCustomValidity('Nomor harus dimulai dengan 8 setelah kode negara +62');
                    } else if (this.value.length < 7 || this.value.length > 13) {
                        this.setCustomValidity('Nomor telepon harus 8-13 digit');
                    } else {
                        this.setCustomValidity('');
                    }
                });

                // Form validation before submit
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                });
            });

            // Toggle password visibility
            function togglePassword(id) {
                const passwordField = document.getElementById(id);
                const icon = document.getElementById(id + '-icon');

                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    icon.className = 'fa fa-eye';
                } else {
                    passwordField.type = 'password';
                    icon.className = 'fa fa-eye-slash';
                }
            }
        </script>
    @endpush

    @push('styles')
        <style>
            .btn-text {
                color: #956a3b;
                text-decoration: none;
                font-weight: 600;
                transition: color 0.2s;
                margin-left: 0.5rem;
            }

            .btn-text:hover {
                color: #7d593a;
                text-decoration: underline;
            }

            .password-container {
                position: relative;
            }

            .password-toggle {
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                z-index: 10;
                color: #6c757d;
                padding: 8px;
                transition: color 0.2s;
            }

            .password-toggle:hover {
                color: #495057;
            }

            /* Phone input styling improvements */
            .phone-input-group .form-floating {
                position: relative;
                width: 100%;
            }

            .phone-input-group .input-group {
                display: flex;
                align-items: stretch;
            }

            .phone-input-group .input-group-text {
                background-color: #f8f9fa;
                border-color: #ced4da;
                color: #495057;
                font-weight: 500;
                width: 45px;
                justify-content: center;
                padding: 0.375rem 0.5rem;
            }

            .phone-input-group .form-control {
                height: auto;
                padding-top: 1.625rem;
                padding-bottom: 0.625rem;
            }

            .phone-input-group .form-floating>.form-control {
                padding-left: 0.75rem;
            }

            .phone-input-group .form-floating>.input-group>label {
                left: 55px;
                padding-left: 0.75rem;
                height: auto;
                transform-origin: 0 0;
                z-index: 3;
            }

            /* When input is focused or has value */
            .phone-input-group .form-floating>.input-group>.form-control:focus~label,
            .phone-input-group .form-floating>.input-group>.form-control:not(:placeholder-shown)~label {
                opacity: 0.65;
                transform: scale(0.85) translateY(-0.5rem) translateX(0);
                padding-top: 0.5rem;
            }

            /* Password strength styles */
            .password-strength {
                margin-top: 5px;
            }

            .progress {
                height: 5px;
                border-radius: 2px;
                margin-bottom: 5px;
                background-color: #e9ecef;
            }

            /* Button styling */
            .btn-primary {
                background-color: #956a3b;
                border-color: #956a3b;
                color: #ffffff;
                font-weight: 600;
                border-radius: 8px;
                padding: 0.75rem 1.5rem;
                letter-spacing: 0.5px;
                transition: all 0.3s ease;
                height: 56px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .btn-primary:hover {
                background-color: #7d593a;
                border-color: #7d593a;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(149, 106, 59, 0.3);
            }

            .btn-primary:active {
                transform: translateY(0);
                box-shadow: 0 2px 6px rgba(149, 106, 59, 0.2);
            }

            /* Focus styles for improved accessibility */
            .form-control:focus,
            .form-check-input:focus {
                border-color: #956a3b;
                box-shadow: 0 0 0 0.25rem rgba(149, 106, 59, 0.25);
            }

            .btn-register:hover {
                animation: button-pulse 1.5s infinite;
            }
        </style>
    @endpush
@endsection

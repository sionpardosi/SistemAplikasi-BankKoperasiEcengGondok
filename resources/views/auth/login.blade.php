@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="login-register container">
            <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore active" id="login-tab" data-bs-toggle="tab" href="#tab-item-login"
                        role="tab" aria-controls="tab-item-login" aria-selected="true">MASUK KE AKUN</a>
                </li>
            </ul>
            <div class="tab-content pt-2" id="login_register_tab_content">
                <div class="tab-pane fade show active" id="tab-item-login" role="tabpanel" aria-labelledby="login-tab">
                    <div class="login-form">
                        @if (session('error'))
                            <div class="alert alert-danger mb-4">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success mb-4">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" name="login-form" class="needs-validation"
                            novalidate>
                            @csrf

                            <div class="form-floating mb-4 input-group-custom">
                                <div class="form-floating mb-4 input-group-custom">
                                    <input id="email" type="email"
                                        class="form-control form-control_gray @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <label for="email">Alamat Email <span class="text-danger">*</span></label>
                                    <span class="input-icon">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @else
                                        <div class="invalid-feedback">
                                            Alamat email harus diisi
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-4 password-container">
                                    <input id="password" type="password"
                                        class="form-control form-control_gray @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="current-password">
                                    <label for="password">Kata Sandi <span class="text-danger">*</span></label>
                                    <span class="password-toggle" onclick="togglePassword('password')">
                                        <i class="fa fa-eye-slash" id="password-icon"></i>
                                    </span>
                                    <span class="input-icon">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @else
                                        <div class="invalid-feedback">
                                            Kata sandi harus diisi
                                        </div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            Ingat saya
                                        </label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="forgot-password-link">
                                            Lupa kata sandi?
                                        </a>
                                    @endif
                                </div>

                                <button class="btn btn-primary btn-login w-100 text-uppercase" type="submit">
                                    <span>Masuk Sekarang</span>
                                    <i class="fa fa-arrow-right ms-2"></i>
                                </button>

                                <div class="separator my-4">
                                    <span>atau</span>
                                </div>

                                <a href="{{ route('oauth.google') }}" class="btn btn-google w-100">
                                    <i class="fab fa-google me-2"></i>
                                    <span>Masuk dengan Google</span>
                                </a>

                                <div class="customer-option mt-4 text-center">
                                    <span class="text-secondary">Belum punya akun?</span>
                                    <a href="{{ route('register') }}" class="btn-text">Buat Akun</a>
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
                const emailInput = document.getElementById('email');
                const passwordInput = document.getElementById('password');

                // Form validation before submit
                form.addEventListener('submit', function(event) {
                    let isValid = true;

                    // Validate email
                    if (!emailInput.value.trim()) {
                        emailInput.classList.add('is-invalid');
                        emailInput.classList.remove('is-valid');
                        isValid = false;
                    } else if (!isValidEmail(emailInput.value)) {
                        emailInput.classList.add('is-invalid');
                        emailInput.classList.remove('is-valid');
                        isValid = false;
                    } else {
                        emailInput.classList.remove('is-invalid');
                        emailInput.classList.add('is-valid');
                    }

                    // Validate password
                    if (!passwordInput.value.trim()) {
                        passwordInput.classList.add('is-invalid');
                        passwordInput.classList.remove('is-valid');
                        isValid = false;
                    } else {
                        passwordInput.classList.remove('is-invalid');
                        passwordInput.classList.add('is-valid');
                    }

                    if (!isValid) {
                        event.preventDefault();
                        event.stopPropagation();
                        form.classList.add('was-validated');
                    }
                });

                // Email validation function
                function isValidEmail(email) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return emailRegex.test(email);
                }

                // Add floating label behavior
                const inputs = document.querySelectorAll('.form-control');

                inputs.forEach(input => {
                    if (input.value) {
                        input.classList.add('has-value');
                    }

                    input.addEventListener('input', function() {
                        if (this.value) {
                            this.classList.add('has-value');
                        } else {
                            this.classList.remove('has-value');
                        }

                        // Reset validation status when user starts typing
                        this.classList.remove('is-valid');
                        this.classList.remove('is-invalid');
                    });
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
            /* General styling */
            .login-register {
                max-width: 480px;
                margin: 0 auto;
            }

            /* Tabs styling */
            .nav-tabs {
                border-bottom: none;
                justify-content: center;
            }

            .nav-tabs .nav-item {
                margin-bottom: 0;
            }

            .nav-tabs .nav-link {
                font-weight: 600;
                border: none;
                color: #6c757d;
                padding: 0.75rem 1rem;
                letter-spacing: 0.5px;
                position: relative;
                transition: all 0.3s ease;
                font-size: 1rem;
            }

            .nav-tabs .nav-link.active {
                color: #956a3b;
                background: transparent;
            }

            .nav-link_underscore::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 0;
                height: 2px;
                background-color: #956a3b;
                transition: width 0.3s ease;
            }

            .nav-link_underscore.active::after {
                width: 100%;
            }

            /* Form styling */
            .form-floating {
                position: relative;
                margin-bottom: 1.5rem;
            }

            .form-control_gray {
                background-color: #f8f9fa;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                padding: 1.5rem 1rem 0.5rem 2.5rem;
                height: 60px;
                font-size: 1rem;
                transition: all 0.3s ease;
            }

            .form-control_gray:focus {
                background-color: #fff;
                border-color: #956a3b;
                box-shadow: 0 0 0 0.25rem rgba(149, 106, 59, 0.25);
            }

            .input-group-custom {
                position: relative;
            }

            .input-icon {
                position: absolute;
                left: 1rem;
                top: 50%;
                transform: translateY(-50%);
                color: #6c757d;
                z-index: 10;
            }

            .form-floating>label {
                padding-left: 2.5rem;
                color: #6c757d;
                font-weight: 400;
            }

            /* Password styling */
            .password-container {
                position: relative;
            }

            .password-toggle {
                position: absolute;
                right: 1rem;
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

            /* Google Button styling */
            .btn-google {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                padding: 0.75rem;
                border: 1px solid #dee2e6;
                color: #212529;
                text-align: center;
                font-size: 1rem;
                font-weight: 500;
                border-radius: 8px;
                background-color: #fff;
                transition: all 0.3s ease;
                height: 56px;
            }

            .btn-google:hover {
                background-color: #f8f9fa;
                border-color: #dd4b39;
                color: #dd4b39;
                text-decoration: none;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
            }

            .btn-google i {
                font-size: 1.2rem;
                color: #dd4b39;
            }

            /* Separator styling */
            .separator {
                display: flex;
                align-items: center;
                color: #6c757d;
                font-size: 0.875rem;
            }

            .separator::before,
            .separator::after {
                content: '';
                flex: 1;
                height: 1px;
                background-color: #dee2e6;
            }

            .separator span {
                padding: 0 1rem;
            }

            /* Link styling */
            .forgot-password-link {
                color: #956a3b;
                text-decoration: none;
                font-size: 0.875rem;
                font-weight: 500;
                transition: color 0.2s;
            }

            .forgot-password-link:hover {
                color: #7d593a;
                text-decoration: underline;
            }

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

            /* Form validation styling - UPDATED */
            .was-validated .form-control:invalid {
                border-color: #dc3545;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right calc(0.375em + 0.1875rem) center;
                background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
            }

            .was-validated .form-control:valid {
                border-color: #198754;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right calc(0.375em + 0.1875rem) center;
                background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
            }

            /* Prevent validation styling on load */
            .form-control.is-invalid {
                border-color: #dc3545;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right calc(0.375em + 0.1875rem) center;
                background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
            }

            .form-control.is-valid {
                border-color: #198754;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right calc(0.375em + 0.1875rem) center;
                background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
            }

            .invalid-feedback {
                display: none;
                width: 100%;
                margin-top: 0.25rem;
                font-size: 80%;
                color: #dc3545;
            }

            .is-invalid~.invalid-feedback {
                display: block;
            }

            /* Custom checkbox styling */
            .form-check-input {
                width: 1.2em;
                height: 1.2em;
                margin-top: 0.15em;
                vertical-align: top;
                background-color: #fff;
                background-repeat: no-repeat;
                background-position: center;
                background-size: contain;
                border: 1px solid #adb5bd;
                appearance: none;
                color-adjust: exact;
                transition: background-color 0.15s ease-in-out, background-position 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                border-radius: 0.25em;
            }

            .form-check-input:checked {
                background-color: #956a3b;
                border-color: #956a3b;
            }

            .form-check-input:focus {
                border-color: #956a3b;
                outline: 0;
                box-shadow: 0 0 0 0.25rem rgba(149, 106, 59, 0.25);
            }

            .form-check-label {
                color: #6c757d;
            }

            /* Responsive fixes */
            @media (max-width: 576px) {
                .login-register {
                    padding: 0 1rem;
                }

                .form-control_gray {
                    height: 56px;
                }
            }

            /* Animation for focus */
            @keyframes input-focus {
                0% {
                    box-shadow: 0 0 0 0 rgba(149, 106, 59, 0.4);
                }

                70% {
                    box-shadow: 0 0 0 10px rgba(149, 106, 59, 0);
                }

                100% {
                    box-shadow: 0 0 0 0 rgba(149, 106, 59, 0);
                }
            }

            .form-control:focus {
                animation: input-focus 1s;
            }

            /* Button animation */
            @keyframes button-pulse {
                0% {
                    box-shadow: 0 0 0 0 rgba(149, 106, 59, 0.4);
                }

                70% {
                    box-shadow: 0 0 0 10px rgba(149, 106, 59, 0);
                }

                100% {
                    box-shadow: 0 0 0 0 rgba(149, 106, 59, 0);
                }
            }

            .btn-login:hover {
                animation: button-pulse 1.5s infinite;
            }

            /* Alert styling enhancement */
            .alert {
                border-radius: 8px;
                padding: 1rem;
                margin-bottom: 1.5rem;
                border: 1px solid transparent;
            }

            .alert-danger {
                color: #842029;
                background-color: #f8d7da;
                border-color: #f5c2c7;
            }

            .alert-success {
                color: #0f5132;
                background-color: #d1e7dd;
                border-color: #badbcc;
            }

            /* Shake animation for invalid inputs */
            @keyframes shake {

                0%,
                100% {
                    transform: translateX(0);
                }

                10%,
                30%,
                50%,
                70%,
                90% {
                    transform: translateX(-5px);
                }

                20%,
                40%,
                60%,
                80% {
                    transform: translateX(5px);
                }
            }

            .is-invalid {
                animation: shake 0.5s;
            }
        </style>
    @endpush
@endsection

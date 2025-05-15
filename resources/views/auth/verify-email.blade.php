@extends('layouts.app')

@section('content')
    <main>
        <section class="verification-section">
            <div class="container py-4">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-5">
                        <div class="card verification-card shadow-sm border-0">
                            <div class="card-body p-4">
                                <!-- Alert Messages -->
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                <div class="text-center mb-4">
                                    <div class="verification-icon mb-3">
                                        <i class="fas fa-envelope-open-text"></i>
                                    </div>
                                    <h4 class="fw-bold text-primary mb-2">Verifikasi Email</h4>
                                    <p class="mb-0 text-secondary">Masukkan kode 6 digit yang dikirim ke</p>
                                    <p class="fw-bold text-primary">{{ $email }}</p>
                                </div>

                                <form method="POST" action="{{ route('verification.verify-code') }}"
                                    class="needs-validation" novalidate>
                                    @csrf
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <input type="hidden" id="verification_timestamp" name="verification_timestamp"
                                        value="{{ session('verification_timestamp', time()) }}">

                                    <!-- Verification Code Input -->
                                    <div class="verification-code-container mb-4">
                                        <div class="d-flex justify-content-center gap-3">
                                            @for ($i = 1; $i <= 6; $i++)
                                                <input type="text"
                                                    class="form-control verification-digit text-center fw-bold"
                                                    maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off"
                                                    data-index="{{ $i }}" required>
                                            @endfor
                                        </div>
                                        <input type="hidden" id="verification_code" name="verification_code" required>
                                        @error('verification_code')
                                            <div class="text-danger text-center mt-2">
                                                <small>{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Timer and Resend Button -->
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="verification-timer">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-clock me-2 text-primary"></i>
                                                <div id="timer-container">
                                                    <span id="countdown-label">Kode berlaku: </span>
                                                    <span id="countdown" class="fw-bold"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('verification.resend', ['email' => $email]) }}"
                                            class="btn btn-light btn-sm resend-link disabled" id="resendLink">
                                            <i class="fas fa-rotate me-1"></i>Kirim Ulang
                                        </a>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary text-uppercase py-3 fw-bold" type="submit"
                                            id="verifyButton" style="background-color: #956a3b; border-color: #956a3b; color: #ffffff;">
                                            <i class="fas fa-check-circle me-1"></i>Verifikasi
                                        </button>
                                        <a href="{{ route('register') }}" class="btn btn-outline-secondary py-2"
                                            type="button">
                                            <i class="fas fa-arrow-left me-1"></i>Kembali
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Enhanced Styling for ver Section -->
    <style>
        .verification-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 40px 0;
            background-color: #f8f9fa;
            position: relative;
        }

        .verification-card {
            border-radius: 18px;
            overflow: hidden;
            transition: all 0.3s ease;
            background-color: #ffffff;
        }

        .verification-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08) !important;
        }

        .verification-icon {
            height: 80px;
            width: 80px;
            line-height: 80px;
            border-radius: 50%;
            background-color: rgba(13, 110, 253, 0.1);
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            color: #0d6efd;
            transition: all 0.3s ease;
        }

        .verification-icon:hover {
            transform: scale(1.05);
            background-color: rgba(13, 110, 253, 0.15);
        }

        .verification-digit {
            width: 52px;
            height: 62px;
            font-size: 1.6rem;
            border-radius: 14px;
            background-color: #f8f9fa;
            border: 2px solid #ced4da;
            transition: all 0.3s ease;
            padding: 0.5rem 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        .verification-digit:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            background-color: #fff;
            transform: translateY(-3px);
        }

        .verification-digit.filled {
            background-color: #e8f0fe;
            border-color: #0d6efd;
            transform: translateY(-2px);
        }

        .verification-timer {
            font-size: 0.95rem;
            color: #6c757d;
        }

        #countdown {
            color: #0d6efd;
            transition: color 0.3s ease;
        }

        #countdown.warning {
            color: #fd7e14;
        }

        #countdown.danger {
            color: #dc3545;
        }

        .resend-link {
            transition: all 0.3s ease;
            border-radius: 20px;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        .resend-link:not(.disabled):hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.08);
        }

        .resend-link.disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }

        #verifyButton {
            border-radius: 12px;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            font-size: 1rem;
        }

        #verifyButton:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.25);
        }

        /* Animation for verification success */
        @keyframes successPulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .verification-success {
            animation: successPulse 0.5s ease;
        }

        /* Add a subtle background pattern */
        .verification-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: radial-gradient(#e9ecef 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.4;
            z-index: -1;
        }

        /* Make alerts more modern */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
        }

        .alert-success {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        /* Add focus effect for a better UX */
        .btn:focus,
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .verification-digit {
                width: 46px;
                height: 58px;
                font-size: 1.4rem;
            }

            .verification-icon {
                height: 70px;
                width: 70px;
                font-size: 2rem;
            }

            .verification-code-container .d-flex {
                gap: 10px !important;
            }
        }
    </style>

    <!-- script for handling the verification code input -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Store initial timestamp in session
            const initialTimestamp = "{{ session('verification_timestamp') }}";

            // If no timestamp in session yet, set it now
            if (!initialTimestamp) {
                document.getElementById('verification_timestamp').value = Math.floor(Date.now() / 10);
            }

            // Set up verification code input fields
            const digitInputs = document.querySelectorAll('.verification-digit');
            const verificationCodeInput = document.getElementById('verification_code');

            // Focus on first input
            digitInputs[0].focus();

            // Handle input for verification code fields
            digitInputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    const value = e.target.value;

                    // Only allow numbers
                    if (!/^\d*$/.test(value)) {
                        e.target.value = '';
                        return;
                    }

                    // Add filled class
                    if (value) {
                        input.classList.add('filled');
                    } else {
                        input.classList.remove('filled');
                    }

                    // Auto focus next input
                    if (value && index < digitInputs.length - 1) {
                        digitInputs[index + 1].focus();
                    }

                    // Auto submit when all fields are filled
                    if (value && index === digitInputs.length - 1) {
                        // Wait a brief moment before checking if all fields have values
                        setTimeout(() => {
                            const allFilled = Array.from(digitInputs).every(input => input
                                .value.length > 0);
                            if (allFilled) {
                                updateVerificationCode();
                                // Add subtle animation to verify button
                                document.getElementById('verifyButton').classList.add(
                                    'verification-success');
                                setTimeout(() => {
                                    document.getElementById('verifyButton')
                                        .classList.remove('verification-success');
                                }, 500);
                            }
                        }, 300);
                    }

                    // Update hidden verification code input
                    updateVerificationCode();
                });

                // Handle backspace
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        digitInputs[index - 1].focus();
                        digitInputs[index - 1].value = '';
                        digitInputs[index - 1].classList.remove('filled');
                        updateVerificationCode();
                    }

                    // Allow arrow navigation
                    if (e.key === 'ArrowLeft' && index > 0) {
                        digitInputs[index - 1].focus();
                    }
                    if (e.key === 'ArrowRight' && index < digitInputs.length - 1) {
                        digitInputs[index + 1].focus();
                    }
                });

                // Handle paste event
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pasteData = (e.clipboardData || window.clipboardData).getData('text');
                    const digits = pasteData.replace(/\D/g, '').substring(0, 6).split('');

                    digitInputs.forEach((input, i) => {
                        if (digits[i]) {
                            input.value = digits[i];
                            input.classList.add('filled');
                        } else {
                            input.value = '';
                            input.classList.remove('filled');
                        }
                    });

                    updateVerificationCode();

                    // Focus on appropriate field
                    if (digits.length < 6) {
                        digitInputs[Math.min(digits.length, 5)].focus();
                    } else {
                        digitInputs[5].focus();
                        // Add subtle animation to verify button when all fields are filled via paste
                        document.getElementById('verifyButton').classList.add(
                            'verification-success');
                        setTimeout(() => {
                            document.getElementById('verifyButton').classList.remove(
                                'verification-success');
                        }, 500);
                    }
                });
            });

            // Combine all inputs to create the verification code
            function updateVerificationCode() {
                let code = '';
                digitInputs.forEach(input => {
                    code += input.value;
                });
                verificationCodeInput.value = code;
            }

            // Initialize from URL parameter if present
            const urlParams = new URLSearchParams(window.location.search);
            const codeFromURL = urlParams.get('code');
            if (codeFromURL && codeFromURL.length === 6 && /^\d+$/.test(codeFromURL)) {
                const digits = codeFromURL.split('');
                digitInputs.forEach((input, i) => {
                    input.value = digits[i];
                    if (digits[i]) {
                        input.classList.add('filled');
                    }
                });
                updateVerificationCode();
            }

            // Countdown timer - using server verification timestamp
            const countdownElement = document.getElementById('countdown');
            const resendLink = document.getElementById('resendLink');

            // Get verification timestamp from PHP session or hidden field
            let verificationTimestamp;

            if ("{{ session('verification_timestamp') }}") {
                verificationTimestamp = parseInt("{{ session('verification_timestamp') }}");
            } else {
                // Fallback to current time if no timestamp found
                verificationTimestamp = Math.floor(Date.now() / 1000);
            }

            // Calculate time left based on expiration (10 minutes from verification timestamp)
            const expirationTime = verificationTimestamp + (2 * 60); // 10 minutes in seconds
            let timeLeft = expirationTime - Math.floor(Date.now() / 1000);

            // Ensure timeLeft is not negative
            timeLeft = Math.max(0, timeLeft);

            function updateCountdown() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;

                countdownElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

                // Update countdown color based on time remaining
                if (timeLeft <= 30) {
                    countdownElement.classList.remove('warning');
                    countdownElement.classList.add('danger');
                } else if (timeLeft <= 60) {
                    countdownElement.classList.remove('danger');
                    countdownElement.classList.add('warning');
                } else {
                    countdownElement.classList.remove('warning', 'danger');
                }

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    countdownElement.textContent = '0:00';
                    document.getElementById('countdown-label').innerHTML =
                        '<span class="text-danger">Kode kedaluwarsa</span>';
                    resendLink.classList.remove('disabled');
                    resendLink.setAttribute('href', "{{ route('verification.resend', ['email' => $email]) }}");
                    // Add subtle pulse animation to resend button
                    resendLink.classList.add('verification-success');
                    setTimeout(() => {
                        resendLink.classList.remove('verification-success');
                    }, 500);
                } else {
                    timeLeft--;
                }
            }

            // Disable resend link during countdown
            if (timeLeft > 0) {
                resendLink.classList.add('disabled');
                resendLink.removeAttribute('href');
            } else {
                resendLink.classList.remove('disabled');
                resendLink.setAttribute('href', "{{ route('verification.resend', ['email' => $email]) }}");
            }

            // Update countdown immediately and then every second
            updateCountdown();
            const timer = setInterval(updateCountdown, 1000);

            // Add Bootstrap Icons if not already included
            if (!document.querySelector('link[href*="bootstrap-icons"]')) {
                const iconLink = document.createElement('link');
                iconLink.rel = 'stylesheet';
                iconLink.href = 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css';
                document.head.appendChild(iconLink);
            }

            // Add event listener to resend link
            resendLink.addEventListener('click', function(e) {
                // Only if the link is not disabled
                if (!this.classList.contains('disabled')) {
                    // Show loading state
                    this.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim...';
                    this.classList.add('disabled');
                }
            });
        });
    </script>
@endsection

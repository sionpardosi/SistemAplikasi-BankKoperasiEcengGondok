@extends('layouts.app')

@section('content')
    <style>
        /* Perbesar judul dan turunkan sedikit */
        .contact-us-title {
            font-size: 2.5rem;
            margin-top: 4.5rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .mb-5 {
            margin-top: 4rem !important;
        }

        .contact-us-subtitle {
            font-size: 1rem;
            color: #6c757d;
        }

        /* Icon di label (floating & textarea) jadi coklat */
        .form-floating label i,
        .form-label i {
            margin-right: 0.5rem;
            color: #b9a16b !important;
        }

        /* Asterisk tetap merah */
        .text-danger {
            color: red !important;
        }

        .divider-text {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 2rem 0;
            font-size: 1.0rem;
            margin-bottom: 5rem;
        }

        .divider-text::before,
        .divider-text::after {
            content: "";
            flex: 1;
            border-bottom: 2px solid #b9a16b;
        }

        .divider-text span {
            padding: 0 1rem;
            color: black;
            font-weight: 500;
        }
    </style>

    <main class="pt-90">
        <section class="contact-us container">
            <div class="text-center">
                <h2 class="contact-us-title text-primary">
                    <i class="fas fa-headset"></i> Hubungi Layanan Kami
                </h2>
            </div>
        </section>

        <div class="divider-text">
            <span>
                Kami siap membantu Anda! Isi formulir di bawah ini, dan tim Bank Eceng Gondok akan segera menghubungi
                melalui WhatsApp atau telepon.
            </span>
        </div>

        <section class="contact-us container">
            <div class="mw-930">
                <div class="contact-us__form">

                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    <form id="contact-form" name="contact-us-form" class="needs-validation" {{-- novalidate --}}
                        action="{{ route('home.contact.store') }}" method="POST">
                        @csrf
                        {{-- Nama Lengkap --}}
                        <div class="form-floating my-4">
                            <input type="text"
                                class="form-control form-control-lg rounded-pill @error('name') is-invalid @enderror"
                                id="name" name="name" placeholder="Masukkan Nama Lengkap Anda *"
                                value="{{ session('success') ? '' : old('name', auth()->user()->name ?? '') }}" required>
                            <label for="name">
                                <i class="fas fa-user"></i> Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message ?: 'Nama lengkap wajib diisi.' }}
                                </div>
                            @enderror
                        </div>

                        {{-- Nomor HP / WhatsApp --}}
                        <div class="form-floating my-4">
                            <input type="tel"
                                class="form-control form-control-lg rounded-pill @error('phone') is-invalid @enderror"
                                id="phone" name="phone" placeholder="Contoh: 081234567890 *"
                                value="{{ session('success') ? '' : old('phone', auth()->user()->phone ?? '') }}" required
                                maxlength="15" pattern="^(?:\+62|62|0)[2-9]{1}[0-9]{7,11}$"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            <label for="phone">
                                <i class="fas fa-phone"></i> Nomor HP / WhatsApp yang Dapat Dihubungi<span
                                    class="text-danger">*</span>
                            </label>
                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message ?: 'Nomor HP/WhatsApp wajib diisi.' }}
                                </div>
                            @enderror
                        </div>

                        {{-- Alamat Email --}}
                        <div class="form-floating my-4">
                            <input type="email"
                                class="form-control form-control-lg rounded-pill @error('email') is-invalid @enderror"
                                id="email" name="email" placeholder="contoh@domain.com *"
                                value="{{ session('success') ? '' : old('email', auth()->user()->email ?? '') }}" required>
                            <label for="email">
                                <i class="fas fa-envelope"></i> Alamat Email <span class="text-danger">*</span>
                            </label>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message ?: 'Alamat email wajib diisi.' }}
                                </div>
                            @enderror
                        </div>

                        {{-- Pesan / Keluhan --}}
                        <div class="mb-4">
                            <label for="comment" class="form-label">
                                <i class="fas fa-comment-dots"></i> Pesan atau Keluhan Anda <span
                                    class="text-danger">*</span>
                            </label>
                            <textarea id="comment" name="comment" rows="5"
                                class="form-control form-control-lg rounded @error('comment') is-invalid @enderror"
                                placeholder="Jelaskan pertanyaan atau keluhan Anda secara singkat di sini" required>{{ session('success') ? '' : old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">
                                    {{ $message ?: 'Harap jelaskan pesan atau keluhan Anda.' }}
                                </div>
                            @enderror
                        </div>

                        {{-- Tombol Kirim --}}
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5"
                                style="background-color: #956a3b; border-color: #956a3b; color: #ffffff;">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contact-form');

            // Trigger validasi bootstrap saat submit
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi Pengiriman',
                        text: 'Dengan mengirim keluhan, pihak Bank Eceng Gondok akan menghubungi Anda melalui WhatsApp atau telepon secepatnya.',
                        icon: 'info',
                        iconColor: '#b9a16b',
                        showCancelButton: true,
                        reverseButtons: true,
                        focusCancel: true,
                        cancelButtonText: 'Batal',
                        cancelButtonColor: '#e3342f',
                        confirmButtonText: 'Kirim',
                        confirmButtonColor: '#28a745'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
                form.classList.add('was-validated');
            });

            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Pesan Anda telah terkirim! Terima kasih telah menghubungi Bank Eceng Gondok. Tim kami akan memproses permintaan Anda dan segera menghubungi Anda melalui WhatsApp atau telepon.',
                    icon: 'success',
                    iconColor: '#28a745',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#28a745'
                });
            @endif
        });
    </script>
@endsection

@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Detail Akun Anda</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('layouts.account-nav')
                </div>
                <div class="col-lg-9">
                    <div class="page-content my-account__edit">
                        <div class="my-account__edit-form">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Tabs untuk memisahkan halaman -->
                            <ul class="nav nav-tabs mb-4" id="accountTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#profile-tab-pane" type="button" role="tab"
                                        aria-controls="profile-tab-pane" aria-selected="true">Profil</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="password-tab" data-bs-toggle="tab"
                                        data-bs-target="#password-tab-pane" type="button" role="tab"
                                        aria-controls="password-tab-pane" aria-selected="false">Ubah Kata Sandi</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="accountTabsContent">
                                <!-- Tab Profil -->
                                <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel"
                                    aria-labelledby="profile-tab" tabindex="0">
                                    <form name="account_edit_form" action="{{ route('user.accountdetails.update') }}"
                                        method="POST" class="needs-validation" novalidate="">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating my-3">
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        placeholder="Full Name" name="name" id="name"
                                                        value="{{ old('name', $user->name) }}" required>
                                                    <label for="name">Nama</label>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating my-3">
                                                    <input type="text"
                                                        class="form-control @error('mobile') is-invalid @enderror"
                                                        placeholder="Mobile Number" name="mobile" id="mobile"
                                                        value="{{ old('mobile', $user->mobile) }}" required>
                                                    <label for="mobile">Nomor Hp/ WhatsApp</label>
                                                    @error('mobile')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-floating my-3">
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        placeholder="Email Address" name="email" id="email"
                                                        value="{{ old('email', $user->email) }}" required>
                                                    <label for="email">Alamat Email</label>
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="my-3">
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Tab Kata Sandi -->
                                <div class="tab-pane fade" id="password-tab-pane" role="tabpanel"
                                    aria-labelledby="password-tab" tabindex="0">
                                    <form name="password_edit_form" action="{{ route('user.accountdetails.update') }}"
                                        method="POST" class="needs-validation" novalidate="">
                                        @csrf
                                        <!-- Data profile yang tersembunyi untuk dikirim juga -->
                                        <input type="hidden" name="name" value="{{ $user->name }}">
                                        <input type="hidden" name="email" value="{{ $user->email }}">
                                        <input type="hidden" name="mobile" value="{{ $user->mobile }}">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-floating my-3">
                                                    <input type="password"
                                                        class="form-control @error('old_password') is-invalid @enderror"
                                                        id="old_password" name="old_password" placeholder="Old password"
                                                        required>
                                                    <label for="old_password">Kata Sandi lama</label>
                                                    @error('old_password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-floating my-3">
                                                    <input type="password"
                                                        class="form-control @error('new_password') is-invalid @enderror"
                                                        id="new_password" name="new_password" placeholder="New password"
                                                        required>
                                                    <label for="new_password">Kata Sandi Baru</label>
                                                    @error('new_password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-floating my-3">
                                                    <input type="password"
                                                        class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                                        data-cf-pwd="#new_password" id="new_password_confirmation"
                                                        name="new_password_confirmation"
                                                        placeholder="Confirm new password" required>
                                                    <label for="new_password_confirmation">Konfirmasi Kata Sandi
                                                        Baru</label>
                                                    @error('new_password_confirmation')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <div class="invalid-feedback password-match-error">Kata sandi tidak
                                                        cocok!</div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="my-3">
                                                    <button type="submit" class="btn btn-primary">Ubah Kata
                                                        Sandi</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        /* Gaya Dasar dan Variabel */
        :root {
            --primary-color: #6a6e51;
            --accent-color: #b9a16b;
            --success-color: #40c710;
            --danger-color: #f44032;
            --warning-color: #f5d700;
            --text-dark: #333333;
            --text-muted: #6c757d;
            --border-light: #e1e1e1;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 8px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 8px 16px rgba(0, 0, 0, 0.15);
            --border-radius: 8px;
            --transition-normal: all 0.3s ease;
        }

        /* Header dan Judul */
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-top: 60px !important;
            position: relative;
            display: inline-block;
            padding-bottom: 12px;
            letter-spacing: 1px;
            margin-bottom: 1.5rem !important;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--accent-color);
        }

        .btn-primary {
            background-color: #956a3b;
            border-color: #956a3b;
        }

        .btn-primary:hover {
            background-color: #7d592f;
            border-color: #7d592f;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-outline-primary {
            color: #956a3b;
            border-color: #956a3b;
        }

        .btn-outline-primary:hover {
            background-color: #956a3b;
            color: white;
        }

        /* Alert styling */
        .alert {
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: none;
        }

        .alert-success {
            background-color: rgba(64, 199, 16, 0.1);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }

        .alert-danger {
            background-color: rgba(244, 64, 50, 0.1);
            color: var(--danger-color);
            border-left: 4px solid var(--danger-color);
        }

        /* Form styling improvements */
        .form-floating {
            position: relative;
        }

        .form-control {
            border-radius: var(--border-radius);
            border: 1px solid var(--border-light);
            padding: 0.75rem 1rem;
            transition: var(--transition-normal);
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(185, 161, 107, 0.25);
        }

        .form-control.is-invalid {
            border-color: var(--danger-color);
            background-image: none;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 0.2rem rgba(244, 64, 50, 0.25);
        }

        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Section styling */
        .my-account__edit {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--shadow-sm);
        }

        /* Tab styling */
        .nav-tabs {
            border-bottom: 1px solid var(--border-light);
        }

        .nav-tabs .nav-link {
            margin-bottom: -1px;
            border: 1px solid transparent;
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
            color: var(--text-muted);
            padding: 0.75rem 1.25rem;
            font-weight: 500;
            transition: var(--transition-normal);
        }

        .nav-tabs .nav-link:hover {
            border-color: #e9ecef #e9ecef var(--border-light);
            color: var(--accent-color);
        }

        .nav-tabs .nav-link.active {
            color: var(--accent-color);
            background-color: #fff;
            border-color: var(--border-light) var(--border-light) #fff;
            font-weight: 600;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .col-lg-2 {
                margin-bottom: 1.5rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua form
            const profileForm = document.querySelector('form[name="account_edit_form"]');
            const passwordForm = document.querySelector('form[name="password_edit_form"]');

            // Ambil elemen password dan konfirmasi password
            const oldPassword = document.getElementById('old_password');
            const newPassword = document.getElementById('new_password');
            const confirmPassword = document.getElementById('new_password_confirmation');
            const passwordError = document.querySelector('.password-match-error');

            // Fungsi untuk memeriksa kecocokan kata sandi
            function checkPasswordMatch() {
                if (newPassword.value && confirmPassword.value) {
                    if (newPassword.value !== confirmPassword.value) {
                        confirmPassword.classList.add('is-invalid');
                        passwordError.style.display = 'block';
                        return false;
                    } else {
                        confirmPassword.classList.remove('is-invalid');
                        passwordError.style.display = 'none';
                        return true;
                    }
                }
                return true;
            }

            // Tambahkan event listener untuk input password
            if (newPassword && confirmPassword) {
                newPassword.addEventListener('input', checkPasswordMatch);
                confirmPassword.addEventListener('input', checkPasswordMatch);
            }

            // Validasi form password sebelum submit
            if (passwordForm) {
                passwordForm.addEventListener('submit', function(event) {
                    // Periksa kecocokan password
                    if (!checkPasswordMatch()) {
                        event.preventDefault();
                        return false;
                    }

                    // Cek jika semua field password terisi
                    if (!oldPassword.value || !newPassword.value || !confirmPassword.value) {
                        event.preventDefault();
                        alert('Semua field kata sandi harus diisi');
                        return false;
                    }
                });
            }

            // Bootstrap form validation
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            });

            // Jika ada hash URL, aktifkan tab yang sesuai
            const hash = window.location.hash;
            if (hash) {
                const tabId = hash.replace('#', '');
                const tab = document.querySelector(`#accountTabs button[data-bs-target="#${tabId}"]`);
                if (tab) {
                    const bsTab = new bootstrap.Tab(tab);
                    bsTab.show();
                }
            }

            // Update URL saat tab berubah
            const tabs = document.querySelectorAll('#accountTabs button');
            tabs.forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(event) {
                    const targetId = event.target.getAttribute('data-bs-target').replace('#', '');
                    window.history.replaceState(null, null, `#${targetId}`);
                });
            });
        });
    </script>
@endsection

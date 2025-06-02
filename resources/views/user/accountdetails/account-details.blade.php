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
                                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('warning'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <strong>Terjadi kesalahan:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Tabs untuk memisahkan halaman -->
                            <ul class="nav nav-tabs mb-4" id="accountTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#profile-tab-pane" type="button" role="tab"
                                        aria-controls="profile-tab-pane" aria-selected="true">
                                        <i class="fas fa-user me-2"></i>Profil Saya
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="security-tab" data-bs-toggle="tab"
                                        data-bs-target="#security-tab-pane" type="button" role="tab"
                                        aria-controls="security-tab-pane" aria-selected="false">
                                        <i class="fas fa-shield-alt me-2"></i>Keamanan
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="accountTabsContent">
                                <!-- Tab Profil -->
                                <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel"
                                    aria-labelledby="profile-tab" tabindex="0">

                                    <!-- Section Foto Profil -->
                                    <div class="profile-picture-section mb-4">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <h5 class="card-title mb-3">
                                                    <i class="fas fa-camera me-2 text-primary"></i>Foto Profil
                                                </h5>
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="profile-picture-container">
                                                            <img src="{{ $user->profile_picture ? asset($user->profile_picture) : 'https://via.placeholder.com/100x100/cccccc/666666?text=User' }}"
                                                                 alt="Profile Picture"
                                                                 class="profile-picture"
                                                                 id="profilePicturePreview">
                                                            <div class="profile-picture-overlay">
                                                                <i class="fas fa-camera"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <p class="text-muted mb-2">Ukuran gambar: maksimal 2MB</p>
                                                        <p class="text-muted mb-3">Format yang didukung: JPG, PNG, GIF</p>
                                                        <div class="btn-group" role="group">
                                                            <input type="file" id="profilePictureInput" accept="image/*" style="display: none;">
                                                            <button type="button" class="btn btn-primary btn-sm" id="uploadProfilePicture">
                                                                <i class="fas fa-upload me-1"></i>Ubah Foto
                                                            </button>
                                                            @if($user->profile_picture)
                                                                <button type="button" class="btn btn-outline-danger btn-sm" id="deleteProfilePicture">
                                                                    <i class="fas fa-trash me-1"></i>Hapus
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Profil -->
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">
                                                <i class="fas fa-edit me-2 text-primary"></i>Informasi Pribadi
                                            </h5>
                                            <form name="account_edit_form" action="{{ route('user.accountdetails.update') }}"
                                                method="POST" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="profile_picture_action" id="profilePictureAction">
                                                <input type="file" name="profile_picture" id="profilePictureFile" style="display: none;">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-floating my-3">
                                                            <input type="text"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                placeholder="Full Name" name="name" id="name"
                                                                value="{{ old('name', $user->name) }}" required>
                                                            <label for="name">
                                                                <i class="fas fa-user me-2"></i>Nama Lengkap
                                                            </label>
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
                                                                value="{{ old('mobile', $user->mobile) }}" required
                                                                pattern="^(08|628)[0-9]{8,12}$">
                                                            <label for="mobile">
                                                                <i class="fas fa-phone me-2"></i>Nomor HP/WhatsApp
                                                            </label>
                                                            <div class="form-text">Format: 08xxxxxxxxxx atau 628xxxxxxxxxx</div>
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
                                                            <label for="email">
                                                                <i class="fas fa-envelope me-2"></i>Alamat Email
                                                            </label>
                                                            @if(!$user->email_verified_at)
                                                                <div class="form-text text-warning">
                                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                                    Email belum diverifikasi
                                                                </div>
                                                            @else
                                                                <div class="form-text text-success">
                                                                    <i class="fas fa-check-circle me-1"></i>
                                                                    Email sudah diverifikasi
                                                                </div>
                                                            @endif
                                                            @error('email')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-12">
                                                        <div class="form-floating my-3">
                                                            <textarea class="form-control" placeholder="Bio" name="bio"
                                                                id="bio" style="height: 100px">{{ old('bio', $user->bio) }}</textarea>
                                                            <label for="bio">
                                                                <i class="fas fa-quote-left me-2"></i>Bio (Opsional)
                                                            </label>
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-md-12">
                                                        <div class="my-3">
                                                            <button type="submit" class="btn btn-primary btn-lg">
                                                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                                                            </button>
                                                            <button type="reset" class="btn btn-outline-secondary btn-lg ms-2">
                                                                <i class="fas fa-undo me-2"></i>Reset
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Keamanan -->
                                <div class="tab-pane fade" id="security-tab-pane" role="tabpanel"
                                    aria-labelledby="security-tab" tabindex="0">

                                    <!-- Password Security Section -->
                                    <div class="card border-0 shadow-sm mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">
                                                <i class="fas fa-key me-2 text-primary"></i>Ubah Kata Sandi
                                            </h5>
                                            <div class="alert alert-info mb-3">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <strong>Tips Keamanan:</strong> Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol untuk kata sandi yang kuat.
                                            </div>

                                            <form name="password_edit_form" action="{{ route('user.accountdetails.update') }}"
                                                method="POST" class="needs-validation" novalidate="">
                                                @csrf
                                                <!-- Data profile yang tersembunyi -->
                                                <input type="hidden" name="name" value="{{ $user->name }}">
                                                <input type="hidden" name="email" value="{{ $user->email }}">
                                                <input type="hidden" name="mobile" value="{{ $user->mobile }}">
                                                <input type="hidden" name="bio" value="{{ $user->bio }}">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-floating my-3">
                                                            <input type="password"
                                                                class="form-control @error('old_password') is-invalid @enderror"
                                                                id="old_password" name="old_password" placeholder="Old password"
                                                                required>
                                                            <label for="old_password">
                                                                <i class="fas fa-lock me-2"></i>Kata Sandi Lama
                                                            </label>
                                                            <button type="button" class="password-toggle" data-target="old_password">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            @error('old_password')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating my-3">
                                                            <input type="password"
                                                                class="form-control @error('new_password') is-invalid @enderror"
                                                                id="new_password" name="new_password" placeholder="New password"
                                                                required>
                                                            <label for="new_password">
                                                                <i class="fas fa-key me-2"></i>Kata Sandi Baru
                                                            </label>
                                                            <button type="button" class="password-toggle" data-target="new_password">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            @error('new_password')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <!-- Password Strength Indicator -->
                                                        <div class="password-strength mb-3">
                                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                                <small class="text-muted">Kekuatan Kata Sandi:</small>
                                                                <small id="password-strength-text" class="fw-bold">-</small>
                                                            </div>
                                                            <div class="progress" style="height: 4px;">
                                                                <div class="progress-bar" role="progressbar"
                                                                     id="password-strength-bar" style="width: 0%"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating my-3">
                                                            <input type="password"
                                                                class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                                                data-cf-pwd="#new_password" id="new_password_confirmation"
                                                                name="new_password_confirmation"
                                                                placeholder="Confirm new password" required>
                                                            <label for="new_password_confirmation">
                                                                <i class="fas fa-check-double me-2"></i>Konfirmasi Kata Sandi Baru
                                                            </label>
                                                            <button type="button" class="password-toggle" data-target="new_password_confirmation">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            @error('new_password_confirmation')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            <div class="invalid-feedback password-match-error">Kata sandi tidak cocok!</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="my-3">
                                                            <button type="submit" class="btn btn-warning btn-lg">
                                                                <i class="fas fa-shield-alt me-2"></i>Ubah Kata Sandi
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Account Security Info -->
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">
                                                <i class="fas fa-shield-check me-2 text-success"></i>Informasi Keamanan
                                            </h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="security-item">
                                                        <div class="d-flex align-items-center">
                                                            <div class="security-icon me-3">
                                                                <i class="fas fa-envelope {{ $user->email_verified_at ? 'text-success' : 'text-warning' }}"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-1">Verifikasi Email</h6>
                                                                <small class="text-muted">
                                                                    {{ $user->email_verified_at ? 'Terverifikasi pada ' . $user->email_verified_at->format('d M Y') : 'Belum terverifikasi' }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="security-item">
                                                        <div class="d-flex align-items-center">
                                                            <div class="security-icon me-3">
                                                                <i class="fas fa-clock text-info"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-1">Login Terakhir</h6>
                                                                <small class="text-muted">
                                                                    {{ $user->last_login_at ? $user->last_login_at->format('d M Y, H:i') : 'Belum pernah login' }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Photo Upload Modal -->
    <div class="modal fade" id="profilePictureModal" tabindex="-1" aria-labelledby="profilePictureModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profilePictureModalLabel">
                        <i class="fas fa-camera me-2"></i>Ubah Foto Profil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="profile-picture-preview mb-3">
                        <img src="" alt="Preview" id="modalProfilePreview" style="max-width: 200px; max-height: 200px; border-radius: 50%;">
                    </div>
                    <p class="text-muted">Pastikan foto profil Anda terlihat jelas dan profesional.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-primary" id="confirmProfileUpload">
                        <i class="fas fa-upload me-1"></i>Upload Foto
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Enhanced CSS Styles */
        :root {
            --primary-color: #6a6e51;
            --accent-color: #b9a16b;
            --success-color: #40c710;
            --danger-color: #f44032;
            --warning-color: #f5d700;
            --info-color: #17a2b8;
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

        /* Button Styling */
        .btn-primary {
            background-color: #956a3b;
            border-color: #956a3b;
            transition: var(--transition-normal);
        }

        .btn-primary:hover {
            background-color: #7d592f;
            border-color: #7d592f;
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            color: #956a3b;
            border-color: #956a3b;
        }

        .btn-outline-primary:hover {
            background-color: #956a3b;
            color: white;
        }

        /* Enhanced Alert Styling */
        .alert {
            border-radius: var(--border-radius);
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            border: none;
            box-shadow: var(--shadow-sm);
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

        .alert-warning {
            background-color: rgba(245, 215, 0, 0.1);
            color: #856404;
            border-left: 4px solid var(--warning-color);
        }

        .alert-info {
            background-color: rgba(23, 162, 184, 0.1);
            color: var(--info-color);
            border-left: 4px solid var(--info-color);
        }

        /* Profile Picture Styling */
        .profile-picture-container {
            position: relative;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
            transition: var(--transition-normal);
        }

        .profile-picture-container:hover {
            transform: scale(1.05);
        }

        .profile-picture {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: var(--shadow-md);
        }

        .profile-picture-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: var(--transition-normal);
            color: white;
            font-size: 1.5rem;
        }

        .profile-picture-container:hover .profile-picture-overlay {
            opacity: 1;
        }

        /* Enhanced Form Styling */
        .form-floating {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: var(--border-radius);
            border: 1px solid var(--border-light);
            padding: 0.75rem 1rem;
            transition: var(--transition-normal);
            position: relative;
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

        .form-control.is-valid {
            border-color: var(--success-color);
        }

        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Password Toggle Button */
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            z-index: 10;
            padding: 0.25rem;
            transition: var(--transition-normal);
        }

        .password-toggle:hover {
            color: var(--accent-color);
        }

        /* Password Strength Indicator */
        .password-strength .progress {
            height: 4px;
            background-color: #f8f9fa;
        }

        .password-strength .progress-bar {
            transition: width 0.3s ease, background-color 0.3s ease;
        }

        .strength-weak { background-color: var(--danger-color) !important; }
        .strength-fair { background-color: var(--warning-color) !important; }
        .strength-good { background-color: var(--info-color) !important; }
        .strength-strong { background-color: var(--success-color) !important; }

        /* Card Enhancement */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition-normal);
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-title {
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        /* Section styling */
        .my-account__edit {
            background-color: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: var(--shadow-sm);
        }

        /* Enhanced Tab styling */
        .nav-tabs {
            border-bottom: 1px solid var(--border-light);
            margin-bottom: 2rem;
        }

        .nav-tabs .nav-link {
            margin-bottom: -1px;
            border: 1px solid transparent;
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
            color: var(--text-muted);
            padding: 1rem 1.5rem;
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

        /* Security Items */
        .security-item {
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
        }

        .security-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.8);
            font-size: 1.2rem;
        }

        /* Form Text Enhancement */
        .form-text {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .form-text.text-warning {
            color: #856404 !important;
        }

        .form-text.text-success {
            color: var(--success-color) !important;
        }

        /* Mobile phone validation styling */
        #mobile:valid {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2340c710' d='M2.3 6.73.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .col-lg-2 {
                margin-bottom: 1.5rem;
            }

            .my-account__edit {
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .profile-picture-container {
                width: 80px;
                height: 80px;
            }

            .btn-group .btn {
                font-size: 0.875rem;
                padding: 0.375rem 0.75rem;
            }
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .slide-up {
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from { transform: translateY(10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Profile Picture Upload Functionality
            const profilePictureInput = document.getElementById('profilePictureInput');
            const profilePictureFile = document.getElementById('profilePictureFile');
            const profilePicturePreview = document.getElementById('profilePicturePreview');
            const modalProfilePreview = document.getElementById('modalProfilePreview');
            const uploadBtn = document.getElementById('uploadProfilePicture');
            const deleteBtn = document.getElementById('deleteProfilePicture');
            const profilePictureAction = document.getElementById('profilePictureAction');
            const confirmUploadBtn = document.getElementById('confirmProfileUpload');
            const profileModal = new bootstrap.Modal(document.getElementById('profilePictureModal'));

            // Upload functionality
            uploadBtn?.addEventListener('click', function() {
                profilePictureInput.click();
            });

            profilePictureInput?.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file size (max 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar. Maksimal 2MB.');
                        return;
                    }

                    // Validate file type
                    if (!file.type.match('image.*')) {
                        alert('File harus berupa gambar.');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        modalProfilePreview.src = e.target.result;
                        profileModal.show();
                    };
                    reader.readAsDataURL(file);
                }
            });

            confirmUploadBtn?.addEventListener('click', function() {
                const file = profilePictureInput.files[0];
                if (file) {
                    // Transfer file to the form
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    profilePictureFile.files = dt.files;

                    // Update preview
                    profilePicturePreview.src = modalProfilePreview.src;
                    profilePictureAction.value = 'upload';

                    profileModal.hide();

                    // Show success message
                    showNotification('Foto profil siap diupload. Klik "Simpan Perubahan" untuk menyimpan.', 'info');
                }
            });

            // Delete functionality
            deleteBtn?.addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
                    profilePictureAction.value = 'delete';
                    profilePicturePreview.src = 'https://via.placeholder.com/100x100/cccccc/666666?text=User';
                    showNotification('Foto profil akan dihapus. Klik "Simpan Perubahan" untuk menyimpan.', 'warning');
                }
            });

            // Mobile phone validation
            const mobileInput = document.getElementById('mobile');
            mobileInput?.addEventListener('input', function() {
                const value = this.value.replace(/\D/g, ''); // Remove non-digits

                // Indonesian phone number validation
                const pattern = /^(08|628)[0-9]{8,12}$/;

                if (value && !pattern.test(value)) {
                    this.setCustomValidity('Format nomor HP tidak valid. Gunakan format 08xxxxxxxxxx atau 628xxxxxxxxxx');
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else if (value) {
                    this.setCustomValidity('');
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-invalid', 'is-valid');
                }
            });

            // Password strength checker
            const newPasswordInput = document.getElementById('new_password');
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthText = document.getElementById('password-strength-text');
            const confirmPasswordInput = document.getElementById('new_password_confirmation');

            newPasswordInput?.addEventListener('input', function() {
                const password = this.value;
                const strength = calculatePasswordStrength(password);
                updatePasswordStrength(strength);
                checkPasswordMatch();
            });

            confirmPasswordInput?.addEventListener('input', checkPasswordMatch);

            function calculatePasswordStrength(password) {
                let score = 0;
                const checks = {
                    length: password.length >= 8,
                    lowercase: /[a-z]/.test(password),
                    uppercase: /[A-Z]/.test(password),
                    numbers: /\d/.test(password),
                    symbols: /[^A-Za-z0-9]/.test(password)
                };

                score = Object.values(checks).filter(Boolean).length;
                return { score, checks };
            }

            function updatePasswordStrength(strength) {
                const { score } = strength;
                let percentage = (score / 5) * 100;
                let className = '';
                let text = '';

                if (score === 0) {
                    percentage = 0;
                    text = '-';
                } else if (score <= 2) {
                    className = 'strength-weak';
                    text = 'Lemah';
                } else if (score === 3) {
                    className = 'strength-fair';
                    text = 'Cukup';
                } else if (score === 4) {
                    className = 'strength-good';
                    text = 'Baik';
                } else {
                    className = 'strength-strong';
                    text = 'Kuat';
                }

                strengthBar.style.width = percentage + '%';
                strengthBar.className = `progress-bar ${className}`;
                strengthText.textContent = text;
                strengthText.className = `fw-bold text-${className.replace('strength-', '')}`;
            }

            function checkPasswordMatch() {
                const password = newPasswordInput?.value;
                const confirmPassword = confirmPasswordInput?.value;

                if (password && confirmPassword) {
                    if (password !== confirmPassword) {
                        confirmPasswordInput.classList.add('is-invalid');
                        confirmPasswordInput.classList.remove('is-valid');
                        document.querySelector('.password-match-error').style.display = 'block';
                        return false;
                    } else {
                        confirmPasswordInput.classList.remove('is-invalid');
                        confirmPasswordInput.classList.add('is-valid');
                        document.querySelector('.password-match-error').style.display = 'none';
                        return true;
                    }
                }
                return true;
            }

            // Password toggle functionality
            document.querySelectorAll('.password-toggle').forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const target = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (target.type === 'password') {
                        target.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        target.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            // Form validation
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });

            // Password form validation
            const passwordForm = document.querySelector('form[name="password_edit_form"]');
            passwordForm?.addEventListener('submit', function(event) {
                const oldPassword = document.getElementById('old_password').value;
                const newPassword = document.getElementById('new_password').value;
                const confirmPassword = document.getElementById('new_password_confirmation').value;

                if (!checkPasswordMatch()) {
                    event.preventDefault();
                    return false;
                }

                if (!oldPassword || !newPassword || !confirmPassword) {
                    event.preventDefault();
                    alert('Semua field kata sandi harus diisi');
                    return false;
                }

                const strength = calculatePasswordStrength(newPassword);
                if (strength.score < 3) {
                    event.preventDefault();
                    alert('Kata sandi terlalu lemah. Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol.');
                    return false;
                }
            });

            // Tab navigation with URL hash
            const hash = window.location.hash;
            if (hash) {
                const tabId = hash.replace('#', '');
                const tab = document.querySelector(`#accountTabs button[data-bs-target="#${tabId}"]`);
                if (tab) {
                    const bsTab = new bootstrap.Tab(tab);
                    bsTab.show();
                }
            }

            const tabs = document.querySelectorAll('#accountTabs button');
            tabs.forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(event) {
                    const targetId = event.target.getAttribute('data-bs-target').replace('#', '');
                    window.history.replaceState(null, null, `#${targetId}`);
                });
            });

            // Notification function
            function showNotification(message, type = 'info') {
                const alertClass = `alert-${type}`;
                const iconClass = type === 'success' ? 'check-circle' :
                                type === 'warning' ? 'exclamation-triangle' :
                                type === 'danger' ? 'exclamation-circle' : 'info-circle';

                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show slide-up" role="alert">
                        <i class="fas fa-${iconClass} me-2"></i>${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;

                const container = document.querySelector('.my-account__edit-form');
                container.insertAdjacentHTML('afterbegin', alertHtml);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    const alert = container.querySelector('.alert:first-child');
                    if (alert) {
                        alert.remove();
                    }
                }, 5000);
            }

            // Add smooth animations
            document.querySelectorAll('.card').forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('fade-in');
                }, index * 100);
            });
        });
    </script>
@endsection

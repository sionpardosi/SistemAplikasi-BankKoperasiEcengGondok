@extends('layouts.admin')

@section('content')
    <style>
        /* Base Styling */
        .main-content-inner {
            padding: 1.5rem;
        }

        /* Content Cards */
        .content-card {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .card-header-custom {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .card-title-custom {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Form Styling */
        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-text {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }

        .input-group {
            position: relative;
        }

        .input-group .btn {
            border: 1px solid #dee2e6;
            border-left: none;
        }

        /* Profile Picture Section */
        .profile-upload-section {
            text-align: center;
        }

        .current-profile {
            margin-bottom: 20px;
        }

        .current-image,
        .profile-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-placeholder {
            background: #007bff;
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
        }

        .upload-preview {
            margin-bottom: 15px;
        }

        .preview-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto;
            display: none;
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .alert-info {
            background: #e3f2fd;
            color: #1565c0;
            border-left: 4px solid #2196f3;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        .alert-success {
            background: #d1f2eb;
            color: #0c5460;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        /* Button Styling */
        .btn-custom {
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .btn-success-custom {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-color: #28a745;
            color: white;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        }

        .btn-success-custom:hover {
            background: linear-gradient(135deg, #1e7e34 0%, #1a9b8c 100%);
            border-color: #1e7e34;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
        }

        .btn-secondary-custom {
            background: #6c757d;
            border-color: #6c757d;
            color: white;
        }

        .btn-secondary-custom:hover {
            background: #545b62;
            border-color: #545b62;
            color: white;
            transform: translateY(-1px);
        }

        .btn-outline-custom {
            background: transparent;
            border-color: #007bff;
            color: #007bff;
        }

        .btn-outline-custom:hover {
            background: #007bff;
            border-color: #007bff;
            color: white;
            transform: translateY(-1px);
        }

        .btn-danger-outline {
            background: transparent;
            border-color: #dc3545;
            color: #dc3545;
        }

        .btn-danger-outline:hover {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
            transform: translateY(-1px);
        }

        /* Info Tables */
        .info-table {
            width: 100%;
            margin-bottom: 0;
        }

        .info-table td {
            padding: 10px 0;
            border-bottom: 1px solid #f1f3f4;
            font-size: 14px;
            vertical-align: top;
        }

        .info-table td:first-child {
            font-weight: 600;
            color: #495057;
            width: 130px;
        }

        .info-table td:last-child {
            color: #6c757d;
        }

        .info-table tr:last-child td {
            border-bottom: none;
        }

        /* Form Check Styling */
        .form-check {
            padding: 15px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .form-check-label {
            font-weight: 600;
            color: #495057;
        }

        .form-check-label small {
            font-weight: 400;
            color: #6c757d;
            display: block;
            margin-top: 3px;
        }

        /* Verification Info */
        .verification-info .alert {
            margin-bottom: 0;
            padding: 10px 15px;
        }

        .alert-sm {
            font-size: 13px;
        }

        /* Removal Notice */
        .removal-notice {
            margin-top: 10px;
        }

        /* Character Counter */
        .character-counter {
            font-size: 12px;
            color: #6c757d;
            text-align: right;
            margin-top: 5px;
        }

        .character-counter.text-danger {
            color: #dc3545 !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .content-card {
                padding: 20px;
            }

            .btn-custom {
                width: 100%;
                justify-content: center;
                margin-bottom: 10px;
            }

            .current-image,
            .profile-placeholder,
            .preview-image {
                width: 100px;
                height: 100px;
            }

            .profile-placeholder {
                font-size: 2rem;
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Header Section -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Pengguna: {{ $user->name }}</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.data-pengguna.index') }}">
                            <div class="text-tiny">Data Pengguna</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.data-pengguna.show', $user->id) }}">
                            <div class="text-tiny">{{ $user->name }}</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Edit</div>
                    </li>
                </ul>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="icon-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h6><i class="icon-alert-circle me-2"></i>Terjadi kesalahan:</h6>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Main Form -->
            <form action="{{ route('admin.data-pengguna.update', $user->id) }}" method="POST"
                enctype="multipart/form-data" id="editUserForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Left Column -->
                    <div class="col-lg-8">
                        <!-- Basic Information -->
                        <div class="content-card">
                            <div class="card-header-custom">
                                <h5 class="card-title-custom">
                                    <i class="icon-user"></i>Informasi Dasar
                                </h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user->name) }}" required
                                        placeholder="Masukkan nama lengkap">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email) }}" required
                                        placeholder="contoh@email.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="mobile" class="form-label">Nomor HP <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('mobile') is-invalid @enderror"
                                        id="mobile" name="mobile" value="{{ old('mobile', $user->mobile) }}" required
                                        placeholder="08xxxxxxxxxx">
                                    @error('mobile')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="utype" class="form-label">Tipe Pengguna <span class="text-danger">*</span></label>
                                    <select class="form-select @error('utype') is-invalid @enderror" id="utype" name="utype" required>
                                        <option value="">Pilih Tipe Pengguna</option>
                                        <option value="USR" {{ old('utype', $user->utype) === 'USR' ? 'selected' : '' }}>
                                            Customer</option>
                                        <option value="ADM" {{ old('utype', $user->utype) === 'ADM' ? 'selected' : '' }}>
                                            Admin</option>
                                    </select>
                                    @error('utype')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($user->utype === 'ADM' && $user->id === auth()->id())
                                        <div class="form-text text-warning">
                                            <i class="icon-alert-triangle me-1"></i>
                                            Anda sedang mengedit akun Anda sendiri
                                        </div>
                                    @endif
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="bio" class="form-label">Bio/Deskripsi</label>
                                    <textarea class="form-control @error('bio') is-invalid @enderror"
                                        id="bio" name="bio" rows="3"
                                        placeholder="Deskripsi singkat tentang pengguna (opsional)">{{ old('bio', $user->bio) }}</textarea>
                                    @error('bio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="character-counter" id="bioCounter">0/1000 karakter</div>
                                </div>
                            </div>
                        </div>

                        <!-- Password Section -->
                        <div class="content-card">
                            <div class="card-header-custom">
                                <h5 class="card-title-custom">
                                    <i class="icon-lock"></i>Ubah Password
                                </h5>
                            </div>

                            <div class="alert alert-info">
                                <i class="icon-info me-2"></i>
                                Kosongkan jika tidak ingin mengubah password
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" placeholder="Minimal 8 karakter">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                            <i class="icon-eye" id="password-icon"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Password harus minimal 8 karakter dan mengandung kombinasi huruf dan angka
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" placeholder="Ulangi password baru">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                            <i class="icon-eye" id="password_confirmation-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account History -->
                        <div class="content-card">
                            <div class="card-header-custom">
                                <h5 class="card-title-custom">
                                    <i class="icon-clock"></i>Riwayat Akun
                                </h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <table class="info-table">
                                        <tr>
                                            <td>Terdaftar:</td>
                                            <td>
                                                {{ $user->created_at->format('d M Y, H:i') }}
                                                <small class="d-block text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Diperbarui:</td>
                                            <td>
                                                {{ $user->updated_at->format('d M Y, H:i') }}
                                                <small class="d-block text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="info-table">
                                        <tr>
                                            <td>Login Terakhir:</td>
                                            <td>
                                                @if ($user->last_login_at)
                                                    {{ $user->last_login_at->format('d M Y, H:i') }}
                                                    <small class="d-block text-muted">{{ $user->last_login_at->diffForHumans() }}</small>
                                                @else
                                                    <span class="text-muted">Belum pernah login</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total Alamat:</td>
                                            <td>
                                                <span class="badge bg-info">{{ $user->addresses->count() }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-4">
                        <!-- Current Profile Picture -->
                        <div class="content-card">
                            <div class="card-header-custom">
                                <h5 class="card-title-custom">
                                    <i class="icon-image"></i>Foto Profil Saat Ini
                                </h5>
                            </div>

                            <div class="profile-upload-section">
                                <div class="current-profile">
                                    @if ($user->profile_picture)
                                        <img src="{{ asset($user->profile_picture) }}" alt="{{ $user->name }}"
                                            class="current-image">
                                    @else
                                        <div class="profile-placeholder">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>

                                <h6>{{ $user->name }}</h6>
                                <p class="text-muted">{{ $user->email }}</p>
                            </div>
                        </div>

                        <!-- Upload New Profile Picture -->
                        <div class="content-card">
                            <div class="card-header-custom">
                                <h5 class="card-title-custom">
                                    <i class="icon-upload"></i>Ubah Foto Profil
                                </h5>
                            </div>

                            <div class="profile-upload-section">
                                <div class="upload-preview">
                                    <img id="preview-image" alt="Preview" class="preview-image">
                                </div>

                                <div class="upload-controls mb-3">
                                    <input type="file" class="form-control @error('profile_picture') is-invalid @enderror"
                                        id="profile_picture" name="profile_picture" accept="image/*" onchange="previewImage(this)">
                                    @error('profile_picture')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-text text-center">
                                    Format: JPG, JPEG, PNG, GIF<br>
                                    Maksimal: 2MB
                                </div>

                                @if ($user->profile_picture)
                                    <button type="button" class="btn btn-custom btn-danger-outline btn-sm mt-3" onclick="removeCurrentImage()">
                                        <i class="icon-trash"></i>Hapus Foto Saat Ini
                                    </button>
                                    <input type="hidden" id="remove_image" name="remove_image" value="0">
                                @endif
                            </div>
                        </div>

                        <!-- Account Settings -->
                        <div class="content-card">
                            <div class="card-header-custom">
                                <h5 class="card-title-custom">
                                    <i class="icon-settings"></i>Pengaturan Akun
                                </h5>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="email_verified" name="email_verified"
                                    {{ old('email_verified', $user->email_verified_at) ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_verified">
                                    Email Terverifikasi
                                    <small>Centang jika email sudah terverifikasi</small>
                                </label>
                            </div>

                            <div class="verification-info">
                                @if ($user->email_verified_at)
                                    <div class="alert alert-success alert-sm">
                                        <i class="icon-check-circle me-1"></i>
                                        <small>Email diverifikasi pada {{ $user->email_verified_at->format('d M Y, H:i') }}</small>
                                    </div>
                                @else
                                    <div class="alert alert-warning alert-sm">
                                        <i class="icon-alert-circle me-1"></i>
                                        <small>Email belum terverifikasi</small>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="content-card">
                            <div class="d-grid gap-3">
                                <button type="submit" class="btn-custom btn-success-custom">
                                    <i class="icon-save"></i>Simpan Perubahan
                                </button>

                                <button type="button" class="btn-custom btn-secondary-custom" onclick="resetForm()">
                                    <i class="icon-refresh-cw"></i>Reset Form
                                </button>

                                <a href="{{ route('admin.data-pengguna.show', $user->id) }}" class="btn-custom btn-outline-custom">
                                    <i class="icon-eye"></i>Lihat Detail
                                </a>

                                <a href="{{ route('admin.data-pengguna.index') }}" class="btn-custom btn-outline-custom">
                                    <i class="icon-arrow-left"></i>Kembali ke Daftar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Store original values for reset
        const originalValues = {
            name: '{{ $user->name }}',
            email: '{{ $user->email }}',
            mobile: '{{ $user->mobile }}',
            utype: '{{ $user->utype }}',
            bio: '{{ $user->bio }}',
            email_verified: {{ $user->email_verified_at ? 'true' : 'false' }}
        };

        // Character counter for bio
        function updateBioCounter() {
            const bioField = document.getElementById('bio');
            const counter = document.getElementById('bioCounter');
            const currentLength = bioField.value.length;
            const maxLength = 1000;

            counter.textContent = `${currentLength}/${maxLength} karakter`;

            if (currentLength > maxLength) {
                counter.classList.add('text-danger');
                bioField.classList.add('is-invalid');
            } else {
                counter.classList.remove('text-danger');
                bioField.classList.remove('is-invalid');
            }
        }

        document.getElementById('bio').addEventListener('input', updateBioCounter);

        // Initialize counter
        updateBioCounter();

        // Preview uploaded image
        function previewImage(input) {
            const preview = document.getElementById('preview-image');
            const currentImage = document.querySelector('.current-image');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    preview.style.border = '3px solid #28a745';

                    // Hide current image
                    if (currentImage) {
                        currentImage.style.opacity = '0.5';
                    }
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';

                // Show current image
                if (currentImage) {
                    currentImage.style.opacity = '1';
                }
            }
        }

        // Remove current image
        function removeCurrentImage() {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Yakin ingin menghapus foto profil saat ini?',
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Hapus',
                confirmButtonColor: '#dc3545'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('remove_image').value = '1';
                    const currentImage = document.querySelector('.current-image');
                    if (currentImage) {
                        currentImage.style.opacity = '0.3';
                        currentImage.style.filter = 'grayscale(100%)';
                    }

                    // Show indication that image will be removed
                    const cardBody = currentImage.closest('.profile-upload-section');
                    if (!cardBody.querySelector('.removal-notice')) {
                        const notice = document.createElement('div');
                        notice.className = 'alert alert-warning alert-sm mt-2 removal-notice';
                        notice.innerHTML = '<i class="icon-trash me-1"></i><small>Foto akan dihapus saat menyimpan</small>';
                        cardBody.appendChild(notice);
                    }
                }
            });
        }

        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'icon-eye-off';
            } else {
                field.type = 'password';
                icon.className = 'icon-eye';
            }
        }

        // Reset form
        function resetForm() {
            Swal.fire({
                title: 'Konfirmasi Reset',
                text: 'Yakin ingin mereset form? Semua perubahan yang belum disimpan akan hilang.',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Reset',
                confirmButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('name').value = originalValues.name;
                    document.getElementById('email').value = originalValues.email;
                    document.getElementById('mobile').value = originalValues.mobile;
                    document.getElementById('utype').value = originalValues.utype;
                    document.getElementById('bio').value = originalValues.bio;
                    document.getElementById('email_verified').checked = originalValues.email_verified;
                    document.getElementById('password').value = '';
                    document.getElementById('password_confirmation').value = '';
                    document.getElementById('profile_picture').value = '';

                    // Reset image preview
                    document.getElementById('preview-image').style.display = 'none';
                    const currentImage = document.querySelector('.current-image');
                    if (currentImage) {
                        currentImage.style.opacity = '1';
                        currentImage.style.filter = 'none';
                    }

                    // Reset remove image flag
                    const removeImageField = document.getElementById('remove_image');
                    if (removeImageField) {
                        removeImageField.value = '0';
                    }

                    // Remove removal notice
                    const removalNotice = document.querySelector('.removal-notice');
                    if (removalNotice) {
                        removalNotice.remove();
                    }

                    // Update bio counter
                    updateBioCounter();
                }
            });
        }

        // Form validation
        document.getElementById('editUserForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;

            // Only validate password if it's filled
            if (password || confirmPassword) {
                if (password !== confirmPassword) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Error',
                        text: 'Password dan konfirmasi password tidak sama!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }

                if (password.length < 8) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Error',
                        text: 'Password harus minimal 8 karakter!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }
            }
        });

        // Mobile number formatting
        document.getElementById('mobile').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits

            // Add country code if not present
            if (value.length > 0 && !value.startsWith('62') && !value.startsWith('08')) {
                if (value.startsWith('8')) {
                    value = '0' + value;
                }
            }

            e.target.value = value;
        });

        // Email validation
        document.getElementById('email').addEventListener('blur', function(e) {
            const email = e.target.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email && !emailRegex.test(email)) {
                e.target.classList.add('is-invalid');
                if (!e.target.nextElementSibling || !e.target.nextElementSibling.classList.contains('invalid-feedback')) {
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = 'Format email tidak valid';
                    e.target.parentNode.appendChild(feedback);
                }
            } else {
                e.target.classList.remove('is-invalid');
                const feedback = e.target.parentNode.querySelector('.invalid-feedback');
                if (feedback && feedback.textContent === 'Format email tidak valid') {
                    feedback.remove();
                }
            }
        });

        // Success message
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#28a745'
            });
        @endif
    </script>
@endsection

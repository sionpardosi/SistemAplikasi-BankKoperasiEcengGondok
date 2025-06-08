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

        .upload-preview {
            margin-bottom: 20px;
        }

        .preview-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto;
            border: 3px dashed #dee2e6;
            transition: all 0.3s ease;
        }

        .preview-image.has-image {
            border: 3px solid #28a745;
        }

        .upload-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px dashed #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            background: #f8f9fa;
            color: #6c757d;
            font-size: 14px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .upload-placeholder:hover {
            border-color: #007bff;
            color: #007bff;
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

        /* Password Strength Indicator */
        .password-strength {
            margin-top: 8px;
        }

        .strength-bar {
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 5px;
        }

        .strength-fill {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-text {
            font-size: 12px;
            font-weight: 600;
        }

        .strength-weak {
            background: #dc3545;
            color: #dc3545;
        }

        .strength-medium {
            background: #ffc107;
            color: #856404;
        }

        .strength-strong {
            background: #28a745;
            color: #28a745;
        }

        /* Preview Cards */
        .preview-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }

        .preview-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 24px;
            font-weight: 700;
        }

        .preview-name {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 5px;
        }

        .preview-email {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .preview-type {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .type-admin {
            background: #f8d7da;
            color: #721c24;
        }

        .type-customer {
            background: #d1ecf1;
            color: #0c5460;
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

            .preview-image,
            .upload-placeholder {
                width: 100px;
                height: 100px;
            }

            .preview-avatar {
                width: 60px;
                height: 60px;
                font-size: 20px;
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Header Section -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Tambah Pengguna Baru</h3>
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
                        <div class="text-tiny">Tambah Pengguna</div>
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
            <form action="{{ route('admin.data-pengguna.store') }}" method="POST" enctype="multipart/form-data"
                id="createUserForm">
                @csrf

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
                                        id="name" name="name" value="{{ old('name') }}" required
                                        placeholder="Masukkan nama lengkap">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required
                                        placeholder="contoh@email.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="mobile" class="form-label">Nomor HP <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('mobile') is-invalid @enderror"
                                        id="mobile" name="mobile" value="{{ old('mobile') }}" required
                                        placeholder="08xxxxxxxxxx">
                                    @error('mobile')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="utype" class="form-label">Tipe Pengguna <span class="text-danger">*</span></label>
                                    <select class="form-select @error('utype') is-invalid @enderror" id="utype" name="utype" required>
                                        <option value="">Pilih Tipe Pengguna</option>
                                        <option value="USR" {{ old('utype') === 'USR' ? 'selected' : '' }}>Customer</option>
                                        <option value="ADM" {{ old('utype') === 'ADM' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    @error('utype')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="bio" class="form-label">Bio/Deskripsi</label>
                                    <textarea class="form-control @error('bio') is-invalid @enderror"
                                        id="bio" name="bio" rows="3"
                                        placeholder="Deskripsi singkat tentang pengguna (opsional)">{{ old('bio') }}</textarea>
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
                                    <i class="icon-lock"></i>Keamanan Akun
                                </h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" required placeholder="Minimal 8 karakter">
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
                                    <div class="password-strength" id="passwordStrength" style="display: none;">
                                        <div class="strength-bar">
                                            <div class="strength-fill" id="strengthFill"></div>
                                        </div>
                                        <div class="strength-text" id="strengthText"></div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" required placeholder="Ulangi password">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                            <i class="icon-eye" id="password_confirmation-icon"></i>
                                        </button>
                                    </div>
                                    <div class="form-text" id="passwordMatch" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-4">
                        <!-- Profile Picture -->
                        <div class="content-card">
                            <div class="card-header-custom">
                                <h5 class="card-title-custom">
                                    <i class="icon-image"></i>Foto Profil
                                </h5>
                            </div>

                            <div class="profile-upload-section">
                                <div class="upload-preview">
                                    <div class="upload-placeholder" id="uploadPlaceholder">
                                        <div>
                                            <i class="icon-camera" style="font-size: 24px; margin-bottom: 8px;"></i>
                                            <div>Upload Foto</div>
                                        </div>
                                    </div>
                                    <img id="preview-image" alt="Preview" class="preview-image" style="display: none;">
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
                            </div>
                        </div>

                        <!-- Preview Card -->
                        <div class="content-card">
                            <div class="card-header-custom">
                                <h5 class="card-title-custom">
                                    <i class="icon-eye"></i>Preview Pengguna
                                </h5>
                            </div>

                            <div class="preview-card">
                                <div class="preview-avatar" id="previewAvatar">
                                    <i class="icon-user"></i>
                                </div>
                                <div class="preview-name" id="previewName">Nama Pengguna</div>
                                <div class="preview-email" id="previewEmail">email@example.com</div>
                                <div class="preview-type type-customer" id="previewType">Customer</div>
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
                                    {{ old('email_verified') ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_verified">
                                    Email Terverifikasi
                                    <small>Centang jika email sudah terverifikasi</small>
                                </label>
                            </div>

                            <div class="alert alert-info">
                                <i class="icon-info me-2"></i>
                                <small>
                                    Pengguna baru akan menerima email notifikasi pembuatan akun.
                                </small>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="content-card">
                            <div class="d-grid gap-3">
                                <button type="submit" class="btn-custom btn-success-custom">
                                    <i class="icon-save"></i>Simpan Pengguna
                                </button>

                                <button type="button" class="btn-custom btn-secondary-custom" onclick="resetForm()">
                                    <i class="icon-refresh-cw"></i>Reset Form
                                </button>

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

        // Password strength checker
        function checkPasswordStrength(password) {
            const strengthIndicator = document.getElementById('passwordStrength');
            const strengthFill = document.getElementById('strengthFill');
            const strengthText = document.getElementById('strengthText');

            if (!password) {
                strengthIndicator.style.display = 'none';
                return;
            }

            strengthIndicator.style.display = 'block';

            let score = 0;

            // Length check
            if (password.length >= 8) score++;
            if (password.length >= 12) score++;

            // Character variety
            if (/[a-z]/.test(password)) score++;
            if (/[A-Z]/.test(password)) score++;
            if (/[0-9]/.test(password)) score++;
            if (/[^A-Za-z0-9]/.test(password)) score++;

            let strength = 'weak';
            let width = '33%';
            let className = 'strength-weak';

            if (score >= 4) {
                strength = 'strong';
                width = '100%';
                className = 'strength-strong';
            } else if (score >= 2) {
                strength = 'medium';
                width = '66%';
                className = 'strength-medium';
            }

            strengthFill.style.width = width;
            strengthFill.className = 'strength-fill ' + className;
            strengthText.textContent = 'Kekuatan: ' + (strength === 'weak' ? 'Lemah' : strength === 'medium' ? 'Sedang' : 'Kuat');
            strengthText.className = 'strength-text ' + className;
        }

        // Password confirmation checker
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmation = document.getElementById('password_confirmation').value;
            const matchIndicator = document.getElementById('passwordMatch');

            if (!confirmation) {
                matchIndicator.style.display = 'none';
                return;
            }

            matchIndicator.style.display = 'block';

            if (password === confirmation) {
                matchIndicator.textContent = '✓ Password cocok';
                matchIndicator.className = 'form-text text-success';
            } else {
                matchIndicator.textContent = '✗ Password tidak cocok';
                matchIndicator.className = 'form-text text-danger';
            }
        }

        // Update preview
        function updatePreview() {
            const name = document.getElementById('name').value || 'Nama Pengguna';
            const email = document.getElementById('email').value || 'email@example.com';
            const utype = document.getElementById('utype').value;

            document.getElementById('previewName').textContent = name;
            document.getElementById('previewEmail').textContent = email;

            const previewAvatar = document.getElementById('previewAvatar');
            previewAvatar.textContent = name.charAt(0).toUpperCase();

            const previewType = document.getElementById('previewType');
            if (utype === 'ADM') {
                previewType.textContent = 'Admin';
                previewType.className = 'preview-type type-admin';
            } else if (utype === 'USR') {
                previewType.textContent = 'Customer';
                previewType.className = 'preview-type type-customer';
            } else {
                previewType.textContent = 'Customer';
                previewType.className = 'preview-type type-customer';
            }
        }

        // Event listeners
        document.getElementById('bio').addEventListener('input', updateBioCounter);
        document.getElementById('password').addEventListener('input', function() {
            checkPasswordStrength(this.value);
        });
        document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);
        document.getElementById('name').addEventListener('input', updatePreview);
        document.getElementById('email').addEventListener('input', updatePreview);
        document.getElementById('utype').addEventListener('change', updatePreview);

        // Initialize
        updateBioCounter();
        updatePreview();

        // Preview uploaded image
        function previewImage(input) {
            const preview = document.getElementById('preview-image');
            const placeholder = document.getElementById('uploadPlaceholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    preview.classList.add('has-image');
                    placeholder.style.display = 'none';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
                preview.classList.remove('has-image');
                placeholder.style.display = 'flex';
            }
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
                text: 'Yakin ingin mereset form? Semua data yang telah diisi akan hilang.',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Reset',
                confirmButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('createUserForm').reset();
                    document.getElementById('preview-image').style.display = 'none';
                    document.getElementById('uploadPlaceholder').style.display = 'flex';
                    document.getElementById('passwordStrength').style.display = 'none';
                    document.getElementById('passwordMatch').style.display = 'none';
                    updateBioCounter();
                    updatePreview();
                }
            });
        }

        // Form validation
        document.getElementById('createUserForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;

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

@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="main-content-inner">
            <div class="main-content-wrap">
                <!-- Header Section -->
                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                    <h3>Edit Pengguna: {{ $user->name }}</h3>
                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">
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
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h6>Terjadi kesalahan:</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Main Form -->
                <div class="wg-box">
                    <form action="{{ route('admin.data-pengguna.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data" id="editUserForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-8">
                                <!-- Basic Information -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="icon-user me-2"></i>Informasi Dasar
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="name" class="form-label">Nama Lengkap <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    name="name" value="{{ old('name', $user->name) }}" required
                                                    placeholder="Masukkan nama lengkap">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label">Email <span
                                                        class="text-danger">*</span></label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    name="email" value="{{ old('email', $user->email) }}" required
                                                    placeholder="contoh@email.com">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="mobile" class="form-label">Nomor HP <span
                                                        class="text-danger">*</span></label>
                                                <input type="tel"
                                                    class="form-control @error('mobile') is-invalid @enderror"
                                                    id="mobile" name="mobile"
                                                    value="{{ old('mobile', $user->mobile) }}" required
                                                    placeholder="08xxxxxxxxxx">
                                                @error('mobile')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="utype" class="form-label">Tipe Pengguna <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select @error('utype') is-invalid @enderror"
                                                    id="utype" name="utype" required>
                                                    <option value="">Pilih Tipe Pengguna</option>
                                                    <option value="USR"
                                                        {{ old('utype', $user->utype) === 'USR' ? 'selected' : '' }}>
                                                        Customer</option>
                                                    <option value="ADM"
                                                        {{ old('utype', $user->utype) === 'ADM' ? 'selected' : '' }}>Admin
                                                    </option>
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
                                                <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3"
                                                    placeholder="Deskripsi singkat tentang pengguna (opsional)">{{ old('bio', $user->bio) }}</textarea>
                                                @error('bio')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">Maksimal 1000 karakter</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Password Section -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="icon-lock me-2"></i>Ubah Password
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info">
                                            <i class="icon-info-circle me-2"></i>
                                            Kosongkan jika tidak ingin mengubah password
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="password" class="form-label">Password Baru</label>
                                                <div class="input-group">
                                                    <input type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        id="password" name="password" placeholder="Minimal 8 karakter">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        onclick="togglePassword('password')">
                                                        <i class="icon-eye" id="password-icon"></i>
                                                    </button>
                                                </div>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">
                                                    Password harus minimal 8 karakter dan mengandung kombinasi huruf dan
                                                    angka
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="password_confirmation" class="form-label">Konfirmasi Password
                                                    Baru</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control"
                                                        id="password_confirmation" name="password_confirmation"
                                                        placeholder="Ulangi password baru">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        onclick="togglePassword('password_confirmation')">
                                                        <i class="icon-eye" id="password_confirmation-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Account History -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="icon-clock me-2"></i>Riwayat Akun
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-borderless table-sm">
                                                    <tr>
                                                        <td width="130"><strong>Terdaftar:</strong></td>
                                                        <td>
                                                            {{ $user->created_at->format('d M Y, H:i') }}
                                                            <small
                                                                class="text-muted d-block">{{ $user->created_at->diffForHumans() }}</small>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Diperbarui:</strong></td>
                                                        <td>
                                                            {{ $user->updated_at->format('d M Y, H:i') }}
                                                            <small
                                                                class="text-muted d-block">{{ $user->updated_at->diffForHumans() }}</small>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-borderless table-sm">
                                                    <tr>
                                                        <td width="140"><strong>Login Terakhir:</strong></td>
                                                        <td>
                                                            @if ($user->last_login_at)
                                                                {{ $user->last_login_at->format('d M Y, H:i') }}
                                                                <small
                                                                    class="text-muted d-block">{{ $user->last_login_at->diffForHumans() }}</small>
                                                            @else
                                                                <span class="text-muted">Belum pernah login</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Total Alamat:</strong></td>
                                                        <td>
                                                            <span
                                                                class="badge bg-info">{{ $user->addresses->count() }}</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-4">
                                <!-- Current Profile Picture -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="icon-image me-2"></i>Foto Profil Saat Ini
                                        </h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="current-profile mb-3">
                                            @if ($user->profile_picture)
                                                <img src="{{ asset($user->profile_picture) }}" alt="{{ $user->name }}"
                                                    class="rounded-circle current-image"
                                                    style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #e9ecef;">
                                            @else
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                                    style="width: 120px; height: 120px; border: 3px solid #e9ecef;">
                                                    <span class="text-white"
                                                        style="font-size: 2.5rem; font-weight: bold;">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        <h6>{{ $user->name }}</h6>
                                        <p class="text-muted">{{ $user->email }}</p>
                                    </div>
                                </div>

                                <!-- Upload New Profile Picture -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="icon-upload me-2"></i>Ubah Foto Profil
                                        </h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="profile-upload">
                                            <div class="upload-preview mb-3">
                                                <img id="preview-image"
                                                    src="https://via.placeholder.com/120x120/e9ecef/6c757d?text=Preview"
                                                    alt="Preview" class="rounded-circle"
                                                    style="width: 120px; height: 120px; object-fit: cover; border: 3px dashed #dee2e6; display: none;">
                                            </div>

                                            <div class="upload-controls">
                                                <input type="file"
                                                    class="form-control @error('profile_picture') is-invalid @enderror"
                                                    id="profile_picture" name="profile_picture" accept="image/*"
                                                    onchange="previewImage(this)">
                                                @error('profile_picture')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-text">
                                                Format: JPG, JPEG, PNG, GIF<br>
                                                Maksimal: 2MB
                                            </div>

                                            @if ($user->profile_picture)
                                                <button type="button" class="btn btn-outline-danger btn-sm mt-2"
                                                    onclick="removeCurrentImage()">
                                                    <i class="icon-trash me-1"></i>Hapus Foto Saat Ini
                                                </button>
                                                <input type="hidden" id="remove_image" name="remove_image"
                                                    value="0">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Settings -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="icon-settings me-2"></i>Pengaturan Akun
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="email_verified"
                                                name="email_verified"
                                                {{ old('email_verified', $user->email_verified_at) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="email_verified">
                                                <strong>Email Terverifikasi</strong>
                                                <small class="d-block text-muted">
                                                    Centang jika email sudah terverifikasi
                                                </small>
                                            </label>
                                        </div>

                                        <div class="verification-info">
                                            @if ($user->email_verified_at)
                                                <div class="alert alert-success alert-sm">
                                                    <i class="icon-check-circle me-1"></i>
                                                    <small>Email diverifikasi pada
                                                        {{ $user->email_verified_at->format('d M Y, H:i') }}</small>
                                                </div>
                                            @else
                                                <div class="alert alert-warning alert-sm">
                                                    <i class="icon-alert-circle me-1"></i>
                                                    <small>Email belum terverifikasi</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-success">
                                                <i class="icon-save me-2"></i>Simpan Perubahan
                                            </button>

                                            <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                                <i class="icon-refresh-cw me-2"></i>Reset Form
                                            </button>

                                            <a href="{{ route('admin.data-pengguna.show', $user->id) }}"
                                                class="btn btn-outline-primary">
                                                <i class="icon-eye me-2"></i>Lihat Detail
                                            </a>

                                            <a href="{{ route('admin.data-pengguna.index') }}"
                                                class="btn btn-outline-secondary">
                                                <i class="icon-arrow-left me-2"></i>Kembali ke Daftar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
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
                if (confirm('Yakin ingin menghapus foto profil saat ini?')) {
                    document.getElementById('remove_image').value = '1';
                    const currentImage = document.querySelector('.current-image');
                    if (currentImage) {
                        currentImage.style.opacity = '0.3';
                        currentImage.style.filter = 'grayscale(100%)';
                    }

                    // Show indication that image will be removed
                    const cardBody = currentImage.closest('.card-body');
                    if (!cardBody.querySelector('.removal-notice')) {
                        const notice = document.createElement('div');
                        notice.className = 'alert alert-warning alert-sm mt-2 removal-notice';
                        notice.innerHTML = '<i class="icon-trash me-1"></i><small>Foto akan dihapus saat menyimpan</small>';
                        cardBody.appendChild(notice);
                    }
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
                if (confirm('Yakin ingin mereset form? Semua perubahan yang belum disimpan akan hilang.')) {
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
                }
            }

            // Form validation
            document.getElementById('editUserForm').addEventListener('submit', function(e) {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('password_confirmation').value;

                // Only validate password if it's filled
                if (password || confirmPassword) {
                    if (password !== confirmPassword) {
                        e.preventDefault();
                        alert('Password dan konfirmasi password tidak sama!');
                        return false;
                    }

                    if (password.length < 8) {
                        e.preventDefault();
                        alert('Password harus minimal 8 karakter!');
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
                    if (!e.target.nextElementSibling || !e.target.nextElementSibling.classList.contains(
                            'invalid-feedback')) {
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

            // Bio character counter
            document.getElementById('bio').addEventListener('input', function(e) {
                const maxLength = 1000;
                const currentLength = e.target.value.length;
                const formText = e.target.parentNode.querySelector('.form-text');

                formText.textContent = `${currentLength}/${maxLength} karakter`;

                if (currentLength > maxLength) {
                    e.target.classList.add('is-invalid');
                    formText.classList.add('text-danger');
                } else {
                    e.target.classList.remove('is-invalid');
                    formText.classList.remove('text-danger');
                }
            });
        </script>
    @endpush
@endsection

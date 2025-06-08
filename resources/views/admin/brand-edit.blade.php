@extends('layouts.admin')

@section('content')
    <style>
        /* Base Styling */
        .main-content-inner {
            padding: 1.5rem;
        }

        /* Form Container */
        .form-container {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            margin-bottom: 25px;
        }

        .form-header {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .form-title {
            font-size: 24px;
            font-weight: 700;
            color: #495057;
            margin: 0 0 8px 0;
        }

        .form-description {
            color: #6c757d;
            font-size: 15px;
            margin: 0;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-size: 15px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .required {
            color: #dc3545;
            margin-left: 3px;
        }

        .form-control {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #ffffff;
            width: 100%;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            outline: none;
        }

        .form-text {
            font-size: 13px;
            color: #6c757d;
            margin-top: 5px;
        }

        /* Image Upload Section */
        .upload-section {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .upload-section:hover {
            border-color: #007bff;
            background: #f0f8ff;
        }

        .upload-section.dragover {
            border-color: #007bff;
            background: #e3f2fd;
            transform: scale(1.02);
        }

        .upload-icon {
            font-size: 48px;
            color: #007bff;
            margin-bottom: 15px;
        }

        .upload-text {
            font-size: 16px;
            color: #495057;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .upload-subtext {
            font-size: 14px;
            color: #6c757d;
        }

        .upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        /* Image Preview */
        .image-preview {
            margin-top: 20px;
            text-align: center;
            display: none;
        }

        .preview-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .preview-actions {
            margin-top: 15px;
        }

        .btn-remove-image {
            background: #dc3545;
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-remove-image:hover {
            background: #c82333;
            transform: translateY(-1px);
        }

        /* Form Actions */
        .form-actions {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px 30px;
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            border: 1px solid #6c757d;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary:hover {
            background: #545b62;
            border-color: #545b62;
            color: white;
            transform: translateY(-1px);
        }

        /* Alert Messages */
        .alert {
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border: none;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-success {
            background: #d1f2eb;
            color: #0c5460;
            border-left: 4px solid #28a745;
        }

        /* Input Groups */
        .input-group {
            position: relative;
        }

        .input-group-text {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 16px;
            z-index: 3;
        }

        .input-group .form-control {
            padding-left: 45px;
        }

        /* Character Counter */
        .char-counter {
            font-size: 12px;
            color: #6c757d;
            text-align: right;
            margin-top: 5px;
        }

        .char-counter.warning {
            color: #ffc107;
        }

        .char-counter.danger {
            color: #dc3545;
        }

        /* Loading States */
        .btn-loading {
            opacity: 0.7;
            cursor: not-allowed;
            position: relative;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Form Validation */
        .is-invalid {
            border-color: #dc3545;
        }

        .is-valid {
            border-color: #28a745;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .valid-feedback {
            color: #28a745;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        /* Tips Section */
        .tips-section {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .tips-title {
            font-size: 16px;
            font-weight: 700;
            color: #1565c0;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tips-list {
            margin: 0;
            padding-left: 20px;
            color: #1976d2;
        }

        .tips-list li {
            margin-bottom: 5px;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .form-container {
                padding: 20px;
            }

            .form-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .action-buttons {
                width: 100%;
                justify-content: center;
            }

            .btn-primary,
            .btn-secondary {
                flex: 1;
                justify-content: center;
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Tambah Merek Baru</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.brands') }}">
                            <div class="text-tiny">Merek</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Tambah Baru</div>
                    </li>
                </ul>
            </div>

            <!-- Tips Section -->
            <div class="tips-section">
                <div class="tips-title">
                    <i class="icon-lightbulb"></i> Tips Menambah Merek Baru
                </div>
                <ul class="tips-list">
                    <li>Gunakan nama merek yang jelas dan mudah diingat</li>
                    <li>Upload gambar logo dengan kualitas tinggi (minimal 300x300px)</li>
                    <li>Pastikan slug unik dan SEO-friendly</li>
                    <li>Gunakan format gambar PNG atau JPG dengan ukuran maksimal 2MB</li>
                </ul>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <div class="form-header">
                    <h4 class="form-title">
                        <i class="icon-credit-card"></i> Formulir Tambah Merek
                    </h4>
                    <p class="form-description">
                        Lengkapi informasi berikut untuk menambahkan merek baru ke dalam sistem
                    </p>
                </div>

                <form id="brandForm" action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="row">
                        <!-- Brand Name -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">
                                    Nama Merek <span class="required">*</span>
                                </label>
                                <div class="input-group">
                                    <i class="icon-credit-card input-group-text"></i>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name"
                                           id="name"
                                           placeholder="Masukkan nama merek..."
                                           value="{{ old('name') }}"
                                           maxlength="100"
                                           required>
                                </div>
                                <div class="char-counter">
                                    <span id="nameCounter">0</span>/100 karakter
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Nama merek akan ditampilkan di halaman produk dan katalog
                                </div>
                            </div>
                        </div>

                        <!-- Brand Slug -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">
                                    Slug Merek <span class="required">*</span>
                                </label>
                                <div class="input-group">
                                    <i class="icon-link input-group-text"></i>
                                    <input type="text"
                                           class="form-control @error('slug') is-invalid @enderror"
                                           name="slug"
                                           id="slug"
                                           placeholder="Slug akan dibuat otomatis..."
                                           value="{{ old('slug') }}"
                                           maxlength="100"
                                           required>
                                </div>
                                <div class="char-counter">
                                    <span id="slugCounter">0</span>/100 karakter
                                </div>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    URL-friendly version dari nama merek (otomatis dibuat)
                                </div>
                            </div>
                        </div>

                        <!-- Brand Description -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">
                                    Deskripsi Merek <span class="text-muted">(Opsional)</span>
                                </label>
                                <textarea class="form-control"
                                          name="description"
                                          id="description"
                                          placeholder="Masukkan deskripsi singkat tentang merek..."
                                          rows="4"
                                          maxlength="500">{{ old('description') }}</textarea>
                                <div class="char-counter">
                                    <span id="descCounter">0</span>/500 karakter
                                </div>
                                <div class="form-text">
                                    Deskripsi singkat tentang merek (akan ditampilkan di halaman detail)
                                </div>
                            </div>
                        </div>

                        <!-- Brand Image Upload -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">
                                    Logo/Gambar Merek <span class="required">*</span>
                                </label>

                                <div class="upload-section" id="uploadSection">
                                    <input type="file"
                                           class="upload-input @error('image') is-invalid @enderror"
                                           name="image"
                                           id="imageInput"
                                           accept="image/*"
                                           required>

                                    <div class="upload-content" id="uploadContent">
                                        <div class="upload-icon">
                                            <i class="icon-upload-cloud"></i>
                                        </div>
                                        <div class="upload-text">
                                            Klik atau seret gambar ke sini
                                        </div>
                                        <div class="upload-subtext">
                                            Format: PNG, JPG, JPEG • Maksimal: 2MB • Ukuran: 300x300px atau lebih
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Preview -->
                                <div class="image-preview" id="imagePreview">
                                    <img src="" alt="Preview" class="preview-image" id="previewImg">
                                    <div class="preview-actions">
                                        <button type="button" class="btn-remove-image" id="removeImage">
                                            <i class="icon-trash"></i> Hapus Gambar
                                        </button>
                                    </div>
                                </div>

                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Upload logo atau gambar representatif untuk merek ini
                                </div>
                            </div>
                        </div>

                        <!-- Brand Status -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">
                                    Status Merek
                                </label>
                                <select class="form-control" name="is_active" id="status">
                                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>
                                        Aktif
                                    </option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>
                                        Nonaktif
                                    </option>
                                </select>
                                <div class="form-text">
                                    Merek aktif akan ditampilkan di frontend website
                                </div>
                            </div>
                        </div>

                        <!-- Featured Brand -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">
                                    Merek Unggulan
                                </label>
                                <select class="form-control" name="is_featured" id="featured">
                                    <option value="0" {{ old('is_featured', '0') == '0' ? 'selected' : '' }}>
                                        Tidak
                                    </option>
                                    <option value="1" {{ old('is_featured') == '1' ? 'selected' : '' }}>
                                        Ya
                                    </option>
                                </select>
                                <div class="form-text">
                                    Merek unggulan akan ditampilkan di bagian khusus website
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <div class="action-info">
                            <small class="text-muted">
                                <i class="icon-info"></i>
                                Pastikan semua informasi sudah benar sebelum menyimpan
                            </small>
                        </div>

                        <div class="action-buttons">
                            <a href="{{ route('admin.brands') }}" class="btn-secondary">
                                <i class="icon-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn-primary" id="submitBtn">
                                <i class="icon-check"></i> Simpan Merek
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            const descInput = document.getElementById('description');
            const imageInput = document.getElementById('imageInput');
            const uploadSection = document.getElementById('uploadSection');
            const uploadContent = document.getElementById('uploadContent');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const removeImageBtn = document.getElementById('removeImage');
            const form = document.getElementById('brandForm');
            const submitBtn = document.getElementById('submitBtn');

            // Character counters
            function updateCounter(input, counterId, maxLength) {
                const counter = document.getElementById(counterId);
                const currentLength = input.value.length;
                counter.textContent = currentLength;

                // Update counter color based on length
                counter.parentElement.classList.remove('warning', 'danger');
                if (currentLength > maxLength * 0.8) {
                    counter.parentElement.classList.add('warning');
                }
                if (currentLength > maxLength * 0.95) {
                    counter.parentElement.classList.add('danger');
                }
            }

            // Auto-generate slug from name
            nameInput.addEventListener('input', function() {
                updateCounter(this, 'nameCounter', 100);

                // Generate slug
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '') // Remove special characters
                    .replace(/\s+/g, '-') // Replace spaces with hyphens
                    .replace(/-+/g, '-') // Replace multiple hyphens with single
                    .trim();

                slugInput.value = slug;
                updateCounter(slugInput, 'slugCounter', 100);
            });

            slugInput.addEventListener('input', function() {
                updateCounter(this, 'slugCounter', 100);
            });

            descInput.addEventListener('input', function() {
                updateCounter(this, 'descCounter', 500);
            });

            // Initialize counters
            updateCounter(nameInput, 'nameCounter', 100);
            updateCounter(slugInput, 'slugCounter', 100);
            updateCounter(descInput, 'descCounter', 500);

            // Image upload handling
            function handleImageUpload(file) {
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        title: 'Format File Tidak Valid',
                        text: 'Silakan upload file dengan format PNG, JPG, atau JPEG.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                    return;
                }

                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        title: 'File Terlalu Besar',
                        text: 'Ukuran file maksimal adalah 2MB.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    uploadContent.style.display = 'none';
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }

            // File input change
            imageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    handleImageUpload(file);
                }
            });

            // Drag and drop
            uploadSection.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            uploadSection.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            uploadSection.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const file = files[0];
                    imageInput.files = files;
                    handleImageUpload(file);
                }
            });

            // Remove image
            removeImageBtn.addEventListener('click', function() {
                imageInput.value = '';
                uploadContent.style.display = 'block';
                imagePreview.style.display = 'none';
                previewImg.src = '';
            });

            // Form validation and submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Basic validation
                const name = nameInput.value.trim();
                const slug = slugInput.value.trim();
                const image = imageInput.files[0];

                if (!name) {
                    Swal.fire({
                        title: 'Nama Merek Diperlukan',
                        text: 'Silakan masukkan nama merek.',
                        icon: 'warning',
                        confirmButtonColor: '#ffc107'
                    });
                    nameInput.focus();
                    return;
                }

                if (!slug) {
                    Swal.fire({
                        title: 'Slug Merek Diperlukan',
                        text: 'Slug akan dibuat otomatis dari nama merek.',
                        icon: 'warning',
                        confirmButtonColor: '#ffc107'
                    });
                    return;
                }

                if (!image) {
                    Swal.fire({
                        title: 'Gambar Merek Diperlukan',
                        text: 'Silakan upload logo atau gambar merek.',
                        icon: 'warning',
                        confirmButtonColor: '#ffc107'
                    });
                    return;
                }

                // Show confirmation
                Swal.fire({
                    title: 'Konfirmasi Simpan Merek',
                    text: 'Apakah Anda yakin ingin menyimpan merek baru ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Add loading state
                        submitBtn.classList.add('btn-loading');
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="icon-loader"></i> Menyimpan...';

                        // Submit form
                        this.submit();
                    }
                });
            });

            // Show success/error messages
            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonColor: '#28a745'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            @endif
        });
    </script>
@endsection

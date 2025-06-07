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
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        .form-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-header h4 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: white;
        }

        .form-header p {
            margin: 8px 0 0;
            opacity: 0.9;
            font-size: 14px;
            color: white;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-size: 15px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .required-marker {
            color: #dc3545;
            font-weight: 700;
            margin-left: 3px;
        }

        .form-control {
            border: 2px solid #e9ecef;
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

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .form-control.is-valid {
            border-color: #28a745;
        }

        /* Help Text */
        .form-help {
            font-size: 13px;
            color: #6c757d;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Error Messages */
        .error-message {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 14px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* File Upload Styling */
        .upload-container {
            border: 2px dashed #e9ecef;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            background: #f8f9fa;
            position: relative;
            cursor: pointer;
        }

        .upload-container:hover {
            border-color: #007bff;
            background: #e3f2fd;
        }

        .upload-container.dragover {
            border-color: #007bff;
            background: #e3f2fd;
            transform: scale(1.02);
        }

        .upload-icon {
            font-size: 48px;
            color: #6c757d;
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

        .upload-button {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-button:hover {
            background: #0056b3;
        }

        #myFile {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        /* Image Preview */
        .preview-container {
            margin-top: 20px;
            display: none;
        }

        .preview-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            object-fit: cover;
        }

        .preview-info {
            margin-top: 10px;
            font-size: 13px;
            color: #6c757d;
        }

        .remove-image {
            background: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            margin-top: 8px;
            cursor: pointer;
        }

        /* Action Buttons */
        .action-buttons {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            border: 1px solid #6c757d;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: #545b62;
            border-color: #545b62;
            color: white;
            transform: translateY(-1px);
        }

        /* Tips Section */
        .tips-section {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .tips-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .tips-icon {
            color: #1976d2;
            font-size: 20px;
        }

        .tips-title {
            font-size: 16px;
            font-weight: 700;
            color: #1976d2;
            margin: 0;
        }

        .tips-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .tips-list li {
            padding: 8px 0;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .tips-list li::before {
            content: "💡";
            font-size: 14px;
            margin-top: 2px;
        }

        .tips-text {
            font-size: 14px;
            color: #1976d2;
            line-height: 1.4;
        }

        /* Character Counter */
        .char-counter {
            font-size: 12px;
            color: #6c757d;
            text-align: right;
            margin-top: 5px;
        }

        .char-counter.warning {
            color: #f39c12;
        }

        .char-counter.danger {
            color: #e74c3c;
        }

        /* Slug Preview */
        .slug-preview {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 8px 12px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            color: #495057;
            margin-top: 8px;
        }

        /* Live Validation */
        .validation-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
        }

        .input-group {
            position: relative;
        }

        /* Loading States */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }

        .btn-loading::after {
            content: "";
            position: absolute;
            width: 16px;
            height: 16px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .form-container {
                padding: 20px;
            }

            .action-buttons {
                flex-direction: column;
                text-align: center;
            }

            .action-buttons .btn {
                width: 100%;
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Manajemen Tambah Kategori Produk</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.categories') }}">
                            <div class="text-tiny">Kategori</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Tambah Kategori</div>
                    </li>
                </ul>
            </div>

            <!-- Tips Section -->
            <div class="tips-section">
                <div class="tips-header">
                    <i class="tips-icon icon-bulb"></i>
                    <h5 class="tips-title">Tips Membuat Kategori yang Baik</h5>
                </div>
                <ul class="tips-list">
                    <li>
                        <span class="tips-text">Gunakan nama kategori yang jelas dan mudah dipahami customer</span>
                    </li>
                    <li>
                        <span class="tips-text">Upload gambar dengan resolusi minimal 300x300px untuk kualitas
                            terbaik</span>
                    </li>
                    <li>
                        <span class="tips-text">Slug akan otomatis dibuat dari nama kategori, tapi dapat disesuaikan</span>
                    </li>
                    <li>
                        <span class="tips-text">Pastikan nama kategori unik dan tidak mengandung karakter khusus</span>
                    </li>
                </ul>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <div class="form-header">
                    <h4><i class="icon-plus"></i> Tambah Kategori Produk Baru</h4>
                    <p>Lengkapi form di bawah untuk menambahkan kategori produk baru ke sistem</p>
                </div>

                <form class="form-new-category" action="{{ route('admin.category.store') }}" method="POST"
                    enctype="multipart/form-data" id="categoryForm">
                    @csrf

                    <!-- Category Name -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="icon-tag"></i> Nama Kategori
                            <span class="required-marker">*</span>
                        </label>
                        <div class="input-group">
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Masukkan nama kategori produk" value="{{ old('name') }}" required
                                maxlength="100" autocomplete="off">
                            <div class="validation-icon" id="nameValidation"></div>
                        </div>
                        <div class="form-help">
                            <i class="icon-info"></i>
                            <span>Nama kategori harus unik dan deskriptif (maksimal 100 karakter)</span>
                        </div>
                        <div class="char-counter" id="nameCounter">0/100 karakter</div>
                        @error('name')
                            <div class="error-message">
                                <i class="icon-alert-triangle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Category Slug -->
                    <div class="form-group">
                        <label for="slug" class="form-label">
                            <i class="icon-link"></i> Slug Kategori
                            <span class="required-marker">*</span>
                        </label>
                        <div class="input-group">
                            <input type="text" id="slug" name="slug"
                                class="form-control @error('slug') is-invalid @enderror" placeholder="kategori-slug"
                                value="{{ old('slug') }}" required pattern="^[a-z0-9-]+$" maxlength="100">
                            <div class="validation-icon" id="slugValidation"></div>
                        </div>
                        <div class="form-help">
                            <i class="icon-info"></i>
                            <span>Slug digunakan untuk URL kategori. Hanya boleh huruf kecil, angka, dan tanda (-)</span>
                        </div>
                        <div class="slug-preview" id="slugPreview">
                            URL Preview: <span id="slugUrl">{{ url('/kategori/') }}/your-slug</span>
                        </div>
                        @error('slug')
                            <div class="error-message">
                                <i class="icon-alert-triangle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Category Description (New Feature) -->
                    <div class="form-group">
                        <label for="description" class="form-label">
                            <i class="icon-file-text"></i> Deskripsi Kategori
                            <span style="color: #6c757d; font-weight: normal;">(Opsional)</span>
                        </label>
                        <textarea id="description" name="description" class="form-control" rows="4"
                            placeholder="Deskripsi singkat tentang kategori ini..." maxlength="500">{{ old('description') }}</textarea>
                        <div class="form-help">
                            <i class="icon-info"></i>
                            <span>Deskripsi akan ditampilkan di halaman kategori untuk membantu customer</span>
                        </div>
                        <div class="char-counter" id="descCounter">0/500 karakter</div>
                    </div>

                    <!-- SEO Meta (New Feature) -->
                    <div class="form-group">
                        <label for="meta_title" class="form-label">
                            <i class="icon-search"></i> Meta Title SEO
                            <span style="color: #6c757d; font-weight: normal;">(Opsional)</span>
                        </label>
                        <input type="text" id="meta_title" name="meta_title" class="form-control"
                            placeholder="Title untuk SEO (akan menggunakan nama kategori jika kosong)"
                            value="{{ old('meta_title') }}" maxlength="60">
                        <div class="form-help">
                            <i class="icon-info"></i>
                            <span>Meta title untuk SEO dan hasil pencarian Google (maksimal 60 karakter)</span>
                        </div>
                        <div class="char-counter" id="metaTitleCounter">0/60 karakter</div>
                    </div>

                    <!-- Category Image -->
                    <div class="form-group">
                        <label for="myFile" class="form-label">
                            <i class="icon-image"></i> Gambar Kategori
                            <span class="required-marker">*</span>
                        </label>
                        <div class="upload-container" id="uploadContainer">
                            <input type="file" id="myFile" name="image" accept="image/*" required>
                            <div class="upload-content">
                                <div class="upload-icon">
                                    <i class="icon-upload-cloud"></i>
                                </div>
                                <div class="upload-text">Drag & Drop gambar di sini</div>
                                <div class="upload-subtext">atau</div>
                                <button type="button" class="upload-button">Pilih File</button>
                                <div style="margin-top: 10px; font-size: 12px; color: #6c757d;">
                                    Format: JPG, PNG, WEBP • Maksimal: 2MB • Minimal: 300x300px
                                </div>
                            </div>
                        </div>

                        <div class="preview-container" id="previewContainer">
                            <div style="text-align: center;">
                                <img id="previewImage" class="preview-image" alt="Preview">
                                <div class="preview-info" id="previewInfo"></div>
                                <button type="button" class="remove-image" id="removeImage">
                                    <i class="icon-trash"></i> Hapus Gambar
                                </button>
                            </div>
                        </div>

                        @error('image')
                            <div class="error-message">
                                <i class="icon-alert-triangle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Sort Order (New Feature) -->
                    <div class="form-group">
                        <label for="sort_order" class="form-label">
                            <i class="icon-list"></i> Urutan Tampil
                            <span style="color: #6c757d; font-weight: normal;">(Opsional)</span>
                        </label>
                        <input type="number" id="sort_order" name="sort_order" class="form-control" placeholder="0"
                            value="{{ old('sort_order', 0) }}" min="0" max="999">
                        <div class="form-help">
                            <i class="icon-info"></i>
                            <span>Angka kecil akan ditampilkan lebih dulu. Kosongkan untuk urutan default</span>
                        </div>
                    </div>

                    <!-- Featured Category (New Feature) -->
                    <div class="form-group">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                {{ old('is_featured') ? 'checked' : '' }}>
                            <label for="is_featured" class="form-label" style="margin: 0;">
                                <i class="icon-star"></i> Jadikan Kategori Unggulan
                            </label>
                        </div>
                        <div class="form-help" style="margin-left: 30px;">
                            <i class="icon-info"></i>
                            <span>Kategori unggulan akan ditampilkan di homepage dan mendapat prioritas lebih tinggi</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <div>
                            <a href="{{ route('admin.categories') }}" class="btn-secondary">
                                <i class="icon-arrow-left"></i> Kembali ke Daftar
                            </a>
                        </div>
                        <div style="display: flex; gap: 15px;">
                            <button type="button" class="btn-secondary" id="resetForm">
                                <i class="icon-refresh"></i> Reset Form
                            </button>
                            <button type="submit" class="btn-primary" id="submitBtn">
                                <i class="icon-check"></i> Simpan Kategori
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            const descInput = document.getElementById('description');
            const metaTitleInput = document.getElementById('meta_title');
            const fileInput = document.getElementById('myFile');
            const uploadContainer = document.getElementById('uploadContainer');
            const previewContainer = document.getElementById('previewContainer');
            const previewImage = document.getElementById('previewImage');
            const removeImageBtn = document.getElementById('removeImage');
            const form = document.getElementById('categoryForm');
            const submitBtn = document.getElementById('submitBtn');
            const resetBtn = document.getElementById('resetForm');

            // Character counters
            const nameCounter = document.getElementById('nameCounter');
            const descCounter = document.getElementById('descCounter');
            const metaTitleCounter = document.getElementById('metaTitleCounter');

            // Auto-generate slug from name
            nameInput.addEventListener('input', function() {
                const name = this.value;
                const slug = StringToSlug(name);
                slugInput.value = slug;
                updateSlugPreview(slug);
                updateCharCounter(nameCounter, name.length, 100);
                validateField(this);
            });

            // Slug input validation
            slugInput.addEventListener('input', function() {
                const slug = this.value.toLowerCase().replace(/[^a-z0-9-]/g, '');
                this.value = slug;
                updateSlugPreview(slug);
                validateField(this);
            });

            // Description counter
            if (descInput) {
                descInput.addEventListener('input', function() {
                    updateCharCounter(descCounter, this.value.length, 500);
                });
            }

            // Meta title counter
            if (metaTitleInput) {
                metaTitleInput.addEventListener('input', function() {
                    updateCharCounter(metaTitleCounter, this.value.length, 60);
                });
            }

            // File upload handling
            fileInput.addEventListener('change', handleFileSelect);

            // Drag and drop
            uploadContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            uploadContainer.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            uploadContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    handleFileSelect();
                }
            });

            // Remove image
            removeImageBtn.addEventListener('click', function() {
                fileInput.value = '';
                previewContainer.style.display = 'none';
                uploadContainer.style.display = 'block';
            });

            // Form reset
            resetBtn.addEventListener('click', function() {
                Swal.fire({
                    title: 'Reset Form?',
                    text: 'Semua data yang telah diisi akan dihapus.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Reset',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.reset();
                        previewContainer.style.display = 'none';
                        uploadContainer.style.display = 'block';
                        updateSlugPreview('');
                        updateCharCounter(nameCounter, 0, 100);
                        updateCharCounter(descCounter, 0, 500);
                        updateCharCounter(metaTitleCounter, 0, 60);
                    }
                });
            });

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                if (!validateForm()) {
                    return;
                }

                submitBtn.classList.add('btn-loading');
                submitBtn.innerHTML = '<i class="icon-loading"></i> Menyimpan...';

                Swal.fire({
                    title: 'Menyimpan Kategori...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit form
                setTimeout(() => {
                    this.submit();
                }, 1000);
            });

            // Functions
            function StringToSlug(text) {
                return text.toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }

            function updateSlugPreview(slug) {
                const slugUrl = document.getElementById('slugUrl');
                slugUrl.textContent = `{{ url('/kategori/') }}/${slug || 'your-slug'}`;
            }

            function updateCharCounter(counter, current, max) {
                counter.textContent = `${current}/${max} karakter`;
                counter.classList.remove('warning', 'danger');

                if (current > max * 0.8) {
                    counter.classList.add('warning');
                }
                if (current > max * 0.95) {
                    counter.classList.add('danger');
                }
            }

            function handleFileSelect() {
                const file = fileInput.files[0];
                if (file) {
                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire({
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file maksimal 2MB',
                            icon: 'error'
                        });
                        fileInput.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.style.display = 'block';
                        uploadContainer.style.display = 'none';

                        const fileSize = (file.size / 1024 / 1024).toFixed(2);
                        document.getElementById('previewInfo').innerHTML =
                            `<strong>${file.name}</strong><br>Ukuran: ${fileSize} MB`;
                    };
                    reader.readAsDataURL(file);
                }
            }

            function validateField(field) {
                const icon = document.getElementById(field.id + 'Validation');
                if (field.value.trim() !== '' && field.checkValidity()) {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');
                    if (icon) icon.innerHTML = '<i class="icon-check" style="color: #28a745;"></i>';
                } else {
                    field.classList.remove('is-valid');
                    if (field.value.trim() !== '') {
                        field.classList.add('is-invalid');
                        if (icon) icon.innerHTML = '<i class="icon-close" style="color: #dc3545;"></i>';
                    } else {
                        field.classList.remove('is-invalid');
                        if (icon) icon.innerHTML = '';
                    }
                }
            }

            function validateForm() {
                let isValid = true;
                const requiredFields = [nameInput, slugInput, fileInput];

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        title: 'Form Belum Lengkap',
                        text: 'Mohon lengkapi semua field yang wajib diisi',
                        icon: 'warning'
                    });
                }

                return isValid;
            }

            // Initialize counters
            updateCharCounter(nameCounter, nameInput.value.length, 100);
            updateCharCounter(descCounter, descInput.value.length, 500);
            updateCharCounter(metaTitleCounter, metaTitleInput.value.length, 60);
        });
    </script>
@endpush

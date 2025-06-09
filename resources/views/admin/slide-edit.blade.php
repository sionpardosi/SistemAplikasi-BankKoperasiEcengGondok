@extends('layouts.admin')

@section('content')
    <style>
        /* Base Styling */
        .main-content-inner {
            padding: 1.5rem;
        }

        /* Page Header */
        .page-header {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #495057;
            margin: 0;
        }

        /* Form Section */
        .form-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .form-header {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .form-title {
            font-size: 20px;
            font-weight: 700;
            color: #495057;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-subtitle {
            color: #6c757d;
            font-size: 14px;
            margin: 5px 0 0;
        }

        /* Current Slide Info */
        .current-slide-info {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .current-slide-title {
            font-size: 16px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .current-image {
            width: 120px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            border: 2px solid #dee2e6;
        }

        .slide-details {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .slide-detail-item {
            font-size: 14px;
        }

        .slide-detail-label {
            font-weight: 600;
            color: #495057;
            display: inline-block;
            width: 80px;
        }

        .slide-detail-value {
            color: #6c757d;
        }

        /* Form Elements */
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

        .form-label .required {
            color: #dc3545;
            margin-left: 3px;
        }

        .form-control,
        .form-select {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #ffffff;
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            outline: none;
        }

        .form-description {
            font-size: 13px;
            color: #6c757d;
            margin-top: 5px;
        }

        /* Upload Image Section */
        .upload-section {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            background: #f8f9fa;
            position: relative;
        }

        .upload-section:hover {
            border-color: #007bff;
            background: #f0f7ff;
        }

        .upload-section.drag-over {
            border-color: #007bff;
            background: #e3f2fd;
        }

        .upload-icon {
            font-size: 48px;
            color: #007bff;
            margin-bottom: 15px;
        }

        .upload-text {
            font-size: 16px;
            color: #495057;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .upload-description {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 20px;
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

        .btn-upload {
            background: #007bff;
            border: 1px solid #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-upload:hover {
            background: #0056b3;
            border-color: #0056b3;
        }

        /* Image Preview */
        .image-preview {
            margin-top: 20px;
            text-align: center;
        }

        .preview-image {
            max-width: 300px;
            max-height: 200px;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .preview-info {
            margin-top: 10px;
            font-size: 13px;
            color: #6c757d;
        }

        .current-image-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .current-image-label {
            font-size: 14px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 10px;
            display: block;
        }

        /* Alert Messages */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid;
        }

        .alert-danger {
            background: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        /* Action Buttons */
        .form-actions {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            display: flex;
            gap: 15px;
            justify-content: flex-end;
        }

        .btn-primary {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
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
        }

        .btn-secondary:hover {
            background: #545b62;
            border-color: #545b62;
            color: white;
            transform: translateY(-1px);
        }

        .btn-info {
            background: #17a2b8;
            border: 1px solid #17a2b8;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-info:hover {
            background: #138496;
            border-color: #138496;
            color: white;
            transform: translateY(-1px);
        }

        /* Row Layout */
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-col {
            flex: 1;
        }

        .form-col-2 {
            flex: 2;
        }

        /* Status Badge */
        .status-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            display: inline-block;
        }

        .status-active {
            background: #d1f2eb;
            color: #0c5460;
            border: 1px solid #7dd3fc;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Loading State */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .btn-loading {
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
            left: 0;
            bottom: 0;
            right: 0;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .form-section {
                padding: 20px;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-primary,
            .btn-secondary,
            .btn-info {
                width: 100%;
                text-align: center;
            }

            .upload-section {
                padding: 20px;
            }

            .current-slide-info {
                padding: 15px;
            }

            .current-image {
                width: 100px;
                height: 65px;
            }
        }

        /* Custom Icons */
        .icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            margin-right: 10px;
        }

        /* Validation Styling */
        .is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .valid-feedback {
            display: block;
            font-size: 13px;
            color: #28a745;
            margin-top: 5px;
        }

        .invalid-feedback {
            display: block;
            font-size: 13px;
            color: #dc3545;
            margin-top: 5px;
        }

        /* Image Change Indicator */
        .image-change-indicator {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 15px;
            display: none;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Slide Beranda</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.slides') }}">
                            <div class="text-tiny">Slider Management</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Edit Slide #{{ $slide->id }}</div>
                    </li>
                </ul>
            </div>

            <!-- Current Slide Info -->
            <div class="current-slide-info">
                <div class="current-slide-title">
                    <i class="icon-info"></i> Informasi Slide Saat Ini
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <img src="{{ asset('uploads/slides') }}/{{ $slide->image }}"
                             alt="{{ $slide->title }}"
                             class="current-image">
                    </div>
                    <div class="col-md-9">
                        <div class="slide-details">
                            <div class="slide-detail-item">
                                <span class="slide-detail-label">Tagline:</span>
                                <span class="slide-detail-value">{{ $slide->tagline }}</span>
                            </div>
                            <div class="slide-detail-item">
                                <span class="slide-detail-label">Judul:</span>
                                <span class="slide-detail-value">{{ $slide->title }}</span>
                            </div>
                            <div class="slide-detail-item">
                                <span class="slide-detail-label">Status:</span>
                                @if($slide->status == 1)
                                    <span class="status-badge status-active">Aktif</span>
                                @else
                                    <span class="status-badge status-inactive">Nonaktif</span>
                                @endif
                            </div>
                            <div class="slide-detail-item">
                                <span class="slide-detail-label">Dibuat:</span>
                                <span class="slide-detail-value">{{ $slide->created_at->format('d M Y, H:i') }} WIB</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="form-section">
                <div class="form-header">
                    <h4 class="form-title">
                        <div class="icon-wrapper">
                            <i class="icon-edit-3"></i>
                        </div>
                        Form Edit Slide Beranda
                    </h4>
                    <p class="form-subtitle">Perbarui informasi slide sesuai kebutuhan</p>
                </div>

                <form class="slide-form" action="{{ route('admin.slide.update') }}" method="POST"
                    enctype="multipart/form-data" id="slideForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $slide->id }}">

                    <!-- Row 1: Tagline & Title -->
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">
                                    Tagline Slide <span class="required">*</span>
                                </label>
                                <input type="text"
                                       name="tagline"
                                       class="form-control @error('tagline') is-invalid @enderror"
                                       placeholder="Contoh: PROMO SPESIAL"
                                       value="{{ old('tagline', $slide->tagline) }}"
                                       required>
                                <div class="form-description">Tagline singkat yang menarik perhatian (maks. 50 karakter)</div>
                                @error('tagline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">
                                    Judul Utama <span class="required">*</span>
                                </label>
                                <input type="text"
                                       name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       placeholder="Contoh: Kerajinan Eceng Gondok Berkualitas"
                                       value="{{ old('title', $slide->title) }}"
                                       required>
                                <div class="form-description">Judul utama yang menjelaskan konten slide</div>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Subtitle -->
                    <div class="form-group">
                        <label class="form-label">
                            Subtitle / Deskripsi <span class="required">*</span>
                        </label>
                        <input type="text"
                               name="subtitle"
                               class="form-control @error('subtitle') is-invalid @enderror"
                               placeholder="Deskripsi singkat tentang konten atau penawaran"
                               value="{{ old('subtitle', $slide->subtitle) }}"
                               required>
                        <div class="form-description">Penjelasan lebih detail tentang slide ini</div>
                        @error('subtitle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Row 3: Link & Status -->
                    <div class="form-row">
                        <div class="form-col-2">
                            <div class="form-group">
                                <label class="form-label">
                                    Link Tujuan <span class="required">*</span>
                                </label>
                                <input type="url"
                                       name="link"
                                       class="form-control @error('link') is-invalid @enderror"
                                       placeholder="https://example.com atau /halaman-tujuan"
                                       value="{{ old('link', $slide->link) }}"
                                       required>
                                <div class="form-description">URL yang akan dibuka saat slide diklik</div>
                                @error('link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">
                                    Status Slide <span class="required">*</span>
                                </label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="1" @if (old('status', $slide->status) == '1') selected @endif>
                                        ✅ Aktif (Tampil di website)
                                    </option>
                                    <option value="0" @if (old('status', $slide->status) == '0') selected @endif>
                                        ⏸️ Nonaktif (Tersembunyi)
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Upload Image Section -->
                    <div class="form-group">
                        <label class="form-label">
                            Gambar Slide
                        </label>

                        <!-- Current Image Display -->
                        <div class="current-image-section">
                            <span class="current-image-label">Gambar Saat Ini:</span>
                            <div id="currentImageDisplay">
                                <img src="{{ asset('uploads/slides') }}/{{ $slide->image }}"
                                     alt="{{ $slide->title }}"
                                     class="preview-image"
                                     id="currentImage">
                                <div class="preview-info">
                                    File: {{ $slide->image }}<br>
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                                </div>
                            </div>
                        </div>

                        <!-- Image Change Indicator -->
                        <div class="image-change-indicator" id="imageChangeIndicator">
                            <i class="icon-info"></i> Gambar baru telah dipilih dan akan menggantikan gambar saat ini
                        </div>

                        <div class="upload-section" id="uploadSection">
                            <div class="upload-icon">
                                <i class="icon-upload-cloud"></i>
                            </div>
                            <div class="upload-text">Ganti Gambar Slide</div>
                            <div class="upload-description">
                                Drag & drop file gambar ke sini atau klik untuk memilih<br>
                                Format: JPG, PNG, JPEG | Maksimal: 2MB | Resolusi: 1920x1080px (disarankan)
                            </div>
                            <input type="file"
                                   name="image"
                                   id="imageInput"
                                   class="upload-input @error('image') is-invalid @enderror"
                                   accept="image/png,image/jpg,image/jpeg">
                            <button type="button" class="btn-upload" onclick="document.getElementById('imageInput').click()">
                                <i class="icon-folder"></i> Pilih Gambar Baru
                            </button>
                        </div>

                        <!-- New Image Preview -->
                        <div class="image-preview" id="imagePreview" style="display: none;">
                            <img id="previewImage" class="preview-image" alt="Preview">
                            <div class="preview-info" id="previewInfo"></div>
                        </div>

                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('admin.slides') }}" class="btn-secondary">
                            <i class="icon-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('admin.slides') }}" class="btn-info">
                            <i class="icon-list"></i> Lihat Semua Slide
                        </a>
                        <button type="submit" class="btn-primary" id="submitBtn">
                            <i class="icon-check"></i> Update Slide
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('imageInput');
            const uploadSection = document.getElementById('uploadSection');
            const imagePreview = document.getElementById('imagePreview');
            const previewImage = document.getElementById('previewImage');
            const previewInfo = document.getElementById('previewInfo');
            const currentImageDisplay = document.getElementById('currentImageDisplay');
            const imageChangeIndicator = document.getElementById('imageChangeIndicator');
            const slideForm = document.getElementById('slideForm');
            const submitBtn = document.getElementById('submitBtn');

            // Image upload handling
            imageInput.addEventListener('change', function(e) {
                handleImageUpload(e.target.files[0]);
            });

            // Drag and drop functionality
            uploadSection.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('drag-over');
            });

            uploadSection.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('drag-over');
            });

            uploadSection.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('drag-over');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    handleImageUpload(files[0]);
                }
            });

            function handleImageUpload(file) {
                if (!file) {
                    // Reset to show current image
                    imagePreview.style.display = 'none';
                    currentImageDisplay.style.display = 'block';
                    imageChangeIndicator.style.display = 'none';
                    return;
                }

                // Validate file type
                if (!file.type.match(/^image\/(png|jpg|jpeg)$/)) {
                    Swal.fire({
                        title: 'Format File Tidak Valid',
                        text: 'Silakan pilih file gambar dengan format PNG, JPG, atau JPEG.',
                        icon: 'error',
                        confirmButtonColor: '#e74c3c'
                    });
                    return;
                }

                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        title: 'Ukuran File Terlalu Besar',
                        text: 'Ukuran file maksimal adalah 2MB. Silakan pilih gambar yang lebih kecil.',
                        icon: 'error',
                        confirmButtonColor: '#e74c3c'
                    });
                    return;
                }

                // Create FileReader to preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.style.display = 'block';
                    currentImageDisplay.style.display = 'none';
                    imageChangeIndicator.style.display = 'block';

                    // Show file info
                    const fileSizeKB = (file.size / 1024).toFixed(2);
                    previewInfo.innerHTML = `
                        <strong>File Baru:</strong> ${file.name}<br>
                        <strong>Ukuran:</strong> ${fileSizeKB} KB<br>
                        <strong>Format:</strong> ${file.type.split('/')[1].toUpperCase()}<br>
                        <small class="text-success">✓ Gambar baru siap untuk disimpan</small>
                    `;
                };
                reader.readAsDataURL(file);
            }

            // Form submission
            slideForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Show loading state
                submitBtn.classList.add('btn-loading');
                submitBtn.innerHTML = '<i class="icon-clock"></i> Memperbarui...';
                submitBtn.disabled = true;

                // Show confirmation
                Swal.fire({
                    title: 'Update Slide?',
                    text: 'Pastikan semua perubahan sudah benar sebelum menyimpan.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Update!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form
                        this.submit();
                    } else {
                        // Reset button state
                        submitBtn.classList.remove('btn-loading');
                        submitBtn.innerHTML = '<i class="icon-check"></i> Update Slide';
                        submitBtn.disabled = false;
                    }
                });
            });

            // Real-time validation feedback
            const requiredInputs = document.querySelectorAll('input[required], select[required]');
            requiredInputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });
            });

            // URL validation for link field
            const linkInput = document.querySelector('input[name="link"]');
            linkInput.addEventListener('blur', function() {
                const url = this.value.trim();
                if (url && !url.match(/^(https?:\/\/|\/)/)) {
                    this.setCustomValidity('URL harus dimulai dengan http://, https://, atau /');
                } else {
                    this.setCustomValidity('');
                }
            });

            // Show success message if present
            @if (session('status'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('status') }}',
                    icon: 'success',
                    iconColor: '#28a745',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#28a745'
                });
            @endif
        });
    </script>
@endsection

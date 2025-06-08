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
            margin-bottom: 30px;
            padding-bottom: 20px;
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
            font-size: 14px;
            color: #6c757d;
            margin: 8px 0 0 0;
        }

        /* Form Groups */
        .form-section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f8f9fa;
            display: flex;
            align-items: center;
            gap: 10px;
        }

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

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .form-text {
            font-size: 13px;
            color: #6c757d;
            margin-top: 5px;
        }

        /* File Input Styling */
        .file-input-container {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-display {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 40px 20px;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-input-display:hover {
            border-color: #007bff;
            background: #f0f8ff;
        }

        .file-icon {
            font-size: 48px;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .file-text {
            font-size: 16px;
            color: #495057;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .file-subtext {
            font-size: 13px;
            color: #6c757d;
        }

        .image-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            margin-top: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Salary Input Group */
        .salary-group {
            display: flex;
            gap: 15px;
            align-items: end;
        }

        .salary-amount {
            flex: 2;
        }

        .salary-type {
            flex: 1;
        }

        /* Action Buttons */
        .action-buttons {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 25px;
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            align-items: center;
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
        }

        .btn-secondary:hover {
            background: #545b62;
            border-color: #545b62;
            color: white;
            transform: translateY(-1px);
        }

        .btn-preview {
            background: #17a2b8;
            border: 1px solid #17a2b8;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .btn-preview:hover {
            background: #138496;
            border-color: #138496;
            color: white;
            transform: translateY(-1px);
        }

        /* Preview Section */
        .preview-container {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            display: none;
        }

        .preview-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .preview-title {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin: 0;
        }

        .preview-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .preview-item {
            margin-bottom: 15px;
        }

        .preview-label {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .preview-value {
            font-size: 15px;
            color: #495057;
            font-weight: 500;
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

        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-content {
            text-align: center;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f4f6;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            font-size: 16px;
            color: #495057;
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .form-container {
                padding: 20px;
            }

            .salary-group {
                flex-direction: column;
                gap: 15px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .action-buttons .btn {
                width: 100%;
                text-align: center;
            }

            .preview-content {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }

        /* Validation Styling */
        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }

        .is-valid {
            border-color: #28a745;
        }

        .valid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #28a745;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Tambah Lowongan Kerja</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.jobs') }}">
                            <div class="text-tiny">Lowongan Kerja</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Tambah Lowongan</div>
                    </li>
                </ul>
            </div>

            <!-- Preview Section -->
            <div class="preview-container" id="preview-container">
                <div class="preview-header">
                    <h5 class="preview-title">
                        <i class="icon-eye"></i> Preview Lowongan Kerja
                    </h5>
                </div>
                <div class="preview-content" id="preview-content">
                    <!-- Preview will be populated here -->
                </div>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <div class="form-header">
                    <h4 class="form-title">
                        <i class="icon-plus"></i> Buat Lowongan Kerja Baru
                    </h4>
                    <p class="form-subtitle">Lengkapi informasi lowongan kerja dengan detail yang jelas dan menarik untuk menarik kandidat terbaik</p>
                </div>

                <form id="createJobForm" enctype="multipart/form-data">
                    @csrf

                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="icon-info"></i> Informasi Dasar
                        </h5>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label class="form-label" for="title">Judul Pekerjaan <span class="required">*</span></label>
                                    <input type="text" id="title" class="form-control" placeholder="Contoh: Front-end Developer, Marketing Manager, dll" required>
                                    <div class="char-counter" id="title-counter">0/100 karakter</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="category">Kategori <span class="required">*</span></label>
                                    <select id="category" class="form-select" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Full-time">Full-time</option>
                                        <option value="Part-time">Part-time</option>
                                        <option value="Freelance">Freelance</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="description">Deskripsi Pekerjaan <span class="required">*</span></label>
                            <textarea id="description" class="form-control" rows="5" placeholder="Deskripsikan tugas dan tanggung jawab pekerjaan ini secara detail..." required></textarea>
                            <div class="char-counter" id="description-counter">0/2000 karakter</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="location">Lokasi <span class="required">*</span></label>
                                    <input type="text" id="location" class="form-control" placeholder="Contoh: Jakarta Selatan, Surabaya, Remote, dll" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="duration">Durasi <span class="required">*</span></label>
                                    <input type="text" id="duration" class="form-control" placeholder="Contoh: 6 bulan, 1 tahun, Permanen, dll" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Compensation Section -->
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="icon-credit-card"></i> Kompensasi & Gaji
                        </h5>

                        <div class="salary-group">
                            <div class="salary-amount">
                                <div class="form-group">
                                    <label class="form-label" for="salary">Besaran Gaji <span class="required">*</span></label>
                                    <input type="number" id="salary" class="form-control" placeholder="Masukkan nominal gaji" required min="0">
                                    <div class="form-text">Masukkan angka tanpa tanda titik atau koma</div>
                                </div>
                            </div>
                            <div class="salary-type">
                                <div class="form-group">
                                    <label class="form-label" for="salary_type">Tipe Gaji <span class="required">*</span></label>
                                    <select id="salary_type" class="form-select" required>
                                        <option value="">Pilih Tipe</option>
                                        <option value="Per Jam">Per Jam</option>
                                        <option value="Per Hari">Per Hari</option>
                                        <option value="Per Bulan">Per Bulan</option>
                                        <option value="Proyek">Per Proyek</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="target">Target/KPI</label>
                            <input type="text" id="target" class="form-control" placeholder="Contoh: Mencapai target penjualan 100 unit/bulan">
                            <div class="form-text">Opsional: Target pencapaian atau KPI yang diharapkan</div>
                        </div>
                    </div>

                    <!-- Additional Information Section -->
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="icon-layers"></i> Informasi Tambahan
                        </h5>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="requirements">Persyaratan</label>
                                    <textarea id="requirements" class="form-control" rows="4" placeholder="Contoh: Lulusan S1, pengalaman 2 tahun, menguasai JavaScript, dll"></textarea>
                                    <div class="char-counter" id="requirements-counter">0/1000 karakter</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="benefits">Benefit/Tunjangan</label>
                                    <textarea id="benefits" class="form-control" rows="4" placeholder="Contoh: BPJS, THR, bonus kinerja, training, dll"></textarea>
                                    <div class="char-counter" id="benefits-counter">0/1000 karakter</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="deadline">Deadline Lamaran</label>
                                    <input type="date" id="deadline" class="form-control" min="{{ date('Y-m-d') }}">
                                    <div class="form-text">Batas waktu terakhir penerimaan lamaran</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="status">Status Lowongan <span class="required">*</span></label>
                                    <select id="status" class="form-select" required>
                                        <option value="Dibuka" selected>Dibuka</option>
                                        <option value="Ditutup">Ditutup</option>
                                        <option value="Selesai">Selesai</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image Upload Section -->
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="icon-image"></i> Gambar Lowongan
                        </h5>

                        <div class="form-group">
                            <label class="form-label">Upload Gambar (Opsional)</label>
                            <div class="file-input-container">
                                <input type="file" id="image" class="file-input" accept="image/jpeg,image/png,image/jpg,image/gif">
                                <div class="file-input-display" onclick="document.getElementById('image').click()">
                                    <div class="file-icon">
                                        <i class="icon-image"></i>
                                    </div>
                                    <div class="file-text">Klik untuk upload gambar</div>
                                    <div class="file-subtext">Format: JPEG, PNG, JPG, GIF (maksimal 2MB)</div>
                                </div>
                            </div>
                            <img id="image-preview" class="image-preview" style="display: none;">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="{{ route('admin.jobs') }}" class="btn btn-secondary">
                            <i class="icon-arrow-left"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-preview" onclick="showPreview()">
                            <i class="icon-eye"></i> Preview
                        </button>
                        <button type="button" class="btn btn-primary" onclick="submitJob()">
                            <i class="icon-check"></i> Simpan Lowongan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner"></div>
            <div class="loading-text">Menyimpan lowongan kerja...</div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Character counters
            setupCharacterCounters();

            // Image upload preview
            setupImagePreview();

            // Form validation
            setupFormValidation();

            // Auto preview on input change
            $('.form-control, .form-select').on('input change', function() {
                updateLivePreview();
            });
        });

        function setupCharacterCounters() {
            const counters = [
                { field: 'title', max: 100 },
                { field: 'description', max: 2000 },
                { field: 'requirements', max: 1000 },
                { field: 'benefits', max: 1000 }
            ];

            counters.forEach(counter => {
                $(`#${counter.field}`).on('input', function() {
                    const length = $(this).val().length;
                    const counterEl = $(`#${counter.field}-counter`);

                    counterEl.text(`${length}/${counter.max} karakter`);

                    if (length > counter.max * 0.8) {
                        counterEl.removeClass('warning danger').addClass('warning');
                    }
                    if (length > counter.max * 0.95) {
                        counterEl.removeClass('warning').addClass('danger');
                    }
                    if (length <= counter.max * 0.8) {
                        counterEl.removeClass('warning danger');
                    }
                });
            });
        }

        function setupImagePreview() {
            $('#image').on('change', function() {
                const file = this.files[0];
                if (file) {
                    // Validate file size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire({
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file maksimal 2MB',
                            icon: 'error'
                        });
                        this.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image-preview').attr('src', e.target.result).show();
                        $('.file-input-display').html(`
                            <div class="file-icon" style="color: #28a745;">
                                <i class="icon-check"></i>
                            </div>
                            <div class="file-text" style="color: #28a745;">Gambar berhasil dipilih</div>
                            <div class="file-subtext">${file.name}</div>
                        `);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        function setupFormValidation() {
            const requiredFields = ['title', 'description', 'category', 'salary', 'salary_type', 'duration', 'location', 'status'];

            requiredFields.forEach(field => {
                $(`#${field}`).on('blur', function() {
                    validateField(field);
                });
            });
        }

        function validateField(fieldName) {
            const field = $(`#${fieldName}`);
            const value = field.val().trim();

            field.removeClass('is-invalid is-valid');
            field.next('.invalid-feedback').remove();

            if (!value) {
                field.addClass('is-invalid');
                field.after('<div class="invalid-feedback">Field ini wajib diisi</div>');
                return false;
            }

            // Additional validations
            if (fieldName === 'salary' && (isNaN(value) || parseFloat(value) <= 0)) {
                field.addClass('is-invalid');
                field.after('<div class="invalid-feedback">Gaji harus berupa angka positif</div>');
                return false;
            }

            if (fieldName === 'title' && value.length > 100) {
                field.addClass('is-invalid');
                field.after('<div class="invalid-feedback">Judul maksimal 100 karakter</div>');
                return false;
            }

            field.addClass('is-valid');
            return true;
        }

        function updateLivePreview() {
            const data = getFormData();
            const previewHTML = `
                <div class="preview-item">
                    <div class="preview-label">Judul Pekerjaan</div>
                    <div class="preview-value">${data.title || '-'}</div>
                </div>
                <div class="preview-item">
                    <div class="preview-label">Kategori</div>
                    <div class="preview-value">${data.category || '-'}</div>
                </div>
                <div class="preview-item">
                    <div class="preview-label">Lokasi</div>
                    <div class="preview-value">${data.location || '-'}</div>
                </div>
                <div class="preview-item">
                    <div class="preview-label">Gaji</div>
                    <div class="preview-value">Rp ${data.salary ? parseFloat(data.salary).toLocaleString('id-ID') : '0'} ${data.salary_type || ''}</div>
                </div>
                <div class="preview-item">
                    <div class="preview-label">Durasi</div>
                    <div class="preview-value">${data.duration || '-'}</div>
                </div>
                <div class="preview-item">
                    <div class="preview-label">Status</div>
                    <div class="preview-value">${data.status || '-'}</div>
                </div>
                <div class="preview-item" style="grid-column: 1 / -1;">
                    <div class="preview-label">Deskripsi</div>
                    <div class="preview-value">${data.description || '-'}</div>
                </div>
            `;

            $('#preview-content').html(previewHTML);
        }

        function showPreview() {
            updateLivePreview();
            $('#preview-container').slideDown();
            $('html, body').animate({
                scrollTop: $('#preview-container').offset().top - 20
            }, 500);
        }

        function getFormData() {
            return {
                title: $('#title').val(),
                description: $('#description').val(),
                category: $('#category').val(),
                salary: $('#salary').val(),
                salary_type: $('#salary_type').val(),
                duration: $('#duration').val(),
                target: $('#target').val(),
                location: $('#location').val(),
                requirements: $('#requirements').val(),
                benefits: $('#benefits').val(),
                deadline: $('#deadline').val(),
                status: $('#status').val()
            };
        }

        function validateForm() {
            const requiredFields = ['title', 'description', 'category', 'salary', 'salary_type', 'duration', 'location', 'status'];
            let isValid = true;

            requiredFields.forEach(field => {
                if (!validateField(field)) {
                    isValid = false;
                }
            });

            return isValid;
        }

        function submitJob() {
            if (!validateForm()) {
                Swal.fire({
                    title: 'Form Tidak Valid',
                    text: 'Silakan lengkapi semua field yang wajib diisi',
                    icon: 'error'
                });
                return;
            }

            // Show confirmation
            Swal.fire({
                title: 'Konfirmasi Penyimpanan',
                text: 'Apakah Anda yakin ingin menyimpan lowongan kerja ini?',
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Simpan!',
                confirmButtonColor: '#007bff'
            }).then((result) => {
                if (result.isConfirmed) {
                    processSubmission();
                }
            });
        }

        function processSubmission() {
            $('#loadingOverlay').show();

            // Create FormData object to handle file uploads
            let formData = new FormData();

            // Add all form fields to FormData
            const data = getFormData();
            Object.keys(data).forEach(key => {
                if (data[key]) {
                    formData.append(key, data[key]);
                }
            });

            // Add image file if uploaded
            if ($("#image")[0].files[0]) {
                formData.append('image', $("#image")[0].files[0]);
            }

            $.ajax({
                url: "{{ url('/api/admin/jobs') }}",
                type: "POST",
                data: formData,
                contentType: false, // Required for FormData
                processData: false, // Required for FormData
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#loadingOverlay').hide();
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Lowongan kerja berhasil ditambahkan',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        window.location.href = "{{ route('admin.jobs') }}";
                    });
                },
                error: function(xhr, status, error) {
                    $('#loadingOverlay').hide();
                    let errorMessage = 'Terjadi kesalahan, coba lagi!';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        errorMessage = Object.values(errors).flat().join('<br>');
                    }

                    Swal.fire({
                        title: 'Error!',
                        html: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    </script>
@endsection

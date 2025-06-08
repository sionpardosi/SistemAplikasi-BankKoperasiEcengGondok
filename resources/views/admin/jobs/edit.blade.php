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

        /* Job Info Card */
        .job-info-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .job-info-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 15px;
        }

        .job-info-title {
            font-size: 16px;
            font-weight: 700;
            color: #495057;
            margin: 0;
        }

        .job-id-badge {
            background: #007bff;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .job-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .job-stat {
            text-align: center;
        }

        .job-stat-number {
            font-size: 24px;
            font-weight: 700;
            color: #007bff;
            margin-bottom: 5px;
        }

        .job-stat-label {
            font-size: 12px;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
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

        .current-image {
            position: relative;
            display: inline-block;
            margin-bottom: 15px;
        }

        .current-image img {
            max-width: 200px;
            max-height: 150px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .current-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .current-image:hover .current-image-overlay {
            opacity: 1;
        }

        .image-overlay-text {
            color: white;
            font-size: 14px;
            font-weight: 600;
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

        /* Status Change Alert */
        .status-alert {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            display: none;
        }

        .status-alert.show {
            display: block;
        }

        .status-alert-icon {
            color: #856404;
            margin-right: 8px;
        }

        .status-alert-text {
            color: #856404;
            font-size: 14px;
            margin: 0;
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

        .btn-danger {
            background: #dc3545;
            border: 1px solid #dc3545;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background: #c82333;
            border-color: #c82333;
            color: white;
            transform: translateY(-1px);
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

            .job-stats {
                grid-template-columns: repeat(2, 1fr);
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
                <h3>Edit Lowongan Kerja</h3>
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
                        <div class="text-tiny">Edit Lowongan</div>
                    </li>
                </ul>
            </div>

            <!-- Job Info Card -->
            <div class="job-info-card">
                <div class="job-info-header d-flex justify-content-between align-items-center">
                    <h5 class="job-info-title">
                        <i class="icon-info"></i> Informasi Lowongan
                    </h5>
                    <span class="job-id-badge">ID: <span id="job-id-display">{{ $id }}</span></span>
                </div>
                <div class="job-stats">
                    <div class="job-stat">
                        <div class="job-stat-number" id="applicants-count">0</div>
                        <div class="job-stat-label">Total Pelamar</div>
                    </div>
                    <div class="job-stat">
                        <div class="job-stat-number" id="days-since-created">0</div>
                        <div class="job-stat-label">Hari Sejak Dibuat</div>
                    </div>
                    <div class="job-stat">
                        <div class="job-stat-number" id="current-status">-</div>
                        <div class="job-stat-label">Status Saat Ini</div>
                    </div>
                    <div class="job-stat">
                        <div class="job-stat-number" id="views-count">0</div>
                        <div class="job-stat-label">Total Views</div>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <div class="form-header">
                    <h4 class="form-title">
                        <i class="icon-edit-3"></i> Edit Informasi Lowongan
                    </h4>
                    <p class="form-subtitle">Perbarui informasi lowongan kerja untuk menarik kandidat yang tepat</p>
                </div>

                <!-- Status Change Alert -->
                <div class="status-alert" id="status-alert">
                    <i class="icon-alert-triangle status-alert-icon"></i>
                    <p class="status-alert-text">Perubahan status lowongan akan mempengaruhi visibility lowongan untuk para pencari kerja.</p>
                </div>

                <form id="editJobForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="job_id" value="{{ $id }}">

                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="icon-info"></i> Informasi Dasar
                        </h5>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label class="form-label" for="title">Judul Pekerjaan <span class="required">*</span></label>
                                    <input type="text" id="title" class="form-control" required>
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
                            <textarea id="description" class="form-control" rows="5" required></textarea>
                            <div class="char-counter" id="description-counter">0/2000 karakter</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="location">Lokasi <span class="required">*</span></label>
                                    <input type="text" id="location" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="duration">Durasi <span class="required">*</span></label>
                                    <input type="text" id="duration" class="form-control" required>
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
                                    <input type="number" id="salary" class="form-control" required min="0">
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
                            <input type="text" id="target" class="form-control">
                            <div class="form-text">Target pencapaian atau KPI yang diharapkan</div>
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
                                    <textarea id="requirements" class="form-control" rows="4"></textarea>
                                    <div class="char-counter" id="requirements-counter">0/1000 karakter</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="benefits">Benefit/Tunjangan</label>
                                    <textarea id="benefits" class="form-control" rows="4"></textarea>
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
                                        <option value="Dibuka">Dibuka</option>
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
                            <label class="form-label">Upload Gambar Baru (Opsional)</label>

                            <!-- Current Image Display -->
                            <div id="current-image-container" style="display: none;">
                                <div class="current-image">
                                    <img id="current-image" src="" alt="Current Job Image">
                                    <div class="current-image-overlay">
                                        <div class="image-overlay-text">Gambar Saat Ini</div>
                                    </div>
                                </div>
                                <div class="form-text mb-3">Gambar saat ini - upload gambar baru untuk menggantinya</div>
                            </div>

                            <div class="file-input-container">
                                <input type="file" id="image" class="file-input" accept="image/jpeg,image/png,image/jpg,image/gif">
                                <div class="file-input-display" onclick="document.getElementById('image').click()">
                                    <div class="file-icon">
                                        <i class="icon-image"></i>
                                    </div>
                                    <div class="file-text">Klik untuk upload gambar baru</div>
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
                        <a href="/admin/jobs/{{ $id }}/applications" class="btn btn-preview">
                            <i class="icon-users"></i> Lihat Pelamar
                        </a>
                        <button type="button" class="btn btn-danger" onclick="deleteJob()">
                            <i class="icon-trash-2"></i> Hapus Lowongan
                        </button>
                        <button type="button" class="btn btn-primary" onclick="updateJob()">
                            <i class="icon-check"></i> Simpan Perubahan
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
            <div class="loading-text">Memproses perubahan...</div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            let originalData = {};
            let originalStatus = '';

            // Load job data
            loadJobData();

            // Setup character counters
            setupCharacterCounters();

            // Setup image preview
            setupImagePreview();

            // Setup form validation
            setupFormValidation();

            // Status change alert
            $('#status').on('change', function() {
                if (originalStatus && $(this).val() !== originalStatus) {
                    $('#status-alert').addClass('show');
                } else {
                    $('#status-alert').removeClass('show');
                }
            });
        });

        function loadJobData() {
            let jobId = $("#job_id").val();
            $('#loadingOverlay').show();

            $.ajax({
                url: "{{ url('/api/admin/jobs') }}/" + jobId,
                type: "GET",
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                success: function(response) {
                    let job = response.data;
                    originalData = job;
                    originalStatus = job.status;

                    // Populate form fields
                    $("#title").val(job.title);
                    $("#description").val(job.description);
                    $("#category").val(job.category);
                    $("#salary").val(job.salary);
                    $("#salary_type").val(job.salary_type);
                    $("#duration").val(job.duration);
                    $("#target").val(job.target);
                    $("#location").val(job.location);
                    $("#requirements").val(job.requirements);
                    $("#benefits").val(job.benefits);
                    $("#deadline").val(job.deadline);
                    $("#status").val(job.status);

                    // Show current image if exists
                    if (job.image) {
                        $('#current-image').attr('src', '{{ asset("storage") }}/' + job.image);
                        $('#current-image-container').show();
                    }

                    // Update job stats
                    updateJobStats(job);

                    // Update character counters
                    updateCharacterCounters();

                    $('#loadingOverlay').hide();
                },
                error: function(xhr) {
                    $('#loadingOverlay').hide();
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal memuat data lowongan',
                        icon: 'error'
                    }).then(() => {
                        window.location.href = "{{ route('admin.jobs') }}";
                    });
                }
            });
        }

        function updateJobStats(job) {
            // Update applicants count
            $('#applicants-count').text(job.applications_count || 0);

            // Calculate days since created
            const createdDate = new Date(job.created_at);
            const currentDate = new Date();
            const daysDiff = Math.floor((currentDate - createdDate) / (1000 * 60 * 60 * 24));
            $('#days-since-created').text(daysDiff);

            // Update status
            $('#current-status').text(job.status);

            // Update views (if available)
            $('#views-count').text(job.views_count || 0);
        }

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

        function updateCharacterCounters() {
            ['title', 'description', 'requirements', 'benefits'].forEach(field => {
                $(`#${field}`).trigger('input');
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
                            <div class="file-text" style="color: #28a745;">Gambar baru berhasil dipilih</div>
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

            field.addClass('is-valid');
            return true;
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

        function updateJob() {
            if (!validateForm()) {
                Swal.fire({
                    title: 'Form Tidak Valid',
                    text: 'Silakan lengkapi semua field yang wajib diisi',
                    icon: 'error'
                });
                return;
            }

            // Check if there are changes
            const currentData = getFormData();
            const hasChanges = hasDataChanged(currentData);

            if (!hasChanges && !$("#image")[0].files[0]) {
                Swal.fire({
                    title: 'Tidak Ada Perubahan',
                    text: 'Tidak ada perubahan yang terdeteksi untuk disimpan',
                    icon: 'info'
                });
                return;
            }

            // Show confirmation
            Swal.fire({
                title: 'Konfirmasi Perubahan',
                text: 'Apakah Anda yakin ingin menyimpan perubahan lowongan ini?',
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Simpan!',
                confirmButtonColor: '#007bff'
            }).then((result) => {
                if (result.isConfirmed) {
                    processUpdate();
                }
            });
        }

        function hasDataChanged(currentData) {
            const fieldsToCheck = ['title', 'description', 'category', 'salary', 'salary_type', 'duration', 'target', 'location', 'requirements', 'benefits', 'deadline', 'status'];

            return fieldsToCheck.some(field => {
                const current = currentData[field] || '';
                const original = originalData[field] || '';
                return current.toString() !== original.toString();
            });
        }

        function processUpdate() {
            $('#loadingOverlay').show();

            let jobId = $("#job_id").val();

            // Create FormData if there's an image, otherwise use regular data
            let formData;
            let contentType = 'application/x-www-form-urlencoded';
            let processData = true;

            if ($("#image")[0].files[0]) {
                formData = new FormData();
                const data = getFormData();
                Object.keys(data).forEach(key => {
                    if (data[key] !== null && data[key] !== '') {
                        formData.append(key, data[key]);
                    }
                });
                formData.append('image', $("#image")[0].files[0]);
                contentType = false;
                processData = false;
            } else {
                formData = getFormData();
            }

            $.ajax({
                url: "{{ url('/api/admin/jobs') }}/" + jobId,
                type: "PUT",
                data: formData,
                contentType: contentType,
                processData: processData,
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                success: function(response) {
                    $('#loadingOverlay').hide();
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Lowongan berhasil diperbarui',
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

        function deleteJob() {
            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: 'Apakah Anda yakin ingin menghapus lowongan ini? Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                iconColor: '#f39c12',
                showCancelButton: true,
                reverseButtons: true,
                focusCancel: true,
                cancelButtonText: 'Batal',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                confirmButtonColor: '#e74c3c'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#loadingOverlay').show();

                    let jobId = $("#job_id").val();

                    $.ajax({
                        url: `/api/admin/jobs/${jobId}`,
                        type: 'DELETE',
                        headers: {
                            'Authorization': 'Bearer ' + localStorage.getItem('token')
                        },
                        success: function(response) {
                            $('#loadingOverlay').hide();
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Lowongan berhasil dihapus',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = "{{ route('admin.jobs') }}";
                            });
                        },
                        error: function(err) {
                            $('#loadingOverlay').hide();
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Gagal menghapus lowongan',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
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
    </script>
@endsection

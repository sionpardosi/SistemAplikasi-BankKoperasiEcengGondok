@extends('layouts.app')

@section('content')
    <style>
        /* Modal Header */
        .modal-header {
            background-color: #956a3b;
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            padding: 15px 20px;
        }

        .modal-title {
            font-weight: 600;
            color: white;
        }

        /* Modal Body */
        .modal-body {
            padding: 25px;
        }

        .job-title-modal {
            font-size: 1.25rem;
            color: #000;
        }

        .job-category-modal {
            font-size: 0.9rem;
            color: #956a3b;
            font-weight: 600;
        }

        /* Form Input */
        .form-label {
            font-weight: 500;
            color: #555;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ddd;
        }

        .form-control:focus {
            border-color: #956a3b;
            box-shadow: 0 0 0 0.25rem rgba(149, 106, 59, 0.25);
        }

        /* Required field indicator */
        .form-label i.required::after {
            content: " *";
            color: #dc3545;
        }

        /* Preview styling */
        #imagePreview {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            background-color: #f8f9fa;
        }

        /* Tombol Kirim */
        .apply-btn {
            background-color: #956a3b;
            border-color: #956a3b;
            color: #ffffff;
            border-radius: 30px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .apply-btn:hover {
            background-color: #7d5a32;
            border-color: #7d5a32;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(149, 106, 59, 0.2);
        }

        /* Custom styles for job vacancy page */
        .text-danger {
            color: red !important;
        }

        .page-title {
            font-weight: 700;
            position: relative;
            display: inline-block;
            margin-bottom: 25px;
        }

        .page-title:after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -10px;
            height: 4px;
            width: 70px;
            background-color: #956a3b;
        }

        .job-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 20px rgba(149, 106, 59, 0.15);
        }

        .job-card .card-body {
            padding: 25px;
            position: relative;
        }

        .job-card .card-title {
            color: #000;
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 15px;
            border-left: 4px solid #956a3b;
            padding-left: 12px;
        }

        .job-category {
            display: inline-block;
            color: #956a3b;
            font-weight: 600;
            background-color: rgba(149, 106, 59, 0.1);
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .card-text {
            color: #555;
            margin-bottom: 18px;
            line-height: 1.6;
        }

        .job-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            color: #555;
        }

        .job-info i {
            color: #956a3b;
            margin-right: 8px;
            width: 18px;
            text-align: center;
        }

        .job-status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
            margin: 15px 0;
        }

        .status-open {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .status-closed {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .status-finished {
            background-color: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
        }

        .apply-btn {
            background-color: #956a3b;
            border-color: #956a3b;
            color: #ffffff;
            border-radius: 30px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: fit-content;
        }

        .apply-btn:hover {
            background-color: #7d5a32;
            border-color: #7d5a32;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(149, 106, 59, 0.2);
        }

        /* Modal styles */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background-color: #956a3b;
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            padding: 15px 20px;
        }

        .modal-title {
            font-weight: 600;
            color: white;
        }

        .modal-body {
            padding: 25px;
        }

        .form-label {
            font-weight: 500;
            color: #555;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ddd;
        }

        .form-control:focus {
            border-color: #956a3b;
            box-shadow: 0 0 0 0.25rem rgba(149, 106, 59, 0.25);
        }

        /* Pagination styles */
        .pagination .page-item.active .page-link {
            background-color: #956a3b;
            border-color: #956a3b;
        }

        .pagination .page-link {
            color: #956a3b;
        }

        .pagination .page-link:hover {
            background-color: rgba(149, 106, 59, 0.1);
        }

        /* Loading animation */
        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(149, 106, 59, 0.2);
            border-radius: 50%;
            border-top-color: #956a3b;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* No jobs found message */
        .no-jobs {
            text-align: center;
            padding: 40px 0;
            color: #666;
        }

        /* Job filter */
        .job-filter {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f9f7f5;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .filter-title {
            font-weight: 600;
            color: #956a3b;
            margin-bottom: 15px;
        }

        /* Animation for job cards */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animated-card {
            animation: fadeIn 0.5s ease forwards;
        }

        /* Job Card Image */
        .job-card-image {
            height: 180px;
            overflow: hidden;
            position: relative;
            border-radius: 12px 12px 0 0;
        }

        .job-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .job-card:hover .job-card-image img {
            transform: scale(1.05);
        }

        .job-image-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            color: white;
        }

        /* Tab navigation for the modal */
        .nav-tabs .nav-link {
            color: #555;
            font-weight: 500;
            border: none;
            padding: 10px 15px;
        }

        .nav-tabs .nav-link.active {
            color: #956a3b;
            background: transparent;
            border-bottom: 3px solid #956a3b;
        }

        .tab-content {
            padding: 20px 0;
        }

        .job-detail-banner {
            height: 200px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 15px 15px 0 0;
            position: relative;
            background-color: #f8f9fa;
            /* Fallback background */
        }

        .job-detail-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            color: white;
            border-radius: 0 0 0 0;
        }

        .job-detail-content {
            padding: 25px;
        }

        /* Tambahan CSS untuk gambar modal yang lebih responsif */
        .modal-dialog {
            max-width: 800px;
        }

        @media (max-width: 768px) {
            .job-detail-banner {
                height: 150px;
            }

            .job-detail-overlay {
                padding: 15px;
            }
        }

        /* Progress steps in application form */
        .form-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }

        .form-steps:before {
            content: "";
            position: absolute;
            top: 15px;
            left: 20px;
            right: 20px;
            height: 2px;
            background: #e6e6e6;
            z-index: 0;
        }

        .step {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e6e6e6;
            color: #666;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            position: relative;
            z-index: 1;
        }

        .step.active {
            background: #956a3b;
            color: white;
        }

        .step-label {
            margin-top: 8px;
            font-size: 12px;
            text-align: center;
            color: #666;
        }

        .step.active .step-label {
            color: #956a3b;
            font-weight: 600;
        }

        /* Perbaikan header modal di atas banner */
        .modal-header {
            background: transparent !important;
            border-bottom: none !important;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10;
            backdrop-filter: blur(5px);
            background: rgba(0, 0, 0, 0.3) !important;
        }

        /* Close button lebih terlihat */
        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        .btn-close {
            color: white;
        }

        /* Loading state untuk banner */
        .job-detail-banner.loading {
            background: linear-gradient(45deg, #f0f0f0 25%, transparent 25%),
                linear-gradient(-45deg, #f0f0f0 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #f0f0f0 75%),
                linear-gradient(-45deg, transparent 75%, #f0f0f0 75%);
            background-size: 20px 20px;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
            animation: loading-stripes 1s linear infinite;
        }

        @keyframes loading-stripes {
            0% {
                background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
            }

            100% {
                background-position: 20px 20px, 20px 30px, 30px 10px, 10px 20px;
            }
        }

        /* Overlay title styling */
        .job-detail-overlay h4 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            color: white;
        }

        .job-detail-overlay p {
            font-size: 1rem;
            font-weight: 500;
            opacity: 0.9;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        /* Responsive improvements */
        @media (max-width: 576px) {
            .modal-dialog {
                margin: 0.5rem;
            }

            .job-detail-banner {
                height: 120px;
            }

            .job-detail-overlay {
                padding: 10px 15px;
            }

            .job-detail-overlay h4 {
                font-size: 1.2rem;
            }

            .job-detail-overlay p {
                font-size: 0.9rem;
            }
        }
    </style>

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="contact-us container">
            <div class="mw-930">
                <h2 class="page-title">LOWONGAN PEKERJAAN</h2>
                <p class="text-muted">Temukan peluang karir terbaik yang sesuai dengan bakat dan minat Anda</p>
            </div>
        </section>

        <hr class="mt-2 text-secondary" />
        <div class="mb-4"></div>

        <section class="job-listings container">
            <div class="mw-930">
                <!-- Job Filter -->
                <div class="job-filter">
                    <h5 class="filter-title">Filter Lowongan</h5>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <select class="form-select" id="categoryFilter">
                                <option value="">Semua Kategori</option>
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Freelance">Freelance</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <select class="form-select" id="statusFilter">
                                <option value="">Semua Status</option>
                                <option value="Dibuka">Dibuka</option>
                                <option value="Ditutup">Ditutup</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari lowongan...">
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn apply-btn w-100" id="applyFilter">
                                <i class="fas fa-filter me-2"></i> Terapkan Filter
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Loading spinner -->
                <div class="loading-spinner" id="loadingSpinner" style="display:none;">
                    <div class="spinner"></div>
                </div>

                <!-- No jobs message -->
                <div class="no-jobs d-none" id="noJobs">
                    <img src="{{ asset('assets/img/no-jobs.png') }}" alt="No Jobs" class="mb-3" width="150">
                    <h4>Tidak ada lowongan yang ditemukan</h4>
                    <p>Silakan coba dengan filter pencarian yang berbeda</p>
                </div>

                <div class="row" id="job-list">
                    <!-- Daftar lowongan kerja akan dimuat di sini oleh JS -->
                </div>

                <!-- Pagination -->
                <nav id="pagination" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <!-- Pagination akan di-generate oleh JavaScript -->
                    </ul>
                </nav>
            </div>
        </section>
    </main>

    <!-- Modal untuk Detail Lowongan -->
    <div class="modal fade" id="jobDetailModal" tabindex="-1" aria-labelledby="jobDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobDetailModalLabel">
                        <i class="fas fa-briefcase me-2"></i>Detail Lowongan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Banner gambar -->
                <div class="job-detail-banner" id="jobDetailBanner">
                    <div class="job-detail-overlay">
                        <h4 id="jobDetailTitle">-</h4>
                        <p id="jobDetailCategory" class="mb-0">-</p>
                    </div>
                </div>
                <div class="modal-body job-detail-content">
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="job-info">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <span id="jobDetailSalary">-</span>
                                </div>
                                <div class="job-info">
                                    <i class="fas fa-clock"></i>
                                    <span id="jobDetailDuration">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="job-info">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span id="jobDetailLocation">-</span>
                                </div>
                                <div class="job-info">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span id="jobDetailDeadline">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs" id="jobDetailTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                data-bs-target="#description" type="button" role="tab" aria-controls="description"
                                aria-selected="true">
                                <i class="fas fa-align-left me-2"></i>Deskripsi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="requirements-tab" data-bs-toggle="tab"
                                data-bs-target="#requirements" type="button" role="tab"
                                aria-controls="requirements" aria-selected="false">
                                <i class="fas fa-list-check me-2"></i>Persyaratan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="benefits-tab" data-bs-toggle="tab" data-bs-target="#benefits"
                                type="button" role="tab" aria-controls="benefits" aria-selected="false">
                                <i class="fas fa-gift me-2"></i>Keuntungan
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="jobDetailTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel"
                            aria-labelledby="description-tab">
                            <p id="jobDetailDescription">-</p>
                        </div>
                        <div class="tab-pane fade" id="requirements" role="tabpanel" aria-labelledby="requirements-tab">
                            <div id="jobDetailRequirements">-</div>
                        </div>
                        <div class="tab-pane fade" id="benefits" role="tabpanel" aria-labelledby="benefits-tab">
                            <div id="jobDetailBenefits">-</div>
                        </div>
                    </div>

                    <div class="mt-4 d-grid">
                        <button id="applyNowBtn" class="btn apply-btn" style="width: 100%;">
                            <i class="fas fa-paper-plane me-2"></i>Lamar Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Melamar Pekerjaan -->
    <div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyModalLabel">
                        <i class="fas fa-briefcase me-2"></i>Lamar Pekerjaan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="job-details mb-4">
                        <h6 class="job-title-modal fw-bold" id="jobTitleModal">-</h6>
                        <p class="job-category-modal text-muted" id="jobCategoryModal">-</p>
                    </div>
                    <form id="applyForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="job_id" id="job_id">
                        <!-- Hidden fields untuk kompatibilitas dengan database -->
                        <input type="hidden" name="cover_letter" value="Lamaran melalui formulir aplikasi baru - Data lengkap tersedia di form.">
                        <input type="hidden" name="skills" value="Data keterampilan tersedia di dokumen yang diupload">
                        <input type="hidden" name="expected_salary" value="Sesuai standar perusahaan">

                        <!-- Data Pribadi -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap *
                                </label>
                                <input type="text" class="form-control" name="name" id="name" required>
                                <small class="text-muted">Nama akan otomatis terisi, tetapi dapat diubah</small>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2 text-primary"></i>Email *
                                </label>
                                <input type="email" class="form-control" name="email" id="email" required>
                                <small class="text-muted">Email akan otomatis terisi, tetapi dapat diubah</small>
                            </div>
                        </div>

                        <!-- Kontak -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="phone_number" class="form-label">
                                    <i class="fas fa-phone me-2 text-primary"></i>Nomor Telepon *
                                </label>
                                <input type="text" class="form-control" name="phone_number" id="phone_number" required placeholder="Contoh: 081234567890">
                            </div>
                            <div class="col-md-6">
                                <label for="whatsapp_number" class="form-label">
                                    <i class="fab fa-whatsapp me-2 text-success"></i>Nomor WhatsApp *
                                </label>
                                <input type="text" class="form-control" name="whatsapp_number" id="whatsapp_number" required placeholder="Contoh: 081234567890">
                                <small class="text-muted">Nomor WhatsApp yang dapat dihubungi</small>
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="mb-3">
                            <label for="gender" class="form-label">
                                <i class="fas fa-venus-mars me-2 text-primary"></i>Jenis Kelamin *
                            </label>
                            <select class="form-control" name="gender" id="gender" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <!-- Pendidikan -->
                        <div class="mb-3">
                            <label for="education_level" class="form-label">
                                <i class="fas fa-graduation-cap me-2 text-primary"></i>Pendidikan Terakhir *
                            </label>
                            <select class="form-control" name="education_level" id="education_level" required>
                                <option value="">Pilih Pendidikan Terakhir</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA/SMK">SMA/SMK</option>
                                <option value="D1">D1</option>
                                <option value="D2">D2</option>
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>

                        <!-- Pengalaman Kerja -->
                        <div class="mb-3">
                            <label for="experience" class="form-label">
                                <i class="fas fa-briefcase me-2 text-primary"></i>Pengalaman Kerja
                            </label>
                            <textarea class="form-control" name="experience" id="experience" rows="3" placeholder="Ceritakan pengalaman kerja Anda (opsional)"></textarea>
                            <small class="text-muted">Tuliskan pengalaman kerja yang relevan (opsional)</small>
                        </div>

                        <!-- Upload Keterampilan/Gambar -->
                        <div class="mb-3">
                            <label for="image" class="form-label">
                                <i class="fas fa-image me-2 text-primary"></i>Upload Keterampilan/Gambar (Opsional)
                            </label>
                            <input type="file" class="form-control" name="image" id="image" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                            <small class="text-muted">Upload gambar portofolio, sertifikat, atau dokumen keterampilan. Format: JPG, JPEG, PNG, PDF, DOC, DOCX (maksimal 2MB)</small>
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img id="previewImg" src="#" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                            </div>
                        </div>

                        <!-- CV Upload (Optional) -->
                        <div class="mb-3">
                            <label for="cv" class="form-label">
                                <i class="fas fa-file-pdf me-2 text-danger"></i>Upload CV (Opsional)
                            </label>
                            <input type="file" class="form-control" name="cv" id="cv" accept=".pdf,.doc,.docx">
                            <small class="text-muted">Upload CV Anda dalam format PDF, DOC, atau DOCX (maksimal 2MB)</small>
                        </div>

                        <!-- Additional Info (Optional) -->
                        <div class="mb-3">
                            <label for="additional_info" class="form-label">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Informasi Tambahan (Opsional)
                            </label>
                            <textarea class="form-control" name="additional_info" id="additional_info" rows="3" placeholder="Informasi tambahan yang ingin Anda sampaikan"></textarea>
                            <small class="text-muted">Informasi lain yang menurut Anda penting</small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn apply-btn">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Lamaran
                            </button>
                        </div>
                    </form>
                    <div id="applyMessage" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat Lamaran User --}}
    <div class="container">
        <div class="mw-930 mb-5">
            <h4 class="mb-3">Riwayat Lamaran Saya</h4>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Lowongan</th>
                            <th>Tanggal Lamar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $i => $app)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $app->job->title ?? '-' }}</td>
                                <td>{{ $app->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    @if ($app->status == 'Diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @elseif($app->status == 'Ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada lamaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Tampilkan spinner loading
            document.getElementById("loadingSpinner").classList.remove("d-none");

            // Muat Font Awesome jika belum dimuat
            if (!document.querySelector('link[href*="font-awesome"]')) {
                const fontAwesome = document.createElement('link');
                fontAwesome.rel = 'stylesheet';
                fontAwesome.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css';
                document.head.appendChild(fontAwesome);
            }

            // Panggil fungsi untuk memuat daftar pekerjaan
            loadJobs();

            // Event listener untuk tombol filter
            document.getElementById("applyFilter").addEventListener("click", function() {
                loadJobs(1, true);
            });

            // Event listener untuk pencarian (dengan debounce)
            let searchTimeout;
            document.getElementById("searchInput").addEventListener("input", function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    loadJobs(1, true);
                }, 500);
            });

            // Fungsi untuk memuat daftar pekerjaan
            function loadJobs(page = 1, isFilter = false) {
                // Tampilkan spinner loading
                document.getElementById("loadingSpinner").classList.remove("d-none");
                document.getElementById("job-list").innerHTML = "";
                document.getElementById("pagination").querySelector("ul").innerHTML = "";
                document.getElementById("noJobs").classList.add("d-none");

                // Ambil nilai filter
                const category = document.getElementById("categoryFilter").value;
                const status = document.getElementById("statusFilter").value;
                const search = document.getElementById("searchInput").value;

                // Bangun URL API dengan filter
                let apiUrl = `/api/jobs?page=${page}`;
                if (category) apiUrl += `&category=${category}`;
                if (status) apiUrl += `&status=${status}`;
                if (search) apiUrl += `&search=${search}`;

                // Fetch data dari API
                fetch(apiUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Gagal memuat data lowongan.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Sembunyikan spinner loading
                        document.getElementById("loadingSpinner").classList.add("d-none");

                        const jobList = document.getElementById("job-list");
                        const pagination = document.getElementById("pagination").querySelector("ul");
                        jobList.innerHTML = "";
                        pagination.innerHTML = "";

                        if (data.success) {
                            // Jika tidak ada pekerjaan
                            if (data.data.data.length === 0) {
                                document.getElementById("noJobs").classList.remove("d-none");
                                return;
                            }

                            // Render daftar pekerjaan
                            data.data.data.forEach((job, index) => {
                                let statusClass = "";
                                let statusText = "";

                                switch (job.status) {
                                    case "Dibuka":
                                        statusClass = "status-open";
                                        statusText = "<i class='fas fa-door-open me-1'></i>Dibuka";
                                        break;
                                    case "Ditutup":
                                        statusClass = "status-closed";
                                        statusText = "<i class='fas fa-door-closed me-1'></i>Ditutup";
                                        break;
                                    case "Selesai":
                                        statusClass = "status-finished";
                                        statusText = "<i class='fas fa-check-circle me-1'></i>Selesai";
                                        break;
                                }

                                const formattedSalary = new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 0
                                }).format(job.salary || 0);

                                const imageUrl = job.image ?
                                    `{{ asset('') }}${job.image}` :
                                    `{{ asset('uploads/image_job/default/job.jpg') }}`;

                                const jobCard = document.createElement('div');
                                jobCard.className = `col-lg-4 col-md-6 mb-4 animated-card`;
                                jobCard.style.animationDelay = `${index * 0.1}s`;

                                jobCard.innerHTML = `
                                <div class="card job-card">
                                    <div class="job-card-image">
                                        <img src="${imageUrl}" alt="${job.title || 'Lowongan'}" onerror="this.src='/storage/job_images/default/job.jpg'">
                                    </div>
                                    <div class="card-body">
                                        <span class="job-category">${job.category || 'Kategori tidak tersedia'}</span>
                                        <h5 class="card-title">${job.title || 'Judul tidak tersedia'}</h5>
                                        <div class="job-info">
                                            <i class="fas fa-money-bill-wave"></i>
                                            <span>${formattedSalary} (${job.salary_type || 'Tipe gaji tidak tersedia'})</span>
                                        </div>
                                        <div class="job-info">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>${job.location || 'Lokasi tidak tersedia'}</span>
                                        </div>
                                        <div class="job-info">
                                            <i class="fas fa-clock"></i>
                                            <span>${job.duration || 'Durasi tidak tersedia'}</span>
                                        </div>
                                        <div class="job-status ${statusClass}">
                                            ${statusText}
                                        </div>
                                        <button class="btn apply-btn view-job-details" data-id="${job.id}">
                                            <i class="fas fa-eye me-2"></i>Lihat Detail
                                        </button>
                                    </div>
                                </div>
                            `;

                                jobList.appendChild(jobCard);
                            });

                            // Tambahkan event listener ke tombol detail pekerjaan
                            document.querySelectorAll('.view-job-details').forEach(button => {
                                button.addEventListener('click', function() {
                                    const jobId = this.getAttribute('data-id');
                                    viewJobDetails(jobId);
                                });
                            });
                        } else {
                            document.getElementById("noJobs").classList.remove("d-none");
                            document.getElementById("noJobs").innerHTML = `
                            <img src="{{ asset('assets/img/error.png') }}" alt="Error" class="mb-3" width="150">
                            <h4>Terjadi kesalahan</h4>
                            <p>${data.message || 'Gagal memuat data lowongan'}</p>
                        `;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById("loadingSpinner").classList.add("d-none");
                        document.getElementById("noJobs").classList.remove("d-none");
                        document.getElementById("noJobs").innerHTML = `
                        <img src="{{ asset('assets/img/error.png') }}" alt="Error" class="mb-3" width="150">
                        <h4>Terjadi kesalahan</h4>
                        <p>Gagal memuat data lowongan</p>
                    `;
                    });
            }

            // Fungsi untuk melihat detail pekerjaan
            function viewJobDetails(jobId) {
                // Tampilkan loading di modal
                document.getElementById("jobDetailTitle").textContent = "Memuat...";
                document.getElementById("jobDetailCategory").textContent = "Memuat...";
                document.getElementById("jobDetailDescription").textContent = "Memuat...";

                // Set loading state untuk banner
                const bannerElement = document.getElementById("jobDetailBanner");
                bannerElement.classList.add("loading");
                bannerElement.style.backgroundImage = "none";

                // Tampilkan modal
                const jobDetailModal = new bootstrap.Modal(document.getElementById('jobDetailModal'));
                jobDetailModal.show();

                // Ambil detail pekerjaan dari API
                fetch(`/api/jobs/${jobId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Gagal memuat detail pekerjaan.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Remove loading state
                        bannerElement.classList.remove("loading");

                        if (data.success) {
                            const job = data.data;

                            // Set gambar banner dengan error handling yang lebih baik
                            const imageUrl = job.image ?
                                `/${job.image}` :
                                `/uploads/image_job/default/job.jpg`;

                            // Preload image untuk memastikan gambar tersedia
                            const testImage = new Image();
                            testImage.onload = function() {
                                bannerElement.style.backgroundImage = `url('${imageUrl}')`;
                            };
                            testImage.onerror = function() {
                                // Fallback ke placeholder jika gambar tidak ditemukan
                                const fallbackUrl =
                                    `https://via.placeholder.com/800x200/956a3b/ffffff?text=${encodeURIComponent(job.title || 'Lowongan Kerja')}`;
                                bannerElement.style.backgroundImage = `url('${fallbackUrl}')`;
                            };
                            testImage.src = imageUrl;

                            // Isi detail pekerjaan di modal (kode yang sudah ada sebelumnya)
                            document.getElementById("jobDetailTitle").textContent = job.title || '-';
                            document.getElementById("jobDetailCategory").textContent = job.category || '-';

                            // Format salary dengan currency
                            const formattedSalary = job.salary ?
                                new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 0
                                }).format(job.salary) :
                                '-';

                            document.getElementById("jobDetailSalary").textContent =
                                `${formattedSalary} (${job.salary_type || '-'})`;
                            document.getElementById("jobDetailDuration").textContent = job.duration || '-';
                            document.getElementById("jobDetailLocation").textContent = job.location || '-';

                            // Format deadline
                            const deadline = job.deadline ?
                                new Date(job.deadline).toLocaleDateString('id-ID', {
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric'
                                }) :
                                'Tidak ada batas waktu';
                            document.getElementById("jobDetailDeadline").textContent = deadline;

                            document.getElementById("jobDetailDescription").textContent = job.description ||
                                'Tidak ada deskripsi.';
                            document.getElementById("jobDetailRequirements").textContent = job.requirements ||
                                'Tidak ada persyaratan.';
                            document.getElementById("jobDetailBenefits").textContent = job.benefits ||
                                'Tidak ada keuntungan.';

                            // Tambahkan event listener untuk tombol "Lamar Sekarang"
                            const applyNowBtn = document.getElementById("applyNowBtn");
                            applyNowBtn.onclick = function() {
                                showApplyModal(job);
                            };
                        } else {
                            bannerElement.style.backgroundImage = "none";
                            document.getElementById("jobDetailTitle").textContent = "Error";
                            document.getElementById("jobDetailDescription").textContent =
                                "Gagal memuat detail lowongan.";
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching job details:', error);
                        bannerElement.classList.remove("loading");
                        bannerElement.style.backgroundImage = "none";
                        document.getElementById("jobDetailTitle").textContent = "Error";
                        document.getElementById("jobDetailDescription").textContent =
                            "Gagal memuat detail lowongan.";
                    });
            }

            // Fungsi untuk menampilkan modal "Lamar Pekerjaan"
            function showApplyModal(job) {
                document.getElementById("job_id").value = job.id;
                document.getElementById("jobTitleModal").textContent = job.title || '-';
                document.getElementById("jobCategoryModal").textContent = job.category || '-';

                // Reset form
                const applyForm = document.getElementById("applyForm");
                applyForm.reset();
                document.getElementById("applyMessage").innerHTML = "";
                document.getElementById("imagePreview").style.display = "none";

                // Auto-fill nama dan email dari user yang login
                @auth
                    document.getElementById("name").value = "{{ auth()->user()->name }}";
                    document.getElementById("email").value = "{{ auth()->user()->email }}";
                    // Update hidden skills field jika ada additional info
                    const additionalInfo = document.getElementById("additional_info").value;
                    if (additionalInfo) {
                        document.querySelector('input[name="skills"]').value = "Lihat informasi tambahan: " + additionalInfo;
                    }
                @endauth

                // Tampilkan modal
                const applyModal = new bootstrap.Modal(document.getElementById('applyModal'));
                applyModal.show();
            }

            // Event listener untuk preview gambar
            document.getElementById("image").addEventListener("change", function() {
                const file = this.files[0];
                const preview = document.getElementById("imagePreview");
                const previewImg = document.getElementById("previewImg");

                if (file) {
                    // Validasi ukuran file (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar. Maksimal 2MB');
                        this.value = '';
                        preview.style.display = "none";
                        return;
                    }

                    // Validasi tipe file
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Format file tidak didukung. Gunakan JPG, JPEG, PNG, PDF, DOC, atau DOCX');
                        this.value = '';
                        preview.style.display = "none";
                        return;
                    }

                    // Preview untuk gambar
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                            preview.style.display = "block";
                        };
                        reader.readAsDataURL(file);
                    } else {
                        // Untuk file non-gambar, tampilkan nama file
                        preview.innerHTML = `<div class="alert alert-info"><i class="fas fa-file me-2"></i>File terpilih: ${file.name}</div>`;
                        preview.style.display = "block";
                    }
                } else {
                    preview.style.display = "none";
                }
            });

            // Update hidden skills field when additional_info changes
            document.getElementById("additional_info").addEventListener("input", function() {
                const additionalInfo = this.value;
                const skillsField = document.querySelector('input[name="skills"]');
                if (additionalInfo.trim()) {
                    skillsField.value = "Lihat informasi tambahan: " + additionalInfo;
                } else {
                    skillsField.value = "Data keterampilan tersedia di dokumen yang diupload";
                }
            });

            // Event listener untuk form lamaran
            document.getElementById("applyForm").addEventListener("submit", function(event) {
                event.preventDefault();

                // Validasi basic
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const phone = document.getElementById('phone_number').value.trim();
                const whatsapp = document.getElementById('whatsapp_number').value.trim();
                const gender = document.getElementById('gender').value;
                const education = document.getElementById('education_level').value;

                if (!name || !email || !phone || !whatsapp || !gender || !education) {
                    document.getElementById("applyMessage").innerHTML = `
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> Silakan lengkapi semua field yang wajib diisi (bertanda *)!
                        </div>
                    `;
                    return;
                }

                // Validasi email format
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    document.getElementById("applyMessage").innerHTML = `
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> Format email tidak valid!
                        </div>
                    `;
                    return;
                }

                // Validasi nomor telepon (basic)
                const phoneRegex = /^[\+]?[0-9\-\s\(\)]+$/;
                if (!phoneRegex.test(phone) || !phoneRegex.test(whatsapp)) {
                    document.getElementById("applyMessage").innerHTML = `
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> Format nomor telepon tidak valid!
                        </div>
                    `;
                    return;
                }

                // Tampilkan pesan konfirmasi
                const applyMessage = document.getElementById("applyMessage");
                applyMessage.innerHTML = `
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="fas fa-spinner fa-spin me-2"></i> Mengirim lamaran Anda, mohon tunggu...
                    </div>
                `;

                const jobId = document.getElementById('job_id').value;
                const formData = new FormData(applyForm);

                fetch(`/jobs/${jobId}/apply`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Response:', data); // Debug log
                        if (data.success) {
                            document.getElementById("applyMessage").innerHTML = `
                                <div class="alert alert-success" role="alert">
                                    <i class="fas fa-check-circle me-2"></i> ${data.message}
                                </div>
                            `;
                            setTimeout(() => {
                                const applyModal = bootstrap.Modal.getInstance(document
                                    .getElementById('applyModal'));
                                if (applyModal) {
                                    applyModal.hide();
                                }
                                // Reload halaman untuk update riwayat lamaran
                                location.reload();
                            }, 2000);
                        } else {
                            document.getElementById("applyMessage").innerHTML = `
                                <div class="alert alert-danger" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i> ${data.message}
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById("applyMessage").innerHTML = `
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i> Terjadi kesalahan, silakan coba lagi nanti. <br>
                                <small>Error: ${error.message}</small>
                            </div>
                        `;
                    });
            });
        });
    </script>
@endsection

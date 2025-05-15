@extends('layouts.app')

@section('content')
    <style>
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

        /* Job detail modal */
        .job-detail-banner {
            height: 200px;
            background-size: cover;
            background-position: center;
            border-radius: 15px 15px 0 0;
            position: relative;
        }

        .job-detail-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            color: white;
        }

        .job-detail-content {
            padding: 25px;
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
                <div class="loading-spinner" id="loadingSpinner">
                    <div class="spinner"></div>
                </div>

                <!-- No jobs message -->
                <div class="no-jobs d-none" id="noJobs">
                    <img src="{{ asset('assets/images/pemasok/whatsapp-image-2022-02-13-at-11-20220214120322.jpeg') }}" alt="No Jobs" class="mb-3" width="150">
                    <h4>Tidak ada lowongan yang ditemukan</h4>
                    <p>Silakan coba dengan filter pencarian yang berbeda</p>
                </div>

                <div class="row" id="job-list">
                    <!-- Daftar lowongan kerja akan dimuat di sini -->
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
                <div class="job-detail-banner" id="jobDetailBanner">
                    <div class="job-detail-overlay">
                        <h4 id="jobDetailTitle">-</h4>
                        <p id="jobDetailCategory">-</p>
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
                        <h6 class="job-title-modal" id="jobTitleModal">-</h6>
                        <p class="job-category-modal" id="jobCategoryModal">-</p>
                    </div>

                    <!-- Form steps indicator -->
                    <div class="form-steps mb-4">
                        <div class="step active" id="step1">
                            <div>1</div>
                            <div class="step-label">Informasi Umum</div>
                        </div>
                        <div class="step" id="step2">
                            <div>2</div>
                            <div class="step-label">Pengalaman</div>
                        </div>
                        <div class="step" id="step3">
                            <div>3</div>
                            <div class="step-label">Dokumen</div>
                        </div>
                    </div>

                    <form id="applyForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="job_id" id="job_id">

                        <!-- Step 1: Informasi Umum -->
                        <div id="step1Content">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone_number" class="form-label">
                                        <i class="fas fa-phone me-2 text-primary"></i>Nomor Telepon *
                                    </label>
                                    <input type="text" class="form-control" name="phone_number" id="phone_number"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="education_level" class="form-label">
                                        <i class="fas fa-graduation-cap me-2 text-primary"></i>Pendidikan Terakhir *
                                    </label>
                                    <select class="form-select" name="education_level" id="education_level" required>
                                        <option value="">Pilih Pendidikan</option>
                                        <option value="SMA/SMK">SMA/SMK</option>
                                        <option value="D3">D3</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="expected_salary" class="form-label">
                                    <i class="fas fa-money-bill-wave me-2 text-success"></i>Ekspektasi Gaji
                                </label>
                                <input type="text" class="form-control" name="expected_salary" id="expected_salary"
                                    placeholder="Contoh: Rp 5.000.000 - Rp 7.000.000">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn apply-btn" id="nextToStep2">
                                    Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Pengalaman -->
                        <div id="step2Content" style="display: none;">
                            <div class="mb-3">
                                <label for="experience" class="form-label">
                                    <i class="fas fa-briefcase me-2 text-warning"></i>Pengalaman Kerja
                                </label>
                                <textarea class="form-control" name="experience" id="experience" rows="4"
                                    placeholder="Deskripsikan pengalaman kerja Anda sebelumnya..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="skills" class="form-label">
                                    <i class="fas fa-tools me-2 text-info"></i>Keterampilan *
                                </label>
                                <textarea class="form-control" name="skills" id="skills" rows="3" required
                                    placeholder="Sebutkan keterampilan yang Anda miliki (pisahkan dengan koma)..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="additional_info" class="form-label">
                                    <i class="fas fa-info-circle me-2 text-secondary"></i>Informasi Tambahan
                                </label>
                                <textarea class="form-control" name="additional_info" id="additional_info" rows="3"
                                    placeholder="Informasi tambahan yang ingin Anda sampaikan..."></textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary" id="backToStep1">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali
                                </button>
                                <button type="button" class="btn apply-btn" id="nextToStep3">
                                    Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Dokumen -->
                        <div id="step3Content" style="display: none;">
                            <div class="mb-3">
                                <label for="cv" class="form-label">
                                    <i class="fas fa-file-pdf me-2 text-danger"></i>Upload CV (PDF, DOC, DOCX) *
                                </label>
                                <input type="file" class="form-control" name="cv" id="cv" required>
                                <small class="text-muted">Ukuran maksimum file: 2MB</small>
                            </div>
                            <div class="mb-3">
                                <label for="cover_letter" class="form-label">
                                    <i class="fas fa-envelope me-2 text-primary"></i>Surat Lamaran *
                                </label>
                                <textarea class="form-control" name="cover_letter" id="cover_letter" rows="5" required
                                    placeholder="Tulis surat lamaran singkat yang menjelaskan mengapa Anda tertarik dengan posisi ini..."></textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary" id="backToStep2">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali
                                </button>
                                <button type="submit" class="btn apply-btn">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Lamaran
                                </button>
                            </div>
                        </div>
                    </form>
                    <div id="applyMessage" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Show loading spinner
            document.getElementById("loadingSpinner").classList.remove("d-none");

            // Load Font Awesome for icons if not already loaded
            if (!document.querySelector('link[href*="font-awesome"]')) {
                const fontAwesome = document.createElement('link');
                fontAwesome.rel = 'stylesheet';
                fontAwesome.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css';
                document.head.appendChild(fontAwesome);
            }

            loadJobs();

            // Filter jobs event listener
            document.getElementById("applyFilter").addEventListener("click", function() {
                loadJobs(1, true);
            });

            // Search input event listener (search as you type with debounce)
            let searchTimeout;
            document.getElementById("searchInput").addEventListener("input", function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    loadJobs(1, true);
                }, 500);
            });

            // Multi-step form navigation
            document.getElementById("nextToStep2").addEventListener("click", function() {
                // Basic validation for step 1
                const phoneNumber = document.getElementById("phone_number").value;
                const educationLevel = document.getElementById("education_level").value;

                if (!phoneNumber) {
                    alert("Nomor telepon harus diisi!");
                    return;
                }
                if (!educationLevel) {
                    alert("Pendidikan terakhir harus dipilih!");
                    return;
                }

                document.getElementById("step1Content").style.display = "none";
                document.getElementById("step2Content").style.display = "block";
                document.getElementById("step1").classList.remove("active");
                document.getElementById("step2").classList.add("active");
            });

            document.getElementById("backToStep1").addEventListener("click", function() {
                document.getElementById("step2Content").style.display = "none";
                document.getElementById("step1Content").style.display = "block";
                document.getElementById("step2").classList.remove("active");
                document.getElementById("step1").classList.add("active");
            });

            document.getElementById("nextToStep3").addEventListener("click", function() {
                // Basic validation for step 2
                const skills = document.getElementById("skills").value;

                if (!skills) {
                    alert("Keterampilan harus diisi!");
                    return;
                }

                document.getElementById("step2Content").style.display = "none";
                document.getElementById("step3Content").style.display = "block";
                document.getElementById("step2").classList.remove("active");
                document.getElementById("step3").classList.add("active");
            });

            document.getElementById("backToStep2").addEventListener("click", function() {
                document.getElementById("step3Content").style.display = "none";
                document.getElementById("step2Content").style.display = "block";
                document.getElementById("step3").classList.remove("active");
                document.getElementById("step2").classList.add("active");
            });

            // Add application form submission event listener
            document.getElementById("applyForm").addEventListener("submit", function(e) {
                e.preventDefault();
                const jobId = document.getElementById("job_id").value;
                submitApplication(jobId);
            });

            function submitApplication(jobId) {
                const formData = new FormData(document.getElementById("applyForm"));
                formData.set('job_id', jobId);

                fetch(`/api/jobs/${jobId}/apply`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.message || 'Error submitting application');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Penanganan respons sukses
                    })
                    .catch(error => {
                        // Penanganan error
                    });
            }
        });

        function loadJobs(page = 1, isFilter = false) {
            // Show loading spinner
            document.getElementById("loadingSpinner").classList.remove("d-none");
            document.getElementById("job-list").innerHTML = "";
            document.getElementById("pagination").querySelector("ul").innerHTML = "";
            document.getElementById("noJobs").classList.add("d-none");

            // Get filter values
            const category = document.getElementById("categoryFilter").value;
            const status = document.getElementById("statusFilter").value;
            const search = document.getElementById("searchInput").value;

            // Build API URL with filters
            let apiUrl = `/api/jobs?page=${page}`;
            if (category) apiUrl += `&category=${category}`;
            if (status) apiUrl += `&status=${status}`;
            if (search) apiUrl += `&search=${search}`;

            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Hide loading spinner
                    document.getElementById("loadingSpinner").classList.add("d-none");

                    const jobList = document.getElementById("job-list");
                    const pagination = document.getElementById("pagination").querySelector("ul");
                    jobList.innerHTML = "";
                    pagination.innerHTML = "";

                    if (data.success) {
                        // Check if there are no jobs
                        if (data.data.data.length === 0) {
                            document.getElementById("noJobs").classList.remove("d-none");
                            return;
                        }

                        // Render daftar lowongan kerja
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

                            // Format salary
                            const formattedSalary = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            }).format(job.salary);

                            // Get image URL - default if not provided
                            const imageUrl = job.image ?
                                `/storage/${job.image}` :
                                `/storage/job_images/default/job.jpg`;

                            // Create job card with animation delay
                            const jobCard = document.createElement('div');
                            jobCard.className = `col-lg-4 col-md-6 mb-4 animated-card`;
                            jobCard.style.animationDelay = `${index * 0.1}s`;

                            jobCard.innerHTML = `
                        <div class="card job-card">
                            <div class="job-card-image">
                                <img src="${imageUrl}" alt="${job.title}" onerror="this.src='/storage/job_images/default/job.jpg'">
                            </div>
                            <div class="card-body">
                                <span class="job-category">${job.category}</span>
                                <h5 class="card-title">${job.title}</h5>
                                <div class="job-info">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <span>${formattedSalary} (${job.salary_type})</span>
                                </div>
                                <div class="job-info">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>${job.location}</span>
                                </div>
                                <div class="job-info">
                                    <i class="fas fa-clock"></i>
                                    <span>${job.duration}</span>
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

                        // Create pagination links
                        const totalPages = data.data.last_page;
                        const currentPage = data.data.current_page;

                        // Create previous button
                        if (currentPage > 1) {
                            const prevLi = document.createElement('li');
                            prevLi.className = 'page-item';
                            prevLi.innerHTML =
                                `<a class="page-link" href="javascript:void(0)" onclick="loadJobs(${currentPage - 1})"><i class="fas fa-chevron-left"></i></a>`;
                            pagination.appendChild(prevLi);
                        }

                        // Create page numbers
                        for (let i = 1; i <= totalPages; i++) {
                            const li = document.createElement('li');
                            li.className = i === currentPage ? 'page-item active' : 'page-item';
                            li.innerHTML =
                                `<a class="page-link" href="javascript:void(0)" onclick="loadJobs(${i})">${i}</a>`;
                            pagination.appendChild(li);
                        }

                        // Create next button
                        if (currentPage < totalPages) {
                            const nextLi = document.createElement('li');
                            nextLi.className = 'page-item';
                            nextLi.innerHTML =
                                `<a class="page-link" href="javascript:void(0)" onclick="loadJobs(${currentPage + 1})"><i class="fas fa-chevron-right"></i></a>`;
                            pagination.appendChild(nextLi);
                        }

                        // Add event listeners to all job detail buttons
                        document.querySelectorAll('.view-job-details').forEach(button => {
                            button.addEventListener('click', function() {
                                const jobId = this.getAttribute('data-id');
                                viewJobDetails(jobId);
                            });
                        });
                    } else {
                        // Show error message if API call fails
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

        // Function to view job details - FIXED
        function viewJobDetails(jobId) {
            // Show loading in modal
            document.getElementById("jobDetailTitle").textContent = "Memuat...";
            document.getElementById("jobDetailDescription").textContent = "Memuat...";

            // Show the modal
            const jobDetailModal = new bootstrap.Modal(document.getElementById('jobDetailModal'));
            jobDetailModal.show();

            // Ensure CSRF token is included in the request headers
            const headers = {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            };

            // Fetch job details - Using GET request with proper error handling
            fetch(`/api/jobs/${jobId}`, {
                    method: 'GET',
                    headers: headers
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const job = data.data;

                        // Format salary
                        const formattedSalary = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0
                        }).format(job.salary);

                        // Set job details in modal
                        document.getElementById("jobDetailTitle").textContent = job.title;
                        document.getElementById("jobDetailCategory").textContent = job.category;
                        document.getElementById("jobDetailSalary").textContent =
                            `${formattedSalary} (${job.salary_type})`;
                        document.getElementById("jobDetailDuration").textContent = job.duration;
                        document.getElementById("jobDetailLocation").textContent = job.location;

                        // Format deadline date
                        const deadline = job.deadline ? new Date(job.deadline).toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        }) : 'Tidak ada batas waktu';
                        document.getElementById("jobDetailDeadline").textContent = deadline;

                        // Set the description, requirements, and benefits
                        document.getElementById("jobDetailDescription").innerHTML = job.description ||
                            'Tidak ada deskripsi.';
                        document.getElementById("jobDetailRequirements").innerHTML = job.requirements ||
                            'Tidak ada persyaratan khusus.';
                        document.getElementById("jobDetailBenefits").innerHTML = job.benefits ||
                            'Tidak ada informasi keuntungan.';

                        // Set banner image
                        const bannerEl = document.getElementById("jobDetailBanner");
                        const imageUrl = job.image ?
                            `/storage/${job.image}` :
                            `/storage/job_images/default/job.jpg`;
                        bannerEl.style.backgroundImage = `url("${imageUrl}")`;

                        // Update apply button status based on job status
                        const applyNowBtn = document.getElementById("applyNowBtn");

                        if (job.status === "Dibuka") {
                            applyNowBtn.disabled = false;
                            applyNowBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Lamar Sekarang';

                            // Set event listener for apply button - FIXED
                            applyNowBtn.onclick = function() {
                                // Store the job ID for later use
                                document.getElementById("job_id").value = job.id;

                                // Close the detail modal
                                jobDetailModal.hide();

                                // Show the apply modal with job data
                                showApplyModal(job);
                            };
                        } else {
                            applyNowBtn.disabled = true;
                            applyNowBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Lowongan Sudah Ditutup';
                        }
                    } else {
                        document.getElementById("jobDetailTitle").textContent = "Error";
                        document.getElementById("jobDetailDescription").textContent = "Gagal memuat detail lowongan.";
                        console.error('API returned error:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error fetching job details:', error);
                    document.getElementById("jobDetailTitle").textContent = "Error";
                    document.getElementById("jobDetailDescription").textContent =
                        "Gagal memuat detail lowongan. Silakan coba lagi nanti.";
                });
        }

        // Function to show apply modal - FIXED
        function showApplyModal(job) {
            // Fill job details
            document.getElementById("jobTitleModal").textContent = job.title;
            document.getElementById("jobCategoryModal").textContent = job.category;

            // Ensure job ID is set in the hidden field
            document.getElementById("job_id").value = job.id;

            // Reset form and steps
            document.getElementById("applyForm").reset();
            document.getElementById("step1").classList.add("active");
            document.getElementById("step2").classList.remove("active");
            document.getElementById("step3").classList.remove("active");
            document.getElementById("step1Content").style.display = "block";
            document.getElementById("step2Content").style.display = "none";
            document.getElementById("step3Content").style.display = "none";
            document.getElementById("applyMessage").innerHTML = "";

            // Check if user is logged in
            fetch('/api/user', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                            '',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin' // Important for authentication sessions
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('User not authenticated');
                    }
                    return response.json();
                })
                .then(userData => {
                    // User is authenticated, show apply modal
                    const applyModal = new bootstrap.Modal(document.getElementById('applyModal'));
                    applyModal.show();
                })
                .catch(error => {
                    console.error('Authentication error:', error);
                    // User is not authenticated, redirect to login
                    // Store the current URL or job ID in localStorage for redirection after login
                    localStorage.setItem('redirect_after_login', 'jobs');
                    localStorage.setItem('job_to_apply', job.id);

                    // Redirect to login page
                    window.location.href = '/login?redirect=jobs';
                });
        }

        // Function to submit job application - FIXED
        function submitApplication(jobId) {
            // Create FormData from the form
            const formData = new FormData(document.getElementById("applyForm"));

            // Ensure job_id is included in the form data
            formData.set('job_id', jobId);

            // Show loading message
            document.getElementById("applyMessage").innerHTML = `
        <div class="alert alert-info">
            <i class="fas fa-spinner fa-spin me-2"></i> Mengirim lamaran Anda...
        </div>
    `;

            fetch(`/api/jobs/${jobId}/apply`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    credentials: 'same-origin' // Important for authentication sessions
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Error submitting application');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        document.getElementById("applyMessage").innerHTML = `
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> ${data.message}
                </div>
            `;

                        // Disable submit button
                        document.querySelector('#applyForm button[type="submit"]').disabled = true;

                        // After 3 seconds, close the modal and redirect to applications page
                        setTimeout(function() {
                            const applyModal = bootstrap.Modal.getInstance(document.getElementById(
                                'applyModal'));
                            if (applyModal) {
                                applyModal.hide();
                            }
                            window.location.href = '/applications';
                        }, 3000);
                    } else {
                        let errorMessage = data.message || 'Terjadi kesalahan saat mengirim lamaran.';

                        // If there are validation errors, show them
                        if (data.data && typeof data.data === 'object') {
                            errorMessage += '<ul class="mt-2 mb-0">';
                            Object.values(data.data).forEach(error => {
                                errorMessage += `<li>${error}</li>`;
                            });
                            errorMessage += '</ul>';
                        }

                        document.getElementById("applyMessage").innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> ${errorMessage}
                </div>
            `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById("applyMessage").innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i> ${error.message || 'Terjadi kesalahan saat mengirim lamaran.'}
            </div>
        `;
                });
        }
    </script>
@endsection

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
                        <h6 class="job-title-modal fw-bold" id="jobTitleModal">-</h6>
                        <p class="job-category-modal text-muted" id="jobCategoryModal">-</p>
                    </div>
                    <form id="applyForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="job_id" id="job_id">
                        <div class="mb-3">
                            <label for="cv" class="form-label">
                                <i class="fas fa-file-pdf me-2 text-danger"></i>Upload CV (PDF, DOC, DOCX)
                            </label>
                            <input type="file" class="form-control" name="cv" id="cv" accept=".pdf,.doc,.docx">
                            <small class="text-muted">Opsional, boleh diisi CV. Ukuran maksimum file: 2MB</small>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">
                                <i class="fas fa-image me-2 text-primary"></i>Upload Foto/Gambar (JPG, JPEG, PNG)
                            </label>
                            <input type="file" class="form-control" name="image" id="image" accept=".jpg,.jpeg,.png">
                            <small class="text-muted">Opsional, boleh diisi Gambar. Ukuran maksimum file: 2MB</small>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">
                                <i class="fas fa-phone me-2 text-primary"></i>Nomor Telepon *
                            </label>
                            <input type="text" class="form-control" name="phone_number" id="phone_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="education_level" class="form-label">
                                <i class="fas fa-graduation-cap me-2 text-primary"></i>Tingkat Pendidikan *
                            </label>
                            <select class="form-control" name="education_level" id="education_level" required>
                                <option value="">Pilih Tingkat Pendidikan</option>
                                <option value="SMA/SMK">SMA/SMK</option>
                                <option value="D3">D3</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="experience" class="form-label">
                                <i class="fas fa-briefcase me-2 text-primary"></i>Pengalaman Kerja
                            </label>
                            <textarea class="form-control" name="experience" id="experience" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="expected_salary" class="form-label">
                                <i class="fas fa-money-bill-wave me-2 text-primary"></i>Gaji yang Diharapkan
                            </label>
                            <input type="text" class="form-control" name="expected_salary" id="expected_salary">
                        </div>
                        <div class="mb-3">
                            <label for="skills" class="form-label">
                                <i class="fas fa-tools me-2 text-primary"></i>Keterampilan
                            </label>
                            <textarea class="form-control" name="skills" id="skills" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="cover_letter" class="form-label">
                                <i class="fas fa-envelope me-2 text-primary"></i>Surat Lamaran *
                            </label>
                            <textarea class="form-control" name="cover_letter" id="cover_letter" rows="5" required
                                placeholder="Tulis surat lamaran singkat yang menjelaskan mengapa Anda tertarik dengan posisi ini..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="additional_info" class="form-label">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Informasi Tambahan
                            </label>
                            <textarea class="form-control" name="additional_info" id="additional_info" rows="3"></textarea>
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
                            <td>{{ $i+1 }}</td>
                            <td>{{ $app->job->title ?? '-' }}</td>
                            <td>{{ $app->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                @if($app->status == 'Diterima')
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

    <script>

    document.addEventListener("DOMContentLoaded", function () {
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
        document.getElementById("applyFilter").addEventListener("click", function () {
            loadJobs(1, true);
        });

        // Event listener untuk pencarian (dengan debounce)
        let searchTimeout;
        document.getElementById("searchInput").addEventListener("input", function () {
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

                            const imageUrl = job.image
                                ? `/storage/${job.image}`
                                : `/storage/job_images/default/job.jpg`;

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
                            button.addEventListener('click', function () {
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
            document.getElementById("jobDetailDescription").textContent = "Memuat...";

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
                    if (data.success) {
                        const job = data.data;

                        // Isi detail pekerjaan di modal
                        document.getElementById("jobDetailTitle").textContent = job.title || '-';
                        document.getElementById("jobDetailCategory").textContent = job.category || '-';
                        document.getElementById("jobDetailSalary").textContent = `${job.salary || '-'} (${job.salary_type || '-'})`;
                        document.getElementById("jobDetailDuration").textContent = job.duration || '-';
                        document.getElementById("jobDetailLocation").textContent = job.location || '-';
                        document.getElementById("jobDetailDeadline").textContent = job.deadline || 'Tidak ada batas waktu';
                        document.getElementById("jobDetailDescription").textContent = job.description || 'Tidak ada deskripsi.';
                        document.getElementById("jobDetailRequirements").textContent = job.requirements || 'Tidak ada persyaratan.';
                        document.getElementById("jobDetailBenefits").textContent = job.benefits || 'Tidak ada keuntungan.';

                        // Tambahkan event listener untuk tombol "Lamar Sekarang"
                        const applyNowBtn = document.getElementById("applyNowBtn");
                        applyNowBtn.onclick = function () {
                            showApplyModal(job);
                        };
                    } else {
                        document.getElementById("jobDetailTitle").textContent = "Error";
                        document.getElementById("jobDetailDescription").textContent = "Gagal memuat detail lowongan.";
                    }
                })
                .catch(error => {
                    console.error('Error fetching job details:', error);
                    document.getElementById("jobDetailTitle").textContent = "Error";
                    document.getElementById("jobDetailDescription").textContent = "Gagal memuat detail lowongan.";
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

            // Tampilkan modal
            const applyModal = new bootstrap.Modal(document.getElementById('applyModal'));
            applyModal.show();
        }

        // Event listener untuk form lamaran
        document.getElementById("applyForm").addEventListener("submit", function (event) {
            event.preventDefault();

            // Validasi: minimal salah satu CV atau image harus diisi
            const cv = document.getElementById('cv').files.length;
            const image = document.getElementById('image').files.length;
            if (cv === 0 && image === 0) {
                document.getElementById("applyMessage").innerHTML = `
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> Silakan upload minimal CV atau Gambar!
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
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Gagal mengirim lamaran.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.getElementById("applyMessage").innerHTML = `
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i> ${data.message}
                        </div>
                    `;
                    setTimeout(() => {
                        const applyModal = bootstrap.Modal.getInstance(document.getElementById('applyModal'));
                        if (applyModal) {
                            applyModal.hide();
                        }
                    }, 3000);
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
                        <i class="fas fa-exclamation-triangle me-2"></i> Terjadi kesalahan, silakan coba lagi nanti.
                    </div>
                `;
            });
        });
    });
    </script>
@endsection

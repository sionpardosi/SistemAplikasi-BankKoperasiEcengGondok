@extends('layouts.app')

@section('content')
    <style>
        /* ===== PROFESSIONAL COLOR SCHEME ===== */
        :root {
            --primary-color: #956a3b;
            --primary-light: #956a3b;
            --accent-color: #956a3b;
            --accent-hover: #956a3b;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --text-dark: #2c3e50;
            --text-muted: #7f8c8d;
            --border-color: #ecf0f1;
            --bg-light: #f8f9fa;
            --shadow-soft: 0 2px 10px rgba(44, 62, 80, 0.08);
            --shadow-medium: 0 4px 20px rgba(44, 62, 80, 0.12);
            --border-radius: 12px;
            --border-radius-small: 8px;
        }

        /* ===== TYPOGRAPHY ===== */
        body {
            font-size: 15px;
            line-height: 1.6;
            color: var(--text-dark);
        }

        .page-title {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .page-title::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -8px;
            height: 4px;
            width: 80px;
            background: linear-gradient(90deg, var(--accent-color), var(--primary-color));
            border-radius: 2px;
        }

        .page-subtitle {
            font-size: 1.1rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
        }

        /* ===== ENHANCED FILTER SECTION ===== */
        .filter-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-soft);
            padding: 2rem;
            margin-bottom: 2.5rem;
            border: 1px solid var(--border-color);
        }

        .filter-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .filter-header h5 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
            margin-right: 1rem;
        }

        .filter-header .badge {
            background-color: var(--accent-color);
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
        }

        .form-select, .form-control {
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-small);
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: white;
        }

        .form-select:focus, .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
            outline: none;
        }

        .filter-btn {
            background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius-small);
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-soft);
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
            background: linear-gradient(135deg, var(--accent-hover), #1f5f8b);
        }

        .filter-btn i {
            margin-right: 0.5rem;
        }

        .clear-filter-btn {
            background: transparent;
            border: 2px solid var(--text-muted);
            color: var(--text-muted);
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius-small);
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .clear-filter-btn:hover {
            background-color: var(--text-muted);
            color: white;
            transform: translateY(-1px);
        }

        /* ===== JOB CARDS ===== */
        .job-card {
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-soft);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
        }

        .job-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-medium);
            border-color: var(--accent-color);
        }

        .job-card-image {
            height: 200px;
            overflow: hidden;
            position: relative;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
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

        .job-card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
            padding: 1rem;
            color: white;
        }

        .job-card .card-body {
            padding: 1.5rem;
        }

        .job-category {
            display: inline-block;
            background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .job-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
            line-height: 1.3;
            border-left: 4px solid var(--accent-color);
            padding-left: 1rem;
        }

        .job-info {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .job-info i {
            width: 20px;
            color: var(--accent-color);
            margin-right: 0.75rem;
            font-size: 1rem;
        }

        .job-status {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            margin: 1rem 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-open {
            background-color: rgba(39, 174, 96, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(39, 174, 96, 0.2);
        }

        .status-closed {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--danger-color);
            border: 1px solid rgba(231, 76, 60, 0.2);
        }

        .status-finished {
            background-color: rgba(243, 156, 18, 0.1);
            color: var(--warning-color);
            border: 1px solid rgba(243, 156, 18, 0.2);
        }

        .view-detail-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius-small);
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .view-detail-btn:hover {
            background: linear-gradient(135deg, var(--primary-light), #1e2d3d);
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .view-detail-btn i {
            margin-right: 0.5rem;
        }

        /* ===== ENHANCED MODALS ===== */
        .modal-content {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: none;
        }

        .modal-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: white;
            display: flex;
            align-items: center;
        }

        .modal-title i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-body-content {
            max-height: 70vh;
            overflow-y: auto;
        }

        /* Job Detail Banner */
        .job-detail-banner {
            height: 250px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            background-color: var(--bg-light);
        }

        .job-detail-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            color: white;
            padding: 2rem;
        }

        .job-detail-overlay h4 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .job-detail-overlay p {
            font-size: 1.1rem;
            opacity: 0.9;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }

        /* Enhanced Form Styling */
        .form-section {
            background: var(--bg-light);
            border-radius: var(--border-radius-small);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .form-section-title i {
            margin-right: 0.75rem;
            color: var(--accent-color);
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }

        .form-label i {
            margin-right: 0.5rem;
            color: var(--accent-color);
            width: 16px;
        }

        .form-label .required {
            color: var(--danger-color);
            margin-left: 0.25rem;
        }

        .form-control, .form-select {
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-small);
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
        }

        .form-text {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        /* Enhanced File Upload */
        .file-upload-area {
            border: 2px dashed var(--border-color);
            border-radius: var(--border-radius-small);
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            background: var(--bg-light);
        }

        .file-upload-area:hover {
            border-color: var(--accent-color);
            background: rgba(52, 152, 219, 0.05);
        }

        .file-upload-area.dragover {
            border-color: var(--accent-color);
            background: rgba(52, 152, 219, 0.1);
        }

        .file-preview {
            margin-top: 1rem;
            padding: 1rem;
            background: white;
            border-radius: var(--border-radius-small);
            border: 1px solid var(--border-color);
        }

        /* Enhanced Buttons */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: var(--border-radius-small);
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-soft);
        }

        .btn-primary-custom:hover {
            background: linear-gradient(135deg, var(--accent-hover), #1f5f8b);
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        /* Enhanced Tabs */
        .nav-tabs {
            border-bottom: 2px solid var(--border-color);
            margin-bottom: 1.5rem;
        }

        .nav-tabs .nav-link {
            border: none;
            color: var(--text-muted);
            font-weight: 600;
            padding: 1rem 1.5rem;
            border-radius: 0;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            color: var(--accent-color);
            background: rgba(52, 152, 219, 0.05);
        }

        .nav-tabs .nav-link.active {
            color: var(--accent-color);
            background: white;
            border-bottom: 3px solid var(--accent-color);
        }

        /* ===== ENHANCED HISTORY TABLE ===== */
        .history-section {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-soft);
            padding: 2rem;
            margin-top: 3rem;
            border: 1px solid var(--border-color);
        }

        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border-color);
        }

        .history-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
            display: flex;
            align-items: center;
        }

        .history-title i {
            margin-right: 0.75rem;
            color: var(--accent-color);
        }

        .table-responsive {
            border-radius: var(--border-radius-small);
            overflow: hidden;
            box-shadow: var(--shadow-soft);
        }

        .table {
            margin-bottom: 0;
            font-size: 0.95rem;
        }

        .table thead {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
        }

        .table thead th {
            border: none;
            padding: 1rem 1.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
        }

        .table tbody td {
            padding: 1rem 1.5rem;
            border-color: var(--border-color);
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge i {
            margin-right: 0.5rem;
            font-size: 0.85rem;
        }

        .status-badge.bg-success {
            background-color: rgba(39, 174, 96, 0.15) !important;
            color: var(--success-color) !important;
            border: 1px solid rgba(39, 174, 96, 0.3);
        }

        .status-badge.bg-danger {
            background-color: rgba(231, 76, 60, 0.15) !important;
            color: var(--danger-color) !important;
            border: 1px solid rgba(231, 76, 60, 0.3);
        }

        .status-badge.bg-warning {
            background-color: rgba(243, 156, 18, 0.15) !important;
            color: var(--warning-color) !important;
            border: 1px solid rgba(243, 156, 18, 0.3);
        }

        /* ===== LOADING & ANIMATIONS ===== */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 3rem 0;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(52, 152, 219, 0.2);
            border-radius: 50%;
            border-top-color: var(--accent-color);
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-muted);
        }

        .empty-state img {
            max-width: 200px;
            margin-bottom: 2rem;
            opacity: 0.7;
        }

        .empty-state h4 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .empty-state p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        /* ===== NOTIFICATIONS ===== */
        .alert {
            border: none;
            border-radius: var(--border-radius-small);
            padding: 1rem 1.5rem;
            font-size: 0.95rem;
            border-left: 4px solid;
        }

        .alert-success {
            background-color: rgba(39, 174, 96, 0.1);
            color: var(--success-color);
            border-left-color: var(--success-color);
        }

        .alert-danger {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--danger-color);
            border-left-color: var(--danger-color);
        }

        .alert-info {
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--accent-color);
            border-left-color: var(--accent-color);
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 768px) {
            .page-title {
                font-size: 1.8rem;
            }

            .filter-container {
                padding: 1.5rem;
            }

            .job-card .card-body {
                padding: 1.25rem;
            }

            .modal-body {
                padding: 1.5rem;
            }

            .job-detail-banner {
                height: 180px;
            }

            .history-section {
                padding: 1.5rem;
            }

            .table thead th,
            .table tbody td {
                padding: 0.75rem 1rem;
            }
        }

        @media (max-width: 576px) {
            .filter-container {
                padding: 1rem;
            }

            .btn-primary-custom,
            .filter-btn,
            .view-detail-btn {
                padding: 0.7rem 1.25rem;
                font-size: 0.9rem;
            }

            .modal-dialog {
                margin: 0.5rem;
            }

            .job-detail-banner {
                height: 150px;
            }

            .job-detail-overlay {
                padding: 1rem;
            }

            .job-detail-overlay h4 {
                font-size: 1.3rem;
            }
        }

        /* ===== ACCESSIBILITY ===== */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* Focus indicators */
        .btn:focus,
        .form-control:focus,
        .form-select:focus {
            outline: 2px solid var(--accent-color);
            outline-offset: 2px;
        }

        /* ===== ENHANCED PAGINATION ===== */
        .pagination {
            justify-content: center;
            margin-top: 2rem;
        }

        .pagination .page-item .page-link {
            border: 2px solid var(--border-color);
            color: var(--primary-color);
            padding: 0.75rem 1rem;
            margin: 0 0.25rem;
            border-radius: var(--border-radius-small);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
            border-color: var(--accent-color);
            color: white;
            box-shadow: var(--shadow-soft);
        }

        .pagination .page-item .page-link:hover {
            background-color: rgba(52, 152, 219, 0.1);
            border-color: var(--accent-color);
            color: var(--accent-hover);
            transform: translateY(-1px);
        }
    </style>

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="contact-us container">
            <div class="mw-930">
                <h1 class="page-title">Pusat Karir</h1>
                <p class="page-subtitle">Temukan peluang karir terbaik yang sesuai dengan bakat dan minat Anda. Bergabunglah dengan perusahaan-perusahaan terpercaya dan kembangkan karir impian Anda.</p>
            </div>
        </section>

        <hr class="mt-2 text-secondary" />
        <div class="mb-4"></div>

        <section class="job-listings container">
            <div class="mw-930">
                <!-- Enhanced Filter Section -->
                <div class="filter-container">
                    <div class="filter-header">
                        <h5><i class="fas fa-filter me-2"></i>Filter Pencarian</h5>
                        <span class="badge" id="filterCount">Semua</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <label for="categoryFilter" class="form-label">
                                <i class="fas fa-briefcase"></i> Kategori Pekerjaan
                            </label>
                            <select class="form-select" id="categoryFilter">
                                <option value="">Semua Kategori</option>
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Freelance">Freelance</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label for="statusFilter" class="form-label">
                                <i class="fas fa-toggle-on"></i> Status Lowongan
                            </label>
                            <select class="form-select" id="statusFilter">
                                <option value="">Semua Status</option>
                                <option value="Dibuka">Dibuka</option>
                                <option value="Ditutup">Ditutup</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-8">
                            <label for="searchInput" class="form-label">
                                <i class="fas fa-search"></i> Kata Kunci
                            </label>
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari berdasarkan posisi, lokasi, atau deskripsi...">
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2">
                                <button class="btn filter-btn" id="applyFilter">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <button class="btn clear-filter-btn" id="clearFilter">
                                    <i class="fas fa-times"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading spinner -->
                <div class="loading-spinner d-none" id="loadingSpinner">
                    <div class="spinner"></div>
                </div>

                <!-- Empty state -->
                <div class="empty-state d-none" id="emptyState">
                    {{-- <img src="{{ asset('assets/img/no-jobs.png') }}" alt="Tidak ada lowongan" class="mb-3"> --}}
                    <h4>Tidak ada lowongan yang ditemukan</h4>
                    <p>Silakan coba dengan kriteria pencarian yang berbeda atau periksa kembali nanti untuk lowongan terbaru.</p>
                    <button class="btn btn-primary-custom" onclick="clearAllFilters()">
                        <i class="fas fa-refresh me-2"></i>Tampilkan Semua Lowongan
                    </button>
                </div>

                <!-- Job listings -->
                <div class="row g-4" id="jobList">
                    <!-- Job cards will be loaded here by JavaScript -->
                </div>

                <!-- Enhanced Pagination -->
                <nav id="paginationContainer" class="mt-4">
                    <ul class="pagination" id="pagination">
                        <!-- Pagination will be generated by JavaScript -->
                    </ul>
                </nav>
            </div>
        </section>

        <!-- Enhanced History Section -->
        <div class="container">
            <div class="mw-930">
                <div class="history-section">
                    <div class="history-header">
                        <h4 class="history-title">
                            <i class="fas fa-history"></i>Riwayat Lamaran Saya
                        </h4>
                        <span class="badge bg-primary">{{ count($applications ?? []) }} Lamaran</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="8%"><i class="fas fa-hashtag me-1"></i>No</th>
                                    <th width="40%"><i class="fas fa-briefcase me-1"></i>Posisi</th>
                                    <th width="20%"><i class="fas fa-calendar me-1"></i>Tanggal Lamar</th>
                                    <th width="20%"><i class="fas fa-info-circle me-1"></i>Status</th>
                                    <th width="12%"><i class="fas fa-cog me-1"></i>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications ?? [] as $index => $application)
                                    <tr class="fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                                        <td>
                                            <span class="fw-bold text-primary">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-bold text-primary">{{ $application->job->title ?? 'Posisi tidak tersedia' }}</div>
                                                <small class="text-muted">
                                                    <i class="fas fa-tag me-1"></i>{{ $application->job->category ?? '-' }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-semibold">{{ $application->created_at->format('d M Y') }}</div>
                                                <small class="text-muted">{{ $application->created_at->format('H:i') }} WIB</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($application->status == 'Diterima')
                                                <span class="status-badge bg-success">
                                                    <i class="fas fa-check-circle"></i>Diterima
                                                </span>
                                            @elseif($application->status == 'Ditolak')
                                                <span class="status-badge bg-danger">
                                                    <i class="fas fa-times-circle"></i>Ditolak
                                                </span>
                                            @else
                                                <span class="status-badge bg-warning">
                                                    <i class="fas fa-clock"></i>Diproses
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"
                                                    onclick="viewApplicationDetail({{ $application->id }})"
                                                    title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">Belum ada lamaran</h5>
                                                <p class="text-muted mb-0">Mulai eksplorasi karir Anda dengan melamar posisi yang menarik!</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Enhanced Job Detail Modal -->
    <div class="modal fade" id="jobDetailModal" tabindex="-1" aria-labelledby="jobDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobDetailModalLabel">
                        <i class="fas fa-briefcase"></i>Detail Lowongan Pekerjaan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Job Banner -->
                <div class="job-detail-banner" id="jobDetailBanner">
                    <div class="job-detail-overlay">
                        <h4 id="jobDetailTitle">-</h4>
                        <p id="jobDetailCategory" class="mb-0">-</p>
                    </div>
                </div>

                <div class="modal-body modal-body-content">
                    <!-- Job Summary -->
                    <div class="row mb-4">
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
                                <span>Batas: <span id="jobDetailDeadline">-</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Tabbed Content -->
                    <ul class="nav nav-tabs" id="jobDetailTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                data-bs-target="#description" type="button" role="tab">
                                <i class="fas fa-align-left"></i> Deskripsi Pekerjaan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="requirements-tab" data-bs-toggle="tab"
                                data-bs-target="#requirements" type="button" role="tab">
                                <i class="fas fa-list-check"></i> Persyaratan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="benefits-tab" data-bs-toggle="tab"
                                data-bs-target="#benefits" type="button" role="tab">
                                <i class="fas fa-gift"></i> Benefit & Fasilitas
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="jobDetailTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div id="jobDetailDescription" class="mt-3">-</div>
                        </div>
                        <div class="tab-pane fade" id="requirements" role="tabpanel">
                            <div id="jobDetailRequirements" class="mt-3">-</div>
                        </div>
                        <div class="tab-pane fade" id="benefits" role="tabpanel">
                            <div id="jobDetailBenefits" class="mt-3">-</div>
                        </div>
                    </div>

                    <div class="mt-4 d-grid">
                        <button id="applyNowBtn" class="btn btn-primary-custom btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Lamar Posisi Ini
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Application Modal -->
    <div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyModalLabel">
                        <i class="fas fa-paper-plane"></i>Formulir Lamaran Pekerjaan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modal-body-content">
                    <!-- Job Info Header -->
                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="fas fa-info-circle"></i>Informasi Posisi
                        </h6>
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="job-title mb-1" id="jobTitleModal">-</h5>
                                <p class="text-muted mb-0" id="jobCategoryModal">-</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-primary px-3 py-2">Formulir Resmi</span>
                            </div>
                        </div>
                    </div>

                    <form id="applyForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="job_id" id="job_id">
                        <input type="hidden" name="cover_letter" value="Lamaran melalui formulir aplikasi - Data lengkap tersedia di form.">
                        <input type="hidden" name="skills" value="Data keterampilan tersedia di dokumen yang diupload">
                        <input type="hidden" name="expected_salary" value="Sesuai standar perusahaan">

                        <!-- Personal Information -->
                        <div class="form-section">
                            {{-- <h6 class="form-section-title">
                                <i class="fas fa-user"></i>Data Pribadi
                            </h6> --}}
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user"></i>Nama Lengkap<span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="name" id="name" required
                                           placeholder="Masukkan nama lengkap Anda">
                                    <div class="form-text">Nama sesuai identitas resmi</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope"></i>Alamat Email<span class="required">*</span>
                                    </label>
                                    <input type="email" class="form-control" name="email" id="email" required
                                           placeholder="nama@email.com">
                                    <div class="form-text">Email aktif untuk komunikasi</div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="form-section">
                            {{-- <h6 class="form-section-title">
                                <i class="fas fa-phone"></i>Informasi Kontak
                            </h6> --}}
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="phone_number" class="form-label">
                                        <i class="fas fa-phone"></i>Nomor Telepon<span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="phone_number" id="phone_number" required
                                           placeholder="08123456789">
                                    <div class="form-text">Nomor yang dapat dihubungi</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="whatsapp_number" class="form-label">
                                        <i class="fab fa-whatsapp"></i>Nomor WhatsApp<span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="whatsapp_number" id="whatsapp_number" required
                                           placeholder="08123456789">
                                    <div class="form-text">Untuk komunikasi cepat via WhatsApp</div>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Details -->
                        <div class="form-section">
                            {{-- <h6 class="form-section-title">
                                <i class="fas fa-id-card"></i>Detail Pribadi
                            </h6> --}}
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="gender" class="form-label">
                                        <i class="fas fa-venus-mars"></i>Jenis Kelamin<span class="required">*</span>
                                    </label>
                                    <select class="form-select" name="gender" id="gender" required>
                                        <option value="">Pilih jenis kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="education_level" class="form-label">
                                        <i class="fas fa-graduation-cap"></i>Pendidikan Terakhir<span class="required">*</span>
                                    </label>
                                    <select class="form-select" name="education_level" id="education_level" required>
                                        <option value="">Pilih tingkat pendidikan</option>
                                        <option value="SD">SD/Sederajat</option>
                                        <option value="SMP">SMP/Sederajat</option>
                                        <option value="SMA/SMK">SMA/SMK/Sederajat</option>
                                        <option value="D1">Diploma 1 (D1)</option>
                                        <option value="D2">Diploma 2 (D2)</option>
                                        <option value="D3">Diploma 3 (D3)</option>
                                        <option value="D4">Diploma 4 (D4)</option>
                                        <option value="S1">Sarjana (S1)</option>
                                        <option value="S2">Magister (S2)</option>
                                        <option value="S3">Doktor (S3)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Experience -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="fas fa-briefcase"></i>Pengalaman Kerja
                            </h6>
                            <label for="experience" class="form-label">
                                <i class="fas fa-history"></i>Pengalaman Kerja (Opsional)
                            </label>
                            <textarea class="form-control" name="experience" id="experience" rows="4"
                                      placeholder="Ceritakan pengalaman kerja yang relevan dengan posisi ini..."></textarea>
                            <div class="form-text">Uraikan pengalaman kerja, magang, atau proyek yang pernah dikerjakan</div>
                        </div>

                        <!-- File Uploads -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="fas fa-folder-open"></i>Dokumen Pendukung
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="cv" class="form-label">
                                        <i class="fas fa-file-pdf"></i>Upload CV (Opsional)
                                    </label>
                                    <input type="file" class="form-control" name="cv" id="cv" accept=".pdf,.doc,.docx">
                                    <div class="form-text">Format: PDF, DOC, DOCX (Maks. 2MB)</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="image" class="form-label">
                                        <i class="fas fa-image"></i>Portofolio/Sertifikat (Opsional)
                                    </label>
                                    <input type="file" class="form-control" name="image" id="image"
                                           accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    <div class="form-text">Upload portofolio, sertifikat, atau dokumen keterampilan</div>
                                </div>
                            </div>
                            <div id="filePreview" class="file-preview mt-3" style="display: none;"></div>
                        </div>

                        <!-- Additional Information -->
                        <div class="form-section">
                            {{-- <h6 class="form-section-title">
                                <i class="fas fa-comment"></i>Informasi Tambahan
                            </h6> --}}
                            <label for="additional_info" class="form-label">
                                <i class="fas fa-info"></i>Catatan Khusus (Opsional)
                            </label>
                            <textarea class="form-control" name="additional_info" id="additional_info" rows="3"
                                      placeholder="Sampaikan informasi tambahan yang ingin Anda berikan..."></textarea>
                            <div class="form-text">Motivasi, ekspektasi gaji, atau informasi lain yang relevan</div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary-custom btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Lamaran Sekarang
                            </button>
                        </div>
                    </form>

                    <div id="applyMessage" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let currentPage = 1;
        let isLoading = false;
        let totalPages = 1;

        document.addEventListener("DOMContentLoaded", function() {
            // Initialize
            initializeJobPage();
            loadJobs();
            setupEventListeners();
            setupFormValidation();
        });

        function initializeJobPage() {
            // Load Font Awesome if not already loaded
            if (!document.querySelector('link[href*="font-awesome"]')) {
                const fontAwesome = document.createElement('link');
                fontAwesome.rel = 'stylesheet';
                fontAwesome.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
                document.head.appendChild(fontAwesome);
            }

            // Auto-fill user data if logged in
            @auth
                document.getElementById("name").value = "{{ auth()->user()->name }}";
                document.getElementById("email").value = "{{ auth()->user()->email }}";
            @endauth
        }

        function setupEventListeners() {
            // Filter and search events
            document.getElementById("applyFilter").addEventListener("click", () => loadJobs(1, true));
            document.getElementById("clearFilter").addEventListener("click", clearAllFilters);

            // Real-time search with debounce
            let searchTimeout;
            document.getElementById("searchInput").addEventListener("input", function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => loadJobs(1, true), 500);
            });

            // Filter change events
            ['categoryFilter', 'statusFilter'].forEach(id => {
                document.getElementById(id).addEventListener("change", () => loadJobs(1, true));
            });

            // File upload preview
            setupFilePreview();
        }

        function setupFilePreview() {
            const imageInput = document.getElementById("image");
            const cvInput = document.getElementById("cv");
            const preview = document.getElementById("filePreview");

            [imageInput, cvInput].forEach(input => {
                input.addEventListener("change", function() {
                    handleFilePreview(this, preview);
                });
            });
        }

        function handleFilePreview(input, preview) {
            const file = input.files[0];

            if (!file) {
                preview.style.display = "none";
                return;
            }

            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                showAlert('danger', 'Ukuran file terlalu besar. Maksimal 2MB');
                input.value = '';
                preview.style.display = "none";
                return;
            }

            // Show preview
            preview.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-file fa-2x text-primary me-3"></i>
                    <div>
                        <div class="fw-bold">${file.name}</div>
                        <small class="text-muted">${formatFileSize(file.size)} • ${file.type}</small>
                    </div>
                </div>
            `;
            preview.style.display = "block";
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function clearAllFilters() {
            document.getElementById("categoryFilter").value = "";
            document.getElementById("statusFilter").value = "";
            document.getElementById("searchInput").value = "";
            updateFilterCount();
            loadJobs(1, true);
        }

        function updateFilterCount() {
            const filters = [
                document.getElementById("categoryFilter").value,
                document.getElementById("statusFilter").value,
                document.getElementById("searchInput").value
            ].filter(val => val.trim() !== "");

            const badge = document.getElementById("filterCount");
            badge.textContent = filters.length === 0 ? "Semua" : `${filters.length} Filter`;
        }

        function loadJobs(page = 1, isFilter = false) {
            if (isLoading) return;

            isLoading = true;
            currentPage = page;

            // Show loading state
            showLoadingState();
            updateFilterCount();

            // Build API URL
            const params = new URLSearchParams({
                page: page,
                per_page: 12
            });

            // Add filters
            const category = document.getElementById("categoryFilter").value;
            const status = document.getElementById("statusFilter").value;
            const search = document.getElementById("searchInput").value;

            if (category) params.append('category', category);
            if (status) params.append('status', status);
            if (search) params.append('search', search);

            // Fetch jobs
            fetch(`/api/jobs?${params.toString()}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    hideLoadingState();
                    if (data.success) {
                        renderJobs(data.data.data);
                        renderPagination(data.data);
                        totalPages = data.data.last_page;
                    } else {
                        showEmptyState('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoadingState();
                    showEmptyState('Terjadi kesalahan saat memuat data');
                })
                .finally(() => {
                    isLoading = false;
                });
        }

        function showLoadingState() {
            document.getElementById("loadingSpinner").classList.remove("d-none");
            document.getElementById("jobList").innerHTML = "";
            document.getElementById("emptyState").classList.add("d-none");
            document.getElementById("paginationContainer").style.display = "none";
        }

        function hideLoadingState() {
            document.getElementById("loadingSpinner").classList.add("d-none");
            document.getElementById("paginationContainer").style.display = "block";
        }

        function showEmptyState(message = null) {
            const emptyState = document.getElementById("emptyState");
            if (message) {
                emptyState.querySelector('h4').textContent = 'Terjadi Kesalahan';
                emptyState.querySelector('p').textContent = message;
            }
            emptyState.classList.remove("d-none");
            document.getElementById("paginationContainer").style.display = "none";
        }

        function renderJobs(jobs) {
            const jobList = document.getElementById("jobList");
            jobList.innerHTML = "";

            if (jobs.length === 0) {
                showEmptyState();
                return;
            }

            jobs.forEach((job, index) => {
                const jobCard = createJobCard(job, index);
                jobList.appendChild(jobCard);
            });

            // Add event listeners to view details buttons
            document.querySelectorAll('.view-job-details').forEach(button => {
                button.addEventListener('click', function() {
                    const jobId = this.getAttribute('data-id');
                    viewJobDetails(jobId);
                });
            });
        }

        function createJobCard(job, index) {
            const statusConfig = getStatusConfig(job.status);
            const formattedSalary = formatCurrency(job.salary || 0);
            const imageUrl = job.image ? `/${job.image}` : '/uploads/image_job/default/job.jpg';

            const card = document.createElement('div');
            card.className = 'col-lg-4 col-md-6 fade-in';
            card.style.animationDelay = `${index * 0.1}s`;

            card.innerHTML = `
                <div class="card job-card h-100">
                    <div class="job-card-image">
                        <img src="${imageUrl}" alt="${job.title}"
                             onerror="this.src='/uploads/image_job/default/job.jpg'">
                        <div class="job-card-overlay">
                            <span class="job-category">${job.category || 'Tidak tersedia'}</span>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="job-title">${job.title || 'Judul tidak tersedia'}</h5>

                        <div class="job-info">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>${formattedSalary} (${job.salary_type || 'Tipe tidak tersedia'})</span>
                        </div>
                        <div class="job-info">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>${job.location || 'Lokasi tidak tersedia'}</span>
                        </div>
                        <div class="job-info">
                            <i class="fas fa-clock"></i>
                            <span>${job.duration || 'Durasi tidak tersedia'}</span>
                        </div>

                        <div class="job-status ${statusConfig.class} mt-auto mb-3">
                            <i class="${statusConfig.icon}"></i> ${statusConfig.text}
                        </div>

                        <button class="btn view-detail-btn view-job-details" data-id="${job.id}">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </button>
                    </div>
                </div>
            `;

            return card;
        }

        function getStatusConfig(status) {
            const configs = {
                'Dibuka': { class: 'status-open', icon: 'fas fa-door-open', text: 'Dibuka' },
                'Ditutup': { class: 'status-closed', icon: 'fas fa-door-closed', text: 'Ditutup' },
                'Selesai': { class: 'status-finished', icon: 'fas fa-check-circle', text: 'Selesai' }
            };
            return configs[status] || { class: 'status-closed', icon: 'fas fa-question', text: 'Tidak diketahui' };
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }

        function renderPagination(paginationData) {
            const pagination = document.getElementById("pagination");
            pagination.innerHTML = "";

            if (paginationData.last_page <= 1) return;

            // Previous button
            if (paginationData.current_page > 1) {
                pagination.appendChild(createPaginationItem('‹', paginationData.current_page - 1, false));
            }

            // Page numbers
            const startPage = Math.max(1, paginationData.current_page - 2);
            const endPage = Math.min(paginationData.last_page, paginationData.current_page + 2);

            if (startPage > 1) {
                pagination.appendChild(createPaginationItem('1', 1, false));
                if (startPage > 2) {
                    pagination.appendChild(createPaginationItem('...', null, false, true));
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                const isActive = i === paginationData.current_page;
                pagination.appendChild(createPaginationItem(i, i, isActive));
            }

            if (endPage < paginationData.last_page) {
                if (endPage < paginationData.last_page - 1) {
                    pagination.appendChild(createPaginationItem('...', null, false, true));
                }
                pagination.appendChild(createPaginationItem(paginationData.last_page, paginationData.last_page, false));
            }

            // Next button
            if (paginationData.current_page < paginationData.last_page) {
                pagination.appendChild(createPaginationItem('›', paginationData.current_page + 1, false));
            }
        }

        function createPaginationItem(text, page, isActive, isDisabled = false) {
            const li = document.createElement('li');
            li.className = `page-item ${isActive ? 'active' : ''} ${isDisabled ? 'disabled' : ''}`;

            const a = document.createElement('a');
            a.className = 'page-link';
            a.href = '#';
            a.textContent = text;

            if (!isDisabled && page) {
                a.addEventListener('click', (e) => {
                    e.preventDefault();
                    loadJobs(page);
                });
            }

            li.appendChild(a);
            return li;
        }

        function viewJobDetails(jobId) {
            const modal = new bootstrap.Modal(document.getElementById('jobDetailModal'));

            // Show loading state
            setJobDetailLoading();
            modal.show();

            // Fetch job details
            fetch(`/api/jobs/${jobId}`)
                .then(response => {
                    if (!response.ok) throw new Error('Failed to fetch job details');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        populateJobDetail(data.data);
                        setupApplyButton(data.data);
                    } else {
                        showJobDetailError();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showJobDetailError();
                });
        }

        function setJobDetailLoading() {
            document.getElementById("jobDetailTitle").textContent = "Memuat...";
            document.getElementById("jobDetailCategory").textContent = "Memuat...";
            document.getElementById("jobDetailDescription").textContent = "Memuat detail pekerjaan...";

            const banner = document.getElementById("jobDetailBanner");
            banner.classList.add("loading");
            banner.style.backgroundImage = "none";
        }

        function populateJobDetail(job) {
            // Remove loading state
            const banner = document.getElementById("jobDetailBanner");
            banner.classList.remove("loading");

            // Set banner image
            const imageUrl = job.image ? `/${job.image}` : '/uploads/image_job/default/job.jpg';
            banner.style.backgroundImage = `url('${imageUrl}')`;

            // Populate job details
            document.getElementById("jobDetailTitle").textContent = job.title || '-';
            document.getElementById("jobDetailCategory").textContent = job.category || '-';
            document.getElementById("jobDetailSalary").textContent =
                `${formatCurrency(job.salary || 0)} (${job.salary_type || '-'})`;
            document.getElementById("jobDetailDuration").textContent = job.duration || '-';
            document.getElementById("jobDetailLocation").textContent = job.location || '-';

            const deadline = job.deadline ?
                new Date(job.deadline).toLocaleDateString('id-ID', {
                    year: 'numeric', month: 'long', day: 'numeric'
                }) : 'Tidak ada batas waktu';
            document.getElementById("jobDetailDeadline").textContent = deadline;

            document.getElementById("jobDetailDescription").innerHTML =
                formatText(job.description || 'Tidak ada deskripsi.');
            document.getElementById("jobDetailRequirements").innerHTML =
                formatText(job.requirements || 'Tidak ada persyaratan khusus.');
            document.getElementById("jobDetailBenefits").innerHTML =
                formatText(job.benefits || 'Benefit akan dijelaskan lebih lanjut.');
        }

        function formatText(text) {
            return text.split('\n').map(line =>
                line.trim() ? `<p>${line.trim()}</p>` : ''
            ).join('');
        }

        function setupApplyButton(job) {
            const applyBtn = document.getElementById("applyNowBtn");
            applyBtn.onclick = () => showApplyModal(job);

            // Disable button if job is closed
            if (job.status !== 'Dibuka') {
                applyBtn.disabled = true;
                applyBtn.innerHTML = '<i class="fas fa-times me-2"></i>Lowongan Ditutup';
                applyBtn.classList.add('btn-secondary');
                applyBtn.classList.remove('btn-primary-custom');
            }
        }

        function showJobDetailError() {
            document.getElementById("jobDetailTitle").textContent = "Error";
            document.getElementById("jobDetailDescription").textContent = "Gagal memuat detail lowongan.";
        }

        function showApplyModal(job) {
            // Check if user is logged in
            @guest
                showAlert('warning', 'Silakan login terlebih dahulu untuk melamar pekerjaan.');
                return;
            @endguest

            // Reset and populate form
            const form = document.getElementById("applyForm");
            form.reset();
            document.getElementById("job_id").value = job.id;
            document.getElementById("jobTitleModal").textContent = job.title || '-';
            document.getElementById("jobCategoryModal").textContent = job.category || '-';
            document.getElementById("applyMessage").innerHTML = "";
            document.getElementById("filePreview").style.display = "none";

            // Auto-fill user data
            @auth
                document.getElementById("name").value = "{{ auth()->user()->name }}";
                document.getElementById("email").value = "{{ auth()->user()->email }}";
            @endauth

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('applyModal'));
            modal.show();
        }

        function setupFormValidation() {
            const form = document.getElementById("applyForm");

            form.addEventListener("submit", function(e) {
                e.preventDefault();

                if (!validateForm()) return;

                submitApplication();
            });
        }

        function validateForm() {
            const requiredFields = ['name', 'email', 'phone_number', 'whatsapp_number', 'gender', 'education_level'];
            let isValid = true;

            // Clear previous errors
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                }
            });

            // Email validation
            const email = document.getElementById('email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value)) {
                email.classList.add('is-invalid');
                isValid = false;
            }

            // Phone validation
            const phone = document.getElementById('phone_number');
            const whatsapp = document.getElementById('whatsapp_number');
            const phoneRegex = /^[\+]?[0-9\-\s\(\)]+$/;

            if (!phoneRegex.test(phone.value) || !phoneRegex.test(whatsapp.value)) {
                phone.classList.add('is-invalid');
                whatsapp.classList.add('is-invalid');
                isValid = false;
            }

            if (!isValid) {
                showAlert('danger', 'Silakan lengkapi semua field yang wajib diisi dengan benar!');
            }

            return isValid;
        }

        function submitApplication() {
            const form = document.getElementById("applyForm");
            const formData = new FormData(form);
            const jobId = document.getElementById('job_id').value;

            // Show loading
            showAlert('info', '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim lamaran Anda, mohon tunggu...');

            // Disable submit button
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';

            fetch(`/jobs/${jobId}/apply`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', `<i class="fas fa-check-circle me-2"></i>${data.message}`);
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('applyModal'));
                        if (modal) modal.hide();
                        location.reload(); // Reload to update history
                    }, 2000);
                } else {
                    showAlert('danger', `<i class="fas fa-exclamation-triangle me-2"></i>${data.message}`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', '<i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan, silakan coba lagi nanti.');
            })
            .finally(() => {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        }

        function showAlert(type, message) {
            const alertContainer = document.getElementById("applyMessage");
            alertContainer.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        }

        function viewApplicationDetail(applicationId) {
            // This function can be expanded to show application details
            // For now, we'll just show an alert
            showAlert('info', 'Fitur detail lamaran akan segera tersedia.');
        }

        // Additional utility functions
        function goToPage(page) {
            if (page >= 1 && page <= totalPages && page !== currentPage) {
                loadJobs(page);
            }
        }

        // Keyboard navigation for pagination
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey) {
                switch(e.key) {
                    case 'ArrowLeft':
                        e.preventDefault();
                        if (currentPage > 1) goToPage(currentPage - 1);
                        break;
                    case 'ArrowRight':
                        e.preventDefault();
                        if (currentPage < totalPages) goToPage(currentPage + 1);
                        break;
                }
            }
        });
    </script>
@endsection

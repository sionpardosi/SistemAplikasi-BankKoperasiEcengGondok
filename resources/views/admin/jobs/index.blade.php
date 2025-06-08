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

        /* Action Bar */
        .action-bar {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .action-bar .d-flex {
            align-items: center;
            justify-content: space-between;
        }

        .btn-add-new {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
            text-decoration: none;
        }

        .btn-add-new:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
            color: white;
        }

        /* Summary Cards */
        .summary-section {
            margin-bottom: 30px;
        }

        .summary-card {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            height: 100%;
            text-align: center;
        }

        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .summary-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            margin: 0 auto 15px;
        }

        .summary-number {
            font-size: 32px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 8px;
            line-height: 1;
        }

        .summary-label {
            font-size: 15px;
            color: #6c757d;
            font-weight: 600;
            margin: 0;
        }

        /* Filter Section */
        .filter-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .filter-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .filter-title {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin: 0;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .form-control,
        .form-select {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .search-container {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 16px;
        }

        .search-input {
            padding-left: 45px;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            align-items: end;
        }

        .btn-filter {
            background: #007bff;
            border: 1px solid #007bff;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-filter:hover {
            background: #0056b3;
            border-color: #0056b3;
            color: white;
            transform: translateY(-1px);
        }

        .btn-reset {
            background: #6c757d;
            border: 1px solid #6c757d;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            white-space: nowrap;
            text-decoration: none;
        }

        .btn-reset:hover {
            background: #545b62;
            border-color: #545b62;
            color: white;
            transform: translateY(-1px);
        }

        /* Enhanced table styling */
        .enhanced-table-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .table-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-title {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin: 0;
        }

        .table-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-export {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-export:hover {
            color: white;
            transform: translateY(-1px);
        }

        /* Enhanced table */
        .table {
            margin-bottom: 0;
            font-size: 15px;
        }

        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 700;
            color: #495057;
            padding: 18px 15px;
            font-size: 15px;
            white-space: nowrap;
            border-top: none;
        }

        .table tbody td {
            padding: 18px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f4;
            font-size: 15px;
            line-height: 1.4;
        }

        .table tbody tr:hover {
            background-color: #f8f9ff;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Job Row Styling */
        .job-row {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .job-row:hover {
            background-color: #f0f8ff !important;
            box-shadow: inset 0 0 0 2px #007bff;
        }

        .job-row.expanded {
            background-color: #e8f4fd !important;
        }

        /* Expandable Content */
        .expandable-content {
            display: none;
            background: #f8f9fa;
            border-top: 2px solid #007bff;
        }

        .expandable-content.show {
            display: table-row;
        }

        .expandable-inner {
            padding: 25px;
            border-radius: 8px;
            background: white;
            margin: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .expandable-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .expandable-tab {
            padding: 10px 20px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-bottom: none;
            border-radius: 8px 8px 0 0;
            cursor: pointer;
            font-weight: 600;
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .expandable-tab.active {
            background: white;
            color: #007bff;
            border-color: #007bff;
        }

        .tab-content {
            display: none;
            padding: 20px 0;
        }

        .tab-content.active {
            display: block;
        }

        /* Enhanced badges and status */
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-success {
            background: #d1f2eb;
            color: #0c5460;
            border: 1px solid #7dd3fc;
        }

        .status-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status-secondary {
            background: #e2e3e5;
            color: #383d41;
            border: 1px solid #c6c8ca;
        }

        .category-badge {
            background: #e3f2fd;
            color: #1565c0;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid #bbdefb;
        }

        /* Applicant Counter with Breakdown */
        .applicant-counter {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .applicant-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .applicant-total {
            background: #e3f2fd;
            color: #1565c0;
            border: 1px solid #bbdefb;
        }

        .applicant-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .applicant-accepted {
            background: #d1f2eb;
            color: #0c5460;
            border: 1px solid #7dd3fc;
        }

        .applicant-rejected {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Enhanced job info */
        .job-title {
            font-weight: 700;
            color: #495057;
            font-size: 16px;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .job-expand-icon {
            color: #007bff;
            font-size: 14px;
            transition: transform 0.3s ease;
        }

        .job-row.expanded .job-expand-icon {
            transform: rotate(90deg);
        }

        .job-description {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .salary-value {
            font-weight: 700;
            color: #495057;
            font-size: 15px;
        }

        .location-text {
            font-weight: 600;
            color: #495057;
            font-size: 15px;
        }

        /* Enhanced action buttons */
        .action-buttons {
            display: flex;
            gap: 6px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }

        .btn-quick-view {
            background: #28a745;
            border-color: #28a745;
            color: white;
        }

        .btn-quick-view:hover {
            background: #1e7e34;
            border-color: #1e7e34;
            color: white;
            transform: translateY(-1px);
        }

        .btn-edit {
            background: #007bff;
            border-color: #007bff;
            color: white;
        }

        .btn-edit:hover {
            background: #0056b3;
            border-color: #0056b3;
            color: white;
            transform: translateY(-1px);
        }

        .btn-delete {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
            border-color: #c82333;
            color: white;
            transform: translateY(-1px);
        }

        /* Add to existing button styles */
        .tf-button.style-1 {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
            text-decoration: none;
        }

        .tf-button.style-1:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
            color: white;
        }

        /* Applicants List in Expandable */
        .applicants-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .applicant-item {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .applicant-info {
            flex: 1;
        }

        .applicant-name {
            font-weight: 700;
            color: #495057;
            font-size: 15px;
            margin-bottom: 4px;
        }

        .applicant-details {
            font-size: 13px;
            color: #6c757d;
            line-height: 1.3;
        }

        .applicant-actions {
            display: flex;
            gap: 6px;
        }

        .btn-mini {
            padding: 4px 8px;
            font-size: 10px;
            border-radius: 4px;
        }

        /* Quick View Modal */
        .modal-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .modal-title {
            font-weight: 700;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .enhanced-search-section,
            .enhanced-table-section {
                padding: 20px;
            }

            .table-header {
                flex-direction: column;
                gap: 15px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
                padding: 8px 10px;
                font-size: 12px;
            }

            .applicant-counter {
                flex-direction: column;
                align-items: flex-start;
            }

            /* Hide some columns on mobile */
            .table thead th:nth-child(3),
            .table tbody td:nth-child(3),
            .table thead th:nth-child(4),
            .table tbody td:nth-child(4) {
                display: none;
            }
        }

        /* Job Stats in expandable */
        .job-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .job-stat-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
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
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Manajemen Lowongan Kerja</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Lowongan Kerja</div>
                    </li>
                </ul>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="page-title">Kelola Lowongan Pekerjaan</h4>
                        <p class="text-muted mb-0">Manajemen semua lowongan kerja dan pelamar yang tersedia</p>
                    </div>
                    <a href="{{ route('admin.jobs.add') }}" class="btn-add-new">
                        <i class="icon-plus"></i> Tambah Lowongan Baru
                    </a>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="summary-section">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-info">
                                <i class="icon-briefcase"></i>
                            </div>
                            <div class="summary-number" id="total-jobs">0</div>
                            <div class="summary-label">Total Lowongan</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-success">
                                <i class="icon-check"></i>
                            </div>
                            <div class="summary-number" id="active-jobs">0</div>
                            <div class="summary-label">Sedang Dibuka</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-warning">
                                <i class="icon-clock"></i>
                            </div>
                            <div class="summary-number" id="closed-jobs">0</div>
                            <div class="summary-label">Ditutup</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-primary">
                                <i class="icon-users"></i>
                            </div>
                            <div class="summary-number" id="total-applications">0</div>
                            <div class="summary-label">Total Pelamar</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-header">
                    <h5 class="filter-title">
                        <i class="icon-equalizer"></i> Filter & Pencarian Lowongan
                    </h5>
                </div>

                <div class="row g-3">
                    <!-- Search -->
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label">Cari Lowongan</label>
                        <div class="search-container">
                            <i class="icon-magnifier search-icon"></i>
                            <input type="text" id="search" class="form-control search-input"
                                placeholder="Cari judul, kategori, atau lokasi..." style="height: 50px; font-size: 16px;">
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Status</label>
                        <select id="status-filter" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Dibuka">Dibuka</option>
                            <option value="Ditutup">Ditutup</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Kategori</label>
                        <select id="category-filter" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="Full-time">Full-time</option>
                            <option value="Part-time">Part-time</option>
                            <option value="Freelance">Freelance</option>
                        </select>
                    </div>

                    <!-- Location Filter -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Lokasi</label>
                        <input type="text" id="location-filter" class="form-control" placeholder="Nama lokasi...">
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">&nbsp;</label>
                        <div class="filter-buttons">
                            <button type="button" class="btn btn-filter" onclick="applyFilters()" title="Terapkan Filter">
                                <i class="icon-search"></i> Filter
                            </button>
                            <button type="button" class="btn btn-reset" onclick="resetFilters()" title="Reset Filter">
                                <i class="icon-refresh"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filter Info -->
                <div class="filter-info mt-3"
                    style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px; padding: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="filter-info-text mb-0" style="font-size: 14px; color: #6c757d;">
                            <i class="icon-info"></i>
                            <span id="filter-info">Menampilkan semua lowongan kerja</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Enhanced Table Section -->
            <div class="enhanced-table-section">
                <div class="table-header">
                    <h5 class="table-title">
                        <i class="icon-list"></i> Daftar Lowongan Kerja
                    </h5>
                    <div class="table-actions">
                        <a href="#" class="btn-export" onclick="exportJobs()">
                            <i class="icon-cloud-download"></i> Export Data
                        </a>
                    </div>
                </div>

                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="8%">ID</th>
                                    <th width="35%">Lowongan & Pelamar</th>
                                    <th width="12%">Kategori</th>
                                    <th width="15%">Gaji</th>
                                    <th width="13%">Lokasi</th>
                                    <th width="10%">Status</th>
                                    <th width="17%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="job-table">
                                <tr>
                                    <td colspan="7" class="text-center" style="padding: 40px;">
                                        <div style="color: #6c757d; font-size: 16px;">
                                            <i class="icon-clock"
                                                style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                                            Memuat data lowongan...
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        <ul id="pagination" class="pagination"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let jobsData = [];
        let applicationsData = {};

        $(document).ready(function() {
            loadJobs();
            loadSummaryStats();

            // Enhanced jobs loading with applications data
            function loadJobs(page = 1) {
                $.ajax({
                    url: `/api/jobs?page=${page}`,
                    type: 'GET',
                    success: function(response) {
                        jobsData = response.data.data;
                        renderJobsTable(jobsData);
                        setupPagination(response.data);

                        // Load applications for each job
                        loadAllApplications();
                    },
                    error: function(err) {
                        console.log(err);
                        $('#job-table').html(`
                            <tr>
                                <td colspan="7" class="text-center text-danger" style="padding: 40px;">
                                    <i class="icon-alert-triangle" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                                    Gagal memuat data lowongan. Silakan refresh halaman.
                                </td>
                            </tr>
                        `);
                    }
                });
            }

            function loadAllApplications() {
                jobsData.forEach(job => {
                    $.ajax({
                        url: `/api/admin/jobs/${job.id}/applications`,
                        type: 'GET',
                        success: function(response) {
                            applicationsData[job.id] = response.data;
                            updateJobApplicationsDisplay(job.id);
                        },
                        error: function(err) {
                            console.log(`Error loading applications for job ${job.id}:`, err);
                        }
                    });
                });
            }

            function updateJobApplicationsDisplay(jobId) {
                const applications = applicationsData[jobId] || [];
                const total = applications.length;
                const pending = applications.filter(app => app.status === 'Diproses').length;
                const accepted = applications.filter(app => app.status === 'Diterima').length;
                const rejected = applications.filter(app => app.status === 'Ditolak').length;

                const $row = $(`.job-row[data-job-id="${jobId}"]`);
                $row.find('.applicant-total .count').text(total);
                $row.find('.applicant-pending .count').text(pending);
                $row.find('.applicant-accepted .count').text(accepted);
                $row.find('.applicant-rejected .count').text(rejected);
            }

            function renderJobsTable(jobs) {
                let html = '';
                if (jobs && jobs.length > 0) {
                    jobs.forEach(job => {
                        html += `
                            <tr class="job-row" data-job-id="${job.id}">
                                <td>
                                    <div style="font-weight: 700; color: #495057; font-size: 16px;">#${job.id}</div>
                                </td>
                                <td>
                                    <div class="job-title">
                                        <i class="icon-chevron-right job-expand-icon"></i>
                                        ${job.title}
                                    </div>
                                    <div class="job-description">
                                        ${job.description ? (job.description.length > 80 ? job.description.substring(0, 80) + '...' : job.description) : 'Tidak ada deskripsi'}
                                    </div>
                                    <div class="applicant-counter">
                                        <span class="applicant-badge applicant-total">
                                            <i class="icon-users"></i> <span class="count">0</span> Total
                                        </span>
                                        <span class="applicant-badge applicant-pending">
                                            <i class="icon-clock"></i> <span class="count">0</span> Pending
                                        </span>
                                        <span class="applicant-badge applicant-accepted">
                                            <i class="icon-check"></i> <span class="count">0</span> Diterima
                                        </span>
                                        <span class="applicant-badge applicant-rejected">
                                            <i class="icon-close"></i> <span class="count">0</span> Ditolak
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <span class="category-badge">
                                        <i class="icon-tag"></i> ${job.category}
                                    </span>
                                </td>
                                <td>
                                    <div class="salary-value">Rp${parseFloat(job.salary).toLocaleString()}</div>
                                    <div style="font-size: 12px; color: #6c757d;">${job.salary_type}</div>
                                </td>
                                <td>
                                    <div class="location-text">
                                        <i class="icon-location-pin"></i> ${job.location}
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge ${job.status == 'Dibuka' ? 'status-success' : (job.status == 'Ditutup' ? 'status-danger' : 'status-secondary')}">
                                        <i class="${job.status == 'Dibuka' ? 'icon-check' : (job.status == 'Ditutup' ? 'icon-clock' : 'icon-close')}"></i>
                                        ${job.status}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="/admin/jobs/${job.id}/applications" class="btn-action btn-quick-view" title="Lihat Daftar Pelamar">
                                            <i class="icon-users"></i> Pelamar
                                        </a>
                                        <a href="/admin/jobs/edit/${job.id}" class="btn-action btn-edit" title="Edit Lowongan">
                                            <i class="icon-edit-3"></i> Edit
                                        </a>
                                        <button class="btn-action btn-delete delete" data-id="${job.id}" title="Hapus Lowongan">
                                            <i class="icon-trash-2"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="expandable-content" id="expandable-${job.id}">
                                <td colspan="7">
                                    <div class="expandable-inner">
                                        <div class="expandable-tabs">
                                            <div class="expandable-tab active" onclick="switchTab(${job.id}, 'details')">
                                                <i class="icon-info"></i> Detail Lowongan
                                            </div>
                                            <div class="expandable-tab" onclick="switchTab(${job.id}, 'applicants')">
                                                <i class="icon-users"></i> Daftar Pelamar
                                            </div>
                                            <div class="expandable-tab" onclick="switchTab(${job.id}, 'analytics')">
                                                <i class="icon-bar-chart"></i> Analitik
                                            </div>
                                        </div>

                                        <div class="tab-content active" id="details-${job.id}">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h6><i class="icon-file-text"></i> Deskripsi Lengkap</h6>
                                                    <p>${job.description || 'Tidak ada deskripsi'}</p>

                                                    <h6><i class="icon-list"></i> Persyaratan</h6>
                                                    <p>${job.requirements || 'Tidak ada persyaratan khusus'}</p>

                                                    <h6><i class="icon-gift"></i> Benefit</h6>
                                                    <p>${job.benefits || 'Tidak ada benefit disebutkan'}</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="job-stats-grid">
                                                        <div class="job-stat-card">
                                                            <div class="job-stat-number">${job.duration}</div>
                                                            <div class="job-stat-label">Durasi</div>
                                                        </div>
                                                        <div class="job-stat-card">
                                                            <div class="job-stat-number">${job.target || '-'}</div>
                                                            <div class="job-stat-label">Target</div>
                                                        </div>
                                                    </div>
                                                    <p><strong>Deadline:</strong> ${job.deadline || 'Tidak ditentukan'}</p>
                                                    <p><strong>Dibuat:</strong> ${new Date(job.created_at).toLocaleDateString('id-ID')}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-content" id="applicants-${job.id}">
                                            <div class="applicants-list" id="applicants-list-${job.id}">
                                                <div class="text-center" style="padding: 40px; color: #6c757d;">
                                                    <i class="icon-users" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                                                    Memuat daftar pelamar...
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-content" id="analytics-${job.id}">
                                            <div class="job-stats-grid">
                                                <div class="job-stat-card">
                                                    <div class="job-stat-number applicant-total-stat">0</div>
                                                    <div class="job-stat-label">Total Aplikasi</div>
                                                </div>
                                                <div class="job-stat-card">
                                                    <div class="job-stat-number applicant-response-rate">0%</div>
                                                    <div class="job-stat-label">Response Rate</div>
                                                </div>
                                                <div class="job-stat-card">
                                                    <div class="job-stat-number applicant-conversion">0%</div>
                                                    <div class="job-stat-label">Conversion Rate</div>
                                                </div>
                                                <div class="job-stat-card">
                                                    <div class="job-stat-number">0</div>
                                                    <div class="job-stat-label">Hari Aktif</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `
                        <tr>
                            <td colspan="7" class="text-center" style="padding: 60px;">
                                <div style="color: #6c757d;">
                                    <i class="icon-briefcase" style="font-size: 48px; margin-bottom: 15px; display: block; opacity: 0.3;"></i>
                                    <h5>Tidak ada lowongan kerja</h5>
                                    <p>Belum ada lowongan yang tersedia. Klik tombol "Tambah Lowongan" untuk membuat lowongan pertama.</p>
                                </div>
                            </td>
                        </tr>
                    `;
                }
                $('#job-table').html(html);
            }

            // Row click to expand
            $(document).on('click', '.job-row', function(e) {
                // Don't expand if clicking on action buttons
                if ($(e.target).closest('.action-buttons').length) return;

                const jobId = $(this).data('job-id');
                const $expandable = $(`#expandable-${jobId}`);
                const $row = $(this);

                if ($expandable.hasClass('show')) {
                    $expandable.removeClass('show');
                    $row.removeClass('expanded');
                } else {
                    // Close other expanded rows
                    $('.expandable-content').removeClass('show');
                    $('.job-row').removeClass('expanded');

                    $expandable.addClass('show');
                    $row.addClass('expanded');

                    // Load applicants if not loaded
                    loadApplicantsForExpanded(jobId);
                }
            });

            function loadApplicantsForExpanded(jobId) {
                const applications = applicationsData[jobId] || [];
                if (applications.length === 0) {
                    $(`#applicants-list-${jobId}`).html(`
                        <div class="text-center" style="padding: 40px; color: #6c757d;">
                            <i class="icon-users" style="font-size: 24px; margin-bottom: 10px; display: block; opacity: 0.3;"></i>
                            <h6>Belum ada pelamar</h6>
                            <p>Lowongan ini belum menerima lamaran dari kandidat.</p>
                        </div>
                    `);
                    return;
                }

                let applicantsHtml = '';
                applications.forEach(app => {
                    const statusClass = app.status === 'Diterima' ? 'success' : app.status === 'Ditolak' ?
                        'danger' : 'warning';
                    applicantsHtml += `
                        <div class="applicant-item">
                            <div class="applicant-info">
                                <div class="applicant-name">${app.user.name}</div>
                                <div class="applicant-details">
                                    📧 ${app.user.email} | 📱 ${app.phone_number || 'Tidak tersedia'}<br>
                                    🎓 ${app.education_level} | 💼 ${app.experience || 'Tidak ada pengalaman'}<br>
                                    💰 Ekspektasi: ${app.expected_salary || 'Tidak disebutkan'} | 📅 ${new Date(app.created_at).toLocaleDateString('id-ID')}
                                </div>
                            </div>
                            <div class="applicant-actions">
                                <span class="badge bg-${statusClass}">${app.status}</span>
                                ${app.cv ? `<a href="{{ asset('storage') }}/${app.cv}" class="btn btn-outline-primary btn-mini" target="_blank"><i class="icon-download"></i> CV</a>` : ''}
                            </div>
                        </div>
                    `;
                });
                $(`#applicants-list-${jobId}`).html(applicantsHtml);
            }

            // Rest of the functions remain the same...
            function setupPagination(data) {
                let paginationHTML = '';
                if (data.prev_page_url) {
                    paginationHTML +=
                        `<li class="page-item"><a class="page-link" href="#" data-page="${data.current_page - 1}">&laquo;</a></li>`;
                }
                for (let i = 1; i <= data.last_page; i++) {
                    paginationHTML += `<li class="page-item ${data.current_page == i ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>`;
                }
                if (data.next_page_url) {
                    paginationHTML +=
                        `<li class="page-item"><a class="page-link" href="#" data-page="${data.current_page + 1}">&raquo;</a></li>`;
                }
                $('#pagination').html(paginationHTML);
            }

            function loadSummaryStats() {
                $.ajax({
                    url: '/api/jobs?per_page=1000',
                    type: 'GET',
                    success: function(response) {
                        let jobs = response.data.data || [];

                        $('#total-jobs').text(jobs.length);
                        $('#active-jobs').text(jobs.filter(j => j.status === 'Dibuka').length);
                        $('#closed-jobs').text(jobs.filter(j => j.status === 'Ditutup').length);
                        $('#total-applications').text(
                            '0'); // Will be updated after loading applications
                    },
                    error: function(err) {
                        console.log('Error loading stats:', err);
                    }
                });
            }

            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                let page = $(this).data('page');
                loadJobs(page);
            });

            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                e.stopPropagation(); // Prevent row expansion
                let jobId = $(this).data('id');

                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Lowongan ini akan dihapus secara permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/api/admin/jobs/${jobId}`,
                            type: 'DELETE',
                            success: function(response) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Lowongan berhasil dihapus',
                                    icon: 'success',
                                    timer: 2000
                                });
                                loadJobs();
                                loadSummaryStats();
                            },
                            error: function(err) {
                                console.log(err);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Gagal menghapus lowongan',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });

            $('#search').on('keyup', function() {
                let keyword = $(this).val().toLowerCase();
                $('.job-row').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(keyword) > -1);
                });
            });
        });

        // Tab switching function
        function switchTab(jobId, tabName) {
            $(`#expandable-${jobId} .expandable-tab`).removeClass('active');
            $(`#expandable-${jobId} .tab-content`).removeClass('active');

            $(`#expandable-${jobId} .expandable-tab:contains('${tabName === 'details' ? 'Detail' : tabName === 'applicants' ? 'Daftar' : 'Analitik'}')`)
                .addClass('active');
            $(`#${tabName}-${jobId}`).addClass('active');
        }

        // Export function
        function exportJobs() {
            Swal.fire({
                title: 'Mengunduh Data...',
                text: 'Silakan tunggu, file sedang disiapkan.',
                icon: 'info',
                timer: 2000,
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            }).then(() => {
                window.location.href = '/api/admin/jobs/export';
            });
        }
    </script>
@endpush

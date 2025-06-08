@extends('layouts.admin')

@section('content')
    <style>
        /* Base Styling */
        .main-content-inner {
            padding: 1.5rem;
        }

        /* Job Header Card */
        .job-header-card {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .job-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .job-info {
            flex: 1;
        }

        .job-title {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 10px 0;
        }

        .job-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .job-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            opacity: 0.9;
        }

        .job-description {
            font-size: 15px;
            opacity: 0.8;
            line-height: 1.5;
        }

        .job-stats-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 8px;
            padding: 20px;
            min-width: 200px;
        }

        .job-stat-number {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .job-stat-label {
            font-size: 13px;
            opacity: 0.8;
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
        }

        .btn-reset:hover {
            background: #545b62;
            border-color: #545b62;
            color: white;
            transform: translateY(-1px);
        }

        /* Table Section */
        .table-section {
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

        .bulk-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

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

        /* Applicant Info Styling */
        .applicant-name {
            font-weight: 700;
            color: #495057;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .applicant-contact {
            font-size: 13px;
            color: #6c757d;
            line-height: 1.3;
        }

        .education-main {
            font-weight: 600;
            color: #495057;
            font-size: 15px;
            margin-bottom: 2px;
        }

        .education-detail {
            font-size: 13px;
            color: #6c757d;
        }

        .experience-text {
            font-weight: 600;
            color: #495057;
            font-size: 15px;
        }

        .skills-list {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .date-applied {
            font-weight: 600;
            color: #495057;
            font-size: 15px;
            margin-bottom: 2px;
        }

        .time-applied {
            font-size: 13px;
            color: #6c757d;
        }

        /* Status Badges */
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

        .status-diproses {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-diterima {
            background: #d1f2eb;
            color: #0c5460;
            border: 1px solid #7dd3fc;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Action Buttons */
        .action-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .btn-action {
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .btn-view {
            background: #17a2b8;
            border-color: #17a2b8;
            color: white;
        }

        .btn-view:hover {
            background: #138496;
            border-color: #138496;
            color: white;
            transform: translateY(-1px);
        }

        .btn-accept {
            background: #28a745;
            border-color: #28a745;
            color: white;
        }

        .btn-accept:hover {
            background: #1e7e34;
            border-color: #1e7e34;
            color: white;
            transform: translateY(-1px);
        }

        .btn-reject {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .btn-reject:hover {
            background: #c82333;
            border-color: #c82333;
            color: white;
            transform: translateY(-1px);
        }

        .btn-download {
            background: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }

        .btn-download:hover {
            background: #e0a800;
            border-color: #e0a800;
            color: #212529;
            transform: translateY(-1px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #6c757d;
        }

        .empty-icon {
            font-size: 80px;
            margin-bottom: 25px;
            opacity: 0.3;
        }

        .empty-title {
            font-size: 24px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 10px;
        }

        .empty-text {
            font-size: 16px;
            color: #6c757d;
            margin-bottom: 30px;
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

            .job-header-content {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .job-meta {
                justify-content: center;
            }

            .table-header {
                flex-direction: column;
                gap: 15px;
            }

            .bulk-actions {
                width: 100%;
                justify-content: center;
            }

            .action-group {
                flex-direction: column;
                gap: 5px;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Daftar Pelamar Lowongan</h3>
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
                        <div class="text-tiny">Daftar Pelamar</div>
                    </li>
                </ul>
            </div>

            <!-- Job Header Card -->
            <div class="job-header-card">
                <div class="job-header-content">
                    <div class="job-info">
                        <h2 class="job-title" id="job-title">Loading...</h2>
                        <div class="job-meta">
                            <div class="job-meta-item">
                                <i class="icon-tag"></i>
                                <span id="job-category">-</span>
                            </div>
                            <div class="job-meta-item">
                                <i class="icon-location-pin"></i>
                                <span id="job-location">-</span>
                            </div>
                            <div class="job-meta-item">
                                <i class="icon-credit-card"></i>
                                <span id="job-salary">-</span>
                            </div>
                            <div class="job-meta-item">
                                <i class="icon-calendar"></i>
                                <span id="job-duration">-</span>
                            </div>
                        </div>
                        <div class="job-description" id="job-description">
                            Loading description...
                        </div>
                    </div>
                    <div class="job-stats-card">
                        <div class="job-stat-number" id="total-applicants">{{ $applications->count() }}</div>
                        <div class="job-stat-label">Total Pelamar</div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="summary-section">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-warning">
                                <i class="icon-clock"></i>
                            </div>
                            <div class="summary-number">{{ $applications->where('status', 'Diproses')->count() }}</div>
                            <div class="summary-label">Sedang Diproses</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-success">
                                <i class="icon-check"></i>
                            </div>
                            <div class="summary-number">{{ $applications->where('status', 'Diterima')->count() }}</div>
                            <div class="summary-label">Diterima</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-danger">
                                <i class="icon-close"></i>
                            </div>
                            <div class="summary-number">{{ $applications->where('status', 'Ditolak')->count() }}</div>
                            <div class="summary-label">Ditolak</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-info">
                                <i class="icon-users"></i>
                            </div>
                            <div class="summary-number">
                                {{ $applications->count() > 0 ? round((($applications->where('status', 'Diterima')->count() + $applications->where('status', 'Ditolak')->count()) / $applications->count()) * 100) : 0 }}%
                            </div>
                            <div class="summary-label">Response Rate</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-header">
                    <h5 class="filter-title">
                        <i class="icon-equalizer"></i> Filter & Pencarian Pelamar
                    </h5>
                </div>

                <div class="row g-3">
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label">Cari Pelamar</label>
                        <div class="search-container">
                            <i class="icon-magnifier search-icon"></i>
                            <input type="text" id="search" class="form-control search-input"
                                placeholder="Cari nama, email, atau skills...">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Status</label>
                        <select id="status-filter" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Diproses">Diproses</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Pendidikan</label>
                        <select id="education-filter" class="form-select">
                            <option value="">Semua Pendidikan</option>
                            <option value="SMA">SMA/SMK</option>
                            <option value="D3">Diploma (D3)</option>
                            <option value="S1">Sarjana (S1)</option>
                            <option value="S2">Magister (S2)</option>
                            <option value="S3">Doktor (S3)</option>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Tanggal Lamar</label>
                        <input type="date" id="date-filter" class="form-control">
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-filter" onclick="applyFilters()">
                                <i class="icon-search"></i> Filter
                            </button>
                            <button type="button" class="btn btn-reset" onclick="resetFilters()">
                                <i class="icon-refresh"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="table-section">
                <div class="table-header">
                    <h5 class="table-title">
                        <i class="icon-list"></i> Daftar Pelamar ({{ $applications->count() }} pelamar)
                    </h5>
                    <div class="bulk-actions">
                        <button class="btn btn-filter" onclick="exportApplicants()">
                            <i class="icon-cloud-download"></i> Export Excel
                        </button>
                        <a href="{{ route('admin.jobs') }}" class="btn btn-reset">
                            <i class="icon-arrow-left"></i> Kembali ke Lowongan
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    @if($applications->count() > 0)
                        <table class="table table-hover" id="applicants-table">
                            <thead>
                                <tr>
                                    <th width="20%">Pelamar</th>
                                    <th width="15%">Pendidikan</th>
                                    <th width="15%">Pengalaman</th>
                                    <th width="20%">Skills</th>
                                    <th width="12%">Tanggal Lamar</th>
                                    <th width="10%">Status</th>
                                    <th width="18%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $application)
                                    <tr data-status="{{ $application->status }}" data-education="{{ $application->education_level }}" data-date="{{ $application->created_at->format('Y-m-d') }}">
                                        <td>
                                            <div class="applicant-name">{{ $application->user->name }}</div>
                                            <div class="applicant-contact">
                                                <i class="icon-envelope"></i> {{ $application->user->email }}<br>
                                                <i class="icon-phone"></i> {{ $application->phone_number ?? 'Tidak tersedia' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="education-main">{{ $application->education_level }}</div>
                                            <div class="education-detail">Pendidikan Formal</div>
                                        </td>
                                        <td>
                                            <div class="experience-text">{{ $application->experience ?: 'Tidak ada pengalaman' }}</div>
                                        </td>
                                        <td>
                                            <div class="skills-list" title="{{ $application->skills }}">
                                                {{ $application->skills ? (strlen($application->skills) > 50 ? substr($application->skills, 0, 50) . '...' : $application->skills) : 'Tidak tersedia' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="date-applied">{{ $application->created_at->format('d M Y') }}</div>
                                            <div class="time-applied">{{ $application->created_at->format('H:i') }} WIB</div>
                                        </td>
                                        <td>
                                            <span class="status-badge
                                                @if($application->status === 'Diproses') status-diproses
                                                @elseif($application->status === 'Diterima') status-diterima
                                                @else status-ditolak @endif">
                                                <i class="
                                                    @if($application->status === 'Diproses') icon-clock
                                                    @elseif($application->status === 'Diterima') icon-check
                                                    @else icon-close @endif"></i>
                                                {{ $application->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-group">
                                                <button class="btn-action btn-view" onclick="viewApplicant({{ $application->id }})" title="Lihat Detail">
                                                    <i class="icon-eye"></i> Lihat
                                                </button>
                                                @if($application->cv)
                                                    <a href="{{ asset('storage/' . $application->cv) }}" class="btn-action btn-download" target="_blank" title="Download CV">
                                                        <i class="icon-cloud-download"></i> CV
                                                    </a>
                                                @endif
                                                @if($application->status === 'Diproses')
                                                    <button class="btn-action btn-accept" onclick="updateStatus({{ $application->id }}, 'Diterima')" title="Terima Pelamar">
                                                        <i class="icon-check"></i> Terima
                                                    </button>
                                                    <button class="btn-action btn-reject" onclick="updateStatus({{ $application->id }}, 'Ditolak')" title="Tolak Pelamar">
                                                        <i class="icon-close"></i> Tolak
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="icon-users"></i>
                            </div>
                            <h4 class="empty-title">Belum Ada Pelamar</h4>
                            <p class="empty-text">
                                Lowongan ini belum memiliki pelamar.<br>
                                Pastikan lowongan dalam status "Dibuka" agar dapat menerima lamaran.
                            </p>
                            <a href="{{ route('admin.jobs') }}" class="btn btn-filter">
                                <i class="icon-arrow-left"></i> Kembali ke Lowongan
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Applicant Detail Modal -->
    <div class="modal fade" id="applicantModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="icon-user"></i> Detail Pelamar
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modal-content">
                    <!-- Content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner"></div>
            <div class="loading-text">Memproses permintaan...</div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            loadJobDetails();
            setupFilters();
        });

        function loadJobDetails() {
            const jobId = {{ $jobId }};

            $.ajax({
                url: `/api/admin/jobs/${jobId}`,
                type: 'GET',
                success: function(response) {
                    const job = response.data;

                    $('#job-title').text(job.title);
                    $('#job-category').text(job.category);
                    $('#job-location').text(job.location);
                    $('#job-salary').text(`Rp ${parseFloat(job.salary).toLocaleString('id-ID')} ${job.salary_type}`);
                    $('#job-duration').text(job.duration);
                    $('#job-description').text(job.description ? (job.description.length > 150 ? job.description.substring(0, 150) + '...' : job.description) : 'Tidak ada deskripsi');
                },
                error: function(err) {
                    console.error('Error loading job details:', err);
                }
            });
        }

        function setupFilters() {
            $('#search').on('keyup', function() {
                applyFilters();
            });

            $('#status-filter, #education-filter, #date-filter').on('change', function() {
                applyFilters();
            });
        }

        function applyFilters() {
            const search = $('#search').val().toLowerCase();
            const status = $('#status-filter').val();
            const education = $('#education-filter').val();
            const date = $('#date-filter').val();

            $('#applicants-table tbody tr').each(function() {
                const row = $(this);
                const text = row.text().toLowerCase();
                const rowStatus = row.data('status');
                const rowEducation = row.data('education');
                const rowDate = row.data('date');

                let show = true;

                // Search filter
                if (search && !text.includes(search)) {
                    show = false;
                }

                // Status filter
                if (status && rowStatus !== status) {
                    show = false;
                }

                // Education filter
                if (education && !rowEducation.includes(education)) {
                    show = false;
                }

                // Date filter
                if (date && rowDate !== date) {
                    show = false;
                }

                if (show) {
                    row.show();
                } else {
                    row.hide();
                }
            });
        }

        function resetFilters() {
            $('#search').val('');
            $('#status-filter').val('');
            $('#education-filter').val('');
            $('#date-filter').val('');

            $('#applicants-table tbody tr').show();
        }

        function viewApplicant(applicationId) {
            $('#loadingOverlay').show();

            // Find the application data from the current applications
            const applications = @json($applications);
            const application = applications.find(app => app.id === applicationId);

            if (application) {
                const modalContent = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="icon-user"></i> Informasi Pribadi</h6>
                            <table class="table table-borderless">
                                <tr><td><strong>Nama:</strong></td><td>${application.user.name}</td></tr>
                                <tr><td><strong>Email:</strong></td><td>${application.user.email}</td></tr>
                                <tr><td><strong>No. HP:</strong></td><td>${application.phone_number || 'Tidak tersedia'}</td></tr>
                                <tr><td><strong>Pendidikan:</strong></td><td>${application.education_level}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="icon-briefcase"></i> Informasi Lamaran</h6>
                            <table class="table table-borderless">
                                <tr><td><strong>Status:</strong></td><td><span class="badge bg-${application.status === 'Diterima' ? 'success' : application.status === 'Ditolak' ? 'danger' : 'warning'}">${application.status}</span></td></tr>
                                <tr><td><strong>Tanggal Lamar:</strong></td><td>${new Date(application.created_at).toLocaleDateString('id-ID')}</td></tr>
                                <tr><td><strong>Gaji Diharapkan:</strong></td><td>${application.expected_salary || 'Tidak disebutkan'}</td></tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h6><i class="icon-file-text"></i> Cover Letter</h6>
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; max-height: 200px; overflow-y: auto;">
                            ${application.cover_letter || 'Tidak ada cover letter'}
                        </div>
                    </div>

                    <div class="mt-3">
                        <h6><i class="icon-award"></i> Skills</h6>
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                            ${application.skills || 'Tidak ada skills yang disebutkan'}
                        </div>
                    </div>

                    ${application.experience ? `
                        <div class="mt-3">
                            <h6><i class="icon-clock"></i> Pengalaman</h6>
                            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                                ${application.experience}
                            </div>
                        </div>
                    ` : ''}

                    ${application.additional_info ? `
                        <div class="mt-3">
                            <h6><i class="icon-info"></i> Informasi Tambahan</h6>
                            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                                ${application.additional_info}
                            </div>
                        </div>
                    ` : ''}

                    ${application.cv ? `
                        <div class="mt-3 text-center">
                            <a href="{{ asset('storage') }}/${application.cv}" class="btn btn-primary" target="_blank">
                                <i class="icon-cloud-download"></i> Download CV
                            </a>
                        </div>
                    ` : ''}
                `;

                $('#modal-content').html(modalContent);
                $('#applicantModal').modal('show');
            }

            $('#loadingOverlay').hide();
        }

        function updateStatus(applicationId, newStatus) {
            const statusText = newStatus === 'Diterima' ? 'menerima' : 'menolak';

            Swal.fire({
                title: 'Konfirmasi Status',
                text: `Apakah Anda yakin ingin ${statusText} pelamar ini?`,
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: `Ya, ${statusText.charAt(0).toUpperCase() + statusText.slice(1)}!`,
                confirmButtonColor: newStatus === 'Diterima' ? '#28a745' : '#dc3545'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#loadingOverlay').show();

                    $.ajax({
                        url: `/api/jobs/applications/${applicationId}/update`,
                        type: 'POST',
                        data: {
                            status: newStatus,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: `Status pelamar berhasil diperbarui menjadi ${newStatus}`,
                                icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(err) {
                            $('#loadingOverlay').hide();
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Gagal memperbarui status pelamar',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }

        function exportApplicants() {
            Swal.fire({
                title: 'Mengunduh File Excel...',
                text: 'Silakan tunggu, file sedang disiapkan untuk diunduh.',
                icon: 'info',
                timer: 2000,
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            }).then(() => {
                // Implement export functionality
                window.location.href = `/api/admin/jobs/{{ $jobId }}/applications/export`;
            });
        }
    </script>
@endsection

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

        /* Action Bar */
        .action-bar {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
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
        }

        .btn-add-new:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
            color: white;
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
        }

        .btn-reset:hover {
            background: #545b62;
            border-color: #545b62;
            color: white;
            transform: translateY(-1px);
        }

        .btn-export {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            white-space: nowrap;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        }

        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
            color: white;
        }

        .filter-info {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }

        .filter-info-text {
            font-size: 14px;
            color: #6c757d;
            margin: 0;
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
        }

        .table-title {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin: 0;
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

        /* User Table Styling */
        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 16px;
        }

        .user-info h6 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #495057;
        }

        .user-info .text-muted {
            font-size: 13px;
            margin-top: 2px;
        }

        .contact-info {
            font-size: 14px;
            line-height: 1.5;
        }

        .contact-info .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 3px;
        }

        .contact-info .contact-item:last-child {
            margin-bottom: 0;
        }

        .contact-info i {
            width: 16px;
            font-size: 14px;
            color: #6c757d;
        }

        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status-admin {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status-customer {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .status-verified {
            background: #d1f2eb;
            color: #0c5460;
            border: 1px solid #7dd3fc;
        }

        .status-unverified {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        /* Date Display */
        .date-display {
            font-size: 14px;
        }

        .date-main {
            font-weight: 600;
            color: #495057;
            margin-bottom: 2px;
        }

        .date-relative {
            font-size: 12px;
            color: #6c757d;
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
            background: transparent;
            border-color: #dc3545;
            color: #dc3545;
        }

        .btn-delete:hover {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
            transform: translateY(-1px);
        }

        /* Bulk Actions */
        .bulk-actions-bar {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            display: none;
        }

        .bulk-actions-bar.active {
            display: block;
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

        /* Pagination */
        .pagination-container {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .pagination-info {
            font-size: 14px;
            color: #6c757d;
        }

        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            border-radius: 6px;
            margin: 0 2px;
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .filter-buttons {
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }

            .filter-buttons .btn {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .page-header,
            .filter-section,
            .table-section {
                padding: 20px;
            }

            .summary-card {
                padding: 20px;
                margin-bottom: 15px;
            }

            .action-group {
                flex-direction: column;
                gap: 5px;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }

            .table-responsive {
                font-size: 14px;
            }
        }

        @media (max-width: 576px) {
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 15px;
            }

            .btn-add-new {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Manajemen Data Pengguna</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Data Pengguna</div>
                    </li>
                </ul>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="page-title">Kelola Data Pengguna</h4>
                        <p class="text-muted mb-0">Manajemen lengkap data pengguna sistem</p>
                    </div>
                    <a href="{{ route('admin.data-pengguna.create') }}" class="btn-add-new">
                        <i class="icon-plus"></i> Tambah Pengguna
                    </a>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="summary-section">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-primary">
                                <i class="icon-users"></i>
                            </div>
                            <div class="summary-number">{{ number_format($stats['total_users']) }}</div>
                            <div class="summary-label">Total Pengguna</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-info">
                                <i class="icon-user"></i>
                            </div>
                            <div class="summary-number">{{ number_format($stats['total_customers']) }}</div>
                            <div class="summary-label">Customer</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-success">
                                <i class="icon-check-circle"></i>
                            </div>
                            <div class="summary-number">{{ number_format($stats['verified_users']) }}</div>
                            <div class="summary-label">Terverifikasi</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-warning">
                                <i class="icon-activity"></i>
                            </div>
                            <div class="summary-number">{{ number_format($stats['active_today']) }}</div>
                            <div class="summary-label">Aktif Hari Ini</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="icon-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="icon-alert-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-header">
                    <h5 class="filter-title">
                        <i class="icon-filter"></i> Filter & Pencarian Data
                    </h5>
                </div>

                <form method="GET" action="{{ route('admin.data-pengguna.index') }}" id="filterForm">
                    <div class="row g-3">
                        <!-- Search -->
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Cari Pengguna</label>
                            <div class="search-container">
                                <i class="icon-search search-icon"></i>
                                <input type="text" name="search" class="form-control search-input"
                                    placeholder="Nama, email, atau HP..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <!-- User Type Filter -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Tipe User</label>
                            <select name="utype" class="form-select">
                                <option value="">Semua Tipe</option>
                                <option value="USR" {{ request('utype') === 'USR' ? 'selected' : '' }}>Customer</option>
                                <option value="ADM" {{ request('utype') === 'ADM' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <!-- Verification Status -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Status Verifikasi</label>
                            <select name="verification_status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="verified" {{ request('verification_status') === 'verified' ? 'selected' : '' }}>
                                    Terverifikasi</option>
                                <option value="unverified" {{ request('verification_status') === 'unverified' ? 'selected' : '' }}>
                                    Belum Verifikasi</option>
                            </select>
                        </div>

                        <!-- Date From -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>

                        <!-- Date To -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-lg-1 col-md-6">
                            <label class="form-label">&nbsp;</label>
                            <div class="filter-buttons">
                                <button type="submit" class="btn btn-filter" title="Terapkan Filter">
                                    <i class="icon-search"></i>
                                </button>
                                <a href="{{ route('admin.data-pengguna.index') }}" class="btn btn-reset" title="Reset Filter">
                                    <i class="icon-refresh-cw"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Info & Export -->
                    <div class="filter-info">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="filter-info-text">
                                <i class="icon-info"></i>
                                Menampilkan <strong>{{ $users->count() }}</strong> dari
                                <strong>{{ $users->total() }}</strong> pengguna
                                @if (request()->hasAny(['search', 'utype', 'verification_status', 'date_from', 'date_to']))
                                    dengan filter yang diterapkan
                                @endif
                            </p>
                            <a href="{{ route('admin.data-pengguna.export', request()->query()) }}"
                                class="btn btn-export" title="Download Data CSV">
                                <i class="icon-download"></i> Export CSV
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Bulk Actions -->
            <form id="bulkActionForm" method="POST" action="{{ route('admin.data-pengguna.bulk-action') }}">
                @csrf
                <div class="bulk-actions-bar" id="bulkActionsBar">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <span class="fw-bold">Aksi Bulk:</span>
                            <select name="action" class="form-select form-select-sm" style="width: auto;">
                                <option value="">Pilih Aksi...</option>
                                <option value="verify">Verifikasi Email</option>
                                <option value="unverify">Cabut Verifikasi</option>
                                <option value="delete">Hapus Pengguna</option>
                            </select>
                            <button type="submit" class="btn btn-warning btn-sm">
                                Jalankan
                            </button>
                        </div>
                        <span class="selected-count text-muted"></span>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="table-section">
                    <div class="table-header">
                        <h5 class="table-title">
                            <i class="icon-list"></i> Daftar Pengguna
                        </h5>
                    </div>

                    <div class="table-responsive">
                        @if ($users->count() > 0)
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
                                        <th width="5%">#</th>
                                        <th width="25%">Pengguna</th>
                                        <th width="20%">Kontak</th>
                                        <th width="10%">Tipe</th>
                                        <th width="12%">Status</th>
                                        <th width="8%">Alamat</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                                                    class="form-check-input user-checkbox">
                                            </td>
                                            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>

                                            <!-- User Info -->
                                            <td>
                                                <div class="user-profile">
                                                    @if ($user->profile_picture)
                                                        <img src="{{ asset($user->profile_picture) }}" alt="{{ $user->name }}"
                                                            class="user-avatar" style="background: #007bff;">
                                                    @else
                                                        <div class="user-avatar" style="background: #007bff;">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                    <div class="user-info">
                                                        <h6>{{ $user->name }}</h6>
                                                        @if ($user->bio)
                                                            <div class="text-muted">{{ Str::limit($user->bio, 30) }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Contact Info -->
                                            <td>
                                                <div class="contact-info">
                                                    <div class="contact-item">
                                                        <i class="icon-mail"></i>
                                                        <span>{{ $user->email }}</span>
                                                    </div>
                                                    @if ($user->mobile)
                                                        <div class="contact-item">
                                                            <i class="icon-phone"></i>
                                                            <span>{{ $user->mobile }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- User Type -->
                                            <td>
                                                @if ($user->utype === 'ADM')
                                                    <span class="status-badge status-admin">
                                                        <i class="icon-shield"></i> Admin
                                                    </span>
                                                @else
                                                    <span class="status-badge status-customer">
                                                        <i class="icon-user"></i> Customer
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Verification Status -->
                                            <td>
                                                @if ($user->email_verified_at)
                                                    <span class="status-badge status-verified">
                                                        <i class="icon-check"></i> Terverifikasi
                                                    </span>
                                                @else
                                                    <span class="status-badge status-unverified">
                                                        <i class="icon-clock"></i> Belum Verifikasi
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Address Count -->
                                            <td class="text-center">
                                                <span class="badge bg-info fs-6">{{ $user->addresses_count }}</span>
                                            </td>

                                            <!-- Actions -->
                                            <td>
                                                <div class="action-group">
                                                    <a href="{{ route('admin.data-pengguna.show', $user->id) }}"
                                                        class="btn-action btn-view" title="Lihat Detail">
                                                        <i class="icon-eye"></i> Detail
                                                    </a>
                                                    <a href="{{ route('admin.data-pengguna.edit', $user->id) }}"
                                                        class="btn-action btn-edit" title="Edit Pengguna">
                                                        <i class="icon-edit"></i> Edit
                                                    </a>
                                                    @if ($user->id !== auth()->id())
                                                        <button type="button" class="btn-action btn-delete"
                                                            onclick="deleteUser({{ $user->id }})" title="Hapus Pengguna">
                                                            <i class="icon-trash"></i> Hapus
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <div class="empty-state">
                                                    <div class="empty-icon">
                                                        <i class="icon-users"></i>
                                                    </div>
                                                    <h4 class="empty-title">Tidak Ada Pengguna Ditemukan</h4>
                                                    <p class="empty-text">
                                                        @if (request()->hasAny(['search', 'utype', 'verification_status']))
                                                            Tidak ada pengguna yang sesuai dengan filter yang diterapkan.<br>
                                                            Coba ubah atau reset filter untuk melihat data lainnya.
                                                        @else
                                                            Belum ada pengguna yang terdaftar.<br>
                                                            Tambahkan pengguna pertama untuk memulai.
                                                        @endif
                                                    </p>
                                                    @if (!request()->hasAny(['search', 'utype', 'verification_status']))
                                                        <a href="{{ route('admin.data-pengguna.create') }}" class="btn btn-filter">
                                                            <i class="icon-plus"></i> Tambah Pengguna Pertama
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="icon-users"></i>
                                </div>
                                <h4 class="empty-title">Tidak Ada Pengguna Ditemukan</h4>
                                <p class="empty-text">
                                    @if (request()->hasAny(['search', 'utype', 'verification_status']))
                                        Tidak ada pengguna yang sesuai dengan filter yang diterapkan.<br>
                                        Coba ubah atau reset filter untuk melihat data lainnya.
                                    @else
                                        Belum ada pengguna yang terdaftar.<br>
                                        Tambahkan pengguna pertama untuk memulai.
                                    @endif
                                </p>
                                @if (!request()->hasAny(['search', 'utype', 'verification_status']))
                                    <a href="{{ route('admin.data-pengguna.create') }}" class="btn btn-filter">
                                        <i class="icon-plus"></i> Tambah Pengguna Pertama
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    @if ($users->hasPages())
                        <div class="pagination-container">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="pagination-info">
                                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }}
                                    dari {{ $users->total() }} pengguna
                                </div>
                                {{ $users->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Form (Hidden) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Toggle Verification Form (Hidden) -->
    <form id="verificationForm" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Bulk Actions
            const selectAllCheckbox = document.getElementById('selectAll');
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            const bulkActionsBar = document.getElementById('bulkActionsBar');
            const selectedCount = document.querySelector('.selected-count');

            function updateBulkActions() {
                const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');

                if (checkedBoxes.length > 0) {
                    bulkActionsBar.classList.add('active');
                    selectedCount.textContent = `${checkedBoxes.length} item dipilih`;
                } else {
                    bulkActionsBar.classList.remove('active');
                }

                // Update select all checkbox state
                const totalCheckboxes = userCheckboxes.length;
                selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < totalCheckboxes;
                selectAllCheckbox.checked = checkedBoxes.length === totalCheckboxes;
            }

            selectAllCheckbox.addEventListener('change', function() {
                userCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkActions();
            });

            userCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActions);
            });

            // Delete User
            window.deleteUser = function(userId) {
                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: 'Apakah Anda yakin ingin menghapus pengguna ini? Data yang dihapus tidak dapat dikembalikan.',
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
                        const form = document.getElementById('deleteForm');
                        form.action = `/admin/data-pengguna/${userId}`;
                        form.submit();
                    }
                });
            };

            // Toggle Verification
            window.toggleVerification = function(userId) {
                const form = document.getElementById('verificationForm');
                form.action = `/admin/data-pengguna/${userId}/toggle-verification`;
                form.submit();
            };

            // Bulk Action Form Validation
            document.getElementById('bulkActionForm').addEventListener('submit', function(e) {
                const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
                const actionSelect = document.querySelector('select[name="action"]');

                if (checkedBoxes.length === 0) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Peringatan',
                        text: 'Pilih minimal satu pengguna untuk melakukan aksi bulk.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                if (!actionSelect.value) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Peringatan',
                        text: 'Pilih aksi yang ingin dilakukan.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Additional confirmation for delete action
                if (actionSelect.value === 'delete') {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi Penghapusan Massal',
                        text: `Yakin ingin menghapus ${checkedBoxes.length} pengguna yang dipilih? Aksi ini tidak dapat dibatalkan.`,
                        icon: 'warning',
                        iconColor: '#f39c12',
                        showCancelButton: true,
                        reverseButtons: true,
                        focusCancel: true,
                        cancelButtonText: 'Batal',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Hapus Semua!',
                        confirmButtonColor: '#e74c3c'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                }
            });

            // Success/Error messages
            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    iconColor: '#28a745',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#28a745'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    iconColor: '#e74c3c',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#e74c3c'
                });
            @endif
        });
    </script>
@endsection

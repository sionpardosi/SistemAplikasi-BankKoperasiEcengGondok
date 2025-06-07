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

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Table Content Styling */
        .supplier-name {
            font-weight: 700;
            color: #495057;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .supplier-contact {
            font-size: 13px;
            color: #6c757d;
            line-height: 1.3;
        }

        .location-main {
            font-weight: 600;
            color: #495057;
            font-size: 15px;
            margin-bottom: 2px;
        }

        .location-detail {
            font-size: 13px;
            color: #6c757d;
        }

        .quantity-value {
            font-weight: 700;
            color: #007bff;
            font-size: 16px;
            margin-bottom: 2px;
        }

        .quantity-estimate {
            font-size: 12px;
            color: #28a745;
            font-weight: 600;
        }

        .date-main {
            font-weight: 600;
            color: #495057;
            font-size: 15px;
            margin-bottom: 2px;
        }

        .date-time {
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

        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-disetujui {
            background: #d1f2eb;
            color: #0c5460;
            border: 1px solid #7dd3fc;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .incentive-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            display: inline-block;
            margin-bottom: 4px;
        }

        .incentive-discount {
            background: #e3f2fd;
            color: #1565c0;
            border: 1px solid #bbdefb;
        }

        .incentive-cash {
            background: #e8f5e8;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .coupon-info {
            font-size: 11px;
            color: #6c757d;
            font-weight: 500;
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

        .btn-manage {
            background: #007bff;
            border-color: #007bff;
            color: white;
        }

        .btn-manage:hover {
            background: #0056b3;
            border-color: #0056b3;
            color: white;
            transform: translateY(-1px);
        }

        .btn-photo {
            background: #17a2b8;
            border-color: #17a2b8;
            color: white;
        }

        .btn-photo:hover {
            background: #138496;
            border-color: #138496;
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
                <h3>Kelola Permintaan Pemasok Bahan Baku Eceng Gondok</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.supplier.index') }}">
                            <div class="text-tiny">Pemasok</div>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="page-title">Manajemen Request Pemasok</h4>
                        <p class="text-muted mb-0">Kelola dan review semua permintaan pasokan eceng gondok</p>
                    </div>
                    <a href="{{ route('admin.supplier.request.add') }}" class="btn-add-new">
                        <i class="icon-plus"></i> Tambah Request Baru
                    </a>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="summary-section">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-info">
                                <i class="icon-layers"></i>
                            </div>
                            <div class="summary-number">{{ $requests->total() }}</div>
                            <div class="summary-label">Total Request</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-warning">
                                <i class="icon-clock"></i>
                            </div>
                            <div class="summary-number">{{ $requests->where('status', 'pending')->count() }}</div>
                            <div class="summary-label">Menunggu Review</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-success">
                                <i class="icon-check"></i>
                            </div>
                            <div class="summary-number">{{ $requests->where('status', 'disetujui')->count() }}</div>
                            <div class="summary-label">Disetujui</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-danger">
                                <i class="bx bx-x-circle"></i>
                                <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
                            </div>
                            <div class="summary-number">{{ $requests->where('status', 'ditolak')->count() }}</div>
                            <div class="summary-label">Ditolak</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-header">
                    <h5 class="filter-title">
                        <i class="icon-equalizer"></i> Filter & Pencarian Data
                    </h5>
                </div>

                <form method="GET" id="filterForm">
                    <div class="row g-3">
                        <!-- Search -->
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Cari Nama atau Email</label>
                            <div class="search-container">
                                <i class="icon-magnifier search-icon"></i>
                                <input type="text" name="nama" class="form-control search-input"
                                    placeholder="Ketik nama atau email..." value="{{ request('nama') }}">
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Status Request</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>
                                    Disetujui
                                </option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                                    Ditolak
                                </option>
                            </select>
                        </div>

                        <!-- Location Filter -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" placeholder="Nama kecamatan..."
                                value="{{ request('kecamatan') }}">
                        </div>

                        <!-- Date From -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="tanggal_dari" class="form-control"
                                value="{{ request('tanggal_dari') }}">
                        </div>

                        <!-- Date To -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="tanggal_sampai" class="form-control"
                                value="{{ request('tanggal_sampai') }}">
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-lg-1 col-md-6">
                            <label class="form-label">&nbsp;</label>
                            <div class="filter-buttons">
                                <button type="submit" class="btn btn-filter" title="Terapkan Filter">
                                    <i class="bx bx-search"></i>
                                </button>
                                <a href="{{ route('admin.supplier.index') }}" class="btn btn-reset" title="Reset Filter">
                                    <i class="icon-refresh"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Info & Export -->
                    <div class="filter-info">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="filter-info-text">
                                <i class="icon-info"></i>
                                Menampilkan <strong>{{ $requests->count() }}</strong> dari
                                <strong>{{ $requests->total() }}</strong> request
                                @if (request()->hasAny(['nama', 'status', 'kecamatan', 'tanggal_dari', 'tanggal_sampai']))
                                    dengan filter yang diterapkan
                                @endif
                            </p>
                            <a href="{{ route('admin.supplier.request.export', request()->query()) }}"
                                class="btn btn-export" title="Download Data Excel">
                                <i class="icon-cloud-download"></i> Export Excel
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="table-section">
                <div class="table-header">
                    <h5 class="table-title">
                        <i class="icon-list"></i> Daftar Request Pemasok
                    </h5>
                </div>

                <div class="table-responsive">
                    @if ($requests->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="12%">Tanggal</th>
                                    <th width="22%">Pemasok</th>
                                    <th width="18%">Lokasi</th>
                                    <th width="12%">Jumlah</th>
                                    <th width="12%">Insentif</th>
                                    <th width="10%">Status</th>
                                    <th width="14%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $req)
                                    <tr>
                                        <!-- Tanggal -->
                                        <td>
                                            <div class="date-main">{{ $req->created_at->format('d M Y') }}</div>
                                            <div class="date-time">{{ $req->created_at->format('H:i') }} WIB</div>
                                        </td>

                                        <!-- Pemasok Info -->
                                        <td>
                                            <div class="supplier-name">{{ $req->nama }}</div>
                                            <div class="supplier-contact">
                                                <i class="icon-envelope"></i> {{ $req->email }}
                                                @if ($req->no_hp || $req->no_wa)
                                                    <br><i class="icon-phone"></i> {{ $req->no_hp ?? $req->no_wa }}
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Lokasi -->
                                        <td>
                                            @if ($req->kecamatan || $req->desa)
                                                <div class="location-main">{{ $req->kecamatan ?? '-' }}</div>
                                                <div class="location-detail">{{ $req->desa ?? '-' }}</div>
                                            @else
                                                <div class="location-main">{{ $req->lokasi ?? '-' }}</div>
                                            @endif
                                        </td>

                                        <!-- Jumlah -->
                                        <td>
                                            <div class="quantity-value">{{ $req->estimasi_kg }} kg</div>
                                            @if ($req->insentif == 'uang_tunai')
                                                <div class="quantity-estimate">
                                                    ~Rp {{ number_format($req->estimasi_kg * 60000, 0, ',', '.') }}
                                                </div>
                                            @endif
                                        </td>

                                        <!-- Insentif -->
                                        <td>
                                            @if ($req->insentif == 'diskon')
                                                <span class="incentive-badge incentive-discount">
                                                    <i class="icon-credit-card"></i> Diskon
                                                </span>
                                                @if ($req->kupon_id && $req->kupon)
                                                    <div class="coupon-info">{{ $req->kupon->code }}</div>
                                                @endif
                                            @else
                                                <span class="incentive-badge incentive-cash">
                                                    <i class="icon-wallet"></i> Tunai
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Status -->
                                        <td>
                                            @switch($req->status)
                                                @case('pending')
                                                    <span class="status-badge status-pending">
                                                        <i class="icon-clock"></i> Pending
                                                    </span>
                                                @break

                                                @case('disetujui')
                                                    <span class="status-badge status-disetujui">
                                                        <i class="icon-check"></i> Disetujui
                                                    </span>
                                                @break

                                                @case('ditolak')
                                                    <span class="status-badge status-ditolak">
                                                        <i class="icon-close"></i> Ditolak
                                                    </span>
                                                @break
                                            @endswitch
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <div class="action-group">
                                                <a href="{{ route('admin.supplier.request.edit', $req->id) }}"
                                                    class="btn-action btn-manage" title="Kelola Request">
                                                    <i class="icon-pencil"></i> Kelola
                                                </a>

                                                @if ($req->foto)
                                                    <button type="button" class="btn-action btn-photo"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#photoModal{{ $req->id }}"
                                                        title="Lihat Foto Bukti">
                                                        <i class="bx bx-image"></i>
                                                    </button>
                                                @endif

                                                <form method="POST"
                                                    action="{{ route('admin.supplier.request.delete', $req->id) }}"
                                                    class="d-inline delete-form">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn-action btn-delete delete-button"
                                                        title="Hapus Request">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="icon-folder"></i>
                            </div>
                            <h4 class="empty-title">Tidak Ada Request Ditemukan</h4>
                            <p class="empty-text">
                                @if (request()->hasAny(['nama', 'status', 'kecamatan', 'tanggal_dari', 'tanggal_sampai']))
                                    Tidak ada request yang sesuai dengan filter yang diterapkan.<br>
                                    Coba ubah atau reset filter untuk melihat data lainnya.
                                @else
                                    Belum ada request pemasok yang terdaftar.<br>
                                    Tambahkan request pertama untuk memulai.
                                @endif
                            </p>
                            @if (!request()->hasAny(['nama', 'status', 'kecamatan', 'tanggal_dari', 'tanggal_sampai']))
                                <a href="{{ route('admin.supplier.request.add') }}" class="btn btn-filter">
                                    <i class="icon-plus"></i> Tambah Request Pertama
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if ($requests->hasPages())
                    <div class="pagination-container">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pagination-info">
                                Menampilkan {{ $requests->firstItem() }} - {{ $requests->lastItem() }}
                                dari {{ $requests->total() }} request
                            </div>
                            {{ $requests->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Photo Modals -->
    @foreach ($requests as $req)
        @if ($req->foto)
            <div class="modal fade" id="photoModal{{ $req->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="icon-picture"></i> Foto Bukti Eceng Gondok - {{ $req->nama }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="{{ asset($req->foto) }}" class="img-fluid" alt="Foto Bukti"
                                style="border-radius: 8px; max-height: 500px;">
                            <div class="mt-3">
                                <p class="text-muted">
                                    <strong>Estimasi:</strong> {{ $req->estimasi_kg }} kg |
                                    <strong>Upload:</strong> {{ $req->created_at->format('d M Y, H:i') }} WIB
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

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
        document.addEventListener('DOMContentLoaded', function() {
            // Delete confirmation
            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const form = this.closest('.delete-form');

                    Swal.fire({
                        title: 'Konfirmasi Penghapusan',
                        text: 'Apakah Anda yakin ingin menghapus request ini? Data yang dihapus tidak dapat dikembalikan.',
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
                            // Show loading
                            document.getElementById('loadingOverlay').style.display =
                            'flex';
                            form.submit();
                        }
                    });
                });
            });

            // Form submission with loading
            const filterForm = document.getElementById('filterForm');
            filterForm.addEventListener('submit', function() {
                document.getElementById('loadingOverlay').style.display = 'flex';
            });

            // Export button loading
            const exportBtn = document.querySelector('.btn-export');
            if (exportBtn) {
                exportBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.href;

                    Swal.fire({
                        title: 'Mengunduh File Excel...',
                        text: 'Silakan tunggu, file sedang disiapkan untuk diunduh.',
                        icon: 'info',
                        iconColor: '#17a2b8',
                        timer: 2000,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    }).then(() => {
                        window.location.href = url;
                    });
                });
            }

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

            // Hide loading on page load
            window.addEventListener('load', function() {
                document.getElementById('loadingOverlay').style.display = 'none';
            });
        });
    </script>
@endsection

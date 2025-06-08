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
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
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
            text-decoration: none;
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
            text-decoration: none;
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

        /* Coupon Code Styling */
        .coupon-code {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            color: #007bff;
            font-size: 16px;
            background: #e3f2fd;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px dashed #007bff;
            display: inline-block;
            margin-bottom: 4px;
        }

        .coupon-description {
            font-size: 13px;
            color: #6c757d;
            font-weight: 500;
        }

        /* Amount Styling */
        .amount-value {
            font-weight: 700;
            color: #28a745;
            font-size: 16px;
            margin-bottom: 2px;
        }

        .amount-minimum {
            font-size: 13px;
            color: #6c757d;
            font-weight: 500;
        }

        /* Date Styling */
        .date-main {
            font-weight: 600;
            color: #495057;
            font-size: 15px;
            margin-bottom: 2px;
        }

        .date-relative {
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

        .status-active {
            background: #d1f2eb;
            color: #0c5460;
            border: 1px solid #7dd3fc;
        }

        .status-expired {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status-inactive {
            background: #e2e3e5;
            color: #383d41;
            border: 1px solid #c6c8ca;
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

        .btn-toggle {
            background: #17a2b8;
            border-color: #17a2b8;
            color: white;
        }

        .btn-toggle:hover {
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
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            font-size: 16px;
            color: #495057;
            font-weight: 600;
        }

        /* Alert Styling */
        .alert-success {
            background: #d1f2eb;
            border: 1px solid #7dd3fc;
            color: #0c5460;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            font-size: 15px;
            font-weight: 600;
        }

        /* Bulk Actions */
        .bulk-actions {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            display: none;
        }

        .bulk-actions.show {
            display: flex;
            align-items: center;
            gap: 15px;
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
                justify-content: center;
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Manajemen Kupon Diskon Produk</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Kupon Diskon</div>
                    </li>
                </ul>
            </div>

            <!-- Success Alert -->
            @if (Session::has('status'))
                <div class="alert-success">
                    <i class="icon-check-circle"></i> {{ Session::get('status') }}
                </div>
            @endif

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="page-title">Kelola Kupon Diskon</h4>
                        <p class="text-muted mb-0">Manajemen kupon diskon untuk meningkatkan penjualan produk</p>
                    </div>
                    <a href="{{ route('admin.coupon.add') }}" class="btn-add-new">
                        <i class="icon-credit-card"></i> Buat Kupon Baru
                    </a>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="summary-section">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-info">
                                <i class="icon-credit-card"></i>
                            </div>
                            <div class="summary-number">{{ $coupons->total() }}</div>
                            <div class="summary-label">Total Kupon</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-success">
                                <i class="icon-check"></i>
                            </div>
                            <div class="summary-number">{{ $coupons->where('is_active', true)->where('expiry_date', '>=', now())->count() }}</div>
                            <div class="summary-label">Kupon Aktif</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-warning">
                                <i class="icon-clock"></i>
                            </div>
                            <div class="summary-number">{{ $coupons->where('expiry_date', '<=', now()->addDays(7))->where('expiry_date', '>=', now())->count() }}</div>
                            <div class="summary-label">Segera Berakhir</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-danger">
                                <i class="icon-close"></i>
                            </div>
                            <div class="summary-number">{{ $coupons->where('expiry_date', '<', now())->count() }}</div>
                            <div class="summary-label">Kadaluarsa</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-header">
                    <h5 class="filter-title">
                        <i class="icon-equalizer"></i> Filter & Pencarian Kupon
                    </h5>
                </div>

                <form method="GET" id="filterForm">
                    <div class="row g-3">
                        <!-- Search -->
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Cari Kode Kupon</label>
                            <div class="search-container">
                                <i class="icon-magnifier search-icon"></i>
                                <input type="text" name="search" class="form-control search-input"
                                    placeholder="Ketik kode kupon..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Status Kupon</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>
                                    Kadaluarsa
                                </option>
                                <option value="soon_expire" {{ request('status') == 'soon_expire' ? 'selected' : '' }}>
                                    Segera Berakhir
                                </option>
                            </select>
                        </div>

                        <!-- Amount Filter -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Nilai Diskon</label>
                            <select name="amount_range" class="form-select">
                                <option value="">Semua Nilai</option>
                                <option value="small" {{ request('amount_range') == 'small' ? 'selected' : '' }}>
                                    &lt; Rp 50.000
                                </option>
                                <option value="medium" {{ request('amount_range') == 'medium' ? 'selected' : '' }}>
                                    Rp 50.000 - Rp 200.000
                                </option>
                                <option value="large" {{ request('amount_range') == 'large' ? 'selected' : '' }}>
                                    &gt; Rp 200.000
                                </option>
                            </select>
                        </div>

                        <!-- Date From -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Berakhir Dari</label>
                            <input type="date" name="date_from" class="form-control"
                                value="{{ request('date_from') }}">
                        </div>

                        <!-- Date To -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Berakhir Sampai</label>
                            <input type="date" name="date_to" class="form-control"
                                value="{{ request('date_to') }}">
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-lg-1 col-md-6">
                            <label class="form-label">&nbsp;</label>
                            <div class="filter-buttons">
                                <button type="submit" class="btn btn-filter" title="Terapkan Filter">
                                    <i class="icon-search"></i>
                                </button>
                                {{-- <a href="{{ route('admin.coupons') }}" class="btn btn-reset" title="Reset Filter">
                                    <i class="icon-refresh"></i>
                                </a> --}}
                            </div>
                        </div>
                    </div>

                    <!-- Filter Info & Export -->
                    <div class="filter-info">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="filter-info-text">
                                <i class="icon-info"></i>
                                Menampilkan <strong>{{ $coupons->count() }}</strong> dari
                                <strong>{{ $coupons->total() }}</strong> kupon
                                @if (request()->hasAny(['search', 'status', 'amount_range', 'date_from', 'date_to']))
                                    dengan filter yang diterapkan
                                @endif
                            </p>
                            <a href="#" class="btn btn-export" title="Download Data Excel" id="exportBtn">
                                <i class="icon-cloud-download"></i> Export Excel
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Bulk Actions -->
            <div class="bulk-actions" id="bulkActions">
                <input type="checkbox" id="selectAll">
                <span id="selectedCount">0</span> kupon dipilih
                <button type="button" class="btn btn-warning btn-sm" id="bulkToggleStatus">
                    <i class="icon-refresh"></i> Toggle Status
                </button>
                <button type="button" class="btn btn-danger btn-sm" id="bulkDelete">
                    <i class="icon-trash"></i> Hapus Terpilih
                </button>
            </div>

            <!-- Table Section -->
            <div class="table-section">
                <div class="table-header">
                    <h5 class="table-title">
                        <i class="icon-list"></i> Daftar Kupon Diskon
                    </h5>
                </div>

                <div class="table-responsive">
                    @if ($coupons->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">
                                        <input type="checkbox" id="masterCheckbox">
                                    </th>
                                    <th width="20%">Kode Kupon</th>
                                    <th width="15%">Nilai Diskon</th>
                                    <th width="15%">Min. Pembelian</th>
                                    <th width="15%">Berakhir</th>
                                    <th width="10%">Status</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                    <tr>
                                        <!-- Checkbox -->
                                        <td>
                                            <input type="checkbox" class="coupon-checkbox" value="{{ $coupon->id }}">
                                        </td>

                                        <!-- Kode Kupon -->
                                        <td>
                                            <div class="coupon-code">{{ $coupon->code }}</div>
                                            <div class="coupon-description">
                                                ID: #{{ $coupon->id }} |
                                                Dibuat: {{ $coupon->created_at->format('d M Y') }}
                                            </div>
                                        </td>

                                        <!-- Nilai Diskon -->
                                        <td>
                                            <div class="amount-value">{{ formatRupiah($coupon->discount_amount) }}</div>
                                            <div class="amount-minimum">
                                                @if($coupon->discount_amount >= 200000)
                                                    <span class="badge" style="background: #e8f5e8; color: #2e7d32;">Tinggi</span>
                                                @elseif($coupon->discount_amount >= 50000)
                                                    <span class="badge" style="background: #fff3cd; color: #856404;">Sedang</span>
                                                @else
                                                    <span class="badge" style="background: #e3f2fd; color: #1565c0;">Rendah</span>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Minimum Order -->
                                        <td>
                                            <div class="amount-value">{{ formatRupiah($coupon->minimum_order) }}</div>
                                            <div class="amount-minimum">
                                                @if($coupon->minimum_order == 0)
                                                    Tanpa minimum
                                                @else
                                                    Minimum order
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Tanggal Berakhir -->
                                        <td>
                                            <div class="date-main">{{ $coupon->expiry_date->format('d M Y') }}</div>
                                            <div class="date-relative">
                                                @php
                                                    $daysLeft = now()->diffInDays($coupon->expiry_date, false);
                                                @endphp
                                                @if($daysLeft < 0)
                                                    {{ abs($daysLeft) }} hari lalu
                                                @elseif($daysLeft == 0)
                                                    Hari ini
                                                @else
                                                    {{ $daysLeft }} hari lagi
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Status -->
                                        <td>
                                            @if($coupon->isValid())
                                                <span class="status-badge status-active">
                                                    <i class="icon-check"></i> Aktif
                                                </span>
                                            @elseif($coupon->expiry_date < now())
                                                <span class="status-badge status-expired">
                                                    <i class="icon-clock"></i> Kadaluarsa
                                                </span>
                                            @else
                                                <span class="status-badge status-inactive">
                                                    <i class="icon-close"></i> Tidak Aktif
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <div class="action-group">
                                                <a href="{{ route('admin.coupon.edit', ['id' => $coupon->id]) }}"
                                                    class="btn-action btn-edit" title="Edit Kupon">
                                                    <i class="icon-edit-3"></i> Edit
                                                </a>

                                                <button type="button" class="btn-action btn-toggle toggle-status-btn"
                                                    data-id="{{ $coupon->id }}" data-status="{{ $coupon->is_active }}"
                                                    title="Toggle Status">
                                                    <i class="icon-refresh"></i>
                                                    {{ $coupon->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>

                                                <button type="button" class="btn-action btn-delete delete-btn"
                                                    data-id="{{ $coupon->id }}" data-code="{{ $coupon->code }}"
                                                    title="Hapus Kupon">
                                                    <i class="icon-trash-2"></i> Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="icon-credit-card"></i>
                            </div>
                            <h4 class="empty-title">Belum Ada Kupon Diskon</h4>
                            <p class="empty-text">
                                @if (request()->hasAny(['search', 'status', 'amount_range', 'date_from', 'date_to']))
                                    Tidak ada kupon yang sesuai dengan filter yang diterapkan.<br>
                                    Coba ubah atau reset filter untuk melihat data lainnya.
                                @else
                                    Belum ada kupon diskon yang dibuat.<br>
                                    Buat kupon pertama untuk memulai program diskon.
                                @endif
                            </p>
                            @if (!request()->hasAny(['search', 'status', 'amount_range', 'date_from', 'date_to']))
                                <a href="{{ route('admin.coupon.add') }}" class="btn btn-filter">
                                    <i class="icon-credit-card"></i> Buat Kupon Pertama
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if ($coupons->hasPages())
                    <div class="pagination-container">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pagination-info">
                                Menampilkan {{ $coupons->firstItem() }} - {{ $coupons->lastItem() }}
                                dari {{ $coupons->total() }} kupon
                            </div>
                            {{ $coupons->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
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

    <!-- Hidden Forms for Actions -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <form id="toggleForm" method="POST" style="display: none;">
        @csrf
        @method('PUT')
        <input type="hidden" name="toggle_status" value="1">
    </form>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Checkbox functionality
            const masterCheckbox = document.getElementById('masterCheckbox');
            const couponCheckboxes = document.querySelectorAll('.coupon-checkbox');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');

            function updateBulkActions() {
                const checkedBoxes = document.querySelectorAll('.coupon-checkbox:checked');
                selectedCount.textContent = checkedBoxes.length;

                if (checkedBoxes.length > 0) {
                    bulkActions.classList.add('show');
                } else {
                    bulkActions.classList.remove('show');
                }
            }

            masterCheckbox.addEventListener('change', function() {
                couponCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkActions();
            });

            couponCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActions);
            });

            // Delete functionality
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const couponId = this.getAttribute('data-id');
                    const couponCode = this.getAttribute('data-code');

                    Swal.fire({
                        title: 'Konfirmasi Penghapusan',
                        html: `Apakah Anda yakin ingin menghapus kupon <strong>${couponCode}</strong>?<br><small class="text-muted">Data yang dihapus tidak dapat dikembalikan.</small>`,
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
                            document.getElementById('loadingOverlay').style.display = 'flex';
                            const form = document.getElementById('deleteForm');
                            form.action = `/admin/coupon/${couponId}/delete`;
                            form.submit();
                        }
                    });
                });
            });

            // Toggle status functionality
            const toggleButtons = document.querySelectorAll('.toggle-status-btn');
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const couponId = this.getAttribute('data-id');
                    const isActive = this.getAttribute('data-status') === '1';
                    const action = isActive ? 'nonaktifkan' : 'aktifkan';

                    Swal.fire({
                        title: `Konfirmasi ${action.charAt(0).toUpperCase() + action.slice(1)}`,
                        text: `Apakah Anda yakin ingin ${action} kupon ini?`,
                        icon: 'question',
                        iconColor: '#17a2b8',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: `Ya, ${action.charAt(0).toUpperCase() + action.slice(1)}!`,
                        confirmButtonColor: '#17a2b8'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('loadingOverlay').style.display = 'flex';
                            const form = document.getElementById('toggleForm');
                            form.action = `/admin/coupon/${couponId}/toggle`;
                            form.submit();
                        }
                    });
                });
            });

            // Export functionality
            const exportBtn = document.getElementById('exportBtn');
            exportBtn.addEventListener('click', function(e) {
                e.preventDefault();

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
                    // Simulate download - replace with actual export URL
                    Swal.fire({
                        title: 'Fitur Segera Hadir!',
                        text: 'Fitur export Excel akan segera tersedia.',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                });
            });

            // Filter form submission with loading
            const filterForm = document.getElementById('filterForm');
            filterForm.addEventListener('submit', function() {
                document.getElementById('loadingOverlay').style.display = 'flex';
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

            // Hide loading on page load
            window.addEventListener('load', function() {
                document.getElementById('loadingOverlay').style.display = 'none';
            });
        });
    </script>
@endsection

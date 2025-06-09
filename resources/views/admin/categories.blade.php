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
            text-decoration: none;
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

        /* Category Styling */
        .category-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .category-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #e9ecef;
        }

        .category-details {
            flex: 1;
        }

        .category-name {
            font-weight: 700;
            color: #495057;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .category-slug {
            font-size: 13px;
            color: #6c757d;
            background: #f8f9fa;
            padding: 2px 8px;
            border-radius: 4px;
            display: inline-block;
        }

        .product-count {
            text-align: center;
        }

        .product-number {
            font-weight: 700;
            color: #007bff;
            font-size: 18px;
            margin-bottom: 2px;
        }

        .product-label {
            font-size: 12px;
            color: #6c757d;
            font-weight: 600;
        }

        .created-date {
            font-weight: 600;
            color: #495057;
            font-size: 15px;
            margin-bottom: 2px;
        }

        .created-time {
            font-size: 13px;
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

        .btn-products {
            background: #17a2b8;
            border-color: #17a2b8;
            color: white;
        }

        .btn-products:hover {
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

        /* Success Alert Styling */
        .alert-success {
            background: #d1f2eb;
            border: 1px solid #7dd3fc;
            color: #0c5460;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            font-weight: 600;
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

            .category-info {
                flex-direction: column;
                text-align: center;
                gap: 10px;
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

        /* TAMBAHKAN CSS ini sebelum closing tag

        /* Toggle Active Button Styling */
        .btn-warning {
            background: #ffc107;
            border-color: #ffc107;
            color: #000;
        }

        .btn-warning:hover {
            background: #e0a800;
            border-color: #d39e00;
            color: #000;
            transform: translateY(-1px);
        }

        /* Status Badge Styling */
        .badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .bg-success {
            background-color: #28a745 !important;
            color: white;
        }

        .bg-secondary {
            background-color: #6c757d !important;
            color: white;
        }

        /* Summary Icon Colors */
        .summary-icon.bg-secondary {
            background-color: #6c757d !important;
        }

        /* Responsive untuk kolom status */
        @media (max-width: 768px) {
            .table td:nth-child(3) {
                display: none;
            }

            .table th:nth-child(3) {
                display: none;
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Manajemen Kategori Produk</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Kategori Produk</div>
                    </li>
                </ul>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="page-title">Kelola Kategori Produk</h4>
                        <p class="text-muted mb-0">Manage dan atur semua kategori produk di toko online</p>
                    </div>
                    <a href="{{ route('admin.category.add') }}" class="btn-add-new">
                        <i class="icon-plus"></i> Tambah Kategori Baru
                    </a>
                </div>
            </div>

            @if (request('status') == 'inactive')
                <div class="alert alert-info">
                    <div class="d-flex align-items-center">
                        <i class="icon-info me-2"></i>
                        <div>
                            <strong>Kategori Nonaktif</strong><br>
                            <small>Kategori yang dinonaktifkan tidak akan tampil di frontend website. Klik tombol "Aktifkan"
                                untuk mengaktifkan kembali.</small>
                        </div>
                    </div>
                </div>
            @elseif(request('status') == 'all')
                <div class="alert alert-secondary">
                    <div class="d-flex align-items-center">
                        <i class="icon-eye me-2"></i>
                        <div>
                            <strong>Semua Status Kategori</strong><br>
                            <small>Menampilkan kategori aktif dan nonaktif. Gunakan tombol "Aktifkan/Nonaktifkan" untuk
                                mengubah status.</small>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Summary Cards -->
            <div class="summary-section">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-info">
                                <i class="icon-layers"></i>
                            </div>
                            <div class="summary-number">{{ $summaryData['totalActive'] ?? $categories->total() }}</div>
                            <div class="summary-label">Kategori Aktif</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-success">
                                <i class="icon-credit-card"></i>
                            </div>
                            <div class="summary-number">{{ $summaryData['totalProducts'] ?? 0 }}</div>
                            <div class="summary-label">Total Produk</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-warning">
                                <i class="icon-grid"></i>
                            </div>
                            <div class="summary-number">{{ $summaryData['totalWithProducts'] ?? 0 }}</div>
                            <div class="summary-label">Kategori Ber-Produk</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-secondary">
                                <i class="icon-pause"></i>
                            </div>
                            <div class="summary-number">{{ $summaryData['totalInactive'] ?? 0 }}</div>
                            <div class="summary-label">Kategori Nonaktif</div>
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
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label">Cari Nama Kategori</label>
                            <div class="search-container">
                                <i class="icon-magnifier search-icon"></i>
                                <input type="text" name="search" class="form-control search-input"
                                    placeholder="Ketik nama kategori..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <!-- Sort Order -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Urutkan</label>
                            <select name="sort" class="form-select">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                    Terbaru
                                </option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                    Terlama
                                </option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                                    Nama A-Z
                                </option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                                    Nama Z-A
                                </option>
                                <option value="most_products" {{ request('sort') == 'most_products' ? 'selected' : '' }}>
                                    Produk Terbanyak
                                </option>
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="" {{ request('status') == '' ? 'selected' : '' }}>
                                    Kategori Aktif
                                </option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                    Dengan Produk
                                </option>
                                <option value="empty" {{ request('status') == 'empty' ? 'selected' : '' }}>
                                    Kategori Kosong
                                </option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                    Kategori Nonaktif
                                </option>
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>
                                    Semua Status
                                </option>
                            </select>
                        </div>

                        <!-- Per Page -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Per Halaman</label>
                            <select name="per_page" class="form-select">
                                <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">&nbsp;</label>
                            <div class="filter-buttons">
                                <button type="submit" class="btn btn-filter" title="Terapkan Filter">
                                    <i class="bx bx-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.categories') }}" class="btn btn-reset" title="Reset Filter">
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
                                Menampilkan <strong>{{ $categories->count() }}</strong> dari
                                <strong>{{ $categories->total() }}</strong> kategori
                                @if (request()->hasAny(['search', 'sort', 'status', 'per_page']))
                                    dengan filter yang diterapkan
                                @endif
                            </p>
                            <button type="button" class="btn btn-export" id="exportBtn" title="Download Data Excel">
                                <i class="icon-cloud-download"></i> Export Excel
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Success Alert -->
            @if (Session::has('status'))
                <div class="alert alert-success">
                    <i class="icon-check"></i> {{ Session::get('status') }}
                </div>
            @endif

            <!-- Table Section -->
            <div class="table-section">
                <div class="table-header">
                    <h5 class="table-title">
                        <i class="icon-list"></i> Daftar Kategori Produk
                    </h5>
                </div>

                <div class="table-responsive">
                    @if ($categories->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" width="5%">#</th>
                                    <th style="text-align: center;" width="30%">Kategori</th>
                                    <th style="text-align: center;" width="10%">Status</th> <!-- TAMBAHKAN ini -->
                                    <th style="text-align: center;" width="12%">Jumlah Produk</th>
                                    <th style="text-align: center;" width="13%">Dibuat</th>
                                    <th style="text-align: center;" width="30%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $index => $category)
                                    <tr>
                                        <!-- ID -->
                                        <td>
                                            <div class="text-center">
                                                <strong>{{ $categories->firstItem() + $index }}</strong>
                                            </div>
                                        </td>

                                        <!-- Category Info -->
                                        <td>
                                            <div class="category-info">
                                                <img src="{{ asset('uploads/categories/' . $category->image) }}"
                                                    alt="{{ $category->name }}" class="category-image"
                                                    onerror="this.src='{{ asset('assets/images/default-category.jpg') }}'">
                                                <div class="category-details">
                                                    <div class="category-name">{{ $category->name }}</div>
                                                    <div class="category-slug">{{ $category->slug }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Status - TAMBAHKAN KOLOM INI -->
                                        <td style="text-align: center;">
                                            <span
                                                class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>

                                        <!-- Product Count -->
                                        <td>
                                            <div class="product-count">
                                                <div class="product-number">{{ $category->products()->count() }}</div>
                                                <div class="product-label">PRODUK</div>
                                            </div>
                                        </td>

                                        <!-- Created Date -->
                                        <td style="text-align: center;">
                                            <div class="created-date">{{ $category->created_at->format('d M Y') }}</div>
                                            <div class="created-time">{{ $category->created_at->format('H:i') }} WIB</div>
                                        </td>

                                        <!-- Actions -->
                                        <td style="text-align: center;">
                                            <div class="action-group" style="text-align: center;">
                                                <a href="{{ route('admin.category.edit', ['id' => $category->id]) }}"
                                                    class="btn-action btn-edit" title="Edit Kategori">
                                                    <i class="icon-edit-3"></i> Edit
                                                </a>

                                                @if ($category->products()->count() > 0)
                                                    <button type="button" class="btn-action btn-products"
                                                        data-bs-toggle="modal" style="text-align: center;"
                                                        data-bs-target="#productsModal{{ $category->id }}"
                                                        title="Lihat Produk">
                                                        <i class="icon-eye"></i> Produk
                                                        ({{ $category->products()->count() }})
                                                    </button>
                                                @endif

                                                <!-- GANTI form delete dengan form toggle active -->
                                                <form method="POST"
                                                    action="{{ route('admin.category.toggle-active', ['id' => $category->id]) }}"
                                                    class="d-inline toggle-active-form">
                                                    @csrf @method('PATCH')
                                                    <button type="button"
                                                        class="btn-action {{ $category->is_active ? 'btn-warning' : 'btn-success' }} toggle-active-button"
                                                        title="{{ $category->is_active ? 'Nonaktifkan Kategori' : 'Aktifkan Kategori' }}">
                                                        <i
                                                            class="{{ $category->is_active ? 'icon-pause' : 'icon-play' }}"></i>
                                                        {{ $category->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
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
                            <h4 class="empty-title">Tidak Ada Kategori Ditemukan</h4>
                            <p class="empty-text">
                                @if (request()->hasAny(['search', 'sort', 'status']))
                                    Tidak ada kategori yang sesuai dengan filter yang diterapkan.<br>
                                    Coba ubah atau reset filter untuk melihat data lainnya.
                                @else
                                    Belum ada kategori produk yang terdaftar.<br>
                                    Tambahkan kategori pertama untuk memulai.
                                @endif
                            </p>
                            @if (!request()->hasAny(['search', 'sort', 'status']))
                                <a href="{{ route('admin.category.add') }}" class="btn btn-filter">
                                    <i class="icon-plus"></i> Tambah Kategori Pertama
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if ($categories->hasPages())
                    <div class="pagination-container">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pagination-info">
                                Menampilkan {{ $categories->firstItem() }} - {{ $categories->lastItem() }}
                                dari {{ $categories->total() }} kategori
                            </div>
                            {{ $categories->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Product Modals -->
    @foreach ($categories as $category)
        @if ($category->products()->count() > 0)
            <div class="modal fade" id="productsModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="icon-shopping-bag"></i> Produk dalam Kategori: {{ $category->name }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($category->products()->take(10)->get() as $product)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($product->image)
                                                            <img src="{{ asset('uploads/products/thumbnails/' . $product->image) }}"
                                                                alt="{{ $product->name }}" class="me-2"
                                                                style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                                        @endif
                                                        <div>
                                                            <div class="fw-bold">{{ $product->name }}</div>
                                                            <small class="text-muted">{{ $product->SKU }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($product->sale_price)
                                                        <div class="fw-bold text-success">Rp
                                                            {{ number_format($product->sale_price, 0, ',', '.') }}</div>
                                                        <small class="text-muted text-decoration-line-through">Rp
                                                            {{ number_format($product->regular_price, 0, ',', '.') }}</small>
                                                    @else
                                                        <div class="fw-bold">Rp
                                                            {{ number_format($product->regular_price, 0, ',', '.') }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span
                                                        class="fw-bold {{ $product->quantity > 10 ? 'text-success' : ($product->quantity > 0 ? 'text-warning' : 'text-danger') }}">
                                                        {{ $product->quantity }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge {{ $product->stock_status == 'instock' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $product->stock_status == 'instock' ? 'Tersedia' : 'Habis' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if ($category->products()->count() > 10)
                                    <div class="text-center mt-3">
                                        <small class="text-muted">Dan {{ $category->products()->count() - 10 }} produk
                                            lainnya...</small>
                                    </div>
                                @endif
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

@endsection

@push('scripts')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Sortable.js for Drag & Drop (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ====================================================================================================
            // Toggle Active confirmation
            // ====================================================================================================
            const toggleActiveButtons = document.querySelectorAll('.toggle-active-button');
            toggleActiveButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const form = this.closest('.toggle-active-form');
                    const isActive = this.textContent.includes('Nonaktifkan');
                    const action = isActive ? 'nonaktifkan' : 'aktifkan';
                    const title = isActive ? 'Nonaktifkan Kategori?' : 'Aktifkan Kategori?';
                    const text = `Apakah Anda yakin ingin ${action} kategori ini?`;

                    Swal.fire({
                        title: title,
                        text: text,
                        icon: 'question',
                        iconColor: isActive ? '#f39c12' : '#28a745',
                        showCancelButton: true,
                        reverseButtons: true,
                        focusCancel: true,
                        cancelButtonText: 'Batal',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: `Ya, ${action.charAt(0).toUpperCase() + action.slice(1)}!`,
                        confirmButtonColor: isActive ? '#f39c12' : '#28a745'
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

            // ====================================================================================================
            // Form submission with loading
            // ====================================================================================================
            const filterForm = document.getElementById('filterForm');
            filterForm.addEventListener('submit', function() {
                document.getElementById('loadingOverlay').style.display = 'flex';
            });

            // ====================================================================================================
            // Export button functionality dengan REAL EXPORT
            // ====================================================================================================
            const exportBtn = document.getElementById('exportBtn');
            if (exportBtn) {
                exportBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Buat URL export dengan filter yang sedang aktif
                    const formData = new FormData(filterForm);
                    const params = new URLSearchParams(formData);
                    const exportUrl = '{{ route('admin.categories.export') }}?' + params.toString();

                    Swal.fire({
                        title: 'Mengunduh File Excel...',
                        text: 'File sedang disiapkan untuk diunduh.',
                        icon: 'info',
                        iconColor: '#17a2b8',
                        timer: 2000,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    }).then(() => {
                        // Redirect ke URL export
                        window.location.href = exportUrl;
                    });
                });
            }

            // ====================================================================================================
            // Bulk Selection (untuk Multiple Selection)
            // ====================================================================================================
            function initBulkSelection() {
                // Add checkbox to each row
                const tableRows = document.querySelectorAll('.table tbody tr');
                tableRows.forEach((row, index) => {
                    const firstCell = row.querySelector('td:first-child');
                    if (firstCell) {
                        const categoryId = firstCell.textContent.trim();
                        firstCell.innerHTML = `
                            <div class="text-center">
                                <input type="checkbox" class="category-checkbox me-2" value="${categoryId}">
                                <strong>${categoryId}</strong>
                            </div>
                        `;
                    }
                });

                // Add select all checkbox to header
                const headerFirstCell = document.querySelector('.table thead th:first-child');
                if (headerFirstCell) {
                    headerFirstCell.innerHTML = `
                        <div class="text-center">
                            <input type="checkbox" id="selectAll" class="me-2">
                            #
                        </div>
                    `;
                }

                // Add bulk action bar
                const tableSection = document.querySelector('.table-section');
                if (tableSection) {
                    const bulkActionBar = document.createElement('div');
                    bulkActionBar.id = 'bulkActionContainer';
                    bulkActionBar.style.display = 'none';
                    bulkActionBar.className = 'alert alert-info mb-3';
                    bulkActionBar.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center">
                            <span><strong id="selectedCount">0</strong> kategori dipilih</span>
                            <div>
                                <select class="form-select d-inline-block me-2" id="bulkAction" style="width: auto;">
    <option value="">Pilih Aksi</option>
    <option value="deactivate">Nonaktifkan</option>
    <option value="activate">Aktifkan</option>
    <option value="feature">Tandai Unggulan</option>
    <option value="unfeature">Hapus Unggulan</option>
    <option value="export">Export</option>
</select>
                                <button type="button" class="btn btn-primary" id="bulkActionBtn">Jalankan</button>
                            </div>
                        </div>
                    `;
                    tableSection.insertBefore(bulkActionBar, tableSection.querySelector('.table-responsive'));
                }

                // Bulk selection logic
                const selectAllCheckbox = document.getElementById('selectAll');
                const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
                const bulkActionContainer = document.getElementById('bulkActionContainer');
                const selectedCount = document.getElementById('selectedCount');
                const bulkActionBtn = document.getElementById('bulkActionBtn');

                if (selectAllCheckbox) {
                    selectAllCheckbox.addEventListener('change', (e) => {
                        categoryCheckboxes.forEach(checkbox => {
                            checkbox.checked = e.target.checked;
                        });
                        updateBulkActionButton();
                    });
                }

                categoryCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateBulkActionButton);
                });

                if (bulkActionBtn) {
                    bulkActionBtn.addEventListener('click', executeBulkAction);
                }

                function updateBulkActionButton() {
                    const checkedBoxes = document.querySelectorAll('.category-checkbox:checked');
                    if (checkedBoxes.length > 0) {
                        bulkActionContainer.style.display = 'block';
                        selectedCount.textContent = checkedBoxes.length;
                    } else {
                        bulkActionContainer.style.display = 'none';
                    }
                }

                function executeBulkAction() {
                    const checkedBoxes = document.querySelectorAll('.category-checkbox:checked');
                    const bulkAction = document.getElementById('bulkAction').value;

                    if (checkedBoxes.length === 0) {
                        Swal.fire('Peringatan', 'Pilih minimal satu kategori', 'warning');
                        return;
                    }

                    if (!bulkAction) {
                        Swal.fire('Peringatan', 'Pilih aksi yang akan dilakukan', 'warning');
                        return;
                    }

                    const categoryIds = Array.from(checkedBoxes).map(cb => cb.value);

                    let confirmText = '';
                    switch (bulkAction) {
                        case 'deactivate': // GANTI dari 'delete'
                            confirmText = `Nonaktifkan ${categoryIds.length} kategori yang dipilih?`;
                            break;
                        case 'activate': // TAMBAHKAN ini
                            confirmText = `Aktifkan ${categoryIds.length} kategori yang dipilih?`;
                            break;
                        case 'feature':
                            confirmText = `Tandai ${categoryIds.length} kategori sebagai unggulan?`;
                            break;
                        case 'unfeature':
                            confirmText = `Hapus ${categoryIds.length} kategori dari unggulan?`;
                            break;
                        case 'export':
                            confirmText = `Export ${categoryIds.length} kategori yang dipilih?`;
                            break;
                    }

                    Swal.fire({
                        title: 'Konfirmasi Aksi',
                        text: confirmText,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Lanjutkan',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            submitBulkAction(bulkAction, categoryIds);
                        }
                    });
                }

                function submitBulkAction(action, categoryIds) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('admin.categories.bulk') }}';

                    // CSRF Token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    // Action
                    const actionInput = document.createElement('input');
                    actionInput.type = 'hidden';
                    actionInput.name = 'action';
                    actionInput.value = action;
                    form.appendChild(actionInput);

                    // Category IDs
                    categoryIds.forEach(id => {
                        const idInput = document.createElement('input');
                        idInput.type = 'hidden';
                        idInput.name = 'categories[]';
                        idInput.value = id;
                        form.appendChild(idInput);
                    });

                    document.getElementById('loadingOverlay').style.display = 'flex';
                    document.body.appendChild(form);
                    form.submit();
                }
            }

            // Initialize bulk selection
            initBulkSelection();

            // ====================================================================================================
            // Toggle Featured Status
            // ====================================================================================================
            // function addFeaturedToggle() {
            //     const actionGroups = document.querySelectorAll('.action-group');
            //     actionGroups.forEach((group, index) => {
            //         const categoryId = group.closest('tr').querySelector('.category-checkbox').value;

            //         const toggleBtn = document.createElement('button');
            //         toggleBtn.type = 'button';
            //         toggleBtn.className = 'btn-action btn-warning toggle-featured';
            //         toggleBtn.setAttribute('data-category-id', categoryId);
            //         toggleBtn.innerHTML = '<i class="icon-star"></i> Toggle';
            //         toggleBtn.title = 'Toggle Featured Status';

            //         toggleBtn.addEventListener('click', function() {
            //             toggleFeatured(categoryId);
            //         });

            //         group.insertBefore(toggleBtn, group.lastElementChild);
            //     });
            // }

            function toggleFeatured(categoryId) {
                fetch(`/admin/category/${categoryId}/toggle-featured`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message, 'success');
                            // Refresh page to see changes
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            showToast(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Terjadi kesalahan', 'error');
                    });
            }

            // Add featured toggle buttons
            addFeaturedToggle();

            // ====================================================================================================
            // Utility Functions
            // ====================================================================================================
            function showToast(message, type = 'info') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });

                Toast.fire({
                    icon: type,
                    title: message
                });
            }

            // ====================================================================================================
            // Success/Error messages
            // ====================================================================================================
            @if (session('success') || session('status'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') ?: session('status') }}',
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

            // ====================================================================================================
            // Hide loading on page load
            // ====================================================================================================
            window.addEventListener('load', function() {
                document.getElementById('loadingOverlay').style.display = 'none';
            });

            // ====================================================================================================
            // Auto submit form on select change
            // ====================================================================================================
            const autoSubmitSelects = document.querySelectorAll('#filterForm select');
            autoSubmitSelects.forEach(select => {
                select.addEventListener('change', function() {
                    document.getElementById('loadingOverlay').style.display = 'flex';
                    document.getElementById('filterForm').submit();
                });
            });
        });
    </script>
@endpush

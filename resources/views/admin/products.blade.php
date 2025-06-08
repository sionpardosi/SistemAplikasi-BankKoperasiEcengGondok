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

        .btn-bulk {
            background: linear-gradient(135deg, #6f42c1 0%, #563d7c 100%);
            border: none;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            white-space: nowrap;
            box-shadow: 0 2px 8px rgba(111, 66, 193, 0.3);
        }

        .btn-bulk:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(111, 66, 193, 0.4);
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

        /* Bulk Actions */
        .bulk-actions {
            background: #f8f9fc;
            border: 1px solid #e3e6f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            display: none;
        }

        .bulk-actions .btn {
            font-size: 14px;
            padding: 8px 15px;
            margin-right: 8px;
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

        /* Product Content Styling */
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .product-name {
            font-weight: 700;
            color: #495057;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .product-sku {
            font-size: 13px;
            color: #6c757d;
            line-height: 1.3;
        }

        .product-category {
            font-size: 13px;
            color: #6c757d;
        }

        .price-main {
            font-weight: 700;
            color: #28a745;
            font-size: 16px;
            margin-bottom: 2px;
        }

        .price-original {
            text-decoration: line-through;
            color: #6c757d;
            font-size: 13px;
        }

        .stock-value {
            font-weight: 700;
            color: #007bff;
            font-size: 16px;
            margin-bottom: 2px;
        }

        .stock-status {
            font-size: 12px;
            color: #6c757d;
        }

        .stock-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .stock-in { background-color: #28a745; }
        .stock-out { background-color: #dc3545; }
        .stock-low { background-color: #ffc107; }

        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 4px;
        }

        .status-active {
            background: #d1f2eb;
            color: #0c5460;
            border: 1px solid #7dd3fc;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status-featured {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .rating-stars {
            color: #ffc107;
            font-size: 14px;
        }

        .rating-count {
            font-size: 12px;
            color: #6c757d;
        }

        .last-update {
            font-size: 13px;
            color: #6c757d;
        }

        /* Action Buttons */
        .action-group {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
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

        /* Dropdown Styling */
        .dropdown-toggle {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #495057;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
        }

        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            padding: 10px 15px;
            font-size: 14px;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
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
                <h3>Manajemen Produk Eceng Gondok</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Produk</div>
                    </li>
                </ul>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="page-title">Kelola Produk Toko</h4>
                        <p class="text-muted mb-0">Manajemen produk, stok, dan penjualan dengan mudah</p>
                    </div>
                    <a href="{{ route('admin.product.add') }}" class="btn-add-new">
                        <i class="icon-plus"></i> Tambah Produk Baru
                    </a>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="summary-section">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-info">
                                <i class="icon-package"></i>
                            </div>
                            <div class="summary-number">{{ $products->total() }}</div>
                            <div class="summary-label">Total Produk</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-warning">
                                <i class="icon-star"></i>
                            </div>
                            <div class="summary-number">{{ $products->where('featured', 1)->count() }}</div>
                            <div class="summary-label">Produk Unggulan</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-success">
                                <i class="icon-check-circle"></i>
                            </div>
                            <div class="summary-number">{{ $products->where('stock_status', 'instock')->count() }}</div>
                            <div class="summary-label">Stok Tersedia</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-danger">
                                <i class="icon-alert-triangle"></i>
                            </div>
                            <div class="summary-number">{{ $products->where('stock_status', 'outofstock')->count() }}</div>
                            <div class="summary-label">Stok Habis</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-header">
                    <h5 class="filter-title">
                        <i class="icon-equalizer"></i> Filter & Pencarian Produk
                    </h5>
                </div>

                <form method="GET" id="filterForm">
                    <div class="row g-3">
                        <!-- Search -->
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Cari Produk</label>
                            <div class="search-container">
                                <i class="icon-magnifier search-icon"></i>
                                <input type="text" name="search" class="form-control search-input"
                                    placeholder="Nama produk atau SKU..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Kategori</label>
                            <select name="category_filter" class="form-select">
                                <option value="">Semua Kategori</option>
                                <!-- Add categories dynamically -->
                            </select>
                        </div>

                        <!-- Stock Status Filter -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Status Stok</label>
                            <select name="status_filter" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="instock" {{ request('status_filter') == 'instock' ? 'selected' : '' }}>
                                    Tersedia
                                </option>
                                <option value="outofstock" {{ request('status_filter') == 'outofstock' ? 'selected' : '' }}>
                                    Habis
                                </option>
                            </select>
                        </div>

                        <!-- Featured Filter -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Unggulan</label>
                            <select name="featured_filter" class="form-select">
                                <option value="">Semua</option>
                                <option value="1" {{ request('featured_filter') == '1' ? 'selected' : '' }}>
                                    Ya
                                </option>
                                <option value="0" {{ request('featured_filter') == '0' ? 'selected' : '' }}>
                                    Tidak
                                </option>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">&nbsp;</label>
                            <div class="filter-buttons">
                                <button type="submit" class="btn btn-filter" title="Terapkan Filter">
                                    <i class="icon-search"></i> Cari
                                </button>
                                <a href="{{ route('admin.products') }}" class="btn btn-reset" title="Reset Filter">
                                    <i class="icon-refresh"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Info & Action Buttons -->
                    <div class="filter-info">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="filter-info-text">
                                <i class="icon-info"></i>
                                Menampilkan <strong>{{ $products->count() }}</strong> dari
                                <strong>{{ $products->total() }}</strong> produk
                                @if (request()->hasAny(['search', 'category_filter', 'status_filter', 'featured_filter']))
                                    dengan filter yang diterapkan
                                @endif
                            </p>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-bulk" onclick="toggleBulkActions()" title="Aksi Massal">
                                    <i class="icon-check-square"></i> Bulk Action
                                </button>
                                <a href="{{ route('admin.products.export') }}" class="btn btn-export" title="Download Data Excel">
                                    <i class="icon-cloud-download"></i> Export Excel
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Bulk Actions -->
            <div class="bulk-actions" id="bulkActions">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">
                        <span id="selectedCount">0</span> produk dipilih
                    </span>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="bulkActivate()">
                            <i class="icon-check"></i> Aktifkan
                        </button>
                        <button type="button" class="btn btn-outline-warning btn-sm" onclick="bulkDeactivate()">
                            <i class="icon-pause"></i> Nonaktifkan
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="bulkFeatured()">
                            <i class="icon-star"></i> Jadikan Unggulan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if (Session::has('status'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="icon-check-circle me-2"></i>{{ Session::get('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Table Section -->
            <div class="table-section">
                <div class="table-header">
                    <h5 class="table-title">
                        <i class="icon-list"></i> Daftar Produk Toko
                    </h5>
                </div>

                <div class="table-responsive">
                    @if ($products->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="3%">
                                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                    </th>
                                    <th width="25%">Informasi Produk</th>
                                    <th width="12%">Harga</th>
                                    <th width="10%">Stok</th>
                                    <th width="10%">Status</th>
                                    <th width="12%">Rating</th>
                                    <th width="10%">Update Terakhir</th>
                                    <th width="18%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="product-checkbox" value="{{ $product->id }}"
                                                   onchange="updateSelectedCount()">
                                        </td>

                                        <!-- Product Info -->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('uploads/products/thumbnails') }}/{{ $product->image }}"
                                                     alt="{{ $product->name }}" class="product-image me-3">
                                                <div>
                                                    <div class="product-name">{{ Str::limit($product->name, 35) }}</div>
                                                    <div class="product-sku">SKU: {{ $product->SKU }}</div>
                                                    <div class="product-category">
                                                        <i class="icon-tag"></i> {{ $product->category->name ?? 'Tanpa Kategori' }} •
                                                        {{ $product->brand->name ?? 'Tanpa Brand' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Price -->
                                        <td>
                                            <div class="price-main">{{ formatRupiah($product->sale_price) }}</div>
                                            @if($product->regular_price > $product->sale_price)
                                                <div class="price-original">{{ formatRupiah($product->regular_price) }}</div>
                                            @endif
                                        </td>

                                        <!-- Stock -->
                                        <td>
                                            <div class="d-flex align-items-center mb-1">
                                                <span class="stock-indicator {{ $product->quantity > 10 ? 'stock-in' : ($product->quantity > 0 ? 'stock-low' : 'stock-out') }}"></span>
                                                <span class="stock-value">{{ $product->quantity }}</span>
                                            </div>
                                            <div class="stock-status">{{ $product->quantity > 0 ? 'unit tersedia' : 'habis' }}</div>
                                        </td>

                                        <!-- Status -->
                                        <td>
                                            @if($product->featured)
                                                <span class="status-badge status-featured">
                                                    <i class="icon-star"></i> Unggulan
                                                </span>
                                            @endif
                                            <div>
                                                <span class="status-badge {{ $product->quantity > 0 ? 'status-active' : 'status-inactive' }}">
                                                    <i class="icon-{{ $product->quantity > 0 ? 'check' : 'x' }}"></i>
                                                    {{ $product->quantity > 0 ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Rating -->
                                        <td>
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="rating-stars me-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="icon-star {{ $i <= 4 ? '' : 'text-muted' }}"></i>
                                                    @endfor
                                                </div>
                                                <small>(4.0)</small>
                                            </div>
                                            <div class="rating-count">25 ulasan</div>
                                        </td>

                                        <!-- Last Update -->
                                        <td>
                                            <div class="last-update">
                                                {{ $product->updated_at->format('d M Y') }}
                                                <br>
                                                {{ $product->updated_at->format('H:i') }} WIB
                                            </div>
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="icon-more-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="viewProduct({{ $product->id }})">
                                                            <i class="icon-eye me-2"></i>Lihat Detail
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.product.edit', ['id' => $product->id]) }}">
                                                            <i class="icon-edit me-2"></i>Edit Produk
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="duplicateProduct({{ $product->id }})">
                                                            <i class="icon-copy me-2"></i>Duplikasi
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="toggleFeatured({{ $product->id }})">
                                                            <i class="icon-star me-2"></i>
                                                            {{ $product->featured ? 'Hapus dari Unggulan' : 'Jadikan Unggulan' }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-warning" href="#" onclick="deactivateProduct({{ $product->id }})">
                                                            <i class="icon-pause me-2"></i>Nonaktifkan Produk
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" onclick="confirmDelete({{ $product->id }})">
                                                            <i class="icon-trash-2 me-2"></i>Hapus Produk
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="icon-package"></i>
                            </div>
                            <h4 class="empty-title">Tidak Ada Produk Ditemukan</h4>
                            <p class="empty-text">
                                @if (request()->hasAny(['search', 'category_filter', 'status_filter', 'featured_filter']))
                                    Tidak ada produk yang sesuai dengan filter yang diterapkan.<br>
                                    Coba ubah atau reset filter untuk melihat data lainnya.
                                @else
                                    Belum ada produk yang terdaftar di toko Anda.<br>
                                    Mulai tambahkan produk pertama untuk memulai penjualan.
                                @endif
                            </p>
                            @if (!request()->hasAny(['search', 'category_filter', 'status_filter', 'featured_filter']))
                                <a href="{{ route('admin.product.add') }}" class="btn btn-filter">
                                    <i class="icon-plus"></i> Tambah Produk Pertama
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if ($products->hasPages())
                    <div class="pagination-container">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pagination-info">
                                Menampilkan {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }}
                                dari {{ $products->total() }} produk
                            </div>
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Product Detail Modal -->
    <div class="modal fade" id="productDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="icon-eye"></i> Detail Produk
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="productDetailContent">
                    <!-- Content will be loaded dynamically -->
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
        let selectedProductId = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Success/Error messages
            @if (session('status'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('status') }}',
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
        });

        // Toggle select all products
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
            updateSelectedCount();
        }

        // Update selected count
        function updateSelectedCount() {
            const checkboxes = document.querySelectorAll('.product-checkbox:checked');
            const count = checkboxes.length;
            document.getElementById('selectedCount').textContent = count;

            const bulkActions = document.getElementById('bulkActions');
            if (count > 0) {
                bulkActions.style.display = 'block';
            } else {
                bulkActions.style.display = 'none';
            }
        }

        // Toggle bulk actions
        function toggleBulkActions() {
            const bulkActions = document.getElementById('bulkActions');
            if (bulkActions.style.display === 'none' || bulkActions.style.display === '') {
                bulkActions.style.display = 'block';
            } else {
                bulkActions.style.display = 'none';
            }
        }

        // View product detail
        function viewProduct(productId) {
            document.getElementById('productDetailContent').innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat detail produk...</p>
                </div>
            `;

            const modal = new bootstrap.Modal(document.getElementById('productDetailModal'));
            modal.show();

            // Load product details via AJAX
            fetch(`/admin/product/${productId}/detail`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('productDetailContent').innerHTML = `
                        <div class="row">
                            <div class="col-md-4">
                                <img src="${data.image}" class="img-fluid rounded" alt="${data.name}">
                            </div>
                            <div class="col-md-8">
                                <h5>${data.name}</h5>
                                <p class="text-muted">SKU: ${data.sku}</p>
                                <p><strong>Kategori:</strong> ${data.category}</p>
                                <p><strong>Brand:</strong> ${data.brand}</p>
                                <p><strong>Harga Normal:</strong> ${data.regular_price}</p>
                                <p><strong>Harga Diskon:</strong> ${data.sale_price}</p>
                                <p><strong>Stok:</strong> ${data.quantity} unit</p>
                                <p><strong>Status:</strong> ${data.stock_status}</p>
                                <p><strong>Unggulan:</strong> ${data.featured ? 'Ya' : 'Tidak'}</p>
                                <hr>
                                <h6>Deskripsi Singkat:</h6>
                                <p>${data.short_description}</p>
                            </div>
                        </div>
                    `;
                })
                .catch(error => {
                    document.getElementById('productDetailContent').innerHTML = `
                        <div class="text-center text-danger">
                            <p>Gagal memuat detail produk</p>
                        </div>
                    `;
                });
        }

        // Confirm delete product
        function confirmDelete(productId) {
            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: 'Apakah Anda yakin ingin menghapus produk ini? Data yang dihapus tidak dapat dikembalikan.',
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

                    // Create and submit form for delete
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/product/${productId}/delete`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Deactivate product
        function deactivateProduct(productId) {
            Swal.fire({
                title: 'Konfirmasi Nonaktifkan Produk',
                text: 'Produk akan disembunyikan dari toko dan tidak bisa dibeli pelanggan. Data produk akan tetap tersimpan.',
                icon: 'warning',
                iconColor: '#f39c12',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Nonaktifkan',
                confirmButtonColor: '#ffc107'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/product/${productId}/deactivate`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PATCH';
                    form.appendChild(methodField);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Toggle featured status
        function toggleFeatured(productId) {
            Swal.fire({
                title: 'Ubah Status Unggulan',
                text: 'Apakah Anda yakin ingin mengubah status unggulan produk ini?',
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Ubah'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/product/${productId}/toggle-featured`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PATCH';
                    form.appendChild(methodField);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Duplicate product
        function duplicateProduct(productId) {
            Swal.fire({
                title: 'Duplikasi Produk',
                text: 'Produk akan diduplikasi dan Anda akan diarahkan ke halaman edit.',
                icon: 'info',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Duplikasi'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/admin/product/${productId}/duplicate`;
                }
            });
        }

        // Bulk actions
        function bulkActivate() {
            const selected = getSelectedProducts();
            if (selected.length === 0) {
                Swal.fire('Peringatan', 'Pilih produk terlebih dahulu', 'warning');
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Aktifkan',
                text: `Aktifkan ${selected.length} produk yang dipilih?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Aktifkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    performBulkAction('activate', selected);
                }
            });
        }

        function bulkDeactivate() {
            const selected = getSelectedProducts();
            if (selected.length === 0) {
                Swal.fire('Peringatan', 'Pilih produk terlebih dahulu', 'warning');
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Nonaktifkan',
                text: `Nonaktifkan ${selected.length} produk yang dipilih?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Nonaktifkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    performBulkAction('deactivate', selected);
                }
            });
        }

        function bulkFeatured() {
            const selected = getSelectedProducts();
            if (selected.length === 0) {
                Swal.fire('Peringatan', 'Pilih produk terlebih dahulu', 'warning');
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Unggulan',
                text: `Jadikan ${selected.length} produk sebagai unggulan?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Jadikan Unggulan'
            }).then((result) => {
                if (result.isConfirmed) {
                    performBulkAction('featured', selected);
                }
            });
        }

        // Get selected products
        function getSelectedProducts() {
            const checkboxes = document.querySelectorAll('.product-checkbox:checked');
            return Array.from(checkboxes).map(cb => cb.value);
        }

        // Perform bulk action
        function performBulkAction(action, products) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/products/bulk-action';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            const actionField = document.createElement('input');
            actionField.type = 'hidden';
            actionField.name = 'action';
            actionField.value = action;
            form.appendChild(actionField);

            const productsField = document.createElement('input');
            productsField.type = 'hidden';
            productsField.name = 'products';
            productsField.value = JSON.stringify(products);
            form.appendChild(productsField);

            document.body.appendChild(form);
            form.submit();
        }
    </script>
@endsection

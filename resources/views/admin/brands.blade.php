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

        /* Brand Content Styling */
        .brand-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brand-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .brand-image:hover {
            transform: scale(1.1);
            border-color: #007bff;
        }

        .brand-details {
            flex: 1;
        }

        .brand-name {
            font-weight: 700;
            color: #495057;
            font-size: 16px;
            margin-bottom: 4px;
            text-decoration: none;
        }

        .brand-name:hover {
            color: #007bff;
        }

        .brand-slug {
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

        .count-number {
            font-weight: 700;
            color: #007bff;
            font-size: 18px;
            margin-bottom: 2px;
        }

        .count-label {
            font-size: 12px;
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

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Action Buttons */
        .action-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: center;
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
            background: #17a2b8;
            border-color: #17a2b8;
            color: white;
        }

        .btn-edit:hover {
            background: #138496;
            border-color: #138496;
            color: white;
            transform: translateY(-1px);
        }

        .btn-toggle {
            background: transparent;
            border-color: #ffc107;
            color: #ffc107;
        }

        .btn-toggle:hover {
            background: #ffc107;
            border-color: #ffc107;
            color: #212529;
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
        .alert {
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border: none;
            font-size: 15px;
        }

        .alert-success {
            background: #d1f2eb;
            color: #0c5460;
            border-left: 4px solid #28a745;
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

            .brand-info {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Manajemen Merek Produk</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Merek</div>
                    </li>
                </ul>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="page-title">Kelola Merek Produk</h4>
                        <p class="text-muted mb-0">Manajemen semua merek produk dalam sistem e-commerce</p>
                    </div>
                    <a href="{{ route('admin.brand.add') }}" class="btn-add-new">
                        <i class="icon-plus"></i> Tambah Merek Baru
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
                            <div class="summary-number">{{ $brands->total() }}</div>
                            <div class="summary-label">Total Merek</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-success">
                                <i class="icon-check"></i>
                            </div>
                            <div class="summary-number">{{ $brands->where('is_active', true)->count() }}</div>
                            <div class="summary-label">Merek Aktif</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-warning">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="summary-number">{{ $brands->where('is_active', false)->count() }}</div>
                            <div class="summary-label">Merek Nonaktif</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-primary">
                                <i class="bx bx-shopping-bag"></i>
                            </div>
                            <div class="summary-number">{{ $totalProducts ?? 0 }}</div>
                            <div class="summary-label">Total Produk</div>
                        </div>
                    </div>
                </div>
            </div>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
            <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

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
                            <label class="form-label">Cari Nama Merek</label>
                            <div class="search-container">
                                <i class="icon-magnifier search-icon"></i>
                                <input type="text" name="search" class="form-control search-input"
                                    placeholder="Ketik nama merek..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Status Merek</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>

                        <!-- Sort By -->
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Urutkan Berdasarkan</label>
                            <select name="sort" class="form-select">
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="most_products" {{ request('sort') == 'most_products' ? 'selected' : '' }}>Produk Terbanyak</option>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">&nbsp;</label>
                            <div class="filter-buttons">
                                <button type="submit" class="btn btn-filter" title="Terapkan Filter">
                                    <i class="icon-search"></i>
                                </button>
                                <a href="{{ route('admin.brands') }}" class="btn btn-reset" title="Reset Filter">
                                    <i class="icon-refresh"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="table-section">
                <div class="table-header">
                    <h5 class="table-title">
                        <i class="icon-list"></i> Daftar Merek Produk
                    </h5>
                </div>

                <!-- Success Message -->
                @if (Session::has('status'))
                    <div class="alert alert-success">
                        <i class="icon-check"></i> {{ Session::get('status') }}
                    </div>
                @endif

                <div class="table-responsive">
                    @if ($brands->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" width="8%">ID</th>
                                    <th style="text-align: center;" width="35%">Informasi Merek</th>
                                    <th style="text-align: center;" width="15%">Jumlah Produk</th>
                                    <th style="text-align: center;" width="12%">Status</th>
                                    <th style="text-align: center;" width="15%">Tanggal Dibuat</th>
                                    <th style="text-align: center;" width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $brand)
                                    <tr>
                                        <!-- ID -->
                                        <td style="text-align: center;">
                                            <span class="badge bg-light text-dark">#{{ $brand->id }}</span>
                                        </td>

                                        <!-- Brand Info -->
                                        <td>
                                            <div class="brand-info">
                                                <img src="{{ asset('uploads/brands/' . $brand->image) }}"
                                                     alt="{{ $brand->name }}"
                                                     class="brand-image"
                                                     onerror="this.src='{{ asset('assets/images/default-brand.png') }}'">
                                                <div class="brand-details">
                                                    <a href="#" class="brand-name">{{ $brand->name }}</a>
                                                    <div class="brand-slug">{{ $brand->slug }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Product Count -->
                                        <td>
                                            <div class="product-count">
                                                <div class="count-number">{{ $brand->products_count ?? 0 }}</div>
                                                <div class="count-label">Produk</div>
                                            </div>
                                        </td>

                                        <!-- Status -->
                                        <td style="text-align: center;">
                                            @if($brand->is_active ?? true)
                                                <span class="status-badge status-active">
                                                    <i class="icon-check"></i> Aktif
                                                </span>
                                            @else
                                                <span class="status-badge status-inactive">
                                                    <i class="icon-close"></i> Nonaktif
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Created Date -->
                                        <td style="text-align: center;">
                                            <div class="date-main">{{ $brand->created_at->format('d M Y') }}</div>
                                            <div class="date-time">{{ $brand->created_at->format('H:i') }} WIB</div>
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <div class="action-group">
                                                <a href="{{ route('admin.brand.edit', $brand->id) }}"
                                                   class="btn-action btn-edit" title="Edit Merek">
                                                    <i class="icon-edit-3"></i> Edit
                                                </a>

                                                <button type="button"
                                                        class="btn-action btn-toggle toggle-status"
                                                        data-id="{{ $brand->id }}"
                                                        data-status="{{ $brand->is_active ?? true }}"
                                                        title="{{ ($brand->is_active ?? true) ? 'Nonaktifkan' : 'Aktifkan' }} Merek">
                                                    <i class="icon-{{ ($brand->is_active ?? true) ? 'eye-off' : 'eye' }}"></i>
                                                    {{ ($brand->is_active ?? true) ? 'Nonaktifkan' : 'Aktifkan' }}
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
                            <h4 class="empty-title">Tidak Ada Merek Ditemukan</h4>
                            <p class="empty-text">
                                @if (request()->hasAny(['search', 'status', 'sort']))
                                    Tidak ada merek yang sesuai dengan filter yang diterapkan.<br>
                                    Coba ubah atau reset filter untuk melihat data lainnya.
                                @else
                                    Belum ada merek yang terdaftar dalam sistem.<br>
                                    Tambahkan merek pertama untuk memulai.
                                @endif
                            </p>
                            @if (!request()->hasAny(['search', 'status', 'sort']))
                                <a href="{{ route('admin.brand.add') }}" class="btn btn-filter">
                                    <i class="icon-plus"></i> Tambah Merek Pertama
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if ($brands->hasPages())
                    <div class="pagination-container">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pagination-info">
                                Menampilkan {{ $brands->firstItem() }} - {{ $brands->lastItem() }}
                                dari {{ $brands->total() }} merek
                            </div>
                            {{ $brands->appends(request()->query())->links() }}
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

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle status functionality
            const toggleButtons = document.querySelectorAll('.toggle-status');
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const brandId = this.dataset.id;
                    const currentStatus = this.dataset.status === 'true';
                    const newStatus = !currentStatus;
                    const actionText = newStatus ? 'mengaktifkan' : 'menonaktifkan';

                    Swal.fire({
                        title: 'Konfirmasi Perubahan Status',
                        text: `Apakah Anda yakin ingin ${actionText} merek ini?`,
                        icon: 'question',
                        iconColor: '#ffc107',
                        showCancelButton: true,
                        reverseButtons: true,
                        focusCancel: true,
                        cancelButtonText: 'Batal',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: `Ya, ${actionText.charAt(0).toUpperCase() + actionText.slice(1)}!`,
                        confirmButtonColor: '#007bff'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading
                            document.getElementById('loadingOverlay').style.display = 'flex';

                            // Create form and submit
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/admin/brand/${brandId}/toggle-status`;

                            // Add CSRF token
                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = '{{ csrf_token() }}';
                            form.appendChild(csrfInput);

                            // Add method
                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'PATCH';
                            form.appendChild(methodInput);

                            document.body.appendChild(form);
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

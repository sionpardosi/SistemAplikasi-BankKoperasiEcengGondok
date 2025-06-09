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

        /* Slide Image */
        .slide-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .slide-image:hover {
            transform: scale(1.1);
            border-color: #007bff;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        /* Content styling */
        .slide-title {
            font-weight: 700;
            color: #495057;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .slide-tagline {
            font-size: 13px;
            color: #007bff;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .slide-subtitle {
            color: #6c757d;
            font-size: 14px;
            line-height: 1.3;
        }

        .slide-link {
            color: #17a2b8;
            font-size: 13px;
            word-break: break-all;
            text-decoration: none;
        }

        .slide-link:hover {
            color: #138496;
            text-decoration: underline;
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

        .btn-delete {
            background: transparent;
            border-color: #dc3545;
            color: #dc3545;
            border: none;
            cursor: pointer;
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

        /* Success Alert */
        .alert-success {
            background: #d1f2eb;
            border: 1px solid #7dd3fc;
            color: #0c5460;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 15px;
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
                <h3>Manajemen Slider Beranda Website</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Slider Management</div>
                    </li>
                </ul>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="page-title">Kelola Konten Slider</h4>
                        <p class="text-muted mb-0">Atur dan kelola semua slide yang tampil di halaman beranda website</p>
                    </div>
                    <a href="{{ route('admin.slide.add') }}" class="btn-add-new">
                        <i class="icon-plus"></i> Tambah Slide Baru
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
                            <div class="summary-number">{{ $slides->total() }}</div>
                            <div class="summary-label">Total Slide</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-success">
                                <i class="icon-check"></i>
                            </div>
                            <div class="summary-number">{{ $slides->where('status', 1)->count() }}</div>
                            <div class="summary-label">Slide Aktif</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-warning">
                                <i class="icon-pause"></i>
                            </div>
                            <div class="summary-number">{{ $slides->where('status', 0)->count() }}</div>
                            <div class="summary-label">Slide Nonaktif</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-primary">
                                <i class="icon-credit-card"></i>
                            </div>
                            <div class="summary-number">{{ $slides->count() }}</div>
                            <div class="summary-label">Slide Halaman Ini</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-header">
                    <h5 class="filter-title">
                        <i class="icon-equalizer"></i> Filter & Pencarian Slide
                    </h5>
                </div>

                <form method="GET" id="filterForm">
                    <div class="row g-3">
                        <!-- Search -->
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label">Cari Judul atau Tagline</label>
                            <div class="search-container">
                                <i class="icon-magnifier search-icon"></i>
                                <input type="text" name="search" class="form-control search-input"
                                    placeholder="Ketik judul atau tagline slide..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Status Slide</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                    Nonaktif
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
                                <a href="{{ route('admin.slides') }}" class="btn btn-reset" title="Reset Filter">
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
                        <i class="icon-list"></i> Daftar Slide Beranda
                    </h5>
                </div>

                <!-- Success Message -->
                @if (Session::has('status'))
                    <div class="alert alert-success">
                        <i class="icon-check"></i> {{ Session::get('status') }}
                    </div>
                @endif

                <div class="table-responsive">
                    @if ($slides->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="8%">ID</th>
                                    <th width="15%">Gambar</th>
                                    <th width="25%">Konten Slide</th>
                                    <th width="20%">Subtitle</th>
                                    <th width="15%">Link Tujuan</th>
                                    <th width="10%">Status</th>
                                    <th width="12%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($slides as $slide)
                                    <tr>
                                        <!-- ID -->
                                        <td>
                                            <span class="slide-title">#{{ $slide->id }}</span>
                                        </td>

                                        <!-- Gambar -->
                                        <td>
                                            <img src="{{ asset('uploads/slides') }}/{{ $slide->image }}"
                                                 alt="{{ $slide->title }}"
                                                 class="slide-image"
                                                 title="Klik untuk preview">
                                        </td>

                                        <!-- Konten Slide -->
                                        <td>
                                            <div class="slide-tagline">{{ $slide->tagline }}</div>
                                            <div class="slide-title">{{ $slide->title }}</div>
                                        </td>

                                        <!-- Subtitle -->
                                        <td>
                                            <div class="slide-subtitle">{{ $slide->subtitle }}</div>
                                        </td>

                                        <!-- Link -->
                                        <td>
                                            <a href="{{ $slide->link }}" target="_blank" class="slide-link" title="Buka link">
                                                {{ Str::limit($slide->link, 30) }}
                                            </a>
                                        </td>

                                        <!-- Status -->
                                        <td>
                                            @if($slide->status == 1)
                                                <span class="status-badge status-active">
                                                    <i class="icon-check"></i> Aktif
                                                </span>
                                            @else
                                                <span class="status-badge status-inactive">
                                                    <i class="icon-pause"></i> Nonaktif
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <div class="action-group">
                                                <a href="{{ route('admin.slide.edit', ['id' => $slide->id]) }}"
                                                    class="btn-action btn-edit" title="Edit Slide">
                                                    <i class="icon-edit-3"></i> Edit
                                                </a>

                                                <form action="{{ route('admin.slide.delete', ['id' => $slide->id]) }}"
                                                    method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-action btn-delete delete-button"
                                                        title="Hapus Slide">
                                                        <i class="icon-trash-2"></i> Hapus
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
                                <i class="icon-credit-card"></i>
                            </div>
                            <h4 class="empty-title">Belum Ada Slide</h4>
                            <p class="empty-text">
                                Belum ada slide yang ditambahkan ke sistem.<br>
                                Tambahkan slide pertama untuk menampilkan konten di beranda.
                            </p>
                            <a href="{{ route('admin.slide.add') }}" class="btn btn-filter">
                                <i class="icon-plus"></i> Tambah Slide Pertama
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if ($slides->hasPages())
                    <div class="pagination-container">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pagination-info">
                                Menampilkan {{ $slides->firstItem() }} - {{ $slides->lastItem() }}
                                dari {{ $slides->total() }} slide
                            </div>
                            {{ $slides->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
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
                        text: 'Apakah Anda yakin ingin menghapus slide ini? Data yang dihapus tidak dapat dikembalikan.',
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
                            form.submit();
                        }
                    });
                });
            });

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

            // Image preview on hover
            const slideImages = document.querySelectorAll('.slide-image');
            slideImages.forEach(img => {
                img.addEventListener('click', function() {
                    Swal.fire({
                        imageUrl: this.src,
                        imageAlt: this.alt,
                        showConfirmButton: false,
                        showCloseButton: true,
                        imageWidth: 600,
                        imageHeight: 400,
                        customClass: {
                            image: 'img-fluid'
                        }
                    });
                });
            });
        });
    </script>
@endsection

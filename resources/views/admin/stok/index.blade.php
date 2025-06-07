@extends('layouts.admin')

@section('content')
    <style>
        /* Base Styling - Same as supplier page */
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

        /* Status Alert */
        .status-alert {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .alert-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .alert-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }

        .alert-text {
            flex: 1;
        }

        .alert-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .alert-message {
            font-size: 15px;
            margin: 0;
        }

        /* Form Section */
        .form-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .form-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .form-title {
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

        /* Buttons */
        .btn-add-stok {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        }

        .btn-add-stok:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
            color: white;
        }

        .btn-konsumsi {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3);
        }

        .btn-konsumsi:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
            color: white;
        }

        .btn-export {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            border: none;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            white-space: nowrap;
            box-shadow: 0 2px 8px rgba(23, 162, 184, 0.3);
        }

        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.4);
            color: white;
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
            justify-content: between;
            align-items: center;
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

        .transaction-value {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 2px;
        }

        .transaction-in {
            color: #28a745;
        }

        .transaction-out {
            color: #dc3545;
        }

        .source-main {
            font-weight: 600;
            color: #495057;
            font-size: 15px;
            margin-bottom: 2px;
        }

        .source-detail {
            font-size: 13px;
            color: #6c757d;
        }

        /* Status Badges */
        .transaction-badge {
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

        .badge-masuk {
            background: #d1f2eb;
            color: #0c5460;
            border: 1px solid #7dd3fc;
        }

        .badge-keluar {
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
            .action-bar .d-flex {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }
        }

        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .form-section,
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
            .form-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .btn-add-stok,
            .btn-konsumsi {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Manajemen Stok Bahan Baku Eceng Gondok</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Stok Bahan Baku</div>
                    </li>
                </ul>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="page-title">Manajemen Stok Bahan Baku</h4>
                        <p class="text-muted mb-0">Kelola dan pantau stok bahan baku eceng gondok untuk produksi</p>
                    </div>
                    <a href="{{ route('admin.stok.export', request()->query()) }}" class="btn-export">
                        <i class="icon-cloud-download"></i> Export Excel
                    </a>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="summary-section">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-primary">
                                <i class="icon-layers"></i>
                            </div>
                            <div class="summary-number">{{ number_format($statistik['total_stok'], 1) }}</div>
                            <div class="summary-label">Total Stok (kg)</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-success">
                                <i class="icon-trending-up"></i>
                            </div>
                            <div class="summary-number">{{ number_format($statistik['total_masuk'], 1) }}</div>
                            <div class="summary-label">Total Masuk (kg)</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-danger">
                                <i class="icon-trending-down"></i>
                            </div>
                            <div class="summary-number">{{ number_format($statistik['total_keluar'], 1) }}</div>
                            <div class="summary-label">Total Keluar (kg)</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-info">
                                <i class="icon-list"></i>
                            </div>
                            <div class="summary-number">{{ $stok->total() }}</div>
                            <div class="summary-label">Total Transaksi</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Alert -->
            @if(isset($statistik['status_stok']))
            <div class="status-alert">
                <div class="alert-content">
                    <div class="alert-icon bg-{{ $statistik['status_stok']['warna'] }}">
                        <i class="icon-info"></i>
                    </div>
                    <div class="alert-text">
                        <div class="alert-title">Status Stok: {{ ucfirst($statistik['status_stok']['status']) }}</div>
                        <p class="alert-message">{{ $statistik['status_stok']['pesan'] }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Form Tambah Stok -->
            <div class="form-section">
                <div class="form-header">
                    <h5 class="form-title">
                        <i class="icon-plus"></i> Tambah Stok Bahan Baku
                    </h5>
                </div>

                <form method="POST" action="{{ route('admin.stok.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input name="tanggal" type="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Jumlah (kg)</label>
                            <input name="jumlah_kg" type="number" step="0.1" class="form-control" placeholder="0.0" required>
                        </div>
                        <div class="col-lg-4 col-md-8">
                            <label class="form-label">Keterangan / Sumber</label>
                            <input name="keterangan" type="text" class="form-control" placeholder="Sumber stok atau keterangan">
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn-add-stok w-100">
                                <i class="icon-plus"></i> Tambah Stok
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Form Konsumsi Stok -->
            <div class="form-section">
                <div class="form-header">
                    <h5 class="form-title">
                        <i class="icon-minus"></i> Konsumsi Stok (Pengurangan untuk Produksi)
                    </h5>
                </div>

                <form method="POST" action="{{ route('admin.stok.konsumsi') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input name="tanggal" type="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Jumlah Konsumsi (kg)</label>
                            <input name="jumlah_kg" type="number" step="0.1" class="form-control" placeholder="0.0"
                                   max="{{ $statistik['total_stok'] }}" required>
                            <small class="text-muted">Maksimal: {{ number_format($statistik['total_stok'], 1) }} kg</small>
                        </div>
                        <div class="col-lg-4 col-md-8">
                            <label class="form-label">Keperluan / Tujuan Konsumsi</label>
                            <input name="keterangan" type="text" class="form-control" placeholder="Untuk produksi apa..." required>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn-konsumsi w-100">
                                <i class="icon-minus"></i> Kurangi Stok
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="table-section">
                <div class="table-header">
                    <h5 class="table-title">
                        <i class="icon-list"></i> Riwayat Transaksi Stok
                    </h5>
                </div>

                <div class="table-responsive">
                    @if ($stok->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="12%">Tanggal</th>
                                    <th width="10%">Jenis</th>
                                    <th width="12%">Jumlah (kg)</th>
                                    <th width="20%">Sumber</th>
                                    <th width="32%">Keterangan</th>
                                    <th width="14%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stok as $s)
                                    <tr>
                                        <!-- Tanggal -->
                                        <td>
                                            <div class="date-main">{{ \Carbon\Carbon::parse($s->tanggal)->format('d M Y') }}</div>
                                            <div class="date-time">{{ \Carbon\Carbon::parse($s->created_at)->format('H:i') }} WIB</div>
                                        </td>

                                        <!-- Jenis Transaksi -->
                                        <td>
                                            @if($s->jumlah_kg > 0)
                                                <span class="transaction-badge badge-masuk">
                                                    <i class="icon-trending-up"></i> Masuk
                                                </span>
                                            @else
                                                <span class="transaction-badge badge-keluar">
                                                    <i class="icon-trending-down"></i> Keluar
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Jumlah -->
                                        <td>
                                            <div class="transaction-value {{ $s->jumlah_kg > 0 ? 'transaction-in' : 'transaction-out' }}">
                                                {{ $s->jumlah_kg > 0 ? '+' : '' }}{{ number_format($s->jumlah_kg, 1) }}
                                            </div>
                                        </td>

                                        <!-- Sumber -->
                                        <td>
                                            <div class="source-main">{{ $s->sumber }}</div>
                                            @if($s->request_id && $s->request)
                                                <div class="source-detail">
                                                    <i class="icon-user"></i> {{ $s->request->nama }}
                                                </div>
                                            @endif
                                        </td>

                                        <!-- Keterangan -->
                                        <td>
                                            {{ $s->keterangan ?? '-' }}
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <div class="action-group">
                                                <a href="{{ route('admin.stok.edit', $s->id) }}"
                                                    class="btn-action btn-edit" title="Edit Data">
                                                    <i class="icon-pencil"></i> Edit
                                                </a>

                                                <form method="POST" action="{{ route('admin.stok.delete', $s->id) }}"
                                                    class="d-inline delete-form">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn-action btn-delete delete-button"
                                                        title="Hapus Data">
                                                        <i class="icon-trash"></i> Hapus
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
                                <i class="icon-layers"></i>
                            </div>
                            <h4 class="empty-title">Belum Ada Data Stok</h4>
                            <p class="empty-text">
                                Belum ada transaksi stok bahan baku yang tercatat.<br>
                                Mulai tambahkan stok pertama untuk memulai pengelolaan.
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if ($stok->hasPages())
                    <div class="pagination-container">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pagination-info">
                                Menampilkan {{ $stok->firstItem() }} - {{ $stok->lastItem() }}
                                dari {{ $stok->total() }} transaksi
                            </div>
                            {{ $stok->links() }}
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
            <div class="loading-text">Memproses data stok...</div>
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
                        text: 'Apakah Anda yakin ingin menghapus data stok ini? Data yang dihapus tidak dapat dikembalikan.',
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
                            document.getElementById('loadingOverlay').style.display = 'flex';
                            form.submit();
                        }
                    });
                });
            });

            // Form submissions with loading
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                if (!form.classList.contains('delete-form')) {
                    form.addEventListener('submit', function() {
                        document.getElementById('loadingOverlay').style.display = 'flex';
                    });
                }
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

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

        /* Order Content Styling */
        .order-number {
            font-weight: 700;
            color: #007bff;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .order-date {
            font-size: 13px;
            color: #6c757d;
        }

        .customer-name {
            font-weight: 600;
            color: #495057;
            font-size: 15px;
            margin-bottom: 2px;
        }

        .customer-phone {
            font-size: 13px;
            color: #6c757d;
        }

        .price-main {
            font-weight: 700;
            color: #28a745;
            font-size: 16px;
            margin-bottom: 2px;
        }

        .price-detail {
            font-size: 13px;
            color: #6c757d;
        }

        /* Status Badges */
        .status-container {
            display: flex;
            flex-direction: column;
            gap: 6px;
            text-align: center;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 2px;
            text-align: center;
        }

        /* Payment Status Badges */
        .payment-paid {
            background: #d1f2eb;
            color: #0c5460;
            border: 1px solid #7dd3fc;
        }

        .payment-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .payment-declined {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Order Status Badges */
        .order-awaiting {
            background: #ffeaa7;
            color: #b7791f;
            border: 1px solid #fab005;
        }

        .order-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .order-confirmed {
            background: #e3f2fd;
            color: #1565c0;
            border: 1px solid #bbdefb;
        }

        .order-processing {
            background: #e8f5e8;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .order-shipped {
            background: #f3e5f5;
            color: #7b1fa2;
            border: 1px solid #ce93d8;
        }

        .order-delivered {
            background: #d1f2eb;
            color: #0c5460;
            border: 1px solid #7dd3fc;
        }

        .order-completed {
            background: #e8f5e8;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .order-canceled {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Items Info */
        .items-count {
            font-weight: 700;
            color: #495057;
            font-size: 16px;
        }

        .items-label {
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

        .btn-view {
            background: #007bff;
            border-color: #007bff;
            color: white;
        }

        .btn-view:hover {
            background: #0056b3;
            border-color: #0056b3;
            color: white;
            transform: translateY(-1px);
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
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Manajemen Kelola Pesanan Pelanggan</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Pesanan</div>
                    </li>
                </ul>
            </div>

            <!-- Summary Cards -->
            <div class="summary-section">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-info">
                                <i class="icon-tag"></i>
                            </div>
                            <div class="summary-number">{{ $orders->total() }}</div>
                            <div class="summary-label">Total Pesanan</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-warning">
                                <i class="icon-credit-card"></i>
                            </div>
                            <div class="summary-number">
                                {{ $orders->where('status', 'awaiting_payment')->count() }}
                            </div>
                            <div class="summary-label">Menunggu Pembayaran</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-primary">
                                <i class="icon-clock"></i>
                            </div>
                            <div class="summary-number">
                                {{ $orders->whereIn('status', ['pending', 'confirmed', 'processing'])->count() }}
                            </div>
                            <div class="summary-label">Sedang Diproses</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-success">
                                <i class="icon-check"></i>
                            </div>
                            <div class="summary-number">
                                {{ $orders->whereIn('status', ['delivered', 'completed'])->count() }}
                            </div>
                            <div class="summary-label">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-header">
                    <h5 class="filter-title">
                        <i class="icon-equalizer"></i> Filter & Pencarian Pesanan
                    </h5>
                </div>

                <form method="GET" id="filterForm">
                    <div class="row g-3">
                        <!-- Search -->
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Cari Nama atau Telepon</label>
                            <div class="search-container">
                                <i class="icon-magnifier search-icon"></i>
                                <input type="text" name="search" class="form-control search-input"
                                    placeholder="Ketik nama atau telepon..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <!-- Order Status Filter -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Status Pesanan</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="awaiting_payment"
                                    {{ request('status') == 'awaiting_payment' ? 'selected' : '' }}>
                                    Menunggu Pembayaran
                                </option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>
                                    Dikonfirmasi
                                </option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                                    Diproses
                                </option>
                                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>
                                    Dikirim
                                </option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>
                                    Sampai
                                </option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                    Selesai
                                </option>
                                <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>
                                    Dibatalkan
                                </option>
                            </select>
                        </div>

                        <!-- Payment Status Filter -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Status Pembayaran</label>
                            <select name="payment_status" class="form-select">
                                <option value="">Semua Pembayaran</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>
                                    Sudah Bayar
                                </option>
                                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>
                                    Belum Bayar
                                </option>
                                <option value="declined" {{ request('payment_status') == 'declined' ? 'selected' : '' }}>
                                    Ditolak
                                </option>
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
                                {{-- <a href="{{ route('admin.orders') }}" class="btn btn-reset" title="Reset Filter">
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
                                Menampilkan <strong>{{ $orders->count() }}</strong> dari
                                <strong>{{ $orders->total() }}</strong> pesanan
                                @if (request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                                    dengan filter yang diterapkan
                                @endif
                            </p>
                            <button class="btn btn-export" onclick="exportOrders()" title="Download Data Excel">
                                <i class="icon-cloud-download"></i> Export Excel
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="table-section">
                <div class="table-header">
                    <h5 class="table-title">
                        <i class="icon-list"></i> Daftar Pesanan Pelanggan
                    </h5>
                </div>

                <div class="table-responsive">
                    @if ($orders->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align: center" width="12%">No. Pesanan</th>
                                    <th style="text-align: center" width="18%">Pelanggan</th>
                                    <th style="text-align: center" width="15%">Total & Ongkir</th>
                                    <th style="text-align: center" width="12%">Items</th>
                                    <th style="text-align: center" width="18%">Status</th>
                                    <th style="text-align: center" width="12%">Tanggal</th>
                                    <th style="text-align: center" width="13%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <!-- Order Number -->
                                        <td style="text-align: center">
                                            <div class="order-number">
                                                #{{ '1' . str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
                                            <div class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                        </td>

                                        <!-- Customer Info -->
                                        <td style="text-align: center">
                                            <div class="customer-name">{{ $order->name }}</div>
                                            <div class="customer-phone">
                                                <i class="icon-phone"></i> {{ $order->phone }}
                                            </div>
                                        </td>

                                        <!-- Price & Shipping -->
                                        <td style="text-align: center">
                                            <div class="price-main">Rp {{ number_format($order->total) }}</div>
                                            <div class="price-detail">
                                                Subtotal: Rp {{ number_format($order->subtotal) }}
                                                @if ($order->ongkir)
                                                    <br>Ongkir: Rp {{ number_format($order->ongkir) }}
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Items -->
                                        <td style="text-align: center">
                                            <div class="items-count">{{ $order->orderItems->count() }}</div>
                                            <div class="items-label">
                                                {{ $order->orderItems->count() > 1 ? 'items' : 'item' }}</div>
                                        </td>

                                        <!-- Status -->
                                        <td>
                                            <div class="status-container">
                                                <!-- Payment Status -->
                                                @if ($order->transaction)
                                                    @switch($order->transaction->status)
                                                        @case('approved')
                                                        @case('paid')
                                                            <span class="status-badge payment-paid">
                                                                <i class="icon-check"></i> Sudah Bayar
                                                            </span>
                                                        @break

                                                        @case('pending')
                                                            <span class="status-badge payment-pending">
                                                                <i class="icon-clock"></i> Belum Bayar
                                                            </span>
                                                        @break

                                                        @case('declined')
                                                            <span class="status-badge payment-declined">
                                                                <i class="icon-close"></i> Ditolak
                                                            </span>
                                                        @break

                                                        @default
                                                            <span class="status-badge payment-pending">
                                                                <i class="icon-clock"></i> Belum Bayar
                                                            </span>
                                                    @endswitch
                                                @else
                                                    <span class="status-badge payment-pending">
                                                        <i class="icon-clock"></i> Belum Bayar
                                                    </span>
                                                @endif

                                                <!-- Order Status -->
                                                @switch($order->status)
                                                    @case('awaiting_payment')
                                                        <span class="status-badge order-awaiting">
                                                            <i class="icon-credit-card"></i> Menunggu Bayar
                                                        </span>
                                                    @break

                                                    @case('pending')
                                                        <span class="status-badge order-pending">
                                                            <i class="icon-clock"></i> Pending
                                                        </span>
                                                    @break

                                                    @case('confirmed')
                                                        <span class="status-badge order-confirmed">
                                                            <i class="icon-check"></i> Dikonfirmasi
                                                        </span>
                                                    @break

                                                    @case('processing')
                                                        <span class="status-badge order-processing">
                                                            <i class="icon-settings"></i> Diproses
                                                        </span>
                                                    @break

                                                    @case('shipped')
                                                        <span class="status-badge order-shipped">
                                                            <i class="icon-plane"></i> Dikirim
                                                        </span>
                                                    @break

                                                    @case('delivered')
                                                        <span class="status-badge order-delivered">
                                                            <i class="icon-location-pin"></i> Sampai
                                                        </span>
                                                    @break

                                                    @case('completed')
                                                        <span class="status-badge order-completed">
                                                            <i class="icon-trophy"></i> Selesai
                                                        </span>
                                                    @break

                                                    @case('canceled')
                                                        <span class="status-badge order-canceled">
                                                            <i class="icon-close"></i> Dibatalkan
                                                        </span>
                                                    @break
                                                @endswitch
                                            </div>
                                        </td>

                                        <!-- Date -->
                                        <td style="text-align: center">
                                            <div class="customer-name">{{ $order->created_at->format('d M Y') }}</div>
                                            <div class="customer-phone">{{ $order->created_at->format('H:i') }} WIB</div>
                                        </td>

                                        <!-- Actions -->
                                        <td style="text-align: center">
                                            <div class="action-group" style="text-align: center">
                                                <a href="{{ route('admin.order.items', ['order_id' => $order->id]) }}"
                                                    class="btn-action btn-view" title="Lihat Detail">
                                                    <i class="icon-eye"></i> Kelola Pesanan
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="icon-basket"></i>
                            </div>
                            <h4 class="empty-title">Tidak Ada Pesanan Ditemukan</h4>
                            <p class="empty-text">
                                @if (request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                                    Tidak ada pesanan yang sesuai dengan filter yang diterapkan.<br>
                                    Coba ubah atau reset filter untuk melihat data lainnya.
                                @else
                                    Belum ada pesanan yang masuk.<br>
                                    Pesanan akan muncul di sini setelah pelanggan melakukan pembelian.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if ($orders->hasPages())
                    <div class="pagination-container">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pagination-info">
                                Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }}
                                dari {{ $orders->total() }} pesanan
                            </div>
                            {{ $orders->appends(request()->query())->links() }}
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
            // Form submission with loading
            const filterForm = document.getElementById('filterForm');
            filterForm.addEventListener('submit', function() {
                // Show loading or add spinner if needed
            });

            // Export function
            window.exportOrders = function() {
                const params = new URLSearchParams(window.location.search);
                const exportUrl = '{{ route('admin.orders') }}?' + params.toString() + '&export=excel';

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
                    window.location.href = exportUrl;
                });
            };

            // Success/Error messages
            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#28a745'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545'
                });
            @endif
        });
    </script>
@endsection

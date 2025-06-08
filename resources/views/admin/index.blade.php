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
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-subtitle {
            font-size: 16px;
            color: #6c757d;
            margin-top: 5px;
            margin-bottom: 0;
        }

        /* Alert untuk stok */
        .alert-stock {
            border: none;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .alert-stock .alert-icon {
            font-size: 20px;
            margin-right: 10px;
        }

        /* Summary Cards */
        .summary-section {
            margin-bottom: 30px;
        }

        .summary-card {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            height: 100%;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #007bff, #0056b3);
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .summary-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #007bff, #0056b3);
        }

        .summary-number {
            font-size: 36px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
            line-height: 1;
        }

        .summary-label {
            font-size: 16px;
            color: #6c757d;
            font-weight: 600;
            margin: 0;
        }

        .summary-change {
            font-size: 13px;
            font-weight: 600;
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .summary-change.positive {
            color: #28a745;
        }

        .summary-change.negative {
            color: #dc3545;
        }

        /* Chart Section */
        .chart-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .chart-header {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f8f9fa;
        }

        .chart-title {
            font-size: 22px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chart-subtitle {
            font-size: 14px;
            color: #6c757d;
            margin-top: 5px;
            margin-bottom: 0;
        }

        .chart-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .legend-label {
            font-size: 14px;
            color: #6c757d;
            font-weight: 600;
        }

        .legend-value {
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
            margin-left: 10px;
        }

        .chart-container {
            background: #fafbfc;
            border-radius: 8px;
            padding: 20px;
        }

        /* Filter Section */
        .filter-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .filter-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .filter-title {
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
        }

        .filter-controls {
            display: flex;
            gap: 15px;
            align-items: end;
            flex-wrap: wrap;
        }

        .filter-item {
            min-width: 120px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .form-select {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 15px;
            background: #ffffff;
        }

        .btn-refresh {
            background: linear-gradient(135deg, #17a2b8, #138496);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .btn-refresh:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.4);
            color: white;
        }

        /* Table Section */
        .table-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .table-header {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f8f9fa;
            display: flex;
            justify-content: space-between;
            /* UBAH dari 'between' ke 'space-between' */
            align-items: center;
        }

        .table-title {
            font-size: 22px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .view-all-btn {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .view-all-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
            color: white;
        }

        .table {
            margin-bottom: 0;
            font-size: 15px;
        }

        .table thead th {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-bottom: 2px solid #dee2e6;
            font-weight: 700;
            color: #2c3e50;
            padding: 18px 15px;
            font-size: 15px;
            white-space: nowrap;
            border-top: none;
            text-align: center;
        }

        .table tbody td {
            padding: 20px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f4;
            font-size: 15px;
            line-height: 1.5;
            text-align: center;
        }

        .table tbody tr:hover {
            background-color: #f8f9ff;
            transform: scale(1.01);
            transition: all 0.3s ease;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Table Content Styling */
        .order-id {
            font-weight: 700;
            color: #007bff;
            font-size: 16px;
        }

        .customer-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 16px;
            margin-bottom: 3px;
        }

        .customer-phone {
            font-size: 13px;
            color: #6c757d;
        }

        .amount-value {
            font-weight: 700;
            color: #28a745;
            font-size: 16px;
        }

        .date-value {
            font-weight: 600;
            color: #2c3e50;
            font-size: 15px;
        }

        .items-count {
            background: #e3f2fd;
            color: #1565c0;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
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

        .status-delivered {
            background: #d1f2eb;
            color: #0c5460;
            border: 1px solid #7dd3fc;
        }

        .status-canceled {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status-ordered {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        /* Action Button */
        .btn-view {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
            color: white;
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
            color: #6c757d;
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

        /* Responsive Design */
        @media (max-width: 992px) {
            .filter-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-item {
                min-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .page-header,
            .filter-section,
            .table-section,
            .chart-section {
                padding: 20px;
            }

            .summary-card {
                padding: 20px;
                margin-bottom: 15px;
            }

            .summary-number {
                font-size: 28px;
            }

            .table-responsive {
                font-size: 14px;
            }

            .table thead th,
            .table tbody td {
                padding: 12px 8px;
            }
        }

        @media (max-width: 576px) {
            .table-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .view-all-btn {
                width: 100%;
                text-align: center;
            }

            .chart-legend {
                flex-direction: column;
                gap: 15px;
            }
        }

        /* Animation untuk loading */
        .loading-spinner {
            border: 3px solid #f3f4f6;
            border-top: 3px solid #007bff;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Status Badges */
        .status-container {
            display: flex;
            flex-direction: column;
            gap: 6px;
            /* align-items: flex-start; */
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
            text-align: center;
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
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h1 class="page-title">
                            <i class="icon-pie-chart"></i> Dashboard Manajemen Admin
                        </h1>
                        <p class="page-subtitle">Monitoring dan analisis bisnis e-commerce secara real-time</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-refresh" onclick="window.location.reload()">
                            <i class="icon-refresh"></i> Refresh Data
                        </button>
                    </div>
                </div>
            </div>

            <!-- Alert Stok (jika ada) -->
            @if (isset($alertStok) && $alertStok)
                <div class="alert alert-{{ $alertStok['type'] }} alert-stock">
                    <i class="alert-icon icon-alert-triangle"></i>
                    {{ $alertStok['message'] }}
                </div>
            @endif

            <!-- Summary Cards -->
            <div class="summary-section">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon">
                                <i class="icon-shopping-bag"></i>
                            </div>
                            <div class="summary-number">{{ number_format($dashboardDatas[0]->Total) }}</div>
                            <div class="summary-label">Total Pesanan</div>
                            <div class="summary-change positive">
                                <i class="icon-trending-up"></i> +12.5% dari bulan lalu
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon">
                                <i class="icon-credit-card"></i>
                            </div>
                            <div class="summary-number">{{ formatRupiah($dashboardDatas[0]->TotalAmount) }}</div>
                            <div class="summary-label">Total Pendapatan</div>
                            <div class="summary-change positive">
                                <i class="icon-trending-up"></i> +8.2% dari bulan lalu
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon">
                                <i class="icon-clock"></i>
                            </div>
                            <div class="summary-number">{{ number_format($dashboardDatas[0]->TotalOrdered) }}</div>
                            <div class="summary-label">Pesanan Pending</div>
                            <div class="summary-change negative">
                                <i class="icon-trending-down"></i> -3.1% dari kemarin
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon">
                                <i class="icon-check"></i>
                            </div>
                            <div class="summary-number">{{ number_format($dashboardDatas[0]->TotalDelivered) }}</div>
                            <div class="summary-label">Pesanan Terkirim</div>
                            <div class="summary-change positive">
                                <i class="icon-trending-up"></i> +15.7% dari kemarin
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="chart-section">
                <div class="chart-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="chart-title">
                                <i class="icon-bar-chart"></i> Analisis Pendapatan Bulanan
                            </h5>
                            <p class="chart-subtitle">Grafik performa penjualan tahun {{ date('Y') }}</p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="icon-more-horizontal"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="exportChart()">Export PNG</a></li>
                                <li><a class="dropdown-item" href="#" onclick="printChart()">Print Chart</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="chart-legend">
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #2377FC;"></div>
                        <div class="legend-label">Total</div>
                        <div class="legend-value">{{ $TotalAmount }}</div>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #FFA500;"></div>
                        <div class="legend-label">Pending</div>
                        <div class="legend-value">{{ $TotalOrderedAmount }}</div>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #078407;"></div>
                        <div class="legend-label">Delivered</div>
                        <div class="legend-value">{{ $TotalDeliveredAmount }}</div>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #FF0000;"></div>
                        <div class="legend-label">Canceled</div>
                        <div class="legend-value">{{ $TotalCanceledAmount }}</div>
                    </div>
                </div>

                <div class="chart-container">
                    <div id="line-chart-8"></div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-header">
                    <h5 class="filter-title">
                        <i class="icon-filter"></i> Filter Data Pesanan
                    </h5>
                </div>
                <form method="GET" action="{{ route('admin.index') }}">
                    <div class="filter-controls">
                        <div class="filter-item">
                            <label class="form-label">Status Pesanan</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>
                                    Delivered</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled
                                </option>
                            </select>
                        </div>
                        <div class="filter-item">
                            <label class="form-label">Periode</label>
                            <select name="period" class="form-select">
                                <option value="">Semua Periode</option>
                                <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hari Ini
                                </option>
                                <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Minggu Ini
                                </option>
                                <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Bulan Ini
                                </option>
                            </select>
                        </div>
                        <div class="filter-item">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-refresh">
                                <i class="icon-search"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Recent Orders Table -->
            <div class="table-section">
                <div class="table-header">
                    <h5 class="table-title">
                        <i class="icon-list"></i> Pesanan Terbaru
                    </h5>
                    <a href="{{ route('admin.orders') }}" class="view-all-btn">
                        <i class="icon-eye"></i> Lihat Semua Pesanan
                    </a>
                </div>

                <div class="table-responsive">
                    @if ($orders->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Items</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <div class="order-id">#{{ '1' . str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="customer-name">{{ $order->name }}</div>
                                            <div class="customer-phone">{{ $order->phone }}</div>
                                        </td>
                                        <td>
                                            <div class="amount-value">{{ formatRupiah($order->total) }}</div>
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
                                        <td>
                                            <div class="date-value">{{ $order->created_at->format('d M Y') }}</div>
                                        </td>
                                        <td>
                                            <span class="items-count">{{ $order->orderItems->count() }} items</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.order.items', ['order_id' => $order->id]) }}"
                                                class="btn-view">
                                                <i class="icon-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="icon-inbox"></i>
                            </div>
                            <h4 class="empty-title">Belum Ada Pesanan</h4>
                            <p class="empty-text">
                                Belum ada pesanan yang masuk hari ini.<br>
                                Data akan muncul ketika ada pelanggan yang melakukan pemesanan.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Loading overlay -->
    <div id="loadingOverlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.9); z-index: 9999;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
            <div class="loading-spinner"></div>
            <p style="margin-top: 15px; color: #6c757d; font-weight: 600;">Memuat data...</p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function($) {
            // Enhanced chart configuration
            var tfLineChart = (function() {
                var chartBar = function() {
                    var options = {
                        series: [{
                                name: 'Total',
                                data: [{{ $AmountM }}]
                            }, {
                                name: 'Pending',
                                data: [{{ $OrderedAmountM }}]
                            },
                            {
                                name: 'Delivered',
                                data: [{{ $DeliveredAmountM }}]
                            }, {
                                name: 'Canceled',
                                data: [{{ $CanceledAmountM }}]
                            }
                        ],
                        chart: {
                            type: 'bar',
                            height: 400,
                            toolbar: {
                                show: true,
                                tools: {
                                    download: true,
                                    selection: false,
                                    zoom: false,
                                    zoomin: false,
                                    zoomout: false,
                                    pan: false,
                                    reset: false
                                }
                            },
                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800,
                                animateGradually: {
                                    enabled: true,
                                    delay: 150
                                },
                                dynamicAnimation: {
                                    enabled: true,
                                    speed: 350
                                }
                            },
                            background: 'transparent'
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '60%',
                                endingShape: 'rounded',
                                borderRadius: 4,
                                dataLabels: {
                                    position: 'top'
                                }
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        legend: {
                            show: false,
                        },
                        colors: ['#2377FC', '#FFA500', '#078407', '#FF0000'],
                        stroke: {
                            show: true,
                            width: 0,
                            colors: ['transparent']
                        },
                        xaxis: {
                            labels: {
                                style: {
                                    colors: '#6c757d',
                                    fontSize: '14px',
                                    fontWeight: 600
                                },
                            },
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
                                'Oct', 'Nov', 'Dec'
                            ],
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            }
                        },
                        yaxis: {
                            show: true,
                            labels: {
                                style: {
                                    colors: '#6c757d',
                                    fontSize: '12px'
                                },
                                formatter: function(val) {
                                    return new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 0
                                    }).format(val);
                                }
                            }
                        },
                        grid: {
                            borderColor: '#e9ecef',
                            strokeDashArray: 5,
                            xaxis: {
                                lines: {
                                    show: false
                                }
                            },
                            yaxis: {
                                lines: {
                                    show: true
                                }
                            }
                        },
                        fill: {
                            opacity: 0.9,
                            type: 'gradient',
                            gradient: {
                                shade: 'light',
                                type: 'vertical',
                                shadeIntensity: 0.25,
                                gradientToColors: ['#4A90E2', '#FFB84D', '#66BB6A', '#FF5252'],
                                inverseColors: false,
                                opacityFrom: 0.85,
                                opacityTo: 0.65,
                                stops: [0, 100]
                            }
                        },
                        tooltip: {
                            enabled: true,
                            theme: 'dark',
                            style: {
                                fontSize: '14px'
                            },
                            y: {
                                formatter: function(val) {
                                    return new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 0
                                    }).format(val);
                                }
                            }
                        },
                        responsive: [{
                            breakpoint: 768,
                            options: {
                                chart: {
                                    height: 300
                                },
                                plotOptions: {
                                    bar: {
                                        columnWidth: '80%'
                                    }
                                }
                            }
                        }]
                    };

                    chart = new ApexCharts(
                        document.querySelector("#line-chart-8"),
                        options
                    );

                    if ($("#line-chart-8").length > 0) {
                        chart.render();
                    }
                };

                return {
                    init: function() {},
                    load: function() {
                        chartBar();
                    },
                    resize: function() {},
                };
            })();

            // Initialize chart
            jQuery(document).ready(function() {
                // Show loading
                $('#loadingOverlay').show();

                setTimeout(function() {
                    $('#loadingOverlay').hide();
                }, 1000);
            });

            jQuery(window).on("load", function() {
                tfLineChart.load();
            });

            jQuery(window).on("resize", function() {
                // Handle responsive chart resize if needed
            });

        })(jQuery);

        // Export chart functions
        function exportChart() {
            if (typeof chart !== 'undefined') {
                chart.dataURI().then(({
                    imgURI,
                    blob
                }) => {
                    const link = document.createElement('a');
                    link.href = imgURI;
                    link.download = 'chart-pendapatan-bulanan.png';
                    link.click();
                });
            }
        }

        function printChart() {
            if (typeof chart !== 'undefined') {
                chart.print();
            }
        }

        // Auto refresh data setiap 5 menit
        setInterval(function() {
            console.log('Auto refresh data...');
            // Uncomment line berikut untuk auto refresh
            // window.location.reload();
        }, 300000); // 5 menit
    </script>
@endpush

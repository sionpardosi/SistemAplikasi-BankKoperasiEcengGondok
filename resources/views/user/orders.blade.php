@extends('layouts.app')

@section('content')
    <style>
        /* Modern Brown Color Palette */
        :root {
            --primary-brown: #8B4513;
            --accent-brown: #D2B48C;
            --dark-brown: #654321;
            --light-brown: #F5E6D3;
            --cream: #FFF8DC;
            --gold: #DAA520;
            --success-green: #228B22;
            --danger-red: #DC143C;
            --warning-orange: #FF8C00;
            --info-blue: #4682B4;
            --text-dark: #2F1B14;
            --text-muted: #8B7355;
            --border-light: #E6DDD4;
            --shadow-subtle: 0 2px 8px rgba(139, 69, 19, 0.08);
            --shadow-elegant: 0 4px 20px rgba(139, 69, 19, 0.12);
            --shadow-prominent: 0 8px 32px rgba(139, 69, 19, 0.16);
            --border-radius-sm: 8px;
            --border-radius: 12px;
            --border-radius-lg: 16px;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Typography */
        .page-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-top: 60px !important;
            margin-bottom: 2.5rem !important;
            position: relative;
            letter-spacing: -0.025em;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-brown), var(--gold));
            border-radius: 2px;
        }

        /* Header Section */
        .orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .order-search {
            position: relative;
            min-width: 320px;
        }

        .order-search .input-group {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-subtle);
            border: 2px solid var(--border-light);
            transition: var(--transition-smooth);
        }

        .order-search .input-group:focus-within {
            border-color: var(--accent-brown);
            box-shadow: 0 0 0 3px rgba(210, 180, 140, 0.2);
        }

        .order-search .form-control {
            border: none;
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
            background: var(--cream);
            color: var(--text-dark);
        }

        .order-search .form-control:focus {
            outline: none;
            box-shadow: none;
            background: white;
        }

        .order-search .form-control::placeholder {
            color: var(--text-muted);
        }

        .order-search button {
            padding: 0.875rem 1.25rem;
            background: linear-gradient(135deg, var(--primary-brown), var(--dark-brown));
            color: white;
            border: none;
            transition: var(--transition-smooth);
        }

        .order-search button:hover {
            background: linear-gradient(135deg, var(--dark-brown), var(--primary-brown));
            transform: translateY(-1px);
        }

        /* Statistics Cards */
        .orders-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .summary-card {
            background: linear-gradient(135deg, white, var(--light-brown));
            padding: 1.75rem 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-elegant);
            transition: var(--transition-smooth);
            text-align: center;
            border: 1px solid var(--border-light);
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
            background: linear-gradient(135deg, var(--primary-brown), var(--gold));
        }

        .summary-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-prominent);
        }

        .summary-number {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--primary-brown);
            line-height: 1;
            margin-bottom: 0.5rem;
            display: block;
        }

        .summary-label {
            font-size: 0.875rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        /* Table Container */
        .order-table-container {
            background: white;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-elegant);
            overflow: hidden;
            border: 1px solid var(--border-light);
        }

        .table-header {
            background: linear-gradient(135deg, var(--primary-brown), var(--dark-brown));
            color: white;
            padding: 1.75rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .table-title {
            font-size: 1.375rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .order-filter {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .filter-label {
            font-size: 0.9rem;
            font-weight: 500;
            margin: 0;
            opacity: 0.9;
        }

        .filter-select {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--border-radius-sm);
            padding: 0.5rem 1rem;
            color: white;
            font-size: 0.9rem;
            min-width: 180px;
            transition: var(--transition-smooth);
        }

        .filter-select:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .filter-select option {
            background: var(--primary-brown);
            color: white;
        }

        /* Professional Table Styling */
        .table-responsive {
            background: white;
            padding: 0;
        }

        .table {
            margin: 0;
            font-size: 0.9rem;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--light-brown), var(--cream));
            color: var(--text-dark);
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1.25rem 1rem !important;
            border: none;
            border-bottom: 2px solid var(--accent-brown);
            white-space: nowrap;
            position: relative;
        }

        .table thead th::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(135deg, var(--primary-brown), var(--gold));
        }

        .table tbody td {
            padding: 1.25rem 1rem !important;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-light);
            color: var(--text-dark);
            transition: var(--transition-smooth);
        }

        .table tbody tr {
            transition: var(--transition-smooth);
        }

        .table tbody tr:hover {
            background: linear-gradient(135deg, var(--light-brown), var(--cream));
            transform: translateX(2px);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Enhanced Status Badges */
        .badge {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 20px;
            box-shadow: var(--shadow-subtle);
            border: 1px solid transparent;
            transition: var(--transition-smooth);
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }

        .badge:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-elegant);
        }

        .badge i {
            font-size: 0.7rem;
        }

        /* Status Colors with Brown Theme */
        .bg-info {
            background: linear-gradient(135deg, var(--info-blue), #5B9BD5) !important;
            border-color: var(--info-blue);
        }

        .bg-warning {
            background: linear-gradient(135deg, var(--warning-orange), #FFB347) !important;
            color: white !important;
            border-color: var(--warning-orange);
        }

        .bg-primary {
            background: linear-gradient(135deg, var(--primary-brown), var(--dark-brown)) !important;
            border-color: var(--primary-brown);
        }

        .bg-secondary {
            background: linear-gradient(135deg, var(--text-muted), #A0937D) !important;
            border-color: var(--text-muted);
        }

        .bg-success {
            background: linear-gradient(135deg, var(--success-green), #32CD32) !important;
            border-color: var(--success-green);
        }

        .bg-danger {
            background: linear-gradient(135deg, var(--danger-red), #FF6B6B) !important;
            border-color: var(--danger-red);
        }

        /* Order Number Styling */
        .order-no-column {
            color: var(--primary-brown);
            font-weight: 700;
            font-family: 'Courier New', monospace;
            font-size: 0.95rem;
        }

        .text-accent {
            color: var(--primary-brown) !important;
        }

        .fw-bold {
            font-weight: 700 !important;
        }

        /* Action Button Enhancements */
        .list-icon-function {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--light-brown), white);
            transition: var(--transition-smooth);
            position: relative;
            overflow: hidden;
            border: 2px solid var(--border-light);
        }

        .list-icon-function::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-brown), var(--gold));
            opacity: 0;
            transform: scale(0);
            transition: var(--transition-smooth);
            border-radius: 50%;
        }

        .list-icon-function:hover::before {
            opacity: 1;
            transform: scale(1);
        }

        .list-icon-function:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-elegant);
            border-color: var(--accent-brown);
        }

        .list-icon-function i {
            position: relative;
            z-index: 2;
            font-size: 1.1rem;
            color: var(--primary-brown);
            transition: var(--transition-smooth);
        }

        .list-icon-function:hover i {
            color: white;
        }

        /* Mini Timeline Progress */
        .mini-timeline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            height: 28px;
            width: 100%;
            max-width: 220px;
            margin: 0 auto;
        }

        .mini-timeline::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--border-light);
            transform: translateY(-50%);
            z-index: 1;
            border-radius: 2px;
        }

        .mini-timeline-progress {
            position: absolute;
            top: 50%;
            left: 0;
            height: 3px;
            background: linear-gradient(135deg, var(--primary-brown), var(--gold));
            transform: translateY(-50%);
            z-index: 2;
            transition: width 0.6s ease;
            border-radius: 2px;
        }

        .mini-timeline-step {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: white;
            border: 3px solid var(--border-light);
            z-index: 3;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition-smooth);
        }

        .mini-timeline-step.active {
            background: var(--primary-brown);
            border-color: var(--primary-brown);
            box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.2);
        }

        .mini-timeline-step.done {
            background: var(--success-green);
            border-color: var(--success-green);
            box-shadow: 0 0 0 3px rgba(34, 139, 34, 0.2);
        }

        .mini-timeline-step.canceled {
            background: var(--danger-red);
            border-color: var(--danger-red);
            box-shadow: 0 0 0 3px rgba(220, 20, 60, 0.2);
        }

        .mini-timeline-step i {
            font-size: 8px;
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: linear-gradient(135deg, var(--cream), white);
        }

        .empty-icon {
            font-size: 5rem;
            color: var(--accent-brown);
            margin-bottom: 1.5rem;
            opacity: 0.7;
        }

        .empty-text {
            font-size: 1.25rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
        }

        .empty-state .btn {
            background: linear-gradient(135deg, var(--primary-brown), var(--dark-brown));
            color: white;
            border: none;
            padding: 0.875rem 2rem;
            border-radius: var(--border-radius);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition-smooth);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .empty-state .btn:hover {
            background: linear-gradient(135deg, var(--dark-brown), var(--primary-brown));
            transform: translateY(-2px);
            box-shadow: var(--shadow-elegant);
            color: white;
            text-decoration: none;
        }

        /* Tooltip Enhancement */
        [data-tooltip]:hover:after {
            background: linear-gradient(135deg, var(--text-dark), var(--primary-brown));
            border-radius: var(--border-radius-sm);
            box-shadow: var(--shadow-elegant);
        }

        /* Pagination Styling */
        .pagination {
            margin-top: 2.5rem;
            justify-content: center;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary-brown), var(--dark-brown));
            border-color: var(--primary-brown);
            color: white;
        }

        .page-link {
            color: var(--primary-brown);
            border: 1px solid var(--border-light);
            border-radius: var(--border-radius-sm);
            margin: 0 3px;
            padding: 0.625rem 1rem;
            transition: var(--transition-smooth);
        }

        .page-link:hover {
            background: var(--light-brown);
            border-color: var(--accent-brown);
            color: var(--dark-brown);
            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .table {
                min-width: 1000px;
            }
        }

        @media (max-width: 992px) {
            .orders-header {
                flex-direction: column;
                align-items: stretch;
            }

            .order-search {
                min-width: auto;
            }

            .orders-summary {
                grid-template-columns: repeat(3, 1fr);
                gap: 1rem;
            }

            .table-header {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .orders-summary {
                grid-template-columns: repeat(2, 1fr);
            }

            .table thead th,
            .table tbody td {
                padding: 0.875rem 0.5rem !important;
                font-size: 0.8rem;
            }

            .badge {
                padding: 0.375rem 0.75rem;
                font-size: 0.7rem;
            }
        }

        @media (max-width: 576px) {
            .orders-summary {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 1.75rem;
            }
        }

        /* Loading Animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid var(--border-light);
            border-radius: 50%;
            border-top: 2px solid var(--primary-brown);
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Fade-in Animation */
        .fade-in {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container fade-in">
            <div class="orders-header">
                <h2 class="page-title">Pesanan Anda</h2>

                <!-- Order Search -->
                <div class="order-search">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari pesanan berdasarkan nomor atau nama...">
                        <button class="btn" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2">
                    @include('layouts.account-nav')
                </div>

                <div class="col-lg-10">
                    @if (Session::has('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle me-2"></i>{{ Session::get('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Order Summary Cards -->
                    <div class="orders-summary">
                        <div class="summary-card">
                            <div class="summary-number">{{ $orders->where('status', 'awaiting_payment')->count() + $orders->where('status', 'pending')->count() }}</div>
                            <div class="summary-label">Menunggu</div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-number">{{ $orders->where('status', 'confirmed')->count() + $orders->where('status', 'processing')->count() }}</div>
                            <div class="summary-label">Diproses</div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-number">{{ $orders->where('status', 'shipped')->count() }}</div>
                            <div class="summary-label">Dikirim</div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-number">{{ $orders->where('status', 'delivered')->count() }}</div>
                            <div class="summary-label">Sampai</div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-number">{{ $orders->where('status', 'completed')->count() }}</div>
                            <div class="summary-label">Selesai</div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-number">{{ $orders->where('status', 'canceled')->count() }}</div>
                            <div class="summary-label">Dibatalkan</div>
                        </div>
                    </div>

                    <div class="order-table-container">
                        <div class="table-header">
                            <h3 class="table-title">
                                <i class="fa fa-list-alt"></i>
                                Daftar Pesanan
                            </h3>

                            <div class="order-filter">
                                <span class="filter-label">Filter Status:</span>
                                <select class="filter-select" id="statusFilter">
                                    <option value="all">Semua Pesanan</option>
                                    <option value="awaiting_payment">Menunggu Pembayaran</option>
                                    <option value="pending">Menunggu Diproses</option>
                                    <option value="confirmed">Dikonfirmasi</option>
                                    <option value="processing">Diproses</option>
                                    <option value="shipped">Dikirim</option>
                                    <option value="delivered">Sampai</option>
                                    <option value="completed">Selesai</option>
                                    <option value="canceled">Dibatalkan</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive">
                            @if ($orders->count() > 0)
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No. Pesanan</th>
                                            <th>Nama</th>
                                            <th class="text-center">Tanggal Pesan</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Progress</th>
                                            <th class="text-center">Item</th>
                                            <th class="text-center">Tipe Pembayaran</th>
                                            <th class="text-center">Status Pembayaran</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr data-status="{{ $order->status }}">
                                                <td class="order-no-column fw-bold">
                                                    {{ '1' . str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                                </td>
                                                <td>{{ $order->name }}</td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
                                                </td>
                                                <td class="text-center fw-bold text-accent">
                                                    {{ formatRupiah($order->total) }}
                                                </td>
                                                <td class="text-center">
                                                    @if ($order->status == 'awaiting_payment')
                                                        <span class="badge bg-info"><i class="fa fa-clock me-1"></i> Menunggu Pembayaran</span>
                                                    @elseif ($order->status == 'pending')
                                                        <span class="badge bg-warning"><i class="fa fa-hourglass-half me-1"></i> Menunggu</span>
                                                    @elseif ($order->status == 'confirmed')
                                                        <span class="badge bg-info"><i class="fa fa-check me-1"></i> Dikonfirmasi</span>
                                                    @elseif ($order->status == 'processing')
                                                        <span class="badge bg-primary"><i class="fa fa-cog me-1"></i> Diproses</span>
                                                    @elseif ($order->status == 'shipped')
                                                        <span class="badge bg-secondary"><i class="fa fa-truck me-1"></i> Dikirim</span>
                                                    @elseif ($order->status == 'delivered')
                                                        <span class="badge bg-warning"><i class="fa fa-box-open me-1"></i> Sampai</span>
                                                    @elseif ($order->status == 'completed')
                                                        <span class="badge bg-success"><i class="fa fa-check-circle me-1"></i> Selesai</span>
                                                    @elseif ($order->status == 'canceled')
                                                        <span class="badge bg-danger"><i class="fa fa-times me-1"></i> Dibatalkan</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="mini-timeline">
                                                        @php
                                                            $progress = 0;
                                                            if ($order->status == 'awaiting_payment') {
                                                                $progress = 10;
                                                            } elseif ($order->status == 'pending') {
                                                                $progress = 20;
                                                            } elseif ($order->status == 'confirmed') {
                                                                $progress = 40;
                                                            } elseif ($order->status == 'processing') {
                                                                $progress = 60;
                                                            } elseif ($order->status == 'shipped') {
                                                                $progress = 80;
                                                            } elseif ($order->status == 'delivered') {
                                                                $progress = 90;
                                                            } elseif ($order->status == 'completed') {
                                                                $progress = 100;
                                                            } elseif ($order->status == 'canceled') {
                                                                $progress = 100;
                                                            }
                                                        @endphp
                                                        <div class="mini-timeline-progress" style="width: {{ $progress }}%;"></div>

                                                        <!-- Start -->
                                                        <div class="mini-timeline-step {{ in_array($order->status, ['awaiting_payment', 'pending', 'confirmed', 'processing', 'shipped', 'delivered', 'completed']) ? 'active' : ($order->status === 'canceled' ? 'canceled' : '') }}">
                                                            <i class="fa fa-circle"></i>
                                                        </div>

                                                        <!-- End -->
                                                        <div class="mini-timeline-step {{ $order->status === 'completed' ? 'done' : ($order->status === 'canceled' ? 'canceled' : '') }}">
                                                            <i class="fa fa-circle"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">{{ $order->orderItems->count() }}</td>
                                                <td class="text-center">
                                                    @if($order->transaction)
                                                        {{ $order->transaction->mode_display }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($order->transaction)
                                                        @if ($order->transaction->status == 'approved' || $order->transaction->status == 'paid')
                                                            <span class="badge bg-success"><i class="fa fa-check-circle me-1"></i> Lunas</span>
                                                        @elseif($order->transaction->status == 'pending')
                                                            <span class="badge bg-warning"><i class="fa fa-clock me-1"></i> Menunggu</span>
                                                        @elseif($order->transaction->status == 'declined')
                                                            <span class="badge bg-danger"><i class="fa fa-times-circle me-1"></i> Ditolak</span>
                                                        @elseif($order->transaction->status == 'refunded')
                                                            <span class="badge bg-info"><i class="fa fa-undo me-1"></i> Dikembalikan</span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('user.account.order.details', ['order_id' => $order->id]) }}"
                                                        class="list-icon-function view-icon" data-tooltip="Lihat Detail">
                                                        <div class="item eye">
                                                            <i class="fa fa-eye"></i>
                                                        </div>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fa fa-shopping-bag"></i>
                                    </div>
                                    <p class="empty-text">Anda belum memiliki pesanan</p>
                                    <a href="{{ route('shop.index') }}" class="btn">
                                        <i class="fa fa-shopping-cart"></i>
                                        Mulai Belanja
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const tableRows = document.querySelectorAll('tbody tr');

            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                filterRows();
            });

            // Filter functionality
            statusFilter.addEventListener('change', function() {
                filterRows();
            });

            function filterRows() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedStatus = statusFilter.value;

                tableRows.forEach(row => {
                    const orderNumber = row.querySelector('.order-no-column').textContent.toLowerCase();
                    const customerName = row.cells[1].textContent.toLowerCase();
                    const rowStatus = row.getAttribute('data-status');

                    const matchesSearch = orderNumber.includes(searchTerm) || customerName.includes(searchTerm);
                    const matchesStatus = selectedStatus === 'all' || rowStatus === selectedStatus;

                    row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
                });
            }

            // Enhanced row hover effects
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(4px)';
                });

                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });

            // Add loading state to action buttons
            document.querySelectorAll('.list-icon-function').forEach(btn => {
                btn.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    icon.className = 'fa fa-spinner fa-spin';
                });
            });
        });
    </script>
@endsection

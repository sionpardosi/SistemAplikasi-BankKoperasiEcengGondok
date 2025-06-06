@extends('layouts.app')

@section('content')
    <style>
        /* Modern Elegant Color Palette */
        :root {
            --primary-brown: #8B7355;
            --secondary-brown: #A68A64;
            --accent-gold: #C9A96E;
            --light-brown: #F5F1EA;
            --cream: #FEFCF7;
            --soft-gray: #F8F9FA;
            --border-light: #E8E5E0;
            --text-primary: #2D3436;
            --text-secondary: #636E72;
            --text-muted: #95A5A6;
            --success: #00B894;
            --warning: #FDCB6E;
            --danger: #E17055;
            --info: #74B9FF;
            --shadow-soft: 0 2px 12px rgba(0, 0, 0, 0.08);
            --shadow-medium: 0 4px 20px rgba(0, 0, 0, 0.12);
            --shadow-strong: 0 8px 30px rgba(0, 0, 0, 0.16);
            --radius-sm: 6px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Base Styles */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, var(--cream) 0%, var(--soft-gray) 100%);
            color: var(--text-primary);
            line-height: 1.6;
        }

        /* Page Header - Simple Style */
        .page-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-top: 60px !important;
            margin-bottom: 2rem !important;
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
            background: linear-gradient(135deg, var(--primary-brown), var(--accent-gold));
            border-radius: 2px;
        }

        /* Orders Header Section */
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
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-soft);
            border: 2px solid var(--border-light);
            transition: var(--transition);
        }

        .order-search .input-group:focus-within {
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 3px rgba(201, 169, 110, 0.2);
        }

        .order-search .form-control {
            border: none;
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
            background: var(--cream);
            color: var(--text-primary);
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
            background: linear-gradient(135deg, var(--primary-brown), var(--secondary-brown));
            color: white;
            border: none;
            transition: var(--transition);
        }

        .order-search button:hover {
            background: linear-gradient(135deg, var(--secondary-brown), var(--accent-gold));
            transform: translateY(-1px);
        }

        /* Statistics Cards - Smaller & Brown Tinted */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #FAF7F0, #F5EFE1);
            border-radius: var(--radius-md);
            padding: 1.25rem 1rem;
            text-align: center;
            box-shadow: var(--shadow-soft);
            border: 1px solid #E8DDD0;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-brown), var(--accent-gold));
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-medium);
            background: linear-gradient(135deg, #F8F4EC, #F0E8D6);
        }

        .stat-number {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-brown);
            margin-bottom: 0.375rem;
            display: block;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Main Content Container */
        .orders-container {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-soft);
            overflow: hidden;
            border: 1px solid var(--border-light);
        }

        .container-header {
            background: linear-gradient(135deg, var(--light-brown), var(--cream));
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-light);
        }

        .container-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .container-title i {
            color: var(--primary-brown);
        }

        /* Enhanced Table Design */
        .table-wrapper {
            overflow-x: auto;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            font-size: 0.95rem;
        }

        .orders-table thead th {
            background: linear-gradient(135deg, var(--soft-gray), var(--light-brown));
            color: var(--text-primary) !important;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1.25rem 1rem;
            border: none;
            text-align: left;
            position: relative;
        }

        .orders-table thead th.text-center {
            text-align: center;
        }

        .orders-table thead th::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 1rem;
            right: 1rem;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-brown), var(--accent-gold));
        }

        .orders-table tbody td {
            padding: 1.5rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-light);
            transition: var(--transition);
        }

        .orders-table tbody tr {
            transition: var(--transition);
            cursor: pointer;
        }

        .orders-table tbody tr:hover {
            background: linear-gradient(135deg, var(--cream), var(--light-brown));
            transform: scale(1.01);
            box-shadow: var(--shadow-soft);
        }

        .orders-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Order Information Styling */
        .order-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .order-number {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary-brown);
            font-family: 'JetBrains Mono', 'Courier New', monospace;
        }

        .customer-name {
            font-size: 0.9rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .order-date {
            font-size: 0.875rem;
            color: var(--text-primary);
            font-weight: 500;
        }

        .order-time {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .order-summary {
            text-align: center;
        }

        .order-total {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-brown);
            margin-bottom: 0.25rem;
        }

        .items-count {
            font-size: 0.825rem;
            color: var(--text-muted);
            background: var(--light-brown);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            display: inline-block;
        }

        /* Enhanced Status Badges */
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
            border: 2px solid transparent;
        }

        .status-badge:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-soft);
        }

        .status-badge i {
            font-size: 0.75rem;
        }

        /* Status Colors - Softer Palette */
        .badge-awaiting {
            background: linear-gradient(135deg, #E3F2FD, #BBDEFB);
            color: #1976D2;
            border-color: #E3F2FD;
        }

        .badge-pending {
            background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
            color: #F57C00;
            border-color: #FFF3E0;
        }

        .badge-confirmed {
            background: linear-gradient(135deg, #E8F5E8, #C8E6C9);
            color: #388E3C;
            border-color: #E8F5E8;
        }

        .badge-processing {
            background: linear-gradient(135deg, #F3E5F5, #E1BEE7);
            color: #7B1FA2;
            border-color: #F3E5F5;
        }

        .badge-shipped {
            background: linear-gradient(135deg, #FFF8E1, #FFECB3);
            color: #F9A825;
            border-color: #FFF8E1;
        }

        .badge-delivered {
            background: linear-gradient(135deg, #E0F2F1, #B2DFDB);
            color: #00695C;
            border-color: #E0F2F1;
        }

        .badge-completed {
            background: linear-gradient(135deg, #E8F5E8, #C8E6C9);
            color: #2E7D32;
            border-color: #E8F5E8;
        }

        .badge-canceled {
            background: linear-gradient(135deg, #FFEBEE, #FFCDD2);
            color: #C62828;
            border-color: #FFEBEE;
        }

        /* Progress Indicator */
        .progress-container {
            margin-top: 0.75rem;
        }

        .progress-bar-custom {
            width: 100%;
            height: 6px;
            background: var(--border-light);
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-brown), var(--accent-gold));
            border-radius: 3px;
            transition: width 0.6s ease;
        }

        .progress-text {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-align: center;
            margin-top: 0.5rem;
        }

        /* Payment Information */
        .payment-info {
            text-align: center;
        }

        .payment-method {
            background: var(--light-brown);
            color: var(--text-primary);
            padding: 0.375rem 0.875rem;
            border-radius: 16px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: inline-block;
            border: 1px solid var(--border-light);
        }

        .payment-status {
            font-size: 0.8rem;
        }

        .payment-paid {
            color: var(--success);
        }

        .payment-pending {
            color: var(--warning);
        }

        .payment-failed {
            color: var(--danger);
        }

        /* Action Button */
        .action-btn {
            background: linear-gradient(135deg, var(--primary-brown), var(--secondary-brown));
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius-md);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            box-shadow: var(--shadow-soft);
        }

        .action-btn:hover {
            background: linear-gradient(135deg, var(--secondary-brown), var(--accent-gold));
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
            color: white;
            text-decoration: none;
        }

        .action-btn i {
            font-size: 0.875rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: linear-gradient(135deg, var(--cream), white);
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--accent-gold);
            margin-bottom: 1.5rem;
            opacity: 0.8;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .empty-text {
            font-size: 1rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        .empty-action {
            background: linear-gradient(135deg, var(--primary-brown), var(--accent-gold));
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: var(--radius-md);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            box-shadow: var(--shadow-medium);
        }

        .empty-action:hover {
            background: linear-gradient(135deg, var(--accent-gold), var(--primary-brown));
            transform: translateY(-2px);
            box-shadow: var(--shadow-strong);
            color: white;
            text-decoration: none;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .orders-table {
                min-width: 900px;
            }
        }

        @media (max-width: 992px) {
            .orders-header {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .order-search {
                min-width: auto;
            }

            .filter-group {
                flex-direction: column;
                align-items: stretch;
                gap: 0.5rem;
            }

            .filter-select {
                min-width: auto;
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 0.875rem;
            }
        }

        @media (max-width: 768px) {
            .controls-section {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }

            .stat-card {
                padding: 1rem 0.75rem;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .stat-label {
                font-size: 0.75rem;
            }

            .orders-table thead th,
            .orders-table tbody td {
                padding: 1rem 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.625rem;
            }

            .stat-card {
                padding: 0.875rem 0.625rem;
            }

            .stat-number {
                font-size: 1.375rem;
            }

            .page-title {
                font-size: 1.75rem;
            }

            .orders-table {
                font-size: 0.875rem;
            }

            .orders-header {
                margin-bottom: 1.5rem;
            }
        }

        /* Animations */
        .fade-in {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .loading-spinner {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid var(--border-light);
            border-radius: 50%;
            border-top: 2px solid var(--primary-brown);
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Alert Styling */
        .alert {
            border-radius: var(--radius-md);
            border: none;
            box-shadow: var(--shadow-soft);
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #E8F5E8, #C8E6C9);
            color: #2E7D32;
        }

        /* Pagination Styling */
        .pagination {
            margin-top: 2rem;
            justify-content: center;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary-brown), var(--secondary-brown));
            border-color: var(--primary-brown);
            color: white;
        }

        .page-link {
            color: var(--primary-brown);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-sm);
            margin: 0 2px;
            padding: 0.625rem 1rem;
            transition: var(--transition);
        }

        .page-link:hover {
            background: var(--light-brown);
            border-color: var(--accent-gold);
            color: var(--text-primary);
            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Filter Section */
        .controls-section {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-soft);
            padding: 1.25rem 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border-light);
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            justify-content: center;
        }

        .filter-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-secondary);
            white-space: nowrap;
        }

        .filter-select {
            padding: 0.875rem 1rem;
            border: 2px solid var(--border-light);
            border-radius: var(--radius-md);
            background: white;
            color: var(--text-primary);
            font-size: 0.9rem;
            min-width: 200px;
            transition: var(--transition);
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 3px rgba(201, 169, 110, 0.1);
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
                            <i class="fas fa-search"></i>
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
                            <i class="fas fa-check-circle me-2"></i>{{ Session::get('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Filter Section -->
                    <div class="controls-section">
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fas fa-filter me-1"></i>
                                Filter Status:
                            </label>
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

                    <!-- Statistics Cards -->
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-number">{{ $orders->where('status', 'awaiting_payment')->count() + $orders->where('status', 'pending')->count() }}</div>
                            <div class="stat-label">Menunggu</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">{{ $orders->where('status', 'confirmed')->count() + $orders->where('status', 'processing')->count() }}</div>
                            <div class="stat-label">Diproses</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">{{ $orders->where('status', 'shipped')->count() }}</div>
                            <div class="stat-label">Dikirim</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">{{ $orders->where('status', 'delivered')->count() }}</div>
                            <div class="stat-label">Sampai</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">{{ $orders->where('status', 'completed')->count() }}</div>
                            <div class="stat-label">Selesai</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">{{ $orders->where('status', 'canceled')->count() }}</div>
                            <div class="stat-label">Dibatalkan</div>
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <div class="orders-container">
                        <div class="container-header">
                            <h3 class="container-title">
                                <i class="fas fa-list-ul"></i>
                                Daftar Pesanan
                            </h3>
                        </div>

                        <div class="table-wrapper">
                            @if ($orders->count() > 0)
                                <table class="orders-table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <i class="fas fa-hashtag me-1"></i>
                                                Pesanan
                                            </th>
                                            <th class="text-center">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                Tanggal
                                            </th>
                                            <th class="text-center">
                                                <i class="fas fa-money-bill-wave me-1"></i>
                                                Total & Items
                                            </th>
                                            <th class="text-center">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Status
                                            </th>
                                            <th class="text-center">
                                                <i class="fas fa-credit-card me-1"></i>
                                                Pembayaran
                                            </th>
                                            <th class="text-center">
                                                <i class="fas fa-eye me-1"></i>
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr class="order-row" data-status="{{ $order->status }}">
                                                <td>
                                                    <div class="order-info">
                                                        <div class="order-number">
                                                            #{{ '1' . str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                                        </div>
                                                        <div class="customer-name">{{ $order->name }}</div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="order-date">
                                                        {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
                                                    </div>
                                                    <div class="order-time">
                                                        {{ \Carbon\Carbon::parse($order->created_at)->format('H:i') }}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="order-summary">
                                                        <div class="order-total">
                                                            {{ formatRupiah($order->total) }}
                                                        </div>
                                                        <div class="items-count">
                                                            {{ $order->orderItems->count() }} {{ $order->orderItems->count() > 1 ? 'items' : 'item' }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $statusConfig = [
                                                            'awaiting_payment' => ['class' => 'badge-awaiting', 'icon' => 'fas fa-clock', 'text' => 'Menunggu Pembayaran', 'progress' => 10],
                                                            'pending' => ['class' => 'badge-pending', 'icon' => 'fas fa-hourglass-half', 'text' => 'Menunggu', 'progress' => 20],
                                                            'confirmed' => ['class' => 'badge-confirmed', 'icon' => 'fas fa-check', 'text' => 'Dikonfirmasi', 'progress' => 40],
                                                            'processing' => ['class' => 'badge-processing', 'icon' => 'fas fa-cog', 'text' => 'Diproses', 'progress' => 60],
                                                            'shipped' => ['class' => 'badge-shipped', 'icon' => 'fas fa-truck', 'text' => 'Dikirim', 'progress' => 80],
                                                            'delivered' => ['class' => 'badge-delivered', 'icon' => 'fas fa-box-open', 'text' => 'Sampai', 'progress' => 90],
                                                            'completed' => ['class' => 'badge-completed', 'icon' => 'fas fa-check-circle', 'text' => 'Selesai', 'progress' => 100],
                                                            'canceled' => ['class' => 'badge-canceled', 'icon' => 'fas fa-times', 'text' => 'Dibatalkan', 'progress' => 100]
                                                        ];
                                                        $status = $statusConfig[$order->status] ?? $statusConfig['pending'];
                                                    @endphp

                                                    <div class="status-badge {{ $status['class'] }}">
                                                        <i class="{{ $status['icon'] }}"></i>
                                                        {{ $status['text'] }}
                                                    </div>

                                                    <div class="progress-container">
                                                        <div class="progress-bar-custom">
                                                            <div class="progress-fill" style="width: {{ $status['progress'] }}%;"></div>
                                                        </div>
                                                        <div class="progress-text">{{ $status['progress'] }}% selesai</div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="payment-info">
                                                        @if($order->transaction)
                                                            <div class="payment-method">
                                                                <i class="fas fa-credit-card me-1"></i>
                                                                {{ $order->transaction->mode_display }}
                                                            </div>
                                                            @if ($order->transaction->status == 'approved' || $order->transaction->status == 'paid')
                                                                <div class="payment-status payment-paid">
                                                                    <i class="fas fa-check-circle me-1"></i>
                                                                    Lunas
                                                                </div>
                                                            @elseif($order->transaction->status == 'pending')
                                                                <div class="payment-status payment-pending">
                                                                    <i class="fas fa-clock me-1"></i>
                                                                    Menunggu
                                                                </div>
                                                            @elseif($order->transaction->status == 'declined')
                                                                <div class="payment-status payment-failed">
                                                                    <i class="fas fa-times-circle me-1"></i>
                                                                    Gagal
                                                                </div>
                                                            @elseif($order->transaction->status == 'refunded')
                                                                <div class="payment-status payment-pending">
                                                                    <i class="fas fa-undo me-1"></i>
                                                                    Dikembalikan
                                                                </div>
                                                            @endif
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('user.account.order.details', ['order_id' => $order->id]) }}"
                                                        class="action-btn">
                                                        <i class="fas fa-eye"></i>
                                                        Lihat Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-shopping-bag"></i>
                                    </div>
                                    <h3 class="empty-title">Belum Ada Pesanan</h3>
                                    <p class="empty-text">Anda belum memiliki pesanan. Mulai berbelanja sekarang!</p>
                                    <a href="{{ route('shop.index') }}" class="empty-action">
                                        <i class="fas fa-shopping-cart"></i>
                                        Mulai Belanja
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if ($orders->count() > 0)
                        <div class="d-flex justify-content-center">
                            {{ $orders->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize elements
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const tableRows = document.querySelectorAll('.order-row');

            // Search functionality with debounce
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    filterRows();
                }, 300);
            });

            // Filter functionality
            statusFilter.addEventListener('change', function() {
                filterRows();
            });

            // Filter function
            function filterRows() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedStatus = statusFilter.value;

                let visibleCount = 0;

                tableRows.forEach(row => {
                    const orderNumber = row.querySelector('.order-number').textContent.toLowerCase();
                    const customerName = row.querySelector('.customer-name').textContent.toLowerCase();
                    const rowStatus = row.getAttribute('data-status');

                    const matchesSearch = orderNumber.includes(searchTerm) || customerName.includes(searchTerm);
                    const matchesStatus = selectedStatus === 'all' || rowStatus === selectedStatus;

                    if (matchesSearch && matchesStatus) {
                        row.style.display = '';
                        visibleCount++;

                        // Add staggered animation
                        setTimeout(() => {
                            row.style.opacity = '1';
                            row.style.transform = 'translateX(0)';
                        }, visibleCount * 50);
                    } else {
                        row.style.display = 'none';
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(-20px)';
                    }
                });

                // Update result count (optional)
                updateResultCount(visibleCount);
            }

            // Update result count display
            function updateResultCount(count) {
                const containerTitle = document.querySelector('.container-title');
                const existingCount = containerTitle.querySelector('.result-count');

                if (existingCount) {
                    existingCount.remove();
                }

                if (searchInput.value || statusFilter.value !== 'all') {
                    const countSpan = document.createElement('span');
                    countSpan.className = 'result-count';
                    countSpan.style.cssText = `
                        font-size: 0.9rem;
                        color: var(--text-muted);
                        font-weight: 400;
                        margin-left: 0.5rem;
                    `;
                    countSpan.textContent = `(${count} hasil)`;
                    containerTitle.appendChild(countSpan);
                }
            }

            // Enhanced row interactions
            tableRows.forEach((row, index) => {
                // Set initial animation delay
                row.style.animationDelay = `${index * 0.1}s`;

                // Add hover sound effect (optional)
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.01) translateX(4px)';
                });

                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1) translateX(0)';
                });

                // Add click to select functionality
                row.addEventListener('click', function(e) {
                    // Don't trigger if clicking on action button
                    if (!e.target.closest('.action-btn')) {
                        // Add selection highlighting
                        tableRows.forEach(r => r.classList.remove('selected'));
                        this.classList.add('selected');
                    }
                });
            });

            // Action button loading states
            document.querySelectorAll('.action-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const icon = this.querySelector('i');
                    const originalClass = icon.className;
                    const originalText = this.textContent.trim();

                    // Show loading state
                    icon.className = 'fas fa-spinner fa-spin';
                    this.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Memuat...`;
                    this.style.pointerEvents = 'none';

                    // Restore original state after timeout (fallback)
                    setTimeout(() => {
                        icon.className = originalClass;
                        this.innerHTML = `<i class="${originalClass}"></i> ${originalText.replace(/.*/, 'Lihat Detail')}`;
                        this.style.pointerEvents = 'auto';
                    }, 3000);
                });
            });

            // Smooth scrolling for pagination
            document.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', function() {
                    // Add loading state to pagination
                    const spinner = document.createElement('div');
                    spinner.className = 'loading-spinner';
                    spinner.style.cssText = `
                        position: fixed;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        z-index: 9999;
                    `;
                    document.body.appendChild(spinner);

                    // Remove spinner after page loads
                    setTimeout(() => {
                        if (spinner.parentNode) {
                            spinner.parentNode.removeChild(spinner);
                        }
                    }, 2000);
                });
            });

            // Auto-hide alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 300);
                }, 5000);
            });

            // Initialize progress bars animation
            const progressBars = document.querySelectorAll('.progress-fill');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + F to focus search
                if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                    e.preventDefault();
                    searchInput.focus();
                }

                // Escape to clear search
                if (e.key === 'Escape') {
                    searchInput.value = '';
                    statusFilter.value = 'all';
                    filterRows();
                }
            });

            // Add selection styling
            const style = document.createElement('style');
            style.textContent = `
                .order-row.selected {
                    background: linear-gradient(135deg, rgba(139, 115, 85, 0.1), rgba(201, 169, 110, 0.1)) !important;
                    border-left: 4px solid var(--primary-brown);
                    transform: translateX(4px) !important;
                }
            `;
            document.head.appendChild(style);
        });
    </script>
@endsection

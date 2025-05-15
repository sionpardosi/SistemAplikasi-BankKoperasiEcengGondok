@extends('layouts.app')

@section('content')
    <style>
        /* Gaya Dasar dan Variabel */
        :root {
            --primary-color: #6a6e51;
            --accent-color: #b9a16b;
            --success-color: #40c710;
            --danger-color: #f44032;
            --warning-color: #f5d700;
            --info-color: #17a2b8;
            --secondary-color: #6c757d;
            --text-dark: #333333;
            --text-muted: #6c757d;
            --border-light: #e1e1e1;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 8px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 8px 16px rgba(0, 0, 0, 0.15);
            --border-radius: 8px;
            --transition-normal: all 0.3s ease;
        }

        /* Header dan Judul */
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-top: 60px !important;
            position: relative;
            display: inline-block;
            padding-bottom: 12px;
            letter-spacing: 1px;
            margin-bottom: 1.5rem !important;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--accent-color);
        }

        .orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .orders-summary {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .summary-card {
            flex: 1;
            min-width: 160px;
            padding: 1rem;
            border-radius: var(--border-radius);
            background-color: #fff;
            box-shadow: var(--shadow-sm);
            transition: var(--transition-normal);
            text-align: center;
            border-left: 4px solid var(--accent-color);
            position: relative;
            overflow: hidden;
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: rgba(185, 161, 107, 0.1);
            z-index: 0;
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .summary-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent-color);
            line-height: 1;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .summary-label {
            font-size: 0.9rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            z-index: 1;
        }

        /* Tabel Styling */
        .order-table-container {
            background-color: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 1.5rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .order-table-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-light);
            padding-bottom: 1rem;
        }

        .table-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            position: relative;
            padding-left: 15px;
        }

        .table-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 5px;
            height: 20px;
            background-color: var(--accent-color);
            border-radius: 3px;
        }

        .order-filter {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .filter-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-muted);
            margin: 0;
        }

        .filter-select {
            border: 1px solid var(--border-light);
            border-radius: 4px;
            padding: 0.35rem 0.75rem;
            font-size: 0.9rem;
            transition: var(--transition-normal);
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(185, 161, 107, 0.25);
        }

        .table> :not(caption)>tr>th {
            padding: 1rem 1.5rem !important;
            background-color: var(--primary-color) !important;
            color: white !important;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            vertical-align: middle;
            border: none;
            white-space: nowrap;
        }

        .table> :not(caption)>tr>td {
            padding: 1rem 1.5rem !important;
            vertical-align: middle;
            font-size: 0.95rem;
            white-space: nowrap;
        }

        .table-bordered> :not(caption)>tr>th,
        .table-bordered> :not(caption)>tr>td {
            border-width: 1px;
            border-color: var(--border-light);
        }

        .table-striped>tbody>tr:nth-of-type(odd)>* {
            background-color: rgba(106, 110, 81, 0.05);
        }

        .table-responsive {
            border-radius: var(--border-radius);
            overflow-x: auto; /* Ensure horizontal scrolling works */
            width: 100%; /* Make sure it takes full width */
            display: block; /* Fix for overflow issues */
        }

        /* Status Badge Styling */
        .badge {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 20px;
            box-shadow: var(--shadow-sm);
        }

        .bg-success {
            background-color: var(--success-color) !important;
            transition: var(--transition-normal);
        }

        .bg-danger {
            background-color: var(--danger-color) !important;
            transition: var(--transition-normal);
        }

        .bg-warning {
            background-color: var(--warning-color) !important;
            color: #000 !important;
            transition: var(--transition-normal);
        }

        .bg-info {
            background-color: var(--info-color) !important;
            transition: var(--transition-normal);
        }

        .bg-secondary {
            background-color: var(--secondary-color) !important;
            transition: var(--transition-normal);
        }

        /* Animasi Badge */
        .badge:hover {
            transform: scale(1.05);
        }

        /* Action Button Styling */
        .list-icon-function {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(106, 110, 81, 0.1);
            transition: var(--transition-normal);
            position: relative;
            overflow: hidden;
        }

        .list-icon-function::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--accent-color);
            opacity: 0;
            transform: scale(0);
            transition: var(--transition-normal);
            border-radius: 50%;
        }

        .list-icon-function:hover::before {
            opacity: 1;
            transform: scale(1);
        }

        .list-icon-function i {
            position: relative;
            z-index: 1;
            transition: var(--transition-normal);
        }

        .list-icon-function:hover i {
            color: white;
        }

        .item.eye i {
            color: var(--accent-color);
            font-size: 1.2rem;
        }

        /* Pagination Styling */
        .wgp-pagination {
            margin-top: 1.5rem;
        }

        .pagination {
            justify-content: center;
        }

        .page-item.active .page-link {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .page-link {
            color: var(--accent-color);
            border-radius: 4px;
            margin: 0 2px;
        }

        .page-link:hover {
            color: var(--primary-color);
            background-color: rgba(185, 161, 107, 0.1);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 0;
        }

        .empty-icon {
            font-size: 4rem;
            color: #ccc;
            margin-bottom: 1rem;
            animation: pulse 2s infinite;
        }

        .empty-text {
            font-size: 1.2rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        /* Search Box Styling */
        .order-search .input-group {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .order-search .form-control {
            border: 1px solid rgba(185, 161, 107, 0.2);
            border-right: none;
            padding: 0.6rem 1rem;
            transition: var(--transition-normal);
        }

        .order-search .form-control:focus {
            outline: none;
            box-shadow: none;
            border-color: var(--accent-color);
        }

        .order-search button {
            padding: 0.6rem 1.2rem;
            background-color: var(--accent-color);
            color: white;
            border: none;
            transition: var(--transition-normal);
        }

        .order-search button:hover {
            background-color: var(--primary-color);
        }

        /* Order Status Timeline - Mini Version */
        .mini-timeline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            height: 24px;
            width: 100%;
            max-width: 200px;
            margin: 0 auto;
        }

        .mini-timeline::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #e0e0e0;
            transform: translateY(-50%);
            z-index: 1;
        }

        .mini-timeline-progress {
            position: absolute;
            top: 50%;
            left: 0;
            height: 2px;
            background-color: var(--accent-color);
            transform: translateY(-50%);
            z-index: 2;
            transition: width 0.3s ease;
        }

        .mini-timeline-step {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: #e0e0e0;
            z-index: 3;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mini-timeline-step.active {
            background-color: var(--accent-color);
        }

        .mini-timeline-step.canceled {
            background-color: var(--danger-color);
        }

        .mini-timeline-step.done {
            background-color: var(--success-color);
        }

        .mini-timeline-step i {
            font-size: 8px;
            color: white;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }

            50% {
                transform: scale(1.05);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 0.8;
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Gaya Tambahan */
        .fw-bold {
            font-weight: 700 !important;
        }

        .text-accent {
            color: var(--accent-color) !important;
        }

        .order-no-column {
            color: var(--accent-color);
            font-weight: 600;
        }

        /* Tooltip styling */
        [data-tooltip] {
            position: relative;
            cursor: pointer;
        }

        [data-tooltip]:after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 0.5rem 1rem;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            border-radius: 4px;
            font-size: 0.8rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition-normal);
            z-index: 10;
        }

        [data-tooltip]:hover:after {
            opacity: 1;
            visibility: visible;
            bottom: calc(100% + 10px);
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .table-responsive {
                margin-bottom: 1.5rem;
            }

            .orders-summary {
                gap: 1rem;
            }

            .summary-card {
                min-width: 120px;
            }
        }

        @media (max-width: 768px) {
            .orders-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .table-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .order-search {
                width: 100%;
            }

            .order-search .input-group {
                width: 100%;
            }
        }

        /* Fix for table display - ensure horizontal scrolling */
        .table {
            width: 100%;
            min-width: 1200px; /* Set a minimum width to ensure all columns are visible with scrolling */
            margin-bottom: 0;
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
                        <input type="text" class="form-control" placeholder="Cari pesanan berdasarkan nomor atau nama...">
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
                            {{ Session::get('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Order Summary Cards -->
                    <div class="orders-summary">
                        <div class="summary-card">
                            <div class="summary-number">{{ $orders->where('status', 'pending')->count() }}</div>
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
                            <h3 class="table-title">Daftar Pesanan</h3>

                            <div class="order-filter">
                                <span class="filter-label">Filter Status:</span>
                                <select class="filter-select" id="statusFilter">
                                    <option value="all">Semua Pesanan</option>
                                    <option value="pending">Menunggu</option>
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
                                            <tr>
                                                <td class="order-no-column fw-bold">
                                                    {{ '1' . str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                                <td>{{ $order->name }}</td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                                                <td class="text-center fw-bold text-accent">Rp.
                                                    {{ number_format($order->total) }}</td>
                                                <td class="text-center">
                                                    @if ($order->status == 'pending')
                                                        <span class="badge bg-warning"><i class="fa fa-clock me-1"></i> Menunggu</span>
                                                    @elseif ($order->status == 'confirmed')
                                                        <span class="badge bg-info"><i class="fa fa-check me-1"></i> Dikonfirmasi</span>
                                                    @elseif ($order->status == 'processing')
                                                        <span class="badge bg-primary"><i class="fa fa-cog me-1"></i> Diproses</span>
                                                    @elseif ($order->status == 'shipped')
                                                        <span class="badge bg-secondary"><i class="fa fa-truck me-1"></i> Dikirim</span>
                                                    @elseif ($order->status == 'delivered')
                                                        <span class="badge bg-warning"><i class="fa fa-box-open me-1"></i> Menunggu Konfirmasi</span>
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
                                                            if ($order->status == 'pending') {
                                                                $progress = 0;
                                                            } elseif ($order->status == 'confirmed') {
                                                                $progress = 20;
                                                            } elseif ($order->status == 'processing') {
                                                                $progress = 40;
                                                            } elseif ($order->status == 'shipped') {
                                                                $progress = 60;
                                                            } elseif ($order->status == 'delivered') {
                                                                $progress = 80;
                                                            } elseif ($order->status == 'completed') {
                                                                $progress = 100;
                                                            } elseif ($order->status == 'canceled') {
                                                                $progress = 100;
                                                            }
                                                        @endphp
                                                        <div class="mini-timeline-progress" style="width: {{ $progress }}%;"></div>

                                                        <!-- Pending -->
                                                        <div class="mini-timeline-step {{ in_array($order->status, ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'completed']) ? 'active' : ($order->status === 'canceled' ? 'canceled' : '') }}">
                                                            <i class="fa fa-circle"></i>
                                                        </div>

                                                        <!-- Completed/Canceled -->
                                                        <div class="mini-timeline-step {{ $order->status === 'completed' ? 'done' : ($order->status === 'canceled' ? 'canceled' : '') }}">
                                                            <i class="fa fa-circle"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">{{ $order->orderItems->count() }}</td>
                                                <td class="text-center">
                                                    @if($order->transaction)
                                                        {{ $order->transaction->mode }}
                                                    @else
                                                        -
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
                                                        -
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
                                    <a href="{{ route('shop.index') }}" class="btn"
                                        style="background-color: var(--accent-color); color: white;">
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
            // Highlight table rows on hover
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = 'rgba(185, 161, 107, 0.05)';
                    this.style.transition = 'all 0.3s ease';
                });
                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });

            // Filter functionality
            const statusFilter = document.getElementById('statusFilter');
            if (statusFilter) {
                statusFilter.addEventListener('change', function() {
                    const status = this.value;
                    const rows = document.querySelectorAll('tbody tr');

                    rows.forEach(row => {
                        const statusCell = row.querySelector('td:nth-child(5)');
                        if (statusCell) {
                            const badgeText = statusCell.textContent.trim().toLowerCase();

                            if (status === 'all') {
                                row.style.display = '';
                            } else if (
                                (status === 'pending' && badgeText.includes('menunggu')) ||
                                (status === 'confirmed' && badgeText.includes('dikonfirmasi')) ||
                                (status === 'processing' && badgeText.includes('diproses')) ||
                                (status === 'shipped' && badgeText.includes('dikirim')) ||
                                (status === 'delivered' && badgeText.includes('menunggu konfirmasi')) ||
                                (status === 'completed' && badgeText.includes('selesai')) ||
                                (status === 'canceled' && badgeText.includes('dibatalkan'))
                            ) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    });

                    // Update visible count after filtering
                    updateVisibleCount();
                });
            }

            //
            function updateVisibleCount() {
                const visibleRows = Array.from(document.querySelectorAll('tbody tr')).filter(row => row.style.display !== 'none');
                const countElement = document.querySelector('.visible-count');
                if (countElement) {
                    countElement.textContent = `Menampilkan ${visibleRows.length} dari ${tableRows.length} pesanan`;
                }
            }
            updateVisibleCount();
        });
    </script>
@endsection

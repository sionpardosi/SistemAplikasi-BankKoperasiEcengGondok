@extends('layouts.app')

@section('content')
    <style>
        /* Modern CSS Variables */
        :root {
            --primary-color: #6a6e51;
            --primary-light: #8a8f69;
            --secondary-color: #e8e9e1;
            --accent-color: #d4b96e;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --text-dark: #2c3e50;
            --text-muted: #6c757d;
            --text-light: #95a5a6;
            --border-color: #dee2e6;
            --bg-light: #f8f9fa;
            --bg-white: #ffffff;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
            --radius-sm: 6px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Base Typography */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
        }

        /* Page Header */
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-top: 80px !important;
            margin-bottom: 2rem !important;
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }

        /* Card System */
        .order-card {
            background: var(--bg-white);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: var(--transition);
            border: 1px solid var(--border-color);
        }

        .order-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            padding: 1.5rem;
            border: none;
        }

        .card-header h5 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-body {
            padding: 2rem;
        }

        /* Alert System */
        .alert {
            border: none;
            border-radius: var(--radius-md);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            font-size: 1rem;
            box-shadow: var(--shadow-sm);
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border-left: 4px solid var(--success-color);
        }

        .alert-info {
            background: linear-gradient(135deg, #d1ecf1, #bee5eb);
            color: #0c5460;
            border-left: 4px solid var(--info-color);
        }

        .alert-warning {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            color: #856404;
            border-left: 4px solid var(--warning-color);
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            border-left: 4px solid var(--danger-color);
        }

        /* Status Timeline */
        .status-timeline {
            position: relative;
            padding: 2rem 1rem;
            background: var(--bg-light);
            border-radius: var(--radius-md);
            margin: 1.5rem 0;
        }

        .timeline-container {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 100%;
            overflow-x: auto;
            padding: 1rem 0;
        }

        .timeline-line {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--border-color);
            border-radius: 2px;
            transform: translateY(-50%);
            z-index: 1;
        }

        .timeline-progress {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: linear-gradient(90deg, var(--success-color), var(--primary-color));
            border-radius: 2px;
            transition: var(--transition);
            z-index: 2;
        }

        .timeline-step {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 120px;
            z-index: 3;
        }

        .step-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--border-color);
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .step-icon.active {
            background: var(--primary-color);
            color: white;
            animation: pulse 2s infinite;
        }

        .step-icon.completed {
            background: var(--success-color);
            color: white;
        }

        .step-icon.cancelled {
            background: var(--danger-color);
            color: white;
        }

        .step-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-dark);
            text-align: center;
            margin-bottom: 0.25rem;
        }

        .step-date {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-align: center;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(106, 110, 81, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(106, 110, 81, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(106, 110, 81, 0);
            }
        }

        /* Tables */
        .table-container {
            background: white;
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
        }

        .table {
            margin-bottom: 0;
            font-size: 1rem;
        }

        .table thead th {
            background: var(--primary-color);
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 1.25rem 1rem;
            border: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 1.25rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
            font-size: 1rem;
            color: var(--text-dark);
        }

        .table tbody tr:hover {
            background-color: rgba(106, 110, 81, 0.05);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Info Table Specific */
        .info-table th {
            background: var(--bg-light);
            color: var(--text-dark);
            font-weight: 600;
            width: 180px;
            font-size: 0.95rem;
        }

        .info-table td {
            font-weight: 500;
        }

        /* Product Table */
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: var(--radius-sm);
            border: 2px solid var(--border-color);
            transition: var(--transition);
        }

        .product-image:hover {
            transform: scale(1.1);
            box-shadow: var(--shadow-md);
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .product-details h6 {
            margin: 0 0 0.5rem 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .product-details .product-meta {
            font-size: 0.875rem;
            color: var(--text-muted);
            line-height: 1.4;
        }

        .product-details a {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .product-details a:hover {
            color: var(--accent-color);
            text-decoration: underline;
        }

        /* Badges */
        .badge {
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            text-transform: capitalize;
        }

        .badge i {
            font-size: 0.875rem;
        }

        /* Buttons */
        .btn {
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 1rem;
            padding: 0.75rem 1.5rem;
            transition: var(--transition);
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color), #20c997);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color), #e74c3c);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color), #f39c12);
            color: white;
        }

        .btn-info {
            background: linear-gradient(135deg, var(--info-color), #20c997);
            color: white;
        }

        .btn-outline-primary {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1.125rem;
        }

        /* Action Buttons Group */
        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }

        /* Address Card */
        .address-card {
            background: var(--bg-light);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 1.5rem;
        }

        .address-card h6 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .address-details p {
            margin-bottom: 0.5rem;
            font-size: 1rem;
            color: var(--text-dark);
        }

        .address-details .contact-info {
            border-top: 1px dashed var(--border-color);
            padding-top: 1rem;
            margin-top: 1rem;
        }

        /* Payment Section */
        .payment-section {
            background: var(--bg-white);
            border: 2px solid var(--primary-color);
            border-radius: var(--radius-md);
            padding: 2rem;
            margin: 2rem 0;
        }

        .payment-section h5 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
            font-weight: 600;
        }

        /* Order Summary */
        .order-summary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            border-radius: var(--radius-md);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 1rem;
        }

        .summary-row:last-child {
            border-bottom: 2px solid rgba(255, 255, 255, 0.4);
            font-weight: 700;
            font-size: 1.25rem;
            margin-top: 0.5rem;
            padding-top: 1rem;
        }

        .summary-row.total {
            border-bottom: none;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .fade-in-delay-1 { animation-delay: 0.1s; }
        .fade-in-delay-2 { animation-delay: 0.2s; }
        .fade-in-delay-3 { animation-delay: 0.3s; }
        .fade-in-delay-4 { animation-delay: 0.4s; }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-title {
                font-size: 1.75rem;
                margin-top: 60px !important;
            }

            .card-body {
                padding: 1.5rem;
            }

            .timeline-container {
                padding: 0.5rem 0;
            }

            .timeline-step {
                min-width: 100px;
            }

            .step-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .step-label {
                font-size: 0.75rem;
            }

            .table thead th,
            .table tbody td {
                padding: 1rem 0.75rem;
                font-size: 0.9rem;
            }

            .product-image {
                width: 60px;
                height: 60px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .order-summary {
                padding: 1.5rem;
            }

            .summary-row {
                font-size: 0.9rem;
            }

            .summary-row:last-child {
                font-size: 1.1rem;
            }
        }

        /* Print Styles */
        @media print {
            .btn, .action-buttons {
                display: none !important;
            }

            .order-card {
                box-shadow: none;
                border: 1px solid #000;
            }
        }
    </style>

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">
                <i class="fas fa-file-invoice me-2"></i>
                Detail Pesanan #{{ '1' . str_pad($transaction->order->id, 4, '0', STR_PAD_LEFT) }}
            </h2>

            <div class="row">
                <div class="col-lg-2">
                    @include('layouts.account-nav')
                </div>

                <div class="col-lg-10">
                    @if (Session::has('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ Session::get('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Order Summary Card -->
                    <div class="order-summary fade-in">
                        <h4><i class="fas fa-shopping-cart me-2"></i>Ringkasan Pesanan</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="summary-row">
                                    <span>Subtotal Produk</span>
                                    <span>Rp {{ number_format($transaction->order->subtotal) }}</span>
                                </div>
                                @if($transaction->order->discount > 0)
                                <div class="summary-row">
                                    <span>Diskon</span>
                                    <span>-Rp {{ number_format($transaction->order->discount) }}</span>
                                </div>
                                @endif
                                @if($transaction->order->ongkir && $transaction->order->ongkir > 0)
                                <div class="summary-row">
                                    <span>Ongkos Kirim</span>
                                    <span>Rp {{ number_format($transaction->order->ongkir) }}</span>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="summary-row">
                                    <span>Metode Pembayaran</span>
                                    <span>{{ $transaction->mode_display ?? ucfirst($transaction->mode) }}</span>
                                </div>
                                @if($transaction->order->kurir)
                                <div class="summary-row">
                                    <span>Jasa Pengiriman</span>
                                    <span>{{ strtoupper($transaction->order->kurir) }}</span>
                                </div>
                                @endif
                                <div class="summary-row total">
                                    <span>Total Pembayaran</span>
                                    <span>Rp {{ number_format($transaction->order->total) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Status Timeline -->
                    <div class="order-card fade-in fade-in-delay-1">
                        <div class="card-header">
                            <h5><i class="fas fa-route me-2"></i>Status Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="status-timeline">
                                <div class="timeline-container">
                                    <div class="timeline-line">
                                        @php
                                            $progress = 0;
                                            switch($transaction->order->status) {
                                                case 'awaiting_payment': $progress = 10; break;
                                                case 'pending': $progress = 20; break;
                                                case 'confirmed': $progress = 35; break;
                                                case 'processing': $progress = 50; break;
                                                case 'shipped': $progress = 70; break;
                                                case 'delivered': $progress = 85; break;
                                                case 'completed': $progress = 100; break;
                                                case 'canceled': $progress = 100; break;
                                                default: $progress = 0;
                                            }
                                        @endphp
                                        <div class="timeline-progress" style="width: {{ $progress }}%;"></div>
                                    </div>

                                    @php
                                        $statuses = [
                                            'awaiting_payment' => ['icon' => 'fas fa-credit-card', 'label' => 'Menunggu Pembayaran'],
                                            'pending' => ['icon' => 'fas fa-clock', 'label' => 'Menunggu Konfirmasi'],
                                            'confirmed' => ['icon' => 'fas fa-check', 'label' => 'Dikonfirmasi'],
                                            'processing' => ['icon' => 'fas fa-cog', 'label' => 'Diproses'],
                                            'shipped' => ['icon' => 'fas fa-truck', 'label' => 'Dikirim'],
                                            'delivered' => ['icon' => 'fas fa-box-open', 'label' => 'Telah Sampai'],
                                            'completed' => ['icon' => 'fas fa-check-circle', 'label' => 'Selesai']
                                        ];

                                        $currentStatus = $transaction->order->status;
                                        $isCanceled = $currentStatus === 'canceled';
                                    @endphp

                                    @foreach($statuses as $status => $info)
                                        @php
                                            $statusIndex = array_search($status, array_keys($statuses));
                                            $currentIndex = array_search($currentStatus, array_keys($statuses));

                                            if ($isCanceled) {
                                                $stepClass = 'cancelled';
                                            } elseif ($currentIndex !== false && $statusIndex < $currentIndex) {
                                                $stepClass = 'completed';
                                            } elseif ($statusIndex === $currentIndex) {
                                                $stepClass = 'active';
                                            } else {
                                                $stepClass = '';
                                            }

                                            $dateField = $status . '_date';
                                            $statusDate = $transaction->order->$dateField ?? ($status === 'awaiting_payment' ? $transaction->order->created_at : null);
                                        @endphp

                                        <div class="timeline-step">
                                            <div class="step-icon {{ $stepClass }}">
                                                <i class="{{ $isCanceled ? 'fas fa-times' : $info['icon'] }}"></i>
                                            </div>
                                            <div class="step-label">
                                                {{ $isCanceled && $status === 'completed' ? 'Dibatalkan' : $info['label'] }}
                                            </div>
                                            <div class="step-date">
                                                {{-- {{ $statusDate ? $statusDate->format('d/m/Y') : '-' }} --}}
                                            </div>
                                        </div>
                                    @endforeach

                                    @if($isCanceled)
                                        {{-- <div class="timeline-step">
                                            <div class="step-icon cancelled">
                                                <i class="fas fa-ban"></i>
                                            </div>
                                            <div class="step-label">Dibatalkan</div>
                                            <div class="step-date">
                                                {{ $transaction->order->canceled_date ? $transaction->order->canceled_date->format('d/m/Y') : '-' }}
                                            </div>
                                        </div> --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="order-card fade-in fade-in-delay-2">
                        <div class="card-header">
                            <h5><i class="fas fa-info-circle me-2"></i>Informasi Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-container">
                                <table class="table info-table">
                                    <tbody>
                                        <tr>
                                            <th><i class="fas fa-hashtag me-2"></i>No. Pesanan</th>
                                            <td>{{ '1' . str_pad($transaction->order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                            <th><i class="fas fa-calendar me-2"></i>Tanggal Pesan</th>
                                            <td>{{ $transaction->order->created_at->format('d M Y, H:i') }} WIB</td>
                                        </tr>
                                        <tr>
                                            <th><i class="fas fa-user me-2"></i>Nama Pemesan</th>
                                            <td>{{ $transaction->order->name }}</td>
                                            <th><i class="fas fa-phone me-2"></i>No. Telepon</th>
                                            <td>{{ $transaction->order->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th><i class="fas fa-info-circle me-2"></i>Status Pesanan</th>
                                            <td>
                                                @switch($transaction->order->status)
                                                    @case('awaiting_payment')
                                                        <span class="badge bg-warning"><i class="fas fa-credit-card me-1"></i>Menunggu Pembayaran</span>
                                                        @break
                                                    @case('pending')
                                                        <span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Menunggu Konfirmasi</span>
                                                        @break
                                                    @case('confirmed')
                                                        <span class="badge bg-info"><i class="fas fa-check me-1"></i>Dikonfirmasi</span>
                                                        @break
                                                    @case('processing')
                                                        <span class="badge bg-primary"><i class="fas fa-cog me-1"></i>Diproses</span>
                                                        @break
                                                    @case('shipped')
                                                        <span class="badge bg-info"><i class="fas fa-truck me-1"></i>Dikirim</span>
                                                        @break
                                                    @case('delivered')
                                                        <span class="badge bg-warning"><i class="fas fa-box-open me-1"></i>Menunggu Konfirmasi Anda</span>
                                                        @break
                                                    @case('completed')
                                                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Selesai</span>
                                                        @break
                                                    @case('canceled')
                                                        <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Dibatalkan</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <th><i class="fas fa-credit-card me-2"></i>Status Pembayaran</th>
                                            <td>
                                                @switch($transaction->status)
                                                    @case('approved')
                                                    @case('paid')
                                                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Lunas</span>
                                                        @break
                                                    @case('pending')
                                                        <span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Menunggu</span>
                                                        @break
                                                    @case('declined')
                                                        <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Ditolak</span>
                                                        @break
                                                    @case('refunded')
                                                        <span class="badge bg-info"><i class="fas fa-undo me-1"></i>Dikembalikan</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary"><i class="fas fa-question me-1"></i>Unknown</span>
                                                @endswitch
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><i class="fas fa-shipping-fast me-2"></i>Ongkos Kirim</th>
                                            <td>{{ $transaction->order->ongkir ? 'Rp ' . number_format($transaction->order->ongkir) : 'Gratis' }}</td>
                                            <th><i class="fas fa-truck me-2"></i>Kurir</th>
                                            <td>{{ $transaction->order->kurir ? strtoupper($transaction->order->kurir) : '-' }}</td>
                                        </tr>
                                        @if($transaction->order->delivered_date)
                                        <tr>
                                            <th><i class="fas fa-calendar-check me-2"></i>Tanggal Sampai</th>
                                            {{-- <td>{{ $transaction->order->delivered_date->format('d M Y, H:i') }} WIB</td> --}}
                                            <th><i class="fas fa-map-pin me-2"></i>Kode Pos</th>
                                            <td>{{ $transaction->order->zip }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Order Actions - Confirm Delivery Button -->
                    @if ($transaction->order->status === 'delivered')
                        <div class="order-card fade-in fade-in-delay-1">
                            <div class="card-header bg-success">
                                <h5><i class="fas fa-clipboard-check me-2"></i>Konfirmasi Penerimaan</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Setelah menerima pesanan Anda, silakan konfirmasi penerimaan dengan menekan tombol di bawah ini.
                                    Dengan mengkonfirmasi, Anda menyatakan bahwa pesanan telah diterima dalam kondisi baik.
                                </div>
                                <form action="{{ route('user.account.confirm.delivery') }}" method="POST" id="confirmDeliveryForm">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $transaction->order->id }}">
                                    <button type="button" class="btn btn-success btn-lg confirm-delivery">
                                        <i class="fas fa-check-circle me-2"></i>Konfirmasi Pesanan Telah Diterima
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Ordered Items -->
                    <div class="order-card fade-in fade-in-delay-3">
                        <div class="card-header">
                            <h5><i class="fas fa-shopping-basket me-2"></i>Produk yang Dipesan ({{ $orderItems->total() }} item)</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-container">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="width: 40%;">Produk</th>
                                                <th style="width: 15%;" class="text-center">Harga</th>
                                                <th style="width: 10%;" class="text-center">Qty</th>
                                                <th style="width: 15%;" class="text-center">Subtotal</th>
                                                <th style="width: 20%;" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orderItems as $orderitem)
                                                <tr>
                                                    <td>
                                                        <div class="product-info">
                                                            <img src="{{ asset('uploads/products/thumbnails/' . $orderitem->product->image) }}"
                                                                alt="{{ $orderitem->product->name }}"
                                                                class="product-image">
                                                            <div class="product-details">
                                                                <h6>
                                                                    <a href="{{ route('shop.product.details', ['product_slug' => $orderitem->product->slug]) }}"
                                                                        target="_blank">
                                                                        {{ $orderitem->product->name }}
                                                                    </a>
                                                                </h6>
                                                                <div class="product-meta">
                                                                    <div><strong>SKU:</strong> {{ $orderitem->product->SKU }}</div>
                                                                    <div><strong>Kategori:</strong> {{ $orderitem->product->category->name ?? '-' }}</div>
                                                                    <div><strong>Merek:</strong> {{ $orderitem->product->brand->name ?? '-' }}</div>
                                                                    @if($orderitem->options)
                                                                        <div><strong>Opsi:</strong> {{ $orderitem->options }}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <strong>Rp {{ number_format($orderitem->price) }}</strong>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary">{{ $orderitem->quantity }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <strong>Rp {{ number_format($orderitem->price * $orderitem->quantity) }}</strong>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <a href="{{ route('shop.product.details', ['product_slug' => $orderitem->product->slug]) }}"
                                                                target="_blank" class="btn btn-outline-primary btn-sm"
                                                                title="Lihat Produk">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <button class="btn btn-outline-success btn-sm" title="Beli Lagi"
                                                                onclick="addToCartAgain({{ $orderitem->product->id }})">
                                                                <i class="fas fa-cart-plus"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Review Section for Completed Orders -->
                                                @if ($transaction->order->status === 'completed')
                                                    <tr>
                                                        <td colspan="5" class="border-top-0">
                                                            @if (!$orderitem->review)
                                                                <div class="mt-3 p-3 border rounded bg-light">
                                                                    <h6 class="text-primary mb-3">
                                                                        <i class="fas fa-star me-2"></i>
                                                                        Beri Ulasan untuk "{{ $orderitem->product->name }}"
                                                                    </h6>
                                                                    <form action="{{ route('user.reviews.store') }}" method="POST"
                                                                        enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="hidden" name="order_item_id" value="{{ $orderitem->id }}">
                                                                        <input type="hidden" name="product_id" value="{{ $orderitem->product->id }}">

                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <label class="form-label fw-bold">Rating:</label>
                                                                                <div class="rating-stars">
                                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                                        <input type="radio" name="rating"
                                                                                            id="star{{ $orderitem->id }}-{{ $i }}"
                                                                                            value="{{ $i }}"
                                                                                            {{ old('rating') == $i ? 'checked' : '' }} required>
                                                                                        <label for="star{{ $orderitem->id }}-{{ $i }}"
                                                                                            class="star-label">
                                                                                            <i class="fas fa-star"></i>
                                                                                        </label>
                                                                                    @endfor
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="form-label fw-bold">Ulasan:</label>
                                                                                <textarea name="comment" class="form-control"
                                                                                    placeholder="Bagikan pengalaman Anda..." rows="3">{{ old('comment') }}</textarea>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <label class="form-label fw-bold">Foto/Video:</label>
                                                                                <input type="file" name="media[]"
                                                                                    accept="image/*,video/*"
                                                                                    class="form-control review-media-input" multiple>
                                                                                <div class="media-preview mt-2"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mt-3">
                                                                            <button type="submit" class="btn btn-primary">
                                                                                <i class="fas fa-star me-2"></i>Kirim Ulasan
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            @else
                                                                <div class="mt-3 p-3 border rounded bg-success bg-opacity-10">
                                                                    <h6 class="text-success mb-2">
                                                                        <i class="fas fa-check-circle me-2"></i>
                                                                        Ulasan Anda
                                                                    </h6>
                                                                    <div class="mb-2">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <i class="fas fa-star {{ $i <= $orderitem->review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                                        @endfor
                                                                        <span class="ms-2">({{ $orderitem->review->rating }}/5)</span>
                                                                    </div>
                                                                    @if($orderitem->review->comment)
                                                                        <p class="mb-2"><em>"{{ $orderitem->review->comment }}"</em></p>
                                                                    @endif
                                                                    @if($orderitem->review->reviewMedia && $orderitem->review->reviewMedia->count())
                                                                    <div class="review-media">
                                                                        @foreach ($orderitem->review->reviewMedia as $media)
                                                                            @if ($media->file_type === 'image')
                                                                                <img src="{{ asset($media->file_path) }}"
                                                                                    alt="Review Image" class="review-media-thumb me-2">
                                                                            @elseif($media->file_type === 'video')
                                                                                <video controls class="review-media-thumb me-2">
                                                                                    <source src="{{ asset($media->file_path) }}">
                                                                                </video>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                                </div>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if($orderItems->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $orderItems->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Address and Transaction Details -->
                    <div class="row">
                        <!-- Shipping Address -->
                        <div class="col-md-6">
                            <div class="order-card fade-in fade-in-delay-4">
                                <div class="card-header">
                                    <h5><i class="fas fa-map-marker-alt me-2"></i>Alamat Pengiriman</h5>
                                </div>
                                <div class="card-body">
                                    <div class="address-card">
                                        <h6><i class="fas fa-user me-2"></i>Penerima</h6>
                                        <div class="address-details">
                                            <p><strong>{{ $transaction->order->name }}</strong></p>
                                            <p><i class="fas fa-home me-2 text-muted"></i>{{ $transaction->order->address }}</p>
                                            <p>{{ $transaction->order->locality }}</p>
                                            <p>{{ $transaction->order->city }}, {{ $transaction->order->state ?? 'Indonesia' }}</p>
                                            <p>{{ $transaction->order->country ?? 'Indonesia' }}</p>
                                            @if($transaction->order->landmark)
                                                <p><i class="fas fa-map me-2 text-muted"></i><strong>Patokan:</strong> {{ $transaction->order->landmark }}</p>
                                            @endif
                                            <p><i class="fas fa-map-pin me-2 text-muted"></i><strong>Kode Pos:</strong> {{ $transaction->order->zip }}</p>

                                            <div class="contact-info">
                                                <p><i class="fas fa-phone me-2 text-muted"></i><strong>Telepon:</strong> {{ $transaction->order->phone }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Transaction Details -->
                        <div class="col-md-6">
                            <div class="order-card fade-in fade-in-delay-4">
                                <div class="card-header">
                                    <h5><i class="fas fa-receipt me-2"></i>Detail Transaksi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-container">
                                        <table class="table info-table">
                                            <tbody>
                                                <tr>
                                                    <th>Subtotal Produk</th>
                                                    <td>Rp {{ number_format($transaction->order->subtotal) }}</td>
                                                </tr>
                                                @if($transaction->order->discount > 0)
                                                <tr>
                                                    <th>Diskon</th>
                                                    <td class="text-success">-Rp {{ number_format($transaction->order->discount) }}</td>
                                                </tr>
                                                @endif
                                                @if($transaction->order->ongkir && $transaction->order->ongkir > 0)
                                                <tr>
                                                    <th>Ongkos Kirim</th>
                                                    <td>Rp {{ number_format($transaction->order->ongkir) }}</td>
                                                </tr>
                                                @endif
                                                <tr class="table-primary">
                                                    <th><strong>Total Pembayaran</strong></th>
                                                    <td><strong>Rp {{ number_format($transaction->order->total) }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <th>Metode Pembayaran</th>
                                                    <td>
                                                        <i class="fas fa-credit-card me-2"></i>
                                                        {{ $transaction->mode_display ?? ucfirst($transaction->mode) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Status Pembayaran</th>
                                                    <td>
                                                        @switch($transaction->status)
                                                            @case('approved')
                                                            @case('paid')
                                                                <span class="badge bg-success">
                                                                    <i class="fas fa-check-circle me-1"></i>Lunas
                                                                </span>
                                                                @break
                                                            @case('pending')
                                                                <span class="badge bg-warning">
                                                                    <i class="fas fa-clock me-1"></i>Menunggu
                                                                </span>
                                                                @break
                                                            @case('declined')
                                                                <span class="badge bg-danger">
                                                                    <i class="fas fa-times-circle me-1"></i>Ditolak
                                                                </span>
                                                                @break
                                                            @case('refunded')
                                                                <span class="badge bg-info">
                                                                    <i class="fas fa-undo me-1"></i>Dikembalikan
                                                                </span>
                                                                @break
                                                        @endswitch
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Transaksi</th>
                                                    <td>{{ $transaction->created_at->format('d M Y, H:i') }} WIB</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Actions -->
                    @include('user.partials.payment-actions', ['transaction' => $transaction])

                    <!-- Cancel Order Section -->
                    @if (in_array($transaction->order->status, ['pending', 'awaiting_payment']))
                        <div class="order-card fade-in">
                            <div class="card-header bg-danger">
                                <h5><i class="fas fa-times-circle me-2"></i>Batalkan Pesanan</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Anda dapat membatalkan pesanan selama status masih "Menunggu" atau "Menunggu Pembayaran".
                                    Setelah dibatalkan, pesanan tidak dapat dikembalikan.
                                </div>
                                <form action="{{ route('user.account_cancel_order') }}" method="POST" id="cancelOrderForm">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="order_id" value="{{ $transaction->order->id }}">
                                    <button type="button" class="btn btn-danger cancel-order">
                                        <i class="fas fa-times me-2"></i>Batalkan Pesanan
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="order-card fade-in">
                        <div class="card-body">
                            <div class="action-buttons">
                                <a href="{{ route('user.account.orders') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Pesanan
                                </a>
                                <button onclick="printOrder()" class="btn btn-info">
                                    <i class="fas fa-print me-2"></i>Cetak Detail
                                </button>
                                <button onclick="shareOrder()" class="btn btn-success">
                                    <i class="fas fa-share me-2"></i>Bagikan
                                </button>
                                <a href="{{ route('home.contact.index') }}" class="btn btn-warning">
                                    <i class="fas fa-headset me-2"></i>Hubungi Support
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <!-- Additional CSS for Review Stars -->
    <style>
        .rating-stars {
            display: flex;
            gap: 0.25rem;
            margin-top: 0.5rem;
        }

        .rating-stars input[type="radio"] {
            display: none;
        }

        .star-label {
            color: #ddd;
            font-size: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .star-label:hover,
        .star-label:hover ~ .star-label {
            color: #ffc107;
        }

        .rating-stars input[type="radio"]:checked ~ .star-label {
            color: #ffc107;
        }

        .rating-stars input[type="radio"]:checked + .star-label {
            color: #ffc107;
        }

        .review-media-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-color);
        }

        .media-preview img,
        .media-preview video {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: var(--radius-sm);
            margin: 2px;
            border: 1px solid var(--border-color);
        }
    </style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Payment Scripts -->
    @if ($transaction->status == 'pending' && $transaction->snap_token)
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        @include('user.partials.payment-scripts', ['transaction' => $transaction])
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Confirm delivery
            const confirmButton = document.querySelector('.confirm-delivery');
            if (confirmButton) {
                confirmButton.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Konfirmasi Penerimaan Pesanan',
                        html: `
                            <div class="text-start">
                                <p>Dengan mengkonfirmasi penerimaan, Anda menyatakan bahwa:</p>
                                <ul class="text-muted">
                                    <li>Pesanan telah sampai dengan aman</li>
                                    <li>Produk sesuai dengan yang dipesan</li>
                                    <li>Tidak ada kerusakan pada produk</li>
                                    <li>Status pesanan akan berubah menjadi "Selesai"</li>
                                </ul>
                                <p class="text-warning"><small><i class="fas fa-exclamation-triangle"></i> Setelah dikonfirmasi, status tidak dapat diubah kembali.</small></p>
                            </div>
                        `,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fas fa-check"></i> Ya, Pesanan Telah Diterima',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('confirmDeliveryForm').submit();
                        }
                    });
                });
            }

            // Cancel order
            const cancelButton = document.querySelector('.cancel-order');
            if (cancelButton) {
                cancelButton.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Batalkan Pesanan?',
                        text: 'Pesanan yang dibatalkan tidak dapat dikembalikan. Apakah Anda yakin?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fas fa-times"></i> Ya, Batalkan',
                        cancelButtonText: 'Tidak',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('cancelOrderForm').submit();
                        }
                    });
                });
            }

            // Add to cart again functionality
            window.addToCartAgain = function(productId) {
                Swal.fire({
                    title: 'Tambah ke Keranjang',
                    text: 'Produk akan ditambahkan ke keranjang belanja Anda',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-cart-plus"></i> Tambah ke Keranjang',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Implement add to cart logic here
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Produk telah ditambahkan ke keranjang',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            };

            // Print functionality
            window.printOrder = function() {
                window.print();
            };

            // Share functionality
            window.shareOrder = function() {
                if (navigator.share) {
                    navigator.share({
                        title: 'Detail Pesanan #{{ "1" . str_pad($transaction->order->id, 4, "0", STR_PAD_LEFT) }}',
                        text: 'Detail pesanan saya di {{ config("app.name") }}',
                        url: window.location.href
                    });
                } else {
                    // Fallback: copy to clipboard
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        Swal.fire({
                            title: 'Link Disalin!',
                            text: 'Link detail pesanan telah disalin ke clipboard',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    });
                }
            };

            // Review media preview
            document.querySelectorAll('.review-media-input').forEach(function(input) {
                input.addEventListener('change', function(e) {
                    const preview = this.closest('form').querySelector('.media-preview');
                    preview.innerHTML = '';

                    if (this.files) {
                        Array.from(this.files).forEach(file => {
                            const reader = new FileReader();
                            reader.onload = function(evt) {
                                let element;
                                if (file.type.startsWith('image/')) {
                                    element = document.createElement('img');
                                    element.src = evt.target.result;
                                } else if (file.type.startsWith('video/')) {
                                    element = document.createElement('video');
                                    element.src = evt.target.result;
                                    element.controls = true;
                                }
                                if (element) {
                                    preview.appendChild(element);
                                }
                            };
                            reader.readAsDataURL(file);
                        });
                    }
                });
            });

            // Rating stars interaction
            document.querySelectorAll('.rating-stars').forEach(function(ratingContainer) {
                const stars = ratingContainer.querySelectorAll('.star-label');
                const inputs = ratingContainer.querySelectorAll('input[type="radio"]');

                stars.forEach(function(star, index) {
                    star.addEventListener('mouseenter', function() {
                        highlightStars(stars, index + 1);
                    });

                    star.addEventListener('click', function() {
                        inputs[index].checked = true;
                        highlightStars(stars, index + 1);
                    });
                });

                ratingContainer.addEventListener('mouseleave', function() {
                    const checkedInput = ratingContainer.querySelector('input[type="radio"]:checked');
                    const rating = checkedInput ? parseInt(checkedInput.value) : 0;
                    highlightStars(stars, rating);
                });

                function highlightStars(stars, rating) {
                    stars.forEach(function(star, index) {
                        if (index < rating) {
                            star.style.color = '#ffc107';
                        } else {
                            star.style.color = '#ddd';
                        }
                    });
                }
            });

            // Auto scroll to active section if there's a hash
            if (window.location.hash) {
                setTimeout(() => {
                    const element = document.querySelector(window.location.hash);
                    if (element) {
                        element.scrollIntoView({ behavior: 'smooth' });
                    }
                }, 500);
            }
        });
    </script>
@endpush

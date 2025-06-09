@extends('layouts.app')

@section('content')
    <style>
        /* Modern CSS Variables - Improved Brown Color Palette */
        :root {
            --primary-color: #A67C5A;
            --primary-light: #A67C5A;
            --primary-dark: #A67C5A;
            --secondary-color: #F5F1EB;
            --accent-color: #D4A574;
            --success-color: #2ECC40;
            --success-light: #4CAF50;
            --danger-color: #FF4136;
            --warning-color: #FF851B;
            --info-color: #0074D9;
            --text-dark: #3C2E26;
            --text-medium: #5D4E3A;
            --text-muted: #8B7355;
            --text-light: #A8927B;
            --border-color: #E5DDD4;
            --bg-light: #FDFCFA;
            --bg-white: #FFFFFF;
            --bg-cream: #FAF7F2;
            --shadow-sm: 0 2px 8px rgba(139, 90, 60, 0.08);
            --shadow-md: 0 4px 16px rgba(139, 90, 60, 0.12);
            --shadow-lg: 0 8px 32px rgba(139, 90, 60, 0.16);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Base Typography */
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: var(--bg-light);
        }

        /* Page Header */
        .page-title {
            font-size: 2.25rem;
            font-weight: 700;
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

        .page-title i {
            color: var(--accent-color);
            margin-right: 0.75rem;
        }

        /* Enhanced Card System */
        .order-card {
            background: var(--bg-white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: var(--transition);
            border: 1px solid var(--border-color);
        }

        .order-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            padding: 1.75rem;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30px, -30px);
        }

        .card-header h5 {
            margin: 0;
            font-size: 1.375rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            z-index: 2;
        }

        .card-header i {
            font-size: 1.5rem;
            color: var(--accent-color);
        }

        .card-body {
            padding: 2.5rem;
            background: var(--bg-white);
        }

        /* Enhanced Alert System */
        .alert {
            border: none;
            border-radius: var(--radius-md);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            font-size: 1rem;
            box-shadow: var(--shadow-sm);
            border-left: 4px solid;
            position: relative;
        }

        .alert-success {
            background: linear-gradient(135deg, #E8F5E8, #D4F4D4);
            color: #1B5E20;
            border-left-color: var(--success-color);
        }

        .alert-info {
            background: linear-gradient(135deg, #E3F2FD, #BBDEFB);
            color: #0D47A1;
            border-left-color: var(--info-color);
        }

        .alert-warning {
            background: linear-gradient(135deg, #FFF8E1, #FFECB3);
            color: #E65100;
            border-left-color: var(--warning-color);
        }

        .alert-danger {
            background: linear-gradient(135deg, #FFEBEE, #FFCDD2);
            color: #B71C1C;
            border-left-color: var(--danger-color);
        }

        /* Enhanced Status Timeline */
        .status-timeline {
            position: relative;
            padding: 3rem 1.5rem;
            background: var(--bg-cream);
            border-radius: var(--radius-lg);
            margin: 2rem 0;
            border: 1px solid var(--border-color);
        }

        .timeline-container {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 100%;
            overflow-x: auto;
            padding: 1.5rem 0;
        }

        .timeline-line {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--border-color);
            border-radius: 3px;
            transform: translateY(-50%);
            z-index: 1;
        }

        .timeline-progress {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: linear-gradient(90deg, var(--success-color), var(--primary-color));
            border-radius: 3px;
            transition: var(--transition);
            z-index: 2;
        }

        .timeline-step {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 140px;
            z-index: 3;
        }

        .step-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--border-color);
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            transition: var(--transition);
            box-shadow: var(--shadow-md);
            border: 3px solid var(--bg-white);
        }

        .step-icon.active {
            background: var(--primary-color);
            color: white;
            animation: pulse 2s infinite;
            box-shadow: var(--shadow-lg);
        }

        .step-icon.completed {
            background: var(--success-color);
            color: white;
            box-shadow: var(--shadow-lg);
        }

        .step-icon.cancelled {
            background: var(--danger-color);
            color: white;
            box-shadow: var(--shadow-lg);
        }

        .step-label {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-dark);
            text-align: center;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .step-date {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-align: center;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(139, 90, 60, 0.7);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(139, 90, 60, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(139, 90, 60, 0);
            }
        }

        /* Enhanced Tables */
        .table-container {
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
        }

        .table {
            margin-bottom: 0;
            font-size: 1rem;
            color: var(--text-medium);
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 1.5rem 1.25rem;
            border: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
        }

        .table thead th i {
            color: var(--accent-color);
            margin-right: 0.5rem;
        }

        .table tbody td {
            padding: 1.5rem 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
            font-size: 1rem;
            color: var(--text-medium);
            background: var(--bg-white);
        }

        .table tbody tr:hover {
            background-color: rgba(139, 90, 60, 0.04);
            transform: scale(1.01);
            transition: var(--transition);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Info Table Specific */
        .info-table th {
            background: var(--bg-cream);
            color: var(--text-dark);
            font-weight: 600;
            width: 200px;
            font-size: 0.95rem;
            border-right: 2px solid var(--border-color);
        }

        .info-table th i {
            color: var(--primary-color);
            margin-right: 0.5rem;
        }

        .info-table td {
            font-weight: 500;
            color: var(--text-medium);
        }

        /* Enhanced Product Table */
        .product-image {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: var(--radius-md);
            border: 3px solid var(--border-color);
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .product-image:hover {
            transform: scale(1.15);
            box-shadow: var(--shadow-lg);
            border-color: var(--accent-color);
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .product-details h6 {
            margin: 0 0 0.75rem 0;
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
            line-height: 1.4;
        }

        .product-details .product-meta {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .product-details .product-meta div {
            margin-bottom: 0.25rem;
        }

        .product-details a {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
            font-weight: 500;
        }

        .product-details a:hover {
            color: var(--accent-color);
            text-decoration: underline;
        }

        /* Enhanced Badges */
        .badge {
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: 25px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-transform: capitalize;
            box-shadow: var(--shadow-sm);
            border: 2px solid transparent;
        }

        .badge i {
            font-size: 0.875rem;
        }

        .badge.bg-success {
            background: linear-gradient(135deg, var(--success-color), var(--success-light)) !important;
            color: white !important;
            border-color: rgba(255, 255, 255, 0.2);
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, var(--warning-color), #FFB74D) !important;
            color: white !important;
        }

        .badge.bg-info {
            background: linear-gradient(135deg, var(--info-color), #42A5F5) !important;
            color: white !important;
        }

        .badge.bg-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light)) !important;
            color: white !important;
        }

        .badge.bg-danger {
            background: linear-gradient(135deg, var(--danger-color), #EF5350) !important;
            color: white !important;
        }

        .badge.bg-secondary {
            background: linear-gradient(135deg, var(--text-muted), var(--text-light)) !important;
            color: white !important;
        }

        /* Enhanced Buttons */
        .btn {
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 1rem;
            padding: 0.875rem 1.75rem;
            transition: var(--transition);
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color), var(--success-light));
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color), #EF5350);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color), #FFB74D);
            color: white;
        }

        .btn-info {
            background: linear-gradient(135deg, var(--info-color), #42A5F5);
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

        .btn-outline-secondary {
            background: transparent;
            color: var(--text-muted);
            border: 2px solid var(--text-muted);
        }

        .btn-outline-secondary:hover {
            background: var(--text-muted);
            color: white;
        }

        .btn-outline-success {
            background: transparent;
            color: var(--success-color);
            border: 2px solid var(--success-color);
        }

        .btn-outline-success:hover {
            background: var(--success-color);
            color: white;
        }

        .btn-sm {
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
        }

        .btn-lg {
            padding: 1.25rem 2.5rem;
            font-size: 1.125rem;
        }

        /* Action Buttons Group */
        .action-buttons {
            display: flex;
            gap: 1.25rem;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        /* Enhanced Address Card */
        .address-card {
            background: var(--bg-cream);
            border: 2px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .address-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(139, 90, 60, 0.1), transparent);
        }

        .address-card h6 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .address-details p {
            margin-bottom: 0.75rem;
            font-size: 1rem;
            color: var(--text-medium);
            line-height: 1.5;
        }

        .address-details .contact-info {
            border-top: 2px dashed var(--border-color);
            padding-top: 1.5rem;
            margin-top: 1.5rem;
        }

        /* Enhanced Payment Section */
        .payment-section {
            background: var(--bg-white);
            border: 3px solid var(--primary-color);
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            margin: 2rem 0;
            position: relative;
            overflow: hidden;
        }

        .payment-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .payment-section h5 {
            color: var(--primary-color);
            margin-bottom: 2rem;
            font-size: 1.375rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Enhanced Order Summary */
        .order-summary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .order-summary::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1), transparent);
        }

        .order-summary h4 {
            position: relative;
            z-index: 2;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 1.125rem;
            position: relative;
            z-index: 2;
        }

        .summary-row:last-child {
            border-bottom: 3px solid rgba(255, 255, 255, 0.4);
            font-weight: 700;
            font-size: 1.375rem;
            margin-top: 1rem;
            padding-top: 1.5rem;
        }

        .summary-row.total {
            border-bottom: none;
        }

        /* Icon Enhancements */
        .fas,
        .far {
            margin-right: 0.5rem;
        }

        .card-header .fas {
            color: var(--accent-color);
            font-size: 1.25rem;
        }

        /* Enhanced Animations */
        .fade-in {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .fade-in-delay-1 {
            animation-delay: 0.1s;
            opacity: 0;
        }

        .fade-in-delay-2 {
            animation-delay: 0.2s;
            opacity: 0;
        }

        .fade-in-delay-3 {
            animation-delay: 0.3s;
            opacity: 0;
        }

        .fade-in-delay-4 {
            animation-delay: 0.4s;
            opacity: 0;
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

        /* Enhanced Responsive Design */
        @media (max-width: 768px) {
            .page-title {
                font-size: 1.875rem;
                margin-top: 60px !important;
            }

            .card-body {
                padding: 2rem;
            }

            .timeline-container {
                padding: 1rem 0;
            }

            .timeline-step {
                min-width: 110px;
            }

            .step-icon {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }

            .step-label {
                font-size: 0.85rem;
            }

            .table thead th,
            .table tbody td {
                padding: 1.25rem 1rem;
                font-size: 0.9rem;
            }

            .product-image {
                width: 70px;
                height: 70px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                justify-content: center;
            }

            .order-summary {
                padding: 2rem;
            }

            .payment-section {
                padding: 2rem;
            }
        }

        @media (max-width: 576px) {
            .summary-row {
                font-size: 1rem;
            }

            .summary-row:last-child {
                font-size: 1.25rem;
            }

            .product-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .product-image {
                align-self: center;
            }
        }

        /* Print Styles */
        @media print {

            .btn,
            .action-buttons {
                display: none !important;
            }

            .order-card {
                box-shadow: none;
                border: 2px solid var(--primary-color);
            }

            .card-header {
                background: var(--primary-color) !important;
                -webkit-print-color-adjust: exact;
            }
        }

        /* Additional Styling for Better Visual Hierarchy */
        .text-success {
            color: var(--success-color) !important;
            font-weight: 600;
        }

        .fw-bold {
            font-weight: 700 !important;
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        /* Card hover effects */
        .order-card .card-body {
            transition: var(--transition);
        }

        .order-card:hover .card-body {
            background: var(--bg-cream);
        }

        /* Form Controls Enhancement */
        .form-control {
            border: 2px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 0.875rem 1.25rem;
            color: var(--text-medium);
            background: var(--bg-white);
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(139, 90, 60, 0.1);
        }

        /* Enhanced countdown display */
        #payment-countdown-detail {
            background: rgba(255, 255, 255, 0.1);
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius-md);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
    </style>

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">
                <i class="fas fa-file-invoice"></i>
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
                        <h4><i class="fas fa-shopping-cart"></i>Ringkasan Pesanan</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="summary-row">
                                    <span>Subtotal Produk</span>
                                    <span>Rp {{ number_format($transaction->order->subtotal) }}</span>
                                </div>
                                @if ($transaction->order->discount > 0)
                                    <div class="summary-row">
                                        <span>Diskon</span>
                                        <span>-Rp {{ number_format($transaction->order->discount) }}</span>
                                    </div>
                                @endif
                                @if ($transaction->order->ongkir && $transaction->order->ongkir > 0)
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
                                @if ($transaction->order->kurir)
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
                            <h5><i class="fas fa-route"></i>Status Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="status-timeline">
                                <div class="timeline-container">
                                    <div class="timeline-line">
                                        @php
                                            $progress = 0;
                                            switch ($transaction->order->status) {
                                                case 'awaiting_payment':
                                                    $progress = 10;
                                                    break;
                                                case 'pending':
                                                    $progress = 20;
                                                    break;
                                                case 'confirmed':
                                                    $progress = 35;
                                                    break;
                                                case 'processing':
                                                    $progress = 50;
                                                    break;
                                                case 'shipped':
                                                    $progress = 70;
                                                    break;
                                                case 'delivered':
                                                    $progress = 85;
                                                    break;
                                                case 'completed':
                                                    $progress = 100;
                                                    break;
                                                case 'canceled':
                                                    $progress = 100;
                                                    break;
                                                default:
                                                    $progress = 0;
                                            }
                                        @endphp
                                        <div class="timeline-progress" style="width: {{ $progress }}%;"></div>
                                    </div>

                                    @php
                                        $statuses = [
                                            'awaiting_payment' => [
                                                'icon' => 'fas fa-credit-card',
                                                'label' => 'Menunggu Pembayaran',
                                            ],
                                            'pending' => ['icon' => 'fas fa-clock', 'label' => 'Menunggu Konfirmasi'],
                                            'confirmed' => ['icon' => 'fas fa-check', 'label' => 'Dikonfirmasi'],
                                            'processing' => ['icon' => 'fas fa-cog', 'label' => 'Diproses'],
                                            'shipped' => ['icon' => 'fas fa-truck', 'label' => 'Dikirim'],
                                            'delivered' => ['icon' => 'fas fa-box-open', 'label' => 'Telah Sampai'],
                                            'completed' => ['icon' => 'fas fa-check-circle', 'label' => 'Selesai'],
                                        ];

                                        $currentStatus = $transaction->order->status;
                                        $isCanceled = $currentStatus === 'canceled';
                                    @endphp

                                    @foreach ($statuses as $status => $info)
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
                                            $statusDate =
                                                $transaction->order->$dateField ??
                                                ($status === 'awaiting_payment'
                                                    ? $transaction->order->created_at
                                                    : null);
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="order-card fade-in fade-in-delay-2">
                        <div class="card-header">
                            <h5><i class="fas fa-info-circle"></i>Informasi Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-container">
                                <table class="table info-table">
                                    <tbody>
                                        <tr>
                                            <th><i class="fas fa-hashtag"></i>No. Pesanan</th>
                                            <td>{{ '1' . str_pad($transaction->order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                            <th><i class="fas fa-calendar"></i>Tanggal Pesan</th>
                                            <td>{{ $transaction->order->created_at->format('d M Y, H:i') }} WIB</td>
                                        </tr>
                                        <tr>
                                            <th><i class="fas fa-user"></i>Nama Pemesan</th>
                                            <td>{{ $transaction->order->name }}</td>
                                            <th><i class="fas fa-phone"></i>No. Telepon</th>
                                            <td>{{ $transaction->order->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th><i class="fas fa-info-circle"></i>Status Pesanan</th>
                                            <td>
                                                @switch($transaction->order->status)
                                                    @case('awaiting_payment')
                                                        <span class="badge bg-warning"><i class="fas fa-credit-card"></i>Menunggu
                                                            Pembayaran</span>
                                                    @break

                                                    @case('pending')
                                                        <span class="badge bg-warning"><i class="fas fa-clock"></i>Menunggu
                                                            Konfirmasi</span>
                                                    @break

                                                    @case('confirmed')
                                                        <span class="badge bg-info"><i class="fas fa-check"></i>Dikonfirmasi</span>
                                                    @break

                                                    @case('processing')
                                                        <span class="badge bg-primary"><i class="fas fa-cog"></i>Diproses</span>
                                                    @break

                                                    @case('shipped')
                                                        <span class="badge bg-info"><i class="fas fa-truck"></i>Dikirim</span>
                                                    @break

                                                    @case('delivered')
                                                        <span class="badge bg-warning"><i class="fas fa-box-open"></i>Menunggu
                                                            Konfirmasi Anda</span>
                                                    @break

                                                    @case('completed')
                                                        <span class="badge bg-success"><i
                                                                class="fas fa-check-circle"></i>Selesai</span>
                                                    @break

                                                    @case('canceled')
                                                        <span class="badge bg-danger"><i class="fas fa-times"></i>Dibatalkan</span>
                                                    @break
                                                @endswitch
                                            </td>
                                            <th><i class="fas fa-credit-card"></i>Status Pembayaran</th>
                                            <td>
                                                @switch($transaction->status)
                                                    @case('approved')
                                                    @case('paid')
                                                        <span class="badge bg-success"><i
                                                                class="fas fa-check-circle"></i>Lunas</span>
                                                    @break

                                                    @case('pending')
                                                        <span class="badge bg-warning"><i class="fas fa-clock"></i>Menunggu</span>
                                                    @break

                                                    @case('declined')
                                                        <span class="badge bg-danger"><i
                                                                class="fas fa-times-circle"></i>Ditolak</span>
                                                    @break

                                                    @case('refunded')
                                                        <span class="badge bg-info"><i class="fas fa-undo"></i>Dikembalikan</span>
                                                    @break

                                                    @default
                                                        <span class="badge bg-secondary"><i
                                                                class="fas fa-question"></i>Unknown</span>
                                                @endswitch
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><i class="fas fa-shipping-fast"></i>Ongkos Kirim</th>
                                            <td>{{ $transaction->order->ongkir ? 'Rp ' . number_format($transaction->order->ongkir) : 'Gratis' }}
                                            </td>
                                            <th><i class="fas fa-truck"></i>Kurir</th>
                                            <td>{{ $transaction->order->kurir ? strtoupper($transaction->order->kurir) : '-' }}
                                            </td>
                                        </tr>
                                        @if ($transaction->order->delivered_date)
                                            <tr>
                                                <th><i class="fas fa-calendar-check"></i>Tanggal Sampai</th>
                                                {{-- <td>{{ $transaction->order->delivered_date->format('d M Y, H:i') }} WIB</td> --}}
                                                <th><i class="fas fa-map-pin"></i>Kode Pos</th>
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
                                <h5><i class="fas fa-clipboard-check"></i>Konfirmasi Penerimaan</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Setelah menerima pesanan Anda, silakan konfirmasi penerimaan dengan menekan tombol di
                                    bawah ini.
                                    Dengan mengkonfirmasi, Anda menyatakan bahwa pesanan telah diterima dalam kondisi baik.
                                </div>
                                <form action="{{ route('user.account.confirm.delivery') }}" method="POST"
                                    id="confirmDeliveryForm">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $transaction->order->id }}">
                                    <button type="button" class="btn btn-success btn-lg confirm-delivery">
                                        <i class="fas fa-check-circle"></i>Konfirmasi Pesanan Telah Diterima
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Ordered Items -->
                    <div class="order-card fade-in fade-in-delay-3">
                        <div class="card-header">
                            <h5><i class="fas fa-shopping-basket"></i>Produk yang Dipesan ({{ $orderItems->total() }} item)
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-container">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="width: 40%;"><i class="fas fa-box"></i>Produk</th>
                                                <th style="width: 15%;" class="text-center"><i
                                                        class="fas fa-tag"></i>Harga</th>
                                                <th style="width: 10%;" class="text-center"><i
                                                        class="fas fa-sort-numeric-up"></i>Qty</th>
                                                <th style="width: 15%;" class="text-center"><i
                                                        class="fas fa-calculator"></i>Subtotal</th>
                                                <th style="width: 20%;" class="text-center"><i
                                                        class="fas fa-tools"></i>Aksi</th>
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
                                                                    <div><strong>SKU:</strong>
                                                                        {{ $orderitem->product->SKU }}</div>
                                                                    <div><strong>Kategori:</strong>
                                                                        {{ $orderitem->product->category->name ?? '-' }}
                                                                    </div>
                                                                    <div><strong>Merek:</strong>
                                                                        {{ $orderitem->product->brand->name ?? '-' }}</div>
                                                                    @if ($orderitem->options)
                                                                        <div><strong>Ukuran:</strong>
                                                                            {{ $orderitem->options }}</div>
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
                                                        <strong>Rp
                                                            {{ number_format($orderitem->price * $orderitem->quantity) }}</strong>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <a href="{{ route('shop.product.details', ['product_slug' => $orderitem->product->slug]) }}"
                                                                target="_blank" class="btn btn-outline-primary btn-sm"
                                                                title="Lihat Produk">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <button class="btn btn-outline-success btn-sm"
                                                                title="Beli Lagi"
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
                                                                    <form action="{{ route('user.reviews.store') }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="hidden" name="order_item_id"
                                                                            value="{{ $orderitem->id }}">
                                                                        <input type="hidden" name="product_id"
                                                                            value="{{ $orderitem->product->id }}">

                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <label
                                                                                    class="form-label fw-bold">Rating:</label>
                                                                                <div class="rating-stars">
                                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                                        <input type="radio"
                                                                                            name="rating"
                                                                                            id="star{{ $orderitem->id }}-{{ $i }}"
                                                                                            value="{{ $i }}"
                                                                                            {{ old('rating') == $i ? 'checked' : '' }}
                                                                                            required>
                                                                                        <label
                                                                                            for="star{{ $orderitem->id }}-{{ $i }}"
                                                                                            class="star-label">
                                                                                            <i class="fas fa-star"></i>
                                                                                        </label>
                                                                                    @endfor
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label
                                                                                    class="form-label fw-bold">Ulasan:</label>
                                                                                <textarea name="comment" class="form-control" placeholder="Bagikan pengalaman Anda..." rows="3">{{ old('comment') }}</textarea>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <label
                                                                                    class="form-label fw-bold">Foto/Video:</label>
                                                                                <input type="file" name="media[]"
                                                                                    accept="image/*,video/*"
                                                                                    class="form-control review-media-input"
                                                                                    multiple>
                                                                                <div class="media-preview mt-2"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mt-3">
                                                                            <button type="submit"
                                                                                class="btn btn-primary">
                                                                                <i class="fas fa-star me-2"></i>Kirim
                                                                                Ulasan
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            @else
                                                                <div
                                                                    class="mt-3 p-3 border rounded bg-success bg-opacity-10">
                                                                    <h6 class="text-success mb-2">
                                                                        <i class="fas fa-check-circle me-2"></i>
                                                                        Ulasan Anda
                                                                    </h6>
                                                                    <div class="mb-2">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <i
                                                                                class="fas fa-star {{ $i <= $orderitem->review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                                        @endfor
                                                                        <span
                                                                            class="ms-2">({{ $orderitem->review->rating }}/5)</span>
                                                                    </div>
                                                                    @if ($orderitem->review->comment)
                                                                        <p class="mb-2">
                                                                            <em>"{{ $orderitem->review->comment }}"</em>
                                                                        </p>
                                                                    @endif
                                                                    @if ($orderitem->review->reviewMedia && $orderitem->review->reviewMedia->count())
                                                                        <div class="review-media">
                                                                            @foreach ($orderitem->review->reviewMedia as $media)
                                                                                @if ($media->file_type === 'image')
                                                                                    <img src="{{ asset($media->file_path) }}"
                                                                                        alt="Review Image"
                                                                                        class="review-media-thumb me-2">
                                                                                @elseif($media->file_type === 'video')
                                                                                    <video controls
                                                                                        class="review-media-thumb me-2">
                                                                                        <source
                                                                                            src="{{ asset($media->file_path) }}">
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

                            @if ($orderItems->hasPages())
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
                                    <h5><i class="fas fa-map-marker-alt"></i>Alamat Pengiriman</h5>
                                </div>
                                <div class="card-body">
                                    <div class="address-card">
                                        <h6><i class="fas fa-user"></i>Penerima</h6>
                                        <div class="address-details">
                                            <p><strong>{{ $transaction->order->name }}</strong></p>
                                            <p><i
                                                    class="fas fa-home me-2 text-muted"></i>{{ $transaction->order->address }}
                                            </p>
                                            <p>{{ $transaction->order->locality }}</p>
                                            <p>{{ $transaction->order->city }},
                                                {{ $transaction->order->state ?? 'Indonesia' }}</p>
                                            <p>{{ $transaction->order->country ?? 'Indonesia' }}</p>
                                            @if ($transaction->order->landmark)
                                                <p><i class="fas fa-map me-2 text-muted"></i><strong>Patokan:</strong>
                                                    {{ $transaction->order->landmark }}</p>
                                            @endif
                                            <p><i class="fas fa-map-pin me-2 text-muted"></i><strong>Kode Pos:</strong>
                                                {{ $transaction->order->zip }}</p>

                                            <div class="contact-info">
                                                <p><i class="fas fa-phone me-2 text-muted"></i><strong>Telepon:</strong>
                                                    {{ $transaction->order->phone }}</p>
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
                                    <h5><i class="fas fa-receipt"></i>Detail Transaksi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-container">
                                        <table class="table info-table">
                                            <tbody>
                                                <tr>
                                                    <th><i class="fas fa-shopping-cart"></i>Subtotal Produk</th>
                                                    <td>Rp {{ number_format($transaction->order->subtotal) }}</td>
                                                </tr>
                                                @if ($transaction->order->discount > 0)
                                                    <tr>
                                                        <th><i class="fas fa-percent"></i>Diskon</th>
                                                        <td class="text-success">-Rp
                                                            {{ number_format($transaction->order->discount) }}</td>
                                                    </tr>
                                                @endif
                                                @if ($transaction->order->ongkir && $transaction->order->ongkir > 0)
                                                    <tr>
                                                        <th><i class="fas fa-shipping-fast"></i>Ongkos Kirim</th>
                                                        <td>Rp {{ number_format($transaction->order->ongkir) }}</td>
                                                    </tr>
                                                @endif
                                                <tr class="table-primary">
                                                    <th><i class="fas fa-calculator"></i><strong>Total Pembayaran</strong>
                                                    </th>
                                                    <td><strong>Rp {{ number_format($transaction->order->total) }}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-credit-card"></i>Metode Pembayaran</th>
                                                    <td>{{ $transaction->mode_display ?? ucfirst($transaction->mode) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-info-circle"></i>Status Pembayaran</th>
                                                    <td>
                                                        @switch($transaction->status)
                                                            @case('approved')
                                                            @case('paid')
                                                                <span class="badge bg-success">
                                                                    <i class="fas fa-check-circle"></i>Lunas
                                                                </span>
                                                            @break

                                                            @case('pending')
                                                                <span class="badge bg-warning">
                                                                    <i class="fas fa-clock"></i>Menunggu
                                                                </span>
                                                            @break

                                                            @case('declined')
                                                                <span class="badge bg-danger">
                                                                    <i class="fas fa-times-circle"></i>Ditolak
                                                                </span>
                                                            @break

                                                            @case('refunded')
                                                                <span class="badge bg-info">
                                                                    <i class="fas fa-undo"></i>Dikembalikan
                                                                </span>
                                                            @break
                                                        @endswitch
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-calendar"></i>Tanggal Transaksi</th>
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
                                <h5><i class="fas fa-times-circle"></i>Batalkan Pesanan</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Anda dapat membatalkan pesanan selama status masih "Menunggu" atau "Menunggu
                                    Pembayaran".
                                    Setelah dibatalkan, pesanan tidak dapat dikembalikan.
                                </div>
                                <form action="{{ route('user.account_cancel_order') }}" method="POST"
                                    id="cancelOrderForm">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="order_id" value="{{ $transaction->order->id }}">
                                    <button type="button" class="btn btn-danger cancel-order">
                                        <i class="fas fa-times"></i>Batalkan Pesanan
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
                                    <i class="fas fa-arrow-left"></i>Kembali ke Pesanan
                                </a>
                                <button onclick="printOrder()" class="btn btn-info">
                                    <i class="fas fa-print"></i>Cetak Detail
                                </button>
                                <button onclick="shareOrder()" class="btn btn-success">
                                    <i class="fas fa-share"></i>Bagikan
                                </button>
                                <a href="{{ route('home.contact.index') }}" class="btn btn-warning">
                                    <i class="fas fa-headset"></i>Hubungi Support
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
            gap: 0.5rem;
            margin-top: 0.75rem;
            align-items: center;
        }

        .rating-stars input[type="radio"] {
            display: none;
        }

        .star-label {
            color: var(--border-color);
            font-size: 1.75rem;
            cursor: pointer;
            transition: var(--transition);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .star-label:hover,
        .star-label:hover~.star-label {
            color: var(--accent-color);
            transform: scale(1.1);
        }

        .rating-stars input[type="radio"]:checked~.star-label {
            color: var(--accent-color);
        }

        .rating-stars input[type="radio"]:checked+.star-label {
            color: var(--accent-color);
        }

        .review-media-thumb {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: var(--radius-md);
            border: 2px solid var(--border-color);
            box-shadow: var(--shadow-sm);
        }

        .media-preview img,
        .media-preview video {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: var(--radius-md);
            margin: 4px;
            border: 2px solid var(--border-color);
            box-shadow: var(--shadow-sm);
        }

        /* Enhanced form styling */
        .form-label {
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Improved review section */
        .bg-light {
            background: var(--bg-cream) !important;
            border: 2px solid var(--border-color) !important;
        }

        .bg-success.bg-opacity-10 {
            background: rgba(46, 204, 64, 0.1) !important;
            border: 2px solid var(--success-color) !important;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Payment Scripts -->
    @if ($transaction->status == 'pending' && $transaction->snap_token)
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
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
                        confirmButtonColor: '#2ECC40',
                        cancelButtonColor: '#8B7355',
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
                        confirmButtonColor: '#FF4136',
                        cancelButtonColor: '#8B7355',
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
                    confirmButtonColor: '#2ECC40',
                    cancelButtonColor: '#8B7355',
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
                        title: 'Detail Pesanan #{{ '1' . str_pad($transaction->order->id, 4, '0', STR_PAD_LEFT) }}',
                        text: 'Detail pesanan saya di {{ config('app.name') }}',
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
                    const checkedInput = ratingContainer.querySelector(
                        'input[type="radio"]:checked');
                    const rating = checkedInput ? parseInt(checkedInput.value) : 0;
                    highlightStars(stars, rating);
                });

                function highlightStars(stars, rating) {
                    stars.forEach(function(star, index) {
                        if (index < rating) {
                            star.style.color = '#D4A574';
                            star.style.transform = 'scale(1.1)';
                        } else {
                            star.style.color = '#E5DDD4';
                            star.style.transform = 'scale(1)';
                        }
                    });
                }
            });

            // Auto scroll to active section if there's a hash
            if (window.location.hash) {
                setTimeout(() => {
                    const element = document.querySelector(window.location.hash);
                    if (element) {
                        element.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }, 500);
            }

            // Enhanced card animations on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all fade-in elements
            document.querySelectorAll('.fade-in').forEach(el => {
                observer.observe(el);
            });

            // Smooth hover effects for buttons
            document.querySelectorAll('.btn').forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px) scale(1.02)';
                });

                btn.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Enhanced table row interactions
            document.querySelectorAll('.table tbody tr').forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = 'rgba(139, 90, 60, 0.06)';
                    this.style.transform = 'scale(1.01)';
                });

                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                    this.style.transform = 'scale(1)';
                });
            });

            // Status timeline animation
            const timelineSteps = document.querySelectorAll('.timeline-step');
            timelineSteps.forEach((step, index) => {
                setTimeout(() => {
                    step.style.opacity = '1';
                    step.style.transform = 'translateY(0)';
                }, index * 200);
            });

            // Initialize tooltips for better UX
            const tooltipElements = document.querySelectorAll('[title]');
            tooltipElements.forEach(element => {
                element.addEventListener('mouseenter', function() {
                    const tooltip = document.createElement('div');
                    tooltip.className = 'custom-tooltip';
                    tooltip.textContent = this.getAttribute('title');
                    tooltip.style.cssText = `
                        position: absolute;
                        background: var(--text-dark);
                        color: white;
                        padding: 0.5rem 1rem;
                        border-radius: var(--radius-sm);
                        font-size: 0.875rem;
                        z-index: 1000;
                        pointer-events: none;
                        opacity: 0;
                        transition: opacity 0.3s;
                        box-shadow: var(--shadow-md);
                    `;
                    document.body.appendChild(tooltip);

                    const rect = this.getBoundingClientRect();
                    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) +
                        'px';
                    tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';

                    setTimeout(() => tooltip.style.opacity = '1', 10);

                    this.addEventListener('mouseleave', function() {
                        tooltip.remove();
                    }, {
                        once: true
                    });
                });
            });
        });
    </script>
@endpush

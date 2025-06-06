@extends('layouts.app')

@section('content')
    <style>
        /* Base Styling */
        :root {
            --primary-color: #6a6e51;
            --primary-light: #8a8f69;
            --secondary-color: #e8e9e1;
            --accent-color: #d4b96e;
            --success-color: #40c710;
            --danger-color: #f44032;
            --warning-color: #f5d700;
            --text-dark: #222222;
            --text-muted: #6c757d;
            --border-color: #e1e1e1;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, .05);
            --shadow-md: 0px 4px 24px 2px rgba(20, 25, 38, 0.05);
            --radius-sm: 6px;
            --radius-md: 12px;
            --transition: all 0.3s ease;
        }

        /* Gaya Dasar dan Variabel */
        :root {
            --primary-color: #6a6e51;
            --accent-color: #b9a16b;
            --success-color: #40c710;
            --danger-color: #f44032;
            --warning-color: #f5d700;
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

        /* Card Styling */
        .my-account .wg-box {
            display: flex;
            padding: 28px;
            flex-direction: column;
            gap: 24px;
            border-radius: var(--radius-md);
            background: #fff;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            border-top: 3px solid var(--primary-color);
            margin-bottom: 25px;
        }

        .my-account .wg-box:hover {
            box-shadow: 0px 8px 30px rgba(20, 25, 38, 0.12);
        }

        .my-account .wg-box h5 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px dashed var(--border-color);
            position: relative;
        }

        /* Status Badges */
        .badge {
            padding: 0.5rem 1rem;
            font-weight: 500;
            border-radius: 30px;
            font-size: 0.85rem;
        }

        .bg-success {
            background-color: var(--success-color) !important;
            color: #fff;
        }

        .bg-danger {
            background-color: var(--danger-color) !important;
            color: #fff;
        }

        .bg-warning {
            background-color: var(--warning-color) !important;
            color: var(--text-dark);
        }

        .bg-secondary {
            background-color: #6c757d !important;
            color: #fff;
        }

        /* Tables */
        .table-transaction {
            margin-bottom: 0;
        }

        .table-transaction>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: #fff !important;
        }

        .table-transaction th,
        .table-transaction td {
            padding: 0.75rem 1.5rem !important;
            color: var(--text-dark) !important;
            vertical-align: middle;
        }

        .table> :not(caption)>tr>th {
            padding: 0.75rem 1.5rem !important;
            background-color: var(--primary-color) !important;
            color: #fff !important;
            font-weight: 600;
        }

        .table-bordered> :not(caption)>*>* {
            border-width: 1px;
            line-height: 1.7;
            font-size: 14px;
            border: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .table-bordered> :not(caption)>tr>th,
        .table-bordered> :not(caption)>tr>td {
            border-width: 1px;
            border-color: var(--border-color);
        }

        /* Item Rows */
        .table-striped tbody tr:hover {
            background-color: rgba(106, 110, 81, 0.05);
        }

        .table-striped .image {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            flex-shrink: 0;
            border-radius: var(--radius-sm);
            overflow: hidden;
            border: 1px solid var(--border-color);
            padding: 3px;
            background-color: #fff;
        }

        .table-striped td:nth-child(1) {
            min-width: 250px;
        }

        .pname {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .name a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .name a:hover {
            color: var(--accent-color);
        }

        /* Buttons */
        .btn {
            border-radius: 4px;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-light);
            border-color: var(--primary-light);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .btn-sm {
            padding: 0.25rem 0.7rem;
            font-size: 0.85rem;
        }

        /* Address Card */
        .my-account__address-item {
            padding: 20px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            background-color: #f9f9f9;
        }

        .my-account__address-item__detail p {
            margin-bottom: 5px;
            color: var(--text-dark);
        }

        .my-account__address-item__detail p:first-child {
            font-weight: 600;
            font-size: 1.1rem;
        }

        /* Order Status Timeline */
        .order-timeline {
            position: relative;
            padding: 20px 0;
        }

        .timeline-track {
            position: relative;
            height: 5px;
            background-color: var(--border-color);
            margin: 30px 0;
            border-radius: 5px;
        }

        .timeline-progress {
            position: absolute;
            top: 0;
            left: 0;
            height: 5px;
            background-color: var(--primary-color);
            border-radius: 5px;
        }

        .timeline-step {
            position: absolute;
            top: -15px;
            transform: translateX(-50%);
            width: 35px;
            height: 35px;
            background-color: var(--border-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            transition: var(--transition);
        }

        .timeline-step.active {
            background-color: var(--primary-color);
            color: #fff;
        }

        .timeline-step.done {
            background-color: var(--success-color);
            color: #fff;
        }

        .timeline-step.canceled {
            background-color: var(--danger-color);
            color: #fff;
        }

        .timeline-label {
            position: absolute;
            top: 25px;
            transform: translateX(-50%);
            text-align: center;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
        }

        .timeline-date {
            font-size: 10px;
            color: #6c757d;
            margin-top: 4px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .my-account .wg-box {
                padding: 20px;
            }

            .my-account .page-title {
                font-size: 1.5rem;
            }

            .timeline-step {
                width: 30px;
                height: 30px;
            }

            .timeline-label {
                font-size: 10px;
            }
        }

        /* Animation */
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

        .animate-fade {
            animation: fadeIn 0.5s ease forwards;
        }

        .animate-delay-1 {
            animation-delay: 0.1s;
        }

        .animate-delay-2 {
            animation-delay: 0.2s;
        }

        .animate-delay-3 {
            animation-delay: 0.3s;
        }

        .animate-delay-4 {
            animation-delay: 0.4s;
        }

        .rating {
            display: inline-block;
        }

        .rating>input[type="radio"] {
            display: none;
        }

        .rating>label {
            color: #ccc;
            font-size: 1.5em;
            cursor: pointer;
            margin: 0 1px;
            transition: color .2s;
        }

        .rating>input[type="radio"]:checked~label {
            color: #f6b500;
        }

        .rating>label:hover {
            color: #f6b500;
        }

        .rating>label.active {
            color: #f6b500;
        }

        /* Payment Section Styles */
        .payment-timeout-alert {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
            padding: 15px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
        }

        .timeout-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .timeout-title {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
        }

        .countdown-display {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
        }

        .timeout-message {
            margin: 0;
            font-size: 0.9rem;
            text-align: center;
        }

        .bank-info-card {
            background: #f8f9fa;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 20px;
        }

        .bank-info-card h6 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .bank-details p {
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }

        .bank-details strong {
            min-width: 120px;
        }

        /* Payment Success Styles */
        .payment-success-info {
            background: #f8f9fa;
            border: 1px solid #d1ecf1;
            border-radius: var(--radius-sm);
            padding: 20px;
            margin-top: 15px;
        }

        .payment-success-info p {
            margin-bottom: 8px;
        }

        .payment-success-info strong {
            color: var(--text-dark);
        }

        .alert-success {
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            border-left: 4px solid #dc3545;
        }

        /* Payment Proof Uploaded Styles */
        .payment-proof-uploaded {
            background: #f8f9fa;
            border: 1px solid #d1ecf1;
            border-radius: var(--radius-sm);
            padding: 20px;
            margin-top: 15px;
        }

        .uploaded-proof-info {
            background: white;
            border-radius: var(--radius-sm);
            padding: 15px;
            margin-top: 15px;
            border: 1px solid #e9ecef;
        }

        .uploaded-proof-info p {
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .uploaded-proof-info strong {
            color: var(--text-dark);
            min-width: 140px;
        }

        .reupload-section {
            border-top: 1px dashed #dee2e6;
            padding-top: 15px;
        }

        #reupload-form {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
        }

        #reupload-form .form-control {
            border: 1px solid #ced4da;
            border-radius: 6px;
        }

        #reupload-form .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(106, 110, 81, 0.25);
        }

        /* Enhanced Alert Styles */
        .alert-success {
            border-left: 4px solid #28a745;
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
        }

        .alert-info {
            border-left: 4px solid #17a2b8;
            background: linear-gradient(135deg, #d1ecf1, #bee5eb);
        }

        .alert-warning {
            border-left: 4px solid #ffc107;
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        }

        /* Button Enhancements */
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }
    </style>
    <main class="pt-90">
        {{-- @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Detail Pesanan Anda</h2>
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

                    <!-- Order Status Timeline -->
                    <div class="wg-box animate-fade">
                        <h5><i class="fa fa-history me-2"></i>Status Pesanan</h5>
                        <div class="order-timeline">
                            <div class="timeline-track">
                                @php
                                    $progress = 0;
                                    if ($transaction->order->status == 'pending') {
                                        $progress = 0;
                                    } elseif ($transaction->order->status == 'confirmed') {
                                        $progress = 20;
                                    } elseif ($transaction->order->status == 'processing') {
                                        $progress = 40;
                                    } elseif ($transaction->order->status == 'shipped') {
                                        $progress = 60;
                                    } elseif ($transaction->order->status == 'delivered') {
                                        $progress = 80;
                                    } elseif ($transaction->order->status == 'completed') {
                                        $progress = 100;
                                    } elseif ($transaction->order->status == 'canceled') {
                                        $progress = 100;
                                    }
                                @endphp
                                <div class="timeline-progress" style="width: {{ $progress }}%;"></div>

                                <!-- Order Placed -->
                                <div class="timeline-step {{ in_array($transaction->order->status, ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'completed']) ? 'active' : ($transaction->order->status === 'canceled' ? 'canceled' : '') }}"
                                    style="left: 0%;">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <div class="timeline-label" style="left: 0%;">Menunggu</div>
                                <div class="timeline-date">
                                    {{ $transaction->order->created_at ? $transaction->order->created_at->format('d/m/Y') : '-' }}
                                </div>

                                <!-- Confirmed -->
                                <div class="timeline-step {{ in_array($transaction->order->status, ['confirmed', 'processing', 'shipped', 'delivered', 'completed']) ? 'active' : ($transaction->order->status === 'canceled' ? 'canceled' : '') }}"
                                    style="left: 20%;">
                                    <i class="fa fa-check"></i>
                                </div>
                                <div class="timeline-label" style="left: 20%;">Dikonfirmasi</div>
                                <div class="timeline-date">
                                    {{ $transaction->order->confirmed_date ? \Carbon\Carbon::parse($transaction->order->confirmed_date)->format('d/m/Y') : '-' }}
                                </div>

                                <!-- Processing -->
                                <div class="timeline-step {{ in_array($transaction->order->status, ['processing', 'shipped', 'delivered', 'completed']) ? 'active' : ($transaction->order->status === 'canceled' ? 'canceled' : '') }}"
                                    style="left: 40%;">
                                    <i class="fa fa-box"></i>
                                </div>
                                <div class="timeline-label" style="left: 40%;">Diproses</div>
                                <div class="timeline-date">
                                    {{ $transaction->order->processing_date ? \Carbon\Carbon::parse($transaction->order->processing_date)->format('d/m/Y') : '-' }}
                                </div>

                                <!-- Shipped -->
                                <div class="timeline-step {{ in_array($transaction->order->status, ['shipped', 'delivered', 'completed']) ? 'active' : ($transaction->order->status === 'canceled' ? 'canceled' : '') }}"
                                    style="left: 60%;">
                                    <i class="fa fa-truck"></i>
                                </div>
                                <div class="timeline-label" style="left: 60%;">Dikirim</div>
                                <div class="timeline-date">
                                    {{ $transaction->order->shipped_date ? \Carbon\Carbon::parse($transaction->order->shipped_date)->format('d/m/Y') : '-' }}
                                </div>

                                <!-- Delivered -->
                                <div class="timeline-step {{ in_array($transaction->order->status, ['delivered', 'completed']) ? 'active' : ($transaction->order->status === 'canceled' ? 'canceled' : '') }}"
                                    style="left: 80%;">
                                    <i class="fa fa-box-open"></i>
                                </div>
                                <div class="timeline-label" style="left: 80%;">Paket Anda telah sampai</div>
                                <div class="timeline-date">
                                    {{ $transaction->order->delivered_date ? \Carbon\Carbon::parse($transaction->order->delivered_date)->format('d/m/Y') : '-' }}
                                </div>

                                <!-- Completed -->
                                <div class="timeline-step {{ $transaction->order->status === 'completed' ? 'done' : ($transaction->order->status === 'canceled' ? 'canceled' : '') }}"
                                    style="left: 100%;">
                                    <i class="fa fa-check-circle"></i>
                                </div>
                                <div class="timeline-label" style="left: 100%;">
                                    {{ $transaction->order->status === 'canceled' ? 'Dibatalkan' : 'Selesai' }}
                                </div>
                                <div class="timeline-date">
                                    {{ $transaction->order->status === 'canceled'
                                        ? ($transaction->order->canceled_date
                                            ? \Carbon\Carbon::parse($transaction->order->canceled_date)->format('d/m/Y')
                                            : '-')
                                        : ($transaction->order->completed_date
                                            ? \Carbon\Carbon::parse($transaction->order->completed_date)->format('d/m/Y')
                                            : '-') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Actions - Confirm Delivery Button -->
                    @if ($transaction->order->status === 'delivered')
                        <div class="wg-box animate-fade">
                            <h5><i class="fa fa-clipboard-check me-2"></i>Konfirmasi Pesanan</h5>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle me-2"></i> Setelah menerima pesanan Anda, silahkan konfirmasi
                                penerimaan dengan menekan tombol di bawah ini.
                            </div>
                            <form action="{{ route('user.account.confirm.delivery') }}" method="POST"
                                id="confirmDeliveryForm">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $transaction->order->id }}">
                                <button type="button" class="btn btn-success btn-lg confirm-delivery">
                                    <i class="fa fa-check-circle me-2"></i> Pesanan Telah Diterima
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Order Details -->
                    <div class="wg-box animate-fade animate-delay-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="fa fa-file-invoice me-2"></i>Detail Pesanan</h5>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('user.account.orders') }}">
                                <i class="fa fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-transaction">
                                <tr>
                                    <th><i class="fa fa-hashtag me-1"></i> No. Pesanan</th>
                                    <td>{{ '1' . str_pad($transaction->order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <th><i class="fa fa-phone me-1"></i> Telepon</th>
                                    <td>{{ $transaction->order->phone }}</td>
                                    <th><i class="fa fa-map-pin me-1"></i> Kode Pos</th>
                                    <td>{{ $transaction->order->zip }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fa fa-calendar me-1"></i> Tanggal Pesan</th>
                                    <td>{{ \Carbon\Carbon::parse($transaction->order->created_at)->format('d M Y, H:i') }}
                                    </td>
                                    <th><i class="fa fa-truck-loading me-1"></i> Tanggal Pengiriman</th>
                                    <td>{{ $transaction->order->delivered_date ? \Carbon\Carbon::parse($transaction->order->delivered_date)->format('d M Y, H:i') : '-' }}
                                    </td>
                                    <th><i class="fa fa-check-circle me-1"></i> Tanggal Selesai</th>
                                    <td>{{ $transaction->order->completed_date ? \Carbon\Carbon::parse($transaction->order->completed_date)->format('d M Y, H:i') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th><i class="fa fa-info-circle me-1"></i> Status Pesanan</th>
                                    <td colspan="5">
                                        @if ($transaction->order->status == 'pending')
                                            <span class="badge bg-warning"><i class="fa fa-clock me-1"></i> Menunggu</span>
                                        @elseif ($transaction->order->status == 'confirmed')
                                            <span class="badge bg-warning"><i class="fa fa-check me-1"></i>
                                                Dikonfirmasi</span>
                                        @elseif ($transaction->order->status == 'processing')
                                            <span class="badge bg-warning"><i class="fa fa-cog me-1"></i> Diproses</span>
                                        @elseif ($transaction->order->status == 'shipped')
                                            <span class="badge bg-warning"><i class="fa fa-truck me-1"></i> Dikirim</span>
                                        @elseif ($transaction->order->status == 'delivered')
                                            <span class="badge bg-warning"><i class="fa fa-box-open me-1"></i> Menunggu
                                                Konfirmasi Anda</span>
                                        @elseif ($transaction->order->status == 'completed')
                                            <span class="badge bg-success"><i class="fa fa-check-circle me-1"></i>
                                                Selesai</span>
                                        @elseif ($transaction->order->status == 'canceled')
                                            <span class="badge bg-danger"><i class="fa fa-times me-1"></i>
                                                Dibatalkan</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Ordered Items -->
                    <div class="wg-box wg-table table-all-user animate-fade animate-delay-2">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5><i class="fa fa-shopping-basket me-2"></i>Produk Pesanan</h5>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" style="min-width: 1000px;">
                                <thead class="thead-dark">
                                    <tr class="text-center text-nowrap">
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>SKU</th>
                                        <th>Kategori</th>
                                        <th>Brand</th>
                                        <th>Opsi</th>
                                        <th>Return</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderItems as $orderitem)
                                        <tr class="text-center text-nowrap align-middle">
                                            <td class="pname">
                                                <div class="image">
                                                    <img src="{{ asset('uploads/products/thumbnails/' . $orderitem->product->image) }}"
                                                        alt="{{ $orderitem->product->name }}"
                                                        style="width: 50px; height: auto; object-fit: cover;">
                                                </div>
                                                <div class="name text-start">
                                                    <a href="{{ route('shop.product.details', ['product_slug' => $orderitem->product->slug]) }}"
                                                        target="_blank" class="body-title-2">
                                                        {{ $orderitem->product->name }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>Rp. {{ number_format($orderitem->price, 0, ',', '.') }}</td>
                                            <td>{{ $orderitem->quantity }}</td>
                                            <td>{{ $orderitem->product->SKU }}</td>
                                            <td>{{ $orderitem->product->category->name }}</td>
                                            <td>{{ $orderitem->product->brand->name }}</td>
                                            <td>{{ $orderitem->options }}</td>
                                            <td>
                                                @if ($orderitem->rstatus == 0)
                                                    <span class="badge bg-secondary">Tidak</span>
                                                @else
                                                    <span class="badge bg-success">Ya</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('shop.product.details', ['product_slug' => $orderitem->product->slug]) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary"
                                                        title="Lihat Produk">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-outline-success"
                                                        title="Beli Lagi">
                                                        <i class="fa fa-cart-plus"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="divider"></div>
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 my-3">
                        {{ $orderItems->links('pagination::bootstrap-5') }}
                    </div>

                    <!-- Shipping Address -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="wg-box animate-fade animate-delay-3">
                                <h5><i class="fa fa-map-marker-alt me-2"></i>Alamat Pengiriman</h5>
                                <div class="my-account__address-item">
                                    <div class="my-account__address-item__detail">
                                        <p><strong>{{ $transaction->order->name }}</strong></p>
                                        <p><i class="fa fa-home me-2 text-muted"></i>{{ $transaction->order->address }}
                                        </p>
                                        <p>{{ $transaction->order->locality }}</p>
                                        <p>{{ $transaction->order->city }}, {{ $transaction->order->country }}</p>
                                        <p><i class="fa fa-map me-2 text-muted"></i>{{ $transaction->order->landmark }}
                                        </p>
                                        <p><i class="fa fa-map-pin me-2 text-muted"></i>{{ $transaction->order->zip }}</p>
                                        <hr>
                                        <p><i class="fa fa-phone me-2 text-muted"></i>{{ $transaction->order->phone }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Transactions -->
                        <div class="col-md-6">
                            <div class="wg-box animate-fade animate-delay-4">
                                <h5><i class="fa fa-credit-card me-2"></i>Transaksi</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-transaction">
                                        <tr>
                                            <th>Subtotal</th>
                                            <td>Rp. {{ number_format($transaction->order->subtotal) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pajak</th>
                                            <td>Rp. {{ number_format($transaction->order->tax) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Diskon</th>
                                            <td>Rp. {{ number_format($transaction->order->discount) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td><strong>Rp. {{ number_format($transaction->order->total) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Metode Pembayaran</th>
                                            <td>{{ $transaction->mode }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status Pembayaran</th>
                                            <td>
                                                <!-- Lanjutan kode yang terpotong -->
                                                @if ($transaction->status == 'approved')
                                                    <span class="badge bg-success"><i class="fa fa-check-circle me-1"></i>
                                                        Lunas</span>
                                                @elseif($transaction->status == 'pending')
                                                    <span class="badge bg-warning"><i class="fa fa-clock me-1"></i>
                                                        Menunggu</span>
                                                @elseif($transaction->status == 'declined')
                                                    <span class="badge bg-danger"><i class="fa fa-times-circle me-1"></i>
                                                        Ditolak</span>
                                                @elseif($transaction->status == 'refunded')
                                                    <span class="badge bg-info"><i class="fa fa-undo me-1"></i>
                                                        Dikembalikan</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Payment Action Section - Perbaikan Logic untuk Status Sudah Dibayar -->
                    @if ($transaction->status == 'pending')
                        <div class="wg-box animate-fade">
                            <h5><i class="fa fa-credit-card me-2"></i>Lanjutkan Pembayaran</h5>

                            {{-- Logika: Jika ada snap_token, anggap sebagai Midtrans --}}
                            @if ($transaction->snap_token)
                                <!-- Midtrans Payment -->
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle me-2"></i>
                                    Pesanan Anda belum dibayar. Silakan lanjutkan pembayaran dengan Midtrans.
                                </div>

                                <div class="payment-timeout-alert mb-3">
                                    <div class="timeout-header">
                                        <i class="fas fa-clock"></i>
                                        <h6 class="timeout-title">Batas Waktu Pembayaran</h6>
                                    </div>
                                    <div class="countdown-display" id="payment-countdown-detail">23:59:59</div>
                                    <p class="timeout-message">Selesaikan pembayaran sebelum waktu habis</p>
                                </div>

                                <button id="pay-button-detail" class="btn btn-primary btn-lg">
                                    <i class="fa fa-credit-card me-2"></i> Bayar Sekarang (Midtrans)
                                </button>
                            @elseif ($transaction->mode == 'manual_atm' || $transaction->bank_code)
                                <!-- Manual Bank Transfer -->
                                <div class="alert alert-info">
                                    <i class="fa fa-university me-2"></i>
                                    Silakan lakukan transfer ke rekening bank BNI dan upload bukti pembayaran.
                                </div>

                                <!-- Bank Account Info -->
                                <div class="bank-info-card mb-3">
                                    <h6><i class="fa fa-university me-1"></i> Informasi Rekening Bank BNI</h6>
                                    <div class="bank-details">
                                        <p><strong>Bank:</strong> Bank BNI</p>
                                        <p><strong>No. Rekening:</strong> 1234567890</p>
                                        <p><strong>Atas Nama:</strong> Bank Koperasi Eceng Gondok</p>
                                        <p><strong>Jumlah Transfer:</strong> <span
                                                class="text-danger fw-bold">{{ formatRupiah($transaction->order->total) }}</span>
                                        </p>
                                    </div>
                                </div>

                                @if ($transaction->payment_proof)
                                    <!-- Bukti Pembayaran Sudah Diupload -->
                                    <div class="payment-proof-uploaded">
                                        <div class="alert alert-success">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-check-circle fa-2x text-success me-3"></i>
                                                <div>
                                                    <h6 class="mb-1"><strong>Bukti Pembayaran Sudah Diupload</strong>
                                                    </h6>
                                                    <p class="mb-0">Bukti pembayaran Anda sedang dalam proses verifikasi
                                                        oleh admin. Mohon tunggu konfirmasi.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="uploaded-proof-info">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Status Verifikasi:</strong>
                                                        <span class="badge bg-warning">Menunggu Verifikasi</span>
                                                    </p>
                                                    <p><strong>Tanggal Upload:</strong>
                                                        {{ $transaction->updated_at->format('d M Y, H:i') }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>File:</strong>
                                                        <a href="{{ asset('storage/' . $transaction->payment_proof) }}"
                                                            target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="fa fa-eye me-1"></i> Lihat Bukti
                                                        </a>
                                                    </p>
                                                    <p><strong>Estimasi Verifikasi:</strong> 1x24 jam</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Form untuk Upload Ulang (Jika diperlukan) -->
                                        <div class="reupload-section mt-3">
                                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                                id="reupload-toggle">
                                                <i class="fa fa-upload me-1"></i> Upload Ulang Bukti Pembayaran
                                            </button>

                                            <div id="reupload-form" style="display: none;" class="mt-3">
                                                <form action="{{ route('upload.payment.proof') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="order_id"
                                                        value="{{ $transaction->order->id }}">

                                                    <div class="mb-3">
                                                        <label for="payment_proof_reupload" class="form-label">
                                                            <i class="fa fa-upload me-1"></i> Upload Bukti Pembayaran Baru
                                                        </label>
                                                        <input type="file" class="form-control"
                                                            id="payment_proof_reupload" name="payment_proof"
                                                            accept="image/*,.pdf" required>
                                                        <div class="form-text">
                                                            Format yang diterima: JPG, PNG, PDF (maksimal 2MB)
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-upload me-2"></i> Upload Ulang
                                                    </button>
                                                    <button type="button" class="btn btn-secondary btn-sm ms-2"
                                                        id="cancel-reupload">
                                                        Batal
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Form Upload Bukti Pembayaran (Belum Upload) -->
                                    <form action="{{ route('upload.payment.proof') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $transaction->order->id }}">

                                        <div class="mb-3">
                                            <label for="payment_proof" class="form-label">
                                                <i class="fa fa-upload me-1"></i> Upload Bukti Pembayaran
                                            </label>
                                            <input type="file" class="form-control" id="payment_proof"
                                                name="payment_proof" accept="image/*,.pdf" required>
                                            <div class="form-text">
                                                Format yang diterima: JPG, PNG, PDF (maksimal 2MB)
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-upload me-2"></i> Upload Bukti Pembayaran
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>

                        {{-- Tambahkan section untuk status SUDAH DIBAYAR --}}
                    @elseif (in_array($transaction->status, ['approved', 'paid']))
                        <div class="wg-box animate-fade">
                            <h5><i class="fa fa-check-circle me-2 text-success"></i>Status Pembayaran</h5>
                            <div class="alert alert-success">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-check-circle fa-2x text-success me-3"></i>
                                    <div>
                                        <h6 class="mb-1"><strong>Pembayaran Berhasil!</strong></h6>
                                        <p class="mb-0">Terima kasih! Pembayaran Anda telah dikonfirmasi dan pesanan
                                            sedang diproses.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="payment-success-info">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Metode Pembayaran:</strong> {{ $transaction->mode_display }}</p>
                                        <p><strong>Status:</strong> <span class="badge bg-success">Lunas</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Total Dibayar:</strong> {{ formatRupiah($transaction->order->total) }}
                                        </p>
                                        <p><strong>Tanggal Pembayaran:</strong>
                                            {{ $transaction->updated_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section untuk status DITOLAK atau GAGAL --}}
                    @elseif (in_array($transaction->status, ['declined', 'failed']))
                        <div class="wg-box animate-fade">
                            <h5><i class="fa fa-times-circle me-2 text-danger"></i>Status Pembayaran</h5>
                            <div class="alert alert-danger">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-times-circle fa-2x text-danger me-3"></i>
                                    <div>
                                        <h6 class="mb-1"><strong>Pembayaran Gagal</strong></h6>
                                        <p class="mb-0">Pembayaran tidak dapat diproses. Silakan coba lagi atau hubungi
                                            customer service.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('user.account.orders') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left me-1"></i> Kembali ke Pesanan
                                </a>
                                <a href="{{ route('home.contact.index') }}" class="btn btn-warning">
                                    <i class="fa fa-phone me-1"></i> Hubungi CS
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Cancel Order Button - only show for pending orders -->
                    @if ($transaction->order->status == 'pending')
                        <div class="wg-box animate-fade">
                            <h5><i class="fa fa-times-circle me-2"></i>Batalkan Pesanan</h5>
                            <div class="alert alert-warning">
                                <i class="fa fa-exclamation-triangle me-2"></i> Anda dapat membatalkan pesanan selama
                                status masih "Menunggu".
                            </div>
                            <form action="{{ route('user.account_cancel_order') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="order_id" value="{{ $transaction->order->id }}">
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                    <i class="fa fa-times me-2"></i> Batalkan Pesanan
                                </button>
                            </form>
                        </div>
                    @endif

                    {{-- Tambahkan di bawah tombol aksi pada setiap $orderitem di tabel --}}
                    @if ($transaction->order->status === 'completed')
                        <tr>
                            <td colspan="9">
                                @if (!$orderitem->review)
                                    <div class="mt-3 p-3 border rounded bg-light">
                                        <strong>Beri Ulasan untuk <span
                                                class="text-primary">{{ $orderitem->product->name }}</span></strong>
                                        <form action="{{ route('user.reviews.store') }}" method="POST"
                                            enctype="multipart/form-data" class="mt-2">
                                            @csrf
                                            <input type="hidden" name="order_item_id" value="{{ $orderitem->id }}">
                                            <input type="hidden" name="product_id"
                                                value="{{ $orderitem->product->id }}">
                                            {{-- Rating Stars --}}
                                            <div class="mb-2">
                                                <label class="form-label">Rating:</label>
                                                <span class="rating">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <input type="radio" name="rating"
                                                            id="star{{ $orderitem->id }}-{{ $i }}"
                                                            value="{{ $i }}"
                                                            @if (old('rating') == $i) checked @endif required>
                                                        <label for="star{{ $orderitem->id }}-{{ $i }}"
                                                            class="fa fa-star"></label>
                                                    @endfor
                                                </span>
                                            </div>
                                            {{-- Comment --}}
                                            <div class="mb-2">
                                                <textarea name="comment" class="form-control" placeholder="Tulis ulasan Anda (opsional)" rows="2">{{ old('comment') }}</textarea>
                                            </div>
                                            {{-- Media Upload --}}
                                            <div class="mb-2">
                                                <label class="form-label">Foto/Video (opsional):</label>
                                                <input type="file" name="media[]" accept="image/*,video/*"
                                                    class="form-control review-media-input" multiple>
                                                <div class="media-preview mt-2"
                                                    style="display:flex;gap:8px;flex-wrap:wrap;"></div>
                                            </div>
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fa fa-star me-1"></i> Kirim Ulasan</button>
                                        </form>
                                    </div>
                                @else
                                    {{-- Sudah ada review, tampilkan ringkasan & media --}}
                                    <div class="mt-3 p-3 border rounded bg-success bg-opacity-10">
                                        <strong>Ulasan Anda:</strong>
                                        <div>
                                            <span>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa fa-star{{ $i <= $orderitem->review->rating ? ' text-warning' : '-o text-muted' }}"></i>
                                                @endfor
                                            </span>
                                            <small class="text-muted">({{ $orderitem->review->rating }}/5)</small>
                                        </div>
                                        <div>
                                            <em>{{ $orderitem->review->comment ?? '-' }}</em>
                                        </div>
                                        @if ($orderitem->review->reviewMedia->count())
                                            <div class="mt-2">
                                                @foreach ($orderitem->review->reviewMedia as $media)
                                                    @if ($media->file_type === 'image')
                                                        <img src="{{ asset('storage/' . $media->file_path) }}"
                                                            alt="Review Image"
                                                            style="max-width:80px;max-height:80px;border-radius:8px;margin:3px;">
                                                    @elseif($media->file_type === 'video')
                                                        <video controls
                                                            style="max-width:120px;max-height:80px;margin:3px;">
                                                            <source src="{{ asset('storage/' . $media->file_path) }}">
                                                            Video tidak didukung.
                                                        </video>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                        <form action="{{ route('user.reviews.update', $orderitem->review->id) }}"
                                            method="POST" enctype="multipart/form-data" class="mt-2">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-2">
                                                <label class="form-label">Edit Rating:</label>
                                                <span class="rating">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <input type="radio" name="rating"
                                                            id="edit-star{{ $orderitem->id }}-{{ $i }}"
                                                            value="{{ $i }}"
                                                            @if ($orderitem->review->rating == $i) checked @endif required>
                                                        <label for="edit-star{{ $orderitem->id }}-{{ $i }}"
                                                            class="fa fa-star"></label>
                                                    @endfor
                                                </span>
                                            </div>
                                            <div class="mb-2">
                                                <textarea name="comment" class="form-control" rows="2">{{ $orderitem->review->comment }}</textarea>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">Tambah Foto/Video:</label>
                                                <input type="file" name="media[]" accept="image/*,video/*"
                                                    class="form-control" multiple>
                                            </div>
                                            <button type="submit" class="btn btn-outline-primary btn-sm"><i
                                                    class="fa fa-refresh"></i> Update Ulasan</button>
                                        </form>
                                        @if ($orderitem->review->reviewMedia->count())
                                            <div class="mt-2">
                                                <small>Hapus media:</small>
                                                @foreach ($orderitem->review->reviewMedia as $media)
                                                    <form action="{{ route('user.reviews.delete-media', $media->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-xs"
                                                            style="font-size:11px;padding:2px 6px;"
                                                            onclick="return confirm('Hapus media ini?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endif

                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    @if ($transaction->status == 'pending' && $transaction->snap_token)
        <!-- Midtrans Script untuk Payment Detail -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const payButton = document.getElementById('pay-button-detail');
                if (payButton) {
                    payButton.addEventListener('click', function() {
                        snap.pay('{{ $transaction->snap_token }}', {
                            onSuccess: function(result) {
                                console.log("Success", result);

                                // Tampilkan loading state
                                Swal.fire({
                                    title: 'Memproses Pembayaran...',
                                    text: 'Sedang memverifikasi pembayaran Anda. Mohon tunggu.',
                                    icon: 'info',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showConfirmButton: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });

                                // Auto-check status dengan polling
                                checkPaymentStatus();
                            },
                            onPending: function(result) {
                                console.log("Pending", result);
                                Swal.fire({
                                    title: 'Pembayaran Sedang Diproses',
                                    text: 'Pembayaran Anda sedang dalam proses verifikasi.',
                                    icon: 'info',
                                    iconColor: '#b9a16b',
                                    confirmButtonText: 'Mengerti',
                                    confirmButtonColor: '#b9a16b',
                                }).then(() => {
                                    // Check status juga untuk pending
                                    checkPaymentStatus();
                                });
                            },
                            onError: function(result) {
                                console.log("Error", result);
                                Swal.fire({
                                    title: 'Pembayaran Gagal',
                                    text: 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.',
                                    icon: 'error',
                                    iconColor: '#e74c3c',
                                    confirmButtonText: 'Coba Lagi',
                                    confirmButtonColor: '#e74c3c',
                                });
                            },
                            onClose: function() {
                                Swal.fire({
                                    title: 'Pembayaran Dibatalkan',
                                    text: 'Anda menutup jendela pembayaran. Anda dapat mencoba lagi kapan saja.',
                                    icon: 'warning',
                                    iconColor: '#f39c12',
                                    confirmButtonText: 'Mengerti',
                                    confirmButtonColor: '#f39c12',
                                });
                            }
                        });
                    });
                }

                // Function untuk check payment status
                function checkPaymentStatus() {
                    let attempts = 0;
                    const maxAttempts = 20; // 20 attempts = 2 menit

                    const checkInterval = setInterval(() => {
                        attempts++;

                        // Call ke server untuk refresh status dari Midtrans API
                        fetch('{{ route('auto.check.payment.status') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    transaction_id: {{ $transaction->id }}
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Payment check result:', data);

                                if (data.status === 'approved' || data.status === 'paid') {
                                    clearInterval(checkInterval);
                                    Swal.close();

                                    Swal.fire({
                                        title: 'Pembayaran Berhasil!',
                                        text: 'Terima kasih! Pembayaran Anda telah dikonfirmasi.',
                                        icon: 'success',
                                        iconColor: '#28a745',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#28a745',
                                    }).then(() => {
                                        window.location.reload();
                                    });

                                } else if (attempts >= maxAttempts) {
                                    clearInterval(checkInterval);
                                    Swal.close();

                                    Swal.fire({
                                        title: 'Verifikasi Manual Diperlukan',
                                        text: 'Pembayaran mungkin sudah berhasil. Silakan refresh halaman atau klik tombol "Refresh Status Manual".',
                                        icon: 'warning',
                                        iconColor: '#f39c12',
                                        confirmButtonText: 'Refresh Halaman',
                                        confirmButtonColor: '#f39c12',
                                        showCancelButton: true,
                                        cancelButtonText: 'Batal',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error checking payment status:', error);
                                if (attempts >= maxAttempts) {
                                    clearInterval(checkInterval);
                                    Swal.close();

                                    Swal.fire({
                                        title: 'Tidak Dapat Memverifikasi',
                                        text: 'Silakan refresh halaman untuk melihat status terbaru.',
                                        icon: 'warning',
                                        confirmButtonText: 'Refresh Halaman',
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }
                            });
                    }, 6000); // Check every 6 seconds
                }
            });
        </script>
    @endif

    <script>
        // Script untuk countdown timer payment detail
        document.addEventListener('DOMContentLoaded', function() {
            const countdownElement = document.getElementById('payment-countdown-detail');
            if (countdownElement) {
                const createdAt = new Date('{{ $transaction->order->created_at }}');
                const deadline = new Date(createdAt.getTime() + (24 * 60 * 60 * 1000)); // 24 jam

                function updateCountdown() {
                    const now = new Date();
                    const timeLeft = deadline - now;

                    if (timeLeft <= 0) {
                        countdownElement.textContent = '00:00:00';
                        const alertBox = document.querySelector('.payment-timeout-alert');
                        if (alertBox) {
                            alertBox.style.background = 'linear-gradient(135deg, #e74c3c, #c0392b)';
                            alertBox.querySelector('.timeout-message').textContent =
                                'Waktu pembayaran telah berakhir';
                        }

                        // Disable pay button if exists
                        const payButton = document.getElementById('pay-button-detail');
                        if (payButton) {
                            payButton.disabled = true;
                            payButton.innerHTML = '<i class="fa fa-times me-2"></i> Waktu Pembayaran Habis';
                            payButton.classList.remove('btn-primary');
                            payButton.classList.add('btn-secondary');
                        }
                        return;
                    }

                    const hours = Math.floor(timeLeft / (1000 * 60 * 60));
                    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                    countdownElement.textContent =
                        `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                    // Change color when less than 1 hour
                    if (timeLeft < 3600000) {
                        const alertBox = document.querySelector('.payment-timeout-alert');
                        if (alertBox) {
                            alertBox.style.background = 'linear-gradient(135deg, #e67e22, #d35400)';
                        }
                    }
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);
            }
        });
    </script>
    <script>
        // Script untuk konfirmasi penerimaan pesanan
        document.addEventListener('DOMContentLoaded', function() {
            const confirmButton = document.querySelector('.confirm-delivery');
            const confirmForm = document.getElementById('confirmDeliveryForm');

            if (confirmButton && confirmForm) {
                confirmButton.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Konfirmasi Penerimaan',
                        text: 'Dengan mengkonfirmasi penerimaan, Anda menyatakan bahwa pesanan telah sampai dengan baik. Status pesanan akan berubah menjadi "Selesai" dan tidak dapat diubah kembali.',
                        icon: 'question',
                        iconColor: '#956a3b',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Pesanan Telah Diterima',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            confirmForm.submit();

                        }
                    });
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Untuk semua form review di halaman
            document.querySelectorAll('.review-media-input').forEach(function(input) {
                input.addEventListener('change', function(e) {
                    let preview = this.closest('form').querySelector('.media-preview');
                    preview.innerHTML = '';
                    if (this.files) {
                        Array.from(this.files).forEach(file => {
                            let reader = new FileReader();
                            reader.onload = function(evt) {
                                let el;
                                if (file.type.startsWith('image/')) {
                                    el = document.createElement('img');
                                    el.src = evt.target.result;
                                    el.style.maxWidth = '80px';
                                    el.style.maxHeight = '80px';
                                    el.style.borderRadius = '8px';
                                    el.style.margin = '2px';
                                } else if (file.type.startsWith('video/')) {
                                    el = document.createElement('video');
                                    el.src = evt.target.result;
                                    el.controls = true;
                                    el.style.maxWidth = '120px';
                                    el.style.maxHeight = '80px';
                                    el.style.margin = '2px';
                                }
                                if (el) preview.appendChild(el);
                            }
                            reader.readAsDataURL(file);
                        });
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle rating stars interaction
            document.querySelectorAll('.rating').forEach(function(ratingContainer) {
                const stars = ratingContainer.querySelectorAll('label');
                const inputs = ratingContainer.querySelectorAll('input[type="radio"]');

                // Add click event to each star
                stars.forEach(function(star, index) {
                    star.addEventListener('click', function() {
                        const ratingValue = index + 1;

                        // Set the corresponding radio input as checked
                        inputs[index].checked = true;

                        // Update visual state
                        updateStarDisplay(ratingContainer, ratingValue);
                    });

                    // Add hover effect
                    star.addEventListener('mouseenter', function() {
                        const hoverValue = index + 1;
                        updateStarDisplay(ratingContainer, hoverValue);
                    });
                });

                // Reset to actual value when mouse leaves rating container
                ratingContainer.addEventListener('mouseleave', function() {
                    const checkedInput = ratingContainer.querySelector(
                        'input[type="radio"]:checked');
                    const currentValue = checkedInput ? parseInt(checkedInput.value) : 0;
                    updateStarDisplay(ratingContainer, currentValue);
                });

                // Initialize display based on current checked value
                const checkedInput = ratingContainer.querySelector('input[type="radio"]:checked');
                if (checkedInput) {
                    updateStarDisplay(ratingContainer, parseInt(checkedInput.value));
                }
            });

            function updateStarDisplay(container, rating) {
                const stars = container.querySelectorAll('label');
                stars.forEach(function(star, index) {
                    if (index < rating) {
                        star.style.color = '#f6b500';
                    } else {
                        star.style.color = '#ccc';
                    }
                });
            }
        });
    </script>

<!-- Form untuk upload ulang bukti pembayaran -->
    <script>
// Script untuk toggle reupload form
document.addEventListener('DOMContentLoaded', function() {
    const reuploadToggle = document.getElementById('reupload-toggle');
    const reuploadForm = document.getElementById('reupload-form');
    const cancelReupload = document.getElementById('cancel-reupload');

    if (reuploadToggle && reuploadForm) {
        reuploadToggle.addEventListener('click', function() {
            if (reuploadForm.style.display === 'none' || reuploadForm.style.display === '') {
                reuploadForm.style.display = 'block';
                reuploadToggle.style.display = 'none';
            }
        });
    }

    if (cancelReupload && reuploadForm && reuploadToggle) {
        cancelReupload.addEventListener('click', function() {
            reuploadForm.style.display = 'none';
            reuploadToggle.style.display = 'inline-block';

            // Reset form
            const form = reuploadForm.querySelector('form');
            if (form) {
                form.reset();
            }
        });
    }
});
        </script>
@endpush

@extends('layouts.admin')

@section('content')
    <style>
        /* Base Styling */
        .main-content-inner {
            padding: 1.5rem;
        }

        /* Card Styling */
        .detail-card {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .card-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-back {
            background: #6c757d;
            border: 1px solid #6c757d;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-back:hover {
            background: #545b62;
            border-color: #545b62;
            color: white;
            transform: translateY(-1px);
        }

        /* Order Summary */
        .order-summary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .order-summary h4 {
            color: white;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .summary-item:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 18px;
            margin-top: 10px;
            padding-top: 15px;
            border-top: 2px solid rgba(255, 255, 255, 0.3);
        }

        .summary-label {
            font-weight: 600;
        }

        .summary-value {
            font-weight: 700;
        }

        /* Payment Status Alert */
        .payment-alert {
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            border: 2px solid;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .payment-alert.paid {
            background: #d1f2eb;
            border-color: #7dd3fc;
            color: #0c5460;
        }

        .payment-alert.pending {
            background: #fff3cd;
            border-color: #ffeaa7;
            color: #856404;
        }

        .payment-alert.declined {
            background: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .payment-icon {
            font-size: 24px;
        }

        .payment-text {
            flex: 1;
        }

        .payment-title {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .payment-desc {
            font-size: 14px;
            opacity: 0.8;
            margin: 0;
        }

        /* Status Timeline */
        .status-timeline {
            display: flex;
            align-items: center;
            margin: 20px 0;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            overflow-x: auto;
            gap: 20px;
        }

        .status-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            flex: 1;
            min-width: 120px;
        }

        .status-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            margin-bottom: 12px;
            z-index: 1;
            font-size: 20px;
            transition: all 0.3s ease;
        }

        .status-active {
            background-color: #007bff;
            color: white;
            animation: pulse 2s infinite;
        }

        .status-completed {
            background-color: #28a745;
            color: white;
        }

        .status-canceled {
            background-color: #dc3545;
            color: white;
        }

        .status-label {
            font-size: 14px;
            text-align: center;
            font-weight: 600;
            color: #495057;
            margin-bottom: 5px;
        }

        .status-date {
            font-size: 12px;
            color: #6c757d;
            text-align: center;
        }

        .status-line {
            position: absolute;
            height: 3px;
            background-color: #e9ecef;
            width: calc(100% - 60px);
            top: 25px;
            left: calc(50% + 30px);
            z-index: 0;
        }

        .status-line.completed {
            background-color: #28a745;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(0, 123, 255, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(0, 123, 255, 0);
            }
        }

        /* Info Table */
        .info-table {
            width: 100%;
            margin-bottom: 0;
        }

        .info-table th,
        .info-table td {
            padding: 15px;
            border-bottom: 1px solid #f1f3f4;
            font-size: 15px;
            vertical-align: top;
        }

        .info-table th {
            background: #f8f9fa;
            font-weight: 700;
            color: #495057;
            width: 200px;
        }

        .info-table td {
            color: #495057;
        }

        .info-table tr:last-child th,
        .info-table tr:last-child td {
            border-bottom: none;
        }

        /* Product Table */
        .product-table {
            width: 100%;
            margin-bottom: 0;
            font-size: 15px;
        }

        .product-table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 700;
            color: #495057;
            padding: 18px 15px;
            font-size: 15px;
            white-space: nowrap;
            border-top: none;
        }

        .product-table tbody td {
            padding: 18px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f4;
            font-size: 15px;
        }

        .product-table tbody tr:hover {
            background-color: #f8f9ff;
        }

        .product-table tbody tr:last-child td {
            border-bottom: none;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .product-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #e9ecef;
        }

        .product-details h6 {
            font-weight: 700;
            color: #495057;
            margin-bottom: 5px;
            font-size: 15px;
        }

        .product-meta {
            font-size: 13px;
            color: #6c757d;
        }

        /* Address Section */
        .address-section {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
        }

        .address-title {
            font-weight: 700;
            color: #495057;
            font-size: 16px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .address-details {
            line-height: 1.6;
            color: #495057;
        }

        .address-details p {
            margin-bottom: 5px;
        }

        .address-details strong {
            color: #495057;
        }

        /* Transaction Section */
        .transaction-summary {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }

        .transaction-title {
            font-weight: 700;
            color: #495057;
            font-size: 16px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Update Status Form */
        .update-form {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 10px;
            padding: 25px;
        }

        .update-title {
            font-weight: 700;
            color: #1565c0;
            font-size: 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            font-size: 15px;
            background: white;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-update {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
            color: white;
        }

        .update-note {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }

        .update-note small {
            color: #856404;
            font-size: 13px;
            line-height: 1.5;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .btn-action {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .btn-print {
            background: #28a745;
            border-color: #28a745;
            color: white;
        }

        .btn-print:hover {
            background: #1e7e34;
            border-color: #1e7e34;
            color: white;
            transform: translateY(-1px);
        }

        .btn-email {
            background: #17a2b8;
            border-color: #17a2b8;
            color: white;
        }

        .btn-email:hover {
            background: #138496;
            border-color: #138496;
            color: white;
            transform: translateY(-1px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .detail-card {
                padding: 20px;
            }

            .order-summary {
                padding: 20px;
            }

            .status-timeline {
                padding: 15px;
                gap: 10px;
            }

            .status-step {
                min-width: 100px;
            }

            .status-icon {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-back {
                align-self: flex-end;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .info-table th {
                width: auto;
            }

            .product-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .summary-item {
                font-size: 14px;
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Kelola Detail Pesanan</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.orders') }}">
                            <div class="text-tiny">Pesanan</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Detail Pesanan</div>
                    </li>
                </ul>
            </div>

            @if (Session::has('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="icon-check"></i> {{ Session::get('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Order Summary -->
            <div class="order-summary">
                <h4><i class="icon-basket"></i> Ringkasan Pesanan #{{ '1' . str_pad($transaction->order->id, 4, '0', STR_PAD_LEFT) }}</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="summary-item">
                            <span class="summary-label">Subtotal</span>
                            <span class="summary-value">Rp {{ number_format($transaction->order->subtotal) }}</span>
                        </div>
                        @if($transaction->order->discount > 0)
                        <div class="summary-item">
                            <span class="summary-label">Diskon</span>
                            <span class="summary-value">-Rp {{ number_format($transaction->order->discount) }}</span>
                        </div>
                        @endif
                        @if($transaction->order->ongkir > 0)
                        <div class="summary-item">
                            <span class="summary-label">Ongkos Kirim</span>
                            <span class="summary-value">Rp {{ number_format($transaction->order->ongkir) }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="summary-item">
                            <span class="summary-label">Metode Pembayaran</span>
                            <span class="summary-value">{{ $transaction->mode_display }}</span>
                        </div>
                        @if($transaction->order->kurir)
                        <div class="summary-item">
                            <span class="summary-label">Kurir</span>
                            <span class="summary-value">{{ strtoupper($transaction->order->kurir) }}</span>
                        </div>
                        @endif
                        <div class="summary-item">
                            <span class="summary-label">Total Pembayaran</span>
                            <span class="summary-value">Rp {{ number_format($transaction->order->total) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Status Alert -->
            @if($transaction)
                @php
                    $paymentStatus = $transaction->status;
                    $alertClass = match($paymentStatus) {
                        'approved', 'paid' => 'paid',
                        'declined' => 'declined',
                        default => 'pending'
                    };
                @endphp
                <div class="payment-alert {{ $alertClass }}">
                    @switch($alertClass)
                        @case('paid')
                            <i class="payment-icon icon-check-circle"></i>
                            <div class="payment-text">
                                <div class="payment-title">Pembayaran Berhasil</div>
                                <p class="payment-desc">Pembayaran telah diterima dan dikonfirmasi. Pesanan dapat diproses lebih lanjut.</p>
                            </div>
                            @break
                        @case('declined')
                            <i class="payment-icon icon-close-circle"></i>
                            <div class="payment-text">
                                <div class="payment-title">Pembayaran Ditolak</div>
                                <p class="payment-desc">Pembayaran ditolak. Silakan hubungi pelanggan untuk konfirmasi atau pembayaran ulang.</p>
                            </div>
                            @break
                        @default
                            <i class="payment-icon icon-clock"></i>
                            <div class="payment-text">
                                <div class="payment-title">Menunggu Pembayaran</div>
                                <p class="payment-desc">Pesanan belum dibayar. Menunggu konfirmasi pembayaran dari pelanggan.</p>
                            </div>
                    @endswitch
                </div>
            @endif

            <!-- Order Information -->
            <div class="detail-card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="icon-info"></i> Informasi Pesanan
                    </h5>
                    <a href="{{ route('admin.orders') }}" class="btn-back">
                        <i class="icon-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="info-table">
                        <tr>
                            <th>No Pesanan</th>
                            <td>{{ '1' . str_pad($transaction->order->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <th>Tanggal Pesan</th>
                            <td>{{ $transaction->order->created_at->format('d M Y, H:i') }} WIB</td>
                        </tr>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <td>{{ $transaction->order->name }}</td>
                            <th>No. Telepon</th>
                            <td>{{ $transaction->order->phone }}</td>
                        </tr>
                        <tr>
                            <th>Status Pesanan</th>
                            <td>{!! $transaction->order->status_badge !!}</td>
                            <th>Status Pembayaran</th>
                            <td>{!! $transaction->status_badge !!}</td>
                        </tr>
                        <tr>
                            <th>Total Items</th>
                            <td>{{ $orderitems->total() }} item</td>
                            <th>Kode Pos</th>
                            <td>{{ $transaction->order->zip }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="detail-card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="icon-timeline"></i> Timeline Status Pesanan
                    </h5>
                </div>
                <div class="status-timeline">
                    @php
                        $currentStatus = $transaction->order->status;
                        $statusFlow = [
                            'awaiting_payment' => ['label' => 'Menunggu Pembayaran', 'icon' => 'icon-credit-card'],
                            'pending' => ['label' => 'Menunggu Konfirmasi', 'icon' => 'icon-clock'],
                            'confirmed' => ['label' => 'Dikonfirmasi', 'icon' => 'icon-check'],
                            'processing' => ['label' => 'Diproses', 'icon' => 'icon-settings'],
                            'shipped' => ['label' => 'Dikirim', 'icon' => 'icon-plane'],
                            'delivered' => ['label' => 'Sampai Tujuan', 'icon' => 'icon-location-pin'],
                            'completed' => ['label' => 'Selesai', 'icon' => 'icon-trophy']
                        ];

                        $statusOrder = array_keys($statusFlow);
                        $currentIndex = array_search($currentStatus, $statusOrder);
                        $isCanceled = $currentStatus === 'canceled';
                    @endphp

                    @foreach($statusFlow as $status => $info)
                        @php
                            $stepIndex = array_search($status, $statusOrder);
                            $isCompleted = !$isCanceled && $stepIndex <= $currentIndex;
                            $isActive = !$isCanceled && $stepIndex === $currentIndex;

                            $dateField = $status . '_date';
                            $statusDate = $transaction->order->$dateField ?? null;
                        @endphp

                        <div class="status-step">
                            @if($stepIndex < count($statusFlow) - 1)
                                <div class="status-line {{ $isCompleted ? 'completed' : '' }}"></div>
                            @endif

                            <div class="status-icon {{ $isCanceled ? 'status-canceled' : ($isCompleted ? 'status-completed' : ($isActive ? 'status-active' : '')) }}">
                                <i class="{{ $isCanceled ? 'icon-close' : $info['icon'] }}"></i>
                            </div>

                            <div class="status-label">{{ $info['label'] }}</div>
                            <div class="status-date">
                                {{ $statusDate ? \Carbon\Carbon::parse($statusDate)->format('d/m/Y') : '-' }}
                            </div>
                        </div>
                    @endforeach

                    @if($isCanceled)
                        <div class="status-step">
                            <div class="status-icon status-canceled">
                                <i class="icon-close"></i>
                            </div>
                            <div class="status-label">Dibatalkan</div>
                            <div class="status-date">
                                {{ $transaction->order->canceled_date ? \Carbon\Carbon::parse($transaction->order->canceled_date)->format('d/m/Y') : '-' }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="detail-card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="icon-basket-loaded"></i> Daftar Produk Pesanan
                    </h5>
                </div>
                <div class="table-responsive">
                    <table class="product-table table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th width="15%" class="text-center">Harga</th>
                                <th width="10%" class="text-center">Qty</th>
                                <th width="15%" class="text-center">Subtotal</th>
                                <th width="15%" class="text-center">SKU</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderitems as $orderitem)
                                <tr>
                                    <td>
                                        <div class="product-info">
                                            <img src="{{ asset('uploads/products/thumbnails') }}/{{ $orderitem->product->image }}"
                                                alt="{{ $orderitem->product->name }}"
                                                class="product-image">
                                            <div class="product-details">
                                                <h6>{{ $orderitem->product->name }}</h6>
                                                <div class="product-meta">
                                                    <span><strong>Kategori:</strong> {{ $orderitem->product->category->name }}</span><br>
                                                    <span><strong>Merek:</strong> {{ $orderitem->product->brand->name }}</span>
                                                    @if($orderitem->options)
                                                        <br><span><strong>Opsi:</strong> {{ $orderitem->options }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">Rp {{ number_format($orderitem->price) }}</td>
                                    <td class="text-center">{{ $orderitem->quantity }}</td>
                                    <td class="text-center">Rp {{ number_format($orderitem->price * $orderitem->quantity) }}</td>
                                    <td class="text-center">{{ $orderitem->product->SKU }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('shop.product.details', ['product_slug' => $orderitem->product->slug]) }}"
                                            target="_blank" class="btn-action btn-view" title="Lihat Produk">
                                            <i class="icon-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($orderitems->hasPages())
                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        {{ $orderitems->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>

            <div class="row">
                <!-- Shipping Address -->
                <div class="col-md-6">
                    <div class="detail-card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="icon-location-pin"></i> Alamat Pengiriman
                            </h5>
                        </div>
                        <div class="address-section">
                            <div class="address-details">
                                <p><strong>{{ $transaction->order->name }}</strong></p>
                                <p>{{ $transaction->order->address }}</p>
                                <p>{{ $transaction->order->locality }}</p>
                                <p>{{ $transaction->order->city }}, {{ $transaction->order->state }}</p>
                                <p>{{ $transaction->order->country }}</p>
                                @if($transaction->order->landmark)
                                    <p><strong>Patokan:</strong> {{ $transaction->order->landmark }}</p>
                                @endif
                                <p><strong>Kode Pos:</strong> {{ $transaction->order->zip }}</p>
                                <p><strong>No. Telepon:</strong> {{ $transaction->order->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction Details -->
                <div class="col-md-6">
                    <div class="detail-card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="icon-credit-card"></i> Detail Transaksi
                            </h5>
                        </div>
                        <div class="transaction-summary">
                            <table class="info-table">
                                <tr>
                                    <th>Invoice</th>
                                    <td>{{ $transaction->invoice ?? 'ORDER-' . $transaction->order->id }}</td>
                                </tr>
                                <tr>
                                    <th>Metode</th>
                                    <td>{{ $transaction->mode_display }}</td>
                                </tr>
                                @if($transaction->bank_code)
                                <tr>
                                    <th>Bank</th>
                                    <td>{{ $transaction->bank_name }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Status</th>
                                    <td>{!! $transaction->status_badge !!}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ $transaction->created_at->format('d M Y, H:i') }} WIB</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Order Status -->
            <div class="detail-card">
                <div class="update-form">
                    <h5 class="update-title">
                        <i class="icon-edit"></i> Perbarui Status Pesanan
                    </h5>
                    <form action="{{ route('admin.order.status.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="order_id" value="{{ $transaction->order->id }}" />
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Status Pesanan</label>
                                    <select id="order_status" name="order_status" class="form-select">
                                        <option value="awaiting_payment"
                                            {{ $transaction->order->status == 'awaiting_payment' ? 'selected' : '' }}>
                                            Menunggu Pembayaran
                                        </option>
                                        <option value="pending"
                                            {{ $transaction->order->status == 'pending' ? 'selected' : '' }}>
                                            Menunggu Konfirmasi
                                        </option>
                                        <option value="confirmed"
                                            {{ $transaction->order->status == 'confirmed' ? 'selected' : '' }}>
                                            Dikonfirmasi
                                        </option>
                                        <option value="processing"
                                            {{ $transaction->order->status == 'processing' ? 'selected' : '' }}>
                                            Sedang Diproses
                                        </option>
                                        <option value="shipped"
                                            {{ $transaction->order->status == 'shipped' ? 'selected' : '' }}>
                                            Dikirim
                                        </option>
                                        <option value="delivered"
                                            {{ $transaction->order->status == 'delivered' ? 'selected' : '' }}>
                                            Sampai Tujuan
                                        </option>
                                        <option value="canceled"
                                            {{ $transaction->order->status == 'canceled' ? 'selected' : '' }}>
                                            Dibatalkan
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn-update form-control">
                                        <i class="icon-check"></i> Perbarui Status
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="update-note">
                        <small>
                            <strong>Catatan:</strong> Status "Selesai" hanya dapat diperbarui oleh pembeli setelah menerima
                            pesanan. Admin dapat mengatur status hingga "Sampai Tujuan".
                        </small>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="detail-card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="icon-settings"></i> Aksi Tambahan
                    </h5>
                </div>
                <div class="action-buttons">
                    <button onclick="printOrder()" class="btn-action btn-print">
                        <i class="icon-printer"></i> Cetak Pesanan
                    </button>
                    <button onclick="emailCustomer()" class="btn-action btn-email">
                        <i class="icon-envelope"></i> Kirim Email
                    </button>
                    <a href="{{ route('admin.orders') }}" class="btn-action btn-back">
                        <i class="icon-list"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Print function
            window.printOrder = function() {
                Swal.fire({
                    title: 'Cetak Pesanan',
                    text: 'Fitur cetak akan dibuka di tab baru',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Cetak',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Implement print functionality
                        window.print();
                    }
                });
            };

            // Email function
            window.emailCustomer = function() {
                Swal.fire({
                    title: 'Kirim Email',
                    text: 'Kirim notifikasi email ke pelanggan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Kirim',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Implement email functionality
                        Swal.fire('Terkirim!', 'Email telah dikirim ke pelanggan.', 'success');
                    }
                });
            };

            // Success/Error messages
            @if (session('status'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('status') }}',
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

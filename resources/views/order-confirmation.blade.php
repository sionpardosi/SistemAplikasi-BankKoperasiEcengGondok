@extends('layouts.app')

@section('content')
    <style>
        .cart-total th,
        .cart-total td {
            color: green;
            font-weight: bold;
            font-size: 21px !important;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-top: 60px !important;
        }

        /* Checkout Steps - Modern Design */
        :root {
            --primary: #956a3b;
            --primary-light: rgba(149, 106, 59, 0.12);
            --primary-lighter: rgba(149, 106, 59, 0.06);
            --primary-dark: #7d593a;
            --white: #ffffff;
            --text-dark: #333333;
            --text-medium: #555555;
            --text-light: #767676;
            --border-radius: 16px;
            --shadow-soft: 0 10px 30px rgba(149, 106, 59, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .checkout-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        /* Progress Bar */
        .checkout-steps:before {
            content: '';
            position: absolute;
            top: 35px;
            left: 0;
            height: 3px;
            width: 100%;
            background-color: #e7e0d8;
            z-index: -1;
        }

        .checkout-steps:after {
            content: '';
            position: absolute;
            top: 35px;
            left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, var(--primary), #a87c4f);
            z-index: -1;
            transition: var(--transition);
        }

        .checkout-steps.step-1:after {
            width: 0%;
        }

        .checkout-steps.step-2:after {
            width: 50%;
        }

        .checkout-steps.step-3:after {
            width: 100%;
        }

        .checkout-steps__item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            text-decoration: none;
            position: relative;
            width: 33.333%;
            transition: var(--transition);
        }

        /* Step Number */
        .checkout-steps__item-number {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 22px;
            font-weight: 700;
            color: var(--text-light);
            background-color: #f0e9e1;
            border: 3px solid #e7e0d8;
            margin-bottom: 16px;
            position: relative;
            transition: var(--transition);
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .checkout-steps__item-number:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), #a87c4f);
            opacity: 0;
            transition: var(--transition);
            border-radius: 50%;
            transform: scale(0.8);
        }

        .checkout-steps__item-number span {
            position: relative;
            z-index: 2;
        }

        /* Step Title */
        .checkout-steps__item-title {
            display: flex;
            flex-direction: column;
            gap: 5px;
            transition: var(--transition);
        }

        .checkout-steps__item-title span {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-medium);
            transition: var(--transition);
        }

        .checkout-steps__item-title em {
            font-size: 13px;
            font-style: normal;
            color: var(--text-light);
            transition: var(--transition);
            max-width: 160px;
            margin: 0 auto;
        }

        /* Step Icon */
        .checkout-steps__item-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            opacity: 0;
            color: var(--white);
            font-size: 20px;
            transition: all 0.4s cubic-bezier(0.68, -0.6, 0.32, 1.6);
            z-index: 3;
        }

        /* Active State */
        .checkout-steps__item.active .checkout-steps__item-number {
            border-color: var(--primary);
            color: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(149, 106, 59, 0.25);
        }

        .checkout-steps__item.active .checkout-steps__item-number:before {
            opacity: 1;
            transform: scale(1);
        }

        .checkout-steps__item.active .checkout-steps__item-title span {
            color: var(--primary);
            font-weight: 700;
        }

        .checkout-steps__item.active .checkout-steps__item-title em {
            color: var(--text-medium);
        }

        /* Completed State */
        .checkout-steps__item.completed .checkout-steps__item-number {
            border-color: var(--primary);
            color: rgba(0, 0, 0, 0);
            background-color: var(--primary);
        }

        .checkout-steps__item.completed .checkout-steps__item-number:before {
            opacity: 1;
            transform: scale(1);
        }

        .checkout-steps__item.completed .checkout-steps__item-icon {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }

        /* New Styles for Order Confirmation Page */
        .order-complete {
            max-width: 1200px;
            margin: 0 auto;
        }

        .order-complete__message {
            background-color: #f9f7f5;
            padding: 40px 20px;
            border-radius: 16px;
            margin-bottom: 40px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
        }

        .order-complete__message h3 {
            margin-top: 25px;
            margin-bottom: 15px;
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: 0.5px;
        }

        .order-complete__message p {
            max-width: 600px;
            margin: 0 auto;
            font-size: 16px;
            color: var(--text-medium);
            line-height: 1.6;
        }

        /* Order Info */
        .order-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 15px;
            margin-bottom: 40px;
        }

        .order-info__item {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            border-left: 4px solid var(--primary);
        }

        .order-info__item label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .order-info__item span {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
        }

        /* Order Details Boxes */
        .order-details-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        @media (max-width: 992px) {
            .order-details-container {
                grid-template-columns: 1fr;
            }
        }

        .order-details-box {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
            padding: 30px;
            position: relative;
            overflow: hidden;
        }

        .order-details-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), #a87c4f);
        }

        .order-details-box h4 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            position: relative;
            padding-bottom: 10px;
        }

        .order-details-box h4::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 3px;
            background: var(--primary);
        }

        .order-details-box h4 i {
            margin-right: 10px;
            color: var(--primary);
        }

        .address-detail,
        .shipping-detail {
            background-color: #f9f7f5;
            border-radius: 12px;
            padding: 20px;
            margin-top: 15px;
        }

        .shipping-detail {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .shipping-detail-item {
            flex: 1 1 calc(50% - 15px);
            min-width: 180px;
            padding: 15px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .shipping-detail-item h5 {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }

        .shipping-detail-item h5 i {
            margin-right: 5px;
            font-size: 14px;
            color: var(--primary);
        }

        .shipping-detail-item p {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .address-detail p {
            margin-bottom: 10px;
            color: var(--text-medium);
            display: flex;
            align-items: flex-start;
        }

        .address-detail p i {
            width: 20px;
            color: var(--primary);
            margin-right: 10px;
            margin-top: 4px;
        }

        .address-detail .recipient-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 15px;
        }

        /* Product Items */
        .order-product-item {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .order-product-item:last-child {
            border-bottom: none;
        }

        .order-product-item__image {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            margin-right: 20px;
            background-color: #f7f7f7;
            border: 1px solid #eee;
        }

        .order-product-item__image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .order-product-item__details {
            flex: 1;
        }

        .order-product-item__name {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
            display: block;
        }

        .order-product-item__meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 10px;
        }

        .order-product-item__meta-item {
            font-size: 14px;
            color: var(--text-light);
            display: flex;
            align-items: center;
        }

        .order-product-item__meta-item i {
            margin-right: 5px;
            font-size: 14px;
            color: var(--primary);
        }

        .order-product-item__price {
            font-size: 16px;
            font-weight: 700;
            color: var(--primary);
            margin-left: auto;
            align-self: flex-start;
        }

        /* Totals */
        .order-summary {
            margin-top: 30px;
        }

        .order-summary-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        .checkout-totals {
            width: 100%;
        }

        .checkout-totals tr {
            border-bottom: 1px solid #f0f0f0;
        }

        .checkout-totals tr:last-child {
            border-bottom: none;
        }

        .checkout-totals th {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-medium);
            padding: 12px 0;
            text-align: left;
        }

        .checkout-totals td {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
            padding: 12px 0;
            text-align: right;
        }

        .checkout-totals .cart-total th,
        .checkout-totals .cart-total td {
            font-size: 18px !important;
            font-weight: 700;
            color: var(--primary);
            padding-top: 20px;
        }

        /* Payment Button */
        .payment-actions {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn-pay {
            background: linear-gradient(to right, var(--primary), #a87c4f);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 5px 15px rgba(149, 106, 59, 0.2);
        }

        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(149, 106, 59, 0.3);
            background: linear-gradient(to right, #a87c4f, var(--primary));
        }

        .payment-info {
            padding: 15px;
            background-color: #f9f7f5;
            border-radius: 8px;
            border-left: 3px solid var(--primary);
            font-size: 14px;
            color: var(--text-medium);
            line-height: 1.6;
            margin-top: 10px;
        }

        .payment-info i {
            color: var(--primary);
            margin-right: 5px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .checkout-steps__item-number {
                width: 60px;
                height: 60px;
                font-size: 18px;
            }

            .checkout-steps__item-title span {
                font-size: 15px;
            }

            .checkout-steps__item-title em {
                font-size: 12px;
            }

            .order-info {
                grid-template-columns: 1fr;
            }

            .shipping-detail-item {
                flex: 1 1 100%;
            }

            .order-product-item {
                flex-direction: column;
            }

            .order-product-item__image {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .order-product-item__price {
                margin-left: 0;
                margin-top: 10px;
            }
        }

        @media (max-width: 480px) {
            .checkout-steps__item-title em {
                display: none;
            }

            .order-details-box {
                padding: 20px 15px;
            }
        }
    </style>

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title mb-4" style="letter-spacing:1px; margin-bottom: 3.5rem !important;">KONFIRMASI PESANAN
            </h2>
            <!-- Modern Checkout Steps -->
            <div class="checkout-steps step-3">
                <a href="{{ route('cart.index') }}" class="checkout-steps__item completed">
                    <div class="checkout-steps__item-number">
                        <span>01</span>
                        <div class="checkout-steps__item-icon">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <div class="checkout-steps__item-title">
                        <span>Keranjang Belanja</span>
                        <em>Kelola Daftar Barang Anda</em>
                    </div>
                </a>
                <a href="javascript:void(0);" class="checkout-steps__item completed">
                    <div class="checkout-steps__item-number">
                        <span>02</span>
                        <div class="checkout-steps__item-icon">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <div class="checkout-steps__item-title">
                        <span>Pengiriman dan Pembayaran</span>
                        <em>Pilih Alamat dan Metode</em>
                    </div>
                </a>
                <a href="javascript:void(0);" class="checkout-steps__item active">
                    <div class="checkout-steps__item-number">
                        <span>03</span>
                        <div class="checkout-steps__item-icon">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <div class="checkout-steps__item-title">
                        <span>Konfirmasi</span>
                        <em>Tinjau dan Kirim Pesanan</em>
                    </div>
                </a>
            </div>

            <div class="order-complete">
                <!-- Success Message -->
                <!-- Di resources/views/order-confirmation.blade.php -->
                <div class="order-complete__message text-center">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                        <circle cx="40" cy="40" r="40" fill="#B9A16B" />
                        <path d="M54.6667 29.3333L35.3333 48.6667L25.3333 38.6667" stroke="white" stroke-width="5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <h3>PESANAN ANDA TELAH DITERIMA</h3>
                    <p>Terima kasih! Pesanan Anda telah berhasil kami terima dan sedang <strong>menunggu
                            pembayaran</strong>. Silakan selesaikan
                        pembayaran untuk konfirmasi.</p>
                </div>

                <!-- Order Information Cards -->
                <div class="order-info">
                    <div class="order-info__item">
                        <label>Nomor Pesanan</label>
                        <span>#{{ $order->id }}</span>
                    </div>
                    <div class="order-info__item">
                        <label>Tanggal</label>
                        <span>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="order-info__item">
                        <label>Total Pembayaran</label>
                        <span>{{ formatRupiah($order->total) }}</span>
                    </div>
                    <div class="order-info__item">
                        <label>Metode Pembayaran</label>
                        <span>
                            @if ($order->transaction)
                                {{ $order->transaction->mode_display }}
                            @else
                                -
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Detailed Order Information -->
                <div class="order-details-container">
                    <!-- Shipping Details -->
                    <div class="order-details-box">
                        <h4><i class="fas fa-shipping-fast"></i> INFORMASI PENGIRIMAN</h4>

                        <div class="address-detail">
                            <div class="recipient-name">{{ $order->name }}</div>
                            <p><i class="fas fa-map-marker-alt"></i> <span>{{ $order->address }}</span></p>
                            <p><i class="fas fa-road"></i> <span>{{ $order->locality }}</span></p>
                            <p><i class="fas fa-city"></i> <span>{{ $order->city }}, {{ $order->state }},
                                    {{ $order->zip }}</span></p>
                            <p><i class="fas fa-phone"></i> <span>{{ $order->phone }}</span></p>
                            @if ($order->landmark)
                                <p><i class="fas fa-landmark"></i> <span>Patokan: {{ $order->landmark }}</span></p>
                            @endif
                        </div>

                        <h4 style="margin-top: 25px;"><i class="fas fa-truck"></i> DETAIL PENGIRIMAN</h4>

                        <div class="shipping-detail">
                            <div class="shipping-detail-item">
                                <h5><i class="fas fa-shipping-fast"></i> Kurir</h5>
                                <p>
                                    @php
                                        $courierNames = [
                                            'jne' => 'JNE',
                                            'pos' => 'POS Indonesia',
                                            'tiki' => 'TIKI',
                                        ];
                                        $courierName = isset($courierNames[$order->kurir])
                                            ? $courierNames[$order->kurir]
                                            : strtoupper($order->kurir);
                                    @endphp
                                    {{ $courierName }}
                                </p>
                            </div>
                            <div class="shipping-detail-item">
                                <h5><i class="fas fa-money-bill-wave"></i> Ongkos Kirim</h5>
                                <p>{{ formatRupiah($order->ongkir) }}</p>
                            </div>
                            <div class="shipping-detail-item">
                                <h5><i class="fas fa-box"></i> Status Pesanan</h5>
                                <p>{!! $order->status_badge !!}</p>
                            </div>
                            <div class="shipping-detail-item">
                                <h5><i class="fas fa-credit-card"></i> Status Pembayaran</h5>
                                <p>
                                    @if ($order->transaction)
                                        {!! $order->transaction->status_badge !!}
                                    @else
                                        <span class="badge bg-warning">Menunggu</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="order-details-box">
                        <h4><i class="fas fa-clipboard-list"></i> RINGKASAN PESANAN</h4>

                        <!-- Product Items -->
                        <div class="order-products">
                            @foreach ($order->orderItems as $item)
                                <div class="order-product-item">
                                    <div class="order-product-item__image">
                                        @if ($item->product && $item->product->image)
                                            <img src="{{ asset('uploads/products/thumbnails/' . $item->product->image) }}"
                                                alt="{{ $item->product->name }}">
                                        @else
                                            <div
                                                style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#f0f0f0;">
                                                <i class="fas fa-image" style="font-size:24px;color:#ccc;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="order-product-item__details">
                                        <span class="order-product-item__name">{{ $item->product->name }}</span>
                                        <div class="order-product-item__meta">
                                            <span class="order-product-item__meta-item">
                                                <i class="fas fa-box"></i> Jumlah: {{ $item->quantity }}
                                            </span>

                                            @if ($item->options)
                                                @php
                                                    if (is_string($item->options)) {
                                                        $options = json_decode($item->options, true);
                                                    } else {
                                                        $options = $item->options;
                                                    }
                                                @endphp
                                                @if (isset($options['size_name']))
                                                    <span class="order-product-item__meta-item">
                                                        <i class="fas fa-ruler-combined"></i> Ukuran:
                                                        {{ $options['size_name'] }}
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="order-product-item__price">
                                        {{ formatRupiah($item->price) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Totals -->
                        <div class="order-summary">
                            <div class="order-summary-title">TOTAL PEMBAYARAN</div>
                            <table class="checkout-totals">
                                <tbody>
                                    <tr>
                                        <th>Subtotal Produk</th>
                                        <td>{{ formatRupiah($order->subtotal) }}</td>
                                    </tr>
                                    @if ($order->discount > 0)
                                        <tr>
                                            <th>Diskon</th>
                                            <td>-{{ formatRupiah($order->discount) }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th>Ongkos Kirim</th>
                                        <td>{{ formatRupiah($order->ongkir) }}</td>
                                    </tr>
                                    <tr class="cart-total">
                                        <th>TOTAL</th>
                                        <td>{{ formatRupiah($order->total) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Payment Button -->
                        <div class="payment-actions">
                            @if ($order->transaction && $order->transaction->status === 'pending')
                                <button id="pay-button" class="btn-pay">
                                    <i class="fas fa-credit-card"></i> BAYAR SEKARANG
                                </button>

                                <div class="payment-info">
                                    <i class="fas fa-info-circle"></i> Setelah pembayaran berhasil, pesanan Anda akan segera
                                    diproses. Detil pembayaran dan status pesanan dapat dilihat di halaman akun Anda.
                                </div>
                            @else
                                <a href="{{ route('account-orders') }}" class="btn-pay">
                                    <i class="fas fa-user"></i> LIHAT PESANAN SAYA
                                </a>
                            @endif
                        </div>

                        <!-- Transfer Bank Section - Tambahkan setelah payment-actions div -->
                        @if ($order->transaction && $order->transaction->mode === 'manual_atm' && $order->transaction->status === 'pending')
                            <div class="bank-transfer-section mt-4">
                                <div class="bank-transfer-info">
                                    <h4><i class="fas fa-university"></i> INFORMASI TRANSFER BANK</h4>

                                    <!-- Timer Countdown -->
                                    <div class="payment-timer">
                                        <div class="timer-header">
                                            <i class="fas fa-clock"></i>
                                            <span>Batas Waktu Pembayaran</span>
                                        </div>
                                        <div class="countdown-timer" id="payment-countdown">
                                            <span id="countdown-display">23:59:59</span>
                                        </div>
                                        <p class="timer-note">Harap selesaikan pembayaran sebelum batas waktu berakhir</p>
                                    </div>

                                    <!-- Bank Account Info -->
                                    <div class="bank-account-info">
                                        <h5><i class="fas fa-credit-card"></i> Detail Rekening Transfer</h5>
                                        <div class="bank-details">
                                            <div class="bank-logo">
                                                <img src="{{ asset('assets/images/bank-bni.png') }}" alt="Bank BNI"
                                                    style="height: 40px;" onerror="this.style.display='none'">
                                                <span class="bank-name">Bank BNI</span>
                                            </div>
                                            <div class="account-details">
                                                <div class="account-item">
                                                    <label>Nomor Rekening:</label>
                                                    <span class="account-number">1234567890123456</span>
                                                    <button type="button" class="copy-btn"
                                                        onclick="copyToClipboard('1234567890123456')">
                                                        <i class="fas fa-copy"></i> Salin
                                                    </button>
                                                </div>
                                                <div class="account-item">
                                                    <label>Nama Penerima:</label>
                                                    <span>PT Bank Koperasi Eceng Gondok</span>
                                                </div>
                                                <div class="account-item">
                                                    <label>Jumlah Transfer:</label>
                                                    <span class="transfer-amount">{{ formatRupiah($order->total) }}</span>
                                                    <button type="button" class="copy-btn"
                                                        onclick="copyToClipboard('{{ $order->total }}')">
                                                        <i class="fas fa-copy"></i> Salin
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Upload Bukti Pembayaran -->
                                    <div class="payment-proof-upload">
                                        <h5><i class="fas fa-upload"></i> Upload Bukti Pembayaran</h5>
                                        <form action="{{ route('upload.payment.proof') }}" method="POST"
                                            enctype="multipart/form-data" id="payment-proof-form">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">

                                            <div class="upload-area">
                                                <div class="upload-zone"
                                                    onclick="document.getElementById('payment-proof').click()">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                    <p>Klik untuk upload bukti transfer</p>
                                                    <small>Format: JPG, PNG, PDF (Max 2MB)</small>
                                                </div>
                                                <input type="file" id="payment-proof" name="payment_proof"
                                                    accept="image/*,.pdf" style="display: none;">
                                            </div>

                                            <div class="upload-preview" id="upload-preview" style="display: none;">
                                                <img id="preview-image" src="" alt="Preview">
                                                <div class="preview-info">
                                                    <span id="file-name"></span>
                                                    <button type="button" onclick="removeFile()">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn-upload" disabled>
                                                <i class="fas fa-paper-plane"></i> Kirim Bukti Pembayaran
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Instruction -->
                                    <div class="transfer-instructions">
                                        <h5><i class="fas fa-info-circle"></i> Petunjuk Transfer</h5>
                                        <ol>
                                            <li>Transfer sesuai jumlah yang tertera <strong>persis</strong></li>
                                            <li>Simpan bukti transfer dari bank</li>
                                            <li>Upload bukti transfer melalui form di atas</li>
                                            <li>Pesanan akan diproses setelah pembayaran dikonfirmasi</li>
                                            <li>Konfirmasi pembayaran maksimal 1x24 jam</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <style>
                                .bank-transfer-section {
                                    background: #f8f9fa;
                                    border-radius: 8px;
                                    padding: 20px;
                                    margin-top: 20px;
                                }

                                .payment-timer {
                                    background: linear-gradient(135deg, #ff6b6b, #ee5a24);
                                    color: white;
                                    padding: 15px;
                                    border-radius: 8px;
                                    text-align: center;
                                    margin-bottom: 20px;
                                }

                                .countdown-timer {
                                    font-size: 2rem;
                                    font-weight: bold;
                                    margin: 10px 0;
                                }

                                .bank-account-info {
                                    background: white;
                                    padding: 20px;
                                    border-radius: 8px;
                                    margin-bottom: 20px;
                                    border: 1px solid #dee2e6;
                                }

                                .bank-details {
                                    display: flex;
                                    flex-wrap: wrap;
                                    gap: 20px;
                                }

                                .bank-logo {
                                    display: flex;
                                    align-items: center;
                                    gap: 10px;
                                    margin-bottom: 15px;
                                }

                                .account-item {
                                    display: flex;
                                    justify-content: space-between;
                                    align-items: center;
                                    padding: 10px 0;
                                    border-bottom: 1px solid #eee;
                                }

                                .account-item:last-child {
                                    border-bottom: none;
                                }

                                .account-number,
                                .transfer-amount {
                                    font-weight: bold;
                                    color: #2c3e50;
                                }

                                .copy-btn {
                                    background: #3498db;
                                    color: white;
                                    border: none;
                                    padding: 5px 10px;
                                    border-radius: 4px;
                                    cursor: pointer;
                                    font-size: 0.8rem;
                                }

                                .copy-btn:hover {
                                    background: #2980b9;
                                }

                                .payment-proof-upload {
                                    background: white;
                                    padding: 20px;
                                    border-radius: 8px;
                                    margin-bottom: 20px;
                                    border: 1px solid #dee2e6;
                                }

                                .upload-zone {
                                    border: 2px dashed #bdc3c7;
                                    padding: 40px 20px;
                                    text-align: center;
                                    border-radius: 8px;
                                    cursor: pointer;
                                    transition: all 0.3s;
                                }

                                .upload-zone:hover {
                                    border-color: #3498db;
                                    background: #f8f9fa;
                                }

                                .upload-preview {
                                    display: flex;
                                    align-items: center;
                                    gap: 15px;
                                    padding: 15px;
                                    background: #f8f9fa;
                                    border-radius: 8px;
                                    margin: 15px 0;
                                }

                                .upload-preview img {
                                    width: 80px;
                                    height: 80px;
                                    object-fit: cover;
                                    border-radius: 4px;
                                }

                                .btn-upload {
                                    background: #27ae60;
                                    color: white;
                                    border: none;
                                    padding: 12px 30px;
                                    border-radius: 6px;
                                    cursor: pointer;
                                    width: 100%;
                                    margin-top: 15px;
                                }

                                .btn-upload:disabled {
                                    background: #bdc3c7;
                                    cursor: not-allowed;
                                }

                                .btn-upload:not(:disabled):hover {
                                    background: #229954;
                                }

                                .transfer-instructions {
                                    background: white;
                                    padding: 20px;
                                    border-radius: 8px;
                                    border: 1px solid #dee2e6;
                                }

                                .transfer-instructions ol {
                                    margin: 0;
                                    padding-left: 20px;
                                }

                                .transfer-instructions li {
                                    margin-bottom: 8px;
                                    line-height: 1.5;
                                }
                            </style>

                            <script>
                                // Timer countdown
                                function startCountdown() {
                                    const createdAt = new Date('{{ $order->created_at }}');
                                    const deadline = new Date(createdAt.getTime() + (24 * 60 * 60 * 1000)); // 24 jam dari created_at

                                    function updateCountdown() {
                                        const now = new Date();
                                        const timeLeft = deadline - now;

                                        if (timeLeft <= 0) {
                                            document.getElementById('countdown-display').textContent = '00:00:00';
                                            document.querySelector('.payment-timer').style.background = 'linear-gradient(135deg, #e74c3c, #c0392b)';
                                            document.querySelector('.timer-note').textContent = 'Waktu pembayaran telah berakhir';
                                            return;
                                        }

                                        const hours = Math.floor(timeLeft / (1000 * 60 * 60));
                                        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                                        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                                        document.getElementById('countdown-display').textContent =
                                            `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                                    }

                                    updateCountdown();
                                    setInterval(updateCountdown, 1000);
                                }

                                // Copy to clipboard function
                                function copyToClipboard(text) {
                                    navigator.clipboard.writeText(text).then(function() {
                                        // Show success message
                                        const btn = event.target.closest('.copy-btn');
                                        const originalText = btn.innerHTML;
                                        btn.innerHTML = '<i class="fas fa-check"></i> Tersalin!';
                                        btn.style.background = '#27ae60';

                                        setTimeout(() => {
                                            btn.innerHTML = originalText;
                                            btn.style.background = '#3498db';
                                        }, 2000);
                                    });
                                }

                                // File upload handling
                                document.getElementById('payment-proof').addEventListener('change', function(e) {
                                    const file = e.target.files[0];
                                    if (file) {
                                        const preview = document.getElementById('upload-preview');
                                        const previewImage = document.getElementById('preview-image');
                                        const fileName = document.getElementById('file-name');
                                        const uploadBtn = document.querySelector('.btn-upload');

                                        // Show preview for images
                                        if (file.type.startsWith('image/')) {
                                            const reader = new FileReader();
                                            reader.onload = function(e) {
                                                previewImage.src = e.target.result;
                                                previewImage.style.display = 'block';
                                            };
                                            reader.readAsDataURL(file);
                                        } else {
                                            previewImage.style.display = 'none';
                                        }

                                        fileName.textContent = file.name;
                                        preview.style.display = 'flex';
                                        uploadBtn.disabled = false;
                                    }
                                });

                                function removeFile() {
                                    document.getElementById('payment-proof').value = '';
                                    document.getElementById('upload-preview').style.display = 'none';
                                    document.querySelector('.btn-upload').disabled = true;
                                }

                                // Start countdown when page loads
                                document.addEventListener('DOMContentLoaded', function() {
                                    startCountdown();
                                });
                            </script>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>

    @if ($order->transaction && $order->transaction->snap_token && $order->transaction->status === 'pending')
        <!-- Midtrans Script -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
        <script type="text/javascript">
            document.getElementById('pay-button').addEventListener('click', function() {
                snap.pay('{{ $order->transaction->snap_token }}', {
                    onSuccess: function(result) {
                        console.log("Success", result);
                        alert("Pembayaran berhasil!");
                        window.location.href = '{{ url('payment_success') }}';
                    },
                    onPending: function(result) {
                        console.log("Pending", result);
                        alert("Pembayaran sedang diproses.");
                        window.location.href = '{{ url('payment_pending') }}';
                    },
                    onError: function(result) {
                        console.log("Error", result);
                        alert("Terjadi kesalahan saat pembayaran.");
                    },
                    onClose: function() {
                        alert("Anda menutup popup tanpa menyelesaikan pembayaran.");
                    }
                });
            });
        </script>
    @endif

    @push('scripts')
        <!-- JavaScript for Step Navigation -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Pada halaman konfirmasi, set langkah ke-3
                updateCheckoutStep(3);

                // Fungsi ini sama dengan yang ada di halaman pengiriman dan pembayaran
                function updateCheckoutStep(step) {
                    const checkoutSteps = document.querySelector('.checkout-steps');
                    const stepItems = document.querySelectorAll('.checkout-steps__item');

                    // Update progress bar
                    checkoutSteps.className = 'checkout-steps';
                    checkoutSteps.classList.add(`step-${step}`);

                    // Reset all steps
                    stepItems.forEach((item, index) => {
                        item.classList.remove('active', 'completed');

                        // Mark steps as completed or active
                        if (index + 1 < step) {
                            item.classList.add('completed');
                        } else if (index + 1 === step) {
                            item.classList.add('active');
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection

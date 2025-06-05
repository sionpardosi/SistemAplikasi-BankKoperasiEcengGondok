@extends('layouts.app')

@section('content')

    <style>
        .text-success {
            color: #278c04 !important;
        }

        /* Styling untuk informasi stok */
        .product-stock-info {
            display: flex;
            align-items: center;
            margin-top: 8px;
            padding: 6px 10px;
            background-color: rgba(149, 106, 59, 0.05);
            border-radius: 6px;
            border-left: 3px solid #956a3b;
            font-size: 0.9rem;
        }

        .product-stock-info i {
            color: #956a3b;
            margin-right: 6px;
            font-size: 14px;
        }

        .stock-text {
            color: #666;
            font-weight: 500;
        }

        .stock-number {
            font-weight: 700;
            margin-left: 4px;
        }

        .stock-available {
            color: #4CAF50;
        }

        .stock-low {
            color: #FF9800;
        }

        .stock-empty {
            color: #f44336;
        }

        /* Badge untuk ukuran dan stok yang konsisten */
        .product-size-badge,
        .product-stock-info {
            font-size: 0.85rem;
            margin-top: 6px;
        }

        .product-size-badge {
            display: inline-block;
            padding: 4px 8px;
            background-color: rgba(149, 106, 59, 0.1);
            border-radius: 4px;
            color: #956a3b;
            font-weight: 500;
        }

        /* Responsive untuk mobile */
        @media (max-width: 768px) {
            .product-stock-info {
                font-size: 0.8rem;
                padding: 4px 8px;
            }

            .product-size-badge {
                font-size: 0.8rem;
                padding: 3px 6px;
            }
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-top: 60px !important;
        }

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

        /* Checkbox styling */
        .cart-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .select-all-container {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 8px 16px;
            background-color: #fcf9f5;
            border-radius: 8px;
            border: 1px solid rgba(149, 106, 59, 0.15);
        }

        .select-all-container label {
            margin-left: 8px;
            font-weight: 500;
            color: var(--text-medium);
            cursor: pointer;
        }

        /* Checkout Steps - Modern Design */
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

        /* Hover Effects */
        .checkout-steps__item:not(.active):hover .checkout-steps__item-title span {
            color: var(--primary-dark);
        }

        .checkout-steps__item:not(.active):hover .checkout-steps__item-number {
            transform: translateY(-3px);
            border-color: #d9ccbc;
            box-shadow: 0 6px 15px rgba(149, 106, 59, 0.15);
        }

        /* Dimmed items - when not selected */
        tr.cart-item-row.dimmed {
            opacity: 0.5;
            transition: opacity 0.3s ease;
        }

        /* Checkbox label */
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
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
        }

        @media (max-width: 768px) {
            .checkout-steps {
                flex-direction: column;
                gap: 20px;
            }

            .checkout-steps:before,
            .checkout-steps:after {
                display: none;
            }

            .checkout-steps__item {
                flex-direction: row;
                justify-content: flex-start;
                width: 100%;
                padding: 12px;
                border-radius: var(--border-radius);
                background-color: var(--white);
                box-shadow: var(--shadow-soft);
                gap: 15px;
            }

            .checkout-steps__item-number {
                width: 45px;
                height: 45px;
                font-size: 16px;
                margin-bottom: 0;
            }

            .checkout-steps__item-title {
                text-align: left;
            }

            .checkout-steps__item-title em {
                margin: 0;
            }

            .checkout-steps__item.active {
                background-color: var(--primary-light);
            }

            .checkout-steps__item:not(.active):hover {
                background-color: var(--primary-lighter);
            }
        }

        @media (max-width: 480px) {
            .checkout-steps__item-title em {
                display: none;
            }
        }

        /* Elegant Empty Cart Design */
        .empty-cart-elegant {
            max-width: 500px;
            margin: 80px auto;
            padding: 0 20px;
        }

        .empty-cart-content {
            background: #ffffff;
            padding: 60px 40px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 4px 25px rgba(149, 106, 59, 0.08);
            border: 1px solid rgba(149, 106, 59, 0.06);
            position: relative;
            overflow: hidden;
        }

        .empty-cart-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), rgba(149, 106, 59, 0.3));
        }

        .empty-cart-icon-wrapper {
            margin-bottom: 32px;
        }

        .empty-cart-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto;
            background: linear-gradient(135deg, rgba(149, 106, 59, 0.06), rgba(149, 106, 59, 0.12));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.3s ease;
        }

        .empty-cart-icon::after {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            border-radius: 50%;
            background: linear-gradient(135deg, transparent, rgba(149, 106, 59, 0.1));
            z-index: -1;
        }

        .empty-cart-icon i {
            font-size: 40px;
            color: var(--primary);
            opacity: 0.8;
        }

        .empty-cart-title {
            font-size: 26px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 16px;
            letter-spacing: 0.3px;
        }

        .empty-cart-message {
            font-size: 16px;
            color: var(--text-medium);
            line-height: 1.6;
            margin-bottom: 36px;
            max-width: 380px;
            margin-left: auto;
            margin-right: auto;
        }

        .empty-cart-actions {
            margin-bottom: 28px;
        }

        .btn-elegant-shop {
            background: linear-gradient(135deg, var(--primary), #a87c4f);
            color: #ffffff;
            padding: 16px 32px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 12px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.3px;
            box-shadow: 0 8px 20px rgba(149, 106, 59, 0.2);
        }

        .btn-elegant-shop::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-elegant-shop:hover {
            background: linear-gradient(135deg, #886133, #b68655);
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(149, 106, 59, 0.3);
            color: #ffffff;
            text-decoration: none;
        }

        .btn-elegant-shop:hover::before {
            left: 100%;
        }

        .btn-elegant-shop:active {
            transform: translateY(0);
        }

        .simple-benefits {
            display: flex;
            justify-content: center;
            gap: 24px;
            flex-wrap: wrap;
            padding-top: 20px;
            border-top: 1px solid rgba(149, 106, 59, 0.08);
        }

        .simple-benefits span {
            font-size: 14px;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
        }

        .simple-benefits i {
            color: var(--primary);
            font-size: 12px;
            opacity: 0.8;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .empty-cart-elegant {
                margin: 60px auto;
            }

            .empty-cart-content {
                padding: 50px 30px;
                border-radius: 12px;
            }

            .empty-cart-icon {
                width: 90px;
                height: 90px;
            }

            .empty-cart-icon i {
                font-size: 36px;
            }

            .empty-cart-title {
                font-size: 24px;
                margin-bottom: 14px;
            }

            .empty-cart-message {
                font-size: 15px;
                margin-bottom: 32px;
            }

            .simple-benefits {
                flex-direction: column;
                gap: 12px;
                align-items: center;
            }
        }

        @media (max-width: 480px) {
            .empty-cart-content {
                padding: 40px 24px;
                margin: 0 16px;
            }

            .btn-elegant-shop {
                width: 100%;
                padding: 18px 32px;
            }

            .empty-cart-title {
                font-size: 22px;
            }
        }

        /* Badge styling for product size */
        .product-size-badge {
            display: inline-block;
            padding: 2px 8px;
            background-color: rgba(149, 106, 59, 0.1);
            border-radius: 4px;
            color: #956a3b;
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 6px;
        }

        /* Notifikasi untuk cart */
        .cart-notification {
            position: fixed;
            top: 120px;
            right: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
            display: none;
            align-items: center;
            z-index: 1000;
            max-width: 400px;
            min-width: 300px;
            transition: all 0.3s ease;
            border-left: 4px solid #956a3b;
        }

        .cart-notification.success {
            border-left-color: #4CAF50;
        }

        .cart-notification.error {
            border-left-color: #f44336;
        }

        .cart-notification.show {
            display: flex !important;
            opacity: 1;
            transform: translateY(0);
        }

        .cart-notification__icon {
            margin-right: 15px;
            width: 30px;
            height: 30px;
            background: #f0f0f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-notification.success .cart-notification__icon {
            background: #e8f5e8;
            color: #4CAF50;
        }

        .cart-notification.error .cart-notification__icon {
            background: #fdeaea;
            color: #f44336;
        }

        .cart-notification__content {
            flex: 1;
        }

        .cart-notification__title {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 3px;
            color: #333;
        }

        .cart-notification__message {
            font-size: 13px;
            color: #666;
            line-height: 1.4;
        }

        .cart-notification__close {
            background: transparent;
            border: none;
            color: #aaa;
            cursor: pointer;
            padding: 5px;
            margin-left: 10px;
            font-size: 16px;
            transition: color 0.2s;
        }

        .cart-notification__close:hover {
            color: #333;
        }

        /* Style untuk form yang disabled */
        .qty-control form {
            pointer-events: none;
        }

        .qty-control__increase:hover,
        .qty-control__reduce:hover {
            background-color: #e9ecef;
            cursor: pointer;
        }

        /* Responsive untuk mobile */
        @media (max-width: 768px) {
            .cart-notification {
                top: 60px;
                right: 10px;
                left: 10px;
                max-width: none;
                min-width: auto;
            }
        }

        /* Styling untuk informasi ongkos kirim */
        .shipping-cost {
            color: #555;
        }

        .shipping-info {
            display: flex;
            align-items: center;
            background-color: rgba(149, 106, 59, 0.05);
            padding: 6px 10px;
            border-radius: 6px;
            border-left: 3px solid #956a3b;
        }

        .shipping-info i {
            margin-right: 8px;
            font-size: 14px;
            color: #956a3b;
        }

        .shipping-info span {
            font-size: 14px;
            color: #666;
        }
    </style>

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title mb-4" style="letter-spacing:1px; margin-bottom: 3.5rem !important;">Keranjang</h2>
            <!-- Modern Checkout Steps -->
            <div class="checkout-steps step-1">
                <a href="javascript:void(0);" class="checkout-steps__item active">
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
                <a href="javascript:void(0);" class="checkout-steps__item">
                    <div class="checkout-steps__item-number">
                        <span>02</span>
                        <div class="checkout-steps__item-icon">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <div class="checkout-steps__item-title">
                        <span>Pengiriman dan Metode Pembayaran</span>
                        <em>Pilih Alamat dan Metode</em>
                    </div>
                </a>
                <a href="javascript:void(0);" class="checkout-steps__item">
                    <div class="checkout-steps__item-number">
                        <span>03</span>
                        <div class="checkout-steps__item-icon">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <div class="checkout-steps__item-title">
                        <span>Konfirmasi</span>
                        <em>Tinjau dan Pembayaran</em>
                    </div>
                </a>
            </div>
            <div class="shopping-cart">
                @if ($cartItems->count() > 0)
                    <div class="cart-table__wrapper">
                        <div class="select-all-container mb-3">
                            <input type="checkbox" id="select-all" class="cart-checkbox" checked>
                            <label for="select-all">Pilih Semua Produk</label>
                        </div>

                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th style="width: 5%"></th>
                                    <th style="width: 15%">Produk</th>
                                    <th style="width: 25%"></th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Sub Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $cartItem)
                                    <tr class="cart-item-row" data-row-id="{{ $cartItem->rowId }}"
                                        data-price="{{ $cartItem->price }}" data-qty="{{ $cartItem->qty }}">
                                        <td>
                                            <input type="checkbox" class="cart-checkbox item-checkbox"
                                                name="selected_items[]" value="{{ $cartItem->rowId }}" checked
                                                data-price="{{ $cartItem->price }}" data-qty="{{ $cartItem->qty }}"
                                                data-subtotal="{{ $cartItem->subtotal(0, '', '') }}">
                                        </td>
                                        <td>
                                            <div class="shopping-cart__product-item">
                                                <img loading="lazy"
                                                    src="{{ asset('uploads/products/thumbnails') }}/{{ $cartItem->model->image }}"
                                                    width="120" height="120" alt="{{ $cartItem->name }}" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="shopping-cart__product-item__detail">
                                                <h4>{{ $cartItem->name }}</h4>
                                                @if (isset($cartItem->options['size_name']))
                                                    <div class="product-size-badge">
                                                        <i class="fas fa-ruler-combined me-1"></i>
                                                        Ukuran: {{ $cartItem->options['size_name'] }}
                                                    </div>
                                                @endif

                                                {{-- Menampilkan stok tersedia --}}
                                                {{-- @php
                                                    // Hitung stok tersedia
                                                    $product =
                                                        $cartItem->model ?? \App\Models\Product::find($cartItem->id);
                                                    if ($product) {
                                                        if (isset($cartItem->options['size_id'])) {
                                                            // Untuk produk dengan ukuran
                                                            $sizeStock = DB::table('product_sizes')
                                                                ->where('product_id', $product->id)
                                                                ->where('size_id', $cartItem->options['size_id'])
                                                                ->first();
                                                            $availableStock = $sizeStock ? $sizeStock->stock : 0;
                                                        } else {
                                                            // Untuk produk tanpa ukuran
                                                            $availableStock =
                                                                $product->quantity - $product->reserved_quantity;
                                                        }
                                                    } else {
                                                        $availableStock = 0;
                                                    }
                                                @endphp --}}

                                                {{-- <div class="product-stock-info">
                                                    <i class="fas fa-box-open me-1"></i>
                                                    <span class="stock-text">Stok tersedia: </span>
                                                    <span
                                                        class="stock-number {{ $availableStock <= 5 ? ($availableStock == 0 ? 'stock-empty' : 'stock-low') : 'stock-available' }}">
                                                        {{ $availableStock }}
                                                    </span>
                                                    @if ($availableStock <= 5 && $availableStock > 0)
                                                        <small class="text-warning ms-1">(Terbatas!)</small>
                                                    @elseif ($availableStock == 0)
                                                        <small class="text-danger ms-1">(Habis)</small>
                                                    @endif
                                                </div> --}}
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="shopping-cart__product-price">{{ formatRupiah($cartItem->price) }}</span>
                                        </td>
                                        <td>
                                            <div class="qty-control position-relative">
                                                <input type="number" name="quantity" value="{{ $cartItem->qty }}"
                                                    min="1" class="qty-control__number text-center qty-input"
                                                    data-row-id="{{ $cartItem->rowId }}">
                                                <form method="POST"
                                                    action="{{ route('cart.reduce.qty', ['rowId' => $cartItem->rowId]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="qty-control__reduce">-</div>
                                                </form>
                                                <form method="POST"
                                                    action="{{ route('cart.increase.qty', ['rowId' => $cartItem->rowId]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="qty-control__increase">+</div>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="shopping-cart__subtotal">
                                                {{ formatRupiah($cartItem->subtotal(0, '', '')) }}
                                            </span>
                                        </td>
                                        <td>
                                            <form method="POST"
                                                action="{{ route('cart.remove', ['rowId' => $cartItem->rowId]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:void(0)" class="remove-cart">
                                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                        <path
                                                            d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                    </svg>
                                                </a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="cart-table-footer">
                            @if (!Session::has('coupon'))
                                <form class="position-relative bg-body" method="POST"
                                    action="{{ route('cart.coupon.apply') }}">
                                    @csrf
                                    <input class="form-control" type="text" name="coupon_code"
                                        placeholder="Masukkan Kupon Diskon">
                                    <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4"
                                        type="submit"
                                        style="background-color: #956a3b; border-color: #956a3b; color: #ffffff;"
                                        value="TERAPKAN KUPON">
                                </form>
                            @else
                                <form class="position-relative bg-body" method="POST"
                                    action="{{ route('cart.coupon.remove') }}">
                                    @csrf
                                    @method('DELETE')
                                    <input class="form-control text-success fw-bold" type="text" name="coupon_code"
                                        placeholder="Kupon Diskon"
                                        value="{{ session()->get('coupon')['code'] }} diterapkan!" readonly>
                                    <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4 text-danger"
                                        type="submit" value="HAPUS KUPON">
                                </form>
                            @endif
                            <form class="position-relative bg-body" method="POST" action="{{ route('cart.empty') }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-light" type="submit">KOSONGKAN KERANJANG</button>
                            </form>
                        </div>

                        <div>
                            @if (Session::has('success'))
                                <p class="text-success">{{ Session::get('success') }}</p>
                            @elseif(Session::has('error'))
                                <p class="text-danger">{{ Session::get('error') }}</p>
                            @endif
                        </div>

                    </div>
                    <div class="shopping-cart__totals-wrapper">
                        <div class="sticky-content">
                            <div class="shopping-cart__totals">
                                <h3>Detail Pembayaran</h3>

                                <table class="cart-totals">
                                    <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td id="cart-subtotal">
                                                {{ formatRupiah(\Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->subtotal(0, '', '')) }}
                                            </td>
                                        </tr>
                                        @if (Session::has('discounts'))
                                            <tr>
                                                <th>Diskon {{ Session('coupon')['code'] }}</th>
                                                <td id="cart-discount">
                                                    -{{ formatRupiah((float) Session('discounts')['discount']) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Subtotal Setelah Diskon</th>
                                                <td id="cart-subtotal-after-discount">
                                                    {{ formatRupiah((float) Session('discounts')['subtotal']) }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th>Ongkos Kirim</th>
                                            <td class="shipping-cost">
                                                <div class="shipping-info">
                                                    <span>Dihitung saat checkout</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="cart-total">
                                            <th>Total</th>
                                            <td id="cart-total">
                                                @if (Session::has('discounts'))
                                                    {{ formatRupiah((float) Session('discounts')['subtotal']) }}
                                                @else
                                                    {{ formatRupiah(\Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->subtotal(0, '', '')) }}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mobile_fixed-btn_wrapper">
                                <div class="button-wrapper container">
                                    <form id="checkout-form" action="{{ route('cart.checkout') }}" method="GET">
                                        <input type="hidden" name="selected_items" id="selected-items-input">
                                        <button type="submit" class="btn btn-primary btn-checkout text-white w-100"
                                            id="checkout-btn"
                                            style="background-color: #956a3b; border-color: #956a3b; color: #ffffff;">
                                            LANJUTKAN KE PEMBAYARAN
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Simple Empty Cart Design -->
                    <div class="empty-cart-elegant">
                        <div class="empty-cart-content">
                            <div class="empty-cart-icon-wrapper">
                                <div class="empty-cart-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>

                            <h3 class="empty-cart-title">Keranjang Belanja Kosong</h3>

                            <p class="empty-cart-message">
                                Temukan berbagai produk berkualitas dari Eceng Gondok untuk memulai berbelanja
                            </p>

                            <div class="empty-cart-actions">
                                <a href="{{ route('shop.index') }}" class="btn-elegant-shop">
                                    Mulai Berbelanja
                                </a>
                            </div>

                            <!-- Optional: Simple benefits (pilih salah satu) -->
                            <div class="simple-benefits">
                                <span><i class="fas fa-leaf"></i> Ramah Lingkungan</span>
                                <span><i class="fas fa-truck"></i> Pengiriman Cepat</span>
                                <span><i class="fas fa-shield-alt"></i> Berkualitas</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>

    @push('scripts')
        <script>
            $(function() {
                // Update cart totals when checkboxes or quantities change
                function updateCartTotals() {
                    let subtotal = 0;
                    let selectedItems = [];

                    // Calculate totals based on selected items
                    $('.item-checkbox:checked').each(function() {
                        const rowId = $(this).val();
                        const price = parseFloat($(this).data('price'));
                        const qty = parseInt($(this).closest('tr').find('.qty-input').val());
                        const itemSubtotal = price * qty;

                        subtotal += itemSubtotal;
                        selectedItems.push(rowId);
                    });

                    // Update the hidden input with selected items
                    $('#selected-items-input').val(JSON.stringify(selectedItems));

                    // Format the number to currency
                    const formattedSubtotal = formatRupiah(subtotal);
                    $('#cart-subtotal').text(formattedSubtotal);

                    // If there's a coupon, recalculate discount
                    @if (Session::has('discounts'))
                        const discount = calculateDiscount(subtotal);
                        const subtotalAfterDiscount = subtotal - discount;

                        $('#cart-discount').text('-' + formatRupiah(discount));
                        $('#cart-subtotal-after-discount').text(formatRupiah(subtotalAfterDiscount));
                        $('#cart-total').text(formatRupiah(subtotalAfterDiscount));
                    @else
                        $('#cart-total').text(formattedSubtotal);
                    @endif

                    // Apply visual dimming to unselected items
                    $('.cart-item-row').each(function() {
                        const isChecked = $(this).find('.item-checkbox').is(':checked');
                        $(this).toggleClass('dimmed', !isChecked);
                    });

                    // Disable checkout button if no items selected
                    if (selectedItems.length === 0) {
                        $('#checkout-btn').prop('disabled', true).css('opacity', '0.5');
                    } else {
                        $('#checkout-btn').prop('disabled', false).css('opacity', '1');
                    }
                }

                // Calculate discount based on coupon type
                function calculateDiscount(subtotal) {
                    @if (Session::has('coupon'))
                        const couponType = "{{ Session::get('coupon')['type'] }}";
                        const couponValue = parseFloat("{{ Session::get('coupon')['value'] }}");

                        if (couponType === 'fixed') {
                            return couponValue;
                        } else {
                            return (subtotal * couponValue) / 100;
                        }
                    @else
                        return 0;
                    @endif
                }

                // Format number to Rupiah
                function formatRupiah(number) {
                    return 'Rp' + number.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                }

                // Select/deselect all items
                $('#select-all').on('change', function() {
                    const isChecked = $(this).is(':checked');
                    $('.item-checkbox').prop('checked', isChecked);
                    updateCartTotals();
                });

                // Individual item selection
                $('.item-checkbox').on('change', function() {
                    // Update "select all" checkbox based on individual selections
                    if ($('.item-checkbox:checked').length === $('.item-checkbox').length) {
                        $('#select-all').prop('checked', true);
                    } else {
                        $('#select-all').prop('checked', false);
                    }

                    updateCartTotals();
                });

                // Update totals when quantity changes
                $('.qty-input').on('change', function() {
                    const rowId = $(this).data('row-id');
                    const newQty = $(this).val();

                    // Update the cart via AJAX
                    $.ajax({
                        url: '{{ url('/cart/update-qty') }}/' + rowId,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'PUT',
                            quantity: newQty
                        },
                        success: function(response) {
                            // Update subtotal display for this item
                            const price = parseFloat($(`tr[data-row-id="${rowId}"]`).data('price'));
                            const newSubtotal = price * newQty;
                            $(`tr[data-row-id="${rowId}"] .shopping-cart__subtotal`).text(
                                formatRupiah(newSubtotal));

                            // Update checkbox data attribute
                            $(`input[value="${rowId}"]`).data('qty', newQty);
                            $(`input[value="${rowId}"]`).data('subtotal', newSubtotal);

                            updateCartTotals();
                        }
                    });
                });

                // Handle quantity buttons
                $(".qty-control__increase").on("click", function() {
                    const input = $(this).closest('td').find('.qty-input');
                    input.val(parseInt(input.val()) + 1).trigger('change');

                    // Don't submit the form as we're handling it via AJAX
                    return false;
                });

                $(".qty-control__reduce").on("click", function() {
                    const input = $(this).closest('td').find('.qty-input');
                    const newVal = Math.max(1, parseInt(input.val()) - 1);
                    input.val(newVal).trigger('change');

                    // Don't submit the form as we're handling it via AJAX
                    return false;
                });

                // Handle remove item
                $('.remove-cart').on("click", function() {
                    $(this).closest('form').submit();
                });

                // Initialize totals on page load
                updateCartTotals();

                // Form submit handler for checkout
                $('#checkout-form').on('submit', function(e) {
                    const selectedItems = $('.item-checkbox:checked').length;
                    if (selectedItems === 0) {
                        e.preventDefault();
                        alert('Silakan pilih setidaknya satu produk untuk checkout');
                    }
                });
            });
        </script>

        <!-- JavaScript for Step Navigation -->
        <script>
            // This script should be added at the bottom of your view or in the scripts section
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

            // Call this function on page load with the current step
            document.addEventListener('DOMContentLoaded', function() {
                // Detect current page and set appropriate step
                // For example:
                // const currentPage = "{{ Route::currentRouteName() }}";
                // if (currentPage === 'cart.index') updateCheckoutStep(1);
                // if (currentPage === 'cart.checkout') updateCheckoutStep(2);
                // if (currentPage === 'cart.confirmation') updateCheckoutStep(3);

                // For this demo, we'll just set step 1
                updateCheckoutStep(1);
            });
        </script>

        <script>
            $(function() {
                // Function to show notification
                function showCartNotification(message, isSuccess = true) {
                    // Cek apakah notifikasi sudah ada, jika belum tambahkan ke body
                    if (!$('#cart-notification-simple').length) {
                        $('body').append(`
                    <div class="cart-notification" id="cart-notification-simple" style="display: none;">
                        <div class="cart-notification__icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="cart-notification__content">
                            <div class="cart-notification__title" id="cart-notification-title-simple">Notifikasi</div>
                            <div class="cart-notification__message" id="cart-notification-message-simple"></div>
                        </div>
                        <button class="cart-notification__close" id="close-cart-notification-simple">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `);

                        // Event handler untuk tombol close
                        $(document).on('click', '#close-cart-notification-simple', function() {
                            $('#cart-notification-simple').removeClass('show');
                            setTimeout(() => $('#cart-notification-simple').css('display', 'none'), 300);
                        });
                    }

                    const notification = $('#cart-notification-simple');
                    const title = $('#cart-notification-title-simple');
                    const messageEl = $('#cart-notification-message-simple');

                    // Set content
                    messageEl.text(message);

                    // Set type (success or error)
                    if (isSuccess) {
                        notification.removeClass('error').addClass('success');
                        title.text('Berhasil');
                        $('.cart-notification__icon i').removeClass('fa-exclamation-circle').addClass(
                            'fa-check-circle');
                    } else {
                        notification.removeClass('success').addClass('error');
                        title.text('Error');
                        $('.cart-notification__icon i').removeClass('fa-check-circle').addClass(
                            'fa-exclamation-circle');
                    }

                    // Show notification
                    notification.css('display', 'flex').addClass('show');

                    // Auto hide after 4 seconds
                    setTimeout(() => {
                        notification.removeClass('show');
                        setTimeout(() => notification.css('display', 'none'), 300);
                    }, 4000);
                }

                // Update cart totals when checkboxes or quantities change
                function updateCartTotals() {
                    let subtotal = 0;
                    let selectedItems = [];

                    // Calculate totals based on selected items
                    $('.item-checkbox:checked').each(function() {
                        const rowId = $(this).val();
                        const price = parseFloat($(this).data('price'));
                        const qty = parseInt($(this).closest('tr').find('.qty-input').val());
                        const itemSubtotal = price * qty;

                        subtotal += itemSubtotal;
                        selectedItems.push(rowId);
                    });

                    // Update the hidden input with selected items
                    $('#selected-items-input').val(JSON.stringify(selectedItems));

                    // Format the number to currency
                    const formattedSubtotal = formatRupiah(subtotal);
                    $('#cart-subtotal').text(formattedSubtotal);

                    // If there's a coupon, recalculate discount
                    @if (Session::has('discounts'))
                        const discount = calculateDiscount(subtotal);
                        const subtotalAfterDiscount = subtotal - discount;

                        $('#cart-discount').text('-' + formatRupiah(discount));
                        $('#cart-subtotal-after-discount').text(formatRupiah(subtotalAfterDiscount));
                        $('#cart-total').text(formatRupiah(subtotalAfterDiscount));
                    @else
                        $('#cart-total').text(formattedSubtotal);
                    @endif

                    // Apply visual dimming to unselected items
                    $('.cart-item-row').each(function() {
                        const isChecked = $(this).find('.item-checkbox').is(':checked');
                        $(this).toggleClass('dimmed', !isChecked);
                    });

                    // Disable checkout button if no items selected
                    if (selectedItems.length === 0) {
                        $('#checkout-btn').prop('disabled', true).css('opacity', '0.5');
                    } else {
                        $('#checkout-btn').prop('disabled', false).css('opacity', '1');
                    }
                }

                // Calculate discount based on coupon
                function calculateDiscount(subtotal) {
                    @if (Session::has('coupon'))
                        const discountAmount = parseFloat("{{ Session::get('coupon')['discount_amount'] }}");
                        // Pastikan diskon tidak melebihi subtotal
                        return Math.min(discountAmount, subtotal);
                    @else
                        return 0;
                    @endif
                }

                // Format number to Rupiah
                function formatRupiah(number) {
                    return 'Rp' + number.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                }

                // Select/deselect all items
                $('#select-all').on('change', function() {
                    const isChecked = $(this).is(':checked');
                    $('.item-checkbox').prop('checked', isChecked);
                    updateCartTotals();
                });

                // Individual item selection
                $('.item-checkbox').on('change', function() {
                    // Update "select all" checkbox based on individual selections
                    if ($('.item-checkbox:checked').length === $('.item-checkbox').length) {
                        $('#select-all').prop('checked', true);
                    } else {
                        $('#select-all').prop('checked', false);
                    }

                    updateCartTotals();
                });

                // PERBAIKAN: Update totals when quantity changes dengan validasi stok
                $('.qty-input').on('change', function() {
                    const rowId = $(this).data('row-id');
                    const newQty = parseInt($(this).val());
                    const $this = $(this);

                    // Validasi minimum quantity
                    if (newQty < 1) {
                        $(this).val(1);
                        return;
                    }

                    // Update the cart via AJAX dengan validasi stok
                    $.ajax({
                        url: '{{ url('/cart/update-qty') }}/' + rowId,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'PUT',
                            quantity: newQty
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update subtotal display for this item
                                const price = parseFloat($(`tr[data-row-id="${rowId}"]`).data(
                                    'price'));
                                const newSubtotal = price * newQty;
                                $(`tr[data-row-id="${rowId}"] .shopping-cart__subtotal`).text(
                                    formatRupiah(newSubtotal));

                                // Update checkbox data attribute
                                $(`input[value="${rowId}"]`).data('qty', newQty);
                                $(`input[value="${rowId}"]`).data('subtotal', newSubtotal);

                                updateCartTotals();
                            } else {
                                // Jika gagal, kembalikan ke nilai sebelumnya dan tampilkan error
                                showCartNotification(response.message, false);

                                // Jika ada max_quantity dari response, set ke nilai maksimum
                                if (response.max_quantity) {
                                    $this.val(response.max_quantity);
                                    $this.trigger(
                                        'change'); // Trigger change dengan nilai yang benar
                                } else {
                                    // Kembalikan ke nilai sebelumnya
                                    const previousQty = $this.data('previous-qty') || 1;
                                    $this.val(previousQty);
                                }
                            }
                        },
                        error: function(xhr) {
                            let errorMsg = 'Gagal mengupdate kuantitas';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            showCartNotification(errorMsg, false);

                            // Kembalikan ke nilai sebelumnya
                            const previousQty = $this.data('previous-qty') || 1;
                            $this.val(previousQty);
                        }
                    });
                });

                // PERBAIKAN: Handle quantity buttons dengan mencegah form submit dan validasi stok
                $(".qty-control__increase").off('click').on("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const $input = $(this).closest('td').find('.qty-input');
                    const currentQty = parseInt($input.val());
                    const newQty = currentQty + 1;

                    // Simpan nilai sebelumnya untuk rollback jika gagal
                    $input.data('previous-qty', currentQty);

                    // Update input value dan trigger change untuk validasi
                    $input.val(newQty).trigger('change');

                    return false; // Prevent form submission
                });

                $(".qty-control__reduce").off('click').on("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const $input = $(this).closest('td').find('.qty-input');
                    const currentQty = parseInt($input.val());
                    const newQty = Math.max(1, currentQty - 1);

                    // Simpan nilai sebelumnya untuk rollback jika gagal
                    $input.data('previous-qty', currentQty);

                    // Update input value dan trigger change untuk validasi
                    $input.val(newQty).trigger('change');

                    return false; // Prevent form submission
                });

                // TAMBAHAN: Prevent form submission untuk quantity forms
                $('.qty-control form').on('submit', function(e) {
                    e.preventDefault();
                    return false;
                });

                // Handle remove item
                $('.remove-cart').on("click", function() {
                    $(this).closest('form').submit();
                });

                // Initialize totals on page load
                updateCartTotals();

                // Form submit handler for checkout
                $('#checkout-form').on('submit', function(e) {
                    const selectedItems = $('.item-checkbox:checked').length;
                    if (selectedItems === 0) {
                        e.preventDefault();
                        alert('Silakan pilih setidaknya satu produk untuk checkout');
                    }
                });

                // TAMBAHAN: Simpan nilai awal quantity untuk rollback
                $('.qty-input').each(function() {
                    $(this).data('previous-qty', parseInt($(this).val()));
                });
            });
        </script>
    @endpush
@endsection

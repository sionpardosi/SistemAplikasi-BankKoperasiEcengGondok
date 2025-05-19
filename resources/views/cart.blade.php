@extends('layouts.app')

@section('content')

    <style>
        .text-success {
            color: #278c04 !important;
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

        .empty-cart-container {
            padding: 40px 30px;
            text-align: center;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(149, 106, 59, 0.12);
            max-width: 650px;
            margin: 0 auto;
            transition: all 0.3s ease;
            border: 1px solid rgba(149, 106, 59, 0.08);
            position: relative;
            overflow: hidden;
            margin-top: 4%;
        }

        /* Top and Bottom Decorations */
        .cart-decoration-top,
        .cart-decoration-bottom {
            display: flex;
            justify-content: space-between;
            position: absolute;
            left: 0;
            width: 100%;
            padding: 0 15px;
        }

        .cart-decoration-top {
            top: 0;
        }

        .cart-decoration-bottom {
            bottom: 0;
        }

        .cart-decoration-top span,
        .cart-decoration-bottom span {
            height: 4px;
            background: linear-gradient(90deg, #956a3b, rgba(149, 106, 59, 0.3));
            display: block;
            border-radius: 0 0 4px 4px;
        }

        .cart-decoration-top span {
            border-radius: 0 0 6px 6px;
        }

        .cart-decoration-bottom span {
            border-radius: 6px 6px 0 0;
        }

        .cart-decoration-top span:nth-child(1),
        .cart-decoration-bottom span:nth-child(1) {
            width: 20%;
        }

        .cart-decoration-top span:nth-child(2),
        .cart-decoration-bottom span:nth-child(2) {
            width: 12%;
        }

        .cart-decoration-top span:nth-child(3),
        .cart-decoration-bottom span:nth-child(3) {
            width: 30%;
        }

        /* Main Illustration */
        .empty-cart-illustration {
            margin-bottom: 25px;
            position: relative;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-circle-pulse {
            position: absolute;
            width: 150px;
            height: 150px;
            background: linear-gradient(145deg, rgba(149, 106, 59, 0.08), rgba(149, 106, 59, 0.15));
            border-radius: 50%;
            z-index: 0;
            animation: pulse 3s infinite;
        }

        .cart-circle-inner {
            position: absolute;
            width: 130px;
            height: 130px;
            background-color: rgba(149, 106, 59, 0.06);
            border-radius: 50%;
            z-index: 0;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(149, 106, 59, 0.2);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 20px rgba(149, 106, 59, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(149, 106, 59, 0);
            }
        }

        .empty-cart-illustration i {
            font-size: 70px;
            color: #956a3b;
            position: relative;
            z-index: 2;
            transform: translateY(5px);
            opacity: 0.9;
            text-shadow: 0 4px 12px rgba(149, 106, 59, 0.3);
        }

        /* Floating Items */
        .floating-item {
            position: absolute;
            width: 40px;
            height: 40px;
            background-color: #fff;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3;
        }

        .floating-item i {
            font-size: 18px;
            color: #956a3b;
            text-shadow: none;
            opacity: 1;
            transform: none;
        }

        .item-1 {
            top: 30px;
            right: 28%;
            animation: float-1 6s infinite ease-in-out;
        }

        .item-2 {
            bottom: 40px;
            right: 32%;
            animation: float-2 7s infinite ease-in-out;
        }

        .item-3 {
            top: 50%;
            left: 25%;
            animation: float-3 5s infinite ease-in-out;
        }

        @keyframes float-1 {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-15px) rotate(5deg);
            }
        }

        @keyframes float-2 {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(15px) rotate(-5deg);
            }
        }

        @keyframes float-3 {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-10px) rotate(-3deg);
            }
        }

        /* Text Elements */
        .empty-cart-title {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }

        .empty-cart-message {
            font-size: 16px;
            color: #666;
            max-width: 450px;
            margin: 0 auto 20px;
            line-height: 1.5;
        }

        /* Benefits Section */
        .cart-benefits {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-bottom: 20px;
        }

        .benefit-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .benefit-icon {
            width: 40px;
            height: 40px;
            background-color: rgba(149, 106, 59, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2px;
            transition: all 0.3s ease;
        }

        .benefit-icon i {
            font-size: 18px;
            color: #956a3b;
        }

        .benefit-item span {
            font-size: 14px;
            color: #555;
            font-weight: 500;
        }

        .benefit-item:hover .benefit-icon {
            background-color: rgba(149, 106, 59, 0.2);
            transform: translateY(-3px);
        }

        /* Call to Action */
        .empty-cart-actions {
            margin-top: 12px;
            margin-bottom: 20px;
        }

        .btn-shop-now {
            background: linear-gradient(to right, #956a3b, #a87c4f);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 12px 34px;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(149, 106, 59, 0.25);
        }

        .btn-shop-now:hover {
            background: linear-gradient(to right, #886133, #b68655);
            box-shadow: 0 12px 25px rgba(149, 106, 59, 0.35);
            transform: translateY(-3px);
            color: #ffffff;
        }

        .btn-shop-now:active {
            transform: translateY(-1px);
        }

        .btn-shop-now i {
            margin-right: 10px;
            font-size: 18px;
            vertical-align: middle;
        }

        /* Suggestion Link */
        .empty-cart-suggestion {
            margin-top: 15px;
            font-size: 14px;
            color: #777;
        }

        .suggestion-link {
            color: #956a3b;
            font-weight: 600;
            text-decoration: none;
            position: relative;
            transition: all 0.3s ease;
        }

        .suggestion-link:after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: #956a3b;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .suggestion-link:hover {
            color: #7d593a;
        }

        .suggestion-link:hover:after {
            transform: scaleX(1);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .empty-cart-container {
                padding: 50px 25px;
                border-radius: 16px;
            }

            .cart-benefits {
                gap: 15px;
            }

            .benefit-icon {
                width: 45px;
                height: 45px;
            }

            .benefit-icon i {
                font-size: 20px;
            }
        }

        @media (max-width: 576px) {
            .empty-cart-container {
                padding: 30px 20px;
                border-radius: 14px;
            }

            .empty-cart-illustration {
                height: 120px;
                margin-bottom: 20px;
            }

            .cart-circle-pulse {
                width: 120px;
                height: 120px;
            }

            .cart-circle-inner {
                width: 100px;
                height: 100px;
            }

            .empty-cart-illustration i {
                font-size: 56px;
            }

            .floating-item {
                width: 35px;
                height: 35px;
            }

            .floating-item i {
                font-size: 16px;
            }

            .item-1 {
                right: 25%;
                top: 25px;
            }

            .item-2 {
                right: 30%;
            }

            .item-3 {
                left: 22%;
            }

            .empty-cart-title {
                font-size: 24px;
                margin-bottom: 12px;
            }

            .empty-cart-message {
                font-size: 15px;
                margin-bottom: 25px;
            }

            .cart-benefits {
                flex-direction: column;
                gap: 15px;
                margin-bottom: 30px;
            }

            .benefit-item {
                flex-direction: row;
                gap: 12px;
            }

            .benefit-icon {
                margin-bottom: 0;
            }

            .btn-shop-now {
                padding: 14px 30px;
                font-size: 15px;
                border-radius: 10px;
                width: 100%;
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
                        <span>Pengiriman dan Pembayaran</span>
                        <em>Lanjutkan ke Pembayaran</em>
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
                        <em>Tinjau dan Kirim Pesanan Anda</em>
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
                    <!-- Empty Cart Section Redesign -->
                    <div class="empty-cart-container">
                        <div class="cart-decoration-top">
                            <span></span><span></span><span></span>
                        </div>

                        <div class="empty-cart-illustration">
                            <div class="cart-circle-pulse"></div>
                            <div class="cart-circle-inner"></div>
                            <i class="fas fa-shopping-basket"></i>
                            <div class="floating-item item-1"><i class="fas fa-leaf"></i></div>
                            <div class="floating-item item-2"><i class="fas fa-gift"></i></div>
                            <div class="floating-item item-3"><i class="fas fa-spa"></i></div>
                        </div>

                        <h3 class="empty-cart-title">Keranjang Belanja Anda Kosong</h3>
                        <p class="empty-cart-message">Temukan produk-produk dari Eceng Gondok untuk menambahkan ke
                            keranjang Anda.</p>

                        <div class="cart-benefits">
                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <span>Pengiriman Cepat</span>
                            </div>
                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <span>Produk Berkualitas</span>
                            </div>
                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i class="fas fa-medal"></i>
                                </div>
                                <span>Ramah Lingkungan</span>
                            </div>
                        </div>

                        <div class="empty-cart-actions">
                            <a href="{{ route('shop.index') }}" class="btn btn-shop-now">
                                <i class="fas fa-store"></i>Jelajahi Produk
                            </a>
                        </div>

                        <div class="empty-cart-suggestion">
                            <p>Atau lihat <a href="#" class="suggestion-link">koleksi terbaru</a> kami</p>
                        </div>

                        <div class="cart-decoration-bottom">
                            <span></span><span></span><span></span>
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

            // Example: To update to step 2 when proceed to checkout
            // document.querySelector('.btn-checkout').addEventListener('click', function() {
            //     updateCheckoutStep(2);
            // });

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

        <style>
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

        <style>
            /* ====== PREMIUM MOBILE CART UI - INSPIRED BY ZALORA & MODERN E-COMMERCE ====== */
            @media (max-width: 768px) {

                /* ===== BASE STYLING & TYPOGRAPHY ===== */
                :root {
                    --spacing-xs: 4px;
                    --spacing-sm: 8px;
                    --spacing-md: 16px;
                    --spacing-lg: 24px;
                    --spacing-xl: 32px;
                }

                body {
                    -webkit-font-smoothing: antialiased;
                    -moz-osx-font-smoothing: grayscale;
                }

                .container {
                    padding-left: 16px;
                    padding-right: 16px;
                }

                /* Elegant page header */
                .page-title {
                    font-size: 24px;
                    font-weight: 600;
                    letter-spacing: 0.5px;
                    margin-top: 24px !important;
                    margin-bottom: 16px !important;
                    position: relative;
                    padding-bottom: 16px;
                }

                .page-title:after {
                    content: '';
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    width: 36px;
                    height: 3px;
                    background: var(--primary);
                    border-radius: 2px;
                }

                /* ===== MODERN CHECKOUT STEPS ===== */
                .checkout-steps {
                    margin-bottom: 24px;
                    padding: 0 4px;
                }

                .checkout-steps__item {
                    border-radius: 12px;
                    padding: 14px 16px;
                    margin-bottom: 10px;
                    background-color: #f9f9f9;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                    transition: all 0.25s ease;
                }

                .checkout-steps__item.active {
                    background-color: rgba(149, 106, 59, 0.08);
                    transform: translateY(-1px);
                    box-shadow: 0 3px 10px rgba(149, 106, 59, 0.1);
                }

                .checkout-steps__item-number {
                    width: 32px;
                    height: 32px;
                    font-size: 14px;
                    margin: 0 12px 0 0;
                    font-weight: 600;
                }

                .checkout-steps__item-title span {
                    font-size: 15px;
                    font-weight: 600;
                }

                /* ===== SELECT ALL CONTAINER ===== */
                .select-all-container {
                    display: flex;
                    align-items: center;
                    padding: 14px 16px;
                    background-color: #ffffff;
                    border-radius: 12px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
                    margin-bottom: 14px;
                    border: none;
                }

                .select-all-container label {
                    font-size: 14px;
                    font-weight: 500;
                    margin-left: 10px;
                }

                .cart-checkbox {
                    width: 20px;
                    height: 20px;
                    border-radius: 4px;
                }

                /* ===== PRODUCT CARDS REDESIGN ===== */
                .cart-table {
                    display: block;
                    border-collapse: separate;
                    border-spacing: 0 12px;
                }

                .cart-table thead {
                    display: none;
                }

                .cart-table tbody {
                    display: block;
                }

                /* Premium card design */
                .cart-table tbody tr {
                    display: flex;
                    flex-wrap: wrap;
                    position: relative;
                    background-color: #ffffff;
                    border-radius: 14px;
                    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
                    padding: 16px;
                    margin-bottom: 16px;
                    transition: transform 0.2s ease, box-shadow 0.2s ease;
                    border: 1px solid rgba(0, 0, 0, 0.03);
                }

                .cart-table tbody tr:active {
                    transform: scale(0.99);
                }

                .cart-table tbody td {
                    border: none;
                    padding: 0;
                }

                /* CHECKBOX - Top left position */
                .cart-table tbody td:nth-child(1) {
                    position: absolute;
                    left: 12px;
                    top: 12px;
                    z-index: 5;
                }

                /* PRODUCT IMAGE - Clean with shadow and rounded corners */
                .cart-table tbody td:nth-child(2) {
                    width: 35%;
                    padding-left: 30px;
                    padding-top: 4px;
                }

                .shopping-cart__product-item img {
                    width: 90px;
                    height: 90px;
                    object-fit: cover;
                    border-radius: 10px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
                    transition: transform 0.3s ease;
                }

                /* PRODUCT TITLE & DETAILS - Clean typography */
                .cart-table tbody td:nth-child(3) {
                    width: 65%;
                    padding-right: 30px;
                    padding-bottom: 14px;
                }

                .shopping-cart__product-item__detail h4 {
                    font-size: 15px;
                    font-weight: 500;
                    line-height: 1.4;
                    color: #333;
                    margin-bottom: 6px;
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                }

                .product-size-badge {
                    display: inline-flex;
                    align-items: center;
                    background: rgba(149, 106, 59, 0.08);
                    color: var(--primary);
                    font-size: 12px;
                    font-weight: 500;
                    padding: 3px 8px;
                    border-radius: 6px;
                    letter-spacing: 0.2px;
                }

                .product-size-badge i {
                    margin-right: 4px;
                    font-size: 10px;
                }

                /* PRICE DISPLAY - Clear hierarchy */
                .cart-table tbody td:nth-child(4) {
                    width: 50%;
                    margin-top: 6px;
                    padding-left: 30px;
                }

                .cart-table tbody td:nth-child(4)::before {
                    content: "Harga";
                    display: block;
                    font-size: 12px;
                    color: #888;
                    margin-bottom: 4px;
                    font-weight: 500;
                }

                .shopping-cart__product-price {
                    font-size: 15px;
                    font-weight: 600;
                    color: #333;
                }

                /* QUANTITY SELECTOR - Thumb-friendly */
                .cart-table tbody td:nth-child(5) {
                    width: 100%;
                    margin-top: 16px;
                    padding-left: 30px;
                }

                .cart-table tbody td:nth-child(5)::before {
                    content: "Jumlah";
                    display: block;
                    font-size: 12px;
                    color: #888;
                    margin-bottom: 6px;
                    font-weight: 500;
                }

                .qty-control {
                    width: 120px;
                    height: 40px;
                    border-radius: 8px;
                    display: flex;
                    align-items: center;
                    background-color: #f7f7f7;
                    overflow: hidden;
                    border: 1px solid #eeeeee;
                }

                .qty-input {
                    flex: 1;
                    height: 100%;
                    border: none;
                    text-align: center;
                    font-size: 15px;
                    font-weight: 500;
                    color: #333;
                    background-color: transparent;
                }

                .qty-control__reduce,
                .qty-control__increase {
                    width: 40px;
                    height: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 18px;
                    font-weight: 500;
                    color: #666;
                    user-select: none;
                    cursor: pointer;
                    transition: all 0.2s;
                    position: relative;
                }

                /* Modern + - buttons with visual feedback */
                .qty-control__reduce:after,
                .qty-control__increase:after {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: var(--primary);
                    opacity: 0;
                    transition: opacity 0.2s;
                }

                .qty-control__reduce:active:after,
                .qty-control__increase:active:after {
                    opacity: 0.1;
                }

                /* SUBTOTAL SECTION */
                .cart-table tbody td:nth-child(6) {
                    width: 50%;
                    margin-top: 6px;
                    text-align: right;
                    padding-right: 10px;
                }

                .cart-table tbody td:nth-child(6)::before {
                    content: "Subtotal";
                    display: block;
                    font-size: 12px;
                    color: #888;
                    margin-bottom: 4px;
                    font-weight: 500;
                }

                .shopping-cart__subtotal {
                    font-weight: 600;
                    color: var(--primary);
                    font-size: 15px;
                }

                /* REMOVE BUTTON - Thumb-friendly top-right */
                .cart-table tbody td:nth-child(7) {
                    position: absolute;
                    top: 12px;
                    right: 12px;
                }

                .remove-cart {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 30px;
                    height: 30px;
                    border-radius: 50%;
                    background-color: rgba(0, 0, 0, 0.03);
                    transition: all 0.2s;
                }

                .remove-cart:active {
                    background-color: rgba(0, 0, 0, 0.08);
                    transform: scale(0.95);
                }

                .remove-cart svg {
                    width: 12px;
                    height: 12px;
                    opacity: 0.6;
                }

                /* ===== COUPON SECTION ===== */
                .cart-table-footer {
                    display: flex;
                    flex-direction: column;
                    gap: 12px;
                    margin-bottom: 30px;
                }

                .cart-table-footer form {
                    width: 100%;
                }

                /* Redesigned coupon input */
                .cart-table-footer .form-control {
                    height: 46px;
                    border-radius: 10px;
                    border: 1px solid #e0e0e0;
                    font-size: 14px;
                    padding: 0 16px;
                    transition: border-color 0.2s;
                    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
                }

                .cart-table-footer .form-control:focus {
                    border-color: rgba(149, 106, 59, 0.4);
                    box-shadow: 0 2px 8px rgba(149, 106, 59, 0.1);
                }

                /* Apply coupon button */
                .cart-table-footer .btn-link {
                    height: 46px;
                    font-size: 13px;
                    font-weight: 600;
                    padding-left: 16px !important;
                    padding-right: 16px !important;
                    border-radius: 0 10px 10px 0;
                    transition: all 0.2s;
                    letter-spacing: 0.3px;
                }

                /* Empty cart button */
                .cart-table-footer .btn-light {
                    height: 46px;
                    border-radius: 10px;
                    font-size: 13px;
                    font-weight: 500;
                    letter-spacing: 0.3px;
                    border: 1px solid #e0e0e0;
                    background: #f8f8f8;
                    color: #666;
                    transition: all 0.2s;
                }

                .cart-table-footer .btn-light:active {
                    background: #f0f0f0;
                    transform: translateY(1px);
                }

                /* ===== ORDER SUMMARY SECTION ===== */
                .shopping-cart__totals-wrapper {
                    width: 100%;
                }

                /* Elegant payment details box */
                .shopping-cart__totals {
                    background-color: #fff;
                    border-radius: 14px;
                    padding: 20px;
                    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
                    margin-bottom: 20px;
                    border: 1px solid rgba(149, 106, 59, 0.08);
                }

                .shopping-cart__totals h3 {
                    font-size: 16px;
                    font-weight: 600;
                    margin-bottom: 18px;
                    color: #333;
                    padding-bottom: 12px;
                    border-bottom: 1px dashed rgba(149, 106, 59, 0.15);
                    letter-spacing: 0.3px;
                }

                .cart-totals {
                    width: 100%;
                }

                .cart-totals tr {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 12px;
                }

                .cart-totals tr th {
                    font-size: 14px;
                    font-weight: 500;
                    color: #666;
                }

                .cart-totals tr td {
                    font-size: 14px;
                    font-weight: 500;
                    color: #333;
                    text-align: right;
                }

                /* Highlight discount */
                #cart-discount {
                    color: #278c04;
                }

                /* Total row highlight */
                .cart-totals tr.cart-total {
                    margin-top: 15px;
                    padding-top: 15px;
                    border-top: 1px solid rgba(149, 106, 59, 0.12);
                }

                .cart-totals tr.cart-total th,
                .cart-totals tr.cart-total td {
                    font-size: 17px;
                    font-weight: 700;
                    color: var(--primary);
                }

                /* Shipping info style */
                .shipping-info {
                    padding: 8px 12px;
                    border-radius: 8px;
                    border-left: 3px solid var(--primary);
                    background-color: rgba(149, 106, 59, 0.06);
                }

                .shipping-info span {
                    font-size: 13px;
                }

                /* ===== CHECKOUT BUTTON FIXED ===== */
                .mobile_fixed-btn_wrapper {
                    position: fixed;
                    bottom: 65px;
                    /* Adjusted for bottom navbar */
                    left: 0;
                    width: 100%;
                    background: linear-gradient(to bottom, rgba(255, 255, 255, 0.9), #ffffff);
                    padding: 15px;
                    box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.08);
                    z-index: 999;
                    backdrop-filter: blur(5px);
                    -webkit-backdrop-filter: blur(5px);
                }

                /* Premium checkout button */
                .btn-checkout {
                    height: 48px;
                    font-size: 14px;
                    font-weight: 600;
                    letter-spacing: 0.5px;
                    border-radius: 12px;
                    background: linear-gradient(to right, var(--primary), #a87c4f);
                    border: none;
                    box-shadow: 0 6px 15px rgba(149, 106, 59, 0.2);
                    transition: all 0.3s ease;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .btn-checkout:active {
                    transform: translateY(2px);
                    box-shadow: 0 2px 8px rgba(149, 106, 59, 0.2);
                }

                /* Add space at bottom to account for fixed checkout button + navbar */
                .shopping-cart {
                    padding-bottom: 120px;
                }

                /* ===== VISUAL FEEDBACK FOR INTERACTIONS ===== */
                .cart-item-row.dimmed {
                    opacity: 0.5;
                    transform: scale(0.985);
                }

                /* Smooth transitions */
                .cart-item-row {
                    transition: all 0.25s ease-out;
                }

                /* Empty notification - error/success message */
                .text-success,
                .text-danger {
                    padding: 10px 15px;
                    border-radius: 10px;
                    font-size: 14px;
                    margin: 15px 0;
                    display: block;
                }

                .text-success {
                    background-color: rgba(39, 140, 4, 0.08);
                }

                .text-danger {
                    background-color: rgba(220, 53, 69, 0.08);
                }
            }

            /* Extra small device enhancements */
            @media (max-width: 380px) {
                .cart-table tbody td:nth-child(2) {
                    width: 32%;
                }

                .cart-table tbody td:nth-child(3) {
                    width: 68%;
                }

                .shopping-cart__product-item img {
                    width: 80px;
                    height: 80px;
                }

                .checkout-steps__item-title span {
                    font-size: 13px;
                }

                .checkout-steps__item-number {
                    width: 28px;
                    height: 28px;
                    font-size: 12px;
                }
            }
        </style>
    @endpush
@endsection

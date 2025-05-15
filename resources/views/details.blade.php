@extends('layouts.app')

@section('content')
    <style>
        .text-danger {
            color: #e53935 !important;
        }

        /* Modern Wishlist Button */
        .wishlist-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.25rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid #e0e0e0;
            background-color: #fff;
            color: #555;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            min-width: 180px;
        }

        .wishlist-btn:hover {
            background-color: #f8f8f8;
            border-color: #d0d0d0;
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
        }

        .wishlist-btn svg {
            margin-right: 8px;
            transition: all 0.3s ease;
        }

        .wishlist-btn:hover svg {
            transform: scale(1.1);
        }

        /* Filled heart for when item is in wishlist */
        .wishlist-btn.in-wishlist {
            color: #e53935;
            border-color: #ffcdd2;
            background-color: #ffebee;
        }

        .wishlist-btn.in-wishlist:hover {
            background-color: #ffcdd2;
        }

        /* Heart animation */
        @keyframes heartbeat {
            0% {
                transform: scale(1);
            }

            25% {
                transform: scale(1.2);
            }

            50% {
                transform: scale(1);
            }

            75% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        .heart-beat {
            animation: heartbeat 0.8s ease-in-out;
        }

        /* Modern Share Button */
        .share-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.25rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid #e0e0e0;
            background-color: #fff;
            color: #555;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            min-width: 120px;
        }

        .share-btn svg {
            margin-right: 8px;
            transition: all 0.3s ease;
        }

        .share-btn:hover {
            background-color: #f8f8f8;
            border-color: #d0d0d0;
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
        }

        .share-btn:hover svg {
            transform: scale(1.1);
        }

        /* Share Dropdown Menu */
        .share-dropdown {
            position: relative;
        }

        .share-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 280px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.15);
            padding: 18px;
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
        }

        .share-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .share-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 12px;
        }

        .share-title {
            font-weight: 600;
            font-size: 1rem;
            color: #333;
        }

        .share-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .share-option {
            display: flex;
            align-items: center;
            padding: 10px 12px;
            border-radius: 8px;
            transition: all 0.2s;
            text-decoration: none;
            color: #333;
            cursor: pointer;
        }

        .share-option:hover {
            background: #f5f5f5;
            transform: translateX(2px);
        }

        .share-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 14px;
            color: white;
            font-size: 16px;
        }

        .facebook-icon {
            background: #1877F2;
        }

        .twitter-icon {
            background: #1DA1F2;
        }

        .whatsapp-icon {
            background: #25D366;
        }

        .link-icon {
            background: #6c757d;
        }

        .copy-feedback {
            font-size: 0.8rem;
            color: #4CAF50;
            margin-top: 5px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .copy-feedback.active {
            opacity: 1;
        }

        /* Custom notification */
        .wishlist-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            padding: 15px 20px;
            display: none;
            align-items: center;
            z-index: 1000;
            max-width: 350px;
            transition: transform 0.3s ease, opacity 0.3s ease;
            transform: translateY(20px);
            opacity: 0;
            border-left: 4px solid;
        }

        .wishlist-notification.success {
            border-left-color: #4CAF50;
        }

        .wishlist-notification.removed {
            border-left-color: #e53935;
        }

        .wishlist-notification.show {
            transform: translateY(0);
            opacity: 1;
        }

        .wishlist-notification__icon {
            margin-right: 15px;
            width: 30px;
            height: 30px;
            background: #f5f5f5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wishlist-notification.success .wishlist-notification__icon {
            color: #4CAF50;
        }

        .wishlist-notification.removed .wishlist-notification__icon {
            color: #e53935;
        }

        .wishlist-notification__content {
            flex: 1;
        }

        .wishlist-notification__title {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 3px;
        }

        .wishlist-notification__message {
            font-size: 13px;
            color: #666;
        }

        .wishlist-notification__close {
            background: transparent;
            border: none;
            color: #aaa;
            cursor: pointer;
            padding: 5px;
            margin-left: 5px;
            font-size: 16px;
            transition: color 0.2s;
        }

        .wishlist-notification__close:hover {
            color: #666;
        }

        /* discount */
        .discount-text {
            color: #e53935;
            font-weight: 600;
        }

        .breadcrumb {

            font-size: 0.85rem;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "/";
            color: #ced4da;
        }

        .product-nav-link {
            transition: color 0.2s ease;
        }

        .product-nav-link:hover {
            color: #956a3b;
        }

        .product-info-box {
            transition: box-shadow 0.3s ease;
        }

        .product-info-box:hover {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .qty-control {
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .qty-control__number {
            border: 1px solid #ced4da;
            font-weight: 500;
        }

        .qty-control__number:focus {
            outline: none;
            border-color: #956a3b;
            box-shadow: 0 0 0 0.2rem rgba(149, 106, 59, 0.25);
        }

        .qty-control__reduce,
        .qty-control__increase {
            cursor: pointer;
            width: 24px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            transition: background-color 0.2s ease;
        }

        .qty-control__reduce:hover,
        .qty-control__increase:hover {
            background-color: #e9ecef;
        }

        .btn-primary,
        .btn-dark {
            border-radius: 4px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-primary:hover,
        .btn-dark:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* New Modal Styles */
        .quantity-modal .modal-content {
            border: none;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .quantity-modal .modal-header {
            border-bottom: 1px solid #f0f0f0;
            background-color: #fcfcfc;
            border-radius: 8px 8px 0 0;
        }

        .quantity-modal .modal-title {
            font-weight: 600;
            color: #333;
        }

        .quantity-modal .modal-body {
            padding: 2rem;
        }

        .quantity-modal .product-info {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .quantity-modal .product-info img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 1rem;
        }

        .quantity-modal .product-details h5 {
            margin-bottom: 0.25rem;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .quantity-modal .product-price {
            color: #956a3b;
            font-weight: 600;
        }

        .quantity-modal .stock-info {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        .quantity-modal .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 1.5rem 0;
        }

        .quantity-modal .qty-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quantity-modal .qty-btn:hover {
            background-color: #e9ecef;
        }

        .quantity-modal .qty-btn:focus {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(149, 106, 59, 0.25);
        }

        .quantity-modal .qty-input {
            width: 80px;
            height: 45px;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 500;
            border: 1px solid #ced4da;
            border-radius: 4px;
            margin: 0 0.75rem;
        }

        .quantity-modal .qty-input:focus {
            outline: none;
            border-color: #956a3b;
            box-shadow: 0 0 0 0.2rem rgba(149, 106, 59, 0.25);
        }

        .quantity-modal .modal-footer {
            border-top: 1px solid #f0f0f0;
            padding: 1rem 1.5rem;
        }

        .quantity-modal .btn-confirm {
            background-color: #956a3b;
            border-color: #956a3b;
            color: white;
            padding: 0.6rem 2rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .quantity-modal .btn-confirm:hover {
            background-color: #7d5931;
            border-color: #7d5931;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .quantity-modal .btn-cancel {
            color: #6c757d;
            background-color: #f8f9fa;
            border-color: #f8f9fa;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .quantity-modal .btn-cancel:hover {
            background-color: #e2e6ea;
            border-color: #dae0e5;
        }

        .nav-tabs .nav-link {
            font-weight: 500;
            color: #555;
            border: none;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            color: #956a3b;
            border-color: #956a3b;
            background-color: transparent;
        }

        .tab-content {
            padding: 20px;
            /* border: 1px solid #e0e0e0; */
            /* border-top: none; */
            /* border-radius: 0 0 80px 80px; */
            background-color: #fff;
        }

        .review-item {
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .review-rating svg {
            width: 16px;
            height: 16px;
        }

        /* Cart notification */
        .cart-notification {
            position: fixed;
            top: 20px;
            /* Tetap di atas */
            right: 20px;
            /* Diubah ke posisi kanan */
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            padding: 15px 20px;
            display: none;
            align-items: center;
            z-index: 1000;
            max-width: 350px;
            transition: transform 0.3s ease, opacity 0.3s ease;
            transform: translateY(-20px);
            /* Hanya transform Y untuk efek muncul dari atas */
            opacity: 0;
            border-left: 4px solid #956a3b;
            /* Warna coklat default */
        }

        .cart-notification.success {
            border-left-color: #956a3b;
            /* Warna coklat */
        }

        .cart-notification.error {
            border-left-color: #e53935;
            /* Tetap merah untuk error */
        }

        .cart-notification.show {
            transform: translateY(0);
            /* Normal position */
            opacity: 1;
        }

        .cart-notification__icon {
            margin-right: 15px;
            width: 30px;
            height: 30px;
            background: #f9f3ec;
            /* Background lebih terang dari coklat */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-notification.success .cart-notification__icon {
            color: #956a3b;
            /* Warna coklat */
        }

        .cart-notification.error .cart-notification__icon {
            color: #e53935;
            /* Tetap merah untuk error */
        }

        .cart-notification__content {
            flex: 1;
        }

        .cart-notification__title {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 3px;
            color: #956a3b;
            /* Judul berwarna coklat */
        }

        .cart-notification__message {
            font-size: 13px;
            color: #666;
        }

        .cart-notification__close {
            background: transparent;
            border: none;
            color: #aaa;
            cursor: pointer;
            padding: 5px;
            margin-left: 5px;
            font-size: 16px;
            transition: color 0.2s;
        }

        .cart-notification__close:hover {
            color: #956a3b;
            /* Hover menjadi coklat */
        }
    </style>

    <main class="pt-90">
        <div class="mb-md-1 pb-md-3"></div>
        <section class="product-single container">
            <div class="row" style="margin-top: 2%">
                <div class="col-lg-7">
                    <div class="product-single__media" data-media-type="vertical-thumbnail">
                        <div class="product-single__image">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide product-single__image-item">
                                        <img loading="lazy" class="h-auto"
                                            src="{{ asset('uploads/products') }}/{{ $product->image }}" width="674"
                                            height="674" alt="" />


                                        <a data-fancybox="gallery"
                                            href="{{ asset('uploads/products') }}/{{ $product->image }}"
                                            data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">


                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_zoom" />
                                            </svg>
                                        </a>
                                    </div>

                                    @foreach (explode(',', $product->images) as $gimg)
                                        <div class="swiper-slide product-single__image-item">
                                            <img loading="lazy" class="h-auto"
                                                src="{{ asset('uploads/products') }}/{{ trim($gimg) }}" width="674"
                                                height="674" alt="" />
                                            <a data-fancybox="gallery"
                                                href="{{ asset('uploads/products') }}/{{ trim($gimg) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_zoom" />
                                                </svg>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_sm" />
                                    </svg></div>
                                <div class="swiper-button-next"><svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_sm" />
                                    </svg></div>
                            </div>
                        </div>
                        <div class="product-single__thumbnail">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide product-single__image-item"><img loading="lazy" class="h-auto"
                                            src="{{ asset('uploads/products/thumbnails') }}/{{ $product->image }}"
                                            width="104" height="104" alt="" /></div>
                                    @foreach (explode(',', $product->images) as $gimg)
                                        <div class="swiper-slide product-single__image-item">
                                            <img loading="lazy" class="h-auto"
                                                src="{{ asset('uploads/products/thumbnails') }}/{{ trim($gimg) }}"
                                                width="104" height="104" alt="" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <!-- Improved Breadcrumb Navigation -->
                    <div class="d-flex justify-content-between mb-4 pb-md-2">
                        <nav aria-label="breadcrumb" class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                            <ol class="breadcrumb m-0 p-0 d-flex flex-wrap align-items-center">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home.index') }}"
                                        class="menu-link menu-link_us-s text-uppercase fw-medium">
                                        <i class="fas fa-home me-1 small"></i>Beranda
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('shop.index') }}"
                                        class="menu-link menu-link_us-s text-uppercase fw-medium">Produk</a>
                                </li>
                                <li class="breadcrumb-item active text-uppercase fw-medium" aria-current="page">Detail
                                    Produk</li>
                            </ol>
                        </nav>

                        <div
                            class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                            @if ($prevProduct)
                                <a href="{{ route('shop.product.details', ['product_slug' => $prevProduct->slug]) }}"
                                    class="nav-item text-uppercase fw-medium product-nav-link me-2 d-flex align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $prevProduct->name }}">
                                    <svg width="10" height="10" viewBox="0 0 25 25"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_md" />
                                    </svg>
                                    <span class="menu-link menu-link_us-s ms-1">Sebelum</span>
                                </a>
                            @endif

                            @if ($nextProduct)
                                <a href="{{ route('shop.product.details', ['product_slug' => $nextProduct->slug]) }}"
                                    class="nav-item text-uppercase fw-medium product-nav-link ms-2 d-flex align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $nextProduct->name }}">
                                    <span class="menu-link menu-link_us-s me-1">Berikut</span>
                                    <svg width="10" height="10" viewBox="0 0 25 25"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_md" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    <h1 class="product-single__name">{{ $product->name }}</h1>

                    <div class="product-single__rating">
                        <div class="reviews-group d-flex">
                            @php
                                $averageRating = $product->reviews()->avg('rating');
                                $totalReviews = $product->reviews()->count();
                            @endphp

                            {{-- Display stars dynamically based on the average rating --}}
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"
                                    style="fill: {{ $i <= $averageRating ? '#FFD700' : '#E0E0E0' }};">
                                    <use href="#icon_star" />
                                </svg>
                            @endfor
                        </div>

                        {{-- Display total reviews count --}}
                        <span class="reviews-note text-lowercase text-secondary ms-1">
                            {{ $totalReviews > 1000 ? round($totalReviews / 1000, 1) . 'k+' : $totalReviews }} Ulasan
                        </span>
                    </div>

                    <div class="product-single__price">
                        <span class="current-price">
                            @if ($product->sale_price < $product->regular_price)
                                <s>{{ formatRupiah($product->regular_price) }}</s>
                                {{ formatRupiah($product->sale_price) }}
                                <span class="discount-text">
                                    {{ round((($product->regular_price - $product->sale_price) * 100) / $product->regular_price) }}%
                                    DISKON
                                </span>
                            @else
                                {{ formatRupiah($product->regular_price) }}
                            @endif
                        </span>
                    </div>
                    <div class="product-single__short-desc">
                        <p>{{ $product->short_description }}</p>
                    </div>

                    <!-- resources/views/detail.blade.php -->
                    <div class="stock-info d-flex align-items-center">
                        <span class="text-secondary fw-semibold me-2" style="font-size: 1rem;">
                            <i class="fas fa-box-open me-1"></i> Stok tersedia:
                        </span>
                        <span class="badge fw-bold rounded-pill px-3"
                            style="background-color: #D2B48C; color: #fff; font-size: 0.9rem;">
                            {{ $product->quantity - $product->reserved_quantity }}
                        </span>
                    </div>

                    <!-- Sebelum buttons "Tambahkan ke Keranjang" dan "Beli Sekarang" -->
                    <div class="product-single__addtocart">
                        @if ($product->sizes->count() > 0)
                            <div class="size-selector mb-3">
                                <label class="fw-semibold mb-2">Pilih Ukuran:</label>
                                <div class="d-flex flex-wrap gap-2" id="size-buttons">
                                    @foreach ($product->sizes as $size)
                                        <button type="button" class="btn size-btn" data-size-id="{{ $size->id }}"
                                            data-size-name="{{ $size->name }}" data-stock="{{ $size->pivot->stock }}"
                                            style="border: 1px solid #d2b48c; color: #956a3b; background-color: white; min-width: 50px; padding: 8px 16px; border-radius: 4px;">
                                            {{ $size->name }}
                                            {{-- <small class="d-block text-muted mt-1">Stok: {{ $size->pivot->stock }}</small> --}}
                                        </button>
                                    @endforeach
                                </div>
                                <div class="selected-size mt-2 d-none" id="selected-size-info">
                                    <span class="badge bg-secondary">Ukuran dipilih: <span id="size-name"></span></span>
                                </div>
                                <div class="text-danger small mt-2 d-none" id="size-error">
                                    Silakan pilih ukuran terlebih dahulu
                                </div>
                                <input type="hidden" id="selected-size-id" name="size_id" value="">
                            </div>
                        @endif

                        <div class="d-flex gap-2 mt-3">
                            <button type="button" class="btn flex-grow-1" id="open-quantity-modal"
                                style="background-color: rgba(149, 106, 59, 0.2); border: 1px solid #956a3b; color: #956a3b; padding: 0.75rem 1rem;">
                                <i class="fas fa-shopping-cart me-2"></i> Tambahkan ke Keranjang
                            </button>
                            <button type="button" id="buy-now" class="btn btn-dark flex-grow-1"
                                style="background-color: #956a3b; border-color: #956a3b; color: #ffffff; padding: 0.75rem 1rem;">
                                <i class=""></i> Beli Sekarang
                            </button>
                        </div>
                    </div>

                    <!-- Hidden Forms for Cart and Buy Now -->
                    <form name="addtocart-form" id="addtocart-form" method="POST" action="{{ route('cart.add') }}"
                        style="display: none;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}" />
                        <input type="hidden" name="name" value="{{ $product->name }}" />
                        <input type="hidden" name="quantity" id="cart-quantity" value="1" />
                        <input type="hidden" name="price"
                            value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}" />
                        <input type="hidden" name="size_id" id="cart-size-id" value="" />
                    </form>

                    <form name="buynow-form" id="buynow-form" method="POST" action="{{ route('cart.add') }}"
                        style="display: none;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}" />
                        <input type="hidden" name="name" value="{{ $product->name }}" />
                        <input type="hidden" name="quantity" id="buynow-quantity" value="1" />
                        <input type="hidden" name="price"
                            value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}" />
                        <input type="hidden" name="size_id" id="buynow-size-id" value="" />
                        <input type="hidden" name="checkout_redirect" value="1" />
                    </form>

                    <!-- Quantity Modal (Diperbaiki) -->
                    <div class="modal fade quantity-modal" id="quantityModal" tabindex="-1"
                        aria-labelledby="quantityModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="quantityModalLabel">
                                        <i class="fas fa-shopping-basket me-2"></i> Pilih Jumlah
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="product-info">
                                        <img src="{{ asset('uploads/products') }}/{{ $product->image }}"
                                            alt="{{ $product->name }}" class="product-thumbnail">
                                        <div class="product-details">
                                            <h5>{{ $product->name }}</h5>
                                            <div class="product-price">
                                                @if ($product->sale_price < $product->regular_price)
                                                    <span>{{ formatRupiah($product->sale_price) }}</span>
                                                    <small
                                                        class="text-muted"><s>{{ formatRupiah($product->regular_price) }}</s></small>
                                                @else
                                                    <span>{{ formatRupiah($product->regular_price) }}</span>
                                                @endif
                                            </div>
                                            @if ($product->sizes->count() > 0)
                                                <div class="selected-size-info mt-1" id="modal-size-info">
                                                    <span class="badge bg-secondary">Ukuran: <span
                                                            id="modal-size-name"></span></span>
                                                </div>
                                            @endif
                                            <div class="stock-info">
                                                <i class="fas fa-box-open me-1"></i> Stok tersedia: <span
                                                    class="fw-semibold"
                                                    id="modal-available-stock">{{ $product->quantity - $product->reserved_quantity }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="quantity-controls">
                                        <button type="button" class="qty-btn modal-reduce-qty">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" class="qty-input modal-qty-input" value="1"
                                            min="1" max="{{ $product->quantity - $product->reserved_quantity }}">
                                        <button type="button" class="qty-btn modal-increase-qty">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-cancel"
                                        data-bs-dismiss="modal">Batalkan</button>
                                    <button type="button" class="btn btn-confirm" id="confirmAddToCart">
                                        <i class="fas fa-shopping-cart me-2"></i> Tambahkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Actions Section -->
                    <div class="product-single__addtolinks mt-4 d-flex gap-3">
                        @if (\Surfsidemedia\Shoppingcart\Facades\Cart::instance('wishlist')->content()->where('id', $product->id)->count() > 0)
                            <form method="POST"
                                action="{{ route('wishlist.remove', ['rowId' => \Surfsidemedia\Shoppingcart\Facades\Cart::instance('wishlist')->content()->where('id', $product->id)->first()->rowId]) }}"
                                id="frm-remove-item">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="wishlist-btn in-wishlist" id="remove-from-wishlist">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16"
                                        viewBox="0 0 20 18" fill="#e53935">
                                        <path
                                            d="M10 18L8.55 16.7C3.4 12.1 0 9.1 0 5.5C0 2.5 2.42 0 5.5 0C7.24 0 8.91 0.81 10 2.09C11.09 0.81 12.76 0 14.5 0C17.58 0 20 2.5 20 5.5C20 9.1 16.6 12.1 11.45 16.7L10 18Z" />
                                    </svg>
                                    <span>Hapus dari Favorit</span>
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('wishlist.add') }}" id="wishlist-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}" />
                                <input type="hidden" name="name" value="{{ $product->name }}" />
                                <input type="hidden" name="price"
                                    value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}" />
                                <input type="hidden" name="quantity" value="1" />
                                <button type="button" class="wishlist-btn" id="add-to-wishlist">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16"
                                        viewBox="0 0 20 18" fill="none" stroke="#555" stroke-width="1.5">
                                        <path
                                            d="M10 18L8.55 16.7C3.4 12.1 0 9.1 0 5.5C0 2.5 2.42 0 5.5 0C7.24 0 8.91 0.81 10 2.09C11.09 0.81 12.76 0 14.5 0C17.58 0 20 2.5 20 5.5C20 9.1 16.6 12.1 11.45 16.7L10 18Z" />
                                    </svg>
                                    <span>Tambahkan ke Favorit</span>
                                </button>
                            </form>
                        @endif

                        <!-- Improved Share Button -->
                        <div class="share-dropdown position-relative">
                            <button class="share-btn" id="shareButton">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="18" cy="5" r="3"></circle>
                                    <circle cx="6" cy="12" r="3"></circle>
                                    <circle cx="18" cy="19" r="3"></circle>
                                    <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                                    <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                                </svg>
                                <span>Bagikan</span>
                            </button>
                            <div class="share-menu" id="shareMenu">
                                <div class="share-header">
                                    <span class="share-title">Bagikan Produk</span>
                                    <button type="button" class="btn-close" id="closeShareMenu"></button>
                                </div>
                                <div class="share-options">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}"
                                        target="_blank" class="share-option">
                                        <div class="share-icon facebook-icon">
                                            <i class="fab fa-facebook-f"></i>
                                        </div>
                                        <span>Facebook</span>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}&text={{ urlencode($product->name) }}"
                                        target="_blank" class="share-option">
                                        <div class="share-icon twitter-icon">
                                            <i class="fab fa-twitter"></i>
                                        </div>
                                        <span>Twitter</span>
                                    </a>
                                    <a href="https://wa.me/?text={{ urlencode($product->name . ' - ' . Request::url()) }}"
                                        target="_blank" class="share-option">
                                        <div class="share-icon whatsapp-icon">
                                            <i class="fab fa-whatsapp"></i>
                                        </div>
                                        <span>WhatsApp</span>
                                    </a>
                                    <div class="share-option" id="copyLink" data-url="{{ Request::url() }}">
                                        <div class="share-icon link-icon">
                                            <i class="fas fa-link"></i>
                                        </div>
                                        <div>
                                            <span>Salin Link</span>
                                            <div class="copy-feedback" id="copyFeedback">Link berhasil disalin!</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Custom notification element -->
                    <div class="wishlist-notification" id="wishlist-notification">
                        <div class="wishlist-notification__icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="wishlist-notification__content">
                            <div class="wishlist-notification__title" id="notification-title">Ditambahkan ke Favorit</div>
                            <div class="wishlist-notification__message" id="notification-message"></div>
                        </div>
                        <button class="wishlist-notification__close" id="close-notification">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="product-single__meta-info mt-4">
                        <div class="meta-item">
                            <label>Kategori Produk : </label>
                            <span>{{ $product->category->name }}</span>
                        </div>
                        <div class="meta-item">
                            <label>Merek asli : </label>
                            <span>{{ $product->brand->name }}</span>
                        </div>
                    </div>

                    <div class="product-reviews mt-4">
                        <h4 class="mb-4">Ulasan Produk</h4>
                        @php
                            $reviews = $product->reviews()->with('user', 'reviewMedia')->get();
                        @endphp

                        @if ($reviews->count() > 0)
                            @foreach ($reviews as $review)
                                <div class="review-item mb-4 p-3 border rounded">
                                    <div class="d-flex align-items-center mb-2">
                                        <strong>{{ $review->user->name }}</strong>
                                        <span class="ms-3 text-muted">{{ $review->created_at->format('d M Y') }}</span>
                                    </div>
                                    <div class="review-rating mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"
                                                style="fill: {{ $i <= $review->rating ? '#FFD700' : '#E0E0E0' }};">
                                                <use href="#icon_star" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <p class="review-comment">{{ $review->comment }}</p>
                                    @if ($review->reviewMedia->count() > 0)
                                        <div class="review-media mt-2">
                                            @foreach ($review->reviewMedia as $media)
                                                @if ($media->file_type === 'image')
                                                    <img src="{{ asset('storage/' . $media->file_path) }}"
                                                        alt="Review Media"
                                                        style="max-width: 100px; max-height: 100px; margin-right: 10px; border-radius: 5px;">
                                                @elseif ($media->file_type === 'video')
                                                    <video controls
                                                        style="max-width: 200px; max-height: 150px; margin-right: 10px;">
                                                        <source src="{{ asset('storage/' . $media->file_path) }}"
                                                            type="video/mp4">
                                                        Video tidak didukung.
                                                    </video>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Belum ada ulasan untuk produk ini.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="product-single__details-tab">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs justify-content-center" id="productDetailsTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-description-tab" data-bs-toggle="tab"
                            data-bs-target="#tab-description" type="button" role="tab"
                            aria-controls="tab-description" aria-selected="true">
                            <i class="fas fa-info-circle me-2"></i>Deskripsi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-additional-info-tab" data-bs-toggle="tab"
                            data-bs-target="#tab-additional-info" type="button" role="tab"
                            aria-controls="tab-additional-info" aria-selected="false">
                            <i class="fas fa-list-alt me-2"></i>Informasi Tambahan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-reviews-tab" data-bs-toggle="tab" data-bs-target="#tab-reviews"
                            type="button" role="tab" aria-controls="tab-reviews" aria-selected="false">
                            <i class="fas fa-star me-2"></i>Semua Ulasan ({{ $product->reviews()->count() }})
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content mt-4">
                    <!-- Description Tab -->
                    <div class="tab-pane fade show active" id="tab-description" role="tabpanel"
                        aria-labelledby="tab-description-tab">
                        <div class="product-single__description">
                            <h4 class="mb-3">Tentang Produk</h4>
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>

                    <!-- Additional Info Tab -->
                    <div class="tab-pane fade" id="tab-additional-info" role="tabpanel"
                        aria-labelledby="tab-additional-info-tab">
                        <div class="product-single__additional-info">
                            <h4 class="mb-3">Informasi Tambahan</h4>
                            <ul class="list-unstyled">
                                <li><strong>Kategori:</strong> {{ $product->category->name }}</li>
                                <li><strong>Brand:</strong> {{ $product->brand->name }}</li>
                                <li><strong>SKU:</strong> {{ $product->SKU }}</li>
                                <li><strong>Stok:</strong> {{ $product->quantity }}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Reviews Tab -->
                    <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews-tab">
                        <div class="product-reviews mt-4">
                            <h4 class="mb-4">Ulasan Produk</h4>
                            @php
                                $reviews = $product->reviews()->with('user', 'reviewMedia')->get();
                            @endphp

                            @if ($reviews->count() > 0)
                                @foreach ($reviews as $review)
                                    <div class="review-item mb-4 p-3 border rounded">
                                        <div class="d-flex align-items-center mb-2">
                                            <strong>{{ $review->user->name }}</strong>
                                            <span
                                                class="ms-3 text-muted">{{ $review->created_at->format('d M Y') }}</span>
                                        </div>
                                        <div class="review-rating mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="review-star" viewBox="0 0 9 9"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    style="fill: {{ $i <= $review->rating ? '#FFD700' : '#E0E0E0' }};">
                                                    <use href="#icon_star" />
                                                </svg>
                                            @endfor
                                        </div>
                                        <p class="review-comment">{{ $review->comment }}</p>
                                        @if ($review->reviewMedia->count() > 0)
                                            <div class="review-media mt-2">
                                                @foreach ($review->reviewMedia as $media)
                                                    @if ($media->file_type === 'image')
                                                        <img src="{{ asset('storage/' . $media->file_path) }}"
                                                            alt="Review Media"
                                                            style="max-width: 100px; max-height: 100px; margin-right: 10px; border-radius: 5px;">
                                                    @elseif ($media->file_type === 'video')
                                                        <video controls
                                                            style="max-width: 200px; max-height: 150px; margin-right: 10px;">
                                                            <source src="{{ asset('storage/' . $media->file_path) }}"
                                                                type="video/mp4">
                                                            Video tidak didukung.
                                                        </video>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted">Belum ada ulasan untuk produk ini.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="products-carousel container">
            <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Produk <strong>Terkait</strong></h2>
            <div id="related_products" class="position-relative">
                <div class="swiper-container js-swiper-slider"
                    data-settings='
                    {
        "autoplay": false,
        "slidesPerView": 4,
        "slidesPerGroup": 4,
        "effect": "none",
        "loop": true,
        "pagination": {
          "el": "#related_products .products-pagination",
          "type": "bullets",
          "clickable": true
        },
        "navigation": {
          "nextEl": "#related_products .products-carousel__next",
          "prevEl": "#related_products .products-carousel__prev"
        },
        "breakpoints": {
          "320": {
            "slidesPerView": 2,
            "slidesPerGroup": 2,
            "spaceBetween": 14
          },
          "768": {
            "slidesPerView": 3,
            "slidesPerGroup": 3,
            "spaceBetween": 24
          },
          "992": {
            "slidesPerView": 4,
            "slidesPerGroup": 4,
            "spaceBetween": 30
          }
        }
      }'>
                    <div class="swiper-wrapper">
                        @foreach ($rproducts as $rproduct)
                            <div class="swiper-slide product-card">
                                <div class="pc__img-wrapper">
                                    <a href="{{ route('shop.product.details', ['product_slug' => $rproduct->slug]) }}">
                                        <img loading="lazy" src="{{ asset('uploads/products') }}/{{ $rproduct->image }}"
                                            width="330" height="400" alt="{{ $rproduct->name }}" class="pc__img">
                                        @foreach (explode(',', $rproduct->images) as $gimg)
                                            <img loading="lazy"
                                                src="{{ asset('uploads/products') }}/{{ trim(explode(',', $rproduct->images)[0]) }}"
                                                width="330" height="400" alt="{{ $rproduct->name }}"
                                                class="pc__img pc__img-second">
                                        @endforeach
                                    </a>
                                    {{-- @if (\Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->content()->Where('id', $rproduct->id)->count() > 0)
                                        <a href="{{ route('cart.index') }}"
                                            class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium js-add-cart btn-warning">Go
                                            to Cart</a>
                                    @else --}}
                                    <form name="addtocart-form" method="POST" action=" {{ route('cart.add') }}">
                                        @csrf
                                        <div class="product-single__addtocart">
                                            <input type="hidden" name="id" value="{{ $rproduct->id }}" />
                                            <input type="hidden" name="name" value="{{ $rproduct->name }}" />
                                            <input type="hidden" name="quantity" value="1" />
                                            <input type="hidden" name="price"
                                                value="{{ $rproduct->sale_price == '' ? $rproduct->regular_price : $rproduct->sale_price }}" />
                                            <button type="submit"
                                                class="pc__atc btn anim_appear-bottom position-absolute border-0 text-uppercase fw-medium js-add-cart"
                                                style="background-color:#956a3b; color:#ffffff;">
                                                Tambahkan ke Keranjang
                                            </button>
                                        </div>
                                    </form>
                                    <!-- Toast Notification khusus untuk produk ini -->
                                    <div id="cart-toast-{{ $rproduct->id }}" class="toast" role="alert"
                                        aria-live="assertive" aria-atomic="true" data-bs-delay="3000"
                                        style="
                       position: absolute;
                       bottom: 50px; /* Jarak 50px di atas tombol */
                       left: 0;
                       z-index: 9999;
                       display: none;
                       min-width: 250px;
                       background-color: #fff;
                       border: 1px solid #e0e0e0;
                       border-radius: 8px;
                       box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    ">
                                        <div class="toast-header"
                                            style="
                          background-color: #f9f9f9;
                          color: #333;
                          border-top-left-radius: 8px;
                          border-top-right-radius: 8px;
                          padding: 0.5rem 0.75rem;
                          display: flex;
                          align-items: center;
                          justify-content: space-between;
                        ">
                                            <strong class="me-auto" style="font-size: 14px;">Notifikasi</strong>
                                            <small style="font-size: 12px;">Baru saja</small>
                                            <button type="button" class="btn-close" data-bs-dismiss="toast"
                                                aria-label="Close" style="margin-left: 10px;"></button>
                                        </div>
                                        <div class="toast-body" style="font-size: 14px; color: #555; padding: 0.75rem;">
                                            Produk telah ditambahkan ke dalam keranjang.
                                        </div>
                                    </div>
                                    <!-- End Toast Notification -->
                                    {{-- @endif --}}
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">{{ $rproduct->category->name }}</p>
                                    <h6 class="pc__title">
                                        <a
                                            href="{{ route('shop.product.details', ['product_slug' => $rproduct->slug]) }}">
                                            {{ $rproduct->name }}
                                        </a>
                                    </h6>
                                    <div class="product-card__price d-flex">
                                        <span class="money price">
                                            @if ($rproduct->sale_price < $rproduct->regular_price)
                                                <s>{{ formatRupiah($rproduct->regular_price) }}</s>
                                                {{ formatRupiah($rproduct->sale_price) }}
                                                <span class="discount-text">
                                                    {{ round((($rproduct->regular_price - $rproduct->sale_price) * 100) / $rproduct->regular_price) }}%
                                                    DISKON
                                                </span>
                                            @else
                                                {{ formatRupiah($rproduct->regular_price) }}
                                            @endif
                                        </span>
                                    </div>
                                    <button
                                        class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                        title="Tambahkan Ke Favorit">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_heart" />
                                        </svg>
                                    </button>
                                </div>

                            </div>
                        @endforeach
                    </div>
                    <!-- /.swiper-wrapper -->
                </div><!-- /.swiper-container js-swiper-slider -->

                <div
                    class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_prev_md" />
                    </svg>
                </div><!-- /.products-carousel__prev -->
                <div
                    class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_next_md" />
                    </svg>
                </div><!-- /.products-carousel__next -->

                <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
                <!-- /.products-pagination -->
            </div><!-- /.position-relative -->

        </section><!-- /.products-carousel container -->

        <!-- Cart notification -->
        <div class="cart-notification" id="cart-notification">
            <div class="cart-notification__icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="cart-notification__content">
                <div class="cart-notification__title" id="cart-notification-title">Ditambahkan ke Keranjang</div>
                <div class="cart-notification__message" id="cart-notification-message"></div>
            </div>
            <button class="cart-notification__close" id="close-cart-notification">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </main>

@endsection

@push('scripts')
    <script>
        // Function to show cart notification
        function showCartNotification(message, isSuccess = true) {
            const notification = $('#cart-notification');
            const title = $('#cart-notification-title');
            const messageEl = $('#cart-notification-message');

            // Set content
            messageEl.text(message);

            // Set type (success or error)
            if (isSuccess) {
                notification.removeClass('error').addClass('success');
                title.text('Ditambahkan ke Keranjang');
                $('.cart-notification__icon i').removeClass('fa-exclamation-circle').addClass('fa-shopping-cart');
            } else {
                notification.removeClass('success').addClass('error');
                title.text('Gagal Ditambahkan');
                $('.cart-notification__icon i').removeClass('fa-shopping-cart').addClass('fa-exclamation-circle');
            }

            // Show notification
            notification.css('display', 'flex').addClass('show');

            // Auto hide after 3 seconds
            setTimeout(() => {
                notification.removeClass('show');
                setTimeout(() => notification.css('display', 'none'), 300);
            }, 3000);
        }

        // Close notification button
        $('#close-cart-notification').on('click', function() {
            const notification = $('#cart-notification');
            notification.removeClass('show');
            setTimeout(() => notification.css('display', 'none'), 300);
        });
    </script>

    <script>
        $(document).ready(function() {
            // Kode yang sudah ada tetap dipertahankan

            // Tombol Beli Sekarang
            $('#buy-now').on('click', function() {
                const quantity = $('.qty-control__number').val();
                const maxStock = {{ $product->quantity }};

                // Validasi quantity tidak melebihi stok
                if (parseInt(quantity) > maxStock) {
                    showNotification(`Tidak bisa menambah lebih dari stok yang tersedia: ${maxStock} item`,
                        'error');
                    return;
                }

                // Update quantity di form beli sekarang
                $('#buynow-quantity').val(quantity);

                // Submit form secara asynchronous
                const formData = $('#buynow-form').serialize();

                $.ajax({
                    url: "{{ route('cart.add') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Update jumlah item di navbar jika perlu
                            $('.js-cart-items-count').text(response.cartCount);

                            // Redirect ke halaman keranjang
                            window.location.href = "{{ route('cart.index') }}";
                        } else {
                            showNotification(response.message ||
                                'Gagal menambahkan produk ke keranjang', 'error');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Gagal menambahkan produk ke keranjang';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        showNotification(errorMsg, 'error');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Clear any existing event handlers to prevent conflicts
            $('#open-quantity-modal').off('click');

            // Create a single, consolidated event handler
            $('#open-quantity-modal').on('click', function() {
                console.log('Add to Cart button clicked');

                // Check if product has sizes and if size is selected
                if ({{ $product->sizes->count() > 0 ? 'true' : 'false' }} && !$('#selected-size-id')
                    .val()) {
                    $('#size-error').removeClass('d-none');
                    $('html, body').animate({
                        scrollTop: $("#size-buttons").offset().top - 100
                    }, 500);
                    return false; // Prevent further execution
                }

                // Explicitly reset buyNow flag
                $('#quantityModal').data('buyNow', false);

                // Update modal with selected size information
                if ({{ $product->sizes->count() > 0 ? 'true' : 'false' }}) {
                    const sizeId = $('#selected-size-id').val();
                    const sizeName = $('#size-name').text();
                    const sizeBtn = $(`.size-btn[data-size-id="${sizeId}"]`);

                    // Update size info in modal
                    $('#modal-size-name').text(sizeName);

                    // Update stock info in modal
                    if (sizeBtn.length) {
                        const availableStock = sizeBtn.data('stock');
                        $('#modal-available-stock').text(availableStock);
                        $('.modal-qty-input').attr('max', availableStock);
                    }
                }

                // Show the modal
                $('#quantityModal').modal('show');
            });

            // Ensure size buttons work correctly
            $('.size-btn').off('click').on('click', function() {
                console.log('Size button clicked');

                // Remove active class from all buttons
                $('.size-btn').removeClass('active')
                    .css({
                        'background-color': 'white',
                        'color': '#956a3b'
                    });

                // Add active class to selected button
                $(this).addClass('active')
                    .css({
                        'background-color': '#956a3b',
                        'color': 'white'
                    });

                // Get size info
                const sizeId = $(this).data('size-id');
                const sizeName = $(this).data('size-name');

                // Update all hidden inputs
                $('#selected-size-id').val(sizeId);
                $('#cart-size-id').val(sizeId);
                $('#buynow-size-id').val(sizeId);

                // Update visible size info
                $('#size-name').text(sizeName);
                $('#selected-size-info').removeClass('d-none');
                $('#size-error').addClass('d-none');

                console.log('Size selected:', {
                    id: sizeId,
                    name: sizeName,
                    'selected-size-id': $('#selected-size-id').val()
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Initialize tooltips for product navigation
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    delay: {
                        show: 500,
                        hide: 100
                    }
                });
            });

            // Track product navigation for analytics (optional enhancement)
            $('.product-single__nav .nav-item').on('click', function() {
                const direction = $(this).find('.menu-link').text().trim();
                const targetProduct = $(this).attr('title') || 'Unknown product';

                // You can send this data to your analytics system
                console.log(`Navigation: ${direction} to ${targetProduct}`);

                // Optional: Add loading indicator
                $(this).append(
                    '<span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>'
                );
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // === SIZE SELECTOR HANDLING ===
            const hasProductSizes = {{ $product->sizes->count() > 0 ? 'true' : 'false' }};

            // Handle size button clicks
            $('.size-btn').on('click', function() {
                // Hapus active class dari semua tombol
                $('.size-btn').removeClass('active')
                    .css({
                        'background-color': 'white',
                        'color': '#956a3b'
                    });

                // Tambahkan active class ke tombol yang dipilih
                $(this).addClass('active')
                    .css({
                        'background-color': '#956a3b',
                        'color': 'white'
                    });

                // Simpan size id yang dipilih
                const sizeId = $(this).data('size-id');
                const sizeName = $(this).data('size-name');
                const sizeStock = $(this).data('stock');

                // Update hidden inputs pada form
                $('#selected-size-id').val(sizeId);
                $('#cart-size-id').val(sizeId);
                $('#buynow-size-id').val(sizeId);

                // Tampilkan informasi ukuran yang dipilih
                $('#size-name').text(sizeName);
                $('#selected-size-info').removeClass('d-none');
                $('#size-error').addClass('d-none');
            });

            // === MODAL HANDLING ===

            // Handle "Tambahkan ke Keranjang" button to open modal
            $('#open-quantity-modal').on('click', function() {
                // Cek apakah produk punya ukuran dan ukuran sudah dipilih
                if (hasProductSizes && !$('#selected-size-id').val()) {
                    $('#size-error').removeClass('d-none');
                    $('html, body').animate({
                        scrollTop: $("#size-buttons").offset().top - 100
                    }, 500);
                    return;
                }

                // Update modal with selected size information
                if (hasProductSizes) {
                    const sizeId = $('#selected-size-id').val();
                    const sizeName = $('#size-name').text();
                    const sizeBtn = $(`.size-btn[data-size-id="${sizeId}"]`);

                    // Update size info in modal
                    $('#modal-size-name').text(sizeName);
                    $('#modal-size-info').removeClass('d-none');

                    // Update stock info in modal if this size has specific stock
                    if (sizeBtn.length) {
                        const availableStock = sizeBtn.data('stock');
                        $('#modal-available-stock').text(availableStock);
                        $('.modal-qty-input').attr('max', availableStock);
                    }
                }

                // Reset quantity to 1
                $('.modal-qty-input').val(1);

                // Show the modal
                $('#quantityModal').modal('show');
            });

            // Handle quantity control in modal
            $('.modal-reduce-qty').on('click', function() {
                let qty = parseInt($('.modal-qty-input').val());
                if (qty > 1) {
                    $('.modal-qty-input').val(qty - 1);
                }
            });

            $('.modal-increase-qty').on('click', function() {
                let qty = parseInt($('.modal-qty-input').val());
                let max = parseInt($('.modal-qty-input').attr('max'));
                if (qty < max) {
                    $('.modal-qty-input').val(qty + 1);
                }
            });

            // IMPORTANT: This is the fixed part - Handle "Tambahkan" button in modal
            $('#confirmAddToCart').on('click', function() {
                // Get quantity from modal
                const quantity = $('.modal-qty-input').val();

                // Update quantity in the cart form
                $('#cart-quantity').val(quantity);

                // Submit the form via AJAX
                const formData = $('#addtocart-form').serialize();

                $.ajax({
                    url: "{{ route('cart.add') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Update cart count in navbar
                            $('.js-cart-items-count').text(response.cartCount);

                            // Show success message
                            showCartNotification(
                                '{{ $product->name }} berhasil ditambahkan ke keranjang Anda.',
                                true);

                            // Close the modal
                            $('#quantityModal').modal('hide');
                        } else {
                            alert(response.message || 'Gagal menambahkan produk ke keranjang');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Gagal menambahkan produk ke keranjang';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        showCartNotification(errorMsg, false);
                    }
                });
            });

            // === BUY NOW HANDLING ===

            // Handle "Beli Sekarang" button
            $('#buy-now').on('click', function() {
                // Cek apakah produk punya ukuran dan ukuran sudah dipilih
                if (hasProductSizes && !$('#selected-size-id').val()) {
                    $('#size-error').removeClass('d-none');
                    $('html, body').animate({
                        scrollTop: $("#size-buttons").offset().top - 100
                    }, 500);
                    return;
                }

                // Set quantity (default to 1 if not set)
                const quantity = 1;
                $('#buynow-quantity').val(quantity);

                // Submit the buy now form
                const formData = $('#buynow-form').serialize();

                $.ajax({
                    url: "{{ route('cart.add') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Redirect to cart/checkout
                            window.location.href = "{{ route('cart.index') }}";
                        } else {
                            alert(response.message || 'Gagal menambahkan produk ke keranjang');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Gagal menambahkan produk ke keranjang';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        alert(errorMsg);
                    }
                });
            });
        });
    </script>

    <!-- JavaScript for Wishlist and Share functionalities -->
    <script>
        $(document).ready(function() {
            // Function to show custom notification
            function showWishlistNotification(message, isSuccess = true) {
                const notification = $('#wishlist-notification');
                const title = $('#notification-title');
                const messageEl = $('#notification-message');

                // Set content
                messageEl.text(message);

                // Set type (success or removed)
                if (isSuccess) {
                    notification.removeClass('removed').addClass('success');
                    title.text('Ditambahkan ke Favorit');
                    $('.wishlist-notification__icon i').removeClass('fa-trash').addClass('fa-heart');
                } else {
                    notification.removeClass('success').addClass('removed');
                    title.text('Dihapus dari Favorit');
                    $('.wishlist-notification__icon i').removeClass('fa-heart').addClass('fa-trash');
                }

                // Show notification
                notification.css('display', 'flex').addClass('show');

                // Auto hide after 3 seconds
                setTimeout(() => {
                    notification.removeClass('show');
                    setTimeout(() => notification.css('display', 'none'), 300);
                }, 3000);
            }

            // Close notification button
            $('#close-notification').on('click', function() {
                const notification = $('#wishlist-notification');
                notification.removeClass('show');
                setTimeout(() => notification.css('display', 'none'), 300);
            });

            // Add to wishlist - with real-time UI updates
            $('#add-to-wishlist').on('click', function() {
                const form = $('#wishlist-form');
                const formData = form.serialize();
                const button = $(this);

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        // Add heart animation
                        button.find('svg').addClass('heart-beat');
                        setTimeout(() => button.find('svg').removeClass('heart-beat'), 800);

                        // Show success notification
                        showWishlistNotification(
                            '{{ $product->name }} berhasil ditambahkan ke daftar favorit Anda.',
                            true);

                        // Get the rowId from the response
                        const newRowId = response.rowId;

                        // The parent element that contains the form
                        const container = button.closest('.product-single__addtolinks');

                        // Replace the add form with the remove form
                        const removeForm = `
                        <form method="POST" action="" id="frm-remove-item">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="wishlist-btn in-wishlist" id="remove-from-wishlist">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 20 18" fill="#e53935">
                                    <path d="M10 18L8.55 16.7C3.4 12.1 0 9.1 0 5.5C0 2.5 2.42 0 5.5 0C7.24 0 8.91 0.81 10 2.09C11.09 0.81 12.76 0 14.5 0C17.58 0 20 2.5 20 5.5C20 9.1 16.6 12.1 11.45 16.7L10 18Z" />
                                </svg>
                                <span>Hapus dari Favorit</span>
                            </button>
                        </form>`;

                        // Replace the existing form
                        $('#wishlist-form').replaceWith(removeForm);

                        // Attach event listener to the new button
                        attachRemoveFromWishlistEvent();
                    },
                    error: function(xhr) {
                        let errorMsg = 'Gagal menambahkan ke favorit. Silakan coba lagi.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        showWishlistNotification(errorMsg, false);
                    }
                });
            });

            // Function to attach event listener to remove from wishlist button
            function attachRemoveFromWishlistEvent() {
                $('#remove-from-wishlist').on('click', function() {
                    const form = $(this).closest('form');

                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST', // We'll still use POST even though it's a DELETE request
                        data: form.serialize(),
                        success: function(response) {
                            // Show removed notification
                            showWishlistNotification(
                                'Produk berhasil dihapus dari daftar favorit Anda.', false);

                            // Replace the remove form with add form
                            const addForm = `
                            <form method="POST" action="{{ route('wishlist.add') }}" id="wishlist-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}" />
                                <input type="hidden" name="name" value="{{ $product->name }}" />
                                <input type="hidden" name="price" value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}" />
                                <input type="hidden" name="quantity" value="1" />
                                <button type="button" class="wishlist-btn" id="add-to-wishlist">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 20 18" fill="none" stroke="#555" stroke-width="1.5">
                                        <path d="M10 18L8.55 16.7C3.4 12.1 0 9.1 0 5.5C0 2.5 2.42 0 5.5 0C7.24 0 8.91 0.81 10 2.09C11.09 0.81 12.76 0 14.5 0C17.58 0 20 2.5 20 5.5C20 9.1 16.6 12.1 11.45 16.7L10 18Z" />
                                    </svg>
                                    <span>Tambahkan ke Favorit</span>
                                </button>
                            </form>`;

                            // Replace the current form
                            form.replaceWith(addForm);

                            // Add event listener to the new add button
                            $('#add-to-wishlist').on('click', function() {
                                const addForm = $('#wishlist-form');
                                const formData = addForm.serialize();
                                const button = $(this);

                                $.ajax({
                                    url: addForm.attr('action'),
                                    type: 'POST',
                                    data: formData,
                                    dataType: 'json',
                                    success: function(response) {
                                        // Implementation would go here (similar to the add-to-wishlist handler above)
                                        // For now, let's just reload the page to ensure everything is fresh
                                        location.reload();
                                    },
                                    error: function(xhr) {
                                        let errorMsg =
                                            'Gagal menambahkan ke favorit. Silakan coba lagi.';
                                        if (xhr.responseJSON && xhr
                                            .responseJSON.message) {
                                            errorMsg = xhr.responseJSON
                                                .message;
                                        }
                                        showWishlistNotification(errorMsg,
                                            false);
                                    }
                                });
                            });
                        },
                        error: function(xhr) {
                            let errorMsg = 'Gagal menghapus dari favorit. Silakan coba lagi.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            showWishlistNotification(errorMsg, false);
                        }
                    });
                });
            }

            // Initial attachment of remove event
            attachRemoveFromWishlistEvent();

            // Share functionality
            const shareButton = document.getElementById('shareButton');
            const shareMenu = document.getElementById('shareMenu');
            const closeShareMenu = document.getElementById('closeShareMenu');
            const copyLinkBtn = document.getElementById('copyLink');
            const copyFeedback = document.getElementById('copyFeedback');

            // Toggle share menu
            shareButton.addEventListener('click', function() {
                shareMenu.classList.toggle('active');
            });

            // Close share menu
            closeShareMenu.addEventListener('click', function() {
                shareMenu.classList.remove('active');
            });

            // Close share menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!shareButton.contains(event.target) && !shareMenu.contains(event.target)) {
                    shareMenu.classList.remove('active');
                }
            });

            // Copy link functionality
            copyLinkBtn.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                navigator.clipboard.writeText(url).then(function() {
                    copyFeedback.classList.add('active');
                    setTimeout(() => {
                        copyFeedback.classList.remove('active');
                    }, 2000);
                }).catch(function(err) {
                    // Fallback for older browsers
                    const tempInput = document.createElement('input');
                    tempInput.value = url;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);

                    copyFeedback.classList.add('active');
                    setTimeout(() => {
                        copyFeedback.classList.remove('active');
                    }, 2000);
                });
            });
        });
    </script>
@endpush

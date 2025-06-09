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

        /* Styling untuk notifikasi favorit - tambahkan ke CSS Anda */

        /* Favorit notification - mirip dengan cart notification tapi posisi di kanan atas */
        .favorit-notification {
            position: fixed;
            top: 190px;
            right: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            padding: 15px 20px;
            display: none;
            align-items: center;
            z-index: 1000;
            max-width: 350px;
            transition: transform 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55), opacity 0.3s ease;
            transform: translateY(-20px);
            opacity: 0;
            border-left: 4px solid #e53935;
        }

        .favorit-notification.success {
            border-left-color: #e53935;
        }

        .favorit-notification.removed {
            border-left-color: #607d8b;
        }

        .favorit-notification.show {
            transform: translateY(0);
            opacity: 1;
        }

        .favorit-notification__icon {
            margin-right: 15px;
            width: 30px;
            height: 30px;
            background: #fff2f2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .favorit-notification.success .favorit-notification__icon {
            color: #e53935;
        }

        .favorit-notification.removed .favorit-notification__icon {
            color: #607d8b;
            background: #f5f5f5;
        }

        .favorit-notification__content {
            flex: 1;
        }

        .favorit-notification__title {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 3px;
            color: #333;
        }

        .favorit-notification.success .favorit-notification__title {
            color: #e53935;
        }

        .favorit-notification.removed .favorit-notification__title {
            color: #607d8b;
        }

        .favorit-notification__message {
            font-size: 13px;
            color: #666;
        }

        .favorit-notification__close {
            background: transparent;
            border: none;
            color: #aaa;
            cursor: pointer;
            padding: 5px;
            margin-left: 5px;
            font-size: 16px;
            transition: color 0.2s;
        }

        .favorit-notification__close:hover {
            color: #e53935;
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

        /* Tambahkan styles untuk tombol wishlist yang lebih baik */
        .wishlist-btn {
            transition: all 0.3s ease;
        }

        .wishlist-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .wishlist-btn.in-wishlist {
            animation: pulse-heart 1s;
        }

        @keyframes pulse-heart {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Badge untuk counter di header */
        .cart-amount,
        .wishlist-amount {
            font-size: 10px;
            line-height: 15px;
            background-color: #e53935;
            color: white;
            border-radius: 50%;
            width: 15px;
            height: 15px;
            text-align: center;
            top: -5px;
            right: -5px;
            transition: all 0.3s ease;
        }

        .js-wishlist-count {
            transition: all 0.3s ease;
        }

        /* Counter animation */
        @keyframes count-pop {
            0% {
                transform: scale(0.5);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        .counter-animation {
            animation: count-pop 0.3s ease-out;
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
            top: 130px;
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

        /* Peningkatan desain notifikasi */
        .cart-notification {
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55), opacity 0.3s ease;
            z-index: 9999;
        }

        /* Notifikasi error yang lebih mencolok */
        .cart-notification.error {
            background: #fff;
            border-left: 4px solid #ff5252;
        }

        .cart-notification.error .cart-notification__icon {
            background: #fff2f2;
            color: #ff5252;
        }

        .cart-notification.error .cart-notification__title {
            color: #ff5252;
            font-weight: 600;
            font-size: 15px;
        }

        /* Tampilan stock level untuk indikator visual */
        .stock-level-indicator {
            height: 6px;
            width: 100%;
            background: #f0f0f0;
            border-radius: 3px;
            margin-top: 8px;
            overflow: hidden;
        }

        .stock-level-bar {
            height: 100%;
            transition: width 0.5s ease;
        }

        .stock-level-high {
            background: linear-gradient(to right, #4CAF50, #8BC34A);
        }

        .stock-level-medium {
            background: linear-gradient(to right, #FFC107, #FF9800);
        }

        .stock-level-low {
            background: linear-gradient(to right, #FF5722, #F44336);
        }

        /* Desain tombol aksi di notifikasi */
        .cart-notification__actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
            gap: 8px;
        }

        .cart-notification__action-btn {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .cart-notification__primary-btn {
            background-color: #956a3b;
            color: white;
        }

        .cart-notification__primary-btn:hover {
            background-color: #7d5931;
        }

        .cart-notification__secondary-btn {
            background-color: transparent;
            border-color: #6c757d;
            color: #6c757d;
        }

        .cart-notification__secondary-btn:hover {
            background-color: #f8f9fa;
        }

        /* Animasi untuk notifikasi */
        @keyframes attention-pulse {
            0% {
                box-shadow: 0 5px 15px rgba(255, 82, 82, 0.2);
            }

            50% {
                box-shadow: 0 5px 20px rgba(255, 82, 82, 0.35);
            }

            100% {
                box-shadow: 0 5px 15px rgba(255, 82, 82, 0.2);
            }
        }

        .cart-notification.error.show {
            animation: attention-pulse 1.5s ease-in-out infinite;
        }

        /* ===== RESPONSIVE ADJUSTMENTS ===== */

        /* Untuk header yang lebih tinggi */
        @media (min-width: 1200px) {

            .cart-notification,
            .favorit-notification {
                top: 130px;
                /* Sesuaikan jika header lebih tinggi di desktop */
                right: 30px;
            }
        }

        /* Untuk tablet */
        @media (max-width: 991px) {

            .cart-notification,
            .favorit-notification {
                top: 70px;
                /* Header biasanya lebih pendek di tablet */
                right: 15px;
                max-width: 350px;
                min-width: 280px;
            }
        }

        /* Untuk mobile */
        @media (max-width: 767px) {

            .cart-notification,
            .favorit-notification {
                top: 130px;
                /* Header mobile biasanya lebih kompak */
                right: 10px;
                left: 10px;
                /* Full width di mobile dengan margin */
                max-width: none;
                min-width: auto;
                width: calc(100% - 20px);
            }
        }

        /* Untuk mobile sangat kecil */
        @media (max-width: 480px) {

            .cart-notification,
            .favorit-notification {
                top: 55px;
                padding: 12px 16px;
                font-size: 14px;
            }

            .cart-notification__title,
            .favorit-notification__title {
                font-size: 13px;
            }

            .cart-notification__message,
            .favorit-notification__message {
                font-size: 12px;
            }
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
                            ( {{ $totalReviews > 1000 ? round($totalReviews / 1000, 1) . 'k+' : $totalReviews }} Ulasan)
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

                    <div class="stock-info d-flex align-items-center">
                        <span class="text-secondary fw-semibold me-2" style="font-size: 1rem;">
                            <i class="fas fa-box-open me-1"></i> Stok tersedia:
                        </span>
                        <span class="badge fw-bold rounded-pill px-3" id="main-stock-display"
                            style="background-color: #D2B48C; color: #fff; font-size: 0.9rem;">
                            @if ($product->sizes->count() > 0)
                            {{ $product->sizes->sum('pivot.stock') }} <!-- Total stok semua ukuran -->
                        @else
                            {{ $product->quantity - ($product->reserved_quantity ?? 0) }} <!-- Stok tersedia -->
                        @endif
                        </span>
                    </div>

                    <!-- Tambahan: Info stok per ukuran yang dipilih -->
                    <div class="size-specific-stock d-none mt-2" id="size-specific-stock">
                        <div class="d-flex align-items-center">
                            <span class="text-muted small me-2">
                                <i class="fas fa-info-circle me-1"></i>
                            </span>
                            <span class="badge bg-info text-white small" id="selected-size-stock-text">
                                Stok: 0
                            </span>
                        </div>
                    </div>
                    <!-- Hidden input untuk simpan stok ukuran yang dipilih -->
                    <input type="hidden" id="selected-size-stock" value="0">
                    <!-- Sebelum buttons "Tambahkan ke Keranjang" dan "Beli Sekarang" -->
                    <div class="product-single__addtocart">
                        @if ($product->sizes->count() > 0)
                            <div class="size-selector mb-3">
                                <label class="fw-semibold mb-2">Pilih Ukuran:</label>
                                <div class="d-flex flex-wrap gap-2" id="size-buttons">
                                    @foreach ($product->sizes as $size)
                                        <button type="button" class="btn size-btn" data-size-id="{{ $size->id }}"
                                            data-size-name="{{ $size->name }}" data-stock="{{ $size->pivot->stock }}"
                                            @if ($size->pivot->stock <= 0) disabled @endif
                                            style="border: 1px solid #d2b48c; color: #956a3b; background-color: white; min-width: 50px; padding: 8px 16px; border-radius: 4px;
                                               @if ($size->pivot->stock <= 0) opacity: 0.5; cursor: not-allowed; @endif">
                                            {{ $size->name }}
                                            <small class="d-block text-muted mt-1" style="font-size: 0.75rem;">
                                                @if ($size->pivot->stock > 0)
                                                Stok: {{ $size->pivot->stock }} <!-- Akan berkurang setelah pembelian -->
                                            @else
                                                <span class="text-danger">Habis</span>
                                            @endif
                                            </small>
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
                                                    class="fw-semibold" id="modal-available-stock">
                                                    @if ($product->sizes->count() > 0)
                                                        0 <!-- Akan diupdate via JavaScript saat ukuran dipilih -->
                                                    @else
                                                        {{ $product->quantity - ($product->reserved_quantity ?? 0) }}
                                                    @endif
                                                </span>
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
                                                    <img src="{{ asset($media->file_path) }}" alt="Review Media"
                                                        style="max-width: 100px; max-height: 100px; margin-right: 10px; border-radius: 5px; cursor: pointer;"
                                                        onclick="openImageModal('{{ asset($media->file_path) }}')">
                                                @elseif ($media->file_type === 'video')
                                                    <video controls
                                                        style="max-width: 200px; max-height: 150px; margin-right: 10px;">
                                                        <source src="{{ asset($media->file_path) }}" type="video/mp4">
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
                                        <div class="review-media mt-3">
                                            @foreach ($review->reviewMedia as $media)
                                                @if ($media->file_type === 'image')
                                                    <img src="{{ asset($media->file_path) }}"
                                                        alt="Review Media"
                                                        style="max-width: 100px; max-height: 100px; margin-right: 10px; border-radius: 5px; cursor: pointer;"
                                                        onclick="openImageModal('{{ asset($media->file_path) }}')">
                                                @elseif ($media->file_type === 'video')
                                                    <video controls
                                                        style="max-width: 200px; max-height: 150px; margin-right: 10px; border-radius: 5px;">
                                                        <source src="{{ asset($media->file_path) }}" type="video/mp4">
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
                            <div class="swiper-slide product-card"
                                data-stock="{{ $rproduct->quantity - $rproduct->reserved_quantity }}">
                                <div class="pc__img-wrapper">
                                    <!-- Tambahkan badge stok habis jika stok <= 0 -->
                                    @if ($rproduct->quantity - $rproduct->reserved_quantity <= 0)
                                        <div class="stock-badge">Stok Habis</div>
                                    @elseif($rproduct->quantity - $rproduct->reserved_quantity <= 5)
                                        <div class="stock-badge" style="background-color: #ff9800;">Stok Terbatas
                                            ({{ $rproduct->quantity - $rproduct->reserved_quantity }})
                                        </div>
                                    @endif

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

                                    <!-- Form add-to-cart dengan kondisi stok -->
                                    @if ($rproduct->quantity - $rproduct->reserved_quantity > 0)
                                        <!-- Tampilkan form normal jika stok tersedia -->
                                        <form name="addtocart-form" class="related-product-form" method="POST"
                                            action="{{ route('cart.add') }}">
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
                                    @else
                                        <!-- Tampilkan tombol disabled jika stok habis -->
                                        <div class="product-single__addtocart">
                                            <button type="button" disabled
                                                class="pc__atc btn anim_appear-bottom position-absolute border-0 text-uppercase fw-medium out-of-stock"
                                                style="background-color: #f5f5f5; color: #aaa; cursor: not-allowed;">
                                                <i class="fas fa-ban me-1"></i> Stok Habis
                                            </button>
                                        </div>
                                    @endif
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

                                    <!-- Tambahkan info stok -->
                                    <div class="product-stock-info mt-1">
                                        @if ($rproduct->quantity - $rproduct->reserved_quantity <= 0)
                                            {{-- Info stok kosong tidak ditampilkan untuk tidak mengulang badge --}}
                                        @elseif($rproduct->quantity - $rproduct->reserved_quantity <= 5)
                                            <small class="text-warning fw-semibold">
                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                Stok terbatas: {{ $rproduct->quantity - $rproduct->reserved_quantity }}
                                                tersisa
                                            </small>
                                        @endif
                                    </div>

                                    <!-- Wishlist Button Section - Disable jika stok habis -->
                                    @if ($rproduct->quantity - $rproduct->reserved_quantity > 0)
                                        <!-- Wishlist normal jika stok tersedia -->
                                        @if (\Surfsidemedia\Shoppingcart\Facades\Cart::instance('wishlist')->content()->where('id', $rproduct->id)->count() > 0)
                                            <form method="POST"
                                                action="{{ route('wishlist.remove', ['rowId' => \Surfsidemedia\Shoppingcart\Facades\Cart::instance('wishlist')->content()->Where('id', $rproduct->id)->first()->rowId]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 filled-heart"
                                                    title="Remove from Wishlist">
                                                    <svg width="16" height="16" viewBox="0 0 20 20"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_heart" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('wishlist.add') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $rproduct->id }}" />
                                                <input type="hidden" name="name" value="{{ $rproduct->name }}" />
                                                <input type="hidden" name="price"
                                                    value="{{ $rproduct->sale_price == '' ? $rproduct->regular_price : $rproduct->sale_price }}" />
                                                <input type="hidden" name="quantity" value="1" />
                                                <button type="submit"
                                                    class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                                    title="Tambahkan Ke Favorit">
                                                    <svg width="16" height="16" viewBox="0 0 20 20"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_heart" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <!-- Wishlist disabled jika stok habis -->
                                        <button type="button" disabled
                                            class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0"
                                            title="Produk tidak tersedia" style="opacity: 0.5; cursor: not-allowed;">
                                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart" />
                                            </svg>
                                        </button>
                                    @endif
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

                <!-- Indicator stok (opsional) -->
                <div class="stock-level-indicator d-none" id="stock-level-indicator">
                    <div class="stock-level-bar" id="stock-level-bar"></div>
                </div>

                <!-- Tombol aksi (opsional) -->
                <div class="cart-notification__actions d-none" id="cart-notification-actions">
                    <button class="cart-notification__action-btn cart-notification__secondary-btn"
                        id="notification-dismiss">Tutup</button>
                    <button class="cart-notification__action-btn cart-notification__primary-btn"
                        id="notification-action">Lihat Keranjang</button>
                </div>
            </div>
            <button class="cart-notification__close" id="close-cart-notification">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal untuk menampilkan gambar review -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Gambar Review</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="" id="modalImage" class="img-fluid" alt="Review Image">
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection

@push('scripts')
    <script>
        function openImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        }
    </script>

    <!-- Function to show cart notification -->
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

        // Fungsi notifikasi yang ditingkatkan
        function showEnhancedStockNotification(availableStock, requestedQuantity, productName, isOutOfStock = false) {
            // Dapatkan elemen notifikasi
            const notification = $('#cart-notification');
            const title = $('#cart-notification-title');
            const messageEl = $('#cart-notification-message');
            const stockIndicator = $('#stock-level-indicator');
            const stockBar = $('#stock-level-bar');
            const actions = $('#cart-notification-actions');

            // Set judul dan pesan berdasarkan kondisi stok
            if (isOutOfStock) {
                // Stok habis total
                title.text('Stok Tidak Tersedia');
                messageEl.html(
                    `<strong>${productName}</strong> sedang tidak tersedia. Silakan cek kembali nanti atau hubungi layanan pelanggan kami.`
                );

                // Tampilkan tombol aksi jika diinginkan
                actions.removeClass('d-none');
                $('#notification-action').text('Lihat Produk Serupa').attr('data-action', 'similar');
            } else {
                // Stok ada tapi kurang dari permintaan
                title.text('Stok Terbatas');
                messageEl.html(
                    `Maksimal pembelian <strong>${availableStock} item</strong> untuk produk ini.<br>Jumlah permintaan Anda (${requestedQuantity}) melebihi stok yang tersedia.`
                );

                // Tampilkan indikator stok
                stockIndicator.removeClass('d-none');

                // Hitung persentase stok dan atur warna
                const stockPercent = Math.min(availableStock / 10 * 100, 100); // Asumsi max stok 10 untuk indikator
                stockBar.css('width', `${stockPercent}%`);

                if (stockPercent > 60) {
                    stockBar.addClass('stock-level-high').removeClass('stock-level-medium stock-level-low');
                } else if (stockPercent > 30) {
                    stockBar.addClass('stock-level-medium').removeClass('stock-level-high stock-level-low');
                } else {
                    stockBar.addClass('stock-level-low').removeClass('stock-level-high stock-level-medium');
                }

                // Tampilkan tombol aksi
                actions.removeClass('d-none');
                $('#notification-action').text('Sesuaikan Kuantitas').attr('data-action', 'adjust');
            }

            // Atur tampilan notifikasi
            notification.removeClass('success').addClass('error');
            $('.cart-notification__icon i').removeClass('fa-shopping-cart').addClass('fa-exclamation-triangle');

            // Tampilkan notifikasi dengan animasi yang lebih menarik
            notification.css({
                'display': 'flex',
                'transform': 'translateY(-20px)',
                'opacity': '0'
            }).addClass('show');

            // Animasi masuk
            setTimeout(() => {
                notification.css({
                    'transform': 'translateY(0)',
                    'opacity': '1'
                });
            }, 10);

            // Auto hide setelah 5 detik
            setTimeout(() => {
                notification.css({
                    'transform': 'translateY(-20px)',
                    'opacity': '0'
                });
                setTimeout(() => notification.css('display', 'none'), 300);
            }, 5000);

            // Hapus kelas show untuk memungkinkan notifikasi muncul lagi
            setTimeout(() => {
                notification.removeClass('show');
            }, 5300);
        }

        // Fungsi pemeriksaan stok yang ditingkatkan
        function enhancedStockCheck(requestedQuantity, availableStock, productName) {
            // Untuk produk dengan ukuran, gunakan stok ukuran yang dipilih
            if ({{ $product->sizes->count() > 0 ? 'true' : 'false' }}) {
                const selectedSizeId = $('#selected-size-id').val();
                if (!selectedSizeId) {
                    showCartNotification('Silakan pilih ukuran terlebih dahulu', false);
                    return false;
                }

                // Ambil stok dari tombol ukuran yang dipilih
                const selectedSizeBtn = $(`.size-btn[data-size-id="${selectedSizeId}"]`);
                availableStock = selectedSizeBtn.data('stock') || 0;
            }

            if (availableStock <= 0) {
                showEnhancedStockNotification(0, requestedQuantity, productName, true);
                updateButtonsForOutOfStock(true);
                return false;
            } else if (requestedQuantity > availableStock) {
                showEnhancedStockNotification(availableStock, requestedQuantity, productName, false);

                if ($('.modal-qty-input').length) {
                    $('.modal-qty-input').val(availableStock).trigger('change');
                }
                return false;
            }

            return true;
        }

        // Fungsi untuk memperbarui tampilan tombol ketika stok habis
        function updateButtonsForOutOfStock(isOutOfStock) {
            if (isOutOfStock) {
                // Disable tombol dan ubah tampilannya
                $('#open-quantity-modal, #buy-now').prop('disabled', true)
                    .addClass('out-of-stock')
                    .css({
                        'background-color': '#f5f5f5',
                        'border-color': '#ddd',
                        'color': '#aaa',
                        'cursor': 'not-allowed'
                    });

                // Ubah teks tombol
                $('#open-quantity-modal').html('<i class="fas fa-ban me-2"></i> Stok Habis');
                $('#buy-now').html('<i class="fas fa-exclamation-circle me-2"></i> Tidak Tersedia');

                // Tambahkan tooltip
                $('#open-quantity-modal, #buy-now').attr('data-bs-toggle', 'tooltip')
                    .attr('data-bs-placement', 'top')
                    .attr('title', 'Produk ini sedang tidak tersedia. Silakan cek kembali nanti.');

                // Initialize tooltips jika Bootstrap sudah dimuat
                if (typeof bootstrap !== 'undefined') {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                    tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                }
            } else {
                // Kembalikan ke tampilan normal jika stok tersedia kembali
                $('#open-quantity-modal, #buy-now').prop('disabled', false)
                    .removeClass('out-of-stock')
                    .removeAttr('data-bs-toggle')
                    .removeAttr('data-bs-placement')
                    .removeAttr('title');

                $('#open-quantity-modal').html('<i class="fas fa-shopping-cart me-2"></i> Tambahkan ke Keranjang')
                    .css({
                        'background-color': 'rgba(149, 106, 59, 0.2)',
                        'border': '1px solid #956a3b',
                        'color': '#956a3b',
                        'cursor': 'pointer'
                    });

                $('#buy-now').html('Beli Sekarang')
                    .css({
                        'background-color': '#956a3b',
                        'border-color': '#956a3b',
                        'color': '#ffffff',
                        'cursor': 'pointer'
                    });
            }
        }

        // Close notification button
        $('#close-cart-notification').on('click', function() {
            const notification = $('#cart-notification');
            notification.removeClass('show');
            setTimeout(() => notification.css('display', 'none'), 300);
        });

        // Event handler untuk tombol aksi di notifikasi
        $(document).ready(function() {
            // Handler untuk tombol dismiss
            $(document).on('click', '#notification-dismiss', function() {
                $('#cart-notification').removeClass('show');
                setTimeout(() => $('#cart-notification').css('display', 'none'), 300);
            });

            // Handler untuk tombol aksi utama
            $(document).on('click', '#notification-action', function() {
                const action = $(this).attr('data-action');

                if (action === 'adjust') {
                    // Buka kembali modal kuantitas dengan nilai maksimal
                    $('#cart-notification').removeClass('show');
                    setTimeout(() => {
                        $('#cart-notification').css('display', 'none');
                        $('#quantityModal').modal('show');
                    }, 300);
                } else if (action === 'similar') {
                    // Redirect ke halaman produk serupa (kategori yang sama)
                    window.location.href =
                        "{{ route('shop.index', ['category' => $product->category->slug]) }}";
                }
            });

            // Periksa stok saat halaman dimuat
            const initialStock = {{ $product->quantity - $product->reserved_quantity }};

            // Jika stok kosong, update tampilan tombol
            if (initialStock <= 0) {
                updateButtonsForOutOfStock(true);
            }

            // Jika stok sangat terbatas (misalnya kurang dari 5)
            else if (initialStock < 5) {
                // Tampilkan peringatan stok terbatas
                const stockWarning = `
            <div class="alert alert-warning mt-3 d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>
                    <strong>Stok Terbatas!</strong> Tersisa hanya ${initialStock} item.
                </div>
            </div>
        `;
                if (!$('.alert-warning').length) {
                    $('.product-single__addtocart').before(stockWarning);
                }
            }
        });
    </script>

    <!-- Function to show cart notification Tombol Beli Sekarang -->
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

    <!-- Function modals -->
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

    <!-- Function to initialize tooltips and track product navigation -->
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

    <!-- Function to handle size selection and stock updates -->
    <script>
        $(document).ready(function() {
            // Inisialisasi variabel untuk simpan stok yang tersedia
            const hasProductSizes = {{ $product->sizes->count() > 0 ? 'true' : 'false' }};
            let selectedSizeStock = 0;

            // Fungsi untuk mengupdate informasi stok berdasarkan ukuran yang dipilih
            function updateStockInfo(sizeId, sizeName, stock) {
                selectedSizeStock = stock;
                $('#selected-size-stock').val(stock);

                // Update tampilan stok spesifik ukuran
                let stockClass = 'bg-info';
                let stockText = `Stok ${sizeName}: ${stock}`;

                if (stock <= 0) {
                    stockClass = 'bg-danger';
                    stockText = `${sizeName}: Habis`;
                } else if (stock <= 5) {
                    stockClass = 'bg-warning text-dark';
                    stockText = `Stok ${sizeName}: ${stock} (Terbatas)`;
                }

                $('#selected-size-stock-text')
                    .removeClass('bg-info bg-warning bg-danger text-dark text-white')
                    .addClass(stockClass)
                    .text(stockText);
                $('#size-specific-stock').removeClass('d-none');

                // PERBAIKAN: Update max quantity dengan stok yang tepat
                $('#modal-available-stock').text(stock);
                $('.modal-qty-input').attr('max', stock);

                // Reset quantity jika melebihi stok
                const currentQty = parseInt($('.modal-qty-input').val());
                if (currentQty > stock) {
                    $('.modal-qty-input').val(Math.min(1, stock));
                }

                // Update tombol berdasarkan stok
                if (stock <= 0) {
                    $('#open-quantity-modal, #buy-now').prop('disabled', true)
                        .css('opacity', '0.6')
                        .attr('title', 'Stok tidak tersedia untuk ukuran ini');
                } else {
                    $('#open-quantity-modal, #buy-now').prop('disabled', false)
                        .css('opacity', '1')
                        .removeAttr('title');
                }
            }

            // Handle klik tombol ukuran
            $('.size-btn').on('click', function() {
                // Dapatkan informasi ukuran
                const sizeId = $(this).data('size-id');
                const sizeName = $(this).data('size-name');
                const stock = $(this).data('stock');

                // Reset semua tombol ukuran
                $('.size-btn').removeClass('active')
                    .css({
                        'background-color': 'white',
                        'color': '#956a3b'
                    });

                // Aktifkan tombol ukuran yang dipilih
                $(this).addClass('active')
                    .css({
                        'background-color': '#956a3b',
                        'color': 'white'
                    });

                // Update hidden inputs
                $('#selected-size-id').val(sizeId);
                $('#cart-size-id').val(sizeId);
                $('#buynow-size-id').val(sizeId);

                // Update informasi ukuran yang dipilih
                $('#size-name').text(sizeName);
                $('#selected-size-info').removeClass('d-none');
                $('#size-error').addClass('d-none');

                // Update informasi stok
                updateStockInfo(sizeId, sizeName, stock);

                // Perbarui informasi ukuran di modal
                $('#modal-size-name').text(sizeName);
            });

            // Handle klik tombol ukuran - PERBAIKAN
            $('.size-btn').on('click', function() {
                // Jangan proses jika tombol disabled (stok habis)
                if ($(this).prop('disabled')) {
                    return false;
                }

                // Dapatkan informasi ukuran
                const sizeId = $(this).data('size-id');
                const sizeName = $(this).data('size-name');
                const stock = $(this).data('stock');

                // Reset semua tombol ukuran
                $('.size-btn').removeClass('active')
                    .css({
                        'background-color': 'white',
                        'color': '#956a3b'
                    });

                // Aktifkan tombol ukuran yang dipilih (hanya jika ada stok)
                if (stock > 0) {
                    $(this).addClass('active')
                        .css({
                            'background-color': '#956a3b',
                            'color': 'white'
                        });

                    // Update hidden inputs
                    $('#selected-size-id').val(sizeId);
                    $('#cart-size-id').val(sizeId);
                    $('#buynow-size-id').val(sizeId);

                    // Update informasi ukuran yang dipilih
                    $('#size-name').text(sizeName);
                    $('#selected-size-info').removeClass('d-none');
                    $('#size-error').addClass('d-none');

                    // Update informasi stok
                    updateStockInfo(sizeId, sizeName, stock);

                    // Perbarui informasi ukuran di modal
                    $('#modal-size-name').text(sizeName);
                } else {
                    // Jika stok habis, tampilkan peringatan
                    showCartNotification(`Stok untuk ukuran ${sizeName} tidak tersedia`, false);
                }
            });

            // Tombol tambah/kurang kuantitas di modal
            $('.modal-reduce-qty').on('click', function() {
                let qty = parseInt($('.modal-qty-input').val());
                if (qty > 1) {
                    $('.modal-qty-input').val(qty - 1);
                }
            });

            $('.modal-increase-qty').on('click', function() {
                let qty = parseInt($('.modal-qty-input').val());
                let max = parseInt($('.modal-qty-input').attr('max'));

                // Pastikan max diset dengan benar
                if (hasProductSizes) {
                    max = selectedSizeStock;
                }

                if (qty < max) {
                    $('.modal-qty-input').val(qty + 1);
                }
            });

            // Validasi input kuantitas langsung
            $('.modal-qty-input').on('change', function() {
                let qty = parseInt($(this).val());
                let max = parseInt($(this).attr('max'));

                // Pastikan max diset dengan benar
                if (hasProductSizes) {
                    max = selectedSizeStock;
                }

                if (qty < 1) {
                    $(this).val(1);
                } else if (qty > max) {
                    $(this).val(max);
                    showCartNotification(`Stok hanya tersedia ${max} unit untuk ukuran ini`, false);
                }
            });

            // Tombol buka modal quantity
            $('#open-quantity-modal').on('click', function() {
                // Cek apakah produk punya ukuran dan ukuran sudah dipilih
                if (hasProductSizes && !$('#selected-size-id').val()) {
                    $('#size-error').removeClass('d-none');
                    $('html, body').animate({
                        scrollTop: $("#size-buttons").offset().top - 100
                    }, 500);
                    return;
                }

                // Update modal dengan informasi ukuran yang dipilih
                if (hasProductSizes) {
                    const sizeId = $('#selected-size-id').val();
                    const sizeName = $('#size-name').text();

                    // Update UI modal
                    $('#modal-size-name').text(sizeName);
                    $('#modal-size-info').removeClass('d-none');

                    // Update stok tersedia di modal
                    $('#modal-available-stock').text(selectedSizeStock);
                    $('.modal-qty-input').attr('max', selectedSizeStock);
                }

                // Reset quantity ke 1
                $('.modal-qty-input').val(1);

                // Tampilkan modal
                $('#quantityModal').modal('show');
            });

            // Tombol konfirmasi tambah ke keranjang
            $('#confirmAddToCart').on('click', function() {
                const quantity = parseInt($('.modal-qty-input').val());
                const productName = "{{ $product->name }}";

                let availableStock;

                // PERBAIKAN: Gunakan stok per ukuran
                if ({{ $product->sizes->count() > 0 ? 'true' : 'false' }}) {
                    const selectedSizeId = $('#selected-size-id').val();
                    if (!selectedSizeId) {
                        showCartNotification('Silakan pilih ukuran terlebih dahulu', false);
                        return;
                    }

                    const selectedSizeBtn = $(`.size-btn[data-size-id="${selectedSizeId}"]`);
                    availableStock = selectedSizeBtn.data('stock') || 0;
                } else {
                    availableStock = {{ $product->quantity - ($product->reserved_quantity ?? 0) }};
                }

                // Periksa stok dengan fungsi yang sudah diperbaiki
                if (!enhancedStockCheck(quantity, availableStock, productName)) {
                    return;
                }
                // Update quantity di form
                $('#cart-quantity').val(quantity);

                // Submit form via AJAX
                const formData = $('#addtocart-form').serialize();

                $.ajax({
                    url: "{{ route('cart.add') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Update cart count di navbar
                            $('.js-cart-items-count').text(response.cartCount);

                            // Tampilkan notifikasi sukses
                            showCartNotification(
                                '{{ $product->name }} berhasil ditambahkan ke keranjang Anda.',
                                true);

                            // Tutup modal
                            $('#quantityModal').modal('hide');
                        } else {
                            showCartNotification(response.message ||
                                'Gagal menambahkan produk ke keranjang', false);
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

            // Tombol Beli Sekarang
            $('#buy-now').on('click', function() {
                // Cek ukuran untuk produk yang memiliki size
                if ({{ $product->sizes->count() > 0 ? 'true' : 'false' }}) {
                    const selectedSizeId = $('#selected-size-id').val();
                    if (!selectedSizeId) {
                        $('#size-error').removeClass('d-none');
                        $('html, body').animate({
                            scrollTop: $("#size-buttons").offset().top - 100
                        }, 500);
                        return;
                    }

                    // Ambil stok dari ukuran yang dipilih
                    const selectedSizeBtn = $(`.size-btn[data-size-id="${selectedSizeId}"]`);
                    const availableStock = selectedSizeBtn.data('stock') || 0;

                    // Validasi stok
                    if (availableStock <= 0) {
                        const sizeName = selectedSizeBtn.data('size-name');
                        showCartNotification(`Ukuran ${sizeName} tidak tersedia`, false);
                        return;
                    }
                }

                // Set default quantity
                const quantity = 1;
                const productName = "{{ $product->name }}";


                // Validasi stok dengan fungsi yang ditingkatkan
                let availableStock;
                if ({{ $product->sizes->count() > 0 ? 'true' : 'false' }}) {
                    availableStock = parseInt(selectedSizeStock);
                } else {
                    availableStock = {{ $product->quantity - $product->reserved_quantity }};
                }

                // Periksa stok dengan fungsi baru kita
                if (!enhancedStockCheck(quantity, availableStock, productName)) {
                    return;
                }

                // Update quantity di form
                $('#buynow-quantity').val(quantity);

                // Submit form via AJAX
                const formData = $('#buynow-form').serialize();

                $.ajax({
                    url: "{{ route('cart.add') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Redirect ke checkout
                            window.location.href = "{{ route('cart.index') }}";
                        } else {
                            showCartNotification(response.message ||
                                'Gagal menambahkan produk ke keranjang', false);
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
        });
    </script>

    <!-- Function to update main stock display -->
    <script>
        // Fungsi untuk update tampilan stok utama
        function updateMainStockDisplay() {
            if (hasProductSizes) {
                // Jika ada ukuran yang dipilih, tampilkan stok ukuran tersebut
                if (selectedSizeStock > 0) {
                    $('#main-stock-display').text(selectedSizeStock);
                } else {
                    // Tampilkan total stok semua ukuran
                    const totalStock = {{ $product->sizes->sum('pivot.stock') }};
                    $('#main-stock-display').text(totalStock);
                }
            } else {
                // Untuk produk tanpa ukuran
                const stock = {{ $product->quantity - ($product->reserved_quantity ?? 0) }};
                $('#main-stock-display').text(stock);
            }
        }

        // Panggil fungsi ini setiap kali ukuran berubah
        $(document).ready(function() {
            updateMainStockDisplay();
        });
    </script>

    <!-- JavaScript for Wishlist functionalities -->
    <script>
        // Script untuk perbaikan favorit/wishlist

        $(document).ready(function() {
            // Function to show favorit notification di atas kanan seperti cart
            function showFavoritNotification(message, isSuccess = true) {
                // Cek apakah notifikasi sudah ada, jika belum tambahkan ke body
                if (!$('#favorit-notification').length) {
                    $('body').append(`
                <div class="favorit-notification" id="favorit-notification">
                    <div class="favorit-notification__icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="favorit-notification__content">
                        <div class="favorit-notification__title" id="favorit-notification-title">Ditambahkan ke Favorit</div>
                        <div class="favorit-notification__message" id="favorit-notification-message"></div>
                    </div>
                    <button class="favorit-notification__close" id="close-favorit-notification">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `);

                    // Tambahkan event handler untuk tombol close
                    $(document).on('click', '#close-favorit-notification', function() {
                        $('#favorit-notification').removeClass('show');
                        setTimeout(function() {
                            $('#favorit-notification').css('display', 'none');
                        }, 300);
                    });
                }

                const notification = $('#favorit-notification');
                const title = $('#favorit-notification-title');
                const messageEl = $('#favorit-notification-message');

                // Set content
                messageEl.text(message);

                // Set type (success or error)
                if (isSuccess) {
                    notification.removeClass('removed').addClass('success');
                    title.text('Ditambahkan ke Favorit');
                    $('.favorit-notification__icon i').removeClass('fa-trash').addClass('fa-heart');
                } else {
                    notification.removeClass('success').addClass('removed');
                    title.text('Dihapus dari Favorit');
                    $('.favorit-notification__icon i').removeClass('fa-heart').addClass('fa-trash');
                }

                // Show notification
                notification.css('display', 'flex').addClass('show');

                // Auto hide after 3 seconds
                setTimeout(function() {
                    notification.removeClass('show');
                    setTimeout(function() {
                        notification.css('display', 'none');
                    }, 300);
                }, 3000);
            }

            // Function to update wishlist count in both desktop and mobile headers
            function updateWishlistCount(count) {
                $('.js-wishlist-items-count').text(count > 0 ? count : '');
                $('.js-wishlist-count').text(count > 0 ? count : '');
            }

            // Handle add to wishlist button
            $(document).on('click', '#add-to-wishlist', function(e) {
                e.preventDefault();
                const form = $('#wishlist-form');
                const button = $(this);
                const formData = form.serialize();

                // Add loading state
                button.prop('disabled', true).css('opacity', '0.7');

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        // Remove loading state
                        button.prop('disabled', false).css('opacity', '1');

                        // Add heart beat animation
                        button.find('svg').addClass('heart-beat');
                        setTimeout(function() {
                            button.find('svg').removeClass('heart-beat');
                        }, 800);

                        // Show success notification dengan style baru
                        showFavoritNotification(
                            'Produk berhasil ditambahkan ke daftar favorit Anda.', true);

                        // Update wishlist count
                        updateWishlistCount(response.count || parseInt($(
                            '.js-wishlist-items-count').text()) + 1);

                        // Replace the button with remove from wishlist button
                        const removeForm = `
                <form method="POST" action="${response.removeUrl || '#'}" id="frm-remove-item">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="rowId" value="${response.rowId || ''}">
                    <button type="button" class="wishlist-btn in-wishlist" id="remove-from-wishlist">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 20 18" fill="#e53935">
                            <path d="M10 18L8.55 16.7C3.4 12.1 0 9.1 0 5.5C0 2.5 2.42 0 5.5 0C7.24 0 8.91 0.81 10 2.09C11.09 0.81 12.76 0 14.5 0C17.58 0 20 2.5 20 5.5C20 9.1 16.6 12.1 11.45 16.7L10 18Z" />
                        </svg>
                        <span>Hapus dari Favorit</span>
                    </button>
                </form>`;

                        // Replace form
                        $('#wishlist-form').replaceWith(removeForm);
                    },
                    error: function(xhr) {
                        // Remove loading state
                        button.prop('disabled', false).css('opacity', '1');

                        let errorMsg = 'Gagal menambahkan ke favorit. Silakan coba lagi.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }

                        // Show error notification
                        showFavoritNotification(errorMsg, false);
                    }
                });
            });

            // Handle remove from wishlist button
            $(document).on('click', '#remove-from-wishlist', function(e) {
                e.preventDefault();
                const form = $(this).closest('form');
                const button = $(this);

                // Add loading state
                button.prop('disabled', true).css('opacity', '0.7');

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        // Remove loading state
                        button.prop('disabled', false).css('opacity', '1');

                        // Show removed notification
                        showFavoritNotification(
                            'Produk berhasil dihapus dari daftar favorit Anda.', false);

                        // Update wishlist count
                        const currentCount = parseInt($('.js-wishlist-items-count').text());
                        updateWishlistCount(response.count || Math.max(0, currentCount - 1));

                        // Replace with add to wishlist button
                        const productId = form.find('input[name="id"]').val() || response
                            .productId;
                        const productName = response.productName || '';
                        const productPrice = response.productPrice || 0;

                        const addForm = `
                <form method="POST" action="/wishlist/add" id="wishlist-form">
                    @csrf
                    <input type="hidden" name="id" value="${productId}" />
                    <input type="hidden" name="name" value="${productName}" />
                    <input type="hidden" name="price" value="${productPrice}" />
                    <input type="hidden" name="quantity" value="1" />
                    <button type="button" class="wishlist-btn" id="add-to-wishlist">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 20 18" fill="none" stroke="#555" stroke-width="1.5">
                            <path d="M10 18L8.55 16.7C3.4 12.1 0 9.1 0 5.5C0 2.5 2.42 0 5.5 0C7.24 0 8.91 0.81 10 2.09C11.09 0.81 12.76 0 14.5 0C17.58 0 20 2.5 20 5.5C20 9.1 16.6 12.1 11.45 16.7L10 18Z" />
                        </svg>
                        <span>Tambahkan ke Favorit</span>
                    </button>
                </form>`;

                        // Replace form
                        form.replaceWith(addForm);
                    },
                    error: function(xhr) {
                        // Remove loading state
                        button.prop('disabled', false).css('opacity', '1');

                        let errorMsg = 'Gagal menghapus dari favorit. Silakan coba lagi.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }

                        // Show error notification
                        showFavoritNotification(errorMsg, false);
                    }
                });
            });

            // Additional cleanup for wishlist form handling
            $(document).on('submit', '#wishlist-form', function(e) {
                e.preventDefault();
                $('#add-to-wishlist').trigger('click');
            });

            $(document).on('submit', '#frm-remove-item', function(e) {
                e.preventDefault();
                $('#remove-from-wishlist').trigger('click');
            });
        });
    </script>

    <!-- JavaScript for Wishlist functionalities -->
    <script>
        // Menambahkan kode ini ke file JavaScript produk detail (misalnya di bawah script notifikasi Cart)

        $(document).ready(function() {
            // Perubahan untuk interaksi wishlist di halaman detail produk

            // Tambah ke wishlist
            $('#add-to-wishlist').on('click', function(e) {
                e.preventDefault();
                const form = $('#wishlist-form');
                const formData = form.serialize();

                // Tambahkan efek loading/disabled pada tombol
                $(this).prop('disabled', true);

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Update jumlah wishlist di navbar
                            $('.js-wishlist-items-count').text(response.count).addClass(
                                'counter-animation');

                            // Tampilkan notifikasi sukses
                            showFavoritNotification(
                                'Produk berhasil ditambahkan ke daftar favorit Anda.', true);

                            // Ganti tombol Add dengan tombol Remove
                            const removeForm = `
                    <form method="POST" action="${response.removeUrl}" id="frm-remove-item">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="wishlist-btn in-wishlist" id="remove-from-wishlist">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 20 18" fill="#e53935">
                                <path d="M10 18L8.55 16.7C3.4 12.1 0 9.1 0 5.5C0 2.5 2.42 0 5.5 0C7.24 0 8.91 0.81 10 2.09C11.09 0.81 12.76 0 14.5 0C17.58 0 20 2.5 20 5.5C20 9.1 16.6 12.1 11.45 16.7L10 18Z" />
                            </svg>
                            <span>Hapus dari Favorit</span>
                        </button>
                    </form>`;

                            $('#wishlist-form').replaceWith(removeForm);

                            // Tambahkan event handler untuk tombol remove
                            attachRemoveHandler();
                        }
                    },
                    error: function(xhr) {
                        // Tampilkan pesan error
                        let errorMsg = 'Gagal menambahkan ke favorit. Silakan coba lagi.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }

                        // Gunakan fungsi notifikasi
                        showFavoritNotification(errorMsg, false);
                    },
                    complete: function() {
                        // Hapus efek loading
                        $('#add-to-wishlist').prop('disabled', false);
                    }
                });
            });

            // Fungsi untuk menambahkan event handler pada tombol remove
            function attachRemoveHandler() {
                $('#remove-from-wishlist').on('click', function(e) {
                    e.preventDefault();
                    const form = $('#frm-remove-item');

                    // Tambahkan efek loading
                    $(this).prop('disabled', true);

                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Update jumlah wishlist di navbar
                                $('.js-wishlist-items-count').text(response.count || '')
                                    .addClass('counter-animation');

                                // Tampilkan notifikasi sukses
                                showFavoritNotification(
                                    'Produk berhasil dihapus dari daftar favorit Anda.',
                                    false);

                                // Ganti tombol Remove dengan tombol Add
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

                                $('#frm-remove-item').replaceWith(addForm);

                                // Tambahkan event handler untuk tombol add yang baru
                                $('#add-to-wishlist').on('click', function() {
                                    $(this).off(
                                        'click'
                                    ); // Hapus handler sebelumnya untuk menghindari duplikasi
                                    $('#add-to-wishlist').trigger(
                                        'click'); // Terapkan handler utama
                                });
                            }
                        },
                        error: function(xhr) {
                            // Tampilkan pesan error
                            let errorMsg = 'Gagal menghapus dari favorit. Silakan coba lagi.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }

                            // Gunakan fungsi notifikasi
                            showFavoritNotification(errorMsg, false);
                        },
                        complete: function() {
                            // Hapus efek loading
                            $('#remove-from-wishlist').prop('disabled', false);
                        }
                    });
                });
            }

            // Implementasi fungsi untuk menampilkan notifikasi favorit
            function showFavoritNotification(message, isSuccess = true) {
                // Cek apakah notifikasi sudah ada, jika belum tambahkan ke body
                if (!$('#favorit-notification').length) {
                    $('body').append(`
                <div class="favorit-notification" id="favorit-notification">
                    <div class="favorit-notification__icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="favorit-notification__content">
                        <div class="favorit-notification__title" id="favorit-notification-title">Ditambahkan ke Favorit</div>
                        <div class="favorit-notification__message" id="favorit-notification-message"></div>
                    </div>
                    <button class="favorit-notification__close" id="close-favorit-notification">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `);

                    // Tambahkan event handler untuk tombol close
                    $(document).on('click', '#close-favorit-notification', function() {
                        $('#favorit-notification').removeClass('show');
                        setTimeout(function() {
                            $('#favorit-notification').css('display', 'none');
                        }, 300);
                    });
                }

                const notification = $('#favorit-notification');
                const title = $('#favorit-notification-title');
                const messageEl = $('#favorit-notification-message');

                // Set content
                messageEl.text(message);

                // Set type (success or error)
                if (isSuccess) {
                    notification.removeClass('removed').addClass('success');
                    title.text('Ditambahkan ke Favorit');
                    $('.favorit-notification__icon i').removeClass('fa-trash').addClass('fa-heart');
                } else {
                    notification.removeClass('success').addClass('removed');
                    title.text('Dihapus dari Favorit');
                    $('.favorit-notification__icon i').removeClass('fa-heart').addClass('fa-trash');
                }

                // Show notification
                notification.css('display', 'flex').addClass('show');

                // Auto hide after 3 seconds
                setTimeout(function() {
                    notification.removeClass('show');
                    setTimeout(function() {
                        notification.css('display', 'none');
                    }, 300);
                }, 3000);
            }

            // Initialize handlers jika tombol sudah ada di halaman
            if ($('#remove-from-wishlist').length) {
                attachRemoveHandler();
            }
        });
    </script>

    <!-- JavaScript for Share functionalities -->
    <script>
        // Share button functionality
        $(document).ready(function() {
            // Initialize share button functionality
            const shareButton = $('#shareButton');
            const shareMenu = $('#shareMenu');
            const closeShareMenu = $('#closeShareMenu');
            const copyLinkBtn = $('#copyLink');
            const copyFeedback = $('#copyFeedback');

            // Toggle share menu
            shareButton.on('click', function(e) {
                e.stopPropagation();
                shareMenu.toggleClass('active');
            });

            // Close share menu
            closeShareMenu.on('click', function() {
                shareMenu.removeClass('active');
            });

            // Close share menu when clicking outside
            $(document).on('click', function(e) {
                if (!shareButton[0].contains(e.target) && !shareMenu[0].contains(e.target)) {
                    shareMenu.removeClass('active');
                }
            });

            // Copy link functionality
            copyLinkBtn.on('click', function() {
                const url = $(this).data('url');

                try {
                    navigator.clipboard.writeText(url).then(function() {
                        copyFeedback.addClass('active');
                        setTimeout(() => {
                            copyFeedback.removeClass('active');
                        }, 2000);
                    });
                } catch (err) {
                    // Fallback for older browsers
                    const tempInput = $('<input>');
                    $('body').append(tempInput);
                    tempInput.val(url).select();
                    document.execCommand('copy');
                    tempInput.remove();

                    copyFeedback.addClass('active');
                    setTimeout(() => {
                        copyFeedback.removeClass('active');
                    }, 2000);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // ======================================================================
            // PERBAIKAN FUNGSI TAMBAH KE KERANJANG PADA PRODUK TERKAIT
            // ======================================================================

            // Ambil data produk untuk cek stok
            $.ajax({
                url: `/api/product/${productId}/check-stock`,
                type: 'GET',
                success: function(response) {
                    // Jika tidak ada API endpoint untuk cek stok, bisa menggunakan quantity dari form
                    const availableStock = response ? response.available_stock : 1;

                    if (availableStock <= 0) {
                        // Tampilkan notifikasi stok kosong
                        showCartNotification(`Stok produk ${productName} tidak tersedia.`,
                            false);
                        return;
                    }

                    // Lanjutkan dengan tambah ke keranjang jika stok tersedia
                    $.ajax({
                        url: '/cart/add',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Update jumlah item di cart navbar
                                $('.js-cart-items-count').text(response
                                    .cartCount);

                                // Tampilkan notifikasi sukses
                                showCartNotification(
                                    `${productName} berhasil ditambahkan ke keranjang Anda.`,
                                    true);
                            } else {
                                showCartNotification(response.message ||
                                    'Gagal menambahkan produk ke keranjang',
                                    false);
                            }
                        },
                        error: function(xhr) {
                            let errorMsg =
                                'Gagal menambahkan produk ke keranjang';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            showCartNotification(errorMsg, false);
                        }
                    });
                },
                error: function() {
                    // Jika endpoint cek stok tidak ada, langsung lakukan tambah ke keranjang
                    addToCartWithoutStockCheck(formData, productName);
                }
            });
        });

        // Fungsi tambah ke keranjang tanpa cek stok (fallback)
        function addToCartWithoutStockCheck(formData, productName) {
            $.ajax({
                url: '/cart/add',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Update jumlah item di cart navbar
                        $('.js-cart-items-count').text(response.cartCount);

                        // Tampilkan notifikasi sukses
                        showCartNotification(
                            `${productName} berhasil ditambahkan ke keranjang Anda.`, true);
                    } else {
                        showCartNotification(response.message ||
                            'Gagal menambahkan produk ke keranjang', false);
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
        }

        // ======================================================================
        // PERBAIKAN FUNGSI WISHLIST PADA PRODUK TERKAIT
        // ======================================================================

        // Fungsi untuk menangani klik pada ikon wishlist produk terkait
        $('.pc__btn-wl').on('click', function(e) {
            e.preventDefault();

            const productCard = $(this).closest('.product-card');
            const productId = productCard.find('input[name="id"]').val();
            const productName = productCard.find('input[name="name"]').val();
            const productPrice = productCard.find('input[name="price"]').val();

            // Cek apakah sudah di wishlist (berdasarkan class)
            const isInWishlist = $(this).hasClass('in-wishlist');

            if (isInWishlist) {
                // Jika sudah di wishlist, hapus dari wishlist
                removeFromWishlist(this);
            } else {
                // Jika belum di wishlist, tambahkan ke wishlist
                addToWishlist(this, productId, productName, productPrice);
            }
        });

        // Fungsi untuk menambahkan ke wishlist
        function addToWishlist(button, productId, productName, productPrice) {
            const data = {
                id: productId,
                name: productName,
                price: productPrice,
                quantity: 1,
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: '/wishlist/add',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Update tampilan button
                        $(button).addClass('in-wishlist');
                        $(button).find('svg').attr('fill', '#e53935').removeAttr('stroke');

                        // Tambahkan animasi detak jantung
                        $(button).find('svg').addClass('heart-beat');
                        setTimeout(function() {
                            $(button).find('svg').removeClass('heart-beat');
                        }, 800);

                        // Update counter wishlist di navbar
                        $('.js-wishlist-items-count').text(response.count || parseInt($(
                            '.js-wishlist-items-count').text()) + 1);

                        // Tampilkan notifikasi
                        showFavoritNotification(
                            'Produk berhasil ditambahkan ke daftar favorit Anda.', true);
                    } else {
                        if (response.redirect) {
                            // Jika perlu login terlebih dahulu
                            window.location.href = response.redirect;
                        } else {
                            showFavoritNotification(response.message ||
                                'Gagal menambahkan ke favorit', false);
                        }
                    }
                },
                error: function(xhr) {
                    // Tampilkan pesan error
                    let errorMsg = 'Gagal menambahkan ke favorit';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }

                    // Jika perlu login, arahkan ke halaman login
                    if (xhr.status === 401) {
                        window.location.href = '/login';
                    } else {
                        showFavoritNotification(errorMsg, false);
                    }
                }
            });
        }

        // Fungsi untuk menghapus dari wishlist
        function removeFromWishlist(button) {
            const productCard = $(button).closest('.product-card');
            const productId = productCard.find('input[name="id"]').val();

            // Dapatkan rowId dari wishlist item
            $.ajax({
                url: '/wishlist',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const wishlistItems = response.items || [];

                    // Cari item dengan product_id yang sama
                    const item = wishlistItems.find(item => item.id === productId);

                    if (item && item.rowId) {
                        // Hapus dari wishlist menggunakan rowId
                        $.ajax({
                            url: `/wishlist/remove/${item.rowId}`,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    // Update tampilan button
                                    $(button).removeClass('in-wishlist');
                                    $(button).find('svg').attr('fill', 'none').attr(
                                        'stroke', '#555');

                                    // Update counter wishlist di navbar
                                    const currentCount = parseInt($(
                                        '.js-wishlist-items-count').text());
                                    $('.js-wishlist-items-count').text(response.count ||
                                        Math.max(0, currentCount - 1));

                                    // Tampilkan notifikasi
                                    showFavoritNotification(
                                        'Produk berhasil dihapus dari daftar favorit Anda.',
                                        false);
                                } else {
                                    showFavoritNotification(response.message ||
                                        'Gagal menghapus dari favorit', false);
                                }
                            },
                            error: function(xhr) {
                                let errorMsg = 'Gagal menghapus dari favorit';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMsg = xhr.responseJSON.message;
                                }
                                showFavoritNotification(errorMsg, false);
                            }
                        });
                    } else {
                        // Fallback jika rowId tidak ditemukan
                        directRemoveFromWishlist(button, productId);
                    }
                },
                error: function() {
                    // Fallback jika endpoint tidak tersedia
                    directRemoveFromWishlist(button, productId);
                }
            });
        }

        // Fungsi fallback untuk menghapus dari wishlist
        function directRemoveFromWishlist(button, productId) {
            // Langsung update UI
            $(button).removeClass('in-wishlist');
            $(button).find('svg').attr('fill', 'none').attr('stroke', '#555');

            // Update counter wishlist di navbar
            const currentCount = parseInt($('.js-wishlist-items-count').text());
            $('.js-wishlist-items-count').text(Math.max(0, currentCount - 1));

            // Tampilkan notifikasi
            showFavoritNotification('Produk berhasil dihapus dari daftar favorit Anda.', false);
        }

        // ======================================================================
        // FUNGSI NOTIFIKASI
        // ======================================================================

        // Fungsi untuk menampilkan notifikasi keranjang
        function showCartNotification(message, isSuccess = true) {
            const notification = $('#cart-notification');
            const title = $('#cart-notification-title');
            const messageEl = $('#cart-notification-message');

            // Set konten
            messageEl.text(message);

            // Set tipe (success atau error)
            if (isSuccess) {
                notification.removeClass('error').addClass('success');
                title.text('Ditambahkan ke Keranjang');
                $('.cart-notification__icon i').removeClass('fa-exclamation-circle').addClass(
                    'fa-shopping-cart');
            } else {
                notification.removeClass('success').addClass('error');
                title.text('Gagal Ditambahkan');
                $('.cart-notification__icon i').removeClass('fa-shopping-cart').addClass(
                    'fa-exclamation-circle');
            }

            // Tampilkan notifikasi
            notification.css('display', 'flex').addClass('show');

            // Auto hide setelah 3 detik
            setTimeout(() => {
                notification.removeClass('show');
                setTimeout(() => notification.css('display', 'none'), 300);
            }, 3000);
        }

        // Fungsi untuk menampilkan notifikasi favorit
        function showFavoritNotification(message, isSuccess = true) {
            // Cek apakah notifikasi sudah ada, jika belum tambahkan ke body
            if (!$('#favorit-notification').length) {
                $('body').append(`
                <div class="favorit-notification" id="favorit-notification">
                    <div class="favorit-notification__icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="favorit-notification__content">
                        <div class="favorit-notification__title" id="favorit-notification-title">Ditambahkan ke Favorit</div>
                        <div class="favorit-notification__message" id="favorit-notification-message"></div>
                    </div>
                    <button class="favorit-notification__close" id="close-favorit-notification">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `);

                // Tambahkan event handler untuk tombol close
                $(document).on('click', '#close-favorit-notification', function() {
                    $('#favorit-notification').removeClass('show');
                    setTimeout(function() {
                        $('#favorit-notification').css('display', 'none');
                    }, 300);
                });
            }

            const notification = $('#favorit-notification');
            const title = $('#favorit-notification-title');
            const messageEl = $('#favorit-notification-message');

            // Set konten
            messageEl.text(message);

            // Set tipe (success atau error)
            if (isSuccess) {
                notification.removeClass('removed').addClass('success');
                title.text('Ditambahkan ke Favorit');
                $('.favorit-notification__icon i').removeClass('fa-trash').addClass('fa-heart');
            } else {
                notification.removeClass('success').addClass('removed');
                title.text('Dihapus dari Favorit');
                $('.favorit-notification__icon i').removeClass('fa-heart').addClass('fa-trash');
            }

            // Tampilkan notifikasi
            notification.css('display', 'flex').addClass('show');

            // Auto hide setelah 3 detik
            setTimeout(function() {
                notification.removeClass('show');
                setTimeout(function() {
                    notification.css('display', 'none');
                }, 300);
            }, 3000);
        }

        // ======================================================================
        // INISIALISASI OTOMATIS - PENGECEKAN STATUS WISHLIST PRODUK TERKAIT
        // ======================================================================

        // Cek produk mana yang sudah ada di wishlist dan update tampilannya
        function initializeWishlistUI() {
            // Ambil data wishlist dari API atau localStorage jika ada
            $.ajax({
                url: '/wishlist/count',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.count > 0) {
                        // Jika ada item di wishlist, cek detail item
                        $.ajax({
                            url: '/wishlist',
                            type: 'GET',
                            dataType: 'json',
                            success: function(wishlistResponse) {
                                const wishlistItems = wishlistResponse.items || [];
                                const wishlistProductIds = wishlistItems.map(item =>
                                    item.id);

                                // Update tampilan ikon wishlist berdasarkan status
                                $('.product-card').each(function() {
                                    const productId = $(this).find(
                                        'input[name="id"]').val();

                                    if (wishlistProductIds.includes(
                                            productId)) {
                                        // Produk ada di wishlist
                                        const wishlistButton = $(this).find(
                                            '.pc__btn-wl');
                                        wishlistButton.addClass('in-wishlist');
                                        wishlistButton.find('svg').attr('fill',
                                            '#e53935').removeAttr('stroke');
                                    }
                                });
                            }
                        });
                    }
                }
            });
        }

        // Panggil inisialisasi
        initializeWishlistUI();
        });
    </script>

    <script>
        // Script untuk perbaikan produk terkait
        $(document).ready(function() {
            // ======================================================================
            // 1. PERBAIKAN TAMBAH KE KERANJANG UNTUK PRODUK TERKAIT
            // ======================================================================

            // Fungsi untuk menampilkan notifikasi keranjang
            function showCartNotification(message, isSuccess = true) {
                const notification = $('#cart-notification');
                const title = $('#cart-notification-title');
                const messageEl = $('#cart-notification-message');

                // Set konten
                messageEl.text(message);

                // Set type (success atau error)
                if (isSuccess) {
                    notification.removeClass('error').addClass('success');
                    title.text('Ditambahkan ke Keranjang');
                    $('.cart-notification__icon i').removeClass('fa-exclamation-circle').addClass(
                        'fa-shopping-cart');
                } else {
                    notification.removeClass('success').addClass('error');
                    title.text('Gagal Ditambahkan');
                    $('.cart-notification__icon i').removeClass('fa-shopping-cart').addClass(
                        'fa-exclamation-circle');
                }

                // Show notification
                notification.css('display', 'flex').addClass('show');

                // Auto hide after 3 seconds
                setTimeout(() => {
                    notification.removeClass('show');
                    setTimeout(() => notification.css('display', 'none'), 300);
                }, 3000);
            }

            function checkRelatedProductsStock() {
                $('.related-product-form').each(function() {
                    const form = $(this);
                    const productCard = form.closest('.product-card');
                    const availableStock = parseInt(productCard.data('stock')) || 0;
                    const submitButton = form.find('button[type="submit"]');

                    // Jika stok kosong atau habis (data sudah dari server)
                    if (availableStock <= 0) {
                        // Button sudah di-disable dari server-side, tidak perlu JavaScript
                        return;
                    }

                    // Jika stok terbatas, tambahkan warning visual
                    if (availableStock <= 5) {
                        submitButton.addClass('stock-warning');
                    }
                });
            }

            // Jalankan cek stok saat halaman dimuat
            checkRelatedProductsStock();

            // Mencegah form submit biasa dan menggunakan AJAX untuk tambah ke keranjang
            $('.related-product-form').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const formData = form.serialize();
                const productId = form.find('input[name="id"]').val();
                const productName = form.find('input[name="name"]').val();
                const submitButton = form.find('button[type="submit"]');

                // Jika tombol disabled (stok habis), jangan lakukan apa-apa
                if (submitButton.prop('disabled')) {
                    return false;
                }

                // Show loading state
                submitButton.prop('disabled', true);
                submitButton.html('<i class="fas fa-spinner fa-spin"></i> Proses...');

                // Request AJAX untuk tambah ke keranjang
                $.ajax({
                    url: '/cart/add',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Update cart count di navbar
                            $('.js-cart-items-count').text(response.cartCount);

                            // Tampilkan notifikasi sukses
                            showCartNotification(
                                `${productName} berhasil ditambahkan ke keranjang Anda.`,
                                true);
                        } else {
                            // Jika response error (misal stok tidak cukup)
                            showCartNotification(response.message ||
                                'Gagal menambahkan produk ke keranjang', false);
                        }
                    },
                    error: function(xhr) {
                        // Handle error response
                        let errorMsg = 'Gagal menambahkan produk ke keranjang';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        showCartNotification(errorMsg, false);
                    },
                    complete: function() {
                        // Restore button state
                        submitButton.prop('disabled', false);
                        submitButton.html('Tambahkan ke Keranjang');
                    }
                });
            });

            // ======================================================================
            // 2. PERBAIKAN FUNGSI WISHLIST PADA PRODUK TERKAIT
            // ======================================================================

            // Fungsi untuk menampilkan notifikasi favorit
            function showFavoritNotification(message, isSuccess = true) {
                // Cek apakah notifikasi sudah ada, jika belum tambahkan ke body
                if (!$('#favorit-notification').length) {
                    $('body').append(`
                            <div class="favorit-notification" id="favorit-notification">
                                <div class="favorit-notification__icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="favorit-notification__content">
                                    <div class="favorit-notification__title" id="favorit-notification-title">Ditambahkan ke Favorit</div>
                                    <div class="favorit-notification__message" id="favorit-notification-message"></div>
                                </div>
                                <button class="favorit-notification__close" id="close-favorit-notification">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        `);

                    // Tambahkan event handler untuk tombol close
                    $(document).on('click', '#close-favorit-notification', function() {
                        $('#favorit-notification').removeClass('show');
                        setTimeout(function() {
                            $('#favorit-notification').css('display', 'none');
                        }, 300);
                    });
                }

                const notification = $('#favorit-notification');
                const title = $('#favorit-notification-title');
                const messageEl = $('#favorit-notification-message');

                // Set konten
                messageEl.text(message);

                // Set type (success atau error)
                if (isSuccess) {
                    notification.removeClass('removed').addClass('success');
                    title.text('Ditambahkan ke Favorit');
                    $('.favorit-notification__icon i').removeClass('fa-trash').addClass('fa-heart');
                } else {
                    notification.removeClass('success').addClass('removed');
                    title.text('Dihapus dari Favorit');
                    $('.favorit-notification__icon i').removeClass('fa-heart').addClass('fa-trash');
                }

                // Tampilkan notifikasi
                notification.css('display', 'flex').addClass('show');

                // Auto hide setelah 3 detik
                setTimeout(function() {
                    notification.removeClass('show');
                    setTimeout(function() {
                        notification.css('display', 'none');
                    }, 300);
                }, 3000);
            }

            // Check status wishlist dan update UI
            function initializeWishlistStatus() {
                // Ambil wishlist dari server
                $.ajax({
                    url: '/wishlist',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Jika mendapatkan data wishlist
                        if (response && response.items) {
                            const wishlistItems = response.items;
                            const wishlistProductIds = wishlistItems.map(item => item.id);

                            // Loop semua tombol wishlist di produk terkait
                            $('.pc__btn-wl').each(function() {
                                const productCard = $(this).closest('.product-card');
                                const productId = productCard.find('input[name="id"]').val();

                                // Jika produk ini ada di wishlist
                                if (wishlistProductIds.includes(parseInt(productId))) {
                                    $(this).addClass('in-wishlist');
                                    $(this).find('svg').attr('fill', '#e53935').removeAttr(
                                        'stroke');
                                }
                            });
                        }
                    },
                    error: function() {
                        console.log('Gagal memuat data wishlist');
                    }
                });
            }

            // Initialize wishlist status
            initializeWishlistStatus();

            // Tambahkan data product-id ke tombol wishlist untuk tracking
            $('.pc__btn-wl').each(function() {
                const productCard = $(this).closest('.product-card');
                const productId = productCard.find('input[name="id"]').val();
                const productName = productCard.find('input[name="name"]').val();
                const productPrice = productCard.find('input[name="price"]').val();

                $(this).attr('data-product-id', productId);
                $(this).attr('data-product-name', productName);
                $(this).attr('data-product-price', productPrice);
            });

            // Handle click event untuk tombol wishlist
            $('.pc__btn-wl').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const $this = $(this);
                const productId = $this.attr('data-product-id');
                const productName = $this.attr('data-product-name');
                const productPrice = $this.attr('data-product-price');

                // Jika belum login, redirect ke login page
                if (!$('meta[name="user-logged-in"]').attr('content') === 'true') {
                    window.location.href = '/login';
                    return;
                }

                // Toggle class untuk visual feedback
                const isInWishlist = $this.hasClass('in-wishlist');

                if (isInWishlist) {
                    // Jika sudah di wishlist, hapus dari wishlist
                    removeFromWishlist($this);
                } else {
                    // Jika belum di wishlist, tambahkan ke wishlist
                    addToWishlist($this, productId, productName, productPrice);
                }
            });

            // Fungsi untuk menambahkan ke wishlist
            function addToWishlist(button, productId, productName, productPrice) {
                // Show loading state
                button.addClass('loading');

                // Data untuk AJAX request
                const data = {
                    id: productId,
                    name: productName,
                    price: productPrice,
                    quantity: 1,
                    _token: $('meta[name="csrf-token"]').attr('content')
                };

                // AJAX request
                $.ajax({
                    url: '/wishlist/add',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Update UI
                            button.addClass('in-wishlist');
                            button.find('svg').attr('fill', '#e53935').removeAttr('stroke');

                            // Animasi heart beat
                            button.find('svg').addClass('heart-beat');
                            setTimeout(function() {
                                button.find('svg').removeClass('heart-beat');
                            }, 800);

                            // Update counter di navbar
                            $('.js-wishlist-items-count, .js-wishlist-count').text(response.count ||
                                parseInt($('.js-wishlist-items-count').text()) + 1).addClass(
                                'counter-animation');

                            // Tampilkan notifikasi
                            showFavoritNotification(
                                `${productName} berhasil ditambahkan ke daftar favorit Anda.`, true);
                        } else {
                            // Jika gagal, tampilkan error
                            showFavoritNotification(response.message || 'Gagal menambahkan ke favorit',
                                false);

                            // Jika perlu login
                            if (response.redirect) {
                                setTimeout(function() {
                                    window.location.href = response.redirect;
                                }, 2000);
                            }
                        }
                    },
                    error: function(xhr) {
                        // Handle error response
                        let errorMsg = 'Gagal menambahkan ke favorit';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }

                        showFavoritNotification(errorMsg, false);

                        // Jika error 401 (unauthorized), redirect ke login
                        if (xhr.status === 401) {
                            setTimeout(function() {
                                window.location.href = '/login';
                            }, 2000);
                        }
                    },
                    complete: function() {
                        // Remove loading state
                        button.removeClass('loading');
                    }
                });
            }

            // Fungsi untuk menghapus dari wishlist
            function removeFromWishlist(button) {
                // Show loading state
                button.addClass('loading');

                const productId = button.attr('data-product-id');
                const productName = button.attr('data-product-name');

                // Ambil wishlist dari server untuk mendapatkan rowId
                $.ajax({
                    url: '/wishlist',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response && response.items) {
                            const item = response.items.find(item => item.id == productId);

                            if (item && item.rowId) {
                                // AJAX request untuk hapus dari wishlist
                                $.ajax({
                                    url: `/wishlist/remove/${item.rowId}`,
                                    type: 'DELETE',
                                    data: {
                                        _token: $('meta[name="csrf-token"]').attr('content')
                                    },
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.success) {
                                            // Update UI
                                            button.removeClass('in-wishlist');
                                            button.find('svg').attr('fill', 'none').attr(
                                                'stroke', 'currentColor');

                                            // Update counter di navbar
                                            const currentCount = parseInt($(
                                                '.js-wishlist-items-count').text());
                                            $('.js-wishlist-items-count, .js-wishlist-count')
                                                .text(response.count || Math.max(0,
                                                    currentCount - 1));

                                            // Tampilkan notifikasi
                                            showFavoritNotification(
                                                `${productName} berhasil dihapus dari daftar favorit Anda.`,
                                                false);
                                        } else {
                                            showFavoritNotification(response.message ||
                                                'Gagal menghapus dari favorit', false);
                                        }
                                    },
                                    error: function(xhr) {
                                        let errorMsg = 'Gagal menghapus dari favorit';
                                        if (xhr.responseJSON && xhr.responseJSON.message) {
                                            errorMsg = xhr.responseJSON.message;
                                        }
                                        showFavoritNotification(errorMsg, false);
                                    },
                                    complete: function() {
                                        button.removeClass('loading');
                                    }
                                });
                            } else {
                                // Fallback jika rowId tidak ditemukan
                                directRemoveFromWishlist(button, productId, productName);
                            }
                        } else {
                            // Fallback jika tidak bisa mengambil data wishlist
                            directRemoveFromWishlist(button, productId, productName);
                        }
                    },
                    error: function() {
                        // Fallback jika error get wishlist
                        directRemoveFromWishlist(button, productId, productName);
                    }
                });
            }

            // Fungsi fallback untuk remove wishlist
            function directRemoveFromWishlist(button, productId, productName) {
                // Update UI
                button.removeClass('in-wishlist');
                button.find('svg').attr('fill', 'none').attr('stroke', 'currentColor');

                // Update counter di navbar
                const currentCount = parseInt($('.js-wishlist-items-count').text());
                $('.js-wishlist-items-count, .js-wishlist-count').text(Math.max(0, currentCount - 1));

                // Tampilkan notifikasi
                showFavoritNotification(`${productName} berhasil dihapus dari daftar favorit Anda.`, false);

                // Remove loading state
                button.removeClass('loading');
            }

            // Tambahkan meta tag untuk status login user (jika belum ada)
            if (!$('meta[name="user-logged-in"]').length) {
                // Cek dari keberadaan elemen yang menandakan user sudah login
                const isLoggedIn = $('#userMenuButton').length > 0;
                $('head').append(`<meta name="user-logged-in" content="${isLoggedIn}">`);
            }

            // Tambahkan styles untuk tombol wishlist
            $('<style>').text(`
                    .pc__btn-wl.in-wishlist {
                        color: #e53935 !important;
                    }
                    .pc__btn-wl.loading {
                        opacity: 0.7;
                        pointer-events: none;
                    }
                    .heart-beat {
                        animation: heartbeat 0.8s ease-in-out;
                    }
                `).appendTo('head');
        });
    </script>

    <!-- Functionality to handle size selection error -->
    <script>
        $(document).ready(function() {
            // Cek apakah ada parameter size_required di URL
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('size_required') === '1') {
                // Tampilkan notifikasi error ukuran
                $('#size-error').removeClass('d-none');

                // Scroll ke bagian ukuran
                if ($("#size-buttons").length) {
                    $('html, body').animate({
                        scrollTop: $("#size-buttons").offset().top - 100
                    }, 500);
                }

                // Hapus parameter dari URL setelah ditampilkan
                if (window.history.replaceState) {
                    const newUrl = window.location.href.split('?')[0];
                    window.history.replaceState({}, '', newUrl);
                }
            }
        });
    </script>

<script>
    $(document).ready(function() {
        const productId = {{ $product->id }};

        // Fungsi untuk refresh data stok
        function refreshStockData() {
            $.ajax({
                url: `/api/product/${productId}/stock`,
                type: 'GET',
                success: function(response) {
                    console.log('Stock updated:', response);

                    // Update stok utama
                    $('#main-stock-display').text(response.available_stock);

                    // Update stok per ukuran jika ada
                    if (response.sizes && response.sizes.length > 0) {
                        response.sizes.forEach(function(size) {
                            const sizeBtn = $(`.size-btn[data-size-id="${size.id}"]`);
                            if (sizeBtn.length) {
                                // Update data stok
                                sizeBtn.attr('data-stock', size.stock);

                                // Update tampilan stok
                                const stockText = sizeBtn.find('small');
                                if (size.stock > 0) {
                                    stockText.html(`Stok: ${size.stock}`);
                                    sizeBtn.prop('disabled', false).css('opacity', '1');
                                } else {
                                    stockText.html('<span class="text-danger">Habis</span>');
                                    sizeBtn.prop('disabled', true).css('opacity', '0.5');
                                }
                            }
                        });
                    }

                    // Update modal stok jika ukuran sudah dipilih
                    const selectedSizeId = $('#selected-size-id').val();
                    if (selectedSizeId && response.sizes) {
                        const selectedSize = response.sizes.find(s => s.id == selectedSizeId);
                        if (selectedSize) {
                            $('#modal-available-stock').text(selectedSize.stock);
                            $('.modal-qty-input').attr('max', selectedSize.stock);
                        }
                    }

                    // Update tampilan tombol berdasarkan stok
                    updateButtonsBasedOnStock(response.available_stock);
                },
                error: function(xhr) {
                    console.error('Failed to refresh stock data:', xhr);
                }
            });
        }

        // Fungsi untuk update tombol berdasarkan stok
        function updateButtonsBasedOnStock(availableStock) {
            if (availableStock <= 0) {
                $('#open-quantity-modal, #buy-now').prop('disabled', true)
                    .css({
                        'background-color': '#f5f5f5',
                        'border-color': '#ddd',
                        'color': '#aaa',
                        'cursor': 'not-allowed'
                    });
                $('#open-quantity-modal').html('<i class="fas fa-ban me-2"></i> Stok Habis');
                $('#buy-now').html('<i class="fas fa-exclamation-circle me-2"></i> Tidak Tersedia');
            } else {
                $('#open-quantity-modal, #buy-now').prop('disabled', false)
                    .removeAttr('style');
                $('#open-quantity-modal').html('<i class="fas fa-shopping-cart me-2"></i> Tambahkan ke Keranjang');
                $('#buy-now').html('Beli Sekarang');
            }
        }

        // Auto refresh setiap 30 detik
        setInterval(refreshStockData, 30000);

        // Refresh saat tab/window menjadi aktif kembali
        $(window).on('focus', function() {
            refreshStockData();
        });

        // Refresh setelah menambahkan ke keranjang
        $(document).on('cartItemAdded', function() {
            setTimeout(refreshStockData, 1000);
        });
    });

    // Trigger event setelah item ditambahkan ke keranjang
    $('#confirmAddToCart').on('click', function() {
        // ... existing code ...

        $.ajax({
            // ... existing AJAX code ...
            success: function(response) {
                if (response.success) {
                    // ... existing success code ...

                    // Trigger refresh stok
                    $(document).trigger('cartItemAdded');
                }
            }
        });
    });
    </script>
@endpush

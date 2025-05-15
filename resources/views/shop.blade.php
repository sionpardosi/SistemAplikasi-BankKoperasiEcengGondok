@extends('layouts.app')
@section('content')
    <style>
        .brand-list li,
        .category-list li {
            line-height: 40px;
        }

        .brand-list li .chk-brand,
        .category-list li .chk-category {
            width: 1rem;
            height: 1rem;
            color: #e4e4e4;
            border: 0.125rem solid currentColor;
            border-radius: 0;
            margin-right: 0.75rem;
        }
    </style>

    <style>
        .filled-heart {
            color: red;
        }

        .custom-page-size-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 0.25rem 0.75rem;
            font-size: 0.85rem;
            line-height: 1.2;
            min-width: 70px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .custom-page-size-select:focus {
            border-color: #964B00;
            box-shadow: 0 0 5px rgba(150, 75, 0, 0.5);
            outline: none;
        }

        .custom-select.ui-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 0.25rem 0.75rem;
            font-size: 0.85rem;
            line-height: 1.2;
            min-width: 130px;
            transition: border-color 0.3s, box-shadow 0.3s;
            /* Menambahkan ikon panah kustom */
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%228%22%20height%3D%226%22%20viewBox%3D%220%200%208%206%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cpath%20d%3D%22M1%200l3%203L7%200%22%20stroke%3D%22%23333%22%20stroke-width%3D%222%22%20fill%3D%22none%22/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            background-size: 8px 6px;
        }

        .custom-select.ui-select:focus {
            border-color: #964B00;
            box-shadow: 0 0 5px rgba(150, 75, 0, 0.5);
            outline: none;
        }

        .simple-cols-size span {
            font-size: 0.9rem;
            color: #333;
        }

        .simple-cols-size .btn {
            font-size: 0.9rem;
            color: #964B00;
            /* Warna dasar lebih terang */
            padding: 0.25rem 0.5rem;
            transition: color 0.2s ease;
        }

        .simple-cols-size .btn:hover,
        .simple-cols-size .btn:focus {
            color: #964B00;
            /* Warna saat hover/fokus: sedikit lebih gelap */
        }

        .simple-cols-size .btn.active {
            font-weight: bold;
            text-decoration: underline;
        }

        /* Enhanced Shop Controls Styling */
        .shop-controls {
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05) !important;
        }

        .shop-controls:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08) !important;
        }

        /* Improved Breadcrumb */
        .breadcrumb {
            margin-bottom: 0;
            padding: 0;
            background: transparent;
        }

        .breadcrumb .menu-link {
            color: #6c757d;
            font-size: 0.85rem;
            transition: color 0.2s ease-in-out;
            text-decoration: none;
        }

        .breadcrumb .menu-link:hover {
            color: #956a3b;
        }

        .breadcrumb .menu-link.active {
            color: #956a3b;
            font-weight: 600;
        }

        /* Enhanced Select Elements */
        .select-wrapper {
            position: relative;
            display: inline-block;
        }

        .select-wrapper::after {
            content: '';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .custom-page-size-select,
        .custom-select.ui-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: #fff;
            border: 1px solid #e4e4e4;
            border-radius: 4px;
            padding: 0.5rem 2rem 0.5rem 0.75rem;
            font-size: 0.85rem;
            line-height: 1.2;
            cursor: pointer;
            transition: all 0.25s ease;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23956a3b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 12px;
        }

        .custom-page-size-select {
            min-width: 80px;
        }

        .custom-select.ui-select {
            min-width: 160px;
        }

        .custom-page-size-select:focus,
        .custom-select.ui-select:focus {
            border-color: #956a3b;
            box-shadow: 0 0 0 0.2rem rgba(149, 106, 59, 0.25);
            outline: none;
        }

        .custom-page-size-select:hover,
        .custom-select.ui-select:hover {
            border-color: #956a3b;
        }

        /* Grid View Button Group */
        .grid-view-options .btn-group .btn {
            padding: 0.375rem 0.75rem;
            border-color: #e4e4e4;
            color: #6c757d;
            transition: all 0.2s ease;
            font-size: 0.85rem;
        }

        .grid-view-options .btn-group .btn:hover {
            background-color: #f8f9fa;
            color: #956a3b;
        }

        .grid-view-options .btn-group .btn.active {
            background-color: #956a3b;
            border-color: #956a3b;
            color: #ffffff;
        }

        /* Divider */
        .shop-controls__divider {
            height: 24px;
            width: 1px;
            background-color: #e4e4e4;
            margin: 0 15px;
        }

        /* Mobile Filter Button */
        .shop-filter .btn-outline-primary {
            color: #956a3b;
            border-color: #956a3b;
            transition: all 0.2s ease;
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .shop-filter .btn-outline-primary:hover {
            background-color: #956a3b;
            border-color: #956a3b;
            color: #fff;
        }

        /* Active Filters Section */
        .active-filters-tags .filter-tag {
            display: inline-flex;
            align-items: center;
            background-color: #f8f9fa;
            border: 1px solid #e4e4e4;
            border-radius: 30px;
            padding: 0.25rem 0.75rem;
            font-size: 0.8rem;
            color: #333;
            transition: all 0.2s ease;
        }

        .active-filters-tags .filter-tag:hover {
            background-color: #f0f0f0;
        }

        .active-filters-tags .filter-tag .close {
            margin-left: 5px;
            font-size: 1rem;
            line-height: 1;
            color: #6c757d;
        }

        .active-filters-tags .filter-tag .close:hover {
            color: #dc3545;
        }


        .product-card__review {
            font-size: 0.85rem;
            color: #555;
        }

        .review-star {
            width: 14px;
            height: 14px;
            margin-right: 2px;
        }

        .reviews-note {
            font-size: 0.8rem;
            color: #888;
        }

        .rating-filter label {
            cursor: pointer;
            padding: 5px;
            transition: background-color 0.2s;
        }

        .rating-filter label:hover {
            background-color: #f0f0f0;
        }

        .rating-filter input[type="checkbox"] {
            display: none;
            /* Hide the default checkbox */
        }

        .rating-filter input[type="checkbox"]+span {
            display: inline-block;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .rating-filter input[type="checkbox"]:checked+span {
            background-color: #FFD700;
            /* Highlight selected rating */
            color: white;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .shop-controls {
                padding: 1rem;
            }

            .shop-controls__wrapper {
                width: 100%;
                margin-top: 0.5rem;
                justify-content: space-between;
            }

            .product-display-options,
            .product-sort-options {
                flex-grow: 1;
            }

            .custom-select.ui-select,
            .custom-page-size-select {
                width: 100%;
            }

            .product-card__review {
                font-size: 0.85rem;
                color: #555;
            }

            .review-star {
                width: 14px;
                height: 14px;
                margin-right: 2px;
            }

            .reviews-note {
                font-size: 0.8rem;
                color: #888;
            }

            .rating-filter label {
                cursor: pointer;
                padding: 5px;
                transition: background-color 0.2s;
            }

            .rating-filter label:hover {
                background-color: #f0f0f0;
            }

            .rating-filter input[type="checkbox"] {
                display: none;
                /* Hide the default checkbox */
            }

            .rating-filter input[type="checkbox"]+span {
                display: inline-block;
                padding: 5px 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
                transition: background-color 0.2s;
            }

            .rating-filter input[type="checkbox"]:checked+span {
                background-color: #FFD700;
                /* Highlight selected rating */
                color: white;
            }
        }

        /* Cart notification */
        .cart-notification {
            position: fixed;
            top: 20px;
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
            transform: translateY(-20px);
            opacity: 0;
            border-left: 4px solid #956a3b;
        }

        .cart-notification.success {
            border-left-color: #956a3b;
        }

        .cart-notification.error {
            border-left-color: #e53935;
        }

        .cart-notification.show {
            transform: translateY(0);
            opacity: 1;
        }

        .cart-notification__icon {
            margin-right: 15px;
            width: 30px;
            height: 30px;
            background: #f9f3ec;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-notification.success .cart-notification__icon {
            color: #956a3b;
        }

        .cart-notification.error .cart-notification__icon {
            color: #e53935;
        }

        .cart-notification__content {
            flex: 1;
        }

        .cart-notification__title {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 3px;
            color: #956a3b;
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
        }
    </style>

    <style>
        /* Enhanced Rating Filter Styles */
        .rating-filters {
            padding: 10px 0;
        }

        .rating-filter-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
            justify-content: space-between;
            position: relative;
            border-left: 3px solid transparent;
        }

        .rating-filter-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(to right, rgba(149, 106, 59, 0.1), transparent);
            border-radius: 8px;
            transition: width 0.3s ease;
            z-index: 0;
        }

        .rating-filter-item:hover {
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(149, 106, 59, 0.15);
        }

        .rating-filter-item:hover::before {
            width: 100%;
        }

        .rating-filter-item.active {
            background-color: rgba(149, 106, 59, 0.15);
            border-left-color: #956a3b;
        }

        .rating-filter-item.active::after {
            content: '\f00c';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            right: 12px;
            color: #956a3b;
            animation: fadeIn 0.3s ease;
        }

        .rating-stars {
            display: flex;
            align-items: center;
            z-index: 1;
            flex: 1;
        }

        .rating-stars i {
            font-size: 14px;
            transition: transform 0.2s ease;
            margin-right: 2px;
        }

        .rating-filter-item:hover .rating-stars i.text-warning {
            transform: scale(1.2);
        }

        .rating-stars i.text-warning {
            color: #FFD700 !important;
        }

        .rating-stars i.text-muted {
            color: #d1d1d1 !important;
        }

        .rating-count {
            margin-left: 8px;
            font-size: 0.85rem;
            color: #666;
            white-space: nowrap;
        }

        .rating-progress {
            flex: 1;
            margin-left: 12px;
            z-index: 1;
            max-width: 80px;
        }

        .progress {
            height: 6px;
            background-color: #f0f0f0;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-bar {
            transition: width 0.5s ease;
            background-color: #956a3b !important;
            animation: progressGrow 1s ease-out forwards;
        }

        /* Filter badges */
        .rating-filter-badge {
            padding: 0 15px;
        }

        .rating-filter-badge .badge {
            padding: 8px 15px;
            font-weight: 500;
            font-size: 0.85rem;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .rating-filter-badge .badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .clear-rating-filter {
            padding: 0 15px;
        }

        .clear-rating-filter .btn {
            transition: all 0.2s ease;
            border-radius: 6px;
            font-size: 0.85rem;
        }

        .clear-rating-filter .btn:hover {
            color: #dc3545;
            border-color: #dc3545;
        }

        /* Status badge when filter is active */
        .filter-active-status {
            display: inline-flex;
            align-items: center;
            margin-left: 10px;
            font-size: 0.75rem;
            color: #956a3b;
            animation: fadeIn 0.5s ease;
        }

        /* Animations */
        @keyframes pulse {
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

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes progressGrow {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }

        .rating-filter-item.active:hover {
            animation: pulse 0.5s ease;
        }

        /* Mobile styles */
        @media (max-width: 767.98px) {
            .rating-filter-item {
                padding: 10px 12px;
            }

            .rating-count {
                font-size: 0.75rem;
            }

            .rating-stars i {
                font-size: 12px;
            }

            .rating-progress {
                max-width: 60px;
            }
        }
    </style>

    <style>
        /* Style untuk filter ukuran */
        .swatch-size {
            min-width: 40px;
            text-align: center;
            border-radius: 4px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .swatch-size.active {
            background-color: #956a3b;
            border-color: #956a3b;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .swatch-size:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .swatch-size small {
            font-size: 0.7rem;
            opacity: 0.8;
        }

        /* Animasi untuk size yang baru ditambahkan atau dihapus */
        @keyframes pulse-size {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .swatch-size.just-clicked {
            animation: pulse-size 0.3s ease-in-out;
        }
    </style>
    <main class="pt-90">
        <section class="shop-main container d-flex pt-4 pt-xl-5">
            <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
                <div class="aside-header d-flex d-lg-none align-items-center">
                    <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
                    <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
                </div>

                <div class="pt-4 pt-lg-0"></div>

                <div class="accordion" id="categories-list">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-1">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true"
                                aria-controls="accordion-filter-1">
                                Kategori Produk
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">


                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
                            <div class="accordion-body px-0 pb-0 pt-3 category-list">
                                <ul class="list list-inline mb-0">
                                    @foreach ($categories as $category)
                                        <li class="list-item">
                                            <span class="menu-link py-1"> <input type="checkbox" name="categories"
                                                    value="{{ $category->id }}" class="chk-category"
                                                    @if (in_array($category->id, explode(',', $f_categories))) checked="checked" @endif />
                                                {{ $category->name }}</span> <span
                                                class="text-right float-end">{{ $category->products()->count() }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Letakkan kode ini setelah filter warna dan sebelum filter ukuran -->
                <div class="accordion" id="rating-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-rating">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-rating" aria-expanded="true"
                                aria-controls="accordion-filter-rating">
                                Ulasan Produk
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-rating" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-rating" data-bs-parent="#rating-filters">
                            <div class="accordion-body px-0 pb-0 pt-3">
                                <div class="rating-filters">
                                    <div class="rating-filter-badge mb-3">
                                        <span class="badge bg-light text-dark border">Semua Ulasan</span>
                                    </div>

                                    @for ($i = 5; $i >= 1; $i--)
                                        <div class="rating-filter-item @if (in_array((string) $i, explode(',', request()->input('ratings', '')))) active @endif"
                                            data-rating="{{ $i }}">
                                            <div class="rating-stars">
                                                @for ($j = 1; $j <= 5; $j++)
                                                    <i
                                                        class="fas fa-star @if ($j <= $i) text-warning @else text-muted @endif"></i>
                                                @endfor
                                                <span class="rating-count">({{ $productCountByRating[$i] ?? 0 }}
                                                    produk)</span>
                                            </div>
                                            <div class="rating-progress">
                                                <div class="progress">
                                                    @php
                                                        $totalProducts = array_sum($productCountByRating);
                                                        $percentage =
                                                            $totalProducts > 0
                                                                ? (($productCountByRating[$i] ?? 0) / $totalProducts) *
                                                                    100
                                                                : 0;
                                                    @endphp
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{ $percentage }}%"
                                                        aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor

                                    @if (request()->has('ratings') && !empty(request()->input('ratings')))
                                        <div class="clear-rating-filter mt-3">
                                            <button type="button" id="clearRatingFilter"
                                                class="btn btn-sm btn-outline-secondary w-100">
                                                <i class="fas fa-times-circle me-1"></i> Hapus Filter Ulasan
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                <input type="hidden" id="selected-ratings" name="ratings"
                                    value="{{ request()->input('ratings', '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion" id="size-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-size">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-size" aria-expanded="true"
                                aria-controls="accordion-filter-size">
                                Ukuran
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-size" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-size" data-bs-parent="#size-filters">
                            <div class="accordion-body px-0 pb-0">
                                <div class="d-flex flex-wrap">
                                    @foreach ($sizes as $size_item)
                                        <button type="button"
                                            class="swatch-size btn btn-sm mb-3 me-3 js-filter-size {{ in_array($size_item->id, explode(',', $f_sizes ?? '')) ? 'active btn-primary' : 'btn-outline-light' }}"
                                            data-size-id="{{ $size_item->id }}">
                                            {{ $size_item->name }}
                                            <small
                                                class="d-block text-muted mt-1">({{ $productCountBySize[$size_item->id] ?? 0 }})</small>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion" id="brand-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-brand">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-brand" aria-expanded="true"
                                aria-controls="accordion-filter-brand">
                                Merek
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">


                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
                            <div class="search-field multi-select accordion-body px-0 pb-0">
                                <ul class="list list-inline mb-0 brand-list">
                                    @foreach ($brands as $brand)
                                        <li class="list-item">
                                            <span class="menu-link py-1">
                                                <input type="checkbox" name="brands" value="{{ $brand->id }}"
                                                    class="chk-brand"
                                                    @if (in_array($brand->id, explode(',', $f_brands))) checked="checked" @endif />
                                                {{ $brand->name }}
                                            </span>
                                            <span class="text-right float-end">
                                                {{ $brand->products()->count() }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion" id="price-filters">
                    <div class="accordion-item mb-4">
                        <h5 class="accordion-header mb-2" id="accordion-heading-price">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-price" aria-expanded="true"
                                aria-controls="accordion-filter-price">
                                Harga
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-price" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
                            <input class="price-range-slider" type="text" name="price_range" value=""
                                data-slider-min="1" data-slider-max="10000000" data-slider-step="5"
                                data-slider-value="[{{ $min_price }},{{ $max_price }}]" data-currency="Rp" />

                            <div class="price-range__info d-flex align-items-center mt-2">
                                <div class="me-auto">
                                    <span class="text-secondary">Harga Minimal: </span>
                                    <span class="price-range__min">Rp1</span>
                                </div>
                                <div>
                                    <span class="text-secondary">Harga Maksimal: </span>
                                    <span class="price-range__max">Rp10000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="shop-list flex-grow-1">
                <div class="swiper-container js-swiper-slider slideshow slideshow_small slideshow_split"
                    data-settings='{
            "autoplay": {
              "delay": 5000
            },
            "slidesPerView": 1,
            "effect": "fade",
            "loop": true,
            "pagination": {
              "el": ".slideshow-pagination",
              "type": "bullets",
              "clickable": true
            }
          }'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                    style="background-color: #f5e6e0;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h2
                                            class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                            BANK KOPERASI<br /><strong>ECENG GONDOK</strong></h2>
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">
                                            Bank Koperasi Eceng Gondok hadir untuk menggerakkan perekonomian bersama melalui
                                            layanan keuangan yang inovatif dan terpercaya. Bergabunglah bersama kami untuk
                                            meraih kemudahan dalam pengelolaan keuangan dan mewujudkan masa depan yang lebih
                                            cerah.
                                            </h6>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color: #f5e6e0;">
                                        <img loading="lazy" src="assets/images/shop/shop_banner3.jpg" width="630"
                                            height="450" alt="Women's accessories"
                                            class="slideshow-bg__img object-fit-cover" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                    style="background-color: #f5e6e0;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h2
                                            class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                            BANK KOPERASI <br /><strong>ECENG GONDOK</strong></h2>
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">
                                            Nikmati berbagai kemudahan dalam pengelolaan keuangan melalui sistem layanan
                                            digital kami yang inovatif dan ramah pengguna.
                                            </h6>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color: #f5e6e0;">
                                        <img loading="lazy" src="assets/images/shop/shop_banner1.jpg" width="630"
                                            height="450" alt="Women's accessories"
                                            class="slideshow-bg__img object-fit-cover" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                    style="background-color: #f5e6e0;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h2
                                            class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                            BANK KOPERASI <br /><strong>ECENG GONDOK</strong></h2>
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">
                                            Bergabunglah dengan komunitas Bank Koperasi Eceng Gondok dan rasakan pengalaman
                                            transaksi yang cepat, aman, dan terpercaya.
                                            </h6>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color: #f5e6e0;">
                                        <img loading="lazy" src="assets/images/shop/shop_banner4.jpg" width="630"
                                            height="450" alt="Women's accessories"
                                            class="slideshow-bg__img object-fit-cover" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container p-3 p-xl-5">
                        <div
                            class="slideshow-pagination d-flex align-items-center position-absolute bottom-0 mb-4 pb-xl-2">
                        </div>

                    </div>
                </div>

                <div class="mb-3 pb-2 pb-xl-3"></div>

                <div class="shop-controls bg-white rounded-3 shadow-sm mb-4 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <!-- Breadcrumb with improved styling -->
                        <div class="breadcrumb mb-3 mb-md-0 d-flex align-items-center">
                            <a href="{{ route('home.index') }}" class="menu-link menu-link_us-s text-uppercase fw-medium"
                                aria-label="Navigate to Home">
                                <i class="fas fa-home me-1" aria-hidden="true" style="font-size: 14px;"></i>Beranda
                            </a>
                            <span class="breadcrumb-separator menu-link fw-medium px-2" aria-hidden="true">/</span>
                            <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium active"
                                aria-current="page">Produk</a>
                        </div>

                        <!-- Filter Controls with improved layout -->
                        <div class="shop-controls__wrapper d-flex align-items-center flex-wrap gap-2 gap-md-3">
                            <!-- Display Options -->
                            {{-- <div class="product-display-options d-flex align-items-center">
                                <label for="pagesize"
                                    class="fw-medium text-secondary me-2 d-none d-md-block">Tampilkan:</label>
                                <div class="select-wrapper position-relative">
                                    <select class="custom-page-size-select" aria-label="Ukuran Halaman" id="pagesize"
                                        name="pagesize">
                                        <option value="12" {{ $size == 12 ? 'selected' : '' }}>12</option>
                                        <option value="24" {{ $size == 24 ? 'selected' : '' }}>24</option>
                                        <option value="48" {{ $size == 48 ? 'selected' : '' }}>48</option>
                                        <option value="102" {{ $size == 102 ? 'selected' : '' }}>102</option>
                                    </select>
                                </div>
                            </div> --}}

                            <div class="shop-controls__divider d-none d-md-block"></div>

                            <!-- Sort Options -->
                            <div class="product-sort-options d-flex align-items-center">
                                <label for="orderby"
                                    class="fw-medium text-secondary me-2 d-none d-md-block">Urutkan:</label>
                                <div class="select-wrapper position-relative">
                                    <select class="custom-select ui-select" aria-label="Urutkan Produk" id="orderby">
                                        <option value="-1" {{ $order == -1 ? 'selected' : '' }}>Rekomendasi</option>
                                        <option value="1" {{ $order == 1 ? 'selected' : '' }}>Produk Terbaru</option>
                                        <option value="2" {{ $order == 2 ? 'selected' : '' }}>Produk Terlama</option>
                                        <option value="3" {{ $order == 3 ? 'selected' : '' }}>Harga Terendah</option>
                                        <option value="4" {{ $order == 4 ? 'selected' : '' }}>Harga Tertinggi
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="shop-controls__divider d-none d-md-block"></div>

                            <!-- View Mode Options with improved active state -->
                            <div class="grid-view-options d-none d-lg-flex align-items-center">
                                <span class="text-uppercase fw-medium me-2" aria-hidden="true">VIEW</span>
                                <div class="btn-group" role="group" aria-label="Grid View Options">
                                    <button type="button" class="btn btn-outline-secondary btn-sm js-cols-size"
                                        data-target="products-grid" data-cols="2"
                                        aria-label="View in 2 columns">2</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm js-cols-size"
                                        data-target="products-grid" data-cols="3"
                                        aria-label="View in 3 columns">3</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm js-cols-size"
                                        data-target="products-grid" data-cols="4"
                                        aria-label="View in 4 columns">4</button>
                                </div>
                            </div>

                            <!-- Mobile Filter Button -->
                            <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
                                <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside"
                                    data-aside="shopFilter">
                                    <svg class="d-inline-block align-middle me-2" width="14" height="10"
                                        viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_filter" />
                                    </svg>
                                    <span class="text-uppercase fw-medium d-inline-block align-middle">Filter</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Active Filters Section (new) -->
                    <div class="active-filters mt-3 d-none" id="activeFilters">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <span class="text-secondary fw-medium me-2">Filter Aktif:</span>
                            <div class="active-filters-tags d-flex flex-wrap gap-2">
                                <!-- Tags will be added dynamically via JavaScript -->
                            </div>
                            <button type="button" class="btn btn-link btn-sm text-danger p-0 ms-auto"
                                id="clearAllFilters">
                                Hapus Semua
                            </button>
                        </div>
                    </div>
                </div>



                @if (request()->has('ratings') && !empty(request()->input('ratings')))
                    <div class="filter-notification mb-4 animate__animated animate__fadeIn">
                        <div class="alert alert-custom fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="filter-icon-container me-3">
                                    <i class="fas fa-filter"></i>
                                </div>
                                <div class="filter-content">
                                    <h5 class="alert-heading mb-1">Filter Ulasan Aktif</h5>
                                    <p class="mb-0 filter-text">
                                        Menampilkan produk dengan rating:
                                        <span class="rating-badge">
                                            @php
                                                $selectedRating = request()->input('ratings');
                                            @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas fa-star @if ($i <= $selectedRating) text-warning @else text-muted @endif"></i>
                                            @endfor
                                        </span>
                                        <span class="product-count">({{ $products->total() }} produk)</span>
                                    </p>
                                </div>
                                <a href="{{ route('shop.index') }}" class="btn btn-sm btn-outline-secondary ms-auto"
                                    title="Hapus Filter">
                                    <i class="fas fa-times-circle me-1"></i> Hapus Filter
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Tampilan kosong jika tidak ada produk yang ditemukan -->
                @if ($products->isEmpty() && request()->has('ratings'))
                    <div class="no-products-found my-5 py-5 text-center">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3 class="mt-4">Tidak Ada Produk Ditemukan</h3>
                            <p class="text-muted mb-4">Tidak ada produk dengan rating yang Anda pilih. Silakan coba filter
                                lainnya.</p>
                            <a href="{{ route('shop.index') }}" class="btn btn-primary">
                                <i class="fas fa-undo me-2"></i> Tampilkan Semua Produk
                            </a>
                        </div>
                    </div>
                @endif

                <style>
                    .filter-notification {
                        animation-duration: 0.5s;
                    }

                    .alert-custom {
                        background-color: #f9f3ec;
                        border-left: 4px solid #956a3b;
                        border-radius: 8px;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                        padding: 1rem 1.25rem;
                    }

                    .filter-icon-container {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 40px;
                        height: 40px;
                        border-radius: 50%;
                        background-color: rgba(149, 106, 59, 0.1);
                        color: #956a3b;
                        font-size: 1.2rem;
                    }

                    .filter-content .alert-heading {
                        color: #333;
                        font-size: 1rem;
                        font-weight: 600;
                    }

                    .filter-text {
                        color: #666;
                        font-size: 0.9rem;
                        display: flex;
                        align-items: center;
                        flex-wrap: wrap;
                    }

                    .rating-badge {
                        display: inline-flex;
                        align-items: center;
                        margin: 0 0.5rem;
                    }

                    .rating-badge i {
                        margin-right: 2px;
                    }

                    .product-count {
                        font-style: italic;
                        color: #777;
                    }

                    .empty-state {
                        padding: 2rem;
                        max-width: 500px;
                        margin: 0 auto;
                    }

                    .empty-state-icon {
                        width: 80px;
                        height: 80px;
                        background-color: #f8f9fa;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin: 0 auto;
                        color: #956a3b;
                        font-size: 2rem;
                    }

                    .empty-state h3 {
                        font-weight: 600;
                        color: #333;
                    }

                    .empty-state .btn-primary {
                        background-color: #956a3b;
                        border-color: #956a3b;
                    }

                    .empty-state .btn-primary:hover {
                        background-color: #7b582f;
                        border-color: #7b582f;
                    }

                    /* Responsive adjustments */
                    @media (max-width: 576px) {
                        .filter-text {
                            flex-direction: column;
                            align-items: flex-start;
                        }

                        .rating-badge {
                            margin: 0.5rem 0;
                        }
                    }
                </style>


                <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
                    @foreach ($products as $product)
                        <div class="product-card-wrapper">

                            @if (isset($search_query) && !empty($search_query))
                                <div class="search-results-notification mb-4">
                                    <div class="alert alert-custom fade show" role="alert">
                                        <div class="d-flex align-items-center">
                                            <div class="search-icon-container me-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    fill="currentColor" class="fas fa-search" viewBox="0 0 16 16">
                                                    <path
                                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                                </svg>
                                            </div>
                                            <div class="search-content">
                                                <h5 class="alert-heading mb-1">Hasil pencarian</h5>
                                                <p class="mb-0 search-query-text">Menampilkan hasil untuk: "<span
                                                        class="fw-medium">{{ $search_query }}</span>"</p>
                                            </div>
                                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    </div>
                                </div>

                                <style>
                                    .search-results-notification {
                                        animation: fadeIn 0.5s ease-in-out;
                                    }

                                    .alert-custom {
                                        background-color: #f8f9fa;
                                        border-left: 4px solid #956a3b;
                                        border-radius: 8px;
                                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                                        padding: 1rem 1.25rem;
                                    }

                                    .search-icon-container {
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        width: 40px;
                                        height: 40px;
                                        border-radius: 50%;
                                        background-color: rgba(149, 106, 59, 0.1);
                                        color: #956a3b;
                                    }

                                    .search-content .alert-heading {
                                        color: #333;
                                        font-size: 1rem;
                                        font-weight: 600;
                                    }

                                    .search-query-text {
                                        color: #666;
                                        font-size: 0.9rem;
                                    }

                                    .search-query-text .fw-medium {
                                        color: #000;
                                    }

                                    @keyframes fadeIn {
                                        from {
                                            opacity: 0;
                                            transform: translateY(-10px);
                                        }

                                        to {
                                            opacity: 1;
                                            transform: translateY(0);
                                        }
                                    }

                                    .btn-close:focus {
                                        box-shadow: 0 0 0 0.25rem rgba(149, 106, 59, 0.25);
                                    }
                                </style>
                            @endif
                            <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                                <div class="pc__img-wrapper">
                                    <div class="swiper-container background-img js-swiper-slider"
                                        data-settings='{"resizeObserver": true}'>
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <a
                                                    href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                                    <img loading="lazy"
                                                        src="{{ asset('uploads/products') }}/{{ $product->image }}"
                                                        width="330" height="400" alt="{{ $product->name }}"
                                                        class="pc__img">
                                                </a>
                                            </div>
                                            <div class="swiper-slide">
                                                @foreach (explode(',', $product->images) as $gimg)
                                                    <a
                                                        href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                                        <img loading="lazy"
                                                            src="{{ asset('uploads/products') }}/{{ trim($gimg) }}"
                                                            width="330" height="400" alt="{{ $product->name }}"
                                                            class="pc__img">
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                        <span class="pc__img-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_prev_sm" />
                                            </svg></span>
                                        <span class="pc__img-next"><svg width="7" height="11" viewBox="0 0 7 11"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_next_sm" />
                                            </svg></span>
                                    </div>
                                    <!-- Selalu tampilkan form add-to-cart, tanpa kondisi untuk "Lihat Keranjang" -->
                                    <form name="addtocart-form" method="POST" action="{{ route('cart.add') }}">
                                        @csrf
                                        <div class="product-single__addtocart">
                                            <input type="hidden" name="id" value="{{ $product->id }}" />
                                            <input type="hidden" name="name" value="{{ $product->name }}" />
                                            <input type="hidden" name="quantity" value="1" />
                                            <input type="hidden" name="price"
                                                value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}" />
                                            <button type="submit"
                                                class="pc__atc btn anim_appear-bottom position-absolute border-0 text-uppercase fw-medium js-add-cart"
                                                style="background-color: #956a3b; color: #ffffff;">
                                                Tambahkan ke Keranjang
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">{{ $product->category->name }}</p>
                                    <h6 class="pc__title"><a
                                            href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">{{ $product->name }}</a>
                                    </h6>
                                    <div class="product-card__price d-flex">
                                        <span class="money price">
                                            @if ($product->sale_price && $product->sale_price < $product->regular_price)
                                                <s>{{ formatRupiah($product->regular_price) }}</s>
                                                {{ formatRupiah($product->sale_price) }}
                                            @else
                                                {{ formatRupiah($product->regular_price) }}
                                            @endif
                                        </span>
                                    </div>

                                    <div class="product-card__review d-flex align-items-center">
                                        @php
                                            $averageRating = $product->reviews()->avg('rating');
                                            $totalReviews = $product->reviews()->count();
                                        @endphp

                                        <div class="reviews-group d-flex">
                                            {{-- Display stars dynamically based on the average rating --}}
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="review-star" viewBox="0 0 9 9"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    style="fill: {{ $i <= $averageRating ? '#FFD700' : '#E0E0E0' }};">
                                                    <use href="#icon_star" />
                                                </svg>
                                            @endfor
                                        </div>

                                        {{-- Display total reviews count --}}
                                        <span class="reviews-note text-lowercase text-secondary ms-1">
                                            {{ $totalReviews > 1000 ? round($totalReviews / 1000, 1) . 'k+' : $totalReviews }}
                                            Ulasan
                                        </span>
                                    </div>

                                    <!-- Wishlist Button Section -->
                                    @if (\Surfsidemedia\Shoppingcart\Facades\Cart::instance('wishlist')->content()->where('id', $product->id)->count() > 0)
                                        <form method="POST"
                                            action="{{ route('wishlist.remove', ['rowId' => \Surfsidemedia\Shoppingcart\Facades\Cart::instance('wishlist')->content()->Where('id', $product->id)->first()->rowId]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 filled-heart"
                                                title="Remove from Wishlist">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('wishlist.add') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $product->id }}" />
                                            <input type="hidden" name="name" value="{{ $product->name }}" />
                                            <input type="hidden" name="price"
                                                value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}" />
                                            <input type="hidden" name="quantity" value="1" />
                                            <button type="submit"
                                                class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                                title="Tambahkan Ke Favorit">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </section>

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

    <form id="frmfilter" method="GET" action="{{ route('shop.index') }}">
        <input type="hidden" name="name" value="{{ $products->currentPage() }}" />
        <input type="hidden" name="size" id="size" value="{{ $pageSize }}" />
        <!-- Ubah $size menjadi $pageSize -->
        <input type="hidden" id="order" name="order" value="{{ $order }}" />
        <input type="hidden" name="brands" id="hdnBrands" />
        <input type="hidden" name="categories" id="hdnCategories" />
        <input type="hidden" name="sizes" id="hdnSizes" value="{{ $f_sizes ?? '' }}" />
        <input type="hidden" name="min" id="hdnMinPrice" value="{{ $min_price }}" />
        <input type="hidden" name="max" id="hdnMaxPrice" value="{{ $max_price }}" />
        <input type="hidden" name="ratings" id="hdnRatings" />
    </form>
@endsection

@push('scripts')
    <script>
        $(function() {
            $("#pagesize").on("change", function() {
                const selectedSize = $(this).val();
                $("#size").val(selectedSize);
                $("#frmfilter").submit(); // Submit form
            });

            $("#orderby").on("change", function() {
                const selectedOrder = $(this).val();
                $("#order").val(selectedOrder); // Update nilai order
                $("#frmfilter").submit(); // Submit form
            });

            $("input[name='brands']").on("change", function() {
                var brands = "";
                $("input[name='brands']:checked").each(function() {
                    if (brands == "") {
                        brands += $(this).val();
                    } else {
                        brands += "," + $(this).val();
                    }
                });
                $("#hdnBrands").val(brands);
                $("#frmfilter").submit();
            });

            $("input[name='categories']").on("change", function() {
                var categories = "";
                $("input[name='categories']:checked").each(function() {
                    if (categories == "") {
                        categories += $(this).val();
                    } else {
                        categories += "," + $(this).val();
                    }
                });
                $("#hdnCategories").val(categories);
                $("#frmfilter").submit();
            });

            $("[name='price_range']").on("change", function() {
                $("#hdnMinPrice").val($(this).val().split(',')[0]);
                $("#hdnMaxPrice").val($(this).val().split(',')[1]);
                $("#frmfilter").submit();
            });

            $(document).ready(function() {
                // Handle rating filter changes
                $("input[name='ratings']").on("change", function() {
                    var ratings = [];
                    $("input[name='ratings']:checked").each(function() {
                        ratings.push($(this).val());
                    });
                    $("#hdnRatings").val(ratings.join(
                        ',')); // Update hidden input with selected ratings
                    $("#frmfilter").submit(); // Submit the filter form
                });
            });

        });
    </script>

    <script>
        // Add this to your existing scripts
        $(document).ready(function() {
            // Make the grid view buttons work with active state
            $(".js-cols-size").on("click", function() {
                // Remove active class from all buttons
                $(".js-cols-size").removeClass("active");

                // Add active class to clicked button
                $(this).addClass("active");

                // Get the target grid and columns count
                const target = $(this).data("target");
                const cols = $(this).data("cols");

                // Update the grid with the new column count
                const $grid = $("#" + target);

                // First, remove any existing column classes
                $grid.removeClass("row-cols-1 row-cols-md-2 row-cols-md-3 row-cols-md-4");

                // Add the new column classes based on the selected value
                if (cols == 2) {
                    $grid.addClass("row-cols-1 row-cols-md-2");
                } else if (cols == 3) {
                    $grid.addClass("row-cols-1 row-cols-md-3");
                } else if (cols == 4) {
                    $grid.addClass("row-cols-1 row-cols-md-4");
                }
            });

            // Set default active state for grid view (3 columns)
            $(".js-cols-size[data-cols='3']").addClass("active");

            // Example of how to show active filters
            // You can implement this based on your actual filter logic
            function updateActiveFilters() {
                const activeFilters = [];

                // Check for active category filters
                $("input[name='categories']:checked").each(function() {
                    const categoryName = $(this).closest("li").text().trim();
                    activeFilters.push({
                        type: 'category',
                        id: $(this).val(),
                        name: categoryName
                    });
                });

                // Check for active brand filters
                $("input[name='brands']:checked").each(function() {
                    const brandName = $(this).closest("li").text().trim();
                    activeFilters.push({
                        type: 'brand',
                        id: $(this).val(),
                        name: brandName
                    });
                });

                // If there are active filters, show the container
                if (activeFilters.length > 0) {
                    $("#activeFilters").removeClass("d-none");

                    // Clear existing tags
                    $(".active-filters-tags").empty();

                    // Add a tag for each filter
                    activeFilters.forEach(filter => {
                        const $tag = $(`
                    <div class="filter-tag" data-type="${filter.type}" data-id="${filter.id}">
                        ${filter.name}
                        <button type="button" class="btn-close btn-close-sm ms-2" aria-label="Remove filter"></button>
                    </div>
                `);

                        $(".active-filters-tags").append($tag);
                    });
                } else {
                    $("#activeFilters").addClass("d-none");
                }
            }

            // Call this function when page loads and when filters change
            updateActiveFilters();

            // Handle filter removal
            $(document).on("click", ".filter-tag .btn-close", function() {
                const $tag = $(this).closest(".filter-tag");
                const type = $tag.data("type");
                const id = $tag.data("id");

                // Uncheck the corresponding checkbox
                if (type === 'category') {
                    $(`input[name='categories'][value='${id}']`).prop("checked", false).trigger("change");
                } else if (type === 'brand') {
                    $(`input[name='brands'][value='${id}']`).prop("checked", false).trigger("change");
                }

                // Update the active filters display
                updateActiveFilters();
            });

            // Handle "Clear All" button
            $("#clearAllFilters").on("click", function() {
                // Uncheck all filter checkboxes
                $("input[name='categories'], input[name='brands']").prop("checked", false).trigger(
                    "change");

                // Reset price range if applicable
                // This depends on how your price range slider is implemented

                // Update the active filters display
                updateActiveFilters();
            });

            // Bind to filter change events
            $("input[name='categories'], input[name='brands']").on("change", function() {
                updateActiveFilters();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Hapus binding sebelumnya jika ada, untuk menghindari duplikasi
            $('form[name="addtocart-form"]').off('submit').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        // Update jumlah item di navbar jika ada elemen dengan kelas .js-cart-items-count
                        $('.js-cart-items-count').text(response.cartCount);

                        // Cari toast berdasarkan id unik produk
                        var productId = form.find('input[name="id"]').val();
                        var toastEl = document.getElementById('cart-toast-' + productId);
                        if (toastEl) {
                            toastEl.style.display = 'block'; // Pastikan toast muncul
                            var toast = new bootstrap.Toast(toastEl);
                            toast.show();
                        }
                    },
                    error: function() {
                        console.error('Gagal menambahkan produk ke keranjang.');
                    }
                });
            });
        });
    </script>

    <!-- Notification -->
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
        $(document).on('click', '#close-cart-notification', function() {
            const notification = $('#cart-notification');
            notification.removeClass('show');
            setTimeout(() => notification.css('display', 'none'), 300);
        });

        $(document).ready(function() {
            // Hapus binding sebelumnya jika ada, untuk menghindari duplikasi
            $('form[name="addtocart-form"]').off('submit').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();

                // Dapatkan nama produk untuk ditampilkan di notifikasi
                var productName = form.find('input[name="name"]').val();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        // Update jumlah item di navbar
                        $('.js-cart-items-count').text(response.cartCount);

                        // Tampilkan notifikasi dengan nama produk
                        showCartNotification(productName +
                            ' berhasil ditambahkan ke keranjang Anda.', true);
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

    <!-- Filter Ulasan -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all rating filter items
            const ratingItems = document.querySelectorAll('.rating-filter-item');
            const selectedRatingsInput = document.getElementById('selected-ratings');
            const clearFilterBtn = document.getElementById('clearRatingFilter');
            const allReviewsBadge = document.querySelector('.rating-filter-badge .badge');

            // "Semua Ulasan" badge click handler
            if (allReviewsBadge) {
                allReviewsBadge.addEventListener('click', function() {
                    // Clear rating filters and submit
                    selectedRatingsInput.value = '';
                    document.getElementById('hdnRatings').value = '';
                    document.getElementById('frmfilter').submit();
                });
            }

            // Clear filter button handler
            if (clearFilterBtn) {
                clearFilterBtn.addEventListener('click', function() {
                    selectedRatingsInput.value = '';
                    document.getElementById('hdnRatings').value = '';
                    document.getElementById('frmfilter').submit();
                });
            }

            // Add click event listener to each rating item
            ratingItems.forEach(item => {
                item.addEventListener('click', function() {
                    const rating = this.getAttribute('data-rating');

                    // Set this rating as the only active one
                    ratingItems.forEach(ri => ri.classList.remove('active'));
                    this.classList.add('active');

                    // Update hidden input with selected rating
                    selectedRatingsInput.value = rating;

                    // Update hdnRatings in the form and submit
                    document.getElementById('hdnRatings').value = rating;
                    document.getElementById('frmfilter').submit();
                });
            });

            // Add filter count to the section title if filters are active
            if (selectedRatingsInput.value) {
                const ratingHeader = document.querySelector('#accordion-heading-rating .accordion-button');
                if (ratingHeader && !ratingHeader.querySelector('.filter-active-status')) {
                    const statusBadge = document.createElement('span');
                    statusBadge.className = 'filter-active-status';
                    statusBadge.innerHTML = '<i class="fas fa-filter me-1"></i> Filter Aktif';
                    ratingHeader.appendChild(statusBadge);
                }
            }

            // Update active filters in the page header
            function updateActiveFiltersDisplay() {
                const activeFilters = document.getElementById('activeFilters');
                if (!activeFilters) return;

                const activeFiltersTags = activeFilters.querySelector('.active-filters-tags');
                if (!activeFiltersTags) return;

                // Collect all active filters
                let allActiveFilters = [];

                // Add rating filters
                const activeRating = selectedRatingsInput.value;
                if (activeRating) {
                    let ratingText = '';

                    // Create visual stars for rating display
                    for (let i = 1; i <= 5; i++) {
                        if (i <= activeRating) {
                            ratingText += '★'; // Filled star
                        } else {
                            ratingText += '☆'; // Empty star
                        }
                    }

                    allActiveFilters.push({
                        type: 'rating',
                        id: activeRating,
                        displayName: 'Ulasan: ' + ratingText
                    });
                }

                // Show rating filter in active filters if exists
                if (activeRating && allActiveFilters.length > 0) {
                    activeFilters.classList.remove('d-none');

                    // Find if rating filter tag already exists
                    let ratingTag = Array.from(activeFiltersTags.children).find(tag =>
                        tag.dataset.type === 'rating'
                    );

                    if (!ratingTag) {
                        // Create new rating filter tag
                        const filterInfo = allActiveFilters.find(f => f.type === 'rating');
                        if (filterInfo) {
                            const filterTag = document.createElement('div');
                            filterTag.className = 'filter-tag';
                            filterTag.dataset.type = 'rating';
                            filterTag.dataset.id = filterInfo.id;

                            filterTag.innerHTML = `
                                ${filterInfo.displayName}
                                <button type="button" class="btn-close btn-close-sm ms-2" aria-label="Remove filter"></button>
                            `;

                            activeFiltersTags.appendChild(filterTag);

                            // Add click event to remove button
                            const removeBtn = filterTag.querySelector('.btn-close-sm');
                            if (removeBtn) {
                                removeBtn.addEventListener('click', function() {
                                    selectedRatingsInput.value = '';
                                    document.getElementById('hdnRatings').value = '';
                                    document.getElementById('frmfilter').submit();
                                });
                            }
                        }
                    }
                }
            }

            // Call on page load
            updateActiveFiltersDisplay();
        });
    </script>

    <!-- Filter ukuran -->
    <script>
        // Tambahkan kode berikut di bagian scripts
        $(function() {
            // Kode event handler yang sudah ada...

            // Handler untuk filter ukuran
            $(".js-filter-size").on("click", function() {
                // Toggle class active untuk visual feedback
                $(this).toggleClass("active btn-primary btn-outline-light");

                // Kumpulkan semua ukuran yang aktif
                var sizes = "";
                $(".js-filter-size.active").each(function() {
                    if (sizes == "") {
                        sizes += $(this).data("size-id");
                    } else {
                        sizes += "," + $(this).data("size-id");
                    }
                });

                // Update hidden input untuk ukuran
                $("#hdnSizes").val(sizes);

                // Submit form filter
                $("#frmfilter").submit();
            });

            // Tambahkan ini untuk menampilkan filter aktif
            function updateActiveFilters() {
                const activeFilters = [];

                // Check for active category filters
                $("input[name='categories']:checked").each(function() {
                    const categoryName = $(this).closest("li").text().trim();
                    activeFilters.push({
                        type: 'category',
                        id: $(this).val(),
                        name: categoryName
                    });
                });

                // Check for active brand filters
                $("input[name='brands']:checked").each(function() {
                    const brandName = $(this).closest("li").text().trim();
                    activeFilters.push({
                        type: 'brand',
                        id: $(this).val(),
                        name: brandName
                    });
                });

                // Check for active size filters
                $(".js-filter-size.active").each(function() {
                    const sizeName = $(this).text().trim().split('(')[
                        0]; // Get only the size name without count
                    activeFilters.push({
                        type: 'size',
                        id: $(this).data("size-id"),
                        name: "Ukuran: " + sizeName
                    });
                });

                // If there are active filters, show the container
                if (activeFilters.length > 0) {
                    $("#activeFilters").removeClass("d-none");

                    // Clear existing tags
                    $(".active-filters-tags").empty();

                    // Add a tag for each filter
                    activeFilters.forEach(filter => {
                        const $tag = $(`
                <div class="filter-tag" data-type="${filter.type}" data-id="${filter.id}">
                    ${filter.name}
                    <button type="button" class="btn-close btn-close-sm ms-2" aria-label="Remove filter"></button>
                </div>
            `);

                        $(".active-filters-tags").append($tag);
                    });
                } else {
                    $("#activeFilters").addClass("d-none");
                }
            }

            // Call updateActiveFilters on page load and when filters change
            updateActiveFilters();

            // Handle tag removal for sizes
            $(document).on("click", ".filter-tag .btn-close", function() {
                const $tag = $(this).closest(".filter-tag");
                const type = $tag.data("type");
                const id = $tag.data("id");

                if (type === 'size') {
                    // Find and click the size button to toggle it off
                    $(`.js-filter-size[data-size-id="${id}"]`).removeClass("active btn-primary").addClass(
                        "btn-outline-light");

                    // Update hidden input
                    var sizes = "";
                    $(".js-filter-size.active").each(function() {
                        if (sizes == "") {
                            sizes += $(this).data("size-id");
                        } else {
                            sizes += "," + $(this).data("size-id");
                        }
                    });
                    $("#hdnSizes").val(sizes);
                    $("#frmfilter").submit();
                }
                // ...other filter tag removal handlers...
            });

            // Clear all filters should also clear sizes
            $("#clearAllFilters").on("click", function() {
                // Reset size filter buttons
                $(".js-filter-size").removeClass("active btn-primary").addClass("btn-outline-light");
                $("#hdnSizes").val("");

                // Existing code for clearing other filters...

                // Submit the form
                $("#frmfilter").submit();
            });
        });
    </script>
@endpush

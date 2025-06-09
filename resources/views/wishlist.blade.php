@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <div class="row">
                <div class="col-12">
                    <div class="page-header-simple">
                        <h2 class="page-title">
                            <i class="fas fa-heart text-brown me-2"></i>
                            Daftar Favorit Saya
                        </h2>
                        <p class="page-subtitle">Kelola produk favorit Anda dengan mudah</p>
                    </div>
                </div>
            </div>

            <div class="wishlist-container">
                @if (\Surfsidemedia\Shoppingcart\Facades\Cart::instance('wishlist')->content()->count() > 0)
                    <!-- Control Panel -->
                    <div class="wishlist-controls-panel mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="wishlist-info">
                                    <span class="items-count">
                                        <i class="fas fa-list-ul text-brown me-2"></i>
                                        <strong>{{ \Surfsidemedia\Shoppingcart\Facades\Cart::instance('wishlist')->content()->count() }}</strong>
                                        Produk dalam Favorit
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="wishlist-actions text-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-brown-outline btn-sm" id="sortWishlist">
                                            <i class="fas fa-sort me-1"></i> Urutkan
                                        </button>
                                        <button type="button" class="btn btn-brown-outline btn-sm" onclick="selectAllItems()">
                                            <i class="fas fa-check-square me-1"></i> Pilih Semua
                                        </button>
                                        <button type="button" class="btn btn-brown-outline btn-sm" onclick="moveSelectedToCart()" id="moveSelectedBtn" disabled>
                                            <i class="fas fa-shopping-cart me-1"></i> Pindah ke Keranjang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Search Bar -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="search-box">
                                    <div class="input-group">
                                        <span class="input-group-text bg-brown text-white">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control" id="searchWishlist" placeholder="Cari produk favorit...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="filter-box">
                                    <select class="form-select" id="priceFilter">
                                        <option value="">Semua Harga</option>
                                        <option value="low">Harga Rendah (< Rp 100.000)</option>
                                        <option value="medium">Harga Sedang (Rp 100.000 - 500.000)</option>
                                        <option value="high">Harga Tinggi (> Rp 500.000)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Wishlist Table -->
                    <div class="wishlist-table-container">
                        <div class="card wishlist-card">
                            <div class="card-body p-0">
                                <!-- Loading Overlay -->
                                <div class="loading-overlay" id="loadingOverlay" style="display: none;">
                                    <div class="spinner-container">
                                        <div class="spinner-border text-brown" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2 text-brown">Memproses...</p>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table wishlist-table mb-0">
                                        <thead class="wishlist-header">
                                            <tr>
                                                <th width="8%">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="selectAllCheckbox">
                                                    </div>
                                                </th>
                                                <th width="20%">Produk</th>
                                                <th width="35%">Detail</th>
                                                <th width="15%">Harga</th>
                                                <th width="22%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="wishlistTableBody">
                                            @foreach (\Surfsidemedia\Shoppingcart\Facades\Cart::instance('wishlist')->content() as $wishlistItem)
                                                <tr class="wishlist-item" data-product-name="{{ strtolower($wishlistItem->name) }}" data-price="{{ $wishlistItem->price }}">
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input item-checkbox" type="checkbox"
                                                                   value="{{ $wishlistItem->rowId }}" id="item-{{ $wishlistItem->rowId }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="wishlist-product-image">
                                                            <div class="image-container">
                                                                <img loading="lazy"
                                                                    src="{{ asset('uploads/products/thumbnails') }}/{{ $wishlistItem->model->image }}"
                                                                    alt="{{ $wishlistItem->name }}"
                                                                    class="product-image" />
                                                                <div class="image-overlay">
                                                                    <i class="fas fa-search-plus"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="wishlist-product-details">
                                                            <h5 class="product-name">{{ $wishlistItem->name }}</h5>
                                                            <div class="product-meta">
                                                                <span class="badge bg-brown-light text-brown">
                                                                    <i class="fas fa-tag me-1"></i>Favorit
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="price-container">
                                                            <span class="wishlist-product-price">{{ formatRupiah($wishlistItem->price) }}</span>
                                                            <div class="price-comparison mt-1">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action-buttons-container">
                                                            <div class="btn-group-vertical btn-group-sm w-100" role="group">
                                                                <form method="POST" class="move-to-cart-form"
                                                                    action="{{ route('wishlist.move.to.cart', ['rowId' => $wishlistItem->rowId]) }}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-brown btn-sm w-100 mb-2">
                                                                        <i class="fas fa-shopping-cart me-1"></i>
                                                                        Ke Keranjang
                                                                    </button>
                                                                </form>

                                                                <form method="POST" class="remove-from-wishlist-form"
                                                                    action="{{ route('wishlist.remove', ['rowId' => $wishlistItem->rowId]) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                                        <i class="fas fa-trash me-1"></i>
                                                                        Hapus
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Wishlist Footer Actions -->
                        <div class="wishlist-footer-actions mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="bulk-actions">
                                        <button class="btn btn-brown" onclick="moveAllToCart()" id="moveAllBtn">
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            Pindahkan Semua ke Keranjang
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <form method="POST" action="{{ route('wishlist.empty') }}" id="emptyWishlistForm">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-secondary" type="button" onclick="confirmEmptyWishlist()">
                                            <i class="fas fa-times-circle me-2"></i>
                                            Kosongkan Favorit
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Empty Wishlist State -->
                    <div class="empty-wishlist-container">
                        <div class="card empty-wishlist-card">
                            <div class="card-body text-center py-5">
                                <div class="empty-state-illustration mb-4">
                                    <div class="empty-heart-icon">
                                        <i class="fas fa-heart fa-4x text-brown-light"></i>
                                        <div class="floating-hearts">
                                            <i class="fas fa-heart heart-1"></i>
                                            <i class="fas fa-heart heart-2"></i>
                                            <i class="fas fa-heart heart-3"></i>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="empty-title mb-3">Daftar Favorit Masih Kosong</h3>
                                <p class="empty-message mb-4">
                                    Belum ada produk dalam daftar favorit Anda.
                                    <br>Mulai jelajahi koleksi produk kami dan tambahkan yang Anda sukai!
                                </p>
                                <div class="empty-actions">
                                    <a href="{{ route('shop.index') }}" class="btn btn-brown btn-lg">
                                        <i class="fas fa-store me-2"></i>
                                        Jelajahi Produk
                                    </a>
                                    <button class="btn btn-outline-brown btn-lg ms-2" onclick="showWishlistTips()">
                                        <i class="fas fa-lightbulb me-2"></i>
                                        Tips Berbelanja
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <!-- Modals -->
    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-brown text-white">
                    <h5 class="modal-title" id="confirmationModalLabel">
                        <i class="fas fa-question-circle me-2"></i>Konfirmasi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="confirmationMessage">Apakah Anda yakin ingin melakukan tindakan ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-brown" id="confirmButton">
                        <i class="fas fa-check me-1"></i>Ya, Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="me-auto">Berhasil</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="successMessage">
                Operasi berhasil dilakukan.
            </div>
        </div>
    </div>

    <style>
        /* Color Variables */
        :root {
            --brown-primary: #956a3b;
            --brown-dark: #7d593a;
            --brown-light: #b8956d;
            --brown-lighter: #f5f1ec;
            --brown-accent: #d4af8c;
        }

        /* Page Header */
        .page-header-simple {
            margin-bottom: 3rem;
            margin-top: 3.7rem;
            text-align: left;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
        }

        .page-title:after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--brown-primary);
            border-radius: 2px;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 0;
            margin-top: 0.5rem;
        }

        .text-brown {
            color: var(--brown-primary) !important;
        }

        .bg-brown {
            background-color: var(--brown-primary) !important;
        }

        .btn-brown {
            background-color: var(--brown-primary);
            border-color: var(--brown-primary);
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .btn-brown:hover {
            background-color: var(--brown-dark);
            border-color: var(--brown-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(149, 106, 59, 0.3);
        }

        .btn-brown-outline {
            background-color: transparent;
            border-color: var(--brown-primary);
            color: var(--brown-primary);
            transition: all 0.3s ease;
        }

        .btn-brown-outline:hover {
            background-color: var(--brown-primary);
            border-color: var(--brown-primary);
            color: #ffffff;
        }

        .btn-outline-brown {
            background-color: transparent;
            border-color: var(--brown-primary);
            color: var(--brown-primary);
        }

        .btn-outline-brown:hover {
            background-color: var(--brown-primary);
            border-color: var(--brown-primary);
            color: #ffffff;
        }

        .bg-brown-light {
            background-color: var(--brown-lighter) !important;
        }

        .text-brown-light {
            color: var(--brown-light) !important;
        }

        /* Controls Panel */
        .wishlist-controls-panel {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9ecef;
        }

        .items-count {
            font-size: 1.1rem;
            color: var(--brown-primary);
        }

        .search-box .input-group-text {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .search-box .form-control,
        .filter-box .form-select {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
            border-left: none;
            padding: 0.75rem 1rem;
        }

        .search-box .form-control:focus,
        .filter-box .form-select:focus {
            border-color: var(--brown-primary);
            box-shadow: 0 0 0 0.2rem rgba(149, 106, 59, 0.25);
        }

        /* Wishlist Card */
        .wishlist-card {
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: none;
            position: relative;
        }

        /* Loading Overlay */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            z-index: 10;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 15px;
        }

        .spinner-container {
            text-align: center;
        }

        /* Table Styles */
        .wishlist-header {
            background: linear-gradient(135deg, var(--brown-primary) 0%, var(--brown-dark) 100%);
        }

        .wishlist-header th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            padding: 1.2rem 1rem;
            border: none;
            color: #ffffff;
            position: relative;
        }

        .wishlist-item {
            transition: all 0.3s ease;
            border: none;
        }

        .wishlist-item:hover {
            background-color: var(--brown-lighter);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(149, 106, 59, 0.1);
        }

        .wishlist-item td {
            padding: 1.5rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }

        /* Product Image */
        .wishlist-product-image {
            display: flex;
            /* justify-content: center; */
            /* align-items: center; */
        }

        .image-container {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            transition: all 0.3s ease;
            border-radius: 12px;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(149, 106, 59, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: all 0.3s ease;
            border-radius: 12px;
        }

        .image-overlay i {
            color: #fff;
            font-size: 1.5rem;
        }

        .image-container:hover .image-overlay {
            opacity: 1;
        }

        .image-container:hover .product-image {
            transform: scale(1.1);
        }

        /* Product Details */
        .wishlist-product-details {
            padding: 0 0.5rem;
        }

        .product-name {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            line-height: 1.4;
        }

        .product-meta .badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
        }

        /* Price */
        .price-container {
            /* text-align: center; */
        }

        .wishlist-product-price {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--brown-primary);
            display: block;
        }

        .price-comparison {
            font-size: 0.8rem;
        }

        /* Action Buttons */
        .action-buttons-container {
            text-align: center;
        }

        .btn-group-vertical .btn {
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
            border-radius: 8px !important;
            margin-bottom: 0.5rem;
        }

        .btn-group-vertical .btn:last-child {
            margin-bottom: 0;
        }

        /* Footer Actions */
        .wishlist-footer-actions {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9ecef;
        }

        /* Empty State */
        .empty-wishlist-card {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: none;
            overflow: hidden;
        }

        .empty-state-illustration {
            position: relative;
            display: inline-block;
        }

        .empty-heart-icon {
            position: relative;
            display: inline-block;
        }

        .floating-hearts {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .floating-hearts i {
            position: absolute;
            opacity: 0;
            animation: floatHeart 3s infinite ease-in-out;
        }

        .heart-1 {
            top: -10px;
            left: -20px;
            animation-delay: 0s;
            font-size: 1rem;
        }

        .heart-2 {
            top: -15px;
            right: -15px;
            animation-delay: 1s;
            font-size: 0.8rem;
        }

        .heart-3 {
            bottom: -10px;
            left: 50%;
            animation-delay: 2s;
            font-size: 0.6rem;
        }

        @keyframes floatHeart {
            0%, 100% {
                opacity: 0;
                transform: translateY(0) scale(0.8);
            }
            50% {
                opacity: 1;
                transform: translateY(-20px) scale(1.2);
            }
        }

        .empty-title {
            font-weight: 700;
            color: var(--brown-primary);
            font-size: 1.8rem;
        }

        .empty-message {
            color: #6c757d;
            font-size: 1.1rem;
            line-height: 1.6;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Fade in animations */
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

        .wishlist-item {
            animation: fadeInUp 0.6s ease forwards;
        }

        .wishlist-item:nth-child(1) { animation-delay: 0.1s; }
        .wishlist-item:nth-child(2) { animation-delay: 0.2s; }
        .wishlist-item:nth-child(3) { animation-delay: 0.3s; }
        .wishlist-item:nth-child(4) { animation-delay: 0.4s; }
        .wishlist-item:nth-child(5) { animation-delay: 0.5s; }

        /* Responsive Design */
        @media (max-width: 991px) {
            .page-title {
                font-size: 1.6rem;
            }

            .wishlist-controls-panel {
                padding: 1rem;
            }

            .wishlist-actions {
                text-align: center !important;
                margin-top: 1rem;
            }

            .search-box, .filter-box {
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 767px) {
            .wishlist-table thead {
                display: none;
            }

            .wishlist-table,
            .wishlist-table tbody,
            .wishlist-table tr,
            .wishlist-table td {
                display: block;
                width: 100%;
            }

            .wishlist-item {
                margin-bottom: 1.5rem;
                border: 1px solid #e9ecef;
                border-radius: 15px;
                overflow: hidden;
                background: #fff;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            }

            .wishlist-item td {
                position: relative;
                padding: 1rem;
                border-bottom: 1px solid #f8f9fa;
                text-align: center;
            }

            .wishlist-item td:last-child {
                border-bottom: none;
            }

            .wishlist-item td:before {
                content: attr(data-title);
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.75rem;
                letter-spacing: 1px;
                color: var(--brown-primary);
                display: block;
                margin-bottom: 0.5rem;
            }

            .product-image {
                width: 120px;
                height: 120px;
            }

            .action-buttons-container .btn-group-vertical {
                flex-direction: row;
                gap: 0.5rem;
            }

            .action-buttons-container .btn-group-vertical .btn {
                flex: 1;
                margin-bottom: 0;
            }

            .wishlist-footer-actions .row {
                text-align: center;
            }

            .wishlist-footer-actions .col-md-6 {
                margin-bottom: 1rem;
            }

            .wishlist-footer-actions .col-md-6:last-child {
                margin-bottom: 0;
            }
        }

        /* Custom scrollbar */
        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: var(--brown-primary);
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: var(--brown-dark);
        }

        /* Checkbox styling */
        .form-check-input:checked {
            background-color: var(--brown-primary);
            border-color: var(--brown-primary);
        }

        .form-check-input:focus {
            border-color: var(--brown-primary);
            box-shadow: 0 0 0 0.25rem rgba(149, 106, 59, 0.25);
        }
    </style>

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize components
            initializeWishlistFeatures();

            // Add mobile responsive attributes
            addMobileAttributes();
        });

        function initializeWishlistFeatures() {
            // Search functionality
            const searchInput = document.getElementById('searchWishlist');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    filterWishlistItems(this.value);
                });
            }

            // Price filter
            const priceFilter = document.getElementById('priceFilter');
            if (priceFilter) {
                priceFilter.addEventListener('change', function() {
                    filterByPrice(this.value);
                });
            }

            // Checkbox functionality
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    itemCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateSelectedButtons();
                });
            }

            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectAllState();
                    updateSelectedButtons();
                });
            });

            // Sort functionality
            const sortButton = document.getElementById('sortWishlist');
            if (sortButton) {
                sortButton.addEventListener('click', function() {
                    sortWishlistItems();
                });
            }

            // Form submissions with loading
            initializeFormSubmissions();
        }

        function filterWishlistItems(searchTerm) {
            const rows = document.querySelectorAll('.wishlist-item');
            const term = searchTerm.toLowerCase().trim();

            rows.forEach(row => {
                const productName = row.dataset.productName;
                if (productName.includes(term)) {
                    row.style.display = '';
                    fadeIn(row);
                } else {
                    fadeOut(row);
                }
            });

            updateEmptyState();
        }

        function filterByPrice(priceRange) {
            const rows = document.querySelectorAll('.wishlist-item');

            rows.forEach(row => {
                const price = parseFloat(row.dataset.price);
                let showRow = true;

                switch(priceRange) {
                    case 'low':
                        showRow = price < 100000;
                        break;
                    case 'medium':
                        showRow = price >= 100000 && price <= 500000;
                        break;
                    case 'high':
                        showRow = price > 500000;
                        break;
                    default:
                        showRow = true;
                }

                if (showRow) {
                    row.style.display = '';
                    fadeIn(row);
                } else {
                    fadeOut(row);
                }
            });

            updateEmptyState();
        }

        function sortWishlistItems() {
            const tbody = document.getElementById('wishlistTableBody');
            const rows = Array.from(tbody.querySelectorAll('.wishlist-item'));

            // Toggle sort order
            const isAscending = tbody.dataset.sortOrder !== 'asc';
            tbody.dataset.sortOrder = isAscending ? 'asc' : 'desc';

            rows.sort((a, b) => {
                const priceA = parseFloat(a.dataset.price);
                const priceB = parseFloat(b.dataset.price);
                return isAscending ? priceA - priceB : priceB - priceA;
            });

            // Re-append sorted rows with animation
            showLoading();
            setTimeout(() => {
                rows.forEach(row => tbody.appendChild(row));
                hideLoading();

                // Update sort button text
                const sortButton = document.getElementById('sortWishlist');
                sortButton.innerHTML = `<i class="fas fa-sort me-1"></i> ${isAscending ? 'Termurah' : 'Termahal'}`;
            }, 500);
        }

        function selectAllItems() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = true;
                selectAllCheckbox.dispatchEvent(new Event('change'));
            }
        }

        function updateSelectAllState() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const checkedItems = document.querySelectorAll('.item-checkbox:checked');

            if (selectAllCheckbox) {
                selectAllCheckbox.checked = itemCheckboxes.length > 0 && checkedItems.length === itemCheckboxes.length;
                selectAllCheckbox.indeterminate = checkedItems.length > 0 && checkedItems.length < itemCheckboxes.length;
            }
        }

        function updateSelectedButtons() {
            const checkedItems = document.querySelectorAll('.item-checkbox:checked');
            const moveSelectedBtn = document.getElementById('moveSelectedBtn');

            if (moveSelectedBtn) {
                moveSelectedBtn.disabled = checkedItems.length === 0;
                moveSelectedBtn.innerHTML = checkedItems.length > 0
                    ? `<i class="fas fa-shopping-cart me-1"></i> Pindah ${checkedItems.length} Item`
                    : `<i class="fas fa-shopping-cart me-1"></i> Pindah ke Keranjang`;
            }
        }

        function moveSelectedToCart() {
            const checkedItems = document.querySelectorAll('.item-checkbox:checked');
            if (checkedItems.length === 0) return;

            showConfirmation(
                `Pindahkan ${checkedItems.length} produk yang dipilih ke keranjang?`,
                () => {
                    showLoading();
                    // Process each selected item
                    const promises = Array.from(checkedItems).map(checkbox => {
                        const row = checkbox.closest('.wishlist-item');
                        const form = row.querySelector('.move-to-cart-form');
                        return submitFormAjax(form);
                    });

                    Promise.all(promises).then(() => {
                        hideLoading();
                        showSuccessToast(`${checkedItems.length} produk berhasil dipindahkan ke keranjang`);
                        setTimeout(() => location.reload(), 1000);
                    }).catch(() => {
                        hideLoading();
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    });
                }
            );
        }

        function moveAllToCart() {
            const itemCount = document.querySelectorAll('.wishlist-item').length;

            showConfirmation(
                `Pindahkan semua ${itemCount} produk ke keranjang?`,
                () => {
                    showLoading();
                    const forms = document.querySelectorAll('.move-to-cart-form');
                    const promises = Array.from(forms).map(form => submitFormAjax(form));

                    Promise.all(promises).then(() => {
                        hideLoading();
                        showSuccessToast(`Semua produk berhasil dipindahkan ke keranjang`);
                        setTimeout(() => location.reload(), 1000);
                    }).catch(() => {
                        hideLoading();
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    });
                }
            );
        }

        function confirmEmptyWishlist() {
            showConfirmation(
                'Hapus semua produk dari daftar favorit? Tindakan ini tidak dapat dibatalkan.',
                () => {
                    showLoading();
                    document.getElementById('emptyWishlistForm').submit();
                }
            );
        }

        function showWishlistTips() {
            alert('Tips Berbelanja:\n\n' +
                  '• Tambahkan produk ke favorit untuk memantau perubahan harga\n' +
                  '• Gunakan fitur pencarian untuk menemukan produk favorit dengan cepat\n' +
                  '• Pindahkan produk ke keranjang saat siap membeli\n' +
                  '• Periksa favorit secara rutin untuk penawaran khusus');
        }

        function initializeFormSubmissions() {
            // Individual move to cart forms
            document.querySelectorAll('.move-to-cart-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    showLoading();

                    submitFormAjax(this).then(() => {
                        hideLoading();
                        showSuccessToast('Produk berhasil dipindahkan ke keranjang');
                        setTimeout(() => location.reload(), 1000);
                    }).catch(() => {
                        hideLoading();
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    });
                });
            });

            // Individual remove forms
            document.querySelectorAll('.remove-from-wishlist-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const productName = this.closest('.wishlist-item').querySelector('.product-name').textContent;

                    showConfirmation(
                        `Hapus "${productName}" dari daftar favorit?`,
                        () => {
                            showLoading();
                            submitFormAjax(this).then(() => {
                                hideLoading();
                                showSuccessToast('Produk berhasil dihapus dari favorit');
                                setTimeout(() => location.reload(), 1000);
                            }).catch(() => {
                                hideLoading();
                                alert('Terjadi kesalahan. Silakan coba lagi.');
                            });
                        }
                    );
                });
            });
        }

        function submitFormAjax(form) {
            return new Promise((resolve, reject) => {
                const formData = new FormData(form);
                const url = form.action;
                const method = form.method;

                fetch(url, {
                    method: method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        resolve(data);
                    } else {
                        reject(data);
                    }
                })
                .catch(error => reject(error));
            });
        }

        function showLoading() {
            const overlay = document.getElementById('loadingOverlay');
            if (overlay) {
                overlay.style.display = 'flex';
            }
        }

        function hideLoading() {
            const overlay = document.getElementById('loadingOverlay');
            if (overlay) {
                overlay.style.display = 'none';
            }
        }

        function showConfirmation(message, callback) {
            const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            document.getElementById('confirmationMessage').textContent = message;

            document.getElementById('confirmButton').onclick = function() {
                modal.hide();
                callback();
            };

            modal.show();
        }

        function showSuccessToast(message) {
            const toast = new bootstrap.Toast(document.getElementById('successToast'));
            document.getElementById('successMessage').textContent = message;
            toast.show();
        }

        function fadeIn(element) {
            element.style.opacity = '0';
            element.style.display = '';
            element.style.transform = 'translateY(20px)';

            setTimeout(() => {
                element.style.transition = 'all 0.3s ease';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, 10);
        }

        function fadeOut(element) {
            element.style.transition = 'all 0.3s ease';
            element.style.opacity = '0';
            element.style.transform = 'translateY(-20px)';

            setTimeout(() => {
                element.style.display = 'none';
            }, 300);
        }

        function updateEmptyState() {
            const visibleRows = document.querySelectorAll('.wishlist-item[style=""], .wishlist-item:not([style])');
            const tableContainer = document.querySelector('.wishlist-table-container');
            const emptyMessage = document.querySelector('.search-empty-message');

            if (visibleRows.length === 0) {
                if (!emptyMessage) {
                    const message = document.createElement('div');
                    message.className = 'search-empty-message text-center py-5';
                    message.innerHTML = `
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4>Tidak ada produk yang sesuai</h4>
                        <p class="text-muted">Coba gunakan kata kunci atau filter yang berbeda</p>
                    `;
                    tableContainer.appendChild(message);
                }
            } else if (emptyMessage) {
                emptyMessage.remove();
            }
        }

        function addMobileAttributes() {
            // Add data-title attributes for mobile view
            const rows = document.querySelectorAll('.wishlist-item');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const titles = ['Pilih', 'Produk', 'Detail', 'Harga', 'Aksi'];

                cells.forEach((cell, index) => {
                    if (titles[index]) {
                        cell.setAttribute('data-title', titles[index]);
                    }
                });
            });
        }
    </script>
@endsection

@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <div class="row">
                <div class="col-12">
                    <h2 class="page-title mb-4" style="letter-spacing:1px; margin-bottom: 3.5rem !important;">Daftar Favorit
                    </h2>
                </div>
            </div>

            <div class="wishlist-container">
                @if (\Surfsidemedia\Shoppingcart\Facades\Cart::instance('wishlist')->content()->count() > 0)
                    <div class="wishlist-table-container">
                        <div class="card wishlist-card">
                            <div class="card-body p-0">
                                <table class="cart-table table wishlist-table">
                                    <thead class="wishlist-header">
                                        <tr>
                                            <th width="15%">Produk</th>
                                            <th width="40%">Detail</th>
                                            <th width="15%">Harga</th>
                                            <th width="30%" colspan="2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (\Surfsidemedia\Shoppingcart\Facades\Cart::instance('wishlist')->content() as $wishlistItem)
                                            <tr class="wishlist-item">
                                                <td>
                                                    <div class="wishlist-product-image">
                                                        <img loading="lazy"
                                                            src="{{ asset('uploads/products/thumbnails') }}/{{ $wishlistItem->model->image }}"
                                                            alt="{{ $wishlistItem->name }}" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="wishlist-product-details">
                                                        <h4 class="product-name">{{ $wishlistItem->name }}</h4>
                                                        {{-- <ul class="shopping-cart__product-item__options">
                                                <li>Color: Yellow</li>
                                                <li>Size: L</li>
                                            </ul> --}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="wishlist-product-price">{{ formatRupiah($wishlistItem->price) }}</span>
                                                </td>
                                                <td>
                                                    <div class="wishlist-action">
                                                        <form method="POST"
                                                            action="{{ route('wishlist.move.to.cart', ['rowId' => $wishlistItem->rowId]) }}">
                                                            @csrf
                                                            <button type="submit" class="move-to-cart btn btn-warning">
                                                                <i class="fa fa-shopping-cart"></i> Pindahkan ke Keranjang
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="wishlist-action">
                                                        <form method="POST"
                                                            action="{{ route('wishlist.remove', ['rowId' => $wishlistItem->rowId]) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="remove-wishlist btn btn-outline-danger">
                                                                <i class="fa fa-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="wishlist-footer mt-4">
                            <div class="row">
                                <div class="col-12 text-end">
                                    <form method="POST" action="{{ route('wishlist.empty') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="empty-wishlist btn btn-outline-secondary" type="submit">
                                            <i class="fa fa-times-circle"></i> KOSONGKAN DAFTAR FAVORIT
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="empty-wishlist-container text-center">
                        <div class="card">
                            <div class="card-body p-5">
                                <div class="empty-wishlist-icon mb-4">
                                    <i class="fa fa-heart-o fa-4x text-muted"></i>
                                </div>
                                <h3 class="empty-title mb-3">Daftar Favorit Anda Kosong</h3>
                                <p class="empty-message mb-4">Tidak ada produk dalam Daftar Favorit Anda saat ini</p>
                                <a href="{{ route('shop.index') }}" class="btn btn-primary add-products-btn">
                                    <i class="fa fa-plus-circle"></i> Tambahkan Produk ke Favorit
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <style>
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-top: 60px !important;
            position: relative;
            padding-bottom: 10px;
        }

        .page-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: #956a3b;
        }

        .wishlist-container {
            margin-bottom: 60px;
        }

        .wishlist-card {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .wishlist-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .wishlist-header {
            background-color: #f8f9fa;
        }

        .wishlist-header th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            padding: 18px 15px;
            border-bottom: 2px solid #e9ecef;
            color: #495057;
        }

        .wishlist-table {
            margin-bottom: 0;
        }

        .wishlist-item {
            transition: all 0.3s ease;
        }

        .wishlist-item:hover {
            background-color: #f8f9fa;
        }

        .wishlist-item td {
            padding: 20px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
        }

        .wishlist-product-image {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .wishlist-product-image img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .wishlist-product-image img:hover {
            transform: scale(1.05);
        }

        .wishlist-product-details {
            padding: 0 10px;
        }

        .product-name {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: #343a40;
        }

        .wishlist-product-price {
            font-weight: 700;
            font-size: 1.1rem;
            color: #956a3b;
        }

        .wishlist-action {
            display: flex;
            justify-content: center;
        }

        .move-to-cart {
            background-color: #956a3b !important;
            border-color: #956a3b !important;
            color: #ffffff !important;
            transition: all 0.3s ease;
            border-radius: 5px;
            padding: 8px 15px;
            font-size: 0.9rem;
            width: 100%;
        }

        .move-to-cart:hover {
            background-color: #7d593a !important;
            transform: translateY(-2px);
        }

        .remove-wishlist {
            transition: all 0.3s ease;
            border-radius: 5px;
            padding: 8px 15px;
            font-size: 0.9rem;
            width: 100%;
        }

        .remove-wishlist:hover {
            background-color: #dc3545;
            color: #fff;
            transform: translateY(-2px);
        }

        .wishlist-footer {
            display: flex;
            justify-content: flex-end;
        }

        .empty-wishlist {
            font-size: 0.9rem;
            transition: all 0.3s ease;
            padding: 10px 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .empty-wishlist:hover {
            background-color: #dee2e6;
        }

        .empty-wishlist-container {
            padding: 40px 0;
        }

        .empty-wishlist-icon {
            color: #adb5bd;
        }

        .empty-title {
            font-weight: 600;
            color: #495057;
        }

        .empty-message {
            color: #6c757d;
            max-width: 500px;
            margin: 0 auto;
        }

        .add-products-btn {
            background-color: #956a3b;
            border-color: #956a3b;
            color: #ffffff;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .add-products-btn:hover {
            background-color: #7d593a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(149, 106, 59, 0.3);
        }

        /* Animate wishlist items on page load */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .wishlist-item {
            animation: fadeInUp 0.5s ease forwards;
        }

        .wishlist-item:nth-child(2) {
            animation-delay: 0.1s;
        }

        .wishlist-item:nth-child(3) {
            animation-delay: 0.2s;
        }

        .wishlist-item:nth-child(4) {
            animation-delay: 0.3s;
        }

        .wishlist-item:nth-child(5) {
            animation-delay: 0.4s;
        }

        /* Button ripple effect */
        .btn {
            position: relative;
            overflow: hidden;
        }

        .btn:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }

            100% {
                transform: scale(100, 100);
                opacity: 0;
            }
        }

        .btn:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }

        /* Responsive styles */
        @media (max-width: 991px) {

            .wishlist-header th,
            .wishlist-item td {
                padding: 15px 10px;
            }

            .product-name {
                font-size: 1rem;
            }

            .wishlist-product-price {
                font-size: 1rem;
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
                text-align: center;
            }

            .wishlist-item {
                margin-bottom: 20px;
                border: 1px solid #dee2e6;
                border-radius: 8px;
                overflow: hidden;
            }

            .wishlist-item td {
                position: relative;
                padding: 15px;
                border-bottom: none;
            }

            .wishlist-item td:before {
                content: attr(data-title);
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.75rem;
                letter-spacing: 1px;
                color: #6c757d;
                display: block;
                margin-bottom: 5px;
            }

            .wishlist-product-image img {
                width: 80px;
                height: 80px;
            }

            .wishlist-action {
                margin-top: 10px;
            }

            .move-to-cart,
            .remove-wishlist {
                width: 100%;
                margin: 5px 0;
            }
        }
    </style>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effect to wishlist items
            const wishlistItems = document.querySelectorAll('.wishlist-item');
            wishlistItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f8f9fa';
                });

                item.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });

            // Add ripple effect to buttons
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('mousedown', function(e) {
                    const x = e.clientX - e.target.getBoundingClientRect().left;
                    const y = e.clientY - e.target.getBoundingClientRect().top;

                    const ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    ripple.style.left = `${x}px`;
                    ripple.style.top = `${y}px`;

                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 700);
                });
            });


            // Add smooth transition when removing items
            const removeBtns = document.querySelectorAll('.remove-wishlist');
            removeBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const row = this.closest('.wishlist-item');
                    row.style.animation = 'fadeOut 0.5s ease forwards';
                });
            });
        });
    </script>
@endsection

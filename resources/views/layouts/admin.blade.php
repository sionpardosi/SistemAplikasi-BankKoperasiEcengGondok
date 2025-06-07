<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="surfside media" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('font/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('icon/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon-logo.ico') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('assets/images/favicon-logo.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')

</head>

<style>
    /* ===========================
       CLEAN & SIMPLE MENU STYLES
    =========================== */

    /* Enhanced Menu Category Headers */
    .menu-category-header {
        margin: 28px 20px 16px 20px;
        position: relative;
        display: flex;
        align-items: center;
        opacity: 0;
        animation: fadeInUp 0.6s ease forwards;
    }

    .menu-category-header::before,
    .menu-category-header::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg,
            transparent 0%,
            #e5e7eb 20%,
            #e5e7eb 80%,
            transparent 100%);
    }

    .menu-category-header::before {
        margin-right: 16px;
    }

    .menu-category-header::after {
        margin-left: 16px;
    }

    .menu-category-label {
        background: #ffffff;
        padding: 8px 18px;
        font-size: 11px;
        color: #6b7280;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        white-space: nowrap;
        position: relative;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.06);
    }

    /* Clean Menu Items */
    .menu-list .menu-item {
        margin-bottom: 6px;
        transform: translateX(-10px);
        opacity: 0;
        animation: slideInLeft 0.5s ease forwards;
    }

    .menu-list .menu-item:nth-child(1) { animation-delay: 0.1s; }
    .menu-list .menu-item:nth-child(2) { animation-delay: 0.15s; }
    .menu-list .menu-item:nth-child(3) { animation-delay: 0.2s; }
    .menu-list .menu-item:nth-child(4) { animation-delay: 0.25s; }
    .menu-list .menu-item:nth-child(5) { animation-delay: 0.3s; }

    .menu-item > a,
    .menu-item > .menu-item-button {
        position: relative;
        margin: 0 16px;
        border-radius: 10px;
        padding: 14px 16px;
        background: transparent;
        border: 1px solid transparent;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
    }

    .menu-item > a:hover,
    .menu-item > .menu-item-button:hover {
        background: #f8fafc;
        border-color: #e2e8f0;
        transform: translateX(4px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .menu-item > a .icon,
    .menu-item > .menu-item-button .icon {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        background: #f1f5f9;
        color: #64748b;
        font-size: 12px;
        margin-right: 12px;
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
    }

    .menu-item > a:hover .icon,
    .menu-item > .menu-item-button:hover .icon {
        background: #e2e8f0;
        color: #475569;
        transform: scale(1.05);
    }

    .menu-item > a .text,
    .menu-item > .menu-item-button .text {
        font-weight: 500;
        color: #374151;
        transition: color 0.3s ease;
        font-size: 14px;
    }

    .menu-item > a:hover .text,
    .menu-item > .menu-item-button:hover .text {
        color: #1f2937;
        font-weight: 600;
    }

    /* Clean Sub-menu Styles */
    .sub-menu {
        background: #fafbfc;
        border-radius: 10px;
        margin: 8px 16px 16px 16px;
        padding: 8px 0;
        border: 1px solid #e5e7eb;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8);
    }

    .sub-menu .sub-menu-item {
        margin: 2px 12px;
    }

    .sub-menu .sub-menu-item > a {
        padding: 10px 16px;
        border-radius: 8px;
        background: transparent;
        border: 1px solid transparent;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        align-items: center;
    }

    .sub-menu .sub-menu-item > a::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: #cbd5e1;
        transform: scaleY(0);
        transition: transform 0.3s ease;
        border-radius: 0 2px 2px 0;
    }

    .sub-menu .sub-menu-item > a:hover::before {
        transform: scaleY(1);
        background: #64748b;
    }

    .sub-menu .sub-menu-item > a:hover {
        background: rgba(248, 250, 252, 0.8);
        border-color: #e2e8f0;
        transform: translateX(6px);
    }

    .sub-menu .sub-menu-item > a .text {
        color: #6b7280;
        font-weight: 500;
        font-size: 13px;
        transition: all 0.3s ease;
        margin-left: 8px;
    }

    .sub-menu .sub-menu-item > a:hover .text {
        color: #374151;
        font-weight: 600;
    }

    /* Active States */
    .menu-item.active > a,
    .menu-item.active > .menu-item-button {
        background: #f8fafc;
        border-color: #cbd5e1;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .menu-item.active > a .icon,
    .menu-item.active > .menu-item-button .icon {
        background: #e2e8f0;
        color: #475569;
        border-color: #cbd5e1;
    }

    .menu-item.active > a .text,
    .menu-item.active > .menu-item-button .text {
        color: #1f2937;
        font-weight: 600;
    }

    /* Enhanced Dashboard Header */
    .center-heading {
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 24px 20px 20px 20px;
        color: #6b7280;
        position: relative;
        text-align: center;
        padding-bottom: 12px;
    }

    .center-heading::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 40px;
        height: 2px;
        background: #cbd5e1;
        border-radius: 1px;
    }

    /* Left Border Accent for Menu Items */
    .menu-item {
        position: relative;
    }

    .menu-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 0;
        background: #cbd5e1;
        border-radius: 0 2px 2px 0;
        transition: height 0.3s ease;
    }

    .menu-item:hover::before {
        height: 50%;
    }

    .menu-item.active::before {
        height: 70%;
        background: #64748b;
    }

    /* Smooth Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-15px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Clean Sidebar Background */
    .section-menu-left {
        background: #ffffff;
        border-right: 1px solid #e5e7eb;
        box-shadow: 2px 0 12px rgba(0, 0, 0, 0.06);
    }

    /* Enhanced Logo Area */
    .box-logo {
        padding: 24px 20px;
        border-bottom: 1px solid #e5e7eb;
        background: #fafbfc;
        position: relative;
    }

    .box-logo::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 20px;
        right: 20px;
        height: 1px;
        background: linear-gradient(90deg,
            transparent 0%,
            #cbd5e1 50%,
            transparent 100%);
    }

    /* Better Spacing */
    .center-item {
        padding-bottom: 20px;
    }

    /* Responsive Improvements */
    @media (max-width: 768px) {
        .menu-category-header {
            margin: 20px 16px 12px 16px;
        }

        .menu-category-label {
            font-size: 10px;
            padding: 6px 14px;
        }

        .menu-item > a,
        .menu-item > .menu-item-button {
            margin: 0 12px;
            padding: 12px 14px;
        }

        .sub-menu {
            margin: 6px 12px 12px 12px;
        }
    }

    /* Focus States for Accessibility */
    .menu-item > a:focus,
    .menu-item > .menu-item-button:focus,
    .sub-menu .sub-menu-item > a:focus {
        outline: 2px solid #cbd5e1;
        outline-offset: 2px;
    }

    /* Subtle hover indicators */
    .menu-item > a::after,
    .menu-item > .menu-item-button::after {
        content: '';
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 4px;
        background: #cbd5e1;
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .menu-item > a:hover::after,
    .menu-item > .menu-item-button:hover::after {
        opacity: 1;
    }

    .menu-item.active > a::after,
    .menu-item.active > .menu-item-button::after {
        opacity: 1;
        background: #64748b;
    }
</style>

<body class="body">
    <div id="wrapper">
        <div id="page" class="">
            <div class="layout-wrap">

                <div id="preload" class="preload-container">
                    <div class="preloading">
                        <span></span>
                    </div>
                </div>

                <div class="section-menu-left">
                    <div class="box-logo">
                        <a href="{{ route('admin.index') }}" id="site-logo-inner">
                            <img class="" id="logo_header" alt=""
                                src="{{ asset('assets/images/logo/logo.png') }}"
                                data-light="{{ asset('assets/images/logo/logo.png') }}"
                                data-dark="{{ asset('assets/images/logo/logo.png') }}">
                        </a>
                        <div class="button-show-hide">
                            <i class="icon-menu-left"></i>
                        </div>
                    </div>
                    <div class="center">
                        <div class="center-item">
                            <div class="center-heading">Dashboard Utama</div>
                            <ul class="menu-list">
                                <li class="menu-item active">
                                    <a href="{{ route('admin.index') }}" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Dashboard</div>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="center-item">
                            <ul class="menu-list">
                                <!-- ===== MANAJEMEN PRODUK ===== -->
                                <div class="menu-category-header">
                                    <span class="menu-category-label">Manajemen Produk</span>
                                </div>

                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                                        <div class="text">Produk</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.products') }}">
                                                <div class="text">Daftar Produk</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.product.add') }}">
                                                <div class="text">Tambah Produk</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Kategori</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.categories') }}">
                                                <div class="text">Daftar Kategori</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.category.add') }}">
                                                <div class="text">Tambah Kategori</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Brand</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.brands') }}">
                                                <div class="text">Daftar Merek</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.brand.add') }}">
                                                <div class="text">Tambah Merek</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <!-- ===== TRANSAKSI ===== -->
                                <div class="menu-category-header">
                                    <span class="menu-category-label">Transaksi & Laporan</span>
                                </div>

                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Pesanan Pelanggan</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.orders') }}">
                                                <div class="text">Kelola Pesanan</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="menu-item">
                                    <a href="{{ url('admin/laporanpenjualan') }}">
                                        <div class="icon"><i class="icon-user"></i></div>
                                        <div class="text">Laporan Penjualan</div>
                                    </a>
                                </li>

                                <!-- ===== SUMBER DAYA ===== -->
                                <div class="menu-category-header">
                                    <span class="menu-category-label">Sumber Daya</span>
                                </div>

                                <li class="menu-item has-children">
                                    <a href="#" class="menu-item-button">
                                        <div class="icon"><i class="icon-briefcase"></i></div>
                                        <div class="text">Lowongan Pekerjaan</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.jobs') }}">
                                                <div class="text">Daftar Lowongan</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.jobs.add') }}">
                                                <div class="text">Buat Lowongan</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="menu-item">
                                    <a href="{{ route('admin.data-pengguna.index') }}">
                                        <div class="icon"><i class="icon-user"></i></div>
                                        <div class="text">Manajemen Pengguna</div>
                                    </a>
                                </li>

                                <!-- ===== SUPPLY CHAIN ===== -->
                                <div class="menu-category-header">
                                    <span class="menu-category-label">Manajemen Pemasok</span>
                                </div>

                                <li class="menu-item has-children">
                                    <a href="#" class="menu-item-button">
                                        <div class="icon"><i class="icon-briefcase"></i></div>
                                        <div class="text">Pemasok</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.supplier.dashboard') }}">
                                                <div class="text">Dashboard Pemasok</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.supplier.index') }}">
                                                <div class="text">Permintaan Pemasok</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.penjadwalan.index') }}">
                                                <div class="text">Penjadwalan Penjemputan</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.adminsupplier.informasi_supplier.index') }}">
                                                <div class="text">Daftar Informasi Pemasok</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.adminsupplier.informasi_supplier.create') }}">
                                                <div class="text">Tambah Informasi Pemasok</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <!-- ===== MANAJEMEN STOK ===== -->
                                <div class="menu-category-header">
                                    <span class="menu-category-label">Manajemen Stok</span>
                                </div>

                                <li class="menu-item">
                                    <a href="{{ route('admin.stok.index') }}" class="">
                                        <div class="icon"><i class="icon-image"></i></div>
                                        <div class="text">Stok Bahan Baku</div>
                                    </a>
                                </li>

                                <!-- ===== KONTEN & MARKETING ===== -->
                                <div class="menu-category-header">
                                    <span class="menu-category-label">Konten & Promosi</span>
                                </div>

                                <li class="menu-item">
                                    <a href="{{ route('admin.slides') }}" class="">
                                        <div class="icon"><i class="icon-image"></i></div>
                                        <div class="text">Slides</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <a href="{{ route('admin.about.index') }}" class="">
                                        <div class="icon"><i class="icon-image"></i></div>
                                        <div class="text">Tentang</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <a href="{{ route('admin.coupons') }}" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Kupon</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <a href="{{ route('admin.contacts') }}" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Pesan dari Layanan</div>
                                    </a>
                                </li>

                                <!-- ===== SISTEM ===== -->
                                <div class="menu-category-header">
                                    <span class="menu-category-label">Sistem</span>
                                </div>

                                <li class="menu-item">
                                    <a href="settings.html" class="">
                                        <div class="icon"><i class="icon-settings"></i></div>
                                        <div class="text">Pengaturan</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                        @csrf
                                        <a href="{{ route('logout') }}" class=""
                                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                            <div class="icon"><i class="icon-settings"></i></div>
                                            <div class="text">Logout</div>
                                        </a>
                                    </form>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="section-content-right">
                    <div class="header-dashboard">
                        <div class="wrap">
                            <div class="header-left">
                                <a href="index-2.html">
                                    <img class="" id="logo_header_mobile" alt=""
                                        src="{{ asset('assets/images/logo/logo.png') }}"
                                        data-light="{{ asset('assets/images/logo/logo.png') }}"
                                        data-dark="{{ asset('assets/images/logo/logo.png') }}" data-width="154px"
                                        data-height="52px" data-retina="{{ asset('assets/images/logo/logo.png') }}">
                                </a>
                                <div class="button-show-hide">
                                    <i class="icon-menu-left"></i>
                                </div>

                                <form class="form-search flex-grow">
                                    <fieldset class="name">
                                        <input type="text" placeholder="Cari produk, pesanan, atau menu..." class="show-search"
                                            name="name" tabindex="2" value="" aria-required="true"
                                            required="">
                                    </fieldset>
                                    <div class="button-submit">
                                        <button class="" type="submit"><i class="icon-search"></i></button>
                                    </div>
                                    <div class="box-content-search" id="box-content-search">
                                        <ul class="mb-24">
                                            <li class="mb-14">
                                                <div class="body-title">Top selling product</div>
                                            </li>
                                            <li class="mb-14">
                                                <div class="divider"></div>
                                            </li>
                                            <li>
                                                <ul>
                                                    <li class="product-item gap14 mb-10">
                                                        <div class="image no-bg">
                                                            <img src="images/products/17.png" alt="">
                                                        </div>
                                                        <div class="flex items-center justify-between gap20 flex-grow">
                                                            <div class="name">
                                                                <a href="product-list.html" class="body-text">Dog Food
                                                                    Rachael Ray Nutrish®</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="mb-10">
                                                        <div class="divider"></div>
                                                    </li>
                                                    <li class="product-item gap14 mb-10">
                                                        <div class="image no-bg">
                                                            <img src="images/products/18.png" alt="">
                                                        </div>
                                                        <div class="flex items-center justify-between gap20 flex-grow">
                                                            <div class="name">
                                                                <a href="product-list.html" class="body-text">Natural
                                                                    Dog Food Healthy Dog Food</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="mb-10">
                                                        <div class="divider"></div>
                                                    </li>
                                                    <li class="product-item gap14">
                                                        <div class="image no-bg">
                                                            <div class="name">
                                                                <a href="product-list.html" class="body-text">Freshpet
                                                                    Healthy Dog Food and Cat</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                        <ul class="">
                                            <li class="mb-14">
                                                <div class="body-title">Order product</div>
                                            </li>
                                            <li class="mb-14">
                                                <div class="divider"></div>
                                            </li>
                                            <li>
                                                <ul>
                                                    <li class="product-item gap14 mb-10">
                                                        <div class="image no-bg">
                                                            <img src="images/products/20.png" alt="">
                                                        </div>
                                                        <div class="flex items-center justify-between gap20 flex-grow">
                                                            <div class="name">
                                                                <a href="product-list.html" class="body-text">Sojos
                                                                    Crunchy Natural Grain Free...</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="mb-10">
                                                        <div class="divider"></div>
                                                    </li>
                                                    <li class="product-item gap14 mb-10">
                                                        <div class="image no-bg">
                                                            <img src="images/products/21.png" alt="">
                                                        </div>
                                                        <div class="flex items-center justify-between gap20 flex-grow">
                                                            <div class="name">
                                                                <a href="product-list.html"
                                                                    class="body-text">Sumondang</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="mb-10">
                                                        <div class="divider"></div>
                                                    </li>
                                                    <li class="product-item gap14 mb-10">
                                                        <div class="image no-bg">
                                                            <img src="images/products/22.png" alt="">
                                                        </div>
                                                        <div class="flex items-center justify-between gap20 flex-grow">
                                                            <div class="name">
                                                                <a href="product-list.html" class="body-text">Mega
                                                                    Pumpkin Bone</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="mb-10">
                                                        <div class="divider"></div>
                                                    </li>
                                                    <li class="product-item gap14">
                                                        <div class="image no-bg">
                                                            <img src="images/products/23.png" alt="">
                                                        </div>
                                                        <div class="flex items-center justify-between gap20 flex-grow">
                                                            <div class="name">
                                                                <a href="product-list.html" class="body-text">Mega
                                                                    Pumpkin Bone</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </form>

                            </div>
                            <div class="header-grid">

                                <div class="popup-wrap message type-header">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="header-item">
                                                <span
                                                    class="text-tiny">{{ DB::table('notifications')->where('status', 'unread')->count() }}</span>
                                                <i class="icon-bell"></i>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end has-content"
                                            aria-labelledby="dropdownMenuButton2">
                                            <li>
                                                <h6>Notifications</h6>
                                            </li>
                                            @foreach (DB::table('notifications')->where('status', 'unread')->orderBy('waktu', 'desc')->take(5)->get() as $notification)
                                                <li>
                                                    <div class="message-item">
                                                        <div class="image">
                                                            <i class="icon-noti-1"></i>
                                                            <!-- Ganti dengan ikon yang sesuai -->
                                                        </div>
                                                        <div>
                                                            <div class="body-title-2">{{ $notification->pesan }}</div>
                                                            <div class="text-tiny">
                                                                {{ \Carbon\Carbon::parse($notification->waktu)->diffForHumans() }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                            <li><a href="{{ url('admin/readall') }}" class="tf-button w-full">Read
                                                    all</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="popup-wrap user type-header">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="header-user wg-user">
                                                <span class="image">
                                                    <img src="images/avatar/user-1.png" alt="">
                                                </span>
                                                <span class="flex flex-column">
                                                    <span class="body-title mb-2">Sumondang</span>
                                                    <span class="text-tiny">Admin</span>
                                                </span>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end has-content"
                                            aria-labelledby="dropdownMenuButton3">
                                            <li>
                                                <a href="#" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-user"></i>
                                                    </div>
                                                    <div class="body-title-2">Account</div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-mail"></i>
                                                    </div>
                                                    <div class="body-title-2">Inbox</div>
                                                    <div class="number">27</div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-file-text"></i>
                                                    </div>
                                                    <div class="body-title-2">Taskboard</div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-headphones"></i>
                                                    </div>
                                                    <div class="body-title-2">Support</div>
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('logout') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="user-item">
                                                        <div class="icon">
                                                            <i class="icon-log-out"></i>
                                                        </div>
                                                        <div class="body-title-2">Log out</div>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="main-content">

                        @yield('content')

                        <div class="bottom-page">
                            <div class="body-text">Copyright © 2025 BankKoperasiEcengGondok</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        // Enhanced Menu Interactions - Simple & Clean
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth menu animations
            const menuItems = document.querySelectorAll('.menu-item');

            menuItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.05}s`;
            });

            // Category headers scroll animation
            const categoryHeaders = document.querySelectorAll('.menu-category-header');
            const observerOptions = {
                threshold: 0.3,
                rootMargin: '0px 0px -30px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            }, observerOptions);

            categoryHeaders.forEach(header => {
                observer.observe(header);
            });
        });

        // Kecamatan-Desa data (existing functionality)
        const kecamatanDesaData = {
            "Harian": ["Dolok Raja", "Hariara Pintu", "Hariara Pohan", "Huta Galung", "Janji Martahan",
                "Partungko Naginjang", "Sampur Toba", "Siparmahan", "Sosor Dolok", "Turpuk Limbong", "Turpuk Malau",
                "Turpuk Sagala", "Turpuk Sihotang"
            ],
            "Nainggolan": ["Huta Rihit", "Janji Marapot", "Nainggolan", "Pananggangan", "Pananggangan II", "Pangaloan",
                "Pasaran I", "Pasaran Parsaoran", "Sibonor Ompu Ratus", "Sinaga Uruk Pandiangan", "Sipinggan",
                "Sipinggan Lumban Siantar", "Toguan Galung", "Parhusip III", "Siruma Hombar"
            ],
            "Onan Runggu": ["Harian", "Huta Hotang", "Janji Matogu", "Onan Runggu", "Pakpahan", "Pardomuan",
                "Rinabolak", "Silima Lombu", "Sipira", "Sitamiang", "Sitinjak", "Tambun Sungkean"
            ],
            "Palipi": ["Gorat Pallombuan", "Hatoguan", "Huta Dame", "Huta Ginjang", "Palipi", "Pallombuan", "Pamutaran",
                "Pardomuan Nauli", "Parsaoran Urat", "Saor Nauli Hatoguan", "Sideak", "Sigaol Marbun",
                "Sigaol Simbolon", "Simbolon Purba", "Suhut Nihuta Pardomuan", "Urat II", "Urat Timur"
            ],
            "Pangururan": ["Aek Nauli", "Huta Bolon", "Huta Namora", "Huta Tinggi", "Lumban Pinggol",
                "Lumban Suhi Suhi Dolok", "Lumban Suhi Suhi Toruan", "Panampangan", "Parbaba Dolok", "Pardomuan I",
                "Pardomuan Nauli", "Pardugul", "Parhorasan", "Parlondut", "Parsaoran I", "Rianiate", "Sait Nihuta",
                "Sialanguan", "Sianting-anting", "Sinabulan", "Siopat Sosor", "Sitolu Huta", "Situngkir",
                "Tanjung Bunga", "Pasar Pangururan", "Pintu Sona", "Siogung-ogung"
            ],
            "Ronggur Nihuta": ["Lintong Nihuta", "Paraduan", "Ronggur Nihuta", "Sabungan Nihuta", "Salaon Dolok",
                "Salaon Toba", "Salaon Tonga-Tonga", "Sijambur"
            ],
            "Sianjur Mulamula": ["Aek Sipitudai", "Boho", "Bonan Dolok", "Ginolat", "Habeahan Naburahan", "Hasinggaan",
                "Huta Ginjang", "Huta Gurgur", "Sari Marihit", "Sianjur Mulamula", "Siboro", "Singkam"
            ],
            "Simanindo": ["Ambarita", "Cinta Dame", "Dosroha", "Garoga", "Huta Ginjang", "Maduma", "Marlumba",
                "Martoba", "Parbalohan", "Pardomuan", "Parmonangan", "Siallagan Pinda Raya", "Sihusapi",
                "Simanindo", "Simanindo Sangkal", "Simarmata", "Tanjungan", "Tomok", "Tomok Parsaoran", "Unjur",
                "Tuktuk Siadong"
            ],
            "Sitio-tio": ["Buntu Mauli", "Cinta Maju", "Holbung", "Janji Maria", "Janji Raja", "Parsaoran", "Sabulan",
                "Tamba Dolok"
            ],
        };

        // Kecamatan-Desa functionality
        document.addEventListener('DOMContentLoaded', function() {
            const kecamatanSelect = document.getElementById('kecamatan');
            const desaSelect = document.getElementById('desa');

            if (kecamatanSelect && desaSelect) {
                kecamatanSelect.addEventListener('change', function() {
                    const selectedKecamatan = this.value;
                    desaSelect.innerHTML = '<option value="">-- Pilih Desa --</option>';

                    if (kecamatanDesaData[selectedKecamatan]) {
                        kecamatanDesaData[selectedKecamatan].forEach(function(desa) {
                            const option = document.createElement('option');
                            option.value = desa;
                            option.textContent = desa;
                            desaSelect.appendChild(option);
                        });
                        desaSelect.disabled = false;
                    } else {
                        desaSelect.disabled = true;
                    }
                });
            }
        });
    </script>

    @stack('scripts')

</body>

</html>

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
    /* Menu Separator Styles - Tambahkan ini ke css/custom.css */
    .menu-separator {
        margin: 24px 0;
        position: relative;
        text-align: center;
    }

    .menu-separator::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #e0e0e0 20%, #e0e0e0 80%, transparent);
        transform: translateY(-50%);
    }

    .menu-separator-label {
        background: #fff;
        padding: 0 16px;
        font-size: 11px;
        color: #6c757d;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        position: relative;
        z-index: 1;
    }

    /* Alternative simple line separator */
    .separator-line {
        margin: 20px 16px;
        height: 1px;
        background: linear-gradient(90deg, transparent, #e9ecef 20%, #e9ecef 80%, transparent);
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
                            <div class="center-heading">Main Home</div>
                            <ul class="menu-list">
                                <li class="menu-item">
                                    <a href="{{ route('admin.index') }}" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Dashboard</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="center-item">
                            {{-- ==========================================
                            Menu Produk Admin
                            ========================================== --}}
                            <ul class="menu-list">
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Pesanan Pelanggan</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.orders') }}" class="">
                                                <div class="text">Lihat Pesanan</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="menu-item has-children">
                                    {{-- Tombol Menu Utama --}}
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon">
                                            <i class="icon-shopping-cart"></i>
                                        </div>
                                        <div class="text">Produk</div>
                                    </a>
                                    {{-- Sub Menu --}}
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.products') }}" class="">
                                                <div class="text">Produk</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.product.add') }}" class="">
                                                <div class="text">Tambah Produk</div>
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
                                            <a href="{{ route('admin.brands') }}" class="">
                                                <div class="text">Merek</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.brand.add') }}" class="">
                                                <div class="text">Tambah Merek</div>
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
                                            <a href="{{ route('admin.categories') }}" class="">
                                                <div class="text">Kategori</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.category.add') }}" class="">
                                                <div class="text">Tambah Kategori</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>


                                <li class="menu-item">
                                    <a href="{{ url('admin/laporanpenjualan') }}" class="">
                                        <div class="icon"><i class="icon-user"></i></div>
                                        <div class="text">Laporan Penjualan</div>
                                    </a>
                                </li>

                                <li class="menu-item has-children">
                                    <a href="#" class="menu-item-button">
                                        <div class="icon"><i class="icon-briefcase"></i></div>
                                        <div class="text">Lowongan Pekerjaan</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.jobs') }}" class="">
                                                <div class="text">Lowongan Kerja</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.jobs.add') }}" class="">
                                                <div class="text">Tambah Lowongan Kerja</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <div class="menu-separator">
                                    <span class="menu-separator-label">Manajemen Pemasok</span>
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
                                    </ul>
                                    <ul class="sub-menu">
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

                                <div class="menu-separator">
                                    <span class="menu-separator-label">Manajemen Stok</span>
                                </div>
                                <li class="menu-item">
                                    <a href="{{ route('admin.stok.index') }}" class="">
                                        <div class="icon"><i class="icon-image"></i></div>
                                        <div class="text">Stok Bahan Baku</div>
                                    </a>
                                </li>

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

                                <li class="menu-item">
                                    <a href="{{ route('admin.data-pengguna.index') }}">
                                        <div class="icon"><i class="icon-user"></i></div>
                                        <div class="text">Pengguna</div>
                                    </a>
                                </li>

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
                                        <input type="text" placeholder="Search here..." class="show-search"
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
                                                            <img src="images/products/19.png" alt="">
                                                        </div>
                                                        <div class="flex items-center justify-between gap20 flex-grow">
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
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>+
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
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
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kecamatanSelect = document.getElementById('kecamatan');
            const desaSelect = document.getElementById('desa');

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
        });
    </script>

    @stack('scripts')

</body>

</html>

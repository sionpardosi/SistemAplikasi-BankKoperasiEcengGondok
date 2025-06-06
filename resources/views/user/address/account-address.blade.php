@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Alamat Anda</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('layouts.account-nav')
                </div>
                <div class="col-lg-10">
                    <div class="page-content my-account__address">
                        <div class="row mb-4 align-items-center">
                            <div class="col-md-6">
                                <p class="notice">Alamat berikut akan digunakan pada halaman pembayaran secara default.</p>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ route('user.address.add-address') }}" class="btn btn-primary add-address-btn">
                                    <i class="fas fa-plus-circle mr-1"></i> Tambah Alamat
                                </a>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="my-account__address-list">
                            @if ($addresses->count() > 0)
                                <div class="address-grid">
                                    @foreach ($addresses as $address)
                                        <div class="address-card-wrapper">
                                            <div class="my-account__address-item card h-100 {{ $address->isdefault ? 'is-default' : '' }}">
                                                @if ($address->isdefault)
                                                    <div class="default-badge">
                                                        <i class="fas fa-check-circle"></i> Alamat Utama
                                                    </div>
                                                @endif
                                                <div class="card-header my-account__address-item__title">
                                                    <h5>
                                                        <i class="fas fa-map-marker-alt address-icon-title"></i>
                                                        {{ $address->name }}
                                                        @if ($address->isdefault)
                                                            <span class="badge badge-success ml-2">Default</span>
                                                        @endif
                                                    </h5>
                                                    <div class="dropdown address-actions">
                                                        {{-- <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                            type="button" id="addressActions{{ $address->id }}"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false" data-tooltip="Opsi Alamat">
                                                            Aksi
                                                        </button> --}}
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="addressActions{{ $address->id }}">
                                                            <a class="dropdown-item"
                                                                href="{{ route('user.address.edit-address', $address->id) }}">
                                                                <i class="fas fa-edit mr-2"></i> Edit
                                                            </a>

                                                            @if (!$address->isdefault)
                                                                <form
                                                                    action="{{ route('user.address.set-default', $address->id) }}"
                                                                    method="POST" class="dropdown-form">
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item">
                                                                        <i class="fas fa-star mr-2"></i> Jadikan Default
                                                                    </button>
                                                                </form>
                                                            @endif

                                                            @if ($addresses->count() > 1)
                                                                <form
                                                                    action="{{ route('user.address.delete-address', $address->id) }}"
                                                                    method="POST" class="dropdown-form"
                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus alamat ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item text-danger">
                                                                        <i class="fas fa-trash-alt mr-2"></i> Hapus
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body my-account__address-item__detail">
                                                    <div class="address-content">
                                                        <p><i class="fas fa-map-marker-alt address-icon"></i>
                                                            {{ $address->address }}</p>
                                                        <p>{{ $address->locality }}</p>
                                                        <p>{{ $address->city }}, {{ $address->state }}</p>
                                                        <p>{{ $address->country ?? 'Indonesia' }} - {{ $address->zip }}
                                                        </p>
                                                        <p><i class="fas fa-map-signs address-icon"></i> Patokan:
                                                            {{ $address->landmark }}</p>
                                                        <p class="mt-2"><i class="fas fa-phone address-icon"></i>
                                                            {{ $address->phone }}</p>
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-transparent">
                                                    <div class="d-flex justify-content-between">
                                                        <a href="{{ route('user.address.edit-address', $address->id) }}"
                                                            class="btn btn-sm btn-outline-primary" data-tooltip="Edit Alamat">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        @if (!$address->isdefault)
                                                            <form
                                                                action="{{ route('user.address.set-default', $address->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-success" data-tooltip="Jadikan Alamat Utama">
                                                                    <i class="fas fa-check-circle"></i> Jadikan Default
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info d-flex align-items-center">
                                    <i class="fas fa-info-circle mr-3 fa-2x"> </i>
                                    <div>
                                        Anda belum menambahkan alamat. Silakan
                                        <a href="{{ route('user.address.add-address') }}" class="alert-link">tambahkan
                                            alamat</a> baru.
                                    </div>
                                </div>
                                <div class="empty-address-container">
                                    <div class="empty-address-content">
                                        <div class="empty-address-icon">
                                            <i class="fas fa-map-marked-alt"></i>
                                        </div>
                                        <h4>Tambahkan Alamat Pengiriman Anda</h4>
                                        <p>Tambahkan alamat pengiriman untuk mempercepat proses checkout Anda berikutnya</p>
                                        <a href="{{ route('user.address.add-address') }}" class="btn btn-primary add-address-btn-lg">
                                            <i class="fas fa-plus-circle mr-1"></i> Tambah Alamat Baru
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        /* Gaya Dasar dan Variabel */
        :root {
            --primary-color: #6a6e51;
            --accent-color: #b9a16b;
            --success-color: #40c710;
            --danger-color: #f44032;
            --warning-color: #f5d700;
            --text-dark: #333333;
            --text-muted: #6c757d;
            --border-light: #e1e1e1;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 8px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 8px 16px rgba(0, 0, 0, 0.15);
            --border-radius: 8px;
            --transition-normal: all 0.3s ease;
        }

        :root {
            --primary-brown: #8B4513;
            --accent-brown: #D2B48C;
            --dark-brown: #654321;
            --light-brown: #F5E6D3;
            --cream: #FFF8DC;
            --gold: #DAA520;
            --success-green: #228B22;
            --danger-red: #DC143C;
            --warning-orange: #FF8C00;
            --info-blue: #4682B4;
            --text-dark: #2F1B14;
            --text-muted: #8B7355;
            --border-light: #E6DDD4;
            --shadow-subtle: 0 2px 8px rgba(139, 69, 19, 0.08);
            --shadow-elegant: 0 4px 20px rgba(139, 69, 19, 0.12);
            --shadow-prominent: 0 8px 32px rgba(139, 69, 19, 0.16);
            --border-radius-sm: 8px;
            --border-radius: 12px;
            --border-radius-lg: 16px;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* General */
        /* Typography */
        .page-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-top: 60px !important;
            margin-bottom: 2.5rem !important;
            position: relative;
            letter-spacing: -0.025em;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-brown), var(--gold));
            border-radius: 2px;
        }


        /* Improved CSS for address page */
        .my-account__address .notice {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        /* Address Grid Layout */
        .address-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            width: 100%;
        }

        .address-card-wrapper {
            min-height: 100%;
            width: 100%;
        }

        .my-account__address-item {
            border: 1px solid #eaeaea;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            height: 100%;
            position: relative;
        }

        .my-account__address-item:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-3px);
        }

        /* Default Address Styling */
        .my-account__address-item.is-default {
            /* border: 2px solid #28a745; */
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.15);
        }

        .default-badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #28a745;
            color: white;
            padding: 4px 10px;
            font-size: 12px;
            border-bottom-left-radius: 8px;
            z-index: 1;
            font-weight: 500;
        }

        .default-badge i {
            margin-right: 4px;
        }

        .my-account__address-item__title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #eaeaea;
        }

        .my-account__address-item__title h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            color: #333;
        }

        .address-icon-title {
            color: #956a3b;
            margin-right: 8px;
        }

        .my-account__address-item__title h5 .badge {
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 50px;
            font-weight: 500;
            margin-left: 10px;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .my-account__address-item__detail {
            padding: 18px;
        }

        .my-account__address-item__detail p {
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
            line-height: 1.5;
        }

        .address-icon {
            color: #956a3b;
            width: 18px;
            margin-right: 5px;
            text-align: center;
        }

        .address-content {
            position: relative;
        }

        /* Button styling */
        .add-address-btn {
            padding: 8px 16px;
            border-radius: 4px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 14px;
        }

        .add-address-btn-lg {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 6px;
        }

        .btn-primary {
            background-color: #956a3b;
            border-color: #956a3b;
        }

        .btn-primary:hover {
            background-color: #7d592f;
            border-color: #7d592f;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-outline-primary {
            color: #956a3b;
            border-color: #956a3b;
        }

        .btn-outline-primary:hover {
            background-color: #956a3b;
            color: white;
        }

        .btn-outline-success:hover {
            background-color: #28a745;
            color: white;
        }

        /* Empty Address State */
        .empty-address-container {
            padding: 40px 0;
            text-align: center;
        }

        .empty-address-content {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
        }

        .empty-address-icon {
            font-size: 48px;
            color: #956a3b;
            margin-bottom: 20px;
        }

        .empty-address-content h4 {
            margin-bottom: 15px;
            color: #333;
        }

        .empty-address-content p {
            color: #666;
            margin-bottom: 25px;
        }

        /* Dropdown styling fixes */
        .address-actions .dropdown-toggle {
            border-radius: 4px;
            color: #666;
        }

        .address-actions .dropdown-toggle:hover {
            background-color: #eee;
        }

        .dropdown-menu {
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #eaeaea;
            padding: 0.5rem 0;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f8f8;
        }

        .dropdown-item i {
            width: 16px;
            text-align: center;
        }

        /* Fix for dropdown form button issues */
        .dropdown-form {
            margin: 0;
            padding: 0;
        }

        .dropdown-form button.dropdown-item {
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            padding: 0.5rem 1rem;
        }

        .dropdown-form button.dropdown-item:hover {
            background-color: #f8f8f8;
        }

        /* Card footer styling */
        .card-footer {
            padding: 12px 15px;
            background-color: #f9f9f9;
            border-top: 1px solid #eaeaea;
        }

        .card-footer .btn {
            font-size: 12px;
            padding: 4px 10px;
        }

        /* Alert styling */
        .alert {
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .alert-success {
            border-left: 4px solid #28a745;
        }

        .alert-info {
            border-left: 4px solid #17a2b8;
        }

        /* Tooltip styling */
        [data-tooltip] {
            position: relative;
            cursor: pointer;
        }

        [data-tooltip]:before,
        [data-tooltip]:after {
            position: absolute;
            visibility: hidden;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
            z-index: 999;
        }

        [data-tooltip]:before {
            content: attr(data-tooltip);
            padding: 6px 10px;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            border-radius: 3px;
            width: max-content;
            max-width: 200px;
            font-size: 12px;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
        }

        [data-tooltip]:after {
            content: '';
            border-width: 6px;
            border-style: solid;
            border-color: rgba(0, 0, 0, 0.8) transparent transparent transparent;
            bottom: 113%;
            left: 50%;
            transform: translateX(-50%);
        }

        [data-tooltip]:hover:before,
        [data-tooltip]:hover:after {
            visibility: visible;
            opacity: 1;
        }

        /* Responsive styling */
        @media (max-width: 991px) {
            .address-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        @media (max-width: 767px) {
            .address-grid {
                grid-template-columns: 1fr;
            }

            .my-account__address-item {
                margin-bottom: 15px;
            }

            .text-right {
                text-align: left !important;
                margin-top: 15px;
            }

            .page-title {
                font-size: 22px;
            }

            .add-address-btn {
                width: 100%;
                margin-top: 10px;
            }
        }

        /* Hover effects */
        .alert-link:hover {
            text-decoration: underline;
        }

        /* Animation for success alert */
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

        .alert-success {
            animation: fadeIn 0.3s ease-out;
        }

        /* Button hover effects */
        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }
    </style>

    <!-- Include Font Awesome for icons - add this before the closing body tag -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <!-- Fix dropdown action buttons functionality and add tooltip support -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Make sure jQuery and Bootstrap are loaded
            if (typeof $ !== 'undefined' && typeof $.fn.dropdown !== 'undefined') {
                // Initialize all dropdowns
                $('.dropdown-toggle').dropdown();

                // Fix form submission in dropdowns
                $('.dropdown-form button').on('click', function(e) {
                    e.stopPropagation();
                });

                // Add tooltip functionality (optional if Bootstrap tooltips are available)
                if (typeof $.fn.tooltip !== 'undefined') {
                    $('[data-tooltip]').tooltip({
                        title: function() {
                            return $(this).attr('data-tooltip');
                        },
                        placement: 'top'
                    });
                }

                // Add subtle animation to address cards
                $('.my-account__address-item').each(function(index) {
                    $(this).css({
                        'animation': 'fadeIn 0.3s ease-out forwards',
                        'animation-delay': (index * 0.1) + 's',
                        'opacity': '0'
                    });
                });
            }
        });
    </script>
@endsection

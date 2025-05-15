@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section id="account-dashboard" class="my-account container">
            <div class="dashboard-header">
                <h2 class="page-title">Akun Saya</h2>
                <div class="welcome-badge">
                    <span class="last-login">Terakhir login: {{ now()->format('d M Y, H:i') }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('layouts.account-nav')
                </div>
                <div class="col-lg-9">
                    <div class="page-content my-account__dashboard dashboard-container">
                        <div class="welcome-section">
                            <div class="welcome-message">
                                <h3>Selamat Datang, <span class="user-name">{{ Auth::user()->name }}</span>!</h3>
                                <p class="welcome-subtitle">Kelola akun dan aktivitas belanja Anda dengan mudah.</p>
                            </div>
                        </div>

                        <div class="dashboard-cards">
                            <div class="row">
                                <!-- Card Pesanan -->
                                <div class="col-md-4 mb-4">
                                    <div class="dashboard-card">
                                        <div class="card-icon">
                                            <i class="fas fa-shopping-bag"></i>
                                        </div>
                                        <div class="card-content">
                                            <h4>Pesanan Saya</h4>
                                            <p>Lihat status dan riwayat pesanan Anda</p>
                                            <a href="{{ route('user.account.orders') }}" class="btn-dashboard">Lihat
                                                Pesanan</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Alamat -->
                                <div class="col-md-4 mb-4">
                                    <div class="dashboard-card">
                                        <div class="card-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="card-content">
                                            <h4>Alamat</h4>
                                            <p>Kelola alamat pengiriman Anda</p>
                                            <a href="{{ route('user.address.account-address') }}"
                                                class="btn-dashboard">Kelola Alamat</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Detail Akun -->
                                <div class="col-md-4 mb-4">
                                    <div class="dashboard-card">
                                        <div class="card-icon">
                                            <i class="fas fa-user-edit"></i>
                                        </div>
                                        <div class="card-content">
                                            <h4>Detail Akun</h4>
                                            <p>Ubah informasi profil dan kata sandi</p>
                                            <a href="{{route('user.accountdetails.update')}}" class="btn-dashboard">Edit Profil</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aktivitas Terbaru -->
                        <div class="recent-activity mt-4">
                            <h3 class="section-title">Aktivitas Terbaru</h3>
                            <div class="activity-timeline">
                                <div class="activity-item">
                                    <div class="activity-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h4>Login Berhasil</h4>
                                        <p class="activity-time">{{ now()->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>

                                <!-- Tambahkan item aktivitas lainnya sesuai data yang Anda miliki -->
                                <!-- Contoh: -->
                                <div class="activity-item">
                                    <div class="activity-icon">
                                        <i class="fas fa-sync"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h4>Profil Diperbarui</h4>
                                        <p class="activity-time">{{ now()->subDays(2)->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bantuan dan Tautan Cepat -->
                        <div class="quick-links mt-4">
                            <h3 class="section-title">Tautan Cepat</h3>
                            <div class="links-container">
                                <a href="{{ route('user.account.orders') }}" class="quick-link">
                                    <i class="fas fa-shopping-bag"></i> Pesanan Terbaru
                                </a>
                                <a href="{{ route('user.address.account-address') }}" class="quick-link">
                                    <i class="fas fa-map-marker-alt"></i> Alamat Pengiriman
                                </a>
                                {{-- <a href="account-details.html" class="quick-link">
                                    <i class="fas fa-user-edit"></i> Ubah Detail Akun
                                </a> --}}
                                <a href="{{route ('wishlist.index') }}" class="quick-link">
                                    <i class="fas fa-heart"></i> Daftar Favorit Saya
                                </a>
                            </div>
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

        /* Header dan Judul */
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-top: 60px !important;
            position: relative;
            display: inline-block;
            padding-bottom: 12px;
            letter-spacing: 1px;
            margin-bottom: 1.5rem !important;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--accent-color);
        }


        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .welcome-badge {
            background-color: #f8f9fa;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            color: #6c757d;
            border: 1px solid #e9ecef;
        }

        .dashboard-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .welcome-section {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #eaeaea;
        }

        .welcome-message h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .user-name {
            color: #b9a16b;
            font-weight: 600;
        }

        .welcome-subtitle {
            color: #6c757d;
            margin-bottom: 0;
        }

        /* Kartu Dashboard */
        .dashboard-cards {
            margin-bottom: 2rem;
        }

        .dashboard-card {
            height: 100%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            transition: all 0.3s ease;
            border-left: 4px solid #b9a16b;
            display: flex;
            flex-direction: column;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            font-size: 2rem;
            color: #b9a16b;
            margin-bottom: 1rem;
        }

        .card-content h4 {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
            color: #333;
        }

        .card-content p {
            color: #6c757d;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .btn-dashboard {
            display: inline-block;
            padding: 8px 15px;
            background-color: #f8f9fa;
            color: #333;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            margin-top: auto;
            text-align: center;
        }

        .btn-dashboard:hover {
            background-color: #b9a16b;
            color: #fff;
            border-color: #b9a16b;
        }

        /* Aktivitas Terbaru */
        .section-title {
            font-size: 1.3rem;
            margin-bottom: 1.25rem;
            color: #333;
            position: relative;
            padding-bottom: 10px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background-color: #b9a16b;
        }

        .activity-timeline {
            margin-top: 1.5rem;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.25rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid #eaeaea;
        }

        .activity-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .activity-icon {
            margin-right: 1rem;
            font-size: 1.25rem;
            color: #b9a16b;
        }

        .activity-content h4 {
            font-size: 1rem;
            margin-bottom: 5px;
            color: #333;
        }

        .activity-time {
            font-size: 0.85rem;
            color: #6c757d;
            margin: 0;
        }

        /* Tautan Cepat */
        .quick-links {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eaeaea;
        }

        .links-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
        }

        .quick-link {
            display: inline-flex;
            align-items: center;
            padding: 10px 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .quick-link i {
            margin-right: 8px;
            color: #b9a16b;
        }

        .quick-link:hover {
            background-color: #b9a16b;
            color: #fff;
            border-color: #b9a16b;
        }

        .quick-link:hover i {
            color: #fff;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .welcome-badge {
                margin-top: 1rem;
            }

            .links-container {
                flex-direction: column;
            }
        }
    </style>

    <!-- Font Awesome untuk ikon (tambahkan di bawah atau di header) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection

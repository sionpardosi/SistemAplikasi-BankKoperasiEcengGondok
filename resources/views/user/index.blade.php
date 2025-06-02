@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section id="account-dashboard" class="my-account container">

            <!-- Profile Header Section -->
            <div class="profile-header-card mb-4">
                <div class="cover-banner">
                    <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&h=200"
                         alt="Cover Banner" class="cover-image">
                    <div class="banner-overlay"></div>
                </div>

                <div class="profile-content">
                    <div class="profile-picture-section">
                        <div class="profile-picture-wrapper">
                            <img src="{{ Auth::user()->profile_picture ? asset(Auth::user()->profile_picture) : 'https://via.placeholder.com/100x100/6a6e51/ffffff?text=' . substr(Auth::user()->name, 0, 1) }}"
                                 alt="Profile Picture" class="profile-picture">
                            <a href="{{ route('user.accountdetails.account-details') }}" class="edit-icon" title="Edit Profil">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>

                    <div class="user-info">
                        <h2 class="user-name">Selamat Datang, {{ Auth::user()->name }}!</h2>
                        <p class="user-subtitle">Kelola akun dan aktivitas belanja Anda dengan mudah.</p>

                        <div class="user-badges mb-3">
                            @if(Auth::user()->email_verified_at)
                                <span class="badge verified-badge">
                                    <i class="fas fa-check-circle"></i> Email Terverifikasi
                                </span>
                            @else
                                <span class="badge unverified-badge">
                                    <i class="fas fa-exclamation-triangle"></i> Email Belum Terverifikasi
                                </span>
                            @endif
                            <span class="badge member-badge">
                                <i class="fas fa-star"></i> Member Premium
                            </span>
                        </div>

                        <div class="last-login-info">
                            <i class="fas fa-clock"></i> Terakhir login: {{ now()->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    @include('layouts.account-nav')
                </div>
                <div class="col-lg-9">
                    <div class="page-content my-account__dashboard dashboard-container">

                        <!-- Notifications Section -->
                        @if(!Auth::user()->email_verified_at)
                        <div class="notification-alert mb-4">
                            <div class="alert alert-warning d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-3"></i>
                                <div class="flex-grow-1">
                                    <strong>Email Belum Diverifikasi</strong>
                                    <p class="mb-0">Verifikasi email Anda untuk keamanan akun yang lebih baik.</p>
                                </div>
                                <a href="{{ route('user.accountdetails.account-details') }}" class="btn btn-sm btn-warning">Verifikasi</a>
                            </div>
                        </div>
                        @endif

                        <div class="dashboard-cards">
                            <div class="row">
                                <!-- Card Pesanan -->
                                <div class="col-md-4 mb-4">
                                    <div class="dashboard-card orders-card">
                                        <div class="card-header">
                                            <div class="card-icon">
                                                <i class="fas fa-shopping-bag"></i>
                                            </div>
                                            <div class="card-stats">
                                                <span class="stat-number">3</span>
                                                <span class="stat-label">Aktif</span>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <h4>Pesanan Saya</h4>
                                            <p>Lihat status dan riwayat pesanan Anda</p>
                                            <a href="{{ route('user.account.orders') }}" class="btn-dashboard">
                                                Lihat Pesanan <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Alamat -->
                                <div class="col-md-4 mb-4">
                                    <div class="dashboard-card address-card">
                                        <div class="card-header">
                                            <div class="card-icon">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                            <div class="card-stats">
                                                <span class="stat-number">2</span>
                                                <span class="stat-label">Alamat</span>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <h4>Alamat</h4>
                                            <p>Kelola alamat pengiriman Anda</p>
                                            <a href="{{ route('user.address.account-address') }}" class="btn-dashboard">
                                                Kelola Alamat <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Detail Akun -->
                                <div class="col-md-4 mb-4">
                                    <div class="dashboard-card profile-card">
                                        <div class="card-header">
                                            <div class="card-icon">
                                                <i class="fas fa-user-edit"></i>
                                            </div>
                                            <div class="card-stats">
                                                <span class="stat-icon {{ Auth::user()->email_verified_at ? 'verified' : 'unverified' }}">
                                                    <i class="fas {{ Auth::user()->email_verified_at ? 'fa-shield-check' : 'fa-shield-exclamation' }}"></i>
                                                </span>
                                                <span class="stat-label">{{ Auth::user()->email_verified_at ? 'Aman' : 'Perlu Verifikasi' }}</span>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <h4>Detail Akun</h4>
                                            <p>Ubah informasi profil dan kata sandi</p>
                                            <a href="{{route('user.accountdetails.account-details')}}" class="btn-dashboard">
                                                Edit Profil <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aktivitas Terbaru -->
                        <div class="recent-activity mt-4">
                            <h3 class="section-title">
                                <i class="fas fa-history me-2"></i>Aktivitas Terbaru
                            </h3>
                            <div class="activity-timeline">
                                <div class="activity-item">
                                    <div class="activity-icon success">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h4>Login Berhasil</h4>
                                        <p class="activity-time">{{ now()->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>

                                <div class="activity-item">
                                    <div class="activity-icon info">
                                        <i class="fas fa-sync"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h4>Profil Diperbarui</h4>
                                        <p class="activity-time">{{ now()->subDays(2)->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>

                                <div class="activity-item">
                                    <div class="activity-icon warning">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h4>Pesanan Dibuat</h4>
                                        <p class="activity-time">{{ now()->subDays(5)->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bantuan dan Tautan Cepat -->
                        <div class="quick-links mt-4">
                            <h3 class="section-title">
                                <i class="fas fa-external-link-alt me-2"></i>Tautan Cepat
                            </h3>
                            <div class="links-container">
                                <a href="{{ route('user.account.orders') }}" class="quick-link">
                                    <i class="fas fa-shopping-bag"></i> Pesanan Terbaru
                                </a>
                                <a href="{{ route('user.address.account-address') }}" class="quick-link">
                                    <i class="fas fa-map-marker-alt"></i> Alamat Pengiriman
                                </a>
                                <a href="{{route ('wishlist.index') }}" class="quick-link">
                                    <i class="fas fa-heart"></i> Daftar Favorit Saya
                                </a>
                                <a href="{{ route('user.accountdetails.account-details') }}" class="quick-link">
                                    <i class="fas fa-cog"></i> Pengaturan Akun
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
            --info-color: #17a2b8;
            --text-dark: #333333;
            --text-muted: #6c757d;
            --border-light: #e1e1e1;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 8px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 8px 16px rgba(0, 0, 0, 0.15);
            --border-radius: 8px;
            --transition-normal: all 0.3s ease;
        }

        /* Profile Header Card */
        .profile-header-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            margin-top: 1rem;
        }

        .cover-banner {
            position: relative;
            height: 160px;
            overflow: hidden;
        }

        .cover-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(106, 110, 81, 0.7), rgba(185, 161, 107, 0.5));
        }

        .profile-content {
            position: relative;
            padding: 0 30px 30px 30px;
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }

        .profile-picture-section {
            flex-shrink: 0;
            margin-top: -50px;
        }

        .profile-picture-wrapper {
            position: relative;
        }

        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: var(--shadow-md);
            transition: var(--transition-normal);
        }

        .profile-picture:hover {
            transform: scale(1.05);
        }

        .edit-icon {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 28px;
            height: 28px;
            background: var(--accent-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 0.8rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition-normal);
        }

        .edit-icon:hover {
            background: var(--primary-color);
            color: white;
            transform: scale(1.1);
        }

        .user-info {
            flex: 1;
            padding-top: 20px;
        }

        .user-name {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .user-subtitle {
            color: var(--text-muted);
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .user-badges {
            display: flex;
            gap: 8px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .verified-badge {
            background: rgba(64, 199, 16, 0.15);
            color: var(--success-color);
            border: 1px solid rgba(64, 199, 16, 0.3);
        }

        .unverified-badge {
            background: rgba(245, 215, 0, 0.15);
            color: #856404;
            border: 1px solid rgba(245, 215, 0, 0.3);
        }

        .member-badge {
            background: rgba(185, 161, 107, 0.15);
            color: var(--accent-color);
            border: 1px solid rgba(185, 161, 107, 0.3);
        }

        .last-login-info {
            color: var(--text-muted);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Enhanced Dashboard Cards */
        .dashboard-cards {
            margin-bottom: 2rem;
        }

        .dashboard-card {
            height: 100%;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            transition: var(--transition-normal);
            overflow: hidden;
            border-top: 4px solid var(--accent-color);
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .orders-card {
            border-top-color: var(--success-color);
        }

        .address-card {
            border-top-color: var(--info-color);
        }

        .profile-card {
            border-top-color: var(--accent-color);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 20px 0 20px;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: rgba(185, 161, 107, 0.1);
            color: var(--accent-color);
        }

        .orders-card .card-icon {
            background: rgba(64, 199, 16, 0.1);
            color: var(--success-color);
        }

        .address-card .card-icon {
            background: rgba(23, 162, 184, 0.1);
            color: var(--info-color);
        }

        .card-stats {
            text-align: right;
        }

        .stat-number {
            display: block;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--accent-color);
            line-height: 1;
        }

        .orders-card .stat-number {
            color: var(--success-color);
        }

        .address-card .stat-number {
            color: var(--info-color);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .stat-icon {
            font-size: 1.5rem;
            display: block;
            margin-bottom: 2px;
        }

        .stat-icon.verified {
            color: var(--success-color);
        }

        .stat-icon.unverified {
            color: var(--warning-color);
        }

        .card-content {
            padding: 15px 20px 20px 20px;
        }

        .card-content h4 {
            font-size: 1.2rem;
            margin-bottom: 8px;
            color: var(--text-dark);
            font-weight: 600;
        }

        .card-content p {
            color: var(--text-muted);
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .btn-dashboard {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background: transparent;
            color: var(--accent-color);
            border: 2px solid var(--accent-color);
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition-normal);
        }

        .btn-dashboard:hover {
            background: var(--accent-color);
            color: white;
            transform: translateX(3px);
        }

        .orders-card .btn-dashboard {
            color: var(--success-color);
            border-color: var(--success-color);
        }

        .orders-card .btn-dashboard:hover {
            background: var(--success-color);
            color: white;
        }

        .address-card .btn-dashboard {
            color: var(--info-color);
            border-color: var(--info-color);
        }

        .address-card .btn-dashboard:hover {
            background: var(--info-color);
            color: white;
        }

        /* Header dan Judul */
        .dashboard-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            transition: all 0.3s ease;
        }

        /* Enhanced Section Titles */
        .section-title {
            font-size: 1.3rem;
            margin-bottom: 1.25rem;
            color: var(--text-dark);
            position: relative;
            padding-bottom: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background-color: var(--accent-color);
        }

        /* Enhanced Activity Timeline */
        .activity-timeline {
            margin-top: 1.5rem;
            position: relative;
            padding-left: 60px;
        }

        .activity-timeline::before {
            content: '';
            position: absolute;
            left: 25px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #f0f0f0;
        }

        .activity-item {
            position: relative;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #f5f5f5;
        }

        .activity-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .activity-icon {
            position: absolute;
            left: -35px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.9rem;
            box-shadow: var(--shadow-sm);
        }

        .activity-icon.success {
            background: var(--success-color);
        }

        .activity-icon.info {
            background: var(--info-color);
        }

        .activity-icon.warning {
            background: var(--warning-color);
            color: #856404;
        }

        .activity-content h4 {
            font-size: 1rem;
            margin-bottom: 5px;
            color: var(--text-dark);
            font-weight: 600;
        }

        .activity-time {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin: 0;
            background: #f8f9fa;
            padding: 2px 8px;
            border-radius: 10px;
            display: inline-block;
        }

        /* Enhanced Quick Links */
        .quick-links {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eaeaea;
        }

        .links-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            margin-top: 1rem;
        }

        .quick-link {
            display: inline-flex;
            align-items: center;
            padding: 12px 16px;
            background-color: white;
            border: 2px solid #f0f0f0;
            border-radius: var(--border-radius);
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 500;
            transition: var(--transition-normal);
        }

        .quick-link i {
            margin-right: 10px;
            color: var(--accent-color);
            width: 16px;
        }

        .quick-link:hover {
            background-color: var(--accent-color);
            color: white;
            border-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .quick-link:hover i {
            color: white;
        }

        /* Notification Alert */
        .notification-alert .alert {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--shadow-sm);
            border-left: 4px solid var(--warning-color);
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .profile-content {
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 0 20px 20px 20px;
            }

            .profile-picture-section {
                margin-top: -50px;
            }

            .user-info {
                padding-top: 15px;
            }

            .dashboard-container {
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .cover-banner {
                height: 120px;
            }

            .profile-picture {
                width: 80px;
                height: 80px;
            }

            .profile-picture-section {
                margin-top: -40px;
            }

            .user-name {
                font-size: 1.4rem;
            }

            .links-container {
                grid-template-columns: 1fr;
            }

            .activity-timeline {
                padding-left: 50px;
            }

            .activity-icon {
                left: -30px;
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }

            .activity-timeline::before {
                left: -15px;
            }
        }

        /* Animation for better UX */
        .dashboard-card {
            animation: fadeInUp 0.5s ease-out;
        }

        .profile-header-card {
            animation: slideDown 0.6s ease-out;
        }

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

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Stagger animation delays */
        .dashboard-card:nth-child(1) { animation-delay: 0.1s; }
        .dashboard-card:nth-child(2) { animation-delay: 0.2s; }
        .dashboard-card:nth-child(3) { animation-delay: 0.3s; }
    </style>

    <!-- Font Awesome untuk ikon -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection

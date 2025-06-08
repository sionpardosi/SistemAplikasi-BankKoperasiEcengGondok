@extends('layouts.admin')

@section('content')
    <style>
        /* Base Styling */
        .main-content-inner {
            padding: 1.5rem;
        }

        /* Page Header */
        .page-header {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        /* Content Cards */
        .content-card {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .card-header-custom {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .card-title-custom {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Profile Section */
        .profile-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-initial {
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
        }

        .profile-name {
            font-size: 24px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 5px;
        }

        .profile-email {
            font-size: 16px;
            color: #6c757d;
            margin-bottom: 15px;
        }

        /* Info Tables */
        .info-table {
            width: 100%;
        }

        .info-table td {
            padding: 12px 0;
            border-bottom: 1px solid #f1f3f4;
            font-size: 15px;
            vertical-align: top;
        }

        .info-table td:first-child {
            font-weight: 600;
            color: #495057;
            width: 140px;
        }

        .info-table td:last-child {
            color: #6c757d;
        }

        .info-table tr:last-child td {
            border-bottom: none;
        }

        /* Status Badges */
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-admin {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status-customer {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .status-verified {
            background: #d1f2eb;
            color: #0c5460;
            border: 1px solid #7dd3fc;
        }

        .status-unverified {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            align-items: center;
        }

        .btn-custom {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .btn-primary-custom {
            background: #007bff;
            border-color: #007bff;
            color: white;
        }

        .btn-primary-custom:hover {
            background: #0056b3;
            border-color: #0056b3;
            color: white;
            transform: translateY(-1px);
        }

        .btn-success-custom {
            background: #28a745;
            border-color: #28a745;
            color: white;
        }

        .btn-success-custom:hover {
            background: #1e7e34;
            border-color: #1e7e34;
            color: white;
            transform: translateY(-1px);
        }

        .btn-warning-custom {
            background: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }

        .btn-warning-custom:hover {
            background: #e0a800;
            border-color: #e0a800;
            color: #212529;
            transform: translateY(-1px);
        }

        .btn-danger-custom {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .btn-danger-custom:hover {
            background: #c82333;
            border-color: #c82333;
            color: white;
            transform: translateY(-1px);
        }

        .btn-outline-custom {
            background: transparent;
            border-color: #6c757d;
            color: #6c757d;
        }

        .btn-outline-custom:hover {
            background: #6c757d;
            border-color: #6c757d;
            color: white;
            transform: translateY(-1px);
        }

        /* Address Cards */
        .address-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .address-card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .address-card.default {
            border-color: #28a745;
            background: #f8fff9;
        }

        .address-title {
            font-size: 16px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .address-content {
            font-size: 14px;
            color: #6c757d;
            line-height: 1.6;
        }

        .address-type {
            display: inline-block;
            padding: 4px 10px;
            background: #e9ecef;
            color: #495057;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e9ecef;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
        }

        .timeline-marker {
            position: absolute;
            left: -23px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid white;
        }

        .timeline-content {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 3px solid #007bff;
        }

        .timeline-title {
            margin-bottom: 8px;
            font-size: 16px;
            font-weight: 700;
            color: #495057;
        }

        .timeline-text {
            margin-bottom: 8px;
            font-size: 14px;
            color: #6c757d;
        }

        .timeline-time {
            font-size: 12px;
            color: #adb5bd;
            font-weight: 600;
        }

        /* Statistics Cards */
        .stat-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin-bottom: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 20px;
            color: white;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 13px;
            color: #6c757d;
            font-weight: 600;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 10px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
            padding: 20px 25px;
        }

        .modal-body {
            padding: 25px;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 15px 25px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .content-card {
                padding: 20px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .btn-custom {
                width: 100%;
                justify-content: center;
            }

            .profile-avatar {
                width: 120px;
                height: 120px;
            }

            .profile-initial {
                font-size: 2.5rem;
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Header Section -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Detail Pengguna: {{ $user->name }}</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.data-pengguna.index') }}">
                            <div class="text-tiny">Data Pengguna</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">{{ $user->name }}</div>
                    </li>
                </ul>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="icon-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="icon-alert-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <!-- Left Column - User Information -->
                <div class="col-lg-8">
                    <!-- Profile Overview -->
                    <div class="content-card">
                        <div class="card-header-custom">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title-custom">
                                    <i class="icon-user"></i>Informasi Pengguna
                                </h5>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.data-pengguna.edit', $user->id) }}" class="btn-custom btn-primary-custom">
                                        <i class="icon-edit"></i>Edit
                                    </a>
                                    @if ($user->id !== auth()->id())
                                        <button type="button" class="btn-custom btn-danger-custom" onclick="deleteUser({{ $user->id }})">
                                            <i class="icon-trash"></i>Hapus
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <table class="info-table">
                                    <tr>
                                        <td>Nama:</td>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td>
                                            {{ $user->email }}
                                            @if ($user->email_verified_at)
                                                <br><span class="status-badge status-verified">
                                                    <i class="icon-check"></i>Terverifikasi
                                                </span>
                                            @else
                                                <br><span class="status-badge status-unverified">
                                                    <i class="icon-clock"></i>Belum Verifikasi
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>No. HP:</td>
                                        <td>{{ $user->mobile ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tipe User:</td>
                                        <td>
                                            @if ($user->utype === 'ADM')
                                                <span class="status-badge status-admin">
                                                    <i class="icon-shield"></i>Admin
                                                </span>
                                            @else
                                                <span class="status-badge status-customer">
                                                    <i class="icon-user"></i>Customer
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="info-table">
                                    <tr>
                                        <td>Terdaftar:</td>
                                        <td>
                                            {{ $user->created_at->format('d M Y, H:i') }}
                                            <small class="d-block text-muted">{{ $userStats['account_age'] }}</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Login Terakhir:</td>
                                        <td>
                                            @if ($user->last_login_at)
                                                {{ $user->last_login_at->format('d M Y, H:i') }}
                                                <small class="d-block text-muted">{{ $userStats['last_login'] }}</small>
                                            @else
                                                <span class="text-muted">Belum pernah login</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Diperbarui:</td>
                                        <td>
                                            {{ $user->updated_at->format('d M Y, H:i') }}
                                            <small class="d-block text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Alamat:</td>
                                        <td>
                                            <span class="badge bg-info fs-6">{{ $userStats['total_addresses'] }}</span>
                                            @if ($userStats['total_addresses'] > 0)
                                                <button type="button" class="btn btn-sm btn-outline-primary ms-2"
                                                    data-bs-toggle="modal" data-bs-target="#addressModal">
                                                    Lihat Alamat
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if ($user->bio)
                            <div class="mt-4 pt-3 border-top">
                                <h6><i class="icon-edit-3 me-2"></i>Bio/Deskripsi:</h6>
                                <p class="mt-2 mb-0 text-muted">{{ $user->bio }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Address Information -->
                    @if ($user->addresses->count() > 0)
                        <div class="content-card">
                            <div class="card-header-custom">
                                <h5 class="card-title-custom">
                                    <i class="icon-map-pin"></i>Alamat Pengguna ({{ $user->addresses->count() }})
                                </h5>
                            </div>

                            <div class="row">
                                @foreach ($user->addresses as $address)
                                    <div class="col-md-6 mb-3">
                                        <div class="address-card {{ $address->isdefault ? 'default' : '' }}">
                                            <div class="address-title">
                                                <span>
                                                    {{ $address->name }}
                                                    @if ($address->isdefault)
                                                        <span class="badge bg-success ms-2">Default</span>
                                                    @endif
                                                </span>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="deleteAddress({{ $user->id }}, {{ $address->id }})">
                                                    <i class="icon-trash"></i>
                                                </button>
                                            </div>
                                            <div class="address-content">
                                                <div class="mb-2">
                                                    <i class="icon-phone me-1"></i>{{ $address->phone }}
                                                </div>
                                                <div class="mb-2">
                                                    <i class="icon-map-pin me-1"></i>{{ $address->address }}, {{ $address->locality }}
                                                </div>
                                                <div class="mb-2">
                                                    {{ $address->city }}, {{ $address->state }} {{ $address->zip }}
                                                </div>
                                                @if ($address->landmark)
                                                    <div class="mb-2">
                                                        <small class="text-muted">Landmark: {{ $address->landmark }}</small>
                                                    </div>
                                                @endif
                                                <div class="address-type">{{ ucfirst($address->type) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Activity Log -->
                    <div class="content-card">
                        <div class="card-header-custom">
                            <h5 class="card-title-custom">
                                <i class="icon-activity"></i>Log Aktivitas
                            </h5>
                        </div>

                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Akun Dibuat</h6>
                                    <p class="timeline-text">Pengguna mendaftar di sistem</p>
                                    <small class="timeline-time">{{ $user->created_at->format('d M Y, H:i') }}</small>
                                </div>
                            </div>

                            @if ($user->email_verified_at)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-info"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Email Diverifikasi</h6>
                                        <p class="timeline-text">Email pengguna berhasil diverifikasi</p>
                                        <small class="timeline-time">{{ $user->email_verified_at->format('d M Y, H:i') }}</small>
                                    </div>
                                </div>
                            @endif

                            @if ($user->last_login_at)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Login Terakhir</h6>
                                        <p class="timeline-text">Pengguna terakhir kali mengakses sistem</p>
                                        <small class="timeline-time">{{ $user->last_login_at->format('d M Y, H:i') }}</small>
                                    </div>
                                </div>
                            @endif

                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Data Diperbarui</h6>
                                    <p class="timeline-text">Data pengguna terakhir diperbarui</p>
                                    <small class="timeline-time">{{ $user->updated_at->format('d M Y, H:i') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Profile & Actions -->
                <div class="col-lg-4">
                    <!-- Profile Picture Card -->
                    <div class="content-card">
                        <div class="profile-section">
                            <div class="profile-avatar" style="background: #007bff;">
                                @if ($user->profile_picture)
                                    <img src="{{ asset($user->profile_picture) }}" alt="{{ $user->name }}">
                                @else
                                    <span class="profile-initial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                @endif
                            </div>

                            <h4 class="profile-name">{{ $user->name }}</h4>
                            <p class="profile-email">{{ $user->email }}</p>

                            <div class="user-status mb-3">
                                @if ($user->utype === 'ADM')
                                    <span class="status-badge status-admin">
                                        <i class="icon-shield"></i>Administrator
                                    </span>
                                @else
                                    <span class="status-badge status-customer">
                                        <i class="icon-user"></i>Customer
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="content-card">
                        <div class="card-header-custom">
                            <h5 class="card-title-custom">
                                <i class="icon-zap"></i>Aksi Cepat
                            </h5>
                        </div>

                        <div class="d-grid gap-3">
                            <a href="{{ route('admin.data-pengguna.edit', $user->id) }}" class="btn-custom btn-primary-custom">
                                <i class="icon-edit"></i>Edit Pengguna
                            </a>

                            <button type="button" class="btn-custom btn-warning-custom" onclick="toggleVerification({{ $user->id }})">
                                @if ($user->email_verified_at)
                                    <i class="icon-x-circle"></i>Cabut Verifikasi
                                @else
                                    <i class="icon-check-circle"></i>Verifikasi Email
                                @endif
                            </button>

                            @if ($user->id !== auth()->id())
                                <button type="button" class="btn-custom btn-danger-custom" onclick="deleteUser({{ $user->id }})">
                                    <i class="icon-trash"></i>Hapus Pengguna
                                </button>
                            @endif

                            <a href="{{ route('admin.data-pengguna.index') }}" class="btn-custom btn-outline-custom">
                                <i class="icon-arrow-left"></i>Kembali ke Daftar
                            </a>
                        </div>
                    </div>

                    <!-- Statistics Card -->
                    <div class="content-card">
                        <div class="card-header-custom">
                            <h5 class="card-title-custom">
                                <i class="icon-bar-chart"></i>Statistik
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="stat-card">
                                    <div class="stat-icon bg-primary">
                                        <i class="icon-map-pin"></i>
                                    </div>
                                    <div class="stat-number">{{ $userStats['total_addresses'] }}</div>
                                    <div class="stat-label">Total Alamat</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card">
                                    <div class="stat-icon bg-success">
                                        <i class="icon-calendar"></i>
                                    </div>
                                    <div class="stat-number">{{ $user->created_at->diffInDays(now()) }}</div>
                                    <div class="stat-label">Hari Bergabung</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <table class="info-table">
                                <tr>
                                    <td>Status Verifikasi:</td>
                                    <td>
                                        @if ($user->email_verified_at)
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            <span class="badge bg-warning">Belum Verifikasi</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Login Terakhir:</td>
                                    <td>
                                        <small class="text-muted">{{ $userStats['last_login'] }}</small>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Modal -->
    <div class="modal fade" id="addressModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="icon-map-pin me-2"></i>Alamat Pengguna: {{ $user->name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @foreach ($user->addresses as $address)
                        <div class="address-card {{ $address->isdefault ? 'default' : '' }} mb-3">
                            <div class="address-title">
                                <span>
                                    {{ $address->name }}
                                    @if ($address->isdefault)
                                        <span class="badge bg-success ms-2">Alamat Utama</span>
                                    @endif
                                    <span class="address-type ms-2">{{ ucfirst($address->type) }}</span>
                                </span>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    onclick="deleteAddress({{ $user->id }}, {{ $address->id }})">
                                    <i class="icon-trash"></i>
                                </button>
                            </div>
                            <div class="address-content">
                                <div><strong>Telepon:</strong> {{ $address->phone }}</div>
                                <div><strong>Alamat:</strong> {{ $address->address }}</div>
                                <div><strong>Kelurahan:</strong> {{ $address->locality }}</div>
                                <div><strong>Kota:</strong> {{ $address->city }}, {{ $address->state }} {{ $address->zip }}</div>
                                @if ($address->landmark)
                                    <div><strong>Landmark:</strong> {{ $address->landmark }}</div>
                                @endif
                                <div><strong>Negara:</strong> {{ $address->country }}</div>
                                <small class="text-muted d-block mt-2">
                                    Dibuat: {{ $address->created_at->format('d M Y, H:i') }}
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Forms (Hidden) -->
    <form id="deleteUserForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <form id="deleteAddressForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <form id="verificationForm" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Delete User
        function deleteUser(userId) {
            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: 'Apakah Anda yakin ingin menghapus pengguna ini? Semua data terkait akan ikut terhapus dan tidak dapat dikembalikan.',
                icon: 'warning',
                iconColor: '#f39c12',
                showCancelButton: true,
                reverseButtons: true,
                focusCancel: true,
                cancelButtonText: 'Batal',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                confirmButtonColor: '#e74c3c'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteUserForm');
                    form.action = `/admin/data-pengguna/${userId}`;
                    form.submit();
                }
            });
        }

        // Delete Address
        function deleteAddress(userId, addressId) {
            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: 'Apakah Anda yakin ingin menghapus alamat ini?',
                icon: 'warning',
                iconColor: '#f39c12',
                showCancelButton: true,
                reverseButtons: true,
                focusCancel: true,
                cancelButtonText: 'Batal',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                confirmButtonColor: '#e74c3c'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteAddressForm');
                    form.action = `/admin/data-pengguna/${userId}/addresses/${addressId}`;
                    form.submit();
                }
            });
        }

        // Toggle Verification
        function toggleVerification(userId) {
            const form = document.getElementById('verificationForm');
            form.action = `/admin/data-pengguna/${userId}/toggle-verification`;
            form.submit();
        }

        // Success/Error messages
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                iconColor: '#28a745',
                confirmButtonText: 'OK',
                confirmButtonColor: '#28a745'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: '{{ session('error') }}',
                icon: 'error',
                iconColor: '#e74c3c',
                confirmButtonText: 'OK',
                confirmButtonColor: '#e74c3c'
            });
        @endif
    </script>
@endsection

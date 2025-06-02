@extends('layouts.admin')

@section('content')
<div class="main-content">
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Header Section -->
            <div class="row">
                <!-- Left Column - User Information -->
                <div class="col-md-8">
                    <!-- Basic Information Card -->
                    <div class="wg-box mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">
                                <i class="icon-user me-2"></i>Informasi Pengguna
                            </h5>
                            <div class="action-buttons">
                                <a href="{{ route('admin.data-pengguna.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                    <i class="icon-edit me-1"></i>Edit
                                </a>
                                @if($user->id !== auth()->id())
                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteUser({{ $user->id }})">
                                        <i class="icon-trash me-1"></i>Hapus
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="120"><strong>Nama:</strong></td>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>
                                            {{ $user->email }}
                                            @if($user->email_verified_at)
                                                <span class="badge bg-success ms-2">
                                                    <i class="icon-check me-1"></i>Terverifikasi
                                                </span>
                                            @else
                                                <span class="badge bg-warning ms-2">
                                                    <i class="icon-clock me-1"></i>Belum Verifikasi
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>No. HP:</strong></td>
                                        <td>{{ $user->mobile ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tipe User:</strong></td>
                                        <td>
                                            @if($user->utype === 'ADM')
                                                <span class="badge bg-danger">Admin</span>
                                            @else
                                                <span class="badge bg-primary">Customer</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="140"><strong>Terdaftar:</strong></td>
                                        <td>
                                            {{ $user->created_at->format('d M Y, H:i') }}
                                            <small class="text-muted d-block">{{ $userStats['account_age'] }}</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Login Terakhir:</strong></td>
                                        <td>
                                            @if($user->last_login_at)
                                                {{ $user->last_login_at->format('d M Y, H:i') }}
                                                <small class="text-muted d-block">{{ $userStats['last_login'] }}</small>
                                            @else
                                                <span class="text-muted">Belum pernah login</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Diperbarui:</strong></td>
                                        <td>
                                            {{ $user->updated_at->format('d M Y, H:i') }}
                                            <small class="text-muted d-block">{{ $user->updated_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Alamat:</strong></td>
                                        <td>
                                            <span class="badge bg-info">{{ $userStats['total_addresses'] }}</span>
                                            @if($userStats['total_addresses'] > 0)
                                                <button type="button" class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#addressModal">
                                                    Lihat Alamat
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($user->bio)
                            <div class="mt-3 pt-3 border-top">
                                <strong>Bio/Deskripsi:</strong>
                                <p class="mt-2 mb-0">{{ $user->bio }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Address Information -->
                    @if($user->addresses->count() > 0)
                        <div class="wg-box mb-4">
                            <div class="card-header mb-3">
                                <h5 class="mb-0">
                                    <i class="icon-map-pin me-2"></i>Alamat Pengguna ({{ $user->addresses->count() }})
                                </h5>
                            </div>

                            <div class="row">
                                @foreach($user->addresses as $address)
                                    <div class="col-md-6 mb-3">
                                        <div class="card {{ $address->isdefault ? 'border-success' : '' }}">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="card-title mb-1">
                                                        {{ $address->name }}
                                                        @if($address->isdefault)
                                                            <span class="badge bg-success ms-1">Default</span>
                                                        @endif
                                                    </h6>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteAddress({{ $user->id }}, {{ $address->id }})">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </div>
                                                <p class="card-text small mb-2">
                                                    <i class="icon-phone me-1"></i>{{ $address->phone }}<br>
                                                    <i class="icon-map-pin me-1"></i>{{ $address->address }}, {{ $address->locality }}<br>
                                                    {{ $address->city }}, {{ $address->state }} {{ $address->zip }}<br>
                                                    @if($address->landmark)
                                                        <small class="text-muted">Landmark: {{ $address->landmark }}</small>
                                                    @endif
                                                </p>
                                                <span class="badge bg-secondary">{{ ucfirst($address->type) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Activity Log -->
                    <div class="wg-box">
                        <div class="card-header mb-3">
                            <h5 class="mb-0">
                                <i class="icon-activity me-2"></i>Log Aktivitas
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

                            @if($user->email_verified_at)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-info"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Email Diverifikasi</h6>
                                        <p class="timeline-text">Email pengguna berhasil diverifikasi</p>
                                        <small class="timeline-time">{{ $user->email_verified_at->format('d M Y, H:i') }}</small>
                                    </div>
                                </div>
                            @endif

                            @if($user->last_login_at)
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
                <div class="col-md-4">
                    <!-- Profile Picture Card -->
                    <div class="wg-box mb-4 text-center">
                        <div class="profile-image-container mb-3">
                            @if($user->profile_picture)
                                <img src="{{ asset($user->profile_picture) }}"
                                     alt="{{ $user->name }}"
                                     class="rounded-circle profile-image"
                                     style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #e9ecef;">
                            @else
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                     style="width: 150px; height: 150px; border: 4px solid #e9ecef;">
                                    <span class="text-white" style="font-size: 3rem; font-weight: bold;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <h4 class="mb-1">{{ $user->name }}</h4>
                        <p class="text-muted mb-3">{{ $user->email }}</p>

                        <div class="user-status mb-3">
                            @if($user->utype === 'ADM')
                                <span class="badge bg-danger fs-6">Administrator</span>
                            @else
                                <span class="badge bg-primary fs-6">Customer</span>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="wg-box mb-4">
                        <h5 class="card-title mb-3">
                            <i class="icon-zap me-2"></i>Aksi Cepat
                        </h5>

                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.data-pengguna.edit', $user->id) }}" class="btn btn-primary">
                                <i class="icon-edit me-2"></i>Edit Pengguna
                            </a>

                            <button type="button" class="btn btn-outline-info" onclick="toggleVerification({{ $user->id }})">
                                @if($user->email_verified_at)
                                    <i class="icon-x-circle me-2"></i>Cabut Verifikasi
                                @else
                                    <i class="icon-check-circle me-2"></i>Verifikasi Email
                                @endif
                            </button>

                            @if($user->id !== auth()->id())
                                <button type="button" class="btn btn-outline-danger" onclick="deleteUser({{ $user->id }})">
                                    <i class="icon-trash me-2"></i>Hapus Pengguna
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Statistics Card -->
                    <div class="wg-box">
                        <h5 class="card-title mb-3">
                            <i class="icon-bar-chart me-2"></i>Statistik
                        </h5>

                        <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                            <span><i class="icon-map-pin me-2 text-primary"></i>Total Alamat</span>
                            <span class="badge bg-primary">{{ $userStats['total_addresses'] }}</span>
                        </div>

                        <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                            <span><i class="icon-calendar me-2 text-success"></i>Umur Akun</span>
                            <span class="text-muted">{{ $userStats['account_age'] }}</span>
                        </div>

                        <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                            <span><i class="icon-shield me-2 text-warning"></i>Status Verifikasi</span>
                            <span class="badge {{ $user->email_verified_at ? 'bg-success' : 'bg-warning' }}">
                                {{ $userStats['verification_status'] }}
                            </span>
                        </div>

                        <div class="stat-item d-flex justify-content-between align-items-center">
                            <span><i class="icon-clock me-2 text-info"></i>Login Terakhir</span>
                            <span class="text-muted">{{ $userStats['last_login'] }}</span>
                        </div>
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
                @foreach($user->addresses as $address)
                    <div class="card mb-3 {{ $address->isdefault ? 'border-success' : '' }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="card-title">
                                        {{ $address->name }}
                                        @if($address->isdefault)
                                            <span class="badge bg-success ms-2">Alamat Utama</span>
                                        @endif
                                        <span class="badge bg-secondary ms-1">{{ ucfirst($address->type) }}</span>
                                    </h6>
                                    <p class="card-text mb-1">
                                        <strong>Telepon:</strong> {{ $address->phone }}<br>
                                        <strong>Alamat:</strong> {{ $address->address }}<br>
                                        <strong>Kelurahan:</strong> {{ $address->locality }}<br>
                                        <strong>Kota:</strong> {{ $address->city }}, {{ $address->state }} {{ $address->zip }}<br>
                                        @if($address->landmark)
                                            <strong>Landmark:</strong> {{ $address->landmark }}<br>
                                        @endif
                                        <strong>Negara:</strong> {{ $address->country }}
                                    </p>
                                    <small class="text-muted">
                                        Dibuat: {{ $address->created_at->format('d M Y, H:i') }}
                                    </small>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteAddress({{ $user->id }}, {{ $address->id }})">
                                    <i class="icon-trash"></i>
                                </button>
                            </div>
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

@push('styles')
<style>
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
    margin-bottom: 20px;
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
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #007bff;
}

.timeline-title {
    margin-bottom: 5px;
    font-size: 0.9rem;
    font-weight: 600;
}

.timeline-text {
    margin-bottom: 5px;
    font-size: 0.85rem;
    color: #6c757d;
}

.timeline-time {
    font-size: 0.75rem;
    color: #adb5bd;
}

.profile-image {
    transition: transform 0.3s ease;
}

.profile-image:hover {
    transform: scale(1.05);
}

.stat-item {
    padding: 8px 0;
    border-bottom: 1px solid #f1f3f4;
}

.stat-item:last-child {
    border-bottom: none;
}
</style>
@endpush

@push('scripts')
<script>
// Delete User
function deleteUser(userId) {
    if (confirm('Yakin ingin menghapus pengguna ini? Semua data terkait akan ikut terhapus dan tidak dapat dikembalikan.')) {
        const form = document.getElementById('deleteUserForm');
        form.action = `/admin/data-pengguna/${userId}`;
        form.submit();
    }
}

// Delete Address
function deleteAddress(userId, addressId) {
    if (confirm('Yakin ingin menghapus alamat ini?')) {
        const form = document.getElementById('deleteAddressForm');
        form.action = `/admin/data-pengguna/${userId}/addresses/${addressId}`;
        form.submit();
    }
}

// Toggle Verification
function toggleVerification(userId) {
    const form = document.getElementById('verificationForm');
    form.action = `/admin/data-pengguna/${userId}/toggle-verification`;
    form.submit();
}
</script>
@endpush
@endsectionflex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Detail Pengguna: {{ $user->name }}</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
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
                    <li><div class="text-tiny">{{ $user->name }}</div></li>
                </ul>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- User Details Section -->

                
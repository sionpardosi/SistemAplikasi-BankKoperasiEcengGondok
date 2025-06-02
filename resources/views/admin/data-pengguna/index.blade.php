@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="main-content-inner">
            <div class="main-content-wrap">
                <!-- Header Section -->
                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                    <h3>Manajemen Data Pengguna</h3>
                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                        <li>
                            <a href="{{ route('admin.index') }}">
                                <div class="text-tiny">Dashboard</div>
                            </a>
                        </li>
                        <li><i class="icon-chevron-right"></i></li>
                        <li>
                            <div class="text-tiny">Data Pengguna</div>
                        </li>
                    </ul>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="wg-box bg-primary text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-white mb-0">{{ number_format($stats['total_users']) }}</h4>
                                    <p class="text-white-50 mb-0">Total Pengguna</p>
                                </div>
                                <div class="icon-box">
                                    <i class="icon-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="wg-box bg-success text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-white mb-0">{{ number_format($stats['total_customers']) }}</h4>
                                    <p class="text-white-50 mb-0">Customer</p>
                                </div>
                                <div class="icon-box">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="wg-box bg-warning text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-white mb-0">{{ number_format($stats['verified_users']) }}</h4>
                                    <p class="text-white-50 mb-0">Terverifikasi</p>
                                </div>
                                <div class="icon-box">
                                    <i class="icon-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="wg-box bg-info text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-white mb-0">{{ number_format($stats['active_today']) }}</h4>
                                    <p class="text-white-50 mb-0">Aktif Hari Ini</p>
                                </div>
                                <div class="icon-box">
                                    <i class="icon-activity"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Main Content Box -->
                <div class="wg-box">
                    <!-- Filters and Actions -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <form method="GET" action="{{ route('admin.data-pengguna.index') }}" class="form-filter">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari nama, email, atau nomor HP..."
                                            value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="utype" class="form-select">
                                            <option value="">Semua Tipe User</option>
                                            <option value="USR" {{ request('utype') === 'USR' ? 'selected' : '' }}>
                                                Customer</option>
                                            <option value="ADM" {{ request('utype') === 'ADM' ? 'selected' : '' }}>Admin
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="verification_status" class="form-select">
                                            <option value="">Status Verifikasi</option>
                                            <option value="verified"
                                                {{ request('verification_status') === 'verified' ? 'selected' : '' }}>
                                                Terverifikasi</option>
                                            <option value="unverified"
                                                {{ request('verification_status') === 'unverified' ? 'selected' : '' }}>
                                                Belum Verifikasi</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="icon-search"></i> Filter
                                        </button>
                                    </div>
                                </div>

                                <!-- Advanced Filters (Collapsible) -->
                                <div class="collapse mt-3" id="advancedFilters">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Tanggal Daftar Dari:</label>
                                            <input type="date" name="date_from" class="form-control"
                                                value="{{ request('date_from') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Tanggal Daftar Sampai:</label>
                                            <input type="date" name="date_to" class="form-control"
                                                value="{{ request('date_to') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Urutkan Berdasarkan:</label>
                                            <select name="sort_by" class="form-select">
                                                <option value="created_at"
                                                    {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Tanggal
                                                    Daftar</option>
                                                <option value="name"
                                                    {{ request('sort_by') === 'name' ? 'selected' : '' }}>Nama</option>
                                                <option value="email"
                                                    {{ request('sort_by') === 'email' ? 'selected' : '' }}>Email</option>
                                                <option value="last_login_at"
                                                    {{ request('sort_by') === 'last_login_at' ? 'selected' : '' }}>Login
                                                    Terakhir</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Urutan:</label>
                                            <select name="sort_order" class="form-select">
                                                <option value="desc"
                                                    {{ request('sort_order') === 'desc' ? 'selected' : '' }}>Terbaru
                                                </option>
                                                <option value="asc"
                                                    {{ request('sort_order') === 'asc' ? 'selected' : '' }}>Terlama
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                        data-bs-toggle="collapse" data-bs-target="#advancedFilters">
                                        <i class="icon-filter"></i> Filter Lanjutan
                                    </button>
                                    @if (request()->hasAny(['search', 'utype', 'verification_status', 'date_from', 'date_to', 'sort_by']))
                                        <a href="{{ route('admin.data-pengguna.index') }}"
                                            class="btn btn-outline-danger btn-sm">
                                            <i class="icon-x"></i> Reset Filter
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.data-pengguna.create') }}" class="btn btn-success">
                                    <i class="icon-plus"></i> Tambah User
                                </a>
                                <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="icon-download"></i> Export
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.data-pengguna.export', request()->query()) }}">
                                            <i class="icon-file-text"></i> Export CSV
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Bulk Actions -->
                    <form id="bulkActionForm" method="POST" action="{{ route('admin.data-pengguna.bulk-action') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="bulk-actions" style="display: none;">
                                    <select name="action" class="form-select form-select-sm"
                                        style="width: auto; display: inline-block;">
                                        <option value="">Pilih Aksi...</option>
                                        <option value="verify">Verifikasi Email</option>
                                        <option value="unverify">Cabut Verifikasi</option>
                                        <option value="delete">Hapus User</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-warning"
                                        onclick="return confirm('Yakin ingin melanjutkan aksi ini?')">
                                        Jalankan
                                    </button>
                                    <span class="selected-count ms-2 text-muted"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Data Table -->
                        <div class="wg-table table-all-user">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="40">
                                                <input type="checkbox" id="selectAll" class="form-check-input">
                                            </th>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Kontak</th>
                                            <th>Tipe</th>
                                            <th>Status</th>
                                            <th>Alamat</th>
                                            <th>Bergabung</th>
                                            <th>Login Terakhir</th>
                                            <th width="120">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $user)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                                                        class="form-check-input user-checkbox">
                                                </td>
                                                <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                                </td>
                                                <td class="pname">
                                                    <div class="d-flex align-items-center">
                                                        <div class="image me-3">
                                                            @if ($user->profile_picture)
                                                                <img src="{{ asset($user->profile_picture) }}"
                                                                    alt="{{ $user->name }}" class="rounded-circle"
                                                                    width="40" height="40">
                                                            @else
                                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                                                    style="width: 40px; height: 40px;">
                                                                    <span
                                                                        class="text-white fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <a href="{{ route('admin.data-pengguna.show', $user->id) }}"
                                                                class="body-title-2 text-decoration-none">
                                                                {{ $user->name }}
                                                            </a>
                                                            @if ($user->bio)
                                                                <div class="text-tiny text-muted mt-1">
                                                                    {{ Str::limit($user->bio, 30) }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-sm">
                                                        <div><i class="icon-mail me-1"></i>{{ $user->email }}</div>
                                                        @if ($user->mobile)
                                                            <div class="text-muted mt-1"><i
                                                                    class="icon-phone me-1"></i>{{ $user->mobile }}</div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($user->utype === 'ADM')
                                                        <span class="badge bg-danger">Admin</span>
                                                    @else
                                                        <span class="badge bg-primary">Customer</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($user->email_verified_at)
                                                        <span class="badge bg-success">
                                                            <i class="icon-check me-1"></i>Terverifikasi
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning">
                                                            <i class="icon-clock me-1"></i>Belum Verifikasi
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-info">{{ $user->addresses_count }}</span>
                                                </td>
                                                <td>
                                                    <div class="text-sm">
                                                        {{ $user->created_at->format('d/m/Y') }}
                                                        <div class="text-muted">{{ $user->created_at->diffForHumans() }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($user->last_login_at)
                                                        <div class="text-sm">
                                                            {{ $user->last_login_at->format('d/m/Y H:i') }}
                                                            <div class="text-muted">
                                                                {{ $user->last_login_at->diffForHumans() }}</div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">Belum pernah</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="list-icon-function">
                                                        <div class="dropdown">
                                                            <button
                                                                class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                                type="button" data-bs-toggle="dropdown">
                                                                <i class="icon-more-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.data-pengguna.show', $user->id) }}">
                                                                        <i class="icon-eye me-2"></i>Lihat Detail
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.data-pengguna.edit', $user->id) }}">
                                                                        <i class="icon-edit me-2"></i>Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <button type="button" class="dropdown-item"
                                                                        onclick="toggleVerification({{ $user->id }})">
                                                                        @if ($user->email_verified_at)
                                                                            <i class="icon-x-circle me-2"></i>Cabut
                                                                            Verifikasi
                                                                        @else
                                                                            <i
                                                                                class="icon-check-circle me-2"></i>Verifikasi
                                                                            Email
                                                                        @endif
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <hr class="dropdown-divider">
                                                                </li>
                                                                @if ($user->id !== auth()->id())
                                                                    <li>
                                                                        <button type="button"
                                                                            class="dropdown-item text-danger"
                                                                            onclick="deleteUser({{ $user->id }})">
                                                                            <i class="icon-trash me-2"></i>Hapus
                                                                        </button>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center py-4">
                                                    <div class="empty-state">
                                                        <i class="icon-users display-4 text-muted"></i>
                                                        <p class="text-muted mt-2">Tidak ada data pengguna yang ditemukan.
                                                        </p>
                                                        @if (request()->hasAny(['search', 'utype', 'verification_status']))
                                                            <a href="{{ route('admin.data-pengguna.index') }}"
                                                                class="btn btn-outline-primary btn-sm">
                                                                Reset Filter
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>

                    <!-- Pagination -->
                    @if ($users->hasPages())
                        <div class="divider"></div>
                        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                            <div class="pagination-info">
                                Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari
                                {{ $users->total() }} pengguna
                            </div>
                            {{ $users->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Form (Hidden) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Toggle Verification Form (Hidden) -->
    <form id="verificationForm" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>

    @push('scripts')
        <script>
            // Bulk Actions
            document.getElementById('selectAll').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.user-checkbox');
                const bulkActions = document.querySelector('.bulk-actions');
                const selectedCount = document.querySelector('.selected-count');

                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });

                updateBulkActions();
            });

            document.querySelectorAll('.user-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActions);
            });

            function updateBulkActions() {
                const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
                const bulkActions = document.querySelector('.bulk-actions');
                const selectedCount = document.querySelector('.selected-count');
                const selectAll = document.getElementById('selectAll');

                if (checkedBoxes.length > 0) {
                    bulkActions.style.display = 'block';
                    selectedCount.textContent = `${checkedBoxes.length} item dipilih`;
                } else {
                    bulkActions.style.display = 'none';
                }

                // Update select all checkbox state
                const totalCheckboxes = document.querySelectorAll('.user-checkbox').length;
                selectAll.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < totalCheckboxes;
                selectAll.checked = checkedBoxes.length === totalCheckboxes;
            }

            // Delete User
            function deleteUser(userId) {
                if (confirm('Yakin ingin menghapus user ini? Data yang terkait juga akan dihapus.')) {
                    const form = document.getElementById('deleteForm');
                    form.action = `/admin/data-pengguna/${userId}`;
                    form.submit();
                }
            }

            // Toggle Verification
            function toggleVerification(userId) {
                const form = document.getElementById('verificationForm');
                form.action = `/admin/data-pengguna/${userId}/toggle-verification`;
                form.submit();
            }

            // Bulk Action Form Validation
            document.getElementById('bulkActionForm').addEventListener('submit', function(e) {
                const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
                const actionSelect = document.querySelector('select[name="action"]');

                if (checkedBoxes.length === 0) {
                    e.preventDefault();
                    alert('Pilih minimal satu user untuk melakukan aksi bulk.');
                    return;
                }

                if (!actionSelect.value) {
                    e.preventDefault();
                    alert('Pilih aksi yang ingin dilakukan.');
                    return;
                }

                // Additional confirmation for delete action
                if (actionSelect.value === 'delete') {
                    if (!confirm(
                            `Yakin ingin menghapus ${checkedBoxes.length} user yang dipilih? Aksi ini tidak dapat dibatalkan.`
                            )) {
                        e.preventDefault();
                        return;
                    }
                }
            });
        </script>
    @endpush
@endsection

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

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #495057;
            margin: 0;
        }

        /* Summary Cards */
        .summary-section {
            margin-bottom: 30px;
        }

        .summary-card {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            height: 100%;
            text-align: center;
        }

        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .summary-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            margin: 0 auto 15px;
        }

        .summary-number {
            font-size: 32px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 8px;
            line-height: 1;
        }

        .summary-label {
            font-size: 15px;
            color: #6c757d;
            font-weight: 600;
            margin: 0;
        }

        /* Chart Section */
        .chart-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .chart-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .chart-title {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin: 0;
        }

        /* Filter Section */
        .filter-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .filter-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .filter-title {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin: 0;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .form-control,
        .form-select {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-filter {
            background: #007bff;
            border: 1px solid #007bff;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-filter:hover {
            background: #0056b3;
            border-color: #0056b3;
            color: white;
            transform: translateY(-1px);
        }

        .btn-reset {
            background: #6c757d;
            border: 1px solid #6c757d;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-reset:hover {
            background: #545b62;
            border-color: #545b62;
            color: white;
            transform: translateY(-1px);
        }

        /* Table Section */
        .table-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .table-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .table-title {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin: 0;
        }

        .table {
            margin-bottom: 0;
            font-size: 15px;
        }

        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 700;
            color: #495057;
            padding: 18px 15px;
            font-size: 15px;
            white-space: nowrap;
            border-top: none;
        }

        .table tbody td {
            padding: 18px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f4;
            font-size: 15px;
            line-height: 1.4;
        }

        .table tbody tr:hover {
            background-color: #f8f9ff;
        }

        .table tbody tr:last-child td {
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

        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-disetujui {
            background: #d1f2eb;
            color: #0c5460;
            border: 1px solid #7dd3fc;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Action Buttons */
        .action-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .btn-action {
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .btn-manage {
            background: #007bff;
            border-color: #007bff;
            color: white;
        }

        .btn-manage:hover {
            background: #0056b3;
            border-color: #0056b3;
            color: white;
            transform: translateY(-1px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #6c757d;
        }

        .empty-icon {
            font-size: 80px;
            margin-bottom: 25px;
            opacity: 0.3;
        }

        .empty-title {
            font-size: 24px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 10px;
        }

        .empty-text {
            font-size: 16px;
            color: #6c757d;
            margin-bottom: 30px;
        }

        /* Quick Stats */
        .quick-stats {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .quick-stats-title {
            font-size: 14px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 10px;
        }

        .quick-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
        }

        .quick-stat-item {
            text-align: center;
        }

        .quick-stat-number {
            font-size: 20px;
            font-weight: 700;
            color: #007bff;
            display: block;
        }

        .quick-stat-label {
            font-size: 12px;
            color: #6c757d;
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .page-header,
            .filter-section,
            .table-section,
            .chart-section {
                padding: 20px;
            }

            .summary-card {
                padding: 20px;
                margin-bottom: 15px;
            }

            .action-group {
                flex-direction: column;
                gap: 5px;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }

            .table-responsive {
                font-size: 14px;
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Dashboard Manajemen Pemasok Bahan Baku Eceng Gondok</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Dashboard Pemasok</div>
                    </li>
                </ul>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="page-title">Dashboard Manajemen Pemasok</h4>
                        <p class="text-muted mb-0">Pantau dan kelola seluruh aktivitas pemasok bahan baku eceng gondok</p>
                    </div>
                    <div class="d-flex gap-3">
                        <a href="{{ route('admin.supplier.index') }}" class="btn btn-filter">
                            <i class="icon-list"></i> Kelola Permintaan
                        </a>
                        <a href="{{ route('admin.penjadwalan.index') }}" class="btn btn-filter">
                            <i class="icon-calendar"></i> Kelola Jadwal
                        </a>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="summary-section">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-info">
                                <i class="icon-users"></i>
                            </div>
                            <div class="summary-number">{{ $dashboardSupplier['total_request'] }}</div>
                            <div class="summary-label">Total Permintaan Pemasok</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-success">
                                <i class="icon-credit-card"></i>
                            </div>
                            <div class="summary-number">{{ number_format(\App\Models\StokBahanBaku::sum('jumlah_kg'), 1) }} kg</div>
                            <div class="summary-label">Total Stok Tersedia</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-primary">
                                <i class="icon-calendar"></i>
                            </div>
                            <div class="summary-number">{{ $dashboardSupplier['total_jadwal'] }}</div>
                            <div class="summary-label">Total Jadwal Penjemputan</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-warning">
                                <i class="icon-check-circle"></i>
                            </div>
                            <div class="summary-number">{{ $dashboardSupplier['total_jemput'] }}</div>
                            <div class="summary-label">Jadwal Terlaksana</div>
                        </div>
                    </div>
                </div>
            </div>

                        <!-- Chart Section -->
            <div class="chart-section">
                <div class="chart-header">
                    <h5 class="chart-title">
                        <i class="icon-bar-chart"></i> Grafik Permintaan Pemasok Per Bulan
                    </h5>
                </div>
                <div id="chart-ringkasan"></div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-header">
                    <h5 class="filter-title">
                        <i class="icon-equalizer"></i> Filter Grafik Permintaan Bulanan
                    </h5>
                </div>

                <form class="row g-3" method="GET" action="{{ route('admin.supplier.dashboard') }}">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Status Permintaan</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button class="btn btn-filter flex-1" type="submit">
                                <i class="icon-search"></i> Filter
                            </button>
                            <a href="{{ route('admin.supplier.dashboard') }}" class="btn btn-reset">
                                <i class="icon-refresh"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

                        <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="quick-stats-title">
                    <i class="icon-bar-chart"></i> Statistik Cepat Penjemputan
                </div>
                <div class="quick-stats-grid">
                    <div class="quick-stat-item">
                        <span class="quick-stat-number">{{ $dashboardSupplier['total_pending'] }}</span>
                        <span class="quick-stat-label">Pending</span>
                    </div>
                    <div class="quick-stat-item">
                        <span class="quick-stat-number">{{ $dashboardSupplier['total_batal'] }}</span>
                        <span class="quick-stat-label">Dibatalkan</span>
                    </div>
                    <div class="quick-stat-item">
                        <span class="quick-stat-number">{{ number_format((\App\Models\StokBahanBaku::where('jumlah_kg', '>', 0)->sum('jumlah_kg') * 60000), 0, ',', '.') }}</span>
                        <span class="quick-stat-label">Total Insentif (Rp)</span>
                    </div>
                    <div class="quick-stat-item">
                        <span class="quick-stat-number">{{ \App\Models\SupplierRequest::where('status', 'disetujui')->count() }}</span>
                        <span class="quick-stat-label">Request Disetujui</span>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="table-section">
                <div class="table-header">
                    <h5 class="table-title">
                        <i class="icon-list"></i> Permintaan Pemasok Terbaru
                    </h5>
                </div>

                <div class="table-responsive">
                    @if ($recentRequests->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="15%">Tanggal</th>
                                    <th width="20%">Pemasok</th>
                                    <th width="18%">Lokasi</th>
                                    <th width="12%">Jumlah (kg)</th>
                                    <th width="12%">Status</th>
                                    <th width="23%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentRequests as $req)
                                    <tr>
                                        <!-- Tanggal -->
                                        <td>
                                            <div class="date-main">{{ $req->created_at->format('d M Y') }}</div>
                                            <div class="date-time">{{ $req->created_at->format('H:i') }} WIB</div>
                                        </td>

                                        <!-- Pemasok Info -->
                                        <td>
                                            <div class="supplier-name" style="font-weight: 700; color: #495057; font-size: 16px; margin-bottom: 4px;">{{ $req->nama }}</div>
                                            <div class="supplier-contact" style="font-size: 13px; color: #6c757d; line-height: 1.3;">
                                                <i class="icon-envelope"></i> {{ $req->email }}
                                            </div>
                                        </td>

                                        <!-- Lokasi -->
                                        <td>
                                            @if ($req->kecamatan || $req->desa)
                                                <div class="location-main" style="font-weight: 600; color: #495057; font-size: 15px; margin-bottom: 2px;">{{ $req->kecamatan ?? '-' }}</div>
                                                <div class="location-detail" style="font-size: 13px; color: #6c757d;">{{ $req->desa ?? '-' }}</div>
                                            @else
                                                <div class="location-main">{{ $req->lokasi ?? '-' }}</div>
                                            @endif
                                        </td>

                                        <!-- Jumlah -->
                                        <td>
                                            <div class="quantity-value" style="font-weight: 700; color: #007bff; font-size: 16px; margin-bottom: 2px;">{{ $req->estimasi_kg }} kg</div>
                                            @if ($req->status === 'disetujui')
                                                <div class="quantity-estimate" style="font-size: 12px; color: #28a745; font-weight: 600;">
                                                    ~Rp {{ number_format($req->estimasi_kg * 60000, 0, ',', '.') }}
                                                </div>
                                            @endif
                                        </td>

                                        <!-- Status -->
                                        <td>
                                            @switch($req->status)
                                                @case('pending')
                                                    <span class="status-badge status-pending">
                                                        <i class="icon-clock"></i> Pending
                                                    </span>
                                                @break

                                                @case('disetujui')
                                                    <span class="status-badge status-disetujui">
                                                        <i class="icon-check"></i> Disetujui
                                                    </span>
                                                @break

                                                @case('ditolak')
                                                    <span class="status-badge status-ditolak">
                                                        <i class="icon-close"></i> Ditolak
                                                    </span>
                                                @break
                                            @endswitch
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <div class="action-group">
                                                <a href="{{ route('admin.supplier.request.edit', $req->id) }}"
                                                    class="btn-action btn-manage" title="Kelola Request">
                                                    <i class="icon-pencil"></i> Kelola
                                                </a>

                                                @if ($req->status === 'disetujui')
                                                    <a href="{{ route('admin.penjadwalan.add') }}?request_id={{ $req->id }}"
                                                        class="btn-action" style="background: #28a745; border-color: #28a745; color: white;" title="Buat Jadwal">
                                                        <i class="icon-calendar"></i> Jadwal
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="icon-users"></i>
                            </div>
                            <h4 class="empty-title">Tidak Ada Permintaan Terbaru</h4>
                            <p class="empty-text">
                                Belum ada permintaan pemasok yang masuk.<br>
                                Permintaan baru akan muncul di sini ketika pemasok mengajukan permintaan.
                            </p>
                            <a href="{{ route('admin.supplier.index') }}" class="btn btn-filter">
                                <i class="icon-list"></i> Lihat Semua Permintaan
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ApexCharts Script -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (document.querySelector("#chart-ringkasan")) {
                var options = {
                    series: [{
                        name: 'Jumlah Permintaan',
                        data: {!! json_encode($chartData) !!}
                    }],
                    chart: {
                        type: 'line',
                        height: 350,
                        toolbar: {
                            show: true,
                            tools: {
                                download: true,
                                selection: false,
                                zoom: false,
                                zoomin: false,
                                zoomout: false,
                                pan: false,
                                reset: false
                            }
                        },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800,
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    markers: {
                        size: 5,
                        colors: ['#2377FC'],
                        strokeColors: '#fff',
                        strokeWidth: 2,
                        hover: {
                            size: 7,
                        }
                    },
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        labels: {
                            style: {
                                fontSize: '14px',
                                fontWeight: 600,
                                colors: '#6c757d'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                fontSize: '14px',
                                fontWeight: 600,
                                colors: '#6c757d'
                            }
                        }
                    },
                    colors: ['#2377FC'],
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '12px',
                            fontWeight: 'bold',
                            colors: ['#2377FC']
                        },
                        background: {
                            enabled: true,
                            foreColor: '#fff',
                            borderRadius: 2,
                            padding: 4,
                            opacity: 0.9,
                            borderWidth: 1,
                            borderColor: '#2377FC'
                        }
                    },
                    grid: {
                        borderColor: '#f1f3f4',
                        strokeDashArray: 5,
                        xaxis: {
                            lines: {
                                show: true
                            }
                        },
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    tooltip: {
                        theme: 'light',
                        style: {
                            fontSize: '14px'
                        },
                        y: {
                            formatter: function (val) {
                                return val + " permintaan"
                            }
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#chart-ringkasan"), options);
                chart.render();
            }
        });
    </script>
@endsection

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

        /* Quick Action Bar */
        .quick-action-bar {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .quick-action-btn {
            margin-right: 10px;
            margin-bottom: 0px;
        }

        .btn-smart {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(23, 162, 184, 0.3);
            text-decoration: none;
        }

        .btn-smart:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.4);
            color: white;
        }

        .btn-optimize {
            background: linear-gradient(135deg, #fd7e14 0%, #e8590c 100%);
            border: none;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(253, 126, 20, 0.3);
        }

        .btn-optimize:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(253, 126, 20, 0.4);
            color: white;
        }

        /* Auto Refresh Toggle */
        .auto-refresh-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }

        .auto-refresh-toggle {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .auto-refresh-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #007bff;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        /* Bulk Action Panel */
        .bulk-action-panel {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            display: none;
        }

        .bulk-action-controls {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        /* Search Container */
        .search-container-advanced {
            position: relative;
            margin-bottom: 20px;
        }

        .search-input-advanced {
            padding: 12px 50px 12px 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            font-size: 15px;
            width: 100%;
        }

        .search-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            font-size: 18px;
        }

        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 8px 8px;
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
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

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 16px;
        }

        .search-input {
            padding-left: 45px;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            align-items: end;
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
            text-decoration: none;
        }

        .btn-reset:hover {
            background: #545b62;
            border-color: #545b62;
            color: white;
            transform: translateY(-1px);
        }

        .btn-export {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            white-space: nowrap;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
            text-decoration: none;
        }

        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
            color: white;
        }

        .filter-info {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }

        .filter-info-text {
            font-size: 14px;
            color: #6c757d;
            margin: 0;
        }

        /* Calendar Section */
        .calendar-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .calendar-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .calendar-title {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin: 0;
        }

        #scheduleCalendar {
            min-height: 400px;
        }

        /* Timeline Section */
        .timeline-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .timeline-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .timeline-title {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin: 0;
        }

        .timeline-item {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            border-left: 4px solid #007bff;
        }

        .timeline-item:hover {
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .timeline-item.status-dijemput {
            border-left-color: #28a745;
        }

        .timeline-item.status-dibatalkan {
            border-left-color: #dc3545;
        }

        .timeline-date {
            font-size: 16px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 8px;
        }

        .timeline-location {
            font-size: 15px;
            color: #6c757d;
            margin-bottom: 8px;
        }

        .timeline-supplier {
            font-size: 14px;
            color: #007bff;
            margin-bottom: 8px;
        }

        .timeline-weight {
            font-size: 14px;
            color: #28a745;
            font-weight: 600;
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

        .status-terjadwal {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-dijemput {
            background: #d1f2eb;
            color: #0c5460;
            border: 1px solid #7dd3fc;
        }

        .status-dibatalkan {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Table Content Styling */
        .schedule-date {
            font-weight: 700;
            color: #495057;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .schedule-time {
            font-size: 13px;
            color: #6c757d;
        }

        .location-main {
            font-weight: 600;
            color: #495057;
            font-size: 15px;
            margin-bottom: 2px;
        }

        .location-detail {
            font-size: 13px;
            color: #6c757d;
        }

        .supplier-name {
            font-weight: 700;
            color: #007bff;
            font-size: 15px;
            margin-bottom: 2px;
        }

        .supplier-contact {
            font-size: 12px;
            color: #6c757d;
        }

        .weight-value {
            font-weight: 700;
            color: #28a745;
            font-size: 16px;
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

        .btn-edit {
            background: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }

        .btn-edit:hover {
            background: #e0a800;
            border-color: #e0a800;
            color: #212529;
            transform: translateY(-1px);
        }

        .btn-delete {
            background: transparent;
            border-color: #dc3545;
            color: #dc3545;
        }

        .btn-delete:hover {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
            transform: translateY(-1px);
        }

        .quick-status-btn {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            border: 1px solid;
            background: transparent;
            transition: all 0.3s ease;
            margin-right: 5px;
        }

        .quick-status-btn.status-dijemput {
            color: #28a745;
            border-color: #28a745;
        }

        .quick-status-btn.status-dijemput:hover {
            background: #28a745;
            color: white;
        }

        .quick-status-btn.status-dibatalkan {
            color: #dc3545;
            border-color: #dc3545;
        }

        .quick-status-btn.status-dibatalkan:hover {
            background: #dc3545;
            color: white;
        }

        /* Alerts */
        .alert-overdue {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-upcoming {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
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

        /* Pagination */
        .pagination-container {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .pagination-info {
            font-size: 14px;
            color: #6c757d;
        }

        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            border-radius: 6px;
            margin: 0 2px;
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .filter-buttons {
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }

            .filter-buttons .btn {
                width: 100%;
            }

            .quick-action-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .quick-action-btn {
                margin-right: 0;
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .page-header,
            .filter-section,
            .table-section,
            .timeline-section,
            .calendar-section,
            .quick-action-bar {
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

            .bulk-action-controls {
                flex-direction: column;
                align-items: stretch;
            }
        }

        @media (max-width: 576px) {
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 15px;
            }

            .auto-refresh-container {
                margin-left: 0;
                justify-content: center;
            }
        }

        /* Action Bar */
        .action-bar {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .action-bar .d-flex {
            align-items: center;
            justify-content: space-between;
        }

        .btn-add-new {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
            text-decoration: none;
        }

        .btn-add-new:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
            color: white;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Manajemen Jadwal Penjemputan</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.penjadwalan.index') }}">
                            <div class="text-tiny">Jadwal Penjemputan</div>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Action Bar -->
            <div class="action-bar">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="page-title">Manajemen Jadwal Penjemputan</h4>
                        <p class="text-muted mb-0">Kelola dan pantau semua jadwal penjemputan eceng gondok</p>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="auto-refresh-container">
                            <span class="text-muted">Auto Refresh:</span>
                            <label class="auto-refresh-toggle">
                                <input type="checkbox" id="autoRefreshToggle">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <button type="button" class="btn btn-smart quick-action-btn" id="smartScheduleBtn">
                            <i class="icon-zap"></i> Smart Scheduling
                        </button>
                        <button type="button" class="btn btn-optimize quick-action-btn" id="optimizeRouteBtn">
                            <i class="icon-map"></i> Optimasi Rute
                        </button>
                        <a href="{{ route('admin.penjadwalan.export') }}" class="btn-export" title="Download Data Excel">
                            <i class="icon-download"></i>Export Excel
                        </a>
                        <a href="{{ route('admin.penjadwalan.add') }}" class="btn-add-new">
                            <i class="icon-plus"></i> Atur Jadwal Penjemputan
                        </a>
                    </div>
                </div>
            </div>
            <!-- Alerts -->
            @php
                $overdueCount = $jadwals
                    ->filter(function ($jadwal) {
                        return $jadwal->status_jemput == 'terjadwal' &&
                            $jadwal->tanggal_jemput < now()->format('Y-m-d');
                    })
                    ->count();

                $upcomingCount = $jadwals
                    ->filter(function ($jadwal) {
                        return $jadwal->status_jemput == 'terjadwal' &&
                            $jadwal->tanggal_jemput >= now()->format('Y-m-d') &&
                            $jadwal->tanggal_jemput <= now()->addWeek()->format('Y-m-d');
                    })
                    ->count();
            @endphp

            @if ($overdueCount > 0)
                <div class="alert-overdue">
                    <i class="icon-alert-triangle"></i>
                    <strong>Perhatian!</strong> Ada <span id="overdueCount">{{ $overdueCount }}</span> jadwal yang sudah
                    terlewat.
                </div>
            @endif

            @if ($upcomingCount > 0)
                <div class="alert-upcoming">
                    <i class="icon-calendar"></i>
                    <strong>Info!</strong> Ada <span id="upcomingCount">{{ $upcomingCount }}</span> jadwal dalam 7 hari ke
                    depan.
                </div>
            @endif

            <!-- Summary Cards -->
            @php
                $todayTotal = $jadwals
                    ->filter(function ($jadwal) {
                        return $jadwal->tanggal_jemput == now()->format('Y-m-d');
                    })
                    ->count();

                $weekTotal = $jadwals
                    ->filter(function ($jadwal) {
                        return $jadwal->tanggal_jemput >= now()->startOfWeek()->format('Y-m-d');
                    })
                    ->count();

                $monthTotal = $jadwals
                    ->filter(function ($jadwal) {
                        return $jadwal->tanggal_jemput >= now()->startOfMonth()->format('Y-m-d');
                    })
                    ->count();

                $weekWeight = $jadwals
                    ->filter(function ($jadwal) {
                        return $jadwal->status_jemput == 'dijemput' &&
                            $jadwal->tanggal_jemput >= now()->startOfWeek()->format('Y-m-d');
                    })
                    ->sum('estimasi_kg');
            @endphp

            <div class="summary-section">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-info">
                                <i class="icon-calendar"></i>
                            </div>
                            <div class="summary-number" id="todayTotal">{{ $todayTotal }}</div>
                            <div class="summary-label">Jadwal Hari Ini</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-warning">
                                <i class="icon-clock"></i>
                            </div>
                            <div class="summary-number" id="weekTotal">{{ $weekTotal }}</div>
                            <div class="summary-label">Minggu Ini</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-success">
                                <i class="icon-check"></i>
                            </div>
                            <div class="summary-number" id="monthTotal">{{ $monthTotal }}</div>
                            <div class="summary-label">Bulan Ini</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="summary-card">
                            <div class="summary-icon bg-primary">
                                <i class="icon-credit-card"></i>
                            </div>
                            <div class="summary-number" id="weekWeight">{{ $weekWeight }} kg</div>
                            <div class="summary-label">Berat Terkumpul</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advanced Search -->
            <div class="search-container-advanced">
                <input type="text" class="search-input-advanced" id="scheduleSearch"
                    placeholder="Cari jadwal berdasarkan nama pemasok, lokasi, atau tanggal...">
                <button type="button" class="search-btn">
                    <i class="icon-magnifier"></i>
                </button>
                <div class="search-results" id="searchResults"></div>
            </div>

            <!-- Bulk Action Panel -->
            <div class="bulk-action-panel" id="bulkActionPanel">
                <form id="bulkActionForm">
                    <div class="bulk-action-controls">
                        <span><strong><span id="selectedCount">0</span> jadwal dipilih</strong></span>

                        <select name="action" class="form-select" style="width: auto;">
                            <option value="">Pilih Aksi</option>
                            <option value="update_status">Update Status</option>
                            <option value="reschedule">Reschedule</option>
                            <option value="delete">Hapus</option>
                        </select>

                        <select name="new_status" class="form-select" style="width: auto; display: none;"
                            id="statusSelect">
                            <option value="terjadwal">Terjadwal</option>
                            <option value="dijemput">Dijemput</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>

                        <input type="date" name="new_date" class="form-control" style="width: auto; display: none;"
                            id="dateInput">

                        <button type="submit" class="btn btn-warning">
                            <i class="icon-zap"></i> Jalankan
                        </button>

                        <button type="button" class="btn btn-secondary"
                            onclick="document.getElementById('bulkActionPanel').style.display='none'">
                            <i class="icon-x"></i> Batal
                        </button>
                    </div>
                </form>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-header">
                    <h5 class="filter-title">
                        <i class="icon-equalizer"></i> Filter & Pencarian Data
                    </h5>
                </div>

                <form method="GET" id="filterForm">
                    <div class="row g-3">
                        <!-- Search -->
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Cari Pemasok</label>
                            <div style="position: relative;">
                                <i class="icon-magnifier search-icon"></i>
                                <input type="text" name="search" class="form-control search-input"
                                    placeholder="Nama pemasok..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Status Penjemputan</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="terjadwal" {{ request('status') == 'terjadwal' ? 'selected' : '' }}>
                                    Terjadwal
                                </option>
                                <option value="dijemput" {{ request('status') == 'dijemput' ? 'selected' : '' }}>
                                    Dijemput
                                </option>
                                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>
                                    Dibatalkan
                                </option>
                            </select>
                        </div>

                        <!-- Location Filter -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" placeholder="Nama kecamatan..."
                                value="{{ request('kecamatan') }}">
                        </div>

                        <!-- Date From -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="tanggal_dari" class="form-control"
                                value="{{ request('tanggal_dari') }}">
                        </div>

                        <!-- Date To -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="tanggal_sampai" class="form-control"
                                value="{{ request('tanggal_sampai') }}">
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-lg-1 col-md-6">
                            <label class="form-label">&nbsp;</label>
                            <div class="filter-buttons">
                                <button type="submit" class="btn btn-filter" title="Terapkan Filter">
                                    <i class="icon-magnifier"></i>
                                </button>
                                <a href="{{ route('admin.penjadwalan.index') }}" class="btn btn-reset"
                                    title="Reset Filter">
                                    <i class="icon-refresh"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Info -->
                    <div class="filter-info">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="filter-info-text">
                                <i class="icon-info"></i>
                                Menampilkan <strong>{{ $jadwals->count() }}</strong> dari
                                <strong>{{ $jadwals->total() }}</strong> jadwal penjemputan
                                @if (request()->hasAny(['search', 'status', 'kecamatan', 'tanggal_dari', 'tanggal_sampai']))
                                    dengan filter yang diterapkan
                                @endif
                            </p>
                        </div>
                    </div>
                </form>
            </div>

            {{-- <!-- Calendar Section -->
            <div class="calendar-section">
                <div class="calendar-header">
                    <h5 class="calendar-title">
                        <i class="icon-calendar"></i> Kalender Penjemputan
                        <div class="float-end">
                            <input type="date" id="routeOptimizationDate" class="form-control d-inline-block"
                                style="width: auto;" value="{{ now()->format('Y-m-d') }}">
                        </div>
                    </h5>
                </div>
                <div id="scheduleCalendar"></div>
            </div> --}}

            <!-- Timeline Section -->
            <div class="timeline-section">
                <div class="timeline-header">
                    <h5 class="timeline-title">
                        <i class="icon-calendar"></i> Timeline Penjemputan Mendatang
                    </h5>
                </div>

                @php
                    $upcomingSchedules = $jadwals
                        ->filter(function ($jadwal) {
                            return $jadwal->status_jemput == 'terjadwal' &&
                                $jadwal->tanggal_jemput >= now()->format('Y-m-d');
                        })
                        ->sortBy('tanggal_jemput')
                        ->take(6);
                @endphp

                @if ($upcomingSchedules->count() > 0)
                    <div class="row">
                        @foreach ($upcomingSchedules as $jadwal)
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="timeline-item status-{{ $jadwal->status_jemput }}">
                                    <div class="timeline-date">
                                        <i class="icon-calendar"></i>
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal_jemput)->format('d M Y') }}
                                    </div>
                                    <div class="timeline-location">
                                        <i class="icon-location-pin"></i> {{ $jadwal->kecamatan ?? '-' }},
                                        {{ $jadwal->desa ?? '-' }}
                                    </div>
                                    <div class="timeline-supplier">
                                        <i class="icon-user"></i> {{ $jadwal->request->nama ?? '-' }}
                                    </div>
                                    <div class="timeline-weight">
                                        <i class="icon-credit-card"></i> {{ $jadwal->estimasi_kg }} kg
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="icon-calendar" style="font-size: 48px; color: #dee2e6;"></i>
                        <p class="text-muted mt-3">Tidak ada jadwal penjemputan mendatang</p>
                    </div>
                @endif
            </div>

            <!-- Table Section -->
            <div class="table-section">
                <div class="table-header">
                    <h5 class="table-title">
                        <i class="icon-list"></i> Daftar Jadwal Penjemputan
                    </h5>
                </div>

                <div class="table-responsive">
                    @if ($jadwals->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                    </th>
                                    <th width="12%">Tanggal Jemput</th>
                                    <th width="22%">Pemasok</th>
                                    <th width="18%">Lokasi</th>
                                    <th width="12%">Jumlah (kg)</th>
                                    <th width="12%">Status</th>
                                    <th width="19%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwals as $jadwal)
                                    <tr data-schedule-id="{{ $jadwal->id }}">
                                        <!-- Checkbox -->
                                        <td>
                                            <input type="checkbox" class="form-check-input item-checkbox"
                                                value="{{ $jadwal->id }}">
                                        </td>

                                        <!-- Tanggal -->
                                        <td>
                                            <div class="schedule-date">
                                                {{ \Carbon\Carbon::parse($jadwal->tanggal_jemput)->format('d M Y') }}</div>
                                            <div class="schedule-time">
                                                {{ \Carbon\Carbon::parse($jadwal->tanggal_jemput)->diffForHumans() }}</div>
                                        </td>

                                        <!-- Pemasok Info -->
                                        <td>
                                            <div class="supplier-name">{{ $jadwal->request->nama ?? '-' }}</div>
                                            @if ($jadwal->request)
                                                <div class="supplier-contact">
                                                    <i class="icon-envelope"></i> {{ $jadwal->request->email }}
                                                    @if ($jadwal->request->no_hp)
                                                        <br><i class="icon-phone"></i> {{ $jadwal->request->no_hp }}
                                                    @endif
                                                </div>
                                            @endif
                                        </td>

                                        <!-- Lokasi -->
                                        <td>
                                            @if ($jadwal->kecamatan || $jadwal->desa)
                                                <div class="location-main">{{ $jadwal->kecamatan ?? '-' }}</div>
                                                <div class="location-detail">{{ $jadwal->desa ?? '-' }}</div>
                                                @if ($jadwal->detail_lokasi)
                                                    <div class="location-detail"><i class="icon-location-pin"></i>
                                                        {{ $jadwal->detail_lokasi }}</div>
                                                @endif
                                            @else
                                                <div class="location-main">{{ $jadwal->lokasi ?? '-' }}</div>
                                            @endif
                                        </td>

                                        <!-- Jumlah -->
                                        <td>
                                            <div class="weight-value">{{ $jadwal->estimasi_kg }} kg</div>
                                        </td>

                                        <!-- Status -->
                                        <td class="status-cell">
                                            @switch($jadwal->status_jemput)
                                                @case('terjadwal')
                                                    <span class="status-badge status-terjadwal">
                                                        <i class="icon-clock"></i> Terjadwal
                                                    </span>
                                                @break

                                                @case('dijemput')
                                                    <span class="status-badge status-dijemput">
                                                        <i class="icon-check"></i> Dijemput
                                                    </span>
                                                @break

                                                @case('dibatalkan')
                                                    <span class="status-badge status-dibatalkan">
                                                        <i class="icon-close"></i> Dibatalkan
                                                    </span>
                                                @break
                                            @endswitch
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <div class="action-group">
                                                <!-- Quick Status Updates -->
                                                @if ($jadwal->status_jemput == 'terjadwal')
                                                    <button type="button" class="quick-status-btn status-dijemput"
                                                        data-schedule-id="{{ $jadwal->id }}" data-status="dijemput"
                                                        data-original-text="✓ Selesai"
                                                        title="Tandai sebagai selesai dijemput">
                                                        ✓ Selesai
                                                    </button>
                                                    <button type="button" class="quick-status-btn status-dibatalkan"
                                                        data-schedule-id="{{ $jadwal->id }}" data-status="dibatalkan"
                                                        data-original-text="✗ Batal" title="Batalkan jadwal">
                                                        ✗ Batal
                                                    </button>
                                                @endif

                                                <a href="{{ route('admin.penjadwalan.edit', $jadwal->id) }}"
                                                    class="btn-action btn-edit" title="Edit Jadwal">
                                                    <i class="icon-pencil"></i> Edit
                                                </a>

                                                <form method="POST"
                                                    action="{{ route('admin.penjadwalan.delete', $jadwal->id) }}"
                                                    class="d-inline delete-form">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn-action btn-delete delete-button"
                                                        title="Hapus Jadwal">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="icon-calendar"></i>
                            </div>
                            <h4 class="empty-title">Tidak Ada Jadwal Ditemukan</h4>
                            <p class="empty-text">
                                @if (request()->hasAny(['search', 'status', 'kecamatan', 'tanggal_dari', 'tanggal_sampai']))
                                    Tidak ada jadwal yang sesuai dengan filter yang diterapkan.<br>
                                    Coba ubah atau reset filter untuk melihat data lainnya.
                                @else
                                    Belum ada jadwal penjemputan yang terdaftar.<br>
                                    Tambahkan jadwal pertama untuk memulai.
                                @endif
                            </p>
                            @if (!request()->hasAny(['search', 'status', 'kecamatan', 'tanggal_dari', 'tanggal_sampai']))
                                <a href="{{ route('admin.penjadwalan.add') }}" class="btn btn-filter">
                                    <i class="icon-plus"></i> Atur Jadwal Pertama
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if ($jadwals->hasPages())
                    <div class="pagination-container">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pagination-info">
                                Menampilkan {{ $jadwals->firstItem() }} - {{ $jadwals->lastItem() }}
                                dari {{ $jadwals->total() }} jadwal
                            </div>
                            {{ $jadwals->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        // Bulk action form logic
        document.addEventListener('DOMContentLoaded', function() {
            const actionSelect = document.querySelector('select[name="action"]');
            const statusSelect = document.getElementById('statusSelect');
            const dateInput = document.getElementById('dateInput');

            if (actionSelect) {
                actionSelect.addEventListener('change', function() {
                    // Hide all conditional inputs
                    statusSelect.style.display = 'none';
                    dateInput.style.display = 'none';

                    // Show relevant input based on selected action
                    switch (this.value) {
                        case 'update_status':
                            statusSelect.style.display = 'block';
                            break;
                        case 'reschedule':
                            dateInput.style.display = 'block';
                            break;
                    }
                });
            }
        });
    </script>
@endsection

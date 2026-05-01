@extends('layouts.admin')

@section('content')
    <style>
        /* ============================================================
           DASHBOARD KEUANGAN — Styling selaras dengan admin/index
        ============================================================ */

        /* Base */
        .main-content-inner {
            padding: 1.5rem;
        }

        /* ── Page Header ── */
        .page-header {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 22px 28px;
            margin-bottom: 28px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
        }

        .page-title {
            font-size: 26px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-subtitle {
            font-size: 14px;
            color: #6c757d;
            margin: 4px 0 0;
        }

        /* ── KPI Cards ── */
        .summary-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 14px;
            padding: 24px 22px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            transition: all .3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }

        .card-kas::before {
            background: linear-gradient(90deg, #17a2b8, #0dcaf0);
        }

        .card-pend::before {
            background: linear-gradient(90deg, #28a745, #20c997);
        }

        .card-beban::before {
            background: linear-gradient(90deg, #dc3545, #e94560);
        }

        .card-laba::before {
            background: linear-gradient(90deg, #6f42c1, #a065e0);
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, .12);
        }

        .kpi-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .summary-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #fff;
            flex-shrink: 0;
        }

        .icon-kas {
            background: linear-gradient(135deg, #17a2b8, #0dcaf0);
        }

        .icon-pend {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .icon-beban {
            background: linear-gradient(135deg, #dc3545, #e94560);
        }

        .icon-laba {
            background: linear-gradient(135deg, #6f42c1, #a065e0);
        }

        .kpi-badge {
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            letter-spacing: .3px;
        }

        .badge-up {
            background: #d4edda;
            color: #155724;
        }

        .badge-down {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-flat {
            background: #e2e3e5;
            color: #383d41;
        }

        .summary-number {
            font-size: 26px;
            font-weight: 800;
            color: #2c3e50;
            line-height: 1.1;
            margin-bottom: 4px;
        }

        .summary-label {
            font-size: 13px;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .summary-footer {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            padding-top: 12px;
            border-top: 1px solid #f0f0f0;
        }

        .summary-change.positive {
            color: #28a745;
            font-weight: 600;
        }

        .summary-change.negative {
            color: #dc3545;
            font-weight: 600;
        }

        .summary-change.neutral {
            color: #6c757d;
            font-weight: 600;
        }

        /* ── Breakdown Row (Online vs Offline detail) ── */
        .breakdown-row {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .breakdown-pill {
            flex: 1;
            text-align: center;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 8px 6px;
        }

        .breakdown-pill .bp-label {
            font-size: 10px;
            color: #6c757d;
            font-weight: 600;
        }

        .breakdown-pill .bp-val {
            font-size: 13px;
            font-weight: 700;
            color: #2c3e50;
            margin-top: 2px;
        }

        .bp-online .bp-val {
            color: #2377FC;
        }

        .bp-offline .bp-val {
            color: #28a745;
        }

        /* ── Chart Section ── */
        .chart-section {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            height: 100%;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-subtitle {
            font-size: 12px;
            color: #6c757d;
            margin-top: 3px;
        }

        /* ── Summary Bar (total debit/kredit seimbang) ── */
        .balance-bar {
            display: flex;
            gap: 16px;
            background: linear-gradient(135deg, #2c3e50, #3d5a80);
            border-radius: 12px;
            padding: 18px 24px;
            margin-bottom: 28px;
            color: #fff;
            flex-wrap: wrap;
            align-items: center;
        }

        .balance-bar-item {
            flex: 1;
            min-width: 120px;
        }

        .bb-label {
            font-size: 11px;
            opacity: .75;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .bb-val {
            font-size: 20px;
            font-weight: 800;
            margin-top: 2px;
        }

        .bb-divider {
            width: 1px;
            background: rgba(255, 255, 255, .25);
            align-self: stretch;
            margin: 0 4px;
        }

        .bb-balance-ok {
            color: #4ade80;
        }

        .bb-balance-err {
            color: #f87171;
        }

        /* ── Tombol Sinkron ── */
        .btn-sinkron {
            background: linear-gradient(135deg, #2377FC, #0056b3);
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .3s ease;
            cursor: pointer;
        }

        .btn-sinkron:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(35, 119, 252, .4);
            color: #fff;
        }

        .btn-sinkron:disabled {
            opacity: .7;
            cursor: not-allowed;
            transform: none;
        }

        /* ── Table ── */
        .table-section {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 2px solid #f8f9fa;
            flex-wrap: wrap;
            gap: 10px;
        }

        .table {
            font-size: 14px;
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-bottom: 2px solid #dee2e6;
            font-weight: 700;
            color: #2c3e50;
            padding: 14px 16px;
            white-space: nowrap;
            border-top: none;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f4;
            font-size: 14px;
            line-height: 1.5;
        }

        .table tbody tr:hover {
            background: #f8f9ff;
            transition: background .2s;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* No jurnal monospace */
        .no-jurnal {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            background: #f0f4ff;
            color: #2377FC;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 700;
        }

        /* Sumber badge */
        .badge-online {
            background: #dbeafe;
            color: #1d4ed8;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-offline {
            background: #dcfce7;
            color: #166534;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        /* Amount */
        .amount-jurnal {
            font-weight: 700;
            color: #2c3e50;
            font-size: 14px;
        }

        /* View all btn */
        .btn-view-all {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            color: #fff;
            padding: 9px 18px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            transition: all .3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-view-all:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, .4);
            color: #fff;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 56px;
            opacity: .25;
            display: block;
            margin-bottom: 16px;
        }

        .empty-state p {
            font-size: 15px;
            margin: 0;
        }

        /* ── Responsive ── */
        @media (max-width: 992px) {
            .bb-divider {
                display: none;
            }

            .balance-bar-item {
                min-width: 48%;
            }
        }

        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .summary-number {
                font-size: 22px;
            }

            .balance-bar {
                padding: 14px 16px;
                gap: 12px;
            }

            .bb-val {
                font-size: 16px;
            }

            .table thead th,
            .table tbody td {
                padding: 10px 10px;
            }
        }

        @media (max-width: 576px) {
            .kpi-top {
                flex-direction: row;
            }

            .page-title {
                font-size: 20px;
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">

            {{-- ── Page Header ── --}}
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h1 class="page-title">
                            <i class="icon-pie-chart" style="color:#2377FC"></i>
                            Dashboard Keuangan
                        </h1>
                        <p class="page-subtitle">
                            Ringkasan keuangan UMKM Lettes Eceng Gondok &mdash;
                            {{ now()->translatedFormat('d F Y') }}
                        </p>
                    </div>
                    <button class="btn-sinkron" onclick="sinkronOnline()" id="btnSinkron">
                        <i class="icon-refresh"></i> Sinkron Order Online
                    </button>
                </div>
            </div>

            {{-- ── Balance Summary Bar ── --}}
            <div class="balance-bar mb-28" style="margin-bottom:28px">
                <div class="balance-bar-item">
                    <div class="bb-label">💰 Total Kas (Kumulatif)</div>
                    <div class="bb-val">Rp {{ number_format($totalKas, 0, ',', '.') }}</div>
                </div>
                <div class="bb-divider"></div>
                <div class="balance-bar-item">
                    <div class="bb-label">📈 Pendapatan Bulan Ini</div>
                    <div class="bb-val">Rp {{ number_format($totalPendBulanIni, 0, ',', '.') }}</div>
                </div>
                <div class="bb-divider"></div>
                <div class="balance-bar-item">
                    <div class="bb-label">📉 Pengeluaran Bulan Ini</div>
                    <div class="bb-val">Rp {{ number_format($totalBebanBulanIni, 0, ',', '.') }}</div>
                </div>
                <div class="bb-divider"></div>
                <div class="balance-bar-item">
                    <div class="bb-label">🏆 Laba Bersih Bulan Ini</div>
                    <div class="bb-val {{ $labaBulanIni >= 0 ? 'bb-balance-ok' : 'bb-balance-err' }}">
                        Rp {{ number_format($labaBulanIni, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            {{-- ── KPI Cards ── --}}
            <div class="row mb-4">

                {{-- Kas --}}
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="summary-card card-kas">
                        <div class="kpi-top">
                            <div class="summary-icon icon-kas">
                                <i class="icon-credit-card"></i>
                            </div>
                            <span class="kpi-badge badge-flat">Kumulatif</span>
                        </div>
                        <div class="summary-number">
                            Rp {{ number_format($totalKas, 0, ',', '.') }}
                        </div>
                        <div class="summary-label">Total Kas</div>
                        <div class="summary-footer">
                            <i class="icon-info" style="color:#17a2b8"></i>
                            <span class="summary-change neutral">Saldo akumulasi seluruh periode</span>
                        </div>
                    </div>
                </div>

                {{-- Pendapatan --}}
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="summary-card card-pend">
                        <div class="kpi-top">
                            <div class="summary-icon icon-pend">
                                <i class="icon-arrow-up"></i>
                            </div>
                            <span class="kpi-badge {{ $persenPend >= 0 ? 'badge-up' : 'badge-down' }}">
                                {{ $persenPend >= 0 ? '▲' : '▼' }} {{ abs($persenPend) }}%
                            </span>
                        </div>
                        <div class="summary-number">
                            Rp {{ number_format($totalPendBulanIni, 0, ',', '.') }}
                        </div>
                        <div class="summary-label">Pendapatan Bulan Ini</div>

                        {{-- Breakdown Online vs Offline --}}
                        <div class="breakdown-row">
                            <div class="breakdown-pill bp-online">
                                <div class="bp-label">🌐 Online</div>
                                <div class="bp-val">Rp {{ number_format($pendOnlineBulanIni, 0, ',', '.') }}</div>
                            </div>
                            <div class="breakdown-pill bp-offline">
                                <div class="bp-label">🏪 Offline</div>
                                <div class="bp-val">Rp {{ number_format($pendOfflineBulanIni, 0, ',', '.') }}</div>
                            </div>
                        </div>

                        <div class="summary-footer">
                            <i class="icon-trending-{{ $persenPend >= 0 ? 'up' : 'down' }}"
                                style="color:{{ $persenPend >= 0 ? '#28a745' : '#dc3545' }}"></i>
                            <span class="summary-change {{ $persenPend >= 0 ? 'positive' : 'negative' }}">
                                {{ $persenPend >= 0 ? '+' : '' }}{{ $persenPend }}% vs bulan lalu
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Pengeluaran --}}
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="summary-card card-beban">
                        <div class="kpi-top">
                            <div class="summary-icon icon-beban">
                                <i class="icon-arrow-down"></i>
                            </div>
                            @php $bebanBadgeClass = $persenBeban <= 0 ? 'badge-up' : 'badge-down'; @endphp
                            <span class="kpi-badge {{ $bebanBadgeClass }}">
                                {{ $persenBeban > 0 ? '▲' : '▼' }} {{ abs($persenBeban) }}%
                            </span>
                        </div>
                        <div class="summary-number">
                            Rp {{ number_format($totalBebanBulanIni, 0, ',', '.') }}
                        </div>
                        <div class="summary-label">Pengeluaran Bulan Ini</div>
                        <div class="summary-footer">
                            <i class="icon-trending-{{ $persenBeban <= 0 ? 'down' : 'up' }}"
                                style="color:{{ $persenBeban <= 0 ? '#28a745' : '#dc3545' }}"></i>
                            <span class="summary-change {{ $persenBeban <= 0 ? 'positive' : 'negative' }}">
                                {{ $persenBeban >= 0 ? '+' : '' }}{{ $persenBeban }}% vs bulan lalu
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Laba Bersih --}}
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="summary-card card-laba">
                        <div class="kpi-top">
                            <div class="summary-icon icon-laba">
                                <i class="icon-award"></i>
                            </div>
                            <span class="kpi-badge {{ $persenLaba >= 0 ? 'badge-up' : 'badge-down' }}">
                                {{ $persenLaba >= 0 ? '▲' : '▼' }} {{ abs($persenLaba) }}%
                            </span>
                        </div>
                        <div class="summary-number" style="color:{{ $labaBulanIni >= 0 ? '#28a745' : '#dc3545' }}">
                            Rp {{ number_format($labaBulanIni, 0, ',', '.') }}
                        </div>
                        <div class="summary-label">
                            {{ $labaBulanIni >= 0 ? '🟢 Laba Bersih' : '🔴 Rugi Bersih' }} Bulan Ini
                        </div>
                        <div class="summary-footer">
                            <i class="icon-trending-{{ $persenLaba >= 0 ? 'up' : 'down' }}"
                                style="color:{{ $persenLaba >= 0 ? '#28a745' : '#dc3545' }}"></i>
                            <span class="summary-change {{ $persenLaba >= 0 ? 'positive' : 'negative' }}">
                                {{ $persenLaba >= 0 ? '+' : '' }}{{ $persenLaba }}% vs bulan lalu
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Grafik Row ── --}}
            <div class="row mb-4">

                {{-- Donut: Online vs Offline --}}
                <div class="col-lg-5 mb-4">
                    <div class="chart-section h-100">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="section-title">
                                    <i class="icon-pie-chart" style="color:#2377FC"></i>
                                    Komposisi Pendapatan
                                </h6>
                                <p class="section-subtitle">Online vs Offline — bulan ini</p>
                            </div>
                        </div>
                        <div id="chart-donut"></div>
                        <div class="d-flex justify-content-around mt-3 pt-3" style="border-top:1px solid #f0f0f0">
                            <div class="text-center">
                                <div
                                    style="font-size:11px;color:#6c757d;font-weight:600;text-transform:uppercase;letter-spacing:.5px">
                                    🌐 Online</div>
                                <div style="font-weight:800;color:#2377FC;font-size:16px;margin-top:4px">
                                    Rp {{ number_format($pendOnlineBulanIni, 0, ',', '.') }}
                                </div>
                                @php
                                    $totalPend = $pendOnlineBulanIni + $pendOfflineBulanIni;
                                    $pctOnline =
                                        $totalPend > 0 ? round(($pendOnlineBulanIni / $totalPend) * 100, 1) : 0;
                                    $pctOffline =
                                        $totalPend > 0 ? round(($pendOfflineBulanIni / $totalPend) * 100, 1) : 0;
                                @endphp
                                <div style="font-size:11px;color:#6c757d;margin-top:2px">{{ $pctOnline }}% dari total
                                </div>
                            </div>
                            <div style="width:1px;background:#e9ecef"></div>
                            <div class="text-center">
                                <div
                                    style="font-size:11px;color:#6c757d;font-weight:600;text-transform:uppercase;letter-spacing:.5px">
                                    🏪 Offline</div>
                                <div style="font-weight:800;color:#28a745;font-size:16px;margin-top:4px">
                                    Rp {{ number_format($pendOfflineBulanIni, 0, ',', '.') }}
                                </div>
                                <div style="font-size:11px;color:#6c757d;margin-top:2px">{{ $pctOffline }}% dari total
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Line: Tren 6 Bulan --}}
                <div class="col-lg-7 mb-4">
                    <div class="chart-section h-100">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="section-title">
                                    <i class="icon-bar-chart" style="color:#6f42c1"></i>
                                    Tren Keuangan 6 Bulan Terakhir
                                </h6>
                                <p class="section-subtitle">Pendapatan, Beban, dan Laba bersih per bulan</p>
                            </div>
                            <div class="d-flex gap-2" style="flex-shrink:0">
                                <span
                                    style="font-size:11px;display:flex;align-items:center;gap:4px;color:#28a745;font-weight:600">
                                    <span
                                        style="width:10px;height:10px;border-radius:50%;background:#28a745;display:inline-block"></span>Pendapatan
                                </span>
                                <span
                                    style="font-size:11px;display:flex;align-items:center;gap:4px;color:#dc3545;font-weight:600">
                                    <span
                                        style="width:10px;height:10px;border-radius:50%;background:#dc3545;display:inline-block"></span>Beban
                                </span>
                                <span
                                    style="font-size:11px;display:flex;align-items:center;gap:4px;color:#6f42c1;font-weight:600">
                                    <span
                                        style="width:10px;height:10px;border-radius:50%;background:#6f42c1;display:inline-block"></span>Laba
                                </span>
                            </div>
                        </div>
                        <div id="chart-tren"></div>
                    </div>
                </div>
            </div>

            {{-- ── Jurnal Transaksi Terbaru ── --}}
            <div class="table-section">
                <div class="table-header">
                    <div>
                        <h5 class="section-title" style="font-size:18px">
                            <i class="icon-list" style="color:#2377FC"></i>
                            Jurnal Transaksi Terbaru
                        </h5>
                        <p class="section-subtitle" style="margin:3px 0 0">5 transaksi terakhir dari semua sumber</p>
                    </div>
                    <a href="{{ route('admin.keuangan.jurnal') }}" class="btn-view-all">
                        <i class="icon-eye"></i> Lihat Semua Jurnal
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width:110px">Tanggal</th>
                                <th style="width:170px">No. Jurnal</th>
                                <th>Keterangan</th>
                                <th style="width:90px" class="text-center">Sumber</th>
                                <th style="width:140px" class="text-end">Debit (Kas Masuk)</th>
                                <th style="width:140px" class="text-end">Kredit (Keluar)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksiTerbaru as $jurnal)
                                @php
                                    $debit = $jurnal->lines->where('posisi', 'debit')->sum('jumlah');
                                    $kredit = $jurnal->lines->where('posisi', 'kredit')->sum('jumlah');
                                @endphp
                                <tr>
                                    <td>
                                        <div style="font-weight:600;color:#2c3e50;font-size:13px">
                                            {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}
                                        </div>
                                        <div style="font-size:11px;color:#6c757d">
                                            {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('l') }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="no-jurnal">{{ $jurnal->no_jurnal }}</span>
                                    </td>
                                    <td>
                                        <div style="font-weight:600;color:#2c3e50">
                                            {{ Str::limit($jurnal->keterangan, 55) }}
                                        </div>
                                        @if ($jurnal->lines->count() > 0)
                                            <div style="font-size:11px;color:#6c757d;margin-top:2px">
                                                {{ $jurnal->lines->count() }} entri akun
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($jurnal->sumber === 'online')
                                            <span class="badge-online">🌐 Online</span>
                                        @else
                                            <span class="badge-offline">🏪 Offline</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="amount-jurnal" style="color:#28a745">
                                            Rp {{ number_format($debit, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="amount-jurnal" style="color:#dc3545">
                                            Rp {{ number_format($kredit, 0, ',', '.') }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="icon-inbox"></i>
                                            <p>Belum ada jurnal. Klik <strong>Sinkron Order Online</strong> atau tambah
                                                transaksi manual.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if ($transaksiTerbaru->count() > 0)
                            <tfoot>
                                <tr style="background:#f8f9fa;font-weight:700;border-top:2px solid #dee2e6">
                                    <td colspan="4" class="text-end"
                                        style="color:#2c3e50;font-size:13px;padding:14px 16px">
                                        TOTAL (5 transaksi terakhir)
                                    </td>
                                    <td class="text-end" style="color:#28a745;padding:14px 16px">
                                        Rp
                                        {{ number_format($transaksiTerbaru->sum(fn($j) => $j->lines->where('posisi', 'debit')->sum('jumlah')), 0, ',', '.') }}
                                    </td>
                                    <td class="text-end" style="color:#dc3545;padding:14px 16px">
                                        Rp
                                        {{ number_format($transaksiTerbaru->sum(fn($j) => $j->lines->where('posisi', 'kredit')->sum('jumlah')), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>

                {{-- Quick Links --}}
                <div class="d-flex gap-3 mt-4 pt-3 flex-wrap" style="border-top:1px solid #f0f0f0">
                    <a href="{{ route('admin.keuangan.transaksi') }}"
                        style="display:inline-flex;align-items:center;gap:6px;font-size:13px;font-weight:600;color:#2377FC;text-decoration:none">
                        <i class="icon-plus"></i> Input Transaksi Baru
                    </a>
                    <a href="{{ route('admin.keuangan.laba_rugi') }}"
                        style="display:inline-flex;align-items:center;gap:6px;font-size:13px;font-weight:600;color:#28a745;text-decoration:none">
                        <i class="icon-doc"></i> Laporan Laba Rugi
                    </a>
                    <a href="{{ route('admin.keuangan.posisi_keuangan') }}"
                        style="display:inline-flex;align-items:center;gap:6px;font-size:13px;font-weight:600;color:#6f42c1;text-decoration:none">
                        <i class="icon-doc"></i> Posisi Keuangan
                    </a>
                    <a href="{{ route('admin.keuangan.jurnal') }}"
                        style="display:inline-flex;align-items:center;gap:6px;font-size:13px;font-weight:600;color:#dc3545;text-decoration:none">
                        <i class="icon-list"></i> Jurnal Umum Lengkap
                    </a>
                </div>
            </div>

        </div>{{-- /main-content-wrap --}}
    </div>{{-- /main-content-inner --}}
@endsection

@push('scripts')
    <script>
        // ── Chart Donut — Online vs Offline ──────────────────
        var donut = new ApexCharts(document.querySelector("#chart-donut"), {
            series: [{{ $pendOnlineBulanIni }}, {{ $pendOfflineBulanIni }}],
            chart: {
                type: 'donut',
                height: 210,
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            labels: ['🌐 Online', '🏪 Offline'],
            colors: ['#2377FC', '#28a745'],
            legend: {
                position: 'bottom',
                fontSize: '13px',
                fontWeight: 600
            },
            dataLabels: {
                enabled: true,
                formatter: (val) => val.toFixed(1) + '%',
                style: {
                    fontSize: '13px',
                    fontWeight: 700
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '13px',
                                fontWeight: 600,
                                color: '#6c757d',
                                formatter: (w) => {
                                    const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
                                }
                            }
                        }
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: val => 'Rp ' + new Intl.NumberFormat('id-ID').format(val)
                }
            },
            stroke: {
                width: 0
            }
        });
        donut.render();

        // ── Chart Tren 6 Bulan ───────────────────────────────
        var tren = new ApexCharts(document.querySelector("#chart-tren"), {
            series: [{
                    name: 'Pendapatan',
                    data: [
                        @foreach ($trenBulan as $t)
                            {{ $t['pendapatan'] }},
                        @endforeach
                    ]
                },
                {
                    name: 'Beban',
                    data: [
                        @foreach ($trenBulan as $t)
                            {{ $t['beban'] }},
                        @endforeach
                    ]
                },
                {
                    name: 'Laba Bersih',
                    data: [
                        @foreach ($trenBulan as $t)
                            {{ $t['laba'] }},
                        @endforeach
                    ]
                },
            ],
            chart: {
                type: 'area',
                height: 230,
                toolbar: {
                    show: false
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 900
                }
            },
            colors: ['#28a745', '#dc3545', '#6f42c1'],
            stroke: {
                curve: 'smooth',
                width: [2, 2, 2.5]
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.25,
                    opacityTo: 0.02,
                    stops: [0, 100]
                }
            },
            markers: {
                size: 4,
                strokeWidth: 2,
                hover: {
                    size: 6
                }
            },
            xaxis: {
                categories: [
                    @foreach ($trenBulan as $t)
                        '{{ $t['bulan'] }}',
                    @endforeach
                ],
                labels: {
                    style: {
                        fontSize: '12px',
                        fontWeight: 600,
                        colors: '#6c757d'
                    }
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    style: {
                        fontSize: '11px',
                        colors: '#6c757d'
                    },
                    formatter: val => {
                        if (val >= 1000000) return 'Rp ' + (val / 1000000).toFixed(1) + 'jt';
                        if (val >= 1000) return 'Rp ' + (val / 1000).toFixed(0) + 'rb';
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                    }
                }
            },
            grid: {
                borderColor: '#f0f0f0',
                strokeDashArray: 4,
                xaxis: {
                    lines: {
                        show: false
                    }
                }
            },
            tooltip: {
                shared: true,
                y: {
                    formatter: val => 'Rp ' + new Intl.NumberFormat('id-ID').format(val)
                }
            },
            legend: {
                show: false
            }
        });
        tren.render();

        // ── Sinkron Online ───────────────────────────────────
        function sinkronOnline() {
            const btn = document.getElementById('btnSinkron');
            btn.disabled = true;
            btn.innerHTML = '<i class="icon-refresh"></i> Menyinkron...';

            fetch('{{ route('admin.keuangan.jurnal.sinkron') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        // Tampilkan notifikasi sukses
                        showToast(data.message, 'success');
                        if (data.count > 0) setTimeout(() => location.reload(), 1500);
                    } else {
                        showToast(data.message, 'danger');
                    }
                })
                .catch(() => showToast('Gagal sinkronisasi. Periksa koneksi.', 'danger'))
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="icon-refresh"></i> Sinkron Order Online';
                });
        }

        // ── Toast notifikasi ringan ──────────────────────────
        function showToast(msg, type) {
            const toast = document.createElement('div');
            toast.style.cssText = `
        position:fixed; top:20px; right:20px; z-index:9999;
        background:${type === 'success' ? '#28a745' : '#dc3545'};
        color:#fff; padding:14px 20px; border-radius:10px;
        font-size:14px; font-weight:600; box-shadow:0 4px 20px rgba(0,0,0,.2);
        max-width:360px; animation: slideIn .3s ease;
    `;
            toast.innerHTML =
                `<style>@keyframes slideIn{from{transform:translateX(120%)}to{transform:translateX(0)}}</style>` + msg;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3500);
        }
    </script>
@endpush

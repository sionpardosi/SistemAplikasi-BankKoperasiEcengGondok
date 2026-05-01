@extends('layouts.admin')

@section('content')
    <style>
        /* ===== LAPORAN LABA RUGI — Styles ===== */
        .lr-filter-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 22px 24px;
            margin-bottom: 22px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        }

        .lr-filter-card .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 7px;
            display: block;
        }

        .lr-filter-card .form-control {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 10px 13px;
            font-size: 14px;
            transition: border-color .2s, box-shadow .2s;
            height: 42px;
        }

        .lr-filter-card .form-control:focus {
            border-color: #2377FC;
            box-shadow: 0 0 0 .2rem rgba(35, 119, 252, .15);
        }

        /* Tombol Export */
        .lr-btn {
            height: 42px;
            padding: 0 20px;
            font-size: 13.5px;
            font-weight: 600;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border: none;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
            white-space: nowrap;
        }

        .lr-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
        }

        .lr-btn-primary {
            background: #2377FC;
            color: #fff;
        }

        .lr-btn-primary:hover {
            background: #1a5fd1;
            color: #fff;
        }

        .lr-btn-danger {
            background: #dc3545;
            color: #fff;
        }

        .lr-btn-danger:hover {
            background: #b02a37;
            color: #fff;
        }

        .lr-btn-excel {
            background: #198754;
            color: #fff;
        }

        .lr-btn-excel:hover {
            background: #146c43;
            color: #fff;
        }

        /* ===== KPI Cards ===== */
        .lr-kpi-row {
            margin-bottom: 22px;
        }

        .lr-kpi {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px 22px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform .25s, box-shadow .25s;
            height: 100%;
        }

        .lr-kpi:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, .1);
        }

        .lr-kpi-icon {
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

        .lr-kpi-body {
            flex: 1;
            min-width: 0;
        }

        .lr-kpi-label {
            font-size: 11.5px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 4px;
        }

        .lr-kpi-value {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .lr-kpi-sub {
            font-size: 11.5px;
            color: #94a3b8;
            margin-top: 2px;
        }

        /* ===== Laporan Card ===== */
        .lr-report-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .lr-report-header {
            text-align: center;
            padding: 24px 20px 16px;
            border-bottom: 2px solid #f1f5f9;
            background: linear-gradient(135deg, #f8faff 0%, #fff 100%);
        }

        .lr-report-header .org-name {
            font-size: 16px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: .3px;
        }

        .lr-report-header .doc-title {
            font-size: 13.5px;
            font-weight: 700;
            color: #2377FC;
            margin-top: 2px;
        }

        .lr-report-header .doc-period {
            font-size: 12px;
            color: #64748b;
            margin-top: 3px;
        }

        .lr-report-header .sak-tag {
            display: inline-block;
            margin-top: 8px;
            font-size: 10.5px;
            color: #64748b;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 2px 10px;
            letter-spacing: .3px;
        }

        /* Tabel Laporan */
        .lr-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }

        /* Section Header (PENDAPATAN / BEBAN) */
        .lr-section-head td {
            padding: 10px 24px 8px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-top: 1px solid #f1f5f9;
        }

        .lr-section-head.pend td {
            background: #f0fdf4;
            color: #15803d;
        }

        .lr-section-head.beban td {
            background: #fff7ed;
            color: #c2410c;
        }

        /* Baris item */
        .lr-row-item td {
            padding: 9px 24px;
            color: #374151;
            border-bottom: 1px solid #f8fafc;
        }

        .lr-row-item:hover td {
            background: #f8faff;
        }

        .lr-row-item .lr-akun-kode {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            margin-right: 4px;
        }

        .lr-row-item .lr-akun-nama {
            font-size: 13px;
        }

        .lr-row-item .lr-nominal {
            text-align: right;
            font-weight: 500;
            color: #374151;
            white-space: nowrap;
        }

        .lr-row-item .lr-nominal.zero {
            color: #cbd5e1;
        }

        /* Baris subtotal */
        .lr-row-subtotal td {
            padding: 10px 24px;
            font-weight: 700;
            font-size: 13.5px;
            border-top: 1.5px solid #e2e8f0;
            border-bottom: 1px solid #f1f5f9;
            background: #fafafa;
        }

        .lr-row-subtotal.pend td {
            color: #15803d;
        }

        .lr-row-subtotal.beban td {
            color: #c2410c;
        }

        .lr-row-subtotal .lr-nominal {
            text-align: right;
            white-space: nowrap;
        }

        /* Baris Laba Bersih */
        .lr-row-laba td {
            padding: 16px 24px;
            font-size: 15px;
            font-weight: 800;
            border-top: 2.5px solid #1e293b;
        }

        .lr-row-laba.profit td {
            background: #f0fdf4;
            color: #15803d;
        }

        .lr-row-laba.loss td {
            background: #fff1f2;
            color: #be123c;
        }

        .lr-row-laba .lr-nominal {
            text-align: right;
            white-space: nowrap;
        }

        /* Margin row */
        .lr-row-margin td {
            padding: 8px 24px 14px;
            font-size: 12px;
            color: #64748b;
            border-bottom: 1px solid #f1f5f9;
            background: #fafafa;
        }

        .lr-row-margin .lr-nominal {
            text-align: right;
            font-weight: 600;
            white-space: nowrap;
        }

        /* Footer laporan */
        .lr-report-footer {
            text-align: center;
            padding: 12px 20px;
            font-size: 11px;
            color: #94a3b8;
            background: #fafafa;
            border-top: 1px solid #f1f5f9;
        }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            .lr-kpi {
                flex-direction: column;
                text-align: center;
            }

            .lr-kpi-value {
                font-size: 15px;
            }

            .lr-btn span {
                display: none;
            }

            .lr-table {
                font-size: 12px;
            }

            .lr-row-item td,
            .lr-row-subtotal td {
                padding: 8px 14px;
            }

            .lr-row-laba td {
                padding: 12px 14px;
                font-size: 13.5px;
            }

            .lr-report-header {
                padding: 18px 14px 12px;
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">

            {{-- ===== Page Header ===== --}}
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Laporan Laba Rugi</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><a href="{{ route('admin.keuangan.dashboard') }}">
                            <div class="text-tiny">Keuangan</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Laba Rugi</div>
                    </li>
                </ul>
            </div>

            {{-- ===== Filter Card ===== --}}
            <div class="lr-filter-card">
                <form method="GET" action="{{ route('admin.keuangan.laba_rugi') }}">
                    <div class="row align-items-end g-3">
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="dari" class="form-control" value="{{ $dari }}"
                                max="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="sampai" class="form-control" value="{{ $sampai }}"
                                max="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" style="visibility:hidden">Action</label>
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="submit" class="lr-btn lr-btn-primary">
                                    <i class="icon-search"></i>
                                    <span>Tampilkan</span>
                                </button>
                                <a href="{{ route('admin.keuangan.laba_rugi.pdf', ['dari' => $dari, 'sampai' => $sampai]) }}"
                                    class="lr-btn lr-btn-danger" target="_blank">
                                    <i class="icon-doc"></i>
                                    <span>PDF</span>
                                </a>
                                {{-- <a href="{{ route('admin.keuangan.laba_rugi.excel', ['dari' => $dari, 'sampai' => $sampai]) }}"
                                    class="lr-btn lr-btn-excel">
                                    <i class="icon-spreadsheet" style="font-size:13px"></i>
                                    <span>Excel</span>
                                </a> --}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- ===== KPI Summary Cards ===== --}}
            @php
                $marginPersen = $totalPendapatan > 0 ? round(($labaBersih / $totalPendapatan) * 100, 1) : 0;
            @endphp
            <div class="lr-kpi-row">
                <div class="row g-3">

                    {{-- Total Pendapatan --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="lr-kpi">
                            <div class="lr-kpi-icon" style="background:#dcfce7;">
                                <i class="icon-arrow-up" style="color:#16a34a;"></i>
                            </div>
                            <div class="lr-kpi-body">
                                <div class="lr-kpi-label">Total Pendapatan</div>
                                <div class="lr-kpi-value" style="color:#16a34a;">
                                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                                </div>
                                <div class="lr-kpi-sub">
                                    Online + Offline
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Total Beban --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="lr-kpi">
                            <div class="lr-kpi-icon" style="background:#fee2e2;">
                                <i class="icon-arrow-down" style="color:#dc2626;"></i>
                            </div>
                            <div class="lr-kpi-body">
                                <div class="lr-kpi-label">Total Beban</div>
                                <div class="lr-kpi-value" style="color:#dc2626;">
                                    Rp {{ number_format($totalBeban, 0, ',', '.') }}
                                </div>
                                <div class="lr-kpi-sub">
                                    Bahan Baku + Operasional + Lain
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Laba/Rugi Bersih --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="lr-kpi">
                            <div class="lr-kpi-icon" style="background:{{ $labaBersih >= 0 ? '#dbeafe' : '#fce7f3' }};">
                                <i class="icon-award" style="color:{{ $labaBersih >= 0 ? '#2563eb' : '#be185d' }};"></i>
                            </div>
                            <div class="lr-kpi-body">
                                <div class="lr-kpi-label">
                                    {{ $labaBersih >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}
                                </div>
                                <div class="lr-kpi-value" style="color:{{ $labaBersih >= 0 ? '#2563eb' : '#be185d' }};">
                                    Rp {{ number_format(abs($labaBersih), 0, ',', '.') }}
                                </div>
                                <div class="lr-kpi-sub">Pendapatan − Beban</div>
                            </div>
                        </div>
                    </div>

                    {{-- Margin % --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="lr-kpi">
                            <div class="lr-kpi-icon" style="background:#f3e8ff;">
                                <i class="icon-pie-chart" style="color:#7c3aed;"></i>
                            </div>
                            <div class="lr-kpi-body">
                                <div class="lr-kpi-label">Margin Laba</div>
                                <div class="lr-kpi-value" style="color:#7c3aed;">
                                    {{ $marginPersen }}%
                                </div>
                                <div class="lr-kpi-sub">
                                    {{ $totalPendapatan > 0 ? 'dari total pendapatan' : 'belum ada pendapatan' }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ===== Laporan Formal ===== --}}
            <div class="lr-report-card">

                {{-- Header --}}
                <div class="lr-report-header">
                    <div class="org-name">UMKM LETTES ECENG GONDOK</div>
                    <div class="doc-title">LAPORAN LABA RUGI</div>
                    <div class="doc-period">
                        Periode: {{ \Carbon\Carbon::parse($dari)->locale('id')->isoFormat('D MMMM YYYY') }}
                        s/d {{ \Carbon\Carbon::parse($sampai)->locale('id')->isoFormat('D MMMM YYYY') }}
                    </div>
                    <span class="sak-tag">Berdasarkan SAK EMKM</span>
                </div>

                {{-- Tabel Laporan --}}
                <table class="lr-table">

                    {{-- ── PENDAPATAN ── --}}
                    <tr class="lr-section-head pend">
                        <td colspan="3">Pendapatan Usaha</td>
                    </tr>

                    <tr class="lr-row-item">
                        <td style="width:50px; padding-right:0; color:#94a3b8; font-size:11px; font-weight:600;">4-001</td>
                        <td class="lr-akun-nama">Pendapatan Penjualan Online</td>
                        <td class="lr-nominal {{ $pendapatanOnline == 0 ? 'zero' : '' }}">
                            {{ number_format($pendapatanOnline, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="lr-row-item">
                        <td style="width:50px; padding-right:0; color:#94a3b8; font-size:11px; font-weight:600;">4-002</td>
                        <td class="lr-akun-nama">Pendapatan Penjualan Offline</td>
                        <td class="lr-nominal {{ $pendapatanOffline == 0 ? 'zero' : '' }}">
                            {{ number_format($pendapatanOffline, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="lr-row-subtotal pend">
                        <td colspan="2">Total Pendapatan</td>
                        <td class="lr-nominal">{{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                    </tr>

                    {{-- ── BEBAN ── --}}
                    <tr class="lr-section-head beban">
                        <td colspan="3">Beban Usaha</td>
                    </tr>

                    <tr class="lr-row-item">
                        <td style="width:50px; padding-right:0; color:#94a3b8; font-size:11px; font-weight:600;">5-001</td>
                        <td class="lr-akun-nama">Beban Bahan Baku</td>
                        <td class="lr-nominal {{ $bebanBahanBaku == 0 ? 'zero' : '' }}">
                            {{ number_format($bebanBahanBaku, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="lr-row-item">
                        <td style="width:50px; padding-right:0; color:#94a3b8; font-size:11px; font-weight:600;">5-002</td>
                        <td class="lr-akun-nama">Beban Operasional</td>
                        <td class="lr-nominal {{ $bebanOperasional == 0 ? 'zero' : '' }}">
                            {{ number_format($bebanOperasional, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="lr-row-item">
                        <td style="width:50px; padding-right:0; color:#94a3b8; font-size:11px; font-weight:600;">5-004</td>
                        <td class="lr-akun-nama">Beban Gaji Karyawan</td>
                        <td class="lr-nominal {{ $bebanGajiKaryawan == 0 ? 'zero' : '' }}">
                            {{ number_format($bebanGajiKaryawan, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="lr-row-item">
                        <td style="width:50px; padding-right:0; color:#94a3b8; font-size:11px; font-weight:600;">5-003</td>
                        <td class="lr-akun-nama">Beban Lain-lain</td>
                        <td class="lr-nominal {{ $bebanLainLain == 0 ? 'zero' : '' }}">
                            {{ number_format($bebanLainLain, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="lr-row-subtotal beban">
                        <td colspan="2">Total Beban</td>
                        <td class="lr-nominal">{{ number_format($totalBeban, 0, ',', '.') }}</td>
                    </tr>

                    {{-- ── LABA BERSIH ── --}}
                    <tr class="lr-row-laba {{ $labaBersih >= 0 ? 'profit' : 'loss' }}">
                        <td colspan="2">
                            {{ $labaBersih >= 0 ? '✦ Laba Bersih Periode' : '✦ Rugi Bersih Periode' }}
                        </td>
                        <td class="lr-nominal">
                            Rp {{ number_format(abs($labaBersih), 0, ',', '.') }}
                        </td>
                    </tr>

                    {{-- Margin baris info --}}
                    <tr class="lr-row-margin">
                        <td colspan="2" style="color:#94a3b8; font-size:11.5px;">
                            Margin Laba Bersih
                        </td>
                        <td class="lr-nominal"
                            style="color: {{ $labaBersih >= 0 ? '#16a34a' : '#be123c' }}; font-size:12px;">
                            {{ $marginPersen }}%
                        </td>
                    </tr>

                </table>

                {{-- Footer --}}
                <div class="lr-report-footer">
                    Dicetak pada {{ now()->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }} WIB
                    &nbsp;|&nbsp;
                    Sistem Informasi Akuntansi &mdash; UMKM Lettes Eceng Gondok
                    &nbsp;|&nbsp;
                    SAK EMKM
                </div>
            </div>

        </div>
    </div>
@endsection

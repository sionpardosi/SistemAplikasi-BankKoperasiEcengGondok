@extends('layouts.admin')

@push('styles')
    <style>
        /* ===== JURNAL UMUM — Custom Styles ===== */
        .ju-filter-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            background: #fff;
        }

        .ju-filter-card .card-body {
            padding: 20px 24px;
        }

        .ju-filter-card .form-label {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 6px;
        }

        .ju-filter-card .form-control {
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 13.5px;
            padding: 8px 12px;
            color: #111827;
            transition: border-color .2s;
            height: 40px;
        }

        .ju-filter-card .form-control:focus {
            border-color: #2377FC;
            box-shadow: 0 0 0 3px rgba(35, 119, 252, .1);
        }

        /* Tombol Export */
        .btn-export {
            height: 40px;
            padding: 0 18px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .2s;
            white-space: nowrap;
        }

        .btn-export:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
        }

        .btn-filter {
            background: #2377FC;
            color: #fff;
            border: none;
        }

        .btn-filter:hover {
            background: #1a5fd1;
            color: #fff;
        }

        .btn-pdf {
            background: #dc3545;
            color: #fff;
            border: none;
        }

        .btn-pdf:hover {
            background: #b02a37;
            color: #fff;
        }

        .btn-excel {
            background: #198754;
            color: #fff;
            border: none;
        }

        .btn-excel:hover {
            background: #146c43;
            color: #fff;
        }

        /* ===== Info Bar ===== */
        .ju-info-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 14px 20px;
            background: #f8faff;
            border-bottom: 1px solid #e8edf5;
            border-radius: 12px 12px 0 0;
        }

        .ju-period {
            font-size: 13.5px;
            font-weight: 600;
            color: #374151;
        }

        .ju-period span {
            color: #2377FC;
        }

        .ju-badge-count {
            background: #2377FC;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
        }

        .ju-badge-balanced {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
        }

        /* ===== Table ===== */
        .ju-table-wrap {
            border: none;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .ju-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            color: #111827;
        }

        /* Header */
        .ju-table thead tr {
            background: #1e293b;
        }

        .ju-table thead th {
            padding: 11px 14px;
            font-size: 11.5px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .6px;
            white-space: nowrap;
            border: none;
        }

        .ju-table thead th:first-child {
            border-radius: 0;
        }

        /* Row Jurnal Header (keterangan) */
        .ju-row-header td {
            background: #f1f5f9;
            border-top: 2px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            padding: 9px 14px;
            vertical-align: middle;
        }

        .ju-row-header:first-of-type td {
            border-top: none;
        }

        .ju-no-jurnal {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', monospace;
            font-size: 12px;
            font-weight: 700;
            color: #2377FC;
            background: #eff6ff;
            padding: 3px 8px;
            border-radius: 5px;
            display: inline-block;
            white-space: nowrap;
        }

        .ju-keterangan {
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            max-width: 320px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .ju-tanggal-header {
            font-size: 12.5px;
            font-weight: 600;
            color: #374151;
            white-space: nowrap;
        }

        /* Badge sumber */
        .badge-online {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-offline {
            background: #dcfce7;
            color: #15803d;
        }

        .ju-badge-sumber {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            letter-spacing: .3px;
        }

        /* Row Detail (akun debit/kredit) */
        .ju-row-detail td {
            padding: 6px 14px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            background: #fff;
        }

        .ju-row-detail:last-of-type td {
            border-bottom: 2px solid #e2e8f0;
        }

        .ju-akun-debit {
            font-size: 12.5px;
            color: #374151;
            padding-left: 8px !important;
            border-left: 3px solid #2377FC;
            margin-left: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ju-akun-kredit {
            font-size: 12.5px;
            color: #374151;
            padding-left: 28px !important;
            border-left: 3px solid #10b981;
            margin-left: 24px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ju-akun-kode {
            font-weight: 700;
            color: #64748b;
            font-size: 11.5px;
            margin-right: 3px;
        }

        /* Nominal */
        .ju-nominal {
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            text-align: right;
            padding-right: 18px !important;
        }

        .ju-nominal-debit {
            color: #1d4ed8;
        }

        .ju-nominal-kredit {
            color: #059669;
        }

        .ju-nominal-empty {
            color: transparent;
        }

        /* Footer Total */
        .ju-tfoot tr td,
        .ju-tfoot tr th {
            background: #1e293b;
            color: #f1f5f9;
            padding: 12px 14px;
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
        }

        .ju-tfoot .ju-total-label {
            text-align: right;
            color: #94a3b8;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: .6px;
        }

        .ju-tfoot .ju-total-debit {
            color: #93c5fd;
            text-align: right;
            padding-right: 18px !important;
        }

        .ju-tfoot .ju-total-kredit {
            color: #6ee7b7;
            text-align: right;
            padding-right: 18px !important;
        }

        /* Warning tidak balance */
        .ju-unbalanced {
            background: #fff7ed;
            border-top: 2px solid #f97316;
            color: #9a3412;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Empty state */
        .ju-empty td {
            padding: 60px 20px;
            text-align: center;
        }

        .ju-empty-icon {
            font-size: 40px;
            display: block;
            margin-bottom: 12px;
            opacity: .4;
        }

        .ju-empty-text {
            color: #6b7280;
            font-size: 14px;
            margin: 0;
        }

        /* Pagination */
        .ju-pagination {
            padding: 14px 20px;
            background: #fff;
            border-top: 1px solid #f1f5f9;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .ju-keterangan {
                max-width: 160px;
            }

            .btn-export span {
                display: none;
            }

            .ju-info-bar {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">

            {{-- ===== Page Header ===== --}}
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Jurnal Umum</h3>
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
                        <div class="text-tiny">Jurnal Umum</div>
                    </li>
                </ul>
            </div>

            {{-- ===== Filter & Export Card ===== --}}
            <div class="ju-filter-card card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.keuangan.jurnal') }}" id="formFilter">
                        <div class="row align-items-end g-3">

                            {{-- Dari Tanggal --}}
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label">Dari Tanggal</label>
                                <input type="date" name="dari" class="form-control" value="{{ $dari }}"
                                    max="{{ date('Y-m-d') }}">
                            </div>

                            {{-- Sampai Tanggal --}}
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label">Sampai Tanggal</label>
                                <input type="date" name="sampai" class="form-control" value="{{ $sampai }}"
                                    max="{{ date('Y-m-d') }}">
                            </div>

                            {{-- Filter --}}
                            <div class="col-lg-2 col-md-4">
                                <button type="submit" class="btn-export btn-filter w-100">
                                    <i class="icon-search"></i>
                                    <span>Filter</span>
                                </button>
                            </div>

                            {{-- Export PDF --}}
                            <div class="col-lg-2 col-md-4">
                                <a href="{{ route('admin.keuangan.jurnal.pdf', ['dari' => $dari, 'sampai' => $sampai]) }}"
                                    class="btn-export btn-pdf w-100 text-decoration-none justify-content-center"
                                    target="_blank">
                                    <i class="icon-doc"></i>
                                    <span>PDF</span>
                                </a>
                            </div>

                            {{-- Export Excel --}}
                            <div class="col-lg-2 col-md-4">
                                <a href="{{ route('admin.keuangan.jurnal.excel', ['dari' => $dari, 'sampai' => $sampai]) }}"
                                    class="btn-export btn-excel w-100 text-decoration-none justify-content-center">
                                    <i class="icon-spreadsheet" style="font-size:14px"></i>
                                    <span>Excel</span>
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            {{-- ===== Tabel Jurnal ===== --}}
            <div class="ju-table-wrap card"
                style="border:none; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.06);">

                {{-- Info Bar --}}
                <div class="ju-info-bar">
                    <div class="ju-period">
                        Periode:
                        <span>{{ \Carbon\Carbon::parse($dari)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                        &mdash;
                        <span>{{ \Carbon\Carbon::parse($sampai)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="ju-badge-count">{{ $jurnals->total() }} entri</span>
                        @if ($jurnals->total() > 0)
                            @if (round($totalDebit, 2) === round($totalKredit, 2))
                                <span class="ju-badge-balanced" style="background:#dcfce7;color:#15803d;">
                                    ✓ Balance
                                </span>
                            @else
                                <span class="ju-badge-balanced" style="background:#fee2e2;color:#b91c1c;">
                                    ⚠ Tidak Balance
                                </span>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="ju-table">
                        <thead>
                            <tr>
                                <th style="width:100px">Tanggal</th>
                                <th style="width:160px">No. Jurnal</th>
                                <th>Keterangan / Akun</th>
                                <th style="width:90px; text-align:center">Sumber</th>
                                <th style="width:140px; text-align:right; padding-right:18px">Debit (Rp)</th>
                                <th style="width:140px; text-align:right; padding-right:18px">Kredit (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jurnals as $jurnal)
                                {{-- Baris Header Jurnal --}}
                                <tr class="ju-row-header">
                                    <td class="ju-tanggal-header">
                                        {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <span class="ju-no-jurnal">{{ $jurnal->no_jurnal }}</span>
                                    </td>
                                    <td>
                                        <span class="ju-keterangan" title="{{ $jurnal->keterangan }}">
                                            {{ $jurnal->keterangan }}
                                        </span>
                                    </td>
                                    <td style="text-align:center">
                                        <span
                                            class="ju-badge-sumber {{ $jurnal->sumber === 'online' ? 'badge-online' : 'badge-offline' }}">
                                            {{ $jurnal->sumber === 'online' ? 'Online' : 'Offline' }}
                                        </span>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                {{-- Baris Detail Debit/Kredit --}}
                                @foreach ($jurnal->lines->sortBy(fn($l) => $l->posisi === 'debit' ? 0 : 1) as $line)
                                    <tr class="ju-row-detail">
                                        <td></td>
                                        <td></td>
                                        <td
                                            style="padding-left: {{ $line->posisi === 'kredit' ? '28px' : '8px' }}; max-width:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                            @if ($line->posisi === 'debit')
                                                <div
                                                    style="display:flex; align-items:center; gap:6px; border-left:3px solid #2377FC; padding-left:10px;">
                                                    <span class="ju-akun-kode">{{ $line->account->kode ?? '' }}</span>
                                                    <span
                                                        style="font-size:12.5px; color:#374151; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                                        {{ $line->account->nama ?? '-' }}
                                                    </span>
                                                </div>
                                            @else
                                                <div
                                                    style="display:flex; align-items:center; gap:6px; border-left:3px solid #10b981; padding-left:10px; margin-left:20px;">
                                                    <span class="ju-akun-kode">{{ $line->account->kode ?? '' }}</span>
                                                    <span
                                                        style="font-size:12.5px; color:#374151; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                                        {{ $line->account->nama ?? '-' }}
                                                    </span>
                                                </div>
                                            @endif
                                        </td>
                                        <td></td>
                                        <td
                                            class="ju-nominal {{ $line->posisi === 'debit' ? 'ju-nominal-debit' : 'ju-nominal-empty' }}">
                                            @if ($line->posisi === 'debit')
                                                {{ number_format($line->jumlah, 0, ',', '.') }}
                                            @endif
                                        </td>
                                        <td
                                            class="ju-nominal {{ $line->posisi === 'kredit' ? 'ju-nominal-kredit' : 'ju-nominal-empty' }}">
                                            @if ($line->posisi === 'kredit')
                                                {{ number_format($line->jumlah, 0, ',', '.') }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            @empty
                                <tr class="ju-empty">
                                    <td colspan="6">
                                        <span class="ju-empty-icon">📋</span>
                                        <p class="ju-empty-text">Tidak ada jurnal pada periode ini.</p>
                                        <p style="font-size:12px; color:#9ca3af; margin-top:4px;">
                                            Coba ubah rentang tanggal atau input transaksi baru.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        {{-- Footer Total --}}
                        @if ($jurnals->total() > 0)
                            <tfoot class="ju-tfoot">
                                <tr>
                                    <td colspan="4" class="ju-total-label">Total Periode</td>
                                    <td class="ju-total-debit">
                                        {{ number_format($totalDebit, 0, ',', '.') }}
                                    </td>
                                    <td class="ju-total-kredit">
                                        {{ number_format($totalKredit, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>

                {{-- Peringatan tidak balance --}}
                @if ($jurnals->total() > 0 && round($totalDebit, 2) !== round($totalKredit, 2))
                    <div class="ju-unbalanced">
                        <i class="icon-alert-triangle"></i>
                        Total Debit (Rp {{ number_format($totalDebit, 0, ',', '.') }})
                        tidak sama dengan total Kredit (Rp {{ number_format($totalKredit, 0, ',', '.') }}).
                        Selisih: Rp {{ number_format(abs($totalDebit - $totalKredit), 0, ',', '.') }}
                    </div>
                @endif

                {{-- Pagination --}}
                @if ($jurnals->hasPages())
                    <div class="ju-pagination">
                        {{ $jurnals->links('pagination::bootstrap-5') }}
                    </div>
                @endif

            </div>
            {{-- /tabel --}}

        </div>
    </div>
@endsection

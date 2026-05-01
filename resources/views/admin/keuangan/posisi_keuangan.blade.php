@extends('layouts.admin')

@section('content')
    <style>
        /* ============================================================
           LAPORAN POSISI KEUANGAN — Modern UI selaras template admin
        ============================================================ */
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
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-subtitle {
            font-size: 13px;
            color: #6c757d;
            margin: 4px 0 0;
        }

        /* ── Stats Mini ── */
        .stats-mini {
            display: flex;
            gap: 16px;
            margin-bottom: 28px;
            flex-wrap: wrap;
        }

        .stats-mini-item {
            flex: 1;
            min-width: 150px;
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 16px 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all .3s;
        }

        .stats-mini-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, .1);
        }

        .smi-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #fff;
            flex-shrink: 0;
        }

        .si-aset {
            background: linear-gradient(135deg, #2377FC, #0056b3);
        }

        .si-liab {
            background: linear-gradient(135deg, #fd7e14, #e55a00);
        }

        .si-ekuitas {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .si-laba {
            background: linear-gradient(135deg, #6f42c1, #a065e0);
        }

        .smi-val {
            font-size: 15px;
            font-weight: 800;
            color: #2c3e50;
            line-height: 1.2;
        }

        .smi-label {
            font-size: 11px;
            color: #6c757d;
            font-weight: 600;
            margin-top: 2px;
        }

        /* ── Filter Panel ── */
        .filter-panel {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 14px;
            padding: 20px 24px;
            margin-bottom: 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
        }

        .filter-title {
            font-size: 14px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f0f0f0;
        }

        .form-label-f {
            font-size: 12px;
            font-weight: 700;
            color: #495057;
            text-transform: uppercase;
            letter-spacing: .4px;
            margin-bottom: 7px;
        }

        .form-control-f {
            border: 1.5px solid #dee2e6;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            color: #2c3e50;
            transition: all .2s;
            width: 100%;
            background: #fff;
        }

        .form-control-f:focus {
            border-color: #2377FC;
            box-shadow: 0 0 0 3px rgba(35, 119, 252, .12);
            outline: none;
        }

        .btn-filter {
            background: linear-gradient(135deg, #2377FC, #0056b3);
            border: none;
            color: #fff;
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all .25s;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            white-space: nowrap;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(35, 119, 252, .4);
            color: #fff;
        }

        .btn-pdf {
            background: linear-gradient(135deg, #dc3545, #c0392b);
            border: none;
            color: #fff;
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            transition: all .25s;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            white-space: nowrap;
        }

        .btn-pdf:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, .4);
            color: #fff;
        }

        /* Shortcut */
        .periode-shortcuts {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .shortcut-btn {
            font-size: 12px;
            font-weight: 600;
            padding: 5px 12px;
            border: 1.5px solid #dee2e6;
            border-radius: 20px;
            background: #fff;
            color: #6c757d;
            cursor: pointer;
            transition: all .2s;
        }

        .shortcut-btn:hover {
            border-color: #2377FC;
            color: #2377FC;
            background: #f0f7ff;
        }

        /* ── Warning Alert ── */
        .alert-balance-err {
            background: #fff3cd;
            border: 1.5px solid #ffc107;
            border-radius: 12px;
            padding: 14px 20px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 600;
            color: #856404;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ── Layout 2 kolom ── */
        .neraca-layout {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }

        .neraca-col-left {
            flex: 1;
            min-width: 280px;
        }

        .neraca-col-right {
            flex: 1;
            min-width: 280px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* ── Section Card ── */
        .neraca-section {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .neraca-section-header {
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        .nsh-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            color: #fff;
            flex-shrink: 0;
        }

        .nsh-aset {
            background: linear-gradient(135deg, #2377FC, #0056b3);
        }

        .nsh-liab {
            background: linear-gradient(135deg, #fd7e14, #e55a00);
        }

        .nsh-ekuitas {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .nsh-title {
            font-size: 14px;
            font-weight: 800;
            color: #2c3e50;
            letter-spacing: .3px;
        }

        .nsh-sub {
            font-size: 11px;
            color: #6c757d;
        }

        /* Baris item neraca */
        .neraca-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 11px 20px;
            border-bottom: 1px solid #f5f5f5;
            transition: background .2s;
        }

        .neraca-item:hover {
            background: #f8f9ff;
        }

        .neraca-item:last-child {
            border-bottom: none;
        }

        .ni-label {
            font-size: 14px;
            color: #495057;
            font-weight: 500;
        }

        .ni-label small {
            font-size: 11px;
            color: #adb5bd;
            display: block;
            margin-top: 1px;
        }

        .ni-val {
            font-size: 14px;
            font-weight: 700;
            color: #2c3e50;
            text-align: right;
            white-space: nowrap;
        }

        .ni-val-pos {
            color: #28a745;
        }

        .ni-val-neg {
            color: #dc3545;
        }

        /* Baris total section */
        .neraca-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 13px 20px;
            border-top: 2px solid #e9ecef;
            background: #f8f9fa;
        }

        .nt-label {
            font-size: 14px;
            font-weight: 800;
            color: #2c3e50;
        }

        .nt-val {
            font-size: 15px;
            font-weight: 800;
            color: #2c3e50;
            white-space: nowrap;
        }

        .nt-aset .nt-val {
            color: #2377FC;
        }

        .nt-liab .nt-val {
            color: #fd7e14;
        }

        .nt-ekuitas .nt-val {
            color: #28a745;
        }

        /* ── Grand Total Bar ── */
        .grand-total-bar {
            border-radius: 14px;
            padding: 20px 24px;
            margin-top: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .gt-ok {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border: 2px solid #28a745;
        }

        .gt-err {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            border: 2px solid #dc3545;
        }

        .gt-left {}

        .gt-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .gt-ok .gt-title {
            color: #155724;
        }

        .gt-err .gt-title {
            color: #721c24;
        }

        .gt-subtitle {
            font-size: 12px;
            margin-top: 2px;
        }

        .gt-ok .gt-subtitle {
            color: #1e7e34;
        }

        .gt-err .gt-subtitle {
            color: #a71d2a;
        }

        .gt-right {}

        .gt-val {
            font-size: 22px;
            font-weight: 900;
        }

        .gt-ok .gt-val {
            color: #155724;
        }

        .gt-err .gt-val {
            color: #721c24;
        }

        /* ── Footer Info ── */
        .report-footer {
            text-align: center;
            padding: 16px 24px;
            font-size: 11px;
            color: #adb5bd;
            border-top: 1px solid #f0f0f0;
            background: #fafbfc;
            border-radius: 0 0 14px 14px;
            margin-top: 24px;
        }

        /* Header laporan cetak */
        .report-header-card {
            background: linear-gradient(135deg, #2c3e50, #3d5a80);
            border-radius: 14px;
            padding: 24px 28px;
            margin-bottom: 24px;
            color: #fff;
            text-align: center;
        }

        .rh-title {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .rh-subtitle {
            font-size: 14px;
            opacity: .8;
        }

        .rh-period {
            display: inline-block;
            margin-top: 10px;
            background: rgba(255, 255, 255, .15);
            padding: 6px 18px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            border: 1px solid rgba(255, 255, 255, .25);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .neraca-layout {
                flex-direction: column;
            }
        }

        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .page-header,
            .filter-panel {
                padding: 16px 18px;
            }

            .stats-mini-item {
                min-width: calc(50% - 8px);
            }
        }

        @media (max-width: 576px) {
            .stats-mini-item {
                flex: 100%;
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
                            <i class="icon-layers" style="color:#2377FC"></i>
                            Laporan Posisi Keuangan
                        </h1>
                        <p class="page-subtitle">
                            Neraca keuangan UMKM Lettes Eceng Gondok &mdash; berdasarkan SAK EMKM
                        </p>
                    </div>
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
                            <div class="text-tiny">Posisi Keuangan</div>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- ── Stats Mini ── --}}
            @php $balance = round($totalAset, 2) === round($totalLiabilitasEkuitas, 2); @endphp
            <div class="stats-mini">
                <div class="stats-mini-item">
                    <div class="smi-icon si-aset"><i class="icon-wallet"></i></div>
                    <div>
                        <div class="smi-val">Rp {{ number_format($totalAset, 0, ',', '.') }}</div>
                        <div class="smi-label">Total Aset</div>
                    </div>
                </div>
                <div class="stats-mini-item">
                    <div class="smi-icon si-liab"><i class="icon-credit-card"></i></div>
                    <div>
                        <div class="smi-val">Rp {{ number_format($totalLiabilitas, 0, ',', '.') }}</div>
                        <div class="smi-label">Total Liabilitas</div>
                    </div>
                </div>
                <div class="stats-mini-item">
                    <div class="smi-icon si-ekuitas"><i class="icon-award"></i></div>
                    <div>
                        <div class="smi-val">Rp {{ number_format($totalEkuitas, 0, ',', '.') }}</div>
                        <div class="smi-label">Total Ekuitas</div>
                    </div>
                </div>
                <div class="stats-mini-item">
                    <div class="smi-icon"
                        style="background: linear-gradient(135deg, {{ $balance ? '#28a745,#20c997' : '#dc3545,#e94560' }})">
                        <i class="{{ $balance ? 'icon-check' : 'icon-alert-triangle' }}"></i>
                    </div>
                    <div>
                        <div class="smi-val" style="color: {{ $balance ? '#28a745' : '#dc3545' }}; font-size:14px">
                            {{ $balance ? '✓ Balance' : '⚠ Tidak Balance' }}
                        </div>
                        <div class="smi-label">Status Neraca</div>
                    </div>
                </div>
            </div>

            {{-- ── Filter Panel ── --}}
            <div class="filter-panel">
                <div class="filter-title">
                    <i class="icon-calendar" style="color:#2377FC"></i>
                    Per Tanggal
                </div>
                <form method="GET" action="{{ route('admin.keuangan.posisi_keuangan') }}" id="filterForm">
                    <div class="row align-items-end g-3">
                        <div class="col-lg-4 col-md-5">
                            <div class="form-label-f">Tampilkan Per Tanggal</div>
                            <input type="date" name="sampai" id="inputSampai" class="form-control-f"
                                value="{{ $sampai }}">
                        </div>
                        <div class="col-lg-4 col-md-5">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn-filter">
                                    <i class="icon-search"></i> Tampilkan
                                </button>
                                <a href="{{ route('admin.keuangan.posisi_keuangan.pdf', ['sampai' => $sampai]) }}"
                                    class="btn-pdf" target="_blank">
                                    <i class="icon-doc"></i> Export PDF
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="periode-shortcuts">
                        <span style="font-size:12px;color:#6c757d;font-weight:600;align-self:center">Cepat :</span>
                        <button type="button" class="shortcut-btn" onclick="setPer('hari_ini')">Hari Ini</button>
                        <button type="button" class="shortcut-btn" onclick="setPer('akhir_bulan')">Akhir Bulan Ini</button>
                        <button type="button" class="shortcut-btn" onclick="setPer('akhir_tahun')">Akhir Tahun Ini</button>
                    </div>
                </form>
            </div>

            {{-- ── Warning jika tidak balance ── --}}
            @if (!$balance)
                <div class="alert-balance-err">
                    <i class="icon-alert-triangle" style="font-size:20px;flex-shrink:0"></i>
                    <div>
                        <strong>Neraca Tidak Seimbang!</strong><br>
                        Total Aset (Rp {{ number_format($totalAset, 0, ',', '.') }})
                        ≠ Total Liabilitas + Ekuitas
                        (Rp {{ number_format($totalLiabilitasEkuitas, 0, ',', '.') }}).
                        Selisih: <strong>Rp
                            {{ number_format(abs($totalAset - $totalLiabilitasEkuitas), 0, ',', '.') }}</strong>.
                        Periksa jurnal yang belum tercatat atau Modal Pemilik yang belum diisi.
                    </div>
                </div>
            @endif

            {{-- ── Report Header ── --}}
            <div class="report-header-card">
                <div class="rh-title">UMKM Lettes Eceng Gondok</div>
                <div class="rh-subtitle">Laporan Posisi Keuangan (Neraca)</div>
                <div class="rh-period">
                    Per Tanggal {{ \Carbon\Carbon::parse($sampai)->format('d F Y') }}
                </div>
            </div>

            {{-- ── Layout 2 Kolom Neraca ── --}}
            <div class="neraca-layout">

                {{-- KOLOM KIRI: ASET ── --}}
                <div class="neraca-col-left">
                    <div class="neraca-section">
                        <div class="neraca-section-header">
                            <div class="nsh-icon nsh-aset"><i class="icon-wallet"></i></div>
                            <div>
                                <div class="nsh-title">ASET</div>
                                <div class="nsh-sub">Sumber daya yang dimiliki</div>
                            </div>
                        </div>

                        <div class="neraca-item">
                            <div class="ni-label">
                                Kas
                                <small>1-001</small>
                            </div>
                            <div class="ni-val">Rp {{ number_format($kas, 0, ',', '.') }}</div>
                        </div>
                        <div class="neraca-item">
                            <div class="ni-label">
                                Piutang Usaha
                                <small>1-002</small>
                            </div>
                            <div class="ni-val">Rp {{ number_format($piutangUsaha, 0, ',', '.') }}</div>
                        </div>
                        <div class="neraca-item">
                            <div class="ni-label">
                                Persediaan Bahan Baku
                                <small>1-003</small>
                            </div>
                            <div class="ni-val">Rp {{ number_format($persediaanBahanBaku, 0, ',', '.') }}</div>
                        </div>

                        <div class="neraca-total nt-aset">
                            <div class="nt-label">Total Aset</div>
                            <div class="nt-val">Rp {{ number_format($totalAset, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: LIABILITAS + EKUITAS ── --}}
                <div class="neraca-col-right">

                    {{-- LIABILITAS --}}
                    <div class="neraca-section">
                        <div class="neraca-section-header">
                            <div class="nsh-icon nsh-liab"><i class="icon-credit-card"></i></div>
                            <div>
                                <div class="nsh-title">LIABILITAS</div>
                                <div class="nsh-sub">Kewajiban yang harus dibayar</div>
                            </div>
                        </div>

                        <div class="neraca-item">
                            <div class="ni-label">
                                Utang Usaha
                                <small>2-001</small>
                            </div>
                            <div class="ni-val">Rp {{ number_format($utangUsaha, 0, ',', '.') }}</div>
                        </div>

                        <div class="neraca-total nt-liab">
                            <div class="nt-label">Total Liabilitas</div>
                            <div class="nt-val">Rp {{ number_format($totalLiabilitas, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    {{-- EKUITAS --}}
                    <div class="neraca-section">
                        <div class="neraca-section-header">
                            <div class="nsh-icon nsh-ekuitas"><i class="icon-award"></i></div>
                            <div>
                                <div class="nsh-title">EKUITAS</div>
                                <div class="nsh-sub">Hak pemilik atas aset</div>
                            </div>
                        </div>

                        <div class="neraca-item">
                            <div class="ni-label">
                                Modal Pemilik
                                <small>3-001</small>
                            </div>
                            <div class="ni-val">Rp {{ number_format($modalPemilik, 0, ',', '.') }}</div>
                        </div>
                        <div class="neraca-item">
                            <div class="ni-label">
                                Laba Ditahan
                                <small>3-002 — akumulasi laba periode sebelumnya</small>
                            </div>
                            <div class="ni-val">Rp {{ number_format($labaDitahan, 0, ',', '.') }}</div>
                        </div>
                        <div class="neraca-item">
                            <div class="ni-label">
                                Laba Berjalan
                                <small>s/d {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}</small>
                            </div>
                            <div class="ni-val {{ $labaBerjalan >= 0 ? 'ni-val-pos' : 'ni-val-neg' }}">
                                {{ $labaBerjalan < 0 ? '(' : '' }}Rp
                                {{ number_format(abs($labaBerjalan), 0, ',', '.') }}{{ $labaBerjalan < 0 ? ')' : '' }}
                            </div>
                        </div>

                        <div class="neraca-total nt-ekuitas">
                            <div class="nt-label">Total Ekuitas</div>
                            <div class="nt-val">Rp {{ number_format($totalEkuitas, 0, ',', '.') }}</div>
                        </div>
                    </div>

                </div>{{-- /kolom kanan --}}
            </div>{{-- /neraca-layout --}}

            {{-- ── Grand Total Bar ── --}}
            <div class="grand-total-bar {{ $balance ? 'gt-ok' : 'gt-err' }}">
                <div class="gt-left">
                    <div class="gt-title">
                        {{ $balance ? '✓ Neraca Seimbang' : '⚠ Neraca Tidak Seimbang' }}
                    </div>
                    <div class="gt-subtitle">
                        {{ $balance
                            ? 'Total Aset = Total Liabilitas + Ekuitas — data jurnal valid'
                            : 'Selisih Rp ' .
                                number_format(abs($totalAset - $totalLiabilitasEkuitas), 0, ',', '.') .
                                ' — periksa pencatatan jurnal' }}
                    </div>
                </div>
                <div class="gt-right">
                    <div class="gt-val">
                        Rp {{ number_format($totalLiabilitasEkuitas, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            {{-- ── Footer ── --}}
            <div class="report-footer">
                Dicetak pada {{ now()->format('d M Y, H:i') }} WIB
                &nbsp;|&nbsp;
                Sistem Informasi Akuntansi &mdash; UMKM Lettes Eceng Gondok
                &nbsp;|&nbsp;
                Berdasarkan SAK EMKM
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function setPer(kode) {
            const el = document.getElementById('inputSampai');
            const now = new Date();
            const fmt = d => d.toISOString().split('T')[0];

            if (kode === 'hari_ini') {
                el.value = fmt(now);
            } else if (kode === 'akhir_bulan') {
                el.value = fmt(new Date(now.getFullYear(), now.getMonth() + 1, 0));
            } else if (kode === 'akhir_tahun') {
                el.value = fmt(new Date(now.getFullYear(), 11, 31));
            }
            document.getElementById('filterForm').submit();
        }
    </script>
@endpush

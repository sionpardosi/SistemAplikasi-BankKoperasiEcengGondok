@extends('layouts.admin')

@section('content')
    <style>
        /* ============================================================
           INPUT TRANSAKSI MANUAL — Modern UI selaras template admin
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

        /* ── Stats mini bar ── */
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

        .stats-mini-icon {
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

        .si-pend {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .si-beban {
            background: linear-gradient(135deg, #dc3545, #e94560);
        }

        .si-total {
            background: linear-gradient(135deg, #2377FC, #0056b3);
        }

        .si-jumlah {
            background: linear-gradient(135deg, #6f42c1, #a065e0);
        }

        .stats-mini-info {}

        .smi-val {
            font-size: 18px;
            font-weight: 800;
            color: #2c3e50;
            line-height: 1.1;
        }

        .smi-label {
            font-size: 11px;
            color: #6c757d;
            font-weight: 600;
            margin-top: 2px;
        }

        /* ── Card Panel ── */
        .panel-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            overflow: hidden;
            height: 100%;
        }

        .panel-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fafbfc;
        }

        .panel-card-title {
            font-size: 15px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .panel-card-body {
            padding: 24px;
        }

        /* ── Form Styling ── */
        .form-group-modern {
            margin-bottom: 20px;
        }

        .form-label-modern {
            font-size: 13px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-label-modern .req {
            color: #dc3545;
        }

        .form-control-modern,
        .form-select-modern {
            border: 1.5px solid #dee2e6;
            border-radius: 10px;
            padding: 11px 16px;
            font-size: 14px;
            color: #2c3e50;
            transition: all .2s;
            width: 100%;
            background: #fff;
        }

        .form-control-modern:focus,
        .form-select-modern:focus {
            border-color: #2377FC;
            box-shadow: 0 0 0 3px rgba(35, 119, 252, .12);
            outline: none;
        }

        .form-control-modern.is-invalid,
        .form-select-modern.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback-modern {
            font-size: 12px;
            color: #dc3545;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Jenis toggle buttons */
        .jenis-toggle {
            display: flex;
            gap: 10px;
        }

        .jenis-btn {
            flex: 1;
            padding: 12px 10px;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            background: #fff;
            font-size: 14px;
            font-weight: 600;
            color: #6c757d;
            cursor: pointer;
            transition: all .25s;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            user-select: none;
        }

        .jenis-btn:hover {
            border-color: #adb5bd;
            color: #495057;
        }

        .jenis-btn.active-pend {
            border-color: #28a745;
            background: #d4edda;
            color: #155724;
        }

        .jenis-btn.active-beban {
            border-color: #dc3545;
            background: #f8d7da;
            color: #721c24;
        }

        /* Input Rupiah */
        .input-rp-wrap {
            display: flex;
            border: 1.5px solid #dee2e6;
            border-radius: 10px;
            overflow: hidden;
            transition: all .2s;
        }

        .input-rp-wrap:focus-within {
            border-color: #2377FC;
            box-shadow: 0 0 0 3px rgba(35, 119, 252, .12);
        }

        .input-rp-prefix {
            background: #f8f9fa;
            padding: 11px 14px;
            font-size: 14px;
            font-weight: 700;
            color: #6c757d;
            border-right: 1.5px solid #dee2e6;
            white-space: nowrap;
        }

        .input-rp-field {
            flex: 1;
            border: none;
            outline: none;
            padding: 11px 14px;
            font-size: 14px;
            color: #2c3e50;
            font-weight: 600;
            background: #fff;
        }

        /* Preview Jurnal */
        .preview-jurnal {
            background: linear-gradient(135deg, #e3f2fd, #f0f7ff);
            border: 1.5px solid #bbdefb;
            border-radius: 10px;
            padding: 16px 18px;
            font-size: 13px;
            display: none;
            margin-bottom: 20px;
        }

        .preview-jurnal.show {
            display: block;
            animation: fadeIn .25s ease;
        }

        .preview-title {
            font-weight: 700;
            color: #1565c0;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
        }

        .preview-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border-bottom: 1px dashed #c5d8f0;
        }

        .preview-row:last-child {
            border-bottom: none;
        }

        .preview-debit-label {
            color: #155724;
            font-weight: 600;
        }

        .preview-kredit-label {
            color: #721c24;
            font-weight: 600;
            padding-left: 20px;
        }

        .preview-amount {
            font-weight: 700;
            color: #2c3e50;
        }

        /* Buttons */
        .btn-reset-modern {
            flex: 1;
            padding: 12px;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            background: #fff;
            font-size: 14px;
            font-weight: 600;
            color: #6c757d;
            cursor: pointer;
            transition: all .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-reset-modern:hover {
            background: #f8f9fa;
            border-color: #adb5bd;
            color: #495057;
        }

        .btn-simpan-modern {
            flex: 2;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #2377FC, #0056b3);
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
            transition: all .25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-simpan-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(35, 119, 252, .4);
        }

        /* ── Tabel Riwayat ── */
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
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .4px;
            white-space: nowrap;
            border-top: none;
        }

        .table tbody td {
            padding: 13px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f4;
            font-size: 14px;
            line-height: 1.4;
        }

        .table tbody tr:hover {
            background: #f8f9ff;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badge Jenis */
        .badge-pend {
            background: #d4edda;
            color: #155724;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-beban {
            background: #f8d7da;
            color: #721c24;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* Badge Jurnal */
        .badge-dijurnal {
            background: #d4edda;
            color: #155724;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-pending-j {
            background: #fff3cd;
            color: #856404;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        /* Akun nama */
        .akun-nama {
            font-size: 12px;
            color: #6c757d;
        }

        .akun-kode {
            font-size: 11px;
            color: #adb5bd;
        }

        /* Amount */
        .amount-pend {
            font-weight: 700;
            color: #28a745;
            font-size: 14px;
        }

        .amount-beban {
            font-weight: 700;
            color: #dc3545;
            font-size: 14px;
        }

        /* Btn Hapus */
        .btn-hapus {
            background: #fff;
            border: 1.5px solid #dc3545;
            color: #dc3545;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }

        .btn-hapus:hover {
            background: #dc3545;
            color: #fff;
        }

        /* Pagination area */
        .pagination-area {
            padding: 16px 24px;
            border-top: 1px solid #f0f0f0;
            background: #fafbfc;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 56px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 52px;
            opacity: .2;
            display: block;
            margin-bottom: 14px;
        }

        .empty-state p {
            font-size: 14px;
            margin: 0;
        }

        /* Alert modern */
        .alert-modern {
            border: none;
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 22px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success-m {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger-m {
            background: #f8d7da;
            color: #721c24;
        }

        /* Tabel footer summary */
        tfoot td {
            padding: 13px 16px;
            font-weight: 700;
            font-size: 13px;
            border-top: 2px solid #dee2e6 !important;
            background: #f8f9fa;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .stats-mini {
                gap: 10px;
            }

            .stats-mini-item {
                min-width: 140px;
            }
        }

        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .page-header {
                padding: 16px 18px;
            }

            .panel-card-body {
                padding: 16px;
            }

            .stats-mini-item {
                flex: calc(50% - 5px);
            }

            .smi-val {
                font-size: 15px;
            }

            .table thead th,
            .table tbody td {
                padding: 10px 10px;
                font-size: 13px;
            }
        }

        @media (max-width: 576px) {
            .stats-mini-item {
                flex: 100%;
            }

            .jenis-toggle {
                flex-direction: row;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
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
                            Pencatatan Transaksi Offline Secara Manual
                        </h1>
                        <p class="page-subtitle">
                            Pencatatan transaksi offline (pendapatan & pengeluaran) yang tidak melalui website
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
                            <div class="text-tiny">Input Transaksi</div>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- ── Alert Session ── --}}
            @if (session('success'))
                <div class="alert-modern alert-success-m">
                    <i class="icon-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert-modern alert-danger-m">
                    <i class="icon-alert-triangle"></i>
                    {{ session('error') }}
                </div>
            @endif

            {{-- ── Stats Mini Bar ── --}}
            @php
                $totalPend = $transaksi->where('jenis', 'pendapatan')->sum('jumlah');
                $totalBeban = $transaksi->where('jenis', 'pengeluaran')->sum('jumlah');
                $jmlData = $transaksi->total();
            @endphp
            <div class="stats-mini">
                <div class="stats-mini-item">
                    <div class="stats-mini-icon si-pend"><i class="icon-arrow-up"></i></div>
                    <div class="stats-mini-info">
                        <div class="smi-val">Rp {{ number_format($totalPend, 0, ',', '.') }}</div>
                        <div class="smi-label">Total Pendapatan (halaman ini)</div>
                    </div>
                </div>
                <div class="stats-mini-item">
                    <div class="stats-mini-icon si-beban"><i class="icon-arrow-down"></i></div>
                    <div class="stats-mini-info">
                        <div class="smi-val">Rp {{ number_format($totalBeban, 0, ',', '.') }}</div>
                        <div class="smi-label">Total Pengeluaran (halaman ini)</div>
                    </div>
                </div>
                <div class="stats-mini-item">
                    <div class="stats-mini-icon si-total"><i class="icon-list"></i></div>
                    <div class="stats-mini-info">
                        <div class="smi-val">{{ $jmlData }}</div>
                        <div class="smi-label">Total Transaksi Tercatat</div>
                    </div>
                </div>
                <div class="stats-mini-item">
                    <div class="stats-mini-icon si-jumlah"><i class="icon-credit-card"></i></div>
                    <div class="stats-mini-info">
                        <div class="smi-val" style="color:{{ $totalPend - $totalBeban >= 0 ? '#28a745' : '#dc3545' }}">
                            Rp {{ number_format($totalPend - $totalBeban, 0, ',', '.') }}
                        </div>
                        <div class="smi-label">Selisih (halaman ini)</div>
                    </div>
                </div>
            </div>

            {{-- ── Main Row ── --}}
            <div class="row g-4 align-items-start">

                {{-- ── Form Input ── --}}
                <div class="col-xl-4 col-lg-5">
                    <div class="panel-card">
                        <div class="panel-card-header">
                            <h6 class="panel-card-title">
                                Tambah Transaksi Baru
                            </h6>
                            <span style="font-size:11px;color:#6c757d;font-weight:600">
                                Otomatis ke Jurnal
                            </span>
                        </div>
                        <div class="panel-card-body">
                            <form action="{{ route('admin.keuangan.transaksi.simpan') }}" method="POST" id="formTransaksi">
                                @csrf

                                {{-- Jenis Toggle --}}
                                <div class="form-group-modern">
                                    <div class="form-label-modern">
                                        <i class="icon-tag" style="color:#6c757d"></i>
                                        Pilih Jenis Transaksi <span class="req">*</span>
                                    </div>
                                    <input type="hidden" name="jenis" id="hiddenJenis" value="{{ old('jenis', '') }}">
                                    <div class="jenis-toggle">
                                        <div class="jenis-btn {{ old('jenis') == 'pendapatan' ? 'active-pend' : '' }}"
                                            id="btnPend" onclick="pilihJenis('pendapatan')">
                                        Pendapatan
                                        </div>
                                        <div class="jenis-btn {{ old('jenis') == 'pengeluaran' ? 'active-beban' : '' }}"
                                            id="btnBeban" onclick="pilihJenis('pengeluaran')">
                                        Pengeluaran
                                        </div>
                                    </div>
                                    @error('jenis')
                                        <div class="invalid-feedback-modern"><i class="icon-alert-circle"></i>
                                            {{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Tanggal --}}
                                <div class="form-group-modern">
                                    <div class="form-label-modern">
                                        Tanggal <span class="req">*</span>
                                    </div>
                                    <input type="date" name="tanggal"
                                        class="form-control-modern @error('tanggal') is-invalid @enderror"
                                        value="{{ old('tanggal', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                                    @error('tanggal')
                                        <div class="invalid-feedback-modern"><i class="icon-alert-circle"></i>
                                            {{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Akun --}}
                                <div class="form-group-modern" id="groupAkun">
                                    <div class="form-label-modern">
                                        <i class="icon-folder" style="color:#6c757d"></i>
                                        Akun <span class="req">*</span>
                                    </div>

                                    <select name="account_id" id="selectAkunPendapatan"
                                        class="form-select-modern @error('account_id') is-invalid @enderror"
                                        style="display:none" disabled>
                                        <option value="">-- Pilih Akun Pendapatan --</option>
                                        @foreach ($akunPendapatan as $akun)
                                            <option value="{{ $akun->id }}"
                                                {{ old('account_id') == $akun->id ? 'selected' : '' }}>
                                                {{ $akun->kode }} — {{ $akun->nama }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select name="account_id" id="selectAkunBeban"
                                        class="form-select-modern @error('account_id') is-invalid @enderror"
                                        style="display:none" disabled>
                                        <option value="">-- Pilih Akun Beban --</option>
                                        @foreach ($akunBeban as $akun)
                                            <option value="{{ $akun->id }}"
                                                {{ old('account_id') == $akun->id ? 'selected' : '' }}>
                                                {{ $akun->kode }} — {{ $akun->nama }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div id="infoAkun"
                                        style="font-size:12px;color:#adb5bd;margin-top:6px;display:flex;align-items:center;gap:5px">
                                        <i class="icon-info"></i> Pilih jenis transaksi terlebih dahulu
                                    </div>
                                    @error('account_id')
                                        <div class="invalid-feedback-modern"><i class="icon-alert-circle"></i>
                                            {{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Deskripsi --}}
                                <div class="form-group-modern">
                                    <div class="form-label-modern">
                                        <i class="icon-edit" style="color:#6c757d"></i>
                                        Deskripsi <span class="req">*</span>
                                    </div>
                                    <input type="text" name="deskripsi"
                                        class="form-control-modern @error('deskripsi') is-invalid @enderror"
                                        placeholder="Contoh: Penjualan di Pasar Samosir" value="{{ old('deskripsi') }}"
                                        required>
                                    @error('deskripsi')
                                        <div class="invalid-feedback-modern"><i class="icon-alert-circle"></i>
                                            {{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Jumlah --}}
                                <div class="form-group-modern">
                                    <div class="form-label-modern">
                                        Jumlah <span class="req">*</span>
                                    </div>
                                    <div class="input-rp-wrap">
                                        <div class="input-rp-prefix">Rp</div>
                                        <input type="text" id="inputJumlahDisplay" class="input-rp-field"
                                            placeholder="0" oninput="formatJumlah(this)" autocomplete="off">
                                    </div>
                                    <input type="hidden" name="jumlah" id="inputJumlah" value="{{ old('jumlah') }}">
                                    @error('jumlah')
                                        <div class="invalid-feedback-modern"><i class="icon-alert-circle"></i>
                                            {{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Preview Jurnal Otomatis --}}
                                <div id="previewJurnal" class="preview-jurnal">
                                    <div class="preview-title">
                                        <i class="icon-doc" style="color:#1565c0"></i>
                                        Preview Jurnal Otomatis
                                    </div>
                                    <div id="previewRows"></div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="d-flex gap-2 mt-2">
                                    <button type="button" class="btn-reset-modern" onclick="resetForm()">
                                        <i class="icon-refresh"></i> Reset
                                    </button>
                                    <button type="submit" class="btn-simpan-modern">
                                        <i class="icon-check"></i> Simpan & Jurnal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ── Tabel Riwayat ── --}}
                <div class="col-xl-8 col-lg-7">
                    <div class="panel-card">
                        <div class="panel-card-header">
                            <h6 class="panel-card-title">
                                <i class="icon-list" style="color:#28a745"></i>
                                Riwayat Transaksi Offline
                            </h6>
                            <span
                                style="font-size:12px;background:#e3f2fd;color:#1565c0;padding:4px 12px;border-radius:20px;font-weight:700">
                                {{ $transaksi->total() }} data
                            </span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:110px">Tanggal</th>
                                        <th style="width:110px" class="text-center">Jenis</th>
                                        <th>Deskripsi & Akun</th>
                                        <th style="width:140px" class="text-end">Jumlah</th>
                                        <th style="width:90px" class="text-center">Status</th>
                                        <th style="width:70px" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transaksi as $t)
                                        <tr>
                                            <td>
                                                <div style="font-weight:600;color:#2c3e50;font-size:13px">
                                                    {{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}
                                                </div>
                                                <div style="font-size:11px;color:#6c757d">
                                                    {{ \Carbon\Carbon::parse($t->tanggal)->format('l') }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if ($t->jenis === 'pendapatan')
                                                    <span class="badge-pend">Pendapatan</span>
                                                @else
                                                    <span class="badge-beban">Pengeluaran</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div style="font-weight:600;color:#2c3e50;font-size:13px">
                                                    {{ Str::limit($t->deskripsi, 42) }}
                                                </div>
                                                <div class="akun-nama" style="margin-top:2px">
                                                    <span class="akun-kode">{{ $t->account->kode ?? '' }}</span>
                                                    {{ $t->account->nama ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div
                                                    class="{{ $t->jenis === 'pendapatan' ? 'amount-pend' : 'amount-beban' }}">
                                                    Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if ($t->jurnal_dibuat)
                                                    <span class="badge-dijurnal">✓ Dijurnal</span>
                                                @else
                                                    <span class="badge-pending-j">⏳ Pending</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('admin.keuangan.transaksi.hapus', $t->id) }}"
                                                    method="POST"
                                                    onsubmit="return konfirmasiHapus(event, '{{ addslashes($t->deskripsi) }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-hapus">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <div class="empty-state">
                                                    <i class="icon-inbox"></i>
                                                    <p>Belum ada transaksi offline.<br>
                                                        Gunakan form di sebelah kiri untuk menambahkan transaksi.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if ($transaksi->count() > 0)
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end" style="color:#2c3e50">
                                                SUBTOTAL
                                            </td>
                                            <td class="text-end">
                                                <div style="color:#28a745;font-size:13px">
                                                    ↑ Rp {{ number_format($totalPend, 0, ',', '.') }}
                                                </div>
                                                <div style="color:#dc3545;font-size:13px">
                                                    ↓ Rp {{ number_format($totalBeban, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                        @if ($transaksi->hasPages())
                            <div class="pagination-area">
                                {{ $transaksi->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>

            </div>{{-- /row --}}

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // ── Pilih Jenis (toggle button) ──────────────────────
        function pilihJenis(jenis) {
            document.getElementById('hiddenJenis').value = jenis;

            const btnP = document.getElementById('btnPend');
            const btnB = document.getElementById('btnBeban');
            btnP.classList.remove('active-pend', 'active-beban');
            btnB.classList.remove('active-pend', 'active-beban');

            if (jenis === 'pendapatan') {
                btnP.classList.add('active-pend');
            } else {
                btnB.classList.add('active-beban');
            }

            toggleAkun(jenis);
            updatePreview();
        }

        function toggleAkun(jenis) {
            const pend = document.getElementById('selectAkunPendapatan');
            const beban = document.getElementById('selectAkunBeban');
            const info = document.getElementById('infoAkun');

            pend.style.display = 'none';
            pend.disabled = true;
            beban.style.display = 'none';
            beban.disabled = true;
            info.style.display = 'none';

            if (jenis === 'pendapatan') {
                pend.style.display = 'block';
                pend.disabled = false;
                pend.addEventListener('change', updatePreview);
            } else if (jenis === 'pengeluaran') {
                beban.style.display = 'block';
                beban.disabled = false;
                beban.addEventListener('change', updatePreview);
            } else {
                info.style.display = 'flex';
            }
        }

        // ── Format Rupiah ────────────────────────────────────
        function formatJumlah(el) {
            let raw = el.value.replace(/\D/g, '');
            el.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
            document.getElementById('inputJumlah').value = raw;
            updatePreview();
        }

        // ── Preview Jurnal ───────────────────────────────────
        function updatePreview() {
            const jenis = document.getElementById('hiddenJenis').value;
            const jumlah = document.getElementById('inputJumlah').value;
            const prev = document.getElementById('previewJurnal');
            const rows = document.getElementById('previewRows');

            if (!jenis || !jumlah) {
                prev.classList.remove('show');
                return;
            }

            const rp = 'Rp ' + new Intl.NumberFormat('id-ID').format(jumlah);

            let html = '';
            if (jenis === 'pendapatan') {
                html = `
        <div class="preview-row">
            <span class="preview-debit-label">↳ Debit &nbsp; : Kas</span>
            <span class="preview-amount">${rp}</span>
        </div>
        <div class="preview-row">
            <span class="preview-kredit-label">↳ Kredit : Pendapatan Offline</span>
            <span class="preview-amount">${rp}</span>
        </div>`;
            } else {
                html = `
        <div class="preview-row">
            <span class="preview-debit-label">↳ Debit &nbsp; : Akun Beban</span>
            <span class="preview-amount">${rp}</span>
        </div>
        <div class="preview-row">
            <span class="preview-kredit-label">↳ Kredit : Kas</span>
            <span class="preview-amount">${rp}</span>
        </div>`;
            }

            rows.innerHTML = html;
            prev.classList.add('show');
        }

        // ── Reset Form ───────────────────────────────────────
        function resetForm() {
            document.getElementById('hiddenJenis').value = '';
            document.getElementById('btnPend').classList.remove('active-pend', 'active-beban');
            document.getElementById('btnBeban').classList.remove('active-pend', 'active-beban');

            const pend = document.getElementById('selectAkunPendapatan');
            const beban = document.getElementById('selectAkunBeban');
            pend.style.display = 'none';
            pend.disabled = true;
            pend.value = '';
            beban.style.display = 'none';
            beban.disabled = true;
            beban.value = '';
            document.getElementById('infoAkun').style.display = 'flex';

            document.getElementById('inputJumlah').value = '';
            document.getElementById('inputJumlahDisplay').value = '';
            document.getElementById('previewJurnal').classList.remove('show');
            document.getElementById('formTransaksi').reset();
            document.getElementById('hiddenJenis').value = '';
        }

        // ── Konfirmasi Hapus dengan SweetAlert ──────────────
        function konfirmasiHapus(event, deskripsi) {
            event.preventDefault();
            const form = event.target;
            Swal.fire({
                title: 'Hapus Transaksi?',
                html: `Transaksi <strong>"${deskripsi}"</strong> dan jurnal terkait akan dihapus permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                borderRadius: '12px'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
            return false;
        }

        // ── Restore state jika ada old input ────────────────
        @if (old('jenis'))
            pilihJenis('{{ old('jenis') }}');
            @if (old('jumlah'))
                document.getElementById('inputJumlah').value = '{{ old('jumlah') }}';
                document.getElementById('inputJumlahDisplay').value =
                    new Intl.NumberFormat('id-ID').format('{{ old('jumlah') }}');
                updatePreview();
            @endif
        @endif
    </script>
@endpush

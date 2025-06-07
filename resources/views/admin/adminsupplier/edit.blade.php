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

        .page-description {
            font-size: 15px;
            color: #6c757d;
            margin: 5px 0 0 0;
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

        .btn-back {
            background: #6c757d;
            border: 1px solid #6c757d;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-back:hover {
            background: #545b62;
            border-color: #545b62;
            color: white;
            transform: translateY(-1px);
        }

        /* Section Styling */
        .section-container {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .section-header {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Info Cards */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 0;
        }

        .info-card {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .info-card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .info-card-header {
            font-size: 16px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-item {
            margin-bottom: 12px;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-size: 13px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            font-weight: 600;
        }

        .info-value {
            font-size: 15px;
            font-weight: 600;
            color: #495057;
            line-height: 1.4;
        }

        .info-value.highlight {
            color: #28a745;
            font-weight: 700;
        }

        /* Photo Section */
        .photo-section {
            text-align: center;
            padding: 20px;
        }

        .photo-preview {
            max-width: 100%;
            max-height: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .photo-preview:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .photo-caption {
            font-size: 14px;
            color: #6c757d;
            margin-top: 15px;
            margin-bottom: 0;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-size: 16px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control, .form-select {
            font-size: 15px;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px 12px;
            padding-right: 40px;
        }

        .form-text {
            font-size: 13px;
            color: #6c757d;
            margin-top: 8px;
            line-height: 1.4;
        }

        /* Status Badge */
        .current-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 25px;
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
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

        /* Kupon Selection */
        .kupon-container {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
        }

        .kupon-description {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 20px;
            padding: 12px;
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 8px;
        }

        .kupon-option {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 18px;
            margin-bottom: 12px;
            cursor: pointer;
            background: #ffffff;
            transition: all 0.3s ease;
            position: relative;
        }

        .kupon-option:hover {
            border-color: #007bff;
            background: #f8f9ff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
        }

        .kupon-option.selected {
            border-color: #007bff;
            background: linear-gradient(135deg, #e7f3ff 0%, #cce7ff 100%);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
        }

        .kupon-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .kupon-option label {
            margin: 0;
            cursor: pointer;
            display: block;
            width: 100%;
            line-height: 1.4;
            font-size: 15px;
        }

        .kupon-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .kupon-details {
            font-size: 13px;
            color: #6c757d;
            line-height: 1.3;
        }

        .kupon-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* Notes Section */
        .previous-note {
            background: #e3f2fd;
            border: 1px solid #90caf9;
            border-radius: 8px;
            padding: 18px;
            margin-bottom: 20px;
        }

        .previous-note h6 {
            font-size: 15px;
            font-weight: 700;
            color: #1565c0;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .previous-note p {
            font-size: 14px;
            color: #1976d2;
            margin: 0;
            line-height: 1.5;
        }

        /* Action Buttons */
        .action-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            margin-top: 30px;
        }

        .btn-save {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            border: 1px solid #6c757d;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-right: 15px;
        }

        .btn-secondary:hover {
            background: #545b62;
            border-color: #545b62;
            color: white;
            transform: translateY(-1px);
        }

        /* Alert Styling */
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            font-size: 14px;
            padding: 15px 20px;
        }

        .alert i {
            margin-right: 8px;
        }

        /* Modal Enhancements */
        .modal-content {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
            padding: 20px 25px;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
        }

        .modal-body {
            padding: 25px;
        }

        .modal-image {
            border-radius: 10px;
            max-height: 500px;
        }

        /* Loading States */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-content {
            text-align: center;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f4f6;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            font-size: 16px;
            color: #495057;
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .info-grid {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 15px;
            }
        }

        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .page-header, .action-bar, .section-container {
                padding: 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .info-card {
                padding: 15px;
            }

            .btn-secondary, .btn-save {
                width: 100%;
                margin-bottom: 10px;
                margin-right: 0;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .page-title {
                font-size: 20px;
            }

            .section-title {
                font-size: 16px;
            }

            .action-section {
                padding: 20px;
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Kelola Request Pemasok</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.supplier.index') }}">
                            <div class="text-tiny">Pemasok</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Edit</div>
                    </li>
                </ul>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="page-title">Kelola Request Pemasok</h4>
                        <p class="page-description">Review dan kelola permintaan pasokan eceng gondok dari {{ $request->nama }}</p>
                    </div>
                    <a href="{{ route('admin.supplier.index') }}" class="btn-back">
                        <i class="icon-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>

            <form action="{{ route('admin.supplier.request.update', $request->id) }}" method="POST" id="supplierForm">
                @csrf @method('PUT')

                <!-- Informasi Lengkap Pemasok -->
                <div class="section-container">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="icon-user"></i> Informasi Lengkap Pemasok
                        </h5>
                    </div>

                    <div class="info-grid">
                        <!-- Data Pribadi -->
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class="icon-user"></i> Data Pribadi
                            </div>
                            <div class="info-item">
                                <div class="info-label">Nama Lengkap</div>
                                <div class="info-value">{{ $request->nama }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Alamat Email</div>
                                <div class="info-value">{{ $request->email }}</div>
                            </div>
                        </div>

                        <!-- Kontak & Waktu -->
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class="icon-phone"></i> Kontak & Waktu
                            </div>
                            <div class="info-item">
                                <div class="info-label">No. HP/WhatsApp</div>
                                <div class="info-value">{{ $request->no_hp ?? $request->no_wa ?? '-' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Tanggal Pengajuan</div>
                                <div class="info-value">{{ $request->created_at->format('d F Y, H:i') }} WIB</div>
                            </div>
                        </div>

                        <!-- Informasi Lokasi -->
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class="icon-location-pin"></i> Informasi Lokasi
                            </div>
                            <div class="info-item">
                                <div class="info-label">Kecamatan</div>
                                <div class="info-value">{{ $request->kecamatan ?? '-' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Desa</div>
                                <div class="info-value">{{ $request->desa ?? '-' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Detail Lokasi</div>
                                <div class="info-value">{{ $request->detail_lokasi ?? '-' }}</div>
                            </div>
                            @if($request->lokasi)
                            <div class="info-item">
                                <div class="info-label">Lokasi Lama</div>
                                <div class="info-value">{{ $request->lokasi }}</div>
                            </div>
                            @endif
                        </div>

                        <!-- Detail Pasokan -->
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class="icon-layers"></i> Detail Pasokan
                            </div>
                            <div class="info-item">
                                <div class="info-label">Estimasi Jumlah</div>
                                <div class="info-value">{{ $request->estimasi_kg }} kg eceng gondok</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Jenis Insentif</div>
                                <div class="info-value">
                                    {{ $request->insentif == 'diskon' ? 'Diskon Produk' : 'Uang Tunai' }}
                                </div>
                            </div>
                            @if ($request->insentif == 'uang_tunai')
                            <div class="info-item">
                                <div class="info-label">Perkiraan Total Insentif</div>
                                <div class="info-value highlight">
                                    Rp {{ number_format($request->estimasi_kg * 60000, 0, ',', '.') }}
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Catatan Pemasok -->
                        @if($request->catatan)
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class="icon-bubble"></i> Catatan dari Pemasok
                            </div>
                            <div class="info-item">
                                <div class="info-value">{{ $request->catatan }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Foto Bukti Eceng Gondok -->
                @if($request->foto)
                <div class="section-container">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="icon-camera"></i> Foto Bukti Eceng Gondok
                        </h5>
                    </div>

                    <div class="photo-section">
                        <img src="{{ asset($request->foto) }}"
                             alt="Foto Eceng Gondok dari {{ $request->nama }}"
                             class="photo-preview"
                             data-bs-toggle="modal"
                             data-bs-target="#photoModal">
                        <p class="photo-caption">
                            <i class="icon-info"></i>
                            Klik gambar untuk melihat dalam ukuran penuh
                        </p>
                    </div>
                </div>
                @endif

                <!-- Status dan Pengaturan -->
                <div class="section-container">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="icon-settings"></i> Pengaturan Status dan Approval
                        </h5>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <!-- Status Saat Ini -->
                            <div class="form-group">
                                <label class="form-label">Status Saat Ini:</label>
                                @switch($request->status)
                                    @case('pending')
                                        <div class="current-status status-pending">
                                            <i class="icon-clock"></i> Menunggu Persetujuan
                                        </div>
                                        @break
                                    @case('disetujui')
                                        <div class="current-status status-disetujui">
                                            <i class="icon-check"></i> Telah Disetujui
                                        </div>
                                        @break
                                    @case('ditolak')
                                        <div class="current-status status-ditolak">
                                            <i class="icon-close"></i> Ditolak
                                        </div>
                                        @break
                                @endswitch
                            </div>

                            <!-- Ubah Status -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="icon-refresh"></i> Ubah Status Permintaan
                                </label>
                                <select name="status" class="form-select" required id="statusSelect">
                                    <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>
                                        Pending - Menunggu Review
                                    </option>
                                    <option value="disetujui" {{ $request->status == 'disetujui' ? 'selected' : '' }}>
                                        Disetujui - Terima Permintaan
                                    </option>
                                    <option value="ditolak" {{ $request->status == 'ditolak' ? 'selected' : '' }}>
                                        Ditolak - Tolak Permintaan
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Perkiraan Total Insentif untuk Uang Tunai -->
                            @if ($request->insentif == 'uang_tunai')
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="icon-calculator"></i> Perkiraan Total Insentif
                                </label>
                                <input type="text" class="form-control bg-success text-white fw-bold"
                                       value="Rp {{ number_format($request->estimasi_kg * 60000, 0, ',', '.') }}"
                                       readonly style="font-size: 16px;">
                                <div class="form-text">
                                    <i class="icon-info"></i> Dihitung: {{ $request->estimasi_kg }} kg × Rp 60.000/kg
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Pengaturan Kupon untuk Insentif Diskon -->
                    @if ($request->insentif == 'diskon')
                    <div class="form-group">
                        <label class="form-label">
                            <i class="icon-credit-card"></i> Pilih Kupon Diskon untuk Pemasok
                        </label>

                        <div class="kupon-description">
                            <i class="icon-info"></i>
                            Pilih kupon yang akan diberikan kepada pemasok sebagai insentif. Kupon hanya akan aktif jika status disetujui.
                        </div>

                        <div class="kupon-container">
                            <!-- Opsi Tidak Ada Kupon -->
                            <div class="kupon-option {{ !$request->kupon_id ? 'selected' : '' }}" onclick="selectKupon('')">
                                <input type="radio" name="kupon_id" value="" id="no-kupon"
                                       {{ !$request->kupon_id ? 'checked' : '' }}>
                                <label for="no-kupon">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="kupon-title text-danger">
                                                <i class="icon-close"></i> Tidak Memberikan Kupon
                                            </div>
                                            <div class="kupon-details">Pemasok tidak akan menerima kupon diskon</div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Daftar Kupon -->
                            @forelse ($kupons as $kupon)
                            <div class="kupon-option {{ $request->kupon_id == $kupon->id ? 'selected' : '' }}"
                                 onclick="selectKupon('{{ $kupon->id }}')">
                                <input type="radio" name="kupon_id" value="{{ $kupon->id }}" id="kupon-{{ $kupon->id }}"
                                       {{ $request->kupon_id == $kupon->id ? 'checked' : '' }}>
                                <label for="kupon-{{ $kupon->id }}">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="kupon-title text-primary">
                                                <i class="icon-credit-card"></i> {{ $kupon->code }}
                                            </div>
                                            <div class="kupon-details">
                                                <i class="icon-wallet"></i> Diskon: <strong>Rp {{ number_format($kupon->discount_amount, 0, ',', '.') }}</strong> |
                                                <i class="icon-bag"></i> Min. Order: <strong>Rp {{ number_format($kupon->minimum_order, 0, ',', '.') }}</strong>
                                                <br>
                                                <i class="icon-calendar"></i> Berlaku sampai: <strong>{{ $kupon->expiry_date->format('d M Y') }}</strong>
                                            </div>
                                        </div>
                                        <div class="ms-2">
                                            @if($kupon->expiry_date < now())
                                                <span class="kupon-badge bg-danger text-white">Expired</span>
                                            @elseif(!$kupon->is_active)
                                                <span class="kupon-badge bg-secondary text-white">Tidak Aktif</span>
                                            @else
                                                <span class="kupon-badge bg-success text-white">Aktif</span>
                                            @endif
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @empty
                            <div class="alert alert-warning">
                                <i class="icon-exclamation"></i>
                                <strong>Tidak ada kupon tersedia.</strong> Silakan buat kupon terlebih dahulu di menu Kupon.
                            </div>
                            @endforelse
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Catatan Admin -->
                <div class="section-container">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="icon-note"></i> Catatan dan Komunikasi
                        </h5>
                    </div>

                    @if($request->catatan_admin)
                    <div class="previous-note">
                        <h6><i class="icon-info"></i> Catatan Admin Sebelumnya:</h6>
                        <p>{{ $request->catatan_admin }}</p>
                    </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">
                            <i class="icon-pencil"></i> Catatan Admin untuk Pemasok
                        </label>
                        <textarea name="catatan_admin" class="form-control" rows="6"
                                  placeholder="Berikan catatan, instruksi, atau alasan keputusan kepada pemasok. Catatan ini akan dikirim melalui email notifikasi.">{{ $request->catatan_admin }}</textarea>
                        <div class="form-text">
                            <i class="icon-envelope"></i> <strong>Penting:</strong> Catatan ini akan dikirim kepada pemasok melalui email otomatis.
                            <br><i class="icon-bulb"></i> <strong>Tips:</strong> Berikan informasi yang jelas dan berguna bagi pemasok.
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-section">
                    <a href="{{ route('admin.supplier.index') }}" class="btn-secondary">
                        <i class="icon-arrow-left"></i> Kembali ke Daftar
                    </a>
                    <button type="submit" class="btn-save" id="submitBtn">
                        <i class="icon-check"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Photo Preview -->
    @if($request->foto)
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModalLabel">
                        <i class="icon-camera"></i> Foto Bukti Eceng Gondok - {{ $request->nama }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset($request->foto) }}" class="modal-image img-fluid" alt="Foto Eceng Gondok">
                    <div class="mt-3">
                        <p class="text-muted">
                            <strong>Estimasi:</strong> {{ $request->estimasi_kg }} kg |
                            <strong>Upload:</strong> {{ $request->created_at->format('d M Y, H:i') }} WIB
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner"></div>
            <div class="loading-text">Menyimpan perubahan...</div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Fungsi untuk select kupon
        function selectKupon(kuponId) {
            // Update radio button
            const radioButton = document.getElementById(kuponId ? `kupon-${kuponId}` : 'no-kupon');
            if (radioButton) {
                radioButton.checked = true;
            }

            // Update styling
            document.querySelectorAll('.kupon-option').forEach(option => {
                option.classList.remove('selected');
            });
            event.currentTarget.classList.add('selected');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('supplierForm');
            const statusSelect = document.getElementById('statusSelect');
            const originalStatus = statusSelect.value;

            // Form submission dengan SweetAlert2
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const status = statusSelect.value;
                const catatan = document.querySelector('textarea[name="catatan_admin"]').value.trim();

                // Validasi wajib catatan untuk penolakan
                if (status === 'ditolak' && !catatan) {
                    Swal.fire({
                        title: 'Catatan Diperlukan!',
                        text: 'Catatan admin wajib diisi ketika menolak permintaan. Berikan alasan yang jelas kepada pemasok.',
                        icon: 'warning',
                        iconColor: '#f39c12',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#f39c12'
                    }).then(() => {
                        document.querySelector('textarea[name="catatan_admin"]').focus();
                    });
                    return false;
                }

                // Konfirmasi berdasarkan status
                let confirmConfig = {
                    title: 'Konfirmasi Perubahan',
                    text: '',
                    icon: 'question',
                    showCancelButton: true,
                    reverseButtons: true,
                    focusCancel: true,
                    cancelButtonText: 'Batal',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Lanjutkan',
                    confirmButtonColor: '#28a745'
                };

                switch(status) {
                    case 'disetujui':
                        confirmConfig.title = 'Setujui Permintaan?';
                        confirmConfig.text = 'Menyetujui permintaan ini akan menambahkan stok bahan baku, mengirim email konfirmasi kepada pemasok, dan mengaktifkan kupon diskon (jika dipilih).';
                        confirmConfig.icon = 'success';
                        confirmConfig.iconColor = '#28a745';
                        confirmConfig.confirmButtonColor = '#28a745';
                        break;
                    case 'ditolak':
                        confirmConfig.title = 'Tolak Permintaan?';
                        confirmConfig.text = 'Menolak permintaan ini akan membatalkan proses pasokan dan mengirim email penolakan kepada pemasok. Pastikan catatan Anda sudah jelas.';
                        confirmConfig.icon = 'warning';
                        confirmConfig.iconColor = '#f39c12';
                        confirmConfig.confirmButtonColor = '#e74c3c';
                        confirmConfig.confirmButtonText = 'Ya, Tolak';
                        break;
                    case 'pending':
                        confirmConfig.title = 'Ubah ke Pending?';
                        confirmConfig.text = 'Mengubah status ke pending akan mengembalikan permintaan ke tahap review dan mengirim notifikasi update kepada pemasok.';
                        confirmConfig.icon = 'info';
                        confirmConfig.iconColor = '#17a2b8';
                        confirmConfig.confirmButtonColor = '#17a2b8';
                        break;
                }

                Swal.fire(confirmConfig).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        document.getElementById('loadingOverlay').style.display = 'flex';

                        const submitBtn = document.getElementById('submitBtn');
                        submitBtn.innerHTML = '<i class="icon-hourglass"></i> Menyimpan...';
                        submitBtn.disabled = true;

                        // Submit form
                        form.submit();
                    }
                });
            });

            // Auto-save draft catatan
            const catatanTextarea = document.querySelector('textarea[name="catatan_admin"]');
            const requestId = {{ $request->id }};
            const draftKey = `catatan_draft_${requestId}`;

            // Load saved draft
            const savedDraft = localStorage.getItem(draftKey);
            if (savedDraft && !catatanTextarea.value.trim()) {
                catatanTextarea.value = savedDraft;

                // Show notification
                Swal.fire({
                    title: 'Draft Dimuat',
                    text: 'Draft catatan yang tersimpan telah dimuat otomatis.',
                    icon: 'info',
                    iconColor: '#17a2b8',
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }

            // Save draft on input
            catatanTextarea.addEventListener('input', function() {
                localStorage.setItem(draftKey, this.value);
            });

            // Clear draft on form submit
            form.addEventListener('submit', function() {
                localStorage.removeItem(draftKey);
            });

            // Show success/error messages
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

            @if ($errors->any())
                Swal.fire({
                    title: 'Terjadi Kesalahan!',
                    html: '<ul style="text-align: left; margin: 0; padding-left: 20px;">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                    icon: 'error',
                    iconColor: '#e74c3c',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#e74c3c'
                });
            @endif

            // Hide loading on page load
            window.addEventListener('load', function() {
                document.getElementById('loadingOverlay').style.display = 'none';
            });
        });
    </script>
@endsection

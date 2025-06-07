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

        .section-description {
            font-size: 14px;
            color: #6c757d;
            margin: 5px 0 0 0;
            line-height: 1.4;
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

        .form-label.required::after {
            content: "*";
            color: #dc3545;
            margin-left: 4px;
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

        /* Radio Button Styling */
        .radio-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 10px;
        }

        .radio-option {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 15px;
            cursor: pointer;
            background: #ffffff;
            transition: all 0.3s ease;
            position: relative;
        }

        .radio-option:hover {
            border-color: #007bff;
            background: #f8f9ff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
        }

        .radio-option.selected {
            border-color: #007bff;
            background: linear-gradient(135deg, #e7f3ff 0%, #cce7ff 100%);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
        }

        .radio-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .radio-option label {
            margin: 0;
            cursor: pointer;
            display: block;
            width: 100%;
            font-size: 15px;
            font-weight: 600;
            color: #495057;
            line-height: 1.4;
        }

        .radio-description {
            font-size: 13px;
            color: #6c757d;
            margin-top: 4px;
            font-weight: 400;
        }

        /* File Upload Styling */
        .file-upload-container {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .file-upload-container:hover {
            border-color: #007bff;
            background: #f0f7ff;
        }

        .file-upload-container.dragover {
            border-color: #007bff;
            background: #e7f3ff;
        }

        .file-upload-icon {
            font-size: 40px;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .file-upload-text {
            font-size: 16px;
            color: #495057;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .file-upload-hint {
            font-size: 13px;
            color: #6c757d;
        }

        .file-upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-preview {
            margin-top: 15px;
            padding: 15px;
            background: #e8f5e8;
            border: 1px solid #c3e6c3;
            border-radius: 8px;
            display: none;
        }

        .file-preview-name {
            font-size: 14px;
            color: #155724;
            font-weight: 600;
        }

        /* Location Dependent Select */
        .location-container {
            position: relative;
        }

        .location-loading {
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-50%);
            display: none;
        }

        .loading-spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #f3f4f6;
            border-top: 2px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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

        /* Status Preview */
        .status-preview {
            display: none;
            margin-top: 15px;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid;
        }

        .status-preview.pending {
            background: #fff3cd;
            border-color: #ffeaa7;
            color: #856404;
        }

        .status-preview.disetujui {
            background: #d1f2eb;
            border-color: #7dd3fc;
            color: #0c5460;
        }

        .status-preview.ditolak {
            background: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        /* Incentive Calculator */
        .incentive-calculator {
            background: #e8f5e8;
            border: 1px solid #c3e6c3;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
            display: none;
        }

        .calculator-title {
            font-size: 14px;
            font-weight: 600;
            color: #155724;
            margin-bottom: 8px;
        }

        .calculator-value {
            font-size: 18px;
            font-weight: 700;
            color: #28a745;
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

        /* Loading Overlay */
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

        .loading-spinner-large {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f4f6;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        .loading-text {
            font-size: 16px;
            color: #495057;
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .page-header, .action-bar, .section-container {
                padding: 20px;
            }

            .radio-group {
                gap: 10px;
            }

            .radio-option {
                padding: 12px;
            }

            .btn-secondary, .btn-save {
                width: 100%;
                margin-bottom: 10px;
                margin-right: 0;
                justify-content: center;
            }

            .file-upload-container {
                padding: 20px;
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
                <h3>Manajemen Permintaan Pemasok Manual</h3>
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
                        <div class="text-tiny">Create</div>
                    </li>
                </ul>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="page-title">Tambah Permintaan Pemasok Manual</h4>
                        <p class="page-description">Buat permintaan pasokan eceng gondok secara manual untuk pemasok yang tidak mendaftar melalui sistem</p>
                    </div>
                    <a href="{{ route('admin.supplier.index') }}" class="btn-back">
                        <i class="icon-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>

            <form action="{{ route('admin.supplier.request.store') }}" method="POST" id="supplierForm" enctype="multipart/form-data">
                @csrf

                <!-- Data Pribadi Pemasok -->
                <div class="section-container">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="icon-user"></i> Data Pribadi Pemasok
                        </h5>
                        <p class="section-description">Masukkan informasi pribadi pemasok yang akan dicatat dalam sistem</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">
                                    <i class="icon-user"></i> Nama Lengkap
                                </label>
                                <input type="text" name="nama" class="form-control"
                                       placeholder="Masukkan nama lengkap pemasok"
                                       value="{{ old('nama') }}" required>
                                <div class="form-text">Nama lengkap sesuai identitas pemasok</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">
                                    <i class="icon-envelope"></i> Alamat Email
                                </label>
                                <input type="email" name="email" class="form-control"
                                       placeholder="contoh@email.com"
                                       value="{{ old('email') }}" required>
                                <div class="form-text">Email untuk komunikasi dan notifikasi</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">
                                    <i class="icon-phone"></i> Nomor HP / WhatsApp
                                </label>
                                <input type="text" name="kontak" class="form-control"
                                       placeholder="08xxxxxxxxxx"
                                       value="{{ old('kontak') }}" required>
                                <div class="form-text">Nomor yang dapat dihubungi untuk koordinasi penjemputan</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="icon-flag"></i> Status Permintaan
                                </label>
                                <select name="status" class="form-select" id="statusSelect">
                                    <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending - Menunggu Review</option>
                                    <option value="disetujui" {{ old('status') == 'disetujui' ? 'selected' : '' }}>Disetujui - Langsung Approve</option>
                                    <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak - Tidak Diterima</option>
                                </select>
                                <div class="status-preview" id="statusPreview"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Pasokan -->
                <div class="section-container">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="icon-layers"></i> Data Pasokan Eceng Gondok
                        </h5>
                        <p class="section-description">Tentukan jumlah dan jenis insentif untuk pasokan eceng gondok</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">
                                    <i class="icon-graph"></i> Estimasi Jumlah Eceng Gondok (kg)
                                </label>
                                <input type="number" name="estimasi_kg" class="form-control"
                                       placeholder="0" min="1" step="0.1"
                                       value="{{ old('estimasi_kg') }}"
                                       id="estimasiKg" required>
                                <div class="form-text">Perkiraan berat eceng gondok yang akan dipasok</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">
                                    <i class="icon-credit-card"></i> Jenis Insentif
                                </label>
                                <div class="radio-group">
                                    <div class="radio-option {{ old('insentif') == 'diskon' ? 'selected' : '' }}" onclick="selectIncentive('diskon')">
                                        <input type="radio" name="insentif" value="diskon" id="insentif-diskon"
                                               {{ old('insentif', 'diskon') == 'diskon' ? 'checked' : '' }} required>
                                        <label for="insentif-diskon">
                                            <i class="icon-credit-card"></i> Diskon Produk
                                            <div class="radio-description">Pemasok mendapat kupon diskon untuk pembelian produk</div>
                                        </label>
                                    </div>
                                    <div class="radio-option {{ old('insentif') == 'uang_tunai' ? 'selected' : '' }}" onclick="selectIncentive('uang_tunai')">
                                        <input type="radio" name="insentif" value="uang_tunai" id="insentif-tunai"
                                               {{ old('insentif') == 'uang_tunai' ? 'checked' : '' }}>
                                        <label for="insentif-tunai">
                                            <i class="icon-wallet"></i> Uang Tunai
                                            <div class="radio-description">Pemasok mendapat pembayaran tunai Rp 60.000 per kg</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="incentive-calculator" id="incentiveCalculator">
                                    <div class="calculator-title">
                                        <i class="icon-calculator"></i> Perkiraan Total Insentif:
                                    </div>
                                    <div class="calculator-value" id="calculatorValue">Rp 0</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Foto Bukti -->
                <div class="section-container">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="icon-camera"></i> Foto Bukti Eceng Gondok
                        </h5>
                        <p class="section-description">Upload foto eceng gondok sebagai bukti ketersediaan pasokan</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="icon-picture"></i> Upload Foto Eceng Gondok
                        </label>
                        <div class="file-upload-container" id="fileUploadContainer">
                            <div class="file-upload-icon">
                                <i class="icon-camera"></i>
                            </div>
                            <div class="file-upload-text">Klik atau seret file gambar ke sini</div>
                            <div class="file-upload-hint">Format: JPG, PNG, GIF (Maksimal 2MB)</div>
                            <input type="file" name="foto" class="file-upload-input"
                                   accept="image/*" id="fileInput" required>
                        </div>
                        <div class="file-preview" id="filePreview">
                            <div class="file-preview-name" id="fileName"></div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Lokasi -->
                <div class="section-container">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="icon-location-pin"></i> Informasi Lokasi Pasokan
                        </h5>
                        <p class="section-description">Tentukan lokasi tempat eceng gondok akan dijemput</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">
                                    <i class="icon-map"></i> Kecamatan
                                </label>
                                <div class="location-container">
                                    <select id="kecamatan" name="kecamatan" class="form-select" required>
                                        <option value="">-- Pilih Kecamatan --</option>
                                        <option value="Harian" {{ old('kecamatan') == 'Harian' ? 'selected' : '' }}>Harian</option>
                                        <option value="Nainggolan" {{ old('kecamatan') == 'Nainggolan' ? 'selected' : '' }}>Nainggolan</option>
                                        <option value="Onan Runggu" {{ old('kecamatan') == 'Onan Runggu' ? 'selected' : '' }}>Onan Runggu</option>
                                        <option value="Palipi" {{ old('kecamatan') == 'Palipi' ? 'selected' : '' }}>Palipi</option>
                                        <option value="Pangururan" {{ old('kecamatan') == 'Pangururan' ? 'selected' : '' }}>Pangururan</option>
                                        <option value="Ronggur Nihuta" {{ old('kecamatan') == 'Ronggur Nihuta' ? 'selected' : '' }}>Ronggur Nihuta</option>
                                        <option value="Sianjur Mulamula" {{ old('kecamatan') == 'Sianjur Mulamula' ? 'selected' : '' }}>Sianjur Mulamula</option>
                                        <option value="Simanindo" {{ old('kecamatan') == 'Simanindo' ? 'selected' : '' }}>Simanindo</option>
                                        <option value="Sitio-tio" {{ old('kecamatan') == 'Sitio-tio' ? 'selected' : '' }}>Sitio-tio</option>
                                    </select>
                                    <div class="location-loading" id="desaLoading">
                                        <div class="loading-spinner"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">
                                    <i class="icon-location-pin"></i> Desa
                                </label>
                                <select id="desa" name="desa" class="form-select" required disabled>
                                    <option value="">-- Pilih Desa --</option>
                                </select>
                                <div class="form-text">Pilih kecamatan terlebih dahulu</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="icon-pin"></i> Detail Lokasi
                        </label>
                        <input type="text" name="detail_lokasi" class="form-control"
                               placeholder="Contoh: Dekat Pasar, Samping Sekolah, RT/RW"
                               value="{{ old('detail_lokasi') }}" required>
                        <div class="form-text">Detail alamat untuk memudahkan tim penjemputan menemukan lokasi</div>
                    </div>
                </div>

                <!-- Catatan Tambahan -->
                <div class="section-container">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="icon-note"></i> Catatan dan Informasi Tambahan
                        </h5>
                        <p class="section-description">Tambahkan informasi atau catatan yang diperlukan</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="icon-bubble"></i> Catatan dari Pemasok
                                </label>
                                <textarea name="catatan" rows="4" class="form-control"
                                          placeholder="Catatan atau permintaan khusus dari pemasok...">{{ old('catatan') }}</textarea>
                                <div class="form-text">Informasi tambahan dari pemasok (opsional)</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="icon-pencil"></i> Catatan Admin
                                </label>
                                <textarea name="catatan_admin" class="form-control" rows="4"
                                          placeholder="Catatan internal untuk admin atau tim penjemputan...">{{ old('catatan_admin') }}</textarea>
                                <div class="form-text">Catatan internal yang akan dikirim ke pemasok via email (opsional)</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-section">
                    <a href="{{ route('admin.supplier.index') }}" class="btn-secondary">
                        <i class="icon-arrow-left"></i> Batal & Kembali
                    </a>
                    <button type="submit" class="btn-save" id="submitBtn">
                        <i class="icon-check"></i> Simpan Permintaan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner-large"></div>
            <div class="loading-text">Menyimpan permintaan...</div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Desa mapping (simplified version)
        const desaMapping = {
            'Harian': ['Harian I', 'Harian II', 'Harian III'],
            'Nainggolan': ['Nainggolan', 'Siogung-ogung', 'Paranginan'],
            'Onan Runggu': ['Onan Runggu', 'Runggu', 'Simanullang'],
            'Palipi': ['Palipi', 'Simanindo', 'Tomok'],
            'Pangururan': ['Pangururan', 'Siogung', 'Parapat'],
            'Ronggur Nihuta': ['Ronggur Nihuta', 'Ambarita', 'Tuk Tuk'],
            'Sianjur Mulamula': ['Sianjur Mulamula', 'Muara', 'Lumban Suhi'],
            'Simanindo': ['Simanindo', 'Tomok', 'Ambarita'],
            'Sitio-tio': ['Sitio-tio', 'Lumban Julu', 'Situngkir']
        };

        // Initialize form functions
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('supplierForm');
            const statusSelect = document.getElementById('statusSelect');
            const estimasiKgInput = document.getElementById('estimasiKg');
            const kecamatanSelect = document.getElementById('kecamatan');
            const desaSelect = document.getElementById('desa');
            const fileInput = document.getElementById('fileInput');
            const fileUploadContainer = document.getElementById('fileUploadContainer');

            // Status preview functionality
            function updateStatusPreview() {
                const status = statusSelect.value;
                const preview = document.getElementById('statusPreview');

                preview.className = `status-preview ${status}`;
                preview.style.display = 'block';

                let statusText = '';
                switch(status) {
                    case 'pending':
                        statusText = '<i class="icon-clock"></i> Status akan diset sebagai PENDING - membutuhkan review manual';
                        break;
                    case 'disetujui':
                        statusText = '<i class="icon-check"></i> Status akan diset sebagai DISETUJUI - langsung aktif';
                        break;
                    case 'ditolak':
                        statusText = '<i class="icon-close"></i> Status akan diset sebagai DITOLAK - tidak akan diproses';
                        break;
                }
                preview.innerHTML = statusText;
            }

            statusSelect.addEventListener('change', updateStatusPreview);
            updateStatusPreview(); // Initial call

            // Incentive selection functionality
            window.selectIncentive = function(type) {
                // Update radio button
                const radioButton = document.getElementById(`insentif-${type}`);
                if (radioButton) {
                    radioButton.checked = true;
                }

                // Update styling
                document.querySelectorAll('.radio-option').forEach(option => {
                    option.classList.remove('selected');
                });
                event.currentTarget.classList.add('selected');

                // Update calculator
                updateIncentiveCalculator();
            }

            // Incentive calculator
            function updateIncentiveCalculator() {
                const isUangTunai = document.getElementById('insentif-tunai').checked;
                const calculator = document.getElementById('incentiveCalculator');
                const kg = parseFloat(estimasiKgInput.value) || 0;

                if (isUangTunai && kg > 0) {
                    const total = kg * 60000;
                    document.getElementById('calculatorValue').textContent =
                        'Rp ' + total.toLocaleString('id-ID');
                    calculator.style.display = 'block';
                } else {
                    calculator.style.display = 'none';
                }
            }

            estimasiKgInput.addEventListener('input', updateIncentiveCalculator);
            document.querySelectorAll('input[name="insentif"]').forEach(radio => {
                radio.addEventListener('change', updateIncentiveCalculator);
            });

            // Location dependency
            kecamatanSelect.addEventListener('change', function() {
                const kecamatan = this.value;
                const desaLoading = document.getElementById('desaLoading');

                desaSelect.innerHTML = '<option value="">-- Pilih Desa --</option>';
                desaSelect.disabled = true;

                if (kecamatan && desaMapping[kecamatan]) {
                    desaLoading.style.display = 'block';

                    // Simulate loading delay
                    setTimeout(() => {
                        desaMapping[kecamatan].forEach(desa => {
                            const option = new Option(desa, desa);
                            desaSelect.add(option);
                        });

                        desaSelect.disabled = false;
                        desaLoading.style.display = 'none';
                    }, 500);
                }
            });

            // File upload functionality
            function handleFileSelect(file) {
                if (file && file.type.startsWith('image/')) {
                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire({
                            title: 'File Terlalu Besar!',
                            text: 'Ukuran file maksimal 2MB. Silakan pilih file yang lebih kecil.',
                            icon: 'error',
                            iconColor: '#e74c3c',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#e74c3c'
                        });
                        return;
                    }

                    document.getElementById('fileName').textContent = file.name;
                    document.getElementById('filePreview').style.display = 'block';
                    fileUploadContainer.style.borderColor = '#28a745';
                    fileUploadContainer.style.background = '#f0fff4';
                } else {
                    Swal.fire({
                        title: 'Format File Tidak Valid!',
                        text: 'Silakan pilih file gambar dengan format JPG, PNG, atau GIF.',
                        icon: 'error',
                        iconColor: '#e74c3c',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#e74c3c'
                    });
                }
            }

            fileInput.addEventListener('change', function() {
                if (this.files[0]) {
                    handleFileSelect(this.files[0]);
                }
            });

            // Drag and drop functionality
            fileUploadContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            fileUploadContainer.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            fileUploadContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    handleFileSelect(files[0]);
                }
            });

            // Form submission
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                // Basic validation
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.focus();
                        return;
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        title: 'Form Belum Lengkap!',
                        text: 'Silakan lengkapi semua field yang wajib diisi.',
                        icon: 'warning',
                        iconColor: '#f39c12',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#f39c12'
                    });
                    return;
                }

                // Confirm submission
                Swal.fire({
                    title: 'Konfirmasi Penyimpanan',
                    text: 'Apakah Anda yakin ingin menyimpan permintaan pemasok ini? Data akan disimpan dan email notifikasi akan dikirim kepada pemasok.',
                    icon: 'question',
                    showCancelButton: true,
                    reverseButtons: true,
                    focusCancel: true,
                    cancelButtonText: 'Batal',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Simpan!',
                    confirmButtonColor: '#28a745'
                }).then((result) => {
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

            // Success/Error messages
            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    iconColor: '#28a745',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#28a745'
                }).then(() => {
                    window.location.href = '{{ route('admin.supplier.index') }}';
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

            // Initialize on page load
            updateIncentiveCalculator();

            // Restore old values for radio buttons
            @if(old('insentif'))
                const oldInsentif = '{{ old('insentif') }}';
                document.querySelector(`input[value="${oldInsentif}"]`).closest('.radio-option').classList.add('selected');
            @else
                document.querySelector('input[value="diskon"]').closest('.radio-option').classList.add('selected');
            @endif

            // Hide loading on page load
            window.addEventListener('load', function() {
                document.getElementById('loadingOverlay').style.display = 'none';
            });
        });
    </script>
@endsection

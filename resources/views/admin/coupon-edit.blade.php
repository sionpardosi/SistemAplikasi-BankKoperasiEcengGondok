@extends('layouts.admin')

@section('content')
    <style>
        /* Base Styling */
        .main-content-inner {
            padding: 1.5rem;
        }

        /* Form Container */
        .form-container {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        .form-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 25px 30px;
            margin: -30px -30px 30px -30px;
            border-radius: 15px 15px 0 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .form-title {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin: 5px 0 0 0;
        }

        .form-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        /* Form Sections */
        .form-section {
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 1px solid #f1f3f4;
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-icon {
            width: 35px;
            height: 35px;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #007bff;
            font-size: 16px;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-size: 15px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .required {
            color: #dc3545;
            font-weight: 700;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 15px 18px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #ffffff;
            width: 100%;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
            background: #ffffff;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
        }

        .form-text {
            font-size: 13px;
            color: #6c757d;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .input-group {
            position: relative;
        }

        .input-group-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 16px;
            z-index: 3;
        }

        .input-group .form-control {
            padding-left: 45px;
        }

        /* Alert Styling */
        .alert {
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border: none;
            font-size: 14px;
            font-weight: 600;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        /* Preview Section */
        .coupon-preview {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px dashed #007bff;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            margin-bottom: 25px;
        }

        .preview-coupon {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 20px 25px;
            border-radius: 12px;
            display: inline-block;
            font-family: 'Courier New', monospace;
            font-weight: 700;
            font-size: 24px;
            letter-spacing: 2px;
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
            position: relative;
            overflow: hidden;
        }

        .preview-coupon::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }
        }

        .preview-details {
            margin-top: 15px;
            color: #6c757d;
            font-size: 14px;
        }

        /* Status Info */
        .status-info {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .status-item {
            text-align: center;
        }

        .status-value {
            font-size: 20px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 5px;
        }

        .status-label {
            font-size: 13px;
            color: #6c757d;
            font-weight: 600;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-success {
            background: #d1f2eb;
            color: #0c5460;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        /* Action Buttons */
        .form-actions {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            align-items: center;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #545b62;
            color: white;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
            color: white;
            transform: translateY(-1px);
        }

        /* Advanced Features */
        .advanced-options {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .advanced-toggle {
            background: none;
            border: none;
            color: #007bff;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0;
            margin-bottom: 15px;
        }

        .advanced-content {
            display: none;
        }

        .advanced-content.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
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
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
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

            .form-container {
                padding: 20px;
            }

            .form-header {
                padding: 20px;
                margin: -20px -20px 25px -20px;
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .form-actions {
                flex-direction: column;
                gap: 10px;
            }

            .form-actions .btn {
                width: 100%;
                justify-content: center;
            }

            .status-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .preview-coupon {
                font-size: 18px;
                padding: 15px 20px;
            }
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .bounce-in {
            animation: bounceIn 0.6s ease;
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }

            50% {
                opacity: 1;
                transform: scale(1.05);
            }

            70% {
                transform: scale(0.9);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Kupon Diskon Produk</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.coupons') }}">
                            <div class="text-tiny">Kupon Diskon</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Edit Kupon</div>
                    </li>
                </ul>
            </div>

            <!-- Main Form Container -->
            <div class="form-container fade-in">
                <!-- Form Header -->
                <div class="form-header">
                    <div>
                        <h1 class="form-title">
                            <div class="form-icon">
                                <i class="icon-credit-card"></i>
                            </div>
                            Edit Kupon Diskon
                        </h1>
                        <p class="form-subtitle">Perbarui informasi kupon diskon untuk pelanggan</p>
                    </div>
                    <div class="status-badge {{ $coupon->isValid() ? 'badge-success' : 'badge-danger' }}">
                        {{ $coupon->isValid() ? 'Aktif' : 'Tidak Aktif' }}
                    </div>
                </div>

                <!-- Coupon Preview -->
                <div class="coupon-preview bounce-in">
                    <div class="preview-coupon" id="couponPreview">
                        {{ $coupon->code }}
                    </div>
                    <div class="preview-details">
                        <strong>Diskon:</strong> <span
                            id="previewDiscount">{{ formatRupiah($coupon->discount_amount) }}</span> |
                        <strong>Min. Pembelian:</strong> <span
                            id="previewMinimum">{{ formatRupiah($coupon->minimum_order) }}</span>
                    </div>
                </div>

                <!-- Status Information -->
                <div class="status-info">
                    <div class="status-grid">
                        <div class="status-item">
                            <div class="status-value">{{ $coupon->created_at->format('d M Y') }}</div>
                            <div class="status-label">Dibuat</div>
                        </div>
                        <div class="status-item">
                            <div class="status-value">{{ $coupon->expiry_date->format('d M Y') }}</div>
                            <div class="status-label">Berakhir</div>
                        </div>
                        <div class="status-item">
                            <div class="status-value">
                                @php
                                    $daysLeft = now()->diffInDays($coupon->expiry_date, false);
                                @endphp
                                @if ($daysLeft < 0)
                                    {{ abs($daysLeft) }} hari lalu
                                @elseif($daysLeft == 0)
                                    Hari ini
                                @else
                                    {{ $daysLeft }} hari lagi
                                @endif
                            </div>
                            <div class="status-label">Waktu Tersisa</div>
                        </div>
                        <div class="status-item">
                            <div class="status-value">#{{ $coupon->id }}</div>
                            <div class="status-label">ID Kupon</div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <form class="form-new-product form-style-1" method="POST" action="{{ route('admin.coupon.update') }}"
                    id="couponEditForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $coupon->id }}" />

                    <!-- Informasi Dasar -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="icon-info"></i>
                            </div>
                            Informasi Dasar Kupon
                        </h3>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="icon-tag"></i> Kode Kupon <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <i class="icon-tag input-group-icon"></i>
                                <input class="form-control" type="text" placeholder="Contoh: DISKON50K" name="code"
                                    value="{{ $coupon->code }}" aria-required="true" style="text-transform: uppercase;"
                                    id="couponCode">
                            </div>
                            <div class="form-text">
                                <i class="icon-info"></i> Gunakan kombinasi huruf dan angka, maksimal 50 karakter
                            </div>
                            @error('code')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="icon-dollar-sign"></i> Nilai Diskon <span class="required">*</span>
                                    </label>
                                    <div class="input-group">
                                        <i class="icon-dollar-sign input-group-icon"></i>
                                        <input class="form-control format-rupiah" type="text" placeholder="Rp 50.000"
                                            name="discount_amount" value="{{ formatRupiah($coupon->discount_amount) }}"
                                            aria-required="true" id="discountAmount">
                                    </div>
                                    <div class="form-text">
                                        <i class="icon-info"></i> Minimal Rp 1.000 - dapat menggunakan format rupiah
                                    </div>
                                    @error('discount_amount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="icon-shopping-cart"></i> Minimum Pembelian <span class="required">*</span>
                                    </label>
                                    <div class="input-group">
                                        <i class="icon-shopping-cart input-group-icon"></i>
                                        <input class="form-control format-rupiah" type="text" placeholder="Rp 100.000"
                                            name="minimum_order" value="{{ formatRupiah($coupon->minimum_order) }}"
                                            aria-required="true" id="minimumOrder">
                                    </div>
                                    <div class="form-text">
                                        <i class="icon-info"></i> Masukkan 0 jika tidak ada minimum pembelian
                                    </div>
                                    @error('minimum_order')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengaturan Waktu -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="icon-calendar"></i>
                            </div>
                            Pengaturan Waktu
                        </h3>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="icon-calendar"></i> Tanggal Berakhir <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <i class="icon-calendar input-group-icon"></i>
                                <input class="form-control" type="date" name="expiry_date"
                                    value="{{ $coupon->expiry_date->format('Y-m-d') }}"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}" aria-required="true" id="expiryDate">
                            </div>
                            <div class="form-text">
                                <i class="icon-clock"></i> Kupon akan otomatis tidak aktif setelah tanggal ini
                            </div>
                            @error('expiry_date')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Opsi Lanjutan -->
                    <div class="advanced-options">
                        <button type="button" class="advanced-toggle" id="advancedToggle">
                            <i class="icon-chevron-down" id="advancedIcon"></i>
                            Opsi Lanjutan
                        </button>
                        <div class="advanced-content" id="advancedContent">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="icon-users"></i> Maksimal Penggunaan
                                        </label>
                                        <div class="input-group">
                                            <i class="icon-users input-group-icon"></i>
                                            <input class="form-control" type="number" placeholder="Tidak terbatas"
                                                name="usage_limit" min="1">
                                        </div>
                                        <div class="form-text">
                                            <i class="icon-info"></i> Kosongkan untuk penggunaan tidak terbatas
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="icon-repeat"></i> Maksimal Per Pelanggan
                                        </label>
                                        <div class="input-group">
                                            <i class="icon-repeat input-group-icon"></i>
                                            <input class="form-control" type="number" placeholder="1"
                                                name="per_customer_limit" min="1" value="1">
                                        </div>
                                        <div class="form-text">
                                            <i class="icon-info"></i> Berapa kali satu pelanggan bisa menggunakan kupon ini
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('admin.coupons') }}" class="btn btn-secondary">
                            <i class="icon-arrow-left"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-danger" id="deleteBtn">
                            <i class="icon-trash-2"></i> Hapus Kupon
                        </button>
                        <button class="btn btn-primary" type="submit">
                            <i class="icon-check"></i> Perbarui Kupon
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner"></div>
            <div class="loading-text">Memproses perubahan...</div>
        </div>
    </div>

    <!-- Hidden Delete Form -->
    <form id="deleteForm" method="POST" action="{{ route('admin.coupon.delete', ['id' => $coupon->id]) }}"
        style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Fungsi untuk format rupiah
        function formatRupiah(value) {
            if (!value) return '';
            let number = value.toString().replace(/[^0-9]/g, '');
            if (number === '') return '';
            return 'Rp ' + parseInt(number).toLocaleString('id-ID');
        }

        // Fungsi untuk membersihkan format rupiah
        function cleanRupiah(value) {
            return value.replace(/[^0-9]/g, '');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Real-time preview update
            const couponCode = document.getElementById('couponCode');
            const discountAmount = document.getElementById('discountAmount');
            const minimumOrder = document.getElementById('minimumOrder');
            const couponPreview = document.getElementById('couponPreview');
            const previewDiscount = document.getElementById('previewDiscount');
            const previewMinimum = document.getElementById('previewMinimum');

            function updatePreview() {
                if (couponCode.value) {
                    couponPreview.textContent = couponCode.value.toUpperCase();
                }
                if (discountAmount.value) {
                    previewDiscount.textContent = discountAmount.value;
                }
                if (minimumOrder.value) {
                    previewMinimum.textContent = minimumOrder.value;
                }
            }

            couponCode.addEventListener('input', updatePreview);
            discountAmount.addEventListener('input', updatePreview);
            minimumOrder.addEventListener('input', updatePreview);

            // Format rupiah saat mengetik
            const rupiahInputs = document.querySelectorAll('.format-rupiah');
            rupiahInputs.forEach(input => {
                input.addEventListener('input', function() {
                    let value = cleanRupiah(this.value);
                    if (value !== '') {
                        this.value = formatRupiah(value);
                    }
                    updatePreview();
                });

                // Tangani paste event
                input.addEventListener('paste', function(e) {
                    setTimeout(() => {
                        let value = cleanRupiah(this.value);
                        if (value !== '') {
                            this.value = formatRupiah(value);
                        }
                        updatePreview();
                    }, 1);
                });
            });

            // Advanced options toggle
            const advancedToggle = document.getElementById('advancedToggle');
            const advancedContent = document.getElementById('advancedContent');
            const advancedIcon = document.getElementById('advancedIcon');

            advancedToggle.addEventListener('click', function() {
                if (advancedContent.classList.contains('show')) {
                    advancedContent.classList.remove('show');
                    advancedIcon.className = 'icon-chevron-down';
                } else {
                    advancedContent.classList.add('show');
                    advancedIcon.className = 'icon-chevron-up';
                }
            });

            // Form submission
            const form = document.getElementById('couponEditForm');
            form.addEventListener('submit', function(e) {
                // Show loading
                document.getElementById('loadingOverlay').style.display = 'flex';

                // Clean rupiah format before submit
                rupiahInputs.forEach(input => {
                    let cleanValue = cleanRupiah(input.value);
                    input.value = cleanValue;
                });
            });

            // Delete functionality
            const deleteBtn = document.getElementById('deleteBtn');
            deleteBtn.addEventListener('click', function() {
                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    html: `Apakah Anda yakin ingin menghapus kupon <strong>{{ $coupon->code }}</strong>?<br><small class="text-muted">Data yang dihapus tidak dapat dikembalikan dan akan mempengaruhi pesanan yang menggunakan kupon ini.</small>`,
                    icon: 'warning',
                    iconColor: '#f39c12',
                    showCancelButton: true,
                    reverseButtons: true,
                    focusCancel: true,
                    cancelButtonText: 'Batal',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    confirmButtonColor: '#e74c3c',
                    customClass: {
                        container: 'swal-container',
                        popup: 'swal-popup',
                        title: 'swal-title',
                        content: 'swal-content'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('loadingOverlay').style.display = 'flex';
                        document.getElementById('deleteForm').submit();
                    }
                });
            });

            // Auto uppercase for coupon code
            couponCode.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });

            // Date validation
            const expiryDate = document.getElementById('expiryDate');
            expiryDate.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);

                if (selectedDate <= tomorrow) {
                    Swal.fire({
                        title: 'Tanggal Tidak Valid',
                        text: 'Tanggal berakhir harus minimal 1 hari dari sekarang.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    this.value = '';
                }
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

            // Hide loading on page load
            window.addEventListener('load', function() {
                document.getElementById('loadingOverlay').style.display = 'none';
            });

            // Form validation enhancement
            const requiredInputs = document.querySelectorAll('input[aria-required="true"]');
            requiredInputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });

                input.addEventListener('input', function() {
                    if (this.value.trim() !== '') {
                        this.classList.remove('is-invalid');
                    }
                });
            });
        });
    </script>

    <style>
        /* Custom SweetAlert2 styling */
        .swal-container .swal-popup {
            border-radius: 15px;
            padding: 25px;
        }

        .swal-container .swal-title {
            font-size: 20px;
            font-weight: 700;
        }

        .swal-container .swal-content {
            font-size: 15px;
            line-height: 1.5;
        }
    </style>
@endsection

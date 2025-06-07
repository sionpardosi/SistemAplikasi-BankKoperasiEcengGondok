@extends('layouts.admin')

@section('content')
    <style>
        /* Base Styling - Same as other pages */
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

        /* Edit Container */
        .edit-container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* Form Section */
        .form-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .form-header {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .form-title {
            font-size: 20px;
            font-weight: 700;
            color: #495057;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-subtitle {
            font-size: 15px;
            color: #6c757d;
            margin: 5px 0 0 0;
        }

        /* Info Cards */
        .info-section {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-size: 14px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 700;
            color: #495057;
        }

        .info-current-stock {
            color: #007bff;
            font-size: 18px;
        }

        .info-transaction-type {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .type-masuk {
            background: #d1f2eb;
            color: #0c5460;
        }

        .type-keluar {
            background: #f8d7da;
            color: #721c24;
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

        .form-control,
        .form-select {
            font-size: 16px;
            padding: 15px 18px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-text {
            font-size: 14px;
            color: #6c757d;
            margin-top: 8px;
            line-height: 1.4;
        }

        /* Alert Messages */
        .alert-section {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .alert-content {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .alert-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ffc107;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
            flex-shrink: 0;
        }

        .alert-text {
            flex: 1;
        }

        .alert-title {
            font-size: 16px;
            font-weight: 700;
            color: #856404;
            margin-bottom: 5px;
        }

        .alert-message {
            font-size: 14px;
            color: #856404;
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

        .btn-group-custom {
            display: flex;
            gap: 15px;
            justify-content: center;
            align-items: center;
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
        }

        .btn-secondary:hover {
            background: #545b62;
            border-color: #545b62;
            color: white;
            transform: translateY(-1px);
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

            .page-header,
            .action-bar,
            .form-section {
                padding: 20px;
            }

            .edit-container {
                max-width: 100%;
            }

            .btn-group-custom {
                flex-direction: column;
                gap: 10px;
            }

            .btn-secondary,
            .btn-save {
                width: 100%;
                justify-content: center;
            }

            .info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
        }

        @media (max-width: 576px) {
            .form-title {
                font-size: 18px;
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
                <h3>Edit Stok Bahan Baku</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.stok.index') }}">
                            <div class="text-tiny">Stok Bahan Baku</div>
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
                        <h4 class="page-title">Edit Data Stok Bahan Baku</h4>
                        <p class="page-description">Ubah informasi transaksi stok bahan baku yang sudah ada</p>
                    </div>
                    <a href="{{ route('admin.stok.index') }}" class="btn-back">
                        <i class="icon-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>

            <div class="edit-container">
                <!-- Info Section -->
                <div class="info-section">
                    <div class="info-row">
                        <span class="info-label">Total Stok Saat Ini</span>
                        <span
                            class="info-value info-current-stock">{{ number_format(\App\Models\StokBahanBaku::sum('jumlah_kg'), 1) }}
                            kg</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jenis Transaksi</span>
                        <span class="info-transaction-type {{ $stok->jumlah_kg > 0 ? 'type-masuk' : 'type-keluar' }}">
                            {{ $stok->jumlah_kg > 0 ? 'Stok Masuk' : 'Stok Keluar' }}
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Dibuat Tanggal</span>
                        <span class="info-value">{{ $stok->created_at->format('d F Y, H:i') }} WIB</span>
                    </div>
                </div>

                <!-- Alert Section -->
                <div class="alert-section">
                    <div class="alert-content">
                        <div class="alert-icon">
                            <i class="icon-info"></i>
                        </div>
                        <div class="alert-text">
                            <div class="alert-title">Perhatian Saat Edit Data</div>
                            <p class="alert-message">
                                Pastikan data yang Anda ubah sudah benar. Perubahan akan mempengaruhi total stok
                                keseluruhan.
                                Gunakan angka negatif (-) untuk transaksi pengurangan stok (konsumsi/penggunaan).
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="form-section">
                    <div class="form-header">
                        <h4 class="form-title">
                            <i class="icon-edit"></i> Form Edit Stok Bahan Baku
                        </h4>
                        <p class="form-subtitle">Ubah informasi transaksi stok yang sudah ada</p>
                    </div>

                    <form action="{{ route('admin.stok.update', $stok->id) }}" method="POST" id="editForm">
                        @csrf @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal" class="form-label">
                                        <i class="icon-calendar"></i> Tanggal Transaksi
                                    </label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                                        value="{{ $stok->tanggal }}" required>
                                    <div class="form-text">
                                        <i class="icon-info"></i> Tanggal ketika transaksi stok terjadi
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jumlah_kg" class="form-label">
                                        <i class="icon-package"></i> Jumlah (kg)
                                    </label>
                                    <input type="number" step="0.1" name="jumlah_kg" id="jumlah_kg"
                                        class="form-control" value="{{ $stok->jumlah_kg }}" required>
                                    <div class="form-text">
                                        <i class="icon-bulb"></i> <strong>Tips:</strong> Gunakan angka positif (+) untuk
                                        penambahan stok,
                                        angka negatif (-) untuk pengurangan stok
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="keterangan" class="form-label">
                                <i class="icon-message-square"></i> Keterangan / Catatan
                            </label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="5"
                                placeholder="Masukkan keterangan lengkap tentang transaksi ini...">{{ $stok->keterangan }}</textarea>
                            <div class="form-text">
                                <i class="icon-info"></i> Berikan informasi detail tentang sumber stok, keperluan, atau
                                catatan penting lainnya
                            </div>
                        </div>

                        <!-- Action Section -->
                        <div class="action-section">
                            <div class="btn-group-custom">
                                <a href="{{ route('admin.stok.index') }}" class="btn-secondary">
                                    <i class="icon-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn-save" id="submitBtn">
                                    <i class="icon-check"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('editForm');
            const jumlahInput = document.getElementById('jumlah_kg');
            const originalValue = parseFloat(jumlahInput.value);

            // Real-time validation untuk jumlah
            jumlahInput.addEventListener('input', function() {
                const currentValue = parseFloat(this.value) || 0;
                const currentTotalStok = {{ \App\Models\StokBahanBaku::sum('jumlah_kg') }};
                const newTotalAfterUpdate = currentTotalStok - originalValue + currentValue;

                // Update visual feedback
                if (newTotalAfterUpdate < 0) {
                    this.style.borderColor = '#dc3545';
                    this.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';
                } else {
                    this.style.borderColor = '#28a745';
                    this.style.boxShadow = '0 0 0 0.2rem rgba(40, 167, 69, 0.25)';
                }
            });

            // Form submission dengan validasi
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const jumlah = parseFloat(jumlahInput.value) || 0;
                const currentTotalStok = {{ \App\Models\StokBahanBaku::sum('jumlah_kg') }};
                const newTotalAfterUpdate = currentTotalStok - originalValue + jumlah;
                const keterangan = document.getElementById('keterangan').value.trim();

                // Validasi stok tidak boleh negatif
                if (newTotalAfterUpdate < 0) {
                    Swal.fire({
                        title: 'Perubahan Tidak Valid!',
                        text: `Perubahan ini akan membuat total stok menjadi ${newTotalAfterUpdate.toFixed(1)} kg (negatif). Silakan sesuaikan jumlahnya.`,
                        icon: 'error',
                        iconColor: '#e74c3c',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#e74c3c'
                    }).then(() => {
                        jumlahInput.focus();
                    });
                    return false;
                }

                // Validasi wajib keterangan untuk perubahan besar
                if (Math.abs(jumlah - originalValue) > 10 && !keterangan) {
                    Swal.fire({
                        title: 'Keterangan Diperlukan!',
                        text: 'Untuk perubahan jumlah yang signifikan (>10 kg), harap berikan keterangan yang jelas.',
                        icon: 'warning',
                        iconColor: '#f39c12',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#f39c12'
                    }).then(() => {
                        document.getElementById('keterangan').focus();
                    });
                    return false;
                }

                // Konfirmasi perubahan
                let confirmConfig = {
                    title: 'Konfirmasi Perubahan',
                    html: `
                        <div style="text-align: left; margin: 15px 0;">
                            <p><strong>Detail Perubahan:</strong></p>
                            <ul style="margin-left: 20px;">
                                <li>Jumlah lama: <strong>${originalValue} kg</strong></li>
                                <li>Jumlah baru: <strong>${jumlah} kg</strong></li>
                                <li>Selisih: <strong>${(jumlah - originalValue).toFixed(1)} kg</strong></li>
                                <li>Total stok setelah perubahan: <strong>${newTotalAfterUpdate.toFixed(1)} kg</strong></li>
                            </ul>
                        </div>
                        <p>Apakah Anda yakin ingin menyimpan perubahan ini?</p>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    reverseButtons: true,
                    focusCancel: true,
                    cancelButtonText: 'Batal',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Simpan',
                    confirmButtonColor: '#28a745'
                };

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
        });
    </script>
@endsection

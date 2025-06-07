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
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .form-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .form-title {
            font-size: 24px;
            font-weight: 700;
            color: #495057;
            margin: 0;
        }

        .form-subtitle {
            font-size: 16px;
            color: #6c757d;
            margin: 8px 0 0 0;
        }

        /* Supplier Info Section */
        .supplier-info-section {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .supplier-info-title {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .supplier-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-card {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 15px;
            color: #495057;
            font-weight: 600;
        }

        .info-value.highlight {
            color: #007bff;
            font-weight: 700;
        }

        .readonly-badge {
            background: #e9ecef;
            color: #6c757d;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Form Styling */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-size: 15px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .form-label.required::after {
            content: ' *';
            color: #dc3545;
        }

        .form-control,
        .form-select {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #ffffff;
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            outline: none;
        }

        .form-control:disabled,
        .form-select:disabled {
            background-color: #f8f9fa;
            border-color: #e9ecef;
            color: #6c757d;
        }

        /* Read-only fields styling */
        .readonly-field {
            background: #f8f9fa !important;
            border-color: #e9ecef !important;
            color: #6c757d !important;
            cursor: not-allowed;
        }

        .readonly-label {
            color: #6c757d !important;
        }

        .readonly-label::before {
            content: '🔒 ';
            margin-right: 4px;
        }

        /* Editable fields styling */
        .editable-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .editable-section-title {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Status Badge Styling */
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

        /* Alert Styling */
        .alert-warning-custom {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            color: #856404;
        }

        .alert-warning-custom .alert-icon {
            font-size: 20px;
            margin-right: 10px;
        }

        /* Button Styling */
        .btn-submit {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            color: white;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
            min-width: 150px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
            color: white;
        }

        .btn-cancel {
            background: #6c757d;
            border: 1px solid #6c757d;
            color: white;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 150px;
        }

        .btn-cancel:hover {
            background: #545b62;
            border-color: #545b62;
            color: white;
            transform: translateY(-1px);
        }

        /* Form Actions */
        .form-actions {
            border-top: 1px solid #e9ecef;
            padding-top: 25px;
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: flex-end;
        }

        /* Help Text */
        .help-text {
            font-size: 13px;
            color: #6c757d;
            margin-top: 5px;
            line-height: 1.4;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .form-container,
            .supplier-info-section,
            .editable-section {
                padding: 20px;
            }

            .supplier-info-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-submit,
            .btn-cancel {
                width: 100%;
            }
        }

        /* Change History */
        .change-history {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }

        .change-history-title {
            font-size: 14px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 10px;
        }

        .change-item {
            font-size: 13px;
            color: #6c757d;
            padding: 5px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .change-item:last-child {
            border-bottom: none;
        }

        .change-date {
            color: #007bff;
            font-weight: 600;
        }

        /* Loading State */
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
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Jadwal Penjemputan</h3>
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
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Edit</div>
                    </li>
                </ul>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <div class="form-header">
                    <h4 class="form-title">
                        <i class="icon-pencil"></i> Edit Jadwal Penjemputan
                    </h4>
                    <p class="form-subtitle">Update informasi jadwal penjemputan dan status</p>
                </div>

                <!-- Supplier Information (Read-only) -->
                <div class="supplier-info-section">
                    <div class="supplier-info-title">
                        <i class="icon-user"></i> Informasi Pemasok
                        <span class="readonly-badge">Tidak Dapat Diubah</span>
                    </div>

                    @if($jadwal->request)
                        <div class="supplier-info-grid">
                            <div class="info-card">
                                <div class="info-label">Nama Pemasok</div>
                                <div class="info-value highlight">{{ $jadwal->request->nama }}</div>
                            </div>
                            <div class="info-card">
                                <div class="info-label">Email</div>
                                <div class="info-value">{{ $jadwal->request->email }}</div>
                            </div>
                            <div class="info-card">
                                <div class="info-label">No. HP</div>
                                <div class="info-value">{{ $jadwal->request->no_hp ?? '-' }}</div>
                            </div>
                            <div class="info-card">
                                <div class="info-label">Tanggal Request</div>
                                <div class="info-value">{{ $jadwal->request->created_at->format('d M Y, H:i') }}</div>
                            </div>
                            <div class="info-card">
                                <div class="info-label">Jenis Insentif</div>
                                <div class="info-value">{{ $jadwal->request->insentif == 'diskon' ? 'Diskon Produk' : 'Uang Tunai' }}</div>
                            </div>
                            <div class="info-card">
                                <div class="info-label">Status Request</div>
                                <div class="info-value highlight">{{ ucfirst($jadwal->request->status) }}</div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="icon-alert-triangle" style="font-size: 48px; color: #ffc107;"></i>
                            <p class="text-warning mt-3">Data pemasok tidak ditemukan</p>
                        </div>
                    @endif
                </div>

                <!-- Warning Alert -->
                <div class="alert-warning-custom">
                    <i class="icon-alert-triangle alert-icon"></i>
                    <strong>Perhatian:</strong> Data pemasok (nama, email, lokasi asal) tidak dapat diubah untuk menjaga integritas data.
                    Hanya tanggal penjemputan dan status yang dapat dimodifikasi.
                </div>

                <!-- Editable Form -->
                <form action="{{ route('admin.penjadwalan.update', $jadwal->id) }}" method="POST" id="editForm">
                    @csrf @method('PUT')

                    <!-- Hidden field for supplier request -->
                    <input type="hidden" name="supplier_request_id" value="{{ $jadwal->supplier_request_id }}">

                    <!-- Editable Fields Section -->
                    <div class="editable-section">
                        <div class="editable-section-title">
                            <i class="icon-edit"></i> Informasi yang Dapat Diubah
                        </div>

                        <!-- Schedule Date -->
                        <div class="form-group">
                            <label class="form-label required">Tanggal Penjemputan</label>
                            <input type="date" name="tanggal_jemput" class="form-control"
                                   value="{{ $jadwal->tanggal_jemput }}" required
                                   min="{{ now()->format('Y-m-d') }}">
                            <div class="help-text">
                                <i class="icon-calendar"></i> Ubah tanggal penjemputan jika diperlukan
                            </div>
                        </div>

                        <!-- Location Fields (Read-only but from schedule data) -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label readonly-label">Kecamatan</label>
                                    <input type="text" name="kecamatan" class="form-control readonly-field"
                                           value="{{ $jadwal->kecamatan }}" readonly>
                                    <div class="help-text">
                                        <i class="icon-lock"></i> Data lokasi dari permintaan pemasok
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label readonly-label">Desa</label>
                                    <input type="text" name="desa" class="form-control readonly-field"
                                           value="{{ $jadwal->desa }}" readonly>
                                    <div class="help-text">
                                        <i class="icon-lock"></i> Data lokasi dari permintaan pemasok
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label readonly-label">Detail Lokasi</label>
                            <input type="text" name="detail_lokasi" class="form-control readonly-field"
                                   value="{{ $jadwal->detail_lokasi }}" readonly>
                            <div class="help-text">
                                <i class="icon-lock"></i> Detail lokasi dari permintaan pemasok
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label readonly-label">Estimasi Berat (kg)</label>
                            <input type="number" name="estimasi_kg" class="form-control readonly-field"
                                   value="{{ $jadwal->estimasi_kg }}" readonly>
                            <div class="help-text">
                                <i class="icon-lock"></i> Estimasi berat dari permintaan pemasok
                            </div>
                        </div>

                        <!-- Status (Editable) -->
                        <div class="form-group">
                            <label class="form-label required">Status Penjemputan</label>
                            <select name="status_jemput" class="form-select" required>
                                <option value="terjadwal" {{ $jadwal->status_jemput == 'terjadwal' ? 'selected' : '' }}>
                                    Terjadwal
                                </option>
                                <option value="dijemput" {{ $jadwal->status_jemput == 'dijemput' ? 'selected' : '' }}>
                                    Dijemput
                                </option>
                                <option value="dibatalkan" {{ $jadwal->status_jemput == 'dibatalkan' ? 'selected' : '' }}>
                                    Dibatalkan
                                </option>
                            </select>
                            <div class="help-text">
                                <i class="icon-info"></i> Update status berdasarkan kondisi aktual penjemputan
                            </div>
                        </div>

                        <!-- Current Status Display -->
                        <div class="form-group">
                            <label class="form-label">Status Saat Ini</label>
                            <div>
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
                            </div>
                        </div>
                    </div>

                    <!-- Change History -->
                    <div class="change-history">
                        <div class="change-history-title">
                            <i class="icon-clock"></i> Riwayat Perubahan
                        </div>
                        <div class="change-item">
                            <span class="change-date">{{ $jadwal->created_at->format('d M Y, H:i') }}</span> -
                            Jadwal dibuat oleh admin
                        </div>
                        @if($jadwal->updated_at != $jadwal->created_at)
                        <div class="change-item">
                            <span class="change-date">{{ $jadwal->updated_at->format('d M Y, H:i') }}</span> -
                            Terakhir diupdate
                        </div>
                        @endif
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('admin.penjadwalan.index') }}" class="btn-cancel">
                            <i class="icon-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn-submit">
                            <i class="icon-check"></i> Simpan Perubahan
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
            <div class="loading-text">Menyimpan perubahan...</div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editForm = document.getElementById('editForm');

            // Form submission with confirmation
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const statusSelect = document.querySelector('select[name="status_jemput"]');
                const newStatus = statusSelect.value;
                const currentStatus = '{{ $jadwal->status_jemput }}';

                let confirmationMessage = 'Apakah Anda yakin ingin menyimpan perubahan?';

                if (newStatus !== currentStatus) {
                    const statusText = {
                        'terjadwal': 'Terjadwal',
                        'dijemput': 'Dijemput',
                        'dibatalkan': 'Dibatalkan'
                    };

                    confirmationMessage = `Anda akan mengubah status dari "${statusText[currentStatus]}" menjadi "${statusText[newStatus]}". Lanjutkan?`;
                }

                Swal.fire({
                    title: 'Konfirmasi Perubahan',
                    text: confirmationMessage,
                    icon: 'question',
                    iconColor: '#007bff',
                    showCancelButton: true,
                    reverseButtons: true,
                    focusCancel: false,
                    cancelButtonText: 'Batal',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Simpan',
                    confirmButtonColor: '#007bff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading overlay
                        document.getElementById('loadingOverlay').style.display = 'flex';

                        // Submit form after a short delay
                        setTimeout(() => {
                            this.submit();
                        }, 500);
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

            // Validation errors
            @if ($errors->any())
                let errorMessages = [];
                @foreach ($errors->all() as $error)
                    errorMessages.push('{{ $error }}');
                @endforeach

                Swal.fire({
                    title: 'Validasi Gagal!',
                    html: errorMessages.join('<br>'),
                    icon: 'error',
                    iconColor: '#e74c3c',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#e74c3c'
                });
            @endif
        });
    </script>
@endsection

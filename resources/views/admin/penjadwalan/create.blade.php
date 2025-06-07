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

        /* Request Selection */
        .request-selector {
            position: relative;
        }

        .request-search {
            margin-bottom: 15px;
        }

        .request-search input {
            padding-left: 45px;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 16px;
        }

        .request-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background: #ffffff;
        }

        .request-item {
            padding: 15px;
            border-bottom: 1px solid #f1f3f4;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .request-item:last-child {
            border-bottom: none;
        }

        .request-item:hover {
            background: #f8f9ff;
        }

        .request-item.selected {
            background: #e3f2fd;
            border-left: 4px solid #007bff;
        }

        .request-header {
            font-weight: 700;
            color: #495057;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .request-details {
            font-size: 14px;
            color: #6c757d;
            line-height: 1.4;
        }

        .request-meta {
            font-size: 12px;
            color: #007bff;
            margin-top: 5px;
        }

        /* Selected Request Display */
        .selected-request-display {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .selected-request-title {
            font-size: 16px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .request-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 14px;
            color: #495057;
            font-weight: 500;
        }

        .info-value.highlight {
            color: #007bff;
            font-weight: 700;
        }

        /* Auto-filled fields styling */
        .auto-filled {
            background: #e8f5e8 !important;
            border-color: #28a745 !important;
        }

        .auto-filled-label {
            color: #28a745 !important;
        }

        .auto-filled-label::before {
            content: '🔒 ';
            margin-right: 4px;
        }

        /* Alert Styling */
        .alert-info-custom {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            color: #1565c0;
        }

        .alert-info-custom .alert-icon {
            font-size: 20px;
            margin-right: 10px;
        }

        /* Button Styling */
        .btn-submit {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
            min-width: 150px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
            color: white;
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
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

        /* Empty State */
        .empty-requests {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-requests .icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .empty-requests .title {
            font-size: 20px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 10px;
        }

        .empty-requests .text {
            font-size: 16px;
            margin-bottom: 25px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .form-container {
                padding: 20px;
            }

            .request-info-grid {
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
                <h3>Atur Jadwal Penjemputan</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.penjadwalan.index') }}">
                            <div class="text-tiny">Jadwal Penjemputan</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Atur Jadwal</div>
                    </li>
                </ul>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <div class="form-header">
                    <h4 class="form-title">
                        <i class="icon-calendar"></i> Atur Jadwal Penjemputan Baru
                    </h4>
                    <p class="form-subtitle">Pilih permintaan pemasok yang telah disetujui dan atur jadwal penjemputannya</p>
                </div>

                @if($requests->count() > 0)
                    <form action="{{ route('admin.penjadwalan.store') }}" method="POST" id="scheduleForm">
                        @csrf

                        <!-- Request Selection -->
                        <div class="form-group">
                            <label class="form-label required">Pilih Permintaan Pemasok</label>

                            <!-- Search Box -->
                            <div class="request-search">
                                <div style="position: relative;">
                                    <i class="icon-magnifier search-icon"></i>
                                    <input type="text" id="requestSearch" class="form-control"
                                           placeholder="Cari berdasarkan nama, email, atau lokasi..."
                                           style="padding-left: 45px;">
                                </div>
                            </div>

                            <!-- Request List -->
                            <div class="request-list" id="requestList">
                                @foreach ($requests as $req)
                                    <div class="request-item" data-request-id="{{ $req->id }}"
                                         data-search-text="{{ strtolower($req->nama . ' ' . $req->email . ' ' . $req->kecamatan . ' ' . $req->desa) }}">
                                        <div class="request-header">{{ $req->nama }}</div>
                                        <div class="request-details">
                                            <i class="icon-envelope"></i> {{ $req->email }} |
                                            <i class="icon-location-pin"></i> {{ $req->kecamatan }}, {{ $req->desa }} |
                                            <i class="icon-credit-card"></i> {{ $req->estimasi_kg }} kg
                                        </div>
                                        <div class="request-meta">
                                            <i class="icon-calendar"></i> Diajukan: {{ $req->created_at->format('d M Y, H:i') }} |
                                            <i class="icon-wallet"></i> {{ $req->insentif == 'diskon' ? 'Diskon' : 'Uang Tunai' }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Hidden input for selected request -->
                            <input type="hidden" name="supplier_request_id" id="selectedRequestId" required>
                            <div class="help-text">
                                <i class="icon-info"></i> Klik pada salah satu permintaan pemasok di atas untuk melanjutkan
                            </div>
                        </div>

                        <!-- Selected Request Display -->
                        <div id="selectedRequestDisplay" class="selected-request-display" style="display: none;">
                            <div class="selected-request-title">
                                <i class="icon-check-circle"></i> Detail Permintaan Terpilih
                            </div>
                            <div class="request-info-grid" id="requestInfoGrid">
                                <!-- Will be populated by JavaScript -->
                            </div>
                        </div>

                        <!-- Alert Info -->
                        <div id="autoFillAlert" class="alert-info-custom" style="display: none;">
                            <i class="icon-info alert-icon"></i>
                            <strong>Info:</strong> Data lokasi dan estimasi berat telah diisi otomatis berdasarkan permintaan pemasok yang dipilih.
                            Data ini tidak dapat diubah untuk menjaga integritas data pemasok.
                        </div>

                        <!-- Schedule Date -->
                        <div class="form-group">
                            <label class="form-label required">Tanggal Penjemputan</label>
                            <input type="date" name="tanggal_jemput" class="form-control" required
                                   min="{{ now()->format('Y-m-d') }}">
                            <div class="help-text">
                                <i class="icon-calendar"></i> Pilih tanggal penjemputan (minimal hari ini)
                            </div>
                        </div>

                        <div class="row">
                            <!-- Kecamatan (Auto-filled) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label auto-filled-label">Kecamatan</label>
                                    <input type="text" name="kecamatan" id="kecamatan" class="form-control auto-filled" readonly>
                                    <div class="help-text">
                                        <i class="icon-lock"></i> Diisi otomatis dari data permintaan pemasok
                                    </div>
                                </div>
                            </div>

                            <!-- Desa (Auto-filled) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label auto-filled-label">Desa</label>
                                    <input type="text" name="desa" id="desa" class="form-control auto-filled" readonly>
                                    <div class="help-text">
                                        <i class="icon-lock"></i> Diisi otomatis dari data permintaan pemasok
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Lokasi (Auto-filled) -->
                        <div class="form-group">
                            <label class="form-label auto-filled-label">Detail Lokasi</label>
                            <input type="text" name="detail_lokasi" id="detail_lokasi" class="form-control auto-filled" readonly>
                            <div class="help-text">
                                <i class="icon-lock"></i> Diisi otomatis dari data permintaan pemasok
                            </div>
                        </div>

                        <!-- Estimasi Berat (Auto-filled) -->
                        <div class="form-group">
                            <label class="form-label auto-filled-label">Estimasi Berat (kg)</label>
                            <input type="number" name="estimasi_kg" id="estimasi_kg" class="form-control auto-filled" readonly>
                            <div class="help-text">
                                <i class="icon-lock"></i> Diisi otomatis dari data permintaan pemasok
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <a href="{{ route('admin.penjadwalan.index') }}" class="btn-cancel">
                                <i class="icon-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn-submit" id="submitBtn" disabled>
                                <i class="icon-check"></i> Simpan Jadwal
                            </button>
                        </div>
                    </form>
                @else
                    <!-- Empty State -->
                    <div class="empty-requests">
                        <div class="icon">
                            <i class="icon-folder"></i>
                        </div>
                        <div class="title">Tidak Ada Permintaan yang Tersedia</div>
                        <p class="text">
                            Belum ada permintaan pemasok yang disetujui dan siap dijadwalkan.<br>
                            Pastikan ada permintaan dengan status "disetujui" terlebih dahulu.
                        </p>
                        <a href="{{ route('admin.supplier.index') }}" class="btn btn-primary">
                            <i class="icon-users"></i> Kelola Permintaan Pemasok
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner"></div>
            <div class="loading-text">Menyimpan jadwal penjemputan...</div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const requestItems = document.querySelectorAll('.request-item');
            const requestSearch = document.getElementById('requestSearch');
            const selectedRequestId = document.getElementById('selectedRequestId');
            const selectedRequestDisplay = document.getElementById('selectedRequestDisplay');
            const requestInfoGrid = document.getElementById('requestInfoGrid');
            const autoFillAlert = document.getElementById('autoFillAlert');
            const submitBtn = document.getElementById('submitBtn');
            const scheduleForm = document.getElementById('scheduleForm');

            // Store request data for easy access
            const requestsData = @json($requests->keyBy('id'));

            // Search functionality
            requestSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();

                requestItems.forEach(item => {
                    const searchText = item.getAttribute('data-search-text');
                    if (searchText.includes(searchTerm)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            // Request selection
            requestItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Remove previous selection
                    requestItems.forEach(i => i.classList.remove('selected'));

                    // Select current item
                    this.classList.add('selected');

                    const requestId = this.getAttribute('data-request-id');
                    const requestData = requestsData[requestId];

                    // Set hidden input
                    selectedRequestId.value = requestId;

                    // Populate form fields
                    populateFormFields(requestData);

                    // Show selected request display
                    showSelectedRequest(requestData);

                    // Enable submit button
                    submitBtn.disabled = false;

                    // Show auto-fill alert
                    autoFillAlert.style.display = 'block';

                    // Scroll to form fields
                    selectedRequestDisplay.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });

            function populateFormFields(requestData) {
                document.getElementById('kecamatan').value = requestData.kecamatan || '';
                document.getElementById('desa').value = requestData.desa || '';
                document.getElementById('detail_lokasi').value = requestData.detail_lokasi || '';
                document.getElementById('estimasi_kg').value = requestData.estimasi_kg || '';
            }

            function showSelectedRequest(requestData) {
                const insentifText = requestData.insentif === 'diskon' ? 'Diskon Produk' : 'Uang Tunai';
                const estimatedValue = requestData.insentif === 'uang_tunai'
                    ? 'Rp ' + (requestData.estimasi_kg * 60000).toLocaleString('id-ID')
                    : (requestData.kupon ? requestData.kupon.code : 'Akan ditentukan');

                requestInfoGrid.innerHTML = `
                    <div class="info-item">
                        <div class="info-label">Nama Pemasok</div>
                        <div class="info-value highlight">${requestData.nama}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">${requestData.email}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">No. HP</div>
                        <div class="info-value">${requestData.no_hp || '-'}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Lokasi</div>
                        <div class="info-value">${requestData.kecamatan}, ${requestData.desa}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Detail Lokasi</div>
                        <div class="info-value">${requestData.detail_lokasi || '-'}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Estimasi Berat</div>
                        <div class="info-value highlight">${requestData.estimasi_kg} kg</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Jenis Insentif</div>
                        <div class="info-value">${insentifText}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Estimasi Nilai</div>
                        <div class="info-value highlight">${estimatedValue}</div>
                    </div>
                `;

                selectedRequestDisplay.style.display = 'block';
            }

            // Form submission
            scheduleForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Show loading overlay
                document.getElementById('loadingOverlay').style.display = 'flex';

                // Submit form after a short delay
                setTimeout(() => {
                    this.submit();
                }, 500);
            });

            // Error handling
            @if ($errors->has('error'))
                Swal.fire({
                    title: 'Gagal!',
                    text: '{{ $errors->first('error') }}',
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

@extends('layouts.admin')

@section('content')
    <style>
        .form-group label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 6px;
            margin-top: 10px;
        }

        .form-control {
            font-size: 14px !important;
            padding: 10px;
            margin-bottom: 10px;
        }

        .btn-primary {
            font-size: 14px !important;
            padding: 10px 15px;
        }

        .info-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
        }

        .info-card h6 {
            margin-bottom: 10px;
            font-weight: bold;
            color: #495057;
        }

        .photo-preview {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            cursor: pointer;
        }

        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 15px;
        }

        .kupon-option {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 8px;
            cursor: pointer;
            background-color: white;
        }

        .kupon-option:hover {
            border-color: #007bff;
            background-color: #f8f9fa;
        }

        .kupon-option.selected {
            border-color: #007bff;
            background-color: #e7f3ff;
        }

        .section-divider {
            border-top: 2px solid #dee2e6;
            margin: 30px 0 20px 0;
            padding-top: 20px;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
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

            <div class="wg-box">
                <form action="{{ route('admin.supplier.request.update', $request->id) }}" method="POST" class="fs-3">
                    @csrf @method('PUT')

                    <!-- Informasi Lengkap Pemasok -->
                    <h5 class="mb-3"><strong>📋 Informasi Lengkap Pemasok</strong></h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6>👤 Nama Lengkap</h6>
                                <p class="mb-0">{{ $request->nama }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6>✉️ Email</h6>
                                <p class="mb-0">{{ $request->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6>📱 No. HP/WhatsApp</h6>
                                <p class="mb-0">{{ $request->no_hp ?? $request->no_wa ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6>📅 Tanggal Pengajuan</h6>
                                <p class="mb-0">{{ $request->created_at->format('d F Y, H:i') }} WIB</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6>📍 Lokasi Lengkap</h6>
                                <p class="mb-1"><strong>Kecamatan:</strong> {{ $request->kecamatan ?? '-' }}</p>
                                <p class="mb-1"><strong>Desa:</strong> {{ $request->desa ?? '-' }}</p>
                                <p class="mb-0"><strong>Detail:</strong> {{ $request->detail_lokasi ?? '-' }}</p>
                                @if($request->lokasi)
                                    <p class="mb-0"><strong>Lokasi Lama:</strong> {{ $request->lokasi }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6>⚖️ Estimasi & Insentif</h6>
                                <p class="mb-1"><strong>Jumlah:</strong> {{ $request->estimasi_kg }} kg eceng gondok</p>
                                <p class="mb-1"><strong>Jenis Insentif:</strong>
                                    {{ $request->insentif == 'diskon' ? '🎟️ Diskon Produk' : '💰 Uang Tunai' }}
                                </p>
                                @if ($request->insentif == 'uang_tunai')
                                    <p class="mb-0"><strong>Perkiraan Total:</strong>
                                        <span class="text-success">Rp {{ number_format($request->estimasi_kg * 60000, 0, ',', '.') }}</span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($request->catatan)
                    <div class="info-card">
                        <h6>💬 Catatan dari Pemasok</h6>
                        <p class="mb-0">{{ $request->catatan }}</p>
                    </div>
                    @endif

                    <!-- Foto Bukti Eceng Gondok -->
                    @if($request->foto)
                    <div class="section-divider">
                        <h5 class="mb-3"><strong>📸 Foto Bukti Eceng Gondok</strong></h5>
                        <div class="text-center">
                            <img src="{{ asset($request->foto) }}"
                                 alt="Foto Eceng Gondok dari {{ $request->nama }}"
                                 class="photo-preview"
                                 data-bs-toggle="modal"
                                 data-bs-target="#photoModal">
                            <p class="text-muted mt-2">
                                <small>📌 Klik gambar untuk melihat dalam ukuran penuh</small>
                            </p>
                        </div>
                    </div>
                    @endif

                    <!-- Status dan Pengaturan -->
                    <div class="section-divider">
                        <h5 class="mb-3"><strong>⚙️ Pengaturan Status dan Approval</strong></h5>

                        <!-- Status Saat Ini -->
                        <div class="mb-3">
                            <label><strong>Status Saat Ini:</strong></label><br>
                            @switch($request->status)
                                @case('pending')
                                    <span class="status-badge bg-warning text-dark">⏳ Menunggu Persetujuan</span>
                                    @break
                                @case('disetujui')
                                    <span class="status-badge bg-success text-white">✅ Telah Disetujui</span>
                                    @break
                                @case('ditolak')
                                    <span class="status-badge bg-danger text-white">❌ Ditolak</span>
                                    @break
                            @endswitch
                        </div>

                        <!-- Ubah Status -->
                        <div class="mb-3">
                            <label class="form-group">🔄 Ubah Status Permintaan</label>
                            <select name="status" class="form-control" required id="statusSelect">
                                <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>
                                    ⏳ Pending - Menunggu Review
                                </option>
                                <option value="disetujui" {{ $request->status == 'disetujui' ? 'selected' : '' }}>
                                    ✅ Disetujui - Terima Permintaan
                                </option>
                                <option value="ditolak" {{ $request->status == 'ditolak' ? 'selected' : '' }}>
                                    ❌ Ditolak - Tolak Permintaan
                                </option>
                            </select>
                        </div>

                        <!-- Pengaturan Kupon untuk Insentif Diskon -->
                        @if ($request->insentif == 'diskon')
                        <div class="mb-3" id="kuponSection">
                            <label class="form-group">🎟️ Pilih Kupon Diskon untuk Pemasok</label>
                            <p class="text-muted mb-3">
                                <small>💡 Pilih kupon yang akan diberikan kepada pemasok sebagai insentif. Kupon hanya akan aktif jika status disetujui.</small>
                            </p>

                            <!-- Opsi Tidak Ada Kupon -->
                            <div class="kupon-option" onclick="selectKupon('')">
                                <input type="radio" name="kupon_id" value="" id="no-kupon"
                                       {{ !$request->kupon_id ? 'checked' : '' }}>
                                <label for="no-kupon" class="mb-0 w-100">
                                    <strong>❌ Tidak Memberikan Kupon</strong><br>
                                    <small class="text-muted">Pemasok tidak akan menerima kupon diskon</small>
                                </label>
                            </div>

                            <!-- Daftar Kupon -->
                            @forelse ($kupons as $kupon)
                            <div class="kupon-option {{ $request->kupon_id == $kupon->id ? 'selected' : '' }}"
                                 onclick="selectKupon('{{ $kupon->id }}')">
                                <input type="radio" name="kupon_id" value="{{ $kupon->id }}" id="kupon-{{ $kupon->id }}"
                                       {{ $request->kupon_id == $kupon->id ? 'checked' : '' }}>
                                <label for="kupon-{{ $kupon->id }}" class="mb-0 w-100">
                                    <strong>🎫 {{ $kupon->code }}</strong>
                                    <span class="float-end">
                                        @if($kupon->expiry_date < now())
                                            <span class="badge bg-danger">Expired</span>
                                        @elseif(!$kupon->is_active)
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @else
                                            <span class="badge bg-success">Aktif</span>
                                        @endif
                                    </span><br>
                                    <small class="text-muted">
                                        💰 Diskon: <strong>Rp {{ number_format($kupon->discount_amount, 0, ',', '.') }}</strong> |
                                        🛒 Min. Order: <strong>Rp {{ number_format($kupon->minimum_order, 0, ',', '.') }}</strong> |
                                        📅 Berlaku sampai: <strong>{{ $kupon->expiry_date->format('d M Y') }}</strong>
                                    </small>
                                </label>
                            </div>
                            @empty
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Tidak ada kupon tersedia.</strong> Silakan buat kupon terlebih dahulu di menu Kupon.
                            </div>
                            @endforelse
                        </div>
                        @endif

                        <!-- Perkiraan Total Insentif Uang Tunai -->
                        @if ($request->insentif == 'uang_tunai')
                        <div class="mb-3">
                            <label class="form-group">💰 Perkiraan Total Insentif Uang Tunai</label>
                            <input type="text" class="form-control bg-success text-white"
                                   value="Rp {{ number_format($request->estimasi_kg * 60000, 0, ',', '.') }}"
                                   readonly style="font-weight: bold; font-size: 16px;">
                            <small class="form-text text-muted">
                                💡 Dihitung berdasarkan: {{ $request->estimasi_kg }} kg × Rp 60.000/kg
                            </small>
                        </div>
                        @endif
                    </div>

                    <!-- Catatan Admin -->
                    <div class="section-divider">
                        <h5 class="mb-3"><strong>📝 Catatan dan Komunikasi</strong></h5>

                        <div class="mb-3">
                            <label class="form-group">💼 Catatan Admin untuk Pemasok</label>
                            <textarea name="catatan_admin" class="form-control" rows="5"
                                      placeholder="Berikan catatan, instruksi, atau alasan keputusan kepada pemasok. Catatan ini akan dikirim melalui email notifikasi.">{{ $request->catatan_admin }}</textarea>
                            <small class="form-text text-muted">
                                📧 <strong>Penting:</strong> Catatan ini akan dikirim kepada pemasok melalui email otomatis.
                                <br>💡 <strong>Tips:</strong> Berikan informasi yang jelas dan berguna bagi pemasok.
                            </small>
                        </div>

                        @if($request->catatan_admin)
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Catatan Admin Sebelumnya:</h6>
                            <p class="mb-0">{{ $request->catatan_admin }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="text-center mt-4">
                        <a href="{{ route('admin.supplier.index') }}" class="btn btn-secondary btn-lg me-3">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                        <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Photo Preview -->
    @if($request->foto)
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModalLabel">
                        📸 Foto Bukti Eceng Gondok - {{ $request->nama }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset($request->foto) }}" class="img-fluid" alt="Foto Eceng Gondok" style="border-radius: 8px;">
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

    <!-- JavaScript -->
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
            // Konfirmasi perubahan status
            const statusSelect = document.getElementById('statusSelect');
            const originalStatus = statusSelect.value;

            statusSelect.addEventListener('change', function() {
                const newStatus = this.value;
                let message = '';

                switch(newStatus) {
                    case 'disetujui':
                        message = '✅ Menyetujui permintaan ini akan:\n\n' +
                                 '• Menambahkan stok bahan baku ke sistem\n' +
                                 '• Mengirim email konfirmasi kepada pemasok\n' +
                                 '• Mengaktifkan kupon diskon (jika dipilih)\n\n' +
                                 'Apakah Anda yakin ingin melanjutkan?';
                        break;
                    case 'ditolak':
                        message = '❌ Menolak permintaan ini akan:\n\n' +
                                 '• Membatalkan proses pasokan\n' +
                                 '• Mengirim email penolakan kepada pemasok\n' +
                                 '• Menghapus kupon yang sudah diberikan\n\n' +
                                 'Pastikan Anda memberikan catatan yang jelas!\n\n' +
                                 'Apakah Anda yakin ingin melanjutkan?';
                        break;
                }

                if (message && newStatus !== originalStatus) {
                    if (!confirm(message)) {
                        this.value = originalStatus;
                    }
                }
            });

            // Validasi form sebelum submit
            document.querySelector('form').addEventListener('submit', function(e) {
                const status = statusSelect.value;
                const catatan = document.querySelector('textarea[name="catatan_admin"]').value.trim();

                // Wajib ada catatan untuk penolakan
                if (status === 'ditolak' && !catatan) {
                    e.preventDefault();
                    alert('❗ Catatan admin wajib diisi ketika menolak permintaan!');
                    document.querySelector('textarea[name="catatan_admin"]').focus();
                    return false;
                }

                // Show loading state
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                submitBtn.disabled = true;
            });

            // Auto-save draft catatan
            const catatanTextarea = document.querySelector('textarea[name="catatan_admin"]');
            const requestId = {{ $request->id }};
            const draftKey = `catatan_draft_${requestId}`;

            // Load saved draft
            const savedDraft = localStorage.getItem(draftKey);
            if (savedDraft && !catatanTextarea.value.trim()) {
                catatanTextarea.value = savedDraft;
            }

            // Save draft on input
            catatanTextarea.addEventListener('input', function() {
                localStorage.setItem(draftKey, this.value);
            });

            // Clear draft on form submit
            document.querySelector('form').addEventListener('submit', function() {
                localStorage.removeItem(draftKey);
            });
        });
    </script>
@endsection

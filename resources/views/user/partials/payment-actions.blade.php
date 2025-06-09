<!-- Enhanced Payment Action Section -->
@if ($transaction->status == 'pending')
    <div class="order-card fade-in payment-section">
        <div class="card-header" style="background: linear-gradient(135deg, #FF851B, #FFB74D);">
            <h5><i class="fas fa-credit-card"></i>Lanjutkan Pembayaran</h5>
        </div>
        <div class="card-body">
            @if ($transaction->snap_token)
                <!-- Midtrans Payment -->
                <div class="alert alert-info">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle fa-3x me-4 text-primary"></i>
                        <div>
                            <h6 class="mb-2 fw-bold">Menunggu Pembayaran</h6>
                            <p class="mb-0">Pesanan Anda belum dibayar. Silakan lanjutkan pembayaran dengan Midtrans untuk memproses pesanan.</p>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Payment Countdown -->
                <div class="alert alert-warning mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-2 fw-bold">
                                <i class="fas fa-clock me-2 text-warning"></i>
                                Batas Waktu Pembayaran
                            </h6>
                            <p class="mb-0">Selesaikan pembayaran sebelum waktu habis untuk menghindari pembatalan otomatis</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="countdown-display" id="payment-countdown-detail"
                                style="font-size: 1.75rem; font-weight: 700; font-family: 'Courier New', monospace;
                                       color: #FF851B; background: rgba(255, 255, 255, 0.9); padding: 1rem;
                                       border-radius: 12px; border: 2px solid #FFB74D; box-shadow: 0 4px 12px rgba(255, 133, 27, 0.2);">
                                23:59:59
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-3">
                    <button id="pay-button-detail" class="btn btn-primary btn-lg" style="background: linear-gradient(135deg, #8B5A3C, #A67C5A); border: none; padding: 1.25rem;">
                        <i class="fas fa-credit-card me-2"></i>Bayar Sekarang dengan Midtrans
                    </button>
                    <button onclick="refreshPaymentStatus()" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-sync me-2"></i>Refresh Status Pembayaran
                    </button>
                </div>
            @elseif ($transaction->mode == 'manual_atm' || $transaction->bank_code)
                <!-- Enhanced Manual Bank Transfer -->
                <div class="alert alert-info mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-university fa-3x me-4 text-primary"></i>
                        <div>
                            <h6 class="mb-2 fw-bold">Pembayaran Manual Bank Transfer</h6>
                            <p class="mb-0">Silakan lakukan transfer ke rekening bank dan upload bukti pembayaran untuk verifikasi.</p>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Bank Account Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-0" style="border: 3px solid #8B5A3C !important; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 24px rgba(139, 90, 60, 0.15);">
                            <div class="card-header text-white" style="background: linear-gradient(135deg, #8B5A3C, #A67C5A); padding: 1.5rem;">
                                <h6 class="mb-0 fw-bold">
                                    <i class="fas fa-university me-2" style="color: #D4A574;"></i>
                                    Informasi Rekening Bank BNI
                                </h6>
                            </div>
                            <div class="card-body" style="background: #FDFCFA; padding: 2rem;">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <td class="fw-bold" style="color: #5D4E3A;">Bank:</td>
                                        <td style="color: #3C2E26; font-weight: 600;">Bank BNI</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold" style="color: #5D4E3A;">No. Rekening:</td>
                                        <td style="color: #3C2E26; font-weight: 600; font-family: 'Courier New', monospace; font-size: 1.1rem;">1234567890</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold" style="color: #5D4E3A;">Atas Nama:</td>
                                        <td style="color: #3C2E26; font-weight: 600;">Bank Koperasi Eceng Gondok</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold" style="color: #5D4E3A;">Jumlah Transfer:</td>
                                        <td class="fw-bold" style="color: #FF4136; font-size: 1.375rem; font-family: 'Courier New', monospace;">
                                            Rp {{ number_format($transaction->order->total) }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-warning" style="border: 2px solid #FF851B; border-radius: 16px; background: linear-gradient(135deg, #FFF8E1, #FFECB3);">
                            <h6 class="fw-bold" style="color: #E65100;">
                                <i class="fas fa-exclamation-triangle me-2"></i>Petunjuk Transfer:
                            </h6>
                            <ol class="mb-0" style="color: #BF360C; line-height: 1.6;">
                                <li>Transfer <strong>tepat</strong> sesuai jumlah yang tertera</li>
                                <li>Simpan bukti transfer</li>
                                <li>Upload bukti transfer di form di bawah</li>
                                <li>Tunggu konfirmasi dari admin (1x24 jam)</li>
                            </ol>
                        </div>
                    </div>
                </div>

                @if ($transaction->payment_proof)
                    <!-- Enhanced Payment Proof Already Uploaded -->
                    <div class="alert alert-success mb-4" style="border: 2px solid #2ECC40; border-radius: 16px; background: linear-gradient(135deg, #E8F5E8, #D4F4D4);">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fa-3x me-4" style="color: #2ECC40;"></i>
                            <div class="flex-grow-1">
                                <h6 class="mb-2 fw-bold" style="color: #1B5E20;">Bukti Pembayaran Sudah Diupload</h6>
                                <p class="mb-0" style="color: #2E7D32;">Bukti pembayaran Anda sedang dalam proses verifikasi oleh admin.</p>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0" style="border: 3px solid #2ECC40 !important; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 24px rgba(46, 204, 64, 0.15);">
                        <div class="card-header text-white" style="background: linear-gradient(135deg, #2ECC40, #4CAF50); padding: 1.5rem;">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-file-image me-2" style="color: #C8E6C9;"></i>
                                Detail Upload
                            </h6>
                        </div>
                        <div class="card-body" style="background: #FDFCFA; padding: 2rem;">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong style="color: #5D4E3A;">Status Verifikasi:</strong>
                                        <span class="badge" style="background: linear-gradient(135deg, #FF851B, #FFB74D); color: white; padding: 0.5rem 1rem; border-radius: 20px;">
                                            <i class="fas fa-clock me-1"></i>Menunggu Verifikasi
                                        </span>
                                    </p>
                                    <p><strong style="color: #5D4E3A;">Tanggal Upload:</strong>
                                        <span style="color: #3C2E26;">{{ $transaction->updated_at->format('d M Y, H:i') }} WIB</span>
                                    </p>
                                    <p><strong style="color: #5D4E3A;">Estimasi Verifikasi:</strong> <span style="color: #3C2E26;">1x24 jam</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong style="color: #5D4E3A;">File Bukti:</strong></p>
                                    <a href="{{ asset('storage/' . $transaction->payment_proof) }}" target="_blank"
                                        class="btn btn-outline-primary" style="border: 2px solid #8B5A3C; color: #8B5A3C; padding: 0.75rem 1.5rem; border-radius: 12px;">
                                        <i class="fas fa-eye me-2"></i>Lihat Bukti Pembayaran
                                    </a>
                                </div>
                            </div>

                            <!-- Enhanced Re-upload Option -->
                            <div class="border-top pt-4 mt-4" style="border-color: #E5DDD4 !important; border-width: 2px !important; border-style: dashed !important;">
                                <button type="button" class="btn btn-outline-secondary" id="reupload-toggle"
                                        style="border: 2px solid #8B7355; color: #8B7355; padding: 0.625rem 1.25rem; border-radius: 12px;">
                                    <i class="fas fa-upload me-2"></i>Upload Ulang Bukti Pembayaran
                                </button>

                                <div id="reupload-form" style="display: none;" class="mt-4">
                                    <div class="card" style="border: 2px solid #E5DDD4; border-radius: 16px; background: #FAF7F2;">
                                        <div class="card-body" style="padding: 2rem;">
                                            <form action="{{ route('upload.payment.proof') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="order_id"
                                                    value="{{ $transaction->order->id }}">

                                                <div class="mb-4">
                                                    <label for="payment_proof_reupload" class="form-label fw-bold" style="color: #5D4E3A;">
                                                        <i class="fas fa-upload me-2" style="color: #8B5A3C;"></i>Upload Bukti Pembayaran Baru
                                                    </label>
                                                    <input type="file" class="form-control"
                                                        id="payment_proof_reupload" name="payment_proof"
                                                        accept="image/*,.pdf" required
                                                        style="border: 2px solid #E5DDD4; border-radius: 12px; padding: 1rem;">
                                                    <div class="form-text" style="color: #8B7355;">
                                                        Format yang diterima: JPG, PNG, PDF (maksimal 2MB)
                                                    </div>
                                                </div>

                                                <div class="d-flex gap-3">
                                                    <button type="submit" class="btn btn-warning"
                                                            style="background: linear-gradient(135deg, #FF851B, #FFB74D); border: none; padding: 0.875rem 1.5rem; border-radius: 12px;">
                                                        <i class="fas fa-upload me-2"></i>Upload Ulang
                                                    </button>
                                                    <button type="button" class="btn btn-secondary"
                                                        id="cancel-reupload"
                                                        style="background: linear-gradient(135deg, #8B7355, #A8927B); border: none; padding: 0.875rem 1.5rem; border-radius: 12px;">
                                                        Batal
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Enhanced Upload Payment Proof Form -->
                    <div class="card border-0" style="border: 3px solid #FF851B !important; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 24px rgba(255, 133, 27, 0.15);">
                        <div class="card-header text-white" style="background: linear-gradient(135deg, #FF851B, #FFB74D); padding: 1.5rem;">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-upload me-2" style="color: #FFF3E0;"></i>
                                Upload Bukti Pembayaran
                            </h6>
                        </div>
                        <div class="card-body" style="background: #FDFCFA; padding: 2rem;">
                            <form action="{{ route('upload.payment.proof') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $transaction->order->id }}">

                                <div class="mb-4">
                                    <label for="payment_proof" class="form-label fw-bold" style="color: #5D4E3A;">
                                        <i class="fas fa-file-image me-2" style="color: #8B5A3C;"></i>Pilih File Bukti Pembayaran
                                    </label>
                                    <input type="file" class="form-control" id="payment_proof"
                                        name="payment_proof" accept="image/*,.pdf" required
                                        style="border: 2px solid #E5DDD4; border-radius: 12px; padding: 1rem; background: white;">
                                    <div class="form-text" style="color: #8B7355;">
                                        Format yang diterima: JPG, PNG, PDF (maksimal 2MB)
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success btn-lg"
                                            style="background: linear-gradient(135deg, #2ECC40, #4CAF50); border: none; padding: 1.25rem; border-radius: 12px;">
                                        <i class="fas fa-upload me-2"></i>Upload Bukti Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@elseif (in_array($transaction->status, ['approved', 'paid']))
    <!-- Enhanced Payment Success -->
    <div class="order-card fade-in">
        <div class="card-header" style="background: linear-gradient(135deg, #2ECC40, #4CAF50);">
            <h5><i class="fas fa-check-circle" style="color: #C8E6C9;"></i>Status Pembayaran</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-success mb-4" style="border: 2px solid #2ECC40; border-radius: 16px; background: linear-gradient(135deg, #E8F5E8, #D4F4D4);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-4x me-4" style="color: #2ECC40;"></i>
                    <div>
                        <h5 class="mb-3 fw-bold" style="color: #1B5E20;">Pembayaran Berhasil!</h5>
                        <p class="mb-0 fs-6" style="color: #2E7D32;">Terima kasih! Pembayaran Anda telah dikonfirmasi dan pesanan sedang diproses dengan baik.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card border-0" style="border: 2px solid #2ECC40 !important; border-radius: 16px; background: #FDFCFA;">
                        <div class="card-body" style="padding: 2rem;">
                            <h6 class="mb-4 fw-bold" style="color: #2ECC40;">
                                <i class="fas fa-info-circle me-2"></i>Detail Pembayaran
                            </h6>
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold" style="color: #5D4E3A;">Metode Pembayaran:</td>
                                    <td style="color: #3C2E26; font-weight: 600;">{{ $transaction->mode_display ?? ucfirst($transaction->mode) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="color: #5D4E3A;">Status:</td>
                                    <td>
                                        <span class="badge" style="background: linear-gradient(135deg, #2ECC40, #4CAF50); color: white; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">
                                            <i class="fas fa-check-circle me-1"></i>Lunas
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="color: #5D4E3A;">Total Dibayar:</td>
                                    <td class="fw-bold" style="color: #2ECC40; font-size: 1.125rem;">Rp {{ number_format($transaction->order->total) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="color: #5D4E3A;">Tanggal Pembayaran:</td>
                                    <td style="color: #3C2E26; font-weight: 600;">{{ $transaction->updated_at->format('d M Y, H:i') }} WIB</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="alert alert-info" style="border: 2px solid #0074D9; border-radius: 16px; background: linear-gradient(135deg, #E3F2FD, #BBDEFB);">
                        <h6 class="fw-bold" style="color: #0D47A1;">
                            <i class="fas fa-lightbulb me-2"></i>Langkah Selanjutnya:
                        </h6>
                        <ul class="mb-0" style="color: #1565C0; line-height: 1.6;">
                            <li>Pesanan Anda akan segera diproses</li>
                            <li>Anda akan mendapat notifikasi saat pesanan dikirim</li>
                            <li>Lacak status pesanan di halaman ini</li>
                            <li>Konfirmasi penerimaan setelah barang sampai</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif (in_array($transaction->status, ['declined', 'failed']))
    <!-- Enhanced Payment Failed -->
    <div class="order-card fade-in">
        <div class="card-header" style="background: linear-gradient(135deg, #FF4136, #EF5350);">
            <h5><i class="fas fa-times-circle" style="color: #FFCDD2;"></i>Status Pembayaran</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-danger mb-4" style="border: 2px solid #FF4136; border-radius: 16px; background: linear-gradient(135deg, #FFEBEE, #FFCDD2);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-times-circle fa-4x me-4" style="color: #FF4136;"></i>
                    <div>
                        <h5 class="mb-3 fw-bold" style="color: #B71C1C;">Pembayaran Gagal</h5>
                        <p class="mb-0" style="color: #C62828;">Pembayaran tidak dapat diproses. Silakan coba lagi atau hubungi customer service untuk bantuan.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="alert alert-warning" style="border: 2px solid #FF851B; border-radius: 16px; background: linear-gradient(135deg, #FFF8E1, #FFECB3);">
                        <h6 class="fw-bold" style="color: #E65100;">
                            <i class="fas fa-exclamation-triangle me-2"></i>Kemungkinan Penyebab:
                        </h6>
                        <ul class="mb-0" style="color: #BF360C; line-height: 1.6;">
                            <li>Saldo tidak mencukupi</li>
                            <li>Kartu/akun diblokir</li>
                            <li>Koneksi internet terputus</li>
                            <li>Batas waktu pembayaran habis</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-grid gap-3">
                        <a href="{{ route('user.account.orders') }}" class="btn btn-outline-primary"
                           style="border: 2px solid #8B5A3C; color: #8B5A3C; padding: 0.875rem; border-radius: 12px;">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Pesanan
                        </a>
                        <a href="{{ route('home.contact.index') }}" class="btn btn-warning"
                           style="background: linear-gradient(135deg, #FF851B, #FFB74D); border: none; padding: 0.875rem; border-radius: 12px;">
                            <i class="fas fa-headset me-2"></i>Hubungi Customer Service
                        </a>
                        @if ($transaction->snap_token && !$transaction->isSnapTokenExpired())
                            <button onclick="retryPayment()" class="btn btn-primary"
                                    style="background: linear-gradient(135deg, #8B5A3C, #A67C5A); border: none; padding: 0.875rem; border-radius: 12px;">
                                <i class="fas fa-redo me-2"></i>Coba Bayar Lagi
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<style>
    /* Additional enhanced styling */
    .payment-section {
        position: relative;
        overflow: hidden;
    }

    .payment-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1), transparent);
        pointer-events: none;
    }

    .countdown-display {
        position: relative;
        animation: countdownPulse 2s infinite ease-in-out;
    }

    @keyframes countdownPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Enhanced form styling */
    .form-control:focus {
        border-color: #8B5A3C;
        box-shadow: 0 0 0 3px rgba(139, 90, 60, 0.1);
        background: #FDFCFA;
    }

    /* Button hover effects */
    .btn:hover {
        transform: translateY(-3px) scale(1.02);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Enhanced alert styling */
    .alert {
        position: relative;
        overflow: hidden;
    }

    .alert::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: currentColor;
        opacity: 0.3;
    }

    /* Enhanced table styling */
    .table td, .table th {
        border: none;
        padding: 1rem 0;
    }

    .table tr:not(:last-child) td {
        border-bottom: 1px dashed #E5DDD4;
    }

    /* Enhanced badge styling */
    .badge {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* Card hover effects */
    .card:hover {
        transform: translateY(-2px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Enhanced file input styling */
    .form-control[type="file"] {
        position: relative;
        cursor: pointer;
    }

    .form-control[type="file"]:hover {
        border-color: #8B5A3C;
        background: #FAF7F2;
    }

    /* Progress bar enhancement */
    .progress {
        height: 8px;
        border-radius: 4px;
        background: rgba(139, 90, 60, 0.1);
    }

    .progress-bar {
        background: linear-gradient(90deg, #8B5A3C, #A67C5A);
        border-radius: 4px;
    }

    /* Enhanced link styling */
    a {
        color: #8B5A3C;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    /* a:hover {
        color: #A67C5A;
        text-decoration: underline;
    } */
</style>

<script>
    // Enhanced reupload toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const reuploadToggle = document.getElementById('reupload-toggle');
        const reuploadForm = document.getElementById('reupload-form');
        const cancelReupload = document.getElementById('cancel-reupload');

        if (reuploadToggle && reuploadForm) {
            reuploadToggle.addEventListener('click', function() {
                reuploadForm.style.display = 'block';
                reuploadToggle.style.display = 'none';
                // Smooth animation
                reuploadForm.style.opacity = '0';
                reuploadForm.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    reuploadForm.style.transition = 'all 0.3s ease';
                    reuploadForm.style.opacity = '1';
                    reuploadForm.style.transform = 'translateY(0)';
                }, 10);
            });
        }

        if (cancelReupload && reuploadForm && reuploadToggle) {
            cancelReupload.addEventListener('click', function() {
                reuploadForm.style.opacity = '0';
                reuploadForm.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    reuploadForm.style.display = 'none';
                    reuploadToggle.style.display = 'inline-block';
                    reuploadForm.querySelector('form').reset();
                }, 300);
            });
        }

        // Enhanced file input preview
        const fileInputs = document.querySelectorAll('input[type="file"]');
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const fileName = this.files[0]?.name;
                if (fileName) {
                    // Create preview element
                    let preview = this.parentNode.querySelector('.file-preview');
                    if (!preview) {
                        preview = document.createElement('div');
                        preview.className = 'file-preview mt-2 p-2 bg-light rounded';
                        this.parentNode.appendChild(preview);
                    }
                    preview.innerHTML = `<i class="fas fa-file me-2"></i>${fileName}`;
                    preview.style.color = '#5D4E3A';
                    preview.style.fontSize = '0.875rem';
                }
            });
        });
    });

    // Enhanced refresh payment status with better UX
    function refreshPaymentStatus() {
        Swal.fire({
            title: 'Memeriksa Status Pembayaran...',
            html: `
                <div class="text-center">
                    <div class="spinner-border mb-3" style="color: #8B5A3C;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p style="color: #5D4E3A;">Menghubungi server pembayaran...</p>
                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                             style="width: 100%; background: linear-gradient(90deg, #8B5A3C, #A67C5A);"></div>
                    </div>
                </div>
            `,
            allowOutsideClick: false,
            showConfirmButton: false,
            customClass: {
                popup: 'rounded-lg border-0',
                title: 'fw-bold'
            }
        });

        fetch('{{ route("auto.check.payment.status") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    transaction_id: {{ $transaction->id }}
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'approved' || data.status === 'paid') {
                    Swal.fire({
                        title: 'Pembayaran Berhasil!',
                        html: `
                            <div class="text-center">
                                <i class="fas fa-check-circle fa-4x mb-3" style="color: #2ECC40;"></i>
                                <p style="color: #2E7D32;">Pembayaran Anda telah dikonfirmasi!</p>
                            </div>
                        `,
                        icon: 'success',
                        confirmButtonText: 'Lihat Status Terbaru',
                        confirmButtonColor: '#2ECC40',
                        customClass: {
                            popup: 'rounded-lg border-0'
                        }
                    }).then(() => {
                        window.location.reload();
                    });
                } else if (data.status === 'declined' || data.status === 'failed') {
                    Swal.fire({
                        title: 'Pembayaran Ditolak',
                        html: `
                            <div class="text-center">
                                <i class="fas fa-times-circle fa-3x mb-3" style="color: #FF4136;"></i>
                                <p style="color: #C62828;">Pembayaran Anda ditolak oleh sistem.</p>
                            </div>
                        `,
                        icon: 'error',
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#FF4136',
                        customClass: {
                            popup: 'rounded-lg border-0'
                        }
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Status Belum Berubah',
                        html: `
                            <div class="text-center">
                                <i class="fas fa-hourglass-half fa-3x mb-3" style="color: #FF851B;"></i>
                                <p style="color: #E65100;">Pembayaran masih dalam proses verifikasi.</p>
                                <p class="text-muted">Mohon tunggu beberapa saat dan coba lagi.</p>
                            </div>
                        `,
                        icon: 'info',
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#0074D9',
                        customClass: {
                            popup: 'rounded-lg border-0'
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Gagal Memeriksa Status',
                    html: `
                        <div class="text-center">
                            <i class="fas fa-exclamation-triangle fa-3x mb-3" style="color: #FF851B;"></i>
                            <p style="color: #E65100;">Terjadi kesalahan saat memeriksa status pembayaran.</p>
                            <p class="text-muted">Silakan coba lagi nanti atau hubungi customer service.</p>
                        </div>
                    `,
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonText: 'Coba Lagi',
                    confirmButtonColor: '#0074D9',
                    cancelButtonText: 'Hubungi CS',
                    cancelButtonColor: '#8B7355',
                    customClass: {
                        popup: 'rounded-lg border-0'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        setTimeout(() => refreshPaymentStatus(), 1000);
                    } else if (result.isDismissed) {
                        window.open('{{ route("home.contact.index") }}', '_blank');
                    }
                });
            });
    }

    // Enhanced retry payment function
    function retryPayment() {
        const payButton = document.getElementById('pay-button-detail');
        if (payButton) {
            payButton.click();
        }
    }

    // Enhanced payment countdown timer with better visual feedback
    document.addEventListener('DOMContentLoaded', function() {
        const countdownElement = document.getElementById('payment-countdown-detail');
        if (countdownElement) {
            const createdAt = new Date('{{ $transaction->created_at }}');
            const deadline = new Date(createdAt.getTime() + (24 * 60 * 60 * 1000)); // 24 hours

            function updateCountdown() {
                const now = new Date();
                const timeLeft = deadline - now;

                if (timeLeft <= 0) {
                    countdownElement.textContent = '00:00:00';
                    countdownElement.style.color = '#FF4136';
                    countdownElement.style.background = 'rgba(255, 65, 54, 0.1)';
                    countdownElement.style.borderColor = '#FF4136';

                    // Disable pay button if exists
                    const payButton = document.getElementById('pay-button-detail');
                    if (payButton) {
                        payButton.disabled = true;
                        payButton.innerHTML = '<i class="fas fa-times me-2"></i>Waktu Pembayaran Habis';
                        payButton.style.background = 'linear-gradient(135deg, #8B7355, #A8927B)';
                        payButton.style.cursor = 'not-allowed';
                    }
                    return;
                }

                const hours = Math.floor(timeLeft / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                countdownElement.textContent =
                    `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                // Change color when less than 1 hour
                if (timeLeft < 3600000) {
                    countdownElement.style.color = '#FF4136';
                    countdownElement.style.background = 'rgba(255, 65, 54, 0.1)';
                    countdownElement.style.borderColor = '#FF4136';
                    countdownElement.style.animation = 'countdownUrgent 1s infinite';
                }
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        }
    });
</script>

<style>
    @keyframes countdownUrgent {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
</style>

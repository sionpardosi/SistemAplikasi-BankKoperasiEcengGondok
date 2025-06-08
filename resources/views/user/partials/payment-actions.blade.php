<!-- Payment Action Section -->
@if ($transaction->status == 'pending')
    <div class="order-card fade-in payment-section">
        <div class="card-header bg-warning">
            <h5><i class="fas fa-credit-card me-2"></i>Lanjutkan Pembayaran</h5>
        </div>
        <div class="card-body">
            @if ($transaction->snap_token)
                <!-- Midtrans Payment -->
                <div class="alert alert-info">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle fa-2x me-3"></i>
                        <div>
                            <h6 class="mb-1"><strong>Menunggu Pembayaran</strong></h6>
                            <p class="mb-0">Pesanan Anda belum dibayar. Silakan lanjutkan pembayaran dengan Midtrans.</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Countdown -->
                <div class="alert alert-warning mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-1">
                                <i class="fas fa-clock me-2"></i>
                                <strong>Batas Waktu Pembayaran</strong>
                            </h6>
                            <p class="mb-0">Selesaikan pembayaran sebelum waktu habis</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="countdown-display" id="payment-countdown-detail"
                                style="font-size: 1.5rem; font-weight: bold; font-family: 'Courier New', monospace; color: #856404;">
                                23:59:59
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button id="pay-button-detail" class="btn btn-primary btn-lg">
                        <i class="fas fa-credit-card me-2"></i>Bayar Sekarang dengan Midtrans
                    </button>
                    <button onclick="refreshPaymentStatus()" class="btn btn-outline-secondary">
                        <i class="fas fa-sync me-2"></i>Refresh Status Pembayaran
                    </button>
                </div>

            @elseif ($transaction->mode == 'manual_atm' || $transaction->bank_code)
                <!-- Manual Bank Transfer -->
                <div class="alert alert-info">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-university fa-2x me-3"></i>
                        <div>
                            <h6 class="mb-1"><strong>Pembayaran Manual Bank Transfer</strong></h6>
                            <p class="mb-0">Silakan lakukan transfer ke rekening bank dan upload bukti pembayaran.</p>
                        </div>
                    </div>
                </div>

                <!-- Bank Account Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-university me-2"></i>
                                    Informasi Rekening Bank BNI
                                </h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <td class="fw-bold">Bank:</td>
                                        <td>Bank BNI</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">No. Rekening:</td>
                                        <td>1234567890</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Atas Nama:</td>
                                        <td>Bank Koperasi Eceng Gondok</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Jumlah Transfer:</td>
                                        <td class="text-danger fw-bold fs-5">
                                            Rp {{ number_format($transaction->order->total) }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Petunjuk Transfer:</h6>
                            <ol class="mb-0">
                                <li>Transfer <strong>tepat</strong> sesuai jumlah yang tertera</li>
                                <li>Simpan bukti transfer</li>
                                <li>Upload bukti transfer di form below</li>
                                <li>Tunggu konfirmasi dari admin (1x24 jam)</li>
                            </ol>
                        </div>
                    </div>
                </div>

                @if ($transaction->payment_proof)
                    <!-- Payment Proof Already Uploaded -->
                    <div class="alert alert-success">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fa-2x text-success me-3"></i>
                            <div class="flex-grow-1">
                                <h6 class="mb-1"><strong>Bukti Pembayaran Sudah Diupload</strong></h6>
                                <p class="mb-0">Bukti pembayaran Anda sedang dalam proses verifikasi oleh admin.</p>
                            </div>
                        </div>
                    </div>

                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-file-image me-2"></i>
                                Detail Upload
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Status Verifikasi:</strong>
                                        <span class="badge bg-warning">Menunggu Verifikasi</span>
                                    </p>
                                    <p><strong>Tanggal Upload:</strong>
                                        {{ $transaction->updated_at->format('d M Y, H:i') }} WIB
                                    </p>
                                    <p><strong>Estimasi Verifikasi:</strong> 1x24 jam</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>File Bukti:</strong></p>
                                    <a href="{{ asset('storage/' . $transaction->payment_proof) }}"
                                        target="_blank" class="btn btn-outline-primary">
                                        <i class="fas fa-eye me-2"></i>Lihat Bukti Pembayaran
                                    </a>
                                </div>
                            </div>

                            <!-- Option to Re-upload -->
                            <div class="border-top pt-3 mt-3">
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="reupload-toggle">
                                    <i class="fas fa-upload me-2"></i>Upload Ulang Bukti Pembayaran
                                </button>

                                <div id="reupload-form" style="display: none;" class="mt-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="{{ route('upload.payment.proof') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $transaction->order->id }}">

                                                <div class="mb-3">
                                                    <label for="payment_proof_reupload" class="form-label fw-bold">
                                                        <i class="fas fa-upload me-2"></i>Upload Bukti Pembayaran Baru
                                                    </label>
                                                    <input type="file" class="form-control" id="payment_proof_reupload"
                                                        name="payment_proof" accept="image/*,.pdf" required>
                                                    <div class="form-text">
                                                        Format yang diterima: JPG, PNG, PDF (maksimal 2MB)
                                                    </div>
                                                </div>

                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-warning">
                                                        <i class="fas fa-upload me-2"></i>Upload Ulang
                                                    </button>
                                                    <button type="button" class="btn btn-secondary" id="cancel-reupload">
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
                    <!-- Upload Payment Proof Form -->
                    <div class="card border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0">
                                <i class="fas fa-upload me-2"></i>
                                Upload Bukti Pembayaran
                            </h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('upload.payment.proof') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $transaction->order->id }}">

                                <div class="mb-3">
                                    <label for="payment_proof" class="form-label fw-bold">
                                        <i class="fas fa-file-image me-2"></i>Pilih File Bukti Pembayaran
                                    </label>
                                    <input type="file" class="form-control" id="payment_proof"
                                        name="payment_proof" accept="image/*,.pdf" required>
                                    <div class="form-text">
                                        Format yang diterima: JPG, PNG, PDF (maksimal 2MB)
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success btn-lg">
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
    <!-- Payment Success -->
    <div class="order-card fade-in">
        <div class="card-header bg-success">
            <h5><i class="fas fa-check-circle me-2"></i>Status Pembayaran</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-success">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-3x text-success me-4"></i>
                    <div>
                        <h5 class="mb-2"><strong>Pembayaran Berhasil!</strong></h5>
                        <p class="mb-0">Terima kasih! Pembayaran Anda telah dikonfirmasi dan pesanan sedang diproses.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card border-success">
                        <div class="card-body">
                            <h6 class="text-success mb-3">
                                <i class="fas fa-info-circle me-2"></i>Detail Pembayaran
                            </h6>
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold">Metode Pembayaran:</td>
                                    <td>{{ $transaction->mode_display ?? ucfirst($transaction->mode) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status:</td>
                                    <td><span class="badge bg-success">Lunas</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Total Dibayar:</td>
                                    <td class="fw-bold">Rp {{ number_format($transaction->order->total) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal Pembayaran:</td>
                                    <td>{{ $transaction->updated_at->format('d M Y, H:i') }} WIB</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-lightbulb me-2"></i>Langkah Selanjutnya:</h6>
                        <ul class="mb-0">
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
    <!-- Payment Failed -->
    <div class="order-card fade-in">
        <div class="card-header bg-danger">
            <h5><i class="fas fa-times-circle me-2"></i>Status Pembayaran</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-danger">
                <div class="d-flex align-items-center">
                    <i class="fas fa-times-circle fa-3x text-danger me-4"></i>
                    <div>
                        <h5 class="mb-2"><strong>Pembayaran Gagal</strong></h5>
                        <p class="mb-0">Pembayaran tidak dapat diproses. Silakan coba lagi atau hubungi customer service.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Kemungkinan Penyebab:</h6>
                        <ul class="mb-0">
                            <li>Saldo tidak mencukupi</li>
                            <li>Kartu/akun diblokir</li>
                            <li>Koneksi internet terputus</li>
                            <li>Batas waktu pembayaran habis</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-grid gap-2">
                        <a href="{{ route('user.account.orders') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Pesanan
                        </a>
                        <a href="{{ route('home.contact.index') }}" class="btn btn-warning">
                            <i class="fas fa-headset me-2"></i>Hubungi Customer Service
                        </a>
                        @if($transaction->snap_token && !$transaction->isSnapTokenExpired())
                            <button onclick="retryPayment()" class="btn btn-primary">
                                <i class="fas fa-redo me-2"></i>Coba Bayar Lagi
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
// Reupload toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const reuploadToggle = document.getElementById('reupload-toggle');
    const reuploadForm = document.getElementById('reupload-form');
    const cancelReupload = document.getElementById('cancel-reupload');

    if (reuploadToggle && reuploadForm) {
        reuploadToggle.addEventListener('click', function() {
            reuploadForm.style.display = 'block';
            reuploadToggle.style.display = 'none';
        });
    }

    if (cancelReupload && reuploadForm && reuploadToggle) {
        cancelReupload.addEventListener('click', function() {
            reuploadForm.style.display = 'none';
            reuploadToggle.style.display = 'inline-block';
            reuploadForm.querySelector('form').reset();
        });
    }
});

// Refresh payment status
function refreshPaymentStatus() {
    Swal.fire({
        title: 'Memeriksa Status Pembayaran...',
        text: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
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
        Swal.close();

        if (data.status === 'approved' || data.status === 'paid') {
            Swal.fire({
                title: 'Pembayaran Berhasil!',
                text: 'Pembayaran Anda telah dikonfirmasi',
                icon: 'success'
            }).then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire({
                title: 'Status Belum Berubah',
                text: 'Pembayaran masih dalam proses. Silakan coba lagi nanti.',
                icon: 'info'
            });
        }
    })
    .catch(error => {
        Swal.close();
        Swal.fire({
            title: 'Error',
            text: 'Gagal memeriksa status pembayaran',
            icon: 'error'
        });
    });
}

// Retry payment function
function retryPayment() {
    const payButton = document.getElementById('pay-button-detail');
    if (payButton) {
        payButton.click();
    }
}

// Payment countdown timer
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
                countdownElement.style.color = '#dc3545';

                // Disable pay button if exists
                const payButton = document.getElementById('pay-button-detail');
                if (payButton) {
                    payButton.disabled = true;
                    payButton.innerHTML = '<i class="fas fa-times me-2"></i>Waktu Pembayaran Habis';
                    payButton.classList.remove('btn-primary');
                    payButton.classList.add('btn-secondary');
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
                countdownElement.style.color = '#dc3545';
            }
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    }
});
</script>

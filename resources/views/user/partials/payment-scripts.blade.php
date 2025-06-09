<!-- Enhanced Midtrans Payment Scripts -->
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('pay-button-detail');
        if (payButton) {
            payButton.addEventListener('click', function() {
                let paymentProcessed = false;

                // Enhanced loading state with brown theme
                Swal.fire({
                    title: 'Memuat Gateway Pembayaran...',
                    html: `
                        <div class="text-center">
                            <div class="payment-loader mb-3">
                                <div class="spinner-border" style="color: #8B5A3C; width: 3rem; height: 3rem;" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <p style="color: #5D4E3A;">Menghubungkan ke sistem pembayaran yang aman...</p>
                            <div class="progress mt-3" style="height: 8px; background: rgba(139, 90, 60, 0.1);">
                                <div class="progress-bar progress-bar-striped progress-bar-animated"
                                     style="background: linear-gradient(90deg, #8B5A3C, #A67C5A); width: 100%;"></div>
                            </div>
                        </div>
                    `,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-lg border-0 shadow-lg',
                        title: 'fw-bold',
                        htmlContainer: 'text-center'
                    },
                    background: '#FDFCFA',
                    color: '#3C2E26'
                });

                // Enhanced delay with smooth transition
                setTimeout(() => {
                    Swal.close();

                    snap.pay('{{ $transaction->snap_token }}', {
                        onSuccess: function(result) {
                            console.log("Payment Success", result);
                            paymentProcessed = true;

                            Swal.fire({
                                title: 'Memverifikasi Pembayaran...',
                                html: `
                                    <div class="text-center">
                                        <div class="verification-animation mb-3">
                                            <i class="fas fa-shield-alt fa-3x" style="color: #2ECC40; animation: verificationPulse 1.5s infinite;"></i>
                                        </div>
                                        <p style="color: #2E7D32;">Sedang memverifikasi pembayaran Anda secara real-time.</p>
                                        <p class="text-muted">Proses ini biasanya memakan waktu beberapa detik.</p>
                                        <div class="mt-3">
                                            <div class="progress" style="height: 6px; background: rgba(46, 204, 64, 0.1);">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                     style="background: linear-gradient(90deg, #2ECC40, #4CAF50); width: 100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                `,
                                icon: 'info',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                customClass: {
                                    popup: 'rounded-lg border-0 shadow-lg',
                                    title: 'fw-bold text-success'
                                },
                                background: '#FDFCFA'
                            });

                            // Auto-check payment status
                            checkPaymentStatus();
                        },

                        onPending: function(result) {
                            console.log("Payment Pending", result);
                            paymentProcessed = true;

                            Swal.fire({
                                title: 'Pembayaran Sedang Diproses',
                                html: `
                                    <div class="text-center">
                                        <div class="pending-animation mb-4">
                                            <i class="fas fa-clock fa-4x mb-3" style="color: #FF851B; animation: pendingClock 2s infinite;"></i>
                                        </div>
                                        <h6 class="mb-3" style="color: #E65100;">Status: Menunggu Konfirmasi</h6>
                                        <p style="color: #BF360C;">Pembayaran Anda sedang dalam proses verifikasi oleh sistem.</p>
                                        <div class="alert alert-info mt-3" style="background: rgba(0, 116, 217, 0.1); border: 1px solid #0074D9; border-radius: 12px;">
                                            <small style="color: #0D47A1;">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Kami akan memperbarui status pembayaran secara otomatis dalam beberapa menit.
                                            </small>
                                        </div>
                                    </div>
                                `,
                                icon: 'info',
                                confirmButtonText: 'Mengerti',
                                confirmButtonColor: '#FF851B',
                                customClass: {
                                    popup: 'rounded-lg border-0 shadow-lg',
                                    title: 'fw-bold'
                                },
                                background: '#FDFCFA'
                            }).then(() => {
                                checkPaymentStatus();
                            });
                        },

                        onError: function(result) {
                            console.log("Payment Error", result);
                            paymentProcessed = true;

                            Swal.fire({
                                title: 'Pembayaran Gagal',
                                html: `
                                    <div class="text-center">
                                        <div class="error-animation mb-4">
                                            <i class="fas fa-times-circle fa-4x mb-3" style="color: #FF4136; animation: errorShake 0.5s infinite;"></i>
                                        </div>
                                        <h6 class="mb-3" style="color: #B71C1C;">Terjadi Kesalahan Pembayaran</h6>
                                        <p style="color: #C62828;">Maaf, terjadi kesalahan saat memproses pembayaran Anda.</p>
                                        <div class="alert alert-warning mt-3" style="background: rgba(255, 133, 27, 0.1); border: 1px solid #FF851B; border-radius: 12px;">
                                            <small style="color: #E65100;">
                                                <i class="fas fa-lightbulb me-1"></i>
                                                Silakan coba lagi dalam beberapa saat atau hubungi customer service kami.
                                            </small>
                                        </div>
                                    </div>
                                `,
                                icon: 'error',
                                showCancelButton: true,
                                confirmButtonText: '<i class="fas fa-redo me-2"></i>Coba Lagi',
                                confirmButtonColor: '#8B5A3C',
                                cancelButtonText: '<i class="fas fa-headset me-2"></i>Hubungi CS',
                                cancelButtonColor: '#FF851B',
                                customClass: {
                                    popup: 'rounded-lg border-0 shadow-lg',
                                    title: 'fw-bold text-danger'
                                },
                                background: '#FDFCFA'
                            }).then((result) => {
                                if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                                    window.open('{{ route("home.contact.index") }}', '_blank');
                                }
                            });
                        },

                        onClose: function() {
                            if (!paymentProcessed) {
                                Swal.fire({
                                    title: 'Pembayaran Dibatalkan',
                                    html: `
                                        <div class="text-center">
                                            <div class="cancel-animation mb-4">
                                                <i class="fas fa-exclamation-triangle fa-4x mb-3" style="color: #FF851B; animation: cancelBounce 1s infinite;"></i>
                                            </div>
                                            <h6 class="mb-3" style="color: #E65100;">Jendela Pembayaran Ditutup</h6>
                                            <p style="color: #BF360C;">Anda menutup jendela pembayaran sebelum menyelesaikan transaksi.</p>
                                            <div class="alert alert-info mt-3" style="background: rgba(0, 116, 217, 0.1); border: 1px solid #0074D9; border-radius: 12px;">
                                                <small style="color: #0D47A1;">
                                                    <i class="fas fa-clock me-1"></i>
                                                    Pesanan Anda masih tersimpan. Anda dapat mencoba pembayaran lagi kapan saja.
                                                </small>
                                            </div>
                                        </div>
                                    `,
                                    icon: 'warning',
                                    confirmButtonText: '<i class="fas fa-check me-2"></i>Mengerti',
                                    confirmButtonColor: '#FF851B',
                                    customClass: {
                                        popup: 'rounded-lg border-0 shadow-lg',
                                        title: 'fw-bold'
                                    },
                                    background: '#FDFCFA'
                                });
                            }
                        }
                    });
                }, 1500);

                // Enhanced function to check payment status with better UX
                function checkPaymentStatus() {
                    let attempts = 0;
                    const maxAttempts = 25; // Increased to 25 attempts = 2.5 minutes

                    const checkInterval = setInterval(() => {
                        attempts++;

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
                            console.log('Payment check result:', data);

                            if (data.status === 'approved' || data.status === 'paid') {
                                clearInterval(checkInterval);
                                Swal.close();

                                Swal.fire({
                                    title: 'Pembayaran Berhasil!',
                                    html: `
                                        <div class="text-center">
                                            <div class="success-animation mb-4">
                                                <i class="fas fa-check-circle fa-5x mb-3" style="color: #2ECC40; animation: successBounce 1s infinite;"></i>
                                            </div>
                                            <h5 class="mb-3" style="color: #1B5E20;">Terima Kasih!</h5>
                                            <p style="color: #2E7D32;">Pembayaran Anda telah dikonfirmasi dan pesanan sedang diproses.</p>
                                            <div class="alert alert-success mt-3" style="background: rgba(46, 204, 64, 0.1); border: 1px solid #2ECC40; border-radius: 12px;">
                                                <small style="color: #1B5E20;">
                                                    <i class="fas fa-truck me-1"></i>
                                                    Halaman akan dimuat ulang untuk menampilkan status pesanan terbaru.
                                                </small>
                                            </div>
                                        </div>
                                    `,
                                    icon: 'success',
                                    confirmButtonText: '<i class="fas fa-eye me-2"></i>Lihat Status Pesanan',
                                    confirmButtonColor: '#2ECC40',
                                    allowOutsideClick: false,
                                    customClass: {
                                        popup: 'rounded-lg border-0 shadow-lg',
                                        title: 'fw-bold text-success'
                                    },
                                    background: '#FDFCFA'
                                }).then(() => {
                                    window.location.reload();
                                });

                            } else if (data.status === 'declined' || data.status === 'failed') {
                                clearInterval(checkInterval);
                                Swal.close();

                                Swal.fire({
                                    title: 'Pembayaran Ditolak',
                                    html: `
                                        <div class="text-center">
                                            <div class="declined-animation mb-4">
                                                <i class="fas fa-times-circle fa-4x mb-3" style="color: #FF4136; animation: declinedPulse 1.5s infinite;"></i>
                                            </div>
                                            <h6 class="mb-3" style="color: #B71C1C;">Pembayaran Tidak Dapat Diproses</h6>
                                            <p style="color: #C62828;">Maaf, pembayaran Anda tidak dapat diproses oleh sistem.</p>
                                            <div class="alert alert-warning mt-3" style="background: rgba(255, 133, 27, 0.1); border: 1px solid #FF851B; border-radius: 12px;">
                                                <small style="color: #E65100;">
                                                    <i class="fas fa-lightbulb me-1"></i>
                                                    Silakan coba dengan metode pembayaran lain atau hubungi bank Anda.
                                                </small>
                                            </div>
                                        </div>
                                    `,
                                    icon: 'error',
                                    confirmButtonText: '<i class="fas fa-check me-2"></i>Mengerti',
                                    confirmButtonColor: '#FF4136',
                                    customClass: {
                                        popup: 'rounded-lg border-0 shadow-lg',
                                        title: 'fw-bold text-danger'
                                    },
                                    background: '#FDFCFA'
                                }).then(() => {
                                    window.location.reload();
                                });

                            } else if (attempts >= maxAttempts) {
                                clearInterval(checkInterval);
                                Swal.close();

                                Swal.fire({
                                    title: 'Verifikasi Manual Diperlukan',
                                    html: `
                                        <div class="text-center">
                                            <div class="manual-verification mb-4">
                                                <i class="fas fa-user-check fa-4x mb-3" style="color: #FF851B; animation: manualVerifyRotate 2s infinite;"></i>
                                            </div>
                                            <h6 class="mb-3" style="color: #E65100;">Memerlukan Waktu Verifikasi Lebih Lama</h6>
                                            <p style="color: #BF360C;">Pembayaran mungkin sudah berhasil namun memerlukan verifikasi manual.</p>
                                            <div class="alert alert-info mt-3" style="background: rgba(0, 116, 217, 0.1); border: 1px solid #0074D9; border-radius: 12px;">
                                                <small style="color: #0D47A1;">
                                                    <i class="fas fa-clock me-1"></i>
                                                    Silakan refresh halaman dalam 5-10 menit atau hubungi customer service.
                                                </small>
                                            </div>
                                        </div>
                                    `,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: '<i class="fas fa-sync me-2"></i>Refresh Halaman',
                                    confirmButtonColor: '#FF851B',
                                    cancelButtonText: '<i class="fas fa-headset me-2"></i>Hubungi CS',
                                    cancelButtonColor: '#8B7355',
                                    customClass: {
                                        popup: 'rounded-lg border-0 shadow-lg',
                                        title: 'fw-bold'
                                    },
                                    background: '#FDFCFA'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    } else if (result.isDismissed) {
                                        window.open('{{ route("home.contact.index") }}', '_blank');
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error checking payment status:', error);

                            if (attempts >= maxAttempts) {
                                clearInterval(checkInterval);
                                Swal.close();

                                Swal.fire({
                                    title: 'Tidak Dapat Memverifikasi',
                                    html: `
                                        <div class="text-center">
                                            <div class="connection-error mb-4">
                                                <i class="fas fa-wifi fa-4x mb-3" style="color: #8B7355; animation: connectionFade 2s infinite;"></i>
                                            </div>
                                            <h6 class="mb-3" style="color: #5D4E3A;">Masalah Koneksi Terdeteksi</h6>
                                            <p style="color: #8B7355;">Terjadi masalah koneksi saat memverifikasi pembayaran.</p>
                                            <div class="alert alert-info mt-3" style="background: rgba(0, 116, 217, 0.1); border: 1px solid #0074D9; border-radius: 12px;">
                                                <small style="color: #0D47A1;">
                                                    <i class="fas fa-sync me-1"></i>
                                                    Silakan refresh halaman untuk melihat status pembayaran terbaru.
                                                </small>
                                            </div>
                                        </div>
                                    `,
                                    icon: 'warning',
                                    confirmButtonText: '<i class="fas fa-sync me-2"></i>Refresh Halaman',
                                    confirmButtonColor: '#0074D9',
                                    customClass: {
                                        popup: 'rounded-lg border-0 shadow-lg',
                                        title: 'fw-bold'
                                    },
                                    background: '#FDFCFA'
                                }).then(() => {
                                    window.location.reload();
                                });
                            }
                        });
                    }, 6000); // Check every 6 seconds
                }
            });
        }

        // Enhanced manual refresh status button
        const refreshButton = document.querySelector('[onclick="refreshPaymentStatus()"]');
        if (refreshButton) {
            refreshButton.addEventListener('click', function(e) {
                e.preventDefault();
                refreshPaymentStatus();
            });
        }
    });

    // Enhanced refresh payment status function with premium UX
    function refreshPaymentStatus() {
        Swal.fire({
            title: 'Memeriksa Status Pembayaran...',
            html: `
                <div class="text-center">
                    <div class="refresh-animation mb-4">
                        <i class="fas fa-sync fa-3x" style="color: #8B5A3C; animation: refreshSpin 1s infinite linear;"></i>
                    </div>
                    <p style="color: #5D4E3A;">Menghubungi server pembayaran...</p>
                    <div class="progress mt-3" style="height: 8px; background: rgba(139, 90, 60, 0.1);">
                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                             style="background: linear-gradient(90deg, #8B5A3C, #A67C5A); width: 100%;"></div>
                    </div>
                    <div class="mt-3">
                        <small style="color: #8B7355;">
                            <i class="fas fa-shield-alt me-1"></i>
                            Koneksi aman dan terenkripsi
                        </small>
                    </div>
                </div>
            `,
            allowOutsideClick: false,
            showConfirmButton: false,
            customClass: {
                popup: 'rounded-lg border-0 shadow-lg',
                title: 'fw-bold'
            },
            background: '#FDFCFA'
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
                            <div class="success-check mb-4">
                                <i class="fas fa-check-circle fa-5x mb-3" style="color: #2ECC40; animation: successZoom 1s ease-out;"></i>
                            </div>
                            <h5 class="mb-3" style="color: #1B5E20;">Status Pembayaran Dikonfirmasi!</h5>
                            <p style="color: #2E7D32;">Pembayaran Anda telah berhasil diverifikasi oleh sistem.</p>
                            <div class="alert alert-success mt-3" style="background: rgba(46, 204, 64, 0.1); border: 1px solid #2ECC40; border-radius: 12px;">
                                <small style="color: #1B5E20;">
                                    <i class="fas fa-truck me-1"></i>
                                    Pesanan Anda akan segera diproses untuk pengiriman.
                                </small>
                            </div>
                        </div>
                    `,
                    icon: 'success',
                    confirmButtonText: '<i class="fas fa-eye me-2"></i>Lihat Status Terbaru',
                    confirmButtonColor: '#2ECC40',
                    customClass: {
                        popup: 'rounded-lg border-0 shadow-lg',
                        title: 'fw-bold text-success'
                    },
                    background: '#FDFCFA'
                }).then(() => {
                    window.location.reload();
                });
            } else if (data.status === 'declined' || data.status === 'failed') {
                Swal.fire({
                    title: 'Pembayaran Ditolak',
                    html: `
                        <div class="text-center">
                            <div class="decline-animation mb-4">
                                <i class="fas fa-times-circle fa-4x mb-3" style="color: #FF4136; animation: declineShake 0.8s infinite;"></i>
                            </div>
                            <h6 class="mb-3" style="color: #B71C1C;">Status: Pembayaran Ditolak</h6>
                            <p style="color: #C62828;">Pembayaran Anda ditolak oleh sistem pembayaran.</p>
                            <div class="alert alert-warning mt-3" style="background: rgba(255, 133, 27, 0.1); border: 1px solid #FF851B; border-radius: 12px;">
                                <small style="color: #E65100;">
                                    <i class="fas fa-lightbulb me-1"></i>
                                    Coba metode pembayaran lain atau periksa saldo/limit kartu Anda.
                                </small>
                            </div>
                        </div>
                    `,
                    icon: 'error',
                    confirmButtonText: '<i class="fas fa-check me-2"></i>Mengerti',
                    confirmButtonColor: '#FF4136',
                    customClass: {
                        popup: 'rounded-lg border-0 shadow-lg',
                        title: 'fw-bold text-danger'
                    },
                    background: '#FDFCFA'
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Status Belum Berubah',
                    html: `
                        <div class="text-center">
                            <div class="pending-status mb-4">
                                <i class="fas fa-hourglass-half fa-4x mb-3" style="color: #FF851B; animation: pendingFlip 2s infinite;"></i>
                            </div>
                            <h6 class="mb-3" style="color: #E65100;">Masih Dalam Proses Verifikasi</h6>
                            <p style="color: #BF360C;">Pembayaran masih dalam tahap verifikasi oleh sistem.</p>
                            <div class="alert alert-info mt-3" style="background: rgba(0, 116, 217, 0.1); border: 1px solid #0074D9; border-radius: 12px;">
                                <small style="color: #0D47A1;">
                                    <i class="fas fa-clock me-1"></i>
                                    Proses verifikasi biasanya memakan waktu 5-15 menit.
                                </small>
                            </div>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonText: '<i class="fas fa-check me-2"></i>Mengerti',
                    confirmButtonColor: '#0074D9',
                    customClass: {
                        popup: 'rounded-lg border-0 shadow-lg',
                        title: 'fw-bold'
                    },
                    background: '#FDFCFA'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Gagal Memeriksa Status',
                html: `
                    <div class="text-center">
                        <div class="error-connection mb-4">
                            <i class="fas fa-exclamation-triangle fa-4x mb-3" style="color: #FF851B; animation: errorWiggle 1s infinite;"></i>
                        </div>
                        <h6 class="mb-3" style="color: #E65100;">Terjadi Kesalahan Koneksi</h6>
                        <p style="color: #BF360C;">Tidak dapat terhubung ke server pembayaran saat ini.</p>
                        <div class="alert alert-warning mt-3" style="background: rgba(255, 133, 27, 0.1); border: 1px solid #FF851B; border-radius: 12px;">
                            <small style="color: #E65100;">
                                <i class="fas fa-wifi me-1"></i>
                                Periksa koneksi internet Anda dan coba lagi.
                            </small>
                        </div>
                    </div>
                `,
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-redo me-2"></i>Coba Lagi',
                confirmButtonColor: '#0074D9',
                cancelButtonText: '<i class="fas fa-headset me-2"></i>Hubungi CS',
                cancelButtonColor: '#8B7355',
                customClass: {
                    popup: 'rounded-lg border-0 shadow-lg',
                    title: 'fw-bold'
                },
                background: '#FDFCFA'
            }).then((result) => {
                if (result.isConfirmed) {
                    setTimeout(() => refreshPaymentStatus(), 2000);
                } else if (result.isDismissed) {
                    window.open('{{ route("home.contact.index") }}', '_blank');
                }
            });
        });
    }
</script>

<!-- Enhanced CSS Animations for Better UX -->
<style>
    /* Payment Loading Animations */
    @keyframes verificationPulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }

    @keyframes pendingClock {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes errorShake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    @keyframes cancelBounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    @keyframes successBounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    @keyframes declinedPulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(0.95); }
    }

    @keyframes manualVerifyRotate {
        0% { transform: rotate(0deg); }
        50% { transform: rotate(10deg); }
        100% { transform: rotate(0deg); }
    }

    @keyframes connectionFade {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    @keyframes refreshSpin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes successZoom {
        0% { transform: scale(0); opacity: 0; }
        50% { transform: scale(1.2); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }

    @keyframes declineShake {
        0%, 100% { transform: translateX(0) rotate(0deg); }
        25% { transform: translateX(-3px) rotate(-3deg); }
        75% { transform: translateX(3px) rotate(3deg); }
    }

    @keyframes pendingFlip {
        0%, 100% { transform: rotateY(0deg); }
        50% { transform: rotateY(180deg); }
    }

    @keyframes errorWiggle {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(-10deg); }
        75% { transform: rotate(10deg); }
    }

    /* Enhanced Progress Bar */
    .progress-bar {
        background-size: 200% 100%;
        animation: progressMove 2s linear infinite;
    }

    @keyframes progressMove {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* Enhanced SweetAlert2 styling */
    .swal2-popup {
        border-radius: 16px !important;
        box-shadow: 0 10px 40px rgba(139, 90, 60, 0.15) !important;
    }

    .swal2-title {
        font-family: 'Inter', sans-serif !important;
        color: #3C2E26 !important;
    }

    .swal2-html-container {
        font-family: 'Inter', sans-serif !important;
        line-height: 1.6 !important;
    }

    .swal2-confirm {
        border-radius: 12px !important;
        padding: 12px 24px !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease !important;
    }

    .swal2-confirm:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2) !important;
    }

    .swal2-cancel {
        border-radius: 12px !important;
        padding: 12px 24px !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        transition: all 0.3s ease !important;
    }

    .swal2-cancel:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15) !important;
    }

    /* Custom spinner for loading states */
    .payment-loader .spinner-border {
        border-width: 4px;
        border-top-color: transparent;
    }

    /* Enhanced alert styling within SweetAlert */
    .swal2-html-container .alert {
        border-radius: 12px !important;
        margin: 0 !important;
        font-size: 0.875rem !important;
    }

    /* Progress bar within SweetAlert */
    .swal2-html-container .progress {
        border-radius: 8px !important;
        overflow: hidden !important;
    }

    .swal2-html-container .progress-bar {
        border-radius: 8px !important;
    }
</style>

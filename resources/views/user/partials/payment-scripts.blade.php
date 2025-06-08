<!-- Midtrans Payment Scripts -->
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('pay-button-detail');
        if (payButton) {
            payButton.addEventListener('click', function() {
                let paymentProcessed = false;

                // Show loading state
                Swal.fire({
                    title: 'Memuat Gateway Pembayaran...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Small delay to show loading
                setTimeout(() => {
                    Swal.close();

                    snap.pay('{{ $transaction->snap_token }}', {
                        onSuccess: function(result) {
                            console.log("Payment Success", result);
                            paymentProcessed = true;

                            Swal.fire({
                                title: 'Memverifikasi Pembayaran...',
                                text: 'Sedang memverifikasi pembayaran Anda. Mohon tunggu.',
                                icon: 'info',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
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
                                        <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                                        <p>Pembayaran Anda sedang dalam proses verifikasi.</p>
                                        <p class="text-muted">Kami akan memperbarui status pembayaran secara otomatis.</p>
                                    </div>
                                `,
                                icon: 'info',
                                confirmButtonText: 'Mengerti',
                                confirmButtonColor: '#007bff'
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
                                        <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                                        <p>Terjadi kesalahan saat memproses pembayaran.</p>
                                        <p class="text-muted">Silakan coba lagi atau hubungi customer service.</p>
                                    </div>
                                `,
                                icon: 'error',
                                showCancelButton: true,
                                confirmButtonText: 'Coba Lagi',
                                confirmButtonColor: '#dc3545',
                                cancelButtonText: 'Hubungi CS',
                                cancelButtonColor: '#6c757d'
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
                                            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                            <p>Anda menutup jendela pembayaran.</p>
                                            <p class="text-muted">Anda dapat mencoba lagi kapan saja.</p>
                                        </div>
                                    `,
                                    icon: 'warning',
                                    confirmButtonText: 'Mengerti',
                                    confirmButtonColor: '#ffc107'
                                });
                            }
                        }
                    });
                }, 1000);

                // Function to check payment status
                function checkPaymentStatus() {
                    let attempts = 0;
                    const maxAttempts = 20; // 20 attempts = 2 minutes

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
                                            <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                                            <h5 class="text-success">Terima Kasih!</h5>
                                            <p>Pembayaran Anda telah dikonfirmasi dan pesanan sedang diproses.</p>
                                            <div class="alert alert-info mt-3">
                                                <small>Halaman akan dimuat ulang untuk menampilkan status terbaru.</small>
                                            </div>
                                        </div>
                                    `,
                                    icon: 'success',
                                    confirmButtonText: 'Lihat Status Pesanan',
                                    confirmButtonColor: '#28a745',
                                    allowOutsideClick: false
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
                                            <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                                            <p>Pembayaran Anda tidak dapat diproses.</p>
                                            <p class="text-muted">Silakan coba dengan metode pembayaran lain atau hubungi bank Anda.</p>
                                        </div>
                                    `,
                                    icon: 'error',
                                    confirmButtonText: 'Mengerti',
                                    confirmButtonColor: '#dc3545'
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
                                            <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                                            <p>Pembayaran mungkin sudah berhasil namun memerlukan waktu verifikasi lebih lama.</p>
                                            <div class="alert alert-info mt-3">
                                                <small>Silakan refresh halaman dalam beberapa menit atau hubungi customer service.</small>
                                            </div>
                                        </div>
                                    `,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Refresh Halaman',
                                    confirmButtonColor: '#ffc107',
                                    cancelButtonText: 'Hubungi CS',
                                    cancelButtonColor: '#6c757d'
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
                                            <i class="fas fa-wifi fa-3x text-muted mb-3"></i>
                                            <p>Terjadi masalah koneksi saat memverifikasi pembayaran.</p>
                                            <p class="text-muted">Silakan refresh halaman untuk melihat status terbaru.</p>
                                        </div>
                                    `,
                                    icon: 'warning',
                                    confirmButtonText: 'Refresh Halaman',
                                    confirmButtonColor: '#007bff'
                                }).then(() => {
                                    window.location.reload();
                                });
                            }
                        });
                    }, 6000); // Check every 6 seconds
                }
            });
        }

        // Manual refresh status button
        const refreshButton = document.querySelector('[onclick="refreshPaymentStatus()"]');
        if (refreshButton) {
            refreshButton.addEventListener('click', function(e) {
                e.preventDefault();
                refreshPaymentStatus();
            });
        }
    });

    // Enhanced refresh payment status function
    function refreshPaymentStatus() {
        Swal.fire({
            title: 'Memeriksa Status Pembayaran...',
            html: `
                <div class="text-center">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p>Menghubungi server pembayaran...</p>
                </div>
            `,
            allowOutsideClick: false,
            showConfirmButton: false
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
                            <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                            <p>Pembayaran Anda telah dikonfirmasi!</p>
                        </div>
                    `,
                    icon: 'success',
                    confirmButtonText: 'Lihat Status Terbaru',
                    confirmButtonColor: '#28a745'
                }).then(() => {
                    window.location.reload();
                });
            } else if (data.status === 'declined' || data.status === 'failed') {
                Swal.fire({
                    title: 'Pembayaran Ditolak',
                    html: `
                        <div class="text-center">
                            <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                            <p>Pembayaran Anda ditolak oleh sistem.</p>
                        </div>
                    `,
                    icon: 'error',
                    confirmButtonText: 'Mengerti',
                    confirmButtonColor: '#dc3545'
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Status Belum Berubah',
                    html: `
                        <div class="text-center">
                            <i class="fas fa-hourglass-half fa-3x text-warning mb-3"></i>
                            <p>Pembayaran masih dalam proses verifikasi.</p>
                            <p class="text-muted">Mohon tunggu beberapa saat dan coba lagi.</p>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Mengerti',
                    confirmButtonColor: '#17a2b8'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Gagal Memeriksa Status',
                html: `
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                        <p>Terjadi kesalahan saat memeriksa status pembayaran.</p>
                        <p class="text-muted">Silakan coba lagi nanti atau hubungi customer service.</p>
                    </div>
                `,
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Coba Lagi',
                confirmButtonColor: '#007bff',
                cancelButtonText: 'Hubungi CS',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    setTimeout(() => refreshPaymentStatus(), 1000);
                } else if (result.isDismissed) {
                    window.open('{{ route("home.contact.index") }}', '_blank');
                }
            });
        });
    }
</script>

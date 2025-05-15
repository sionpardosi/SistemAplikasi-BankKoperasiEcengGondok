@extends('layouts.app')

@section('content')
    <style>
        .cart-total th,
        .cart-total td {
            color: green;
            font-weight: bold;
            font-size: 21px !important;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-top: 60px !important;
        }

        /* Menambahkan CSS dari halaman keranjang untuk checkout steps */
        :root {
            --primary: #956a3b;
            --primary-light: rgba(149, 106, 59, 0.12);
            --primary-lighter: rgba(149, 106, 59, 0.06);
            --primary-dark: #7d593a;
            --white: #ffffff;
            --text-dark: #333333;
            --text-medium: #555555;
            --text-light: #767676;
            --border-radius: 16px;
            --shadow-soft: 0 10px 30px rgba(149, 106, 59, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* Checkout Steps - Modern Design */
        .checkout-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        /* Progress Bar */
        .checkout-steps:before {
            content: '';
            position: absolute;
            top: 35px;
            left: 0;
            height: 3px;
            width: 100%;
            background-color: #e7e0d8;
            z-index: -1;
        }

        .checkout-steps:after {
            content: '';
            position: absolute;
            top: 35px;
            left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, var(--primary), #a87c4f);
            z-index: -1;
            transition: var(--transition);
        }

        .checkout-steps.step-1:after {
            width: 0%;
        }

        .checkout-steps.step-2:after {
            width: 50%;
        }

        .checkout-steps.step-3:after {
            width: 100%;
        }

        .checkout-steps__item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            text-decoration: none;
            position: relative;
            width: 33.333%;
            transition: var(--transition);
        }

        /* Step Number */
        .checkout-steps__item-number {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 22px;
            font-weight: 700;
            color: var(--text-light);
            background-color: #f0e9e1;
            border: 3px solid #e7e0d8;
            margin-bottom: 16px;
            position: relative;
            transition: var(--transition);
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .checkout-steps__item-number:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), #a87c4f);
            opacity: 0;
            transition: var(--transition);
            border-radius: 50%;
            transform: scale(0.8);
        }

        .checkout-steps__item-number span {
            position: relative;
            z-index: 2;
        }

        /* Step Title */
        .checkout-steps__item-title {
            display: flex;
            flex-direction: column;
            gap: 5px;
            transition: var(--transition);
        }

        .checkout-steps__item-title span {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-medium);
            transition: var(--transition);
        }

        .checkout-steps__item-title em {
            font-size: 13px;
            font-style: normal;
            color: var(--text-light);
            transition: var(--transition);
            max-width: 160px;
            margin: 0 auto;
        }

        /* Step Icon */
        .checkout-steps__item-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            opacity: 0;
            color: var(--white);
            font-size: 20px;
            transition: all 0.4s cubic-bezier(0.68, -0.6, 0.32, 1.6);
            z-index: 3;
        }

        /* Active State */
        .checkout-steps__item.active .checkout-steps__item-number {
            border-color: var(--primary);
            color: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(149, 106, 59, 0.25);
        }

        .checkout-steps__item.active .checkout-steps__item-number:before {
            opacity: 1;
            transform: scale(1);
        }

        .checkout-steps__item.active .checkout-steps__item-title span {
            color: var(--primary);
            font-weight: 700;
        }

        .checkout-steps__item.active .checkout-steps__item-title em {
            color: var(--text-medium);
        }

        /* Completed State */
        .checkout-steps__item.completed .checkout-steps__item-number {
            border-color: var(--primary);
            color: rgba(0, 0, 0, 0);
            background-color: var(--primary);
        }

        .checkout-steps__item.completed .checkout-steps__item-number:before {
            opacity: 1;
            transform: scale(1);
        }

        .checkout-steps__item.completed .checkout-steps__item-icon {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }

        /* Hover Effects */
        .checkout-steps__item:not(.active):hover .checkout-steps__item-title span {
            color: var(--primary-dark);
        }

        .checkout-steps__item:not(.active):hover .checkout-steps__item-number {
            transform: translateY(-3px);
            border-color: #d9ccbc;
            box-shadow: 0 6px 15px rgba(149, 106, 59, 0.15);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .checkout-steps__item-number {
                width: 60px;
                height: 60px;
                font-size: 18px;
            }

            .checkout-steps__item-title span {
                font-size: 15px;
            }

            .checkout-steps__item-title em {
                font-size: 12px;
            }
        }

        @media (max-width: 768px) {
            .checkout-steps {
                flex-direction: column;
                gap: 20px;
            }

            .checkout-steps:before,
            .checkout-steps:after {
                display: none;
            }

            .checkout-steps__item {
                flex-direction: row;
                justify-content: flex-start;
                width: 100%;
                padding: 12px;
                border-radius: var(--border-radius);
                background-color: var(--white);
                box-shadow: var(--shadow-soft);
                gap: 15px;
            }

            .checkout-steps__item-number {
                width: 45px;
                height: 45px;
                font-size: 16px;
                margin-bottom: 0;
            }

            .checkout-steps__item-title {
                text-align: left;
            }

            .checkout-steps__item-title em {
                margin: 0;
            }

            .checkout-steps__item.active {
                background-color: var(--primary-light);
            }

            .checkout-steps__item:not(.active):hover {
                background-color: var(--primary-lighter);
            }
        }

        @media (max-width: 480px) {
            .checkout-steps__item-title em {
                display: none;
            }
        }
    </style>

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title mb-4" style="letter-spacing:1px; margin-bottom: 3.5rem !important;">KONFIRMASI PEMBAYARAN
            </h2>
            <!-- Modern Checkout Steps - Menggunakan format yang sama seperti di pengiriman & pembayaran -->
            <div class="checkout-steps step-3">
                <a href="javascript:void(0);" class="checkout-steps__item completed">
                    <div class="checkout-steps__item-number">
                        <span>01</span>
                        <div class="checkout-steps__item-icon">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <div class="checkout-steps__item-title">
                        <span>Keranjang Belanja</span>
                        <em>Kelola Daftar Barang Anda</em>
                    </div>
                </a>
                <a href="javascript:void(0);" class="checkout-steps__item completed">
                    <div class="checkout-steps__item-number">
                        <span>02</span>
                        <div class="checkout-steps__item-icon">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <div class="checkout-steps__item-title">
                        <span>Pengiriman dan Pembayaran</span>
                        <em>Lanjutkan ke Pembayaran</em>
                    </div>
                </a>
                <a href="javascript:void(0);" class="checkout-steps__item active">
                    <div class="checkout-steps__item-number">
                        <span>03</span>
                        <div class="checkout-steps__item-icon">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <div class="checkout-steps__item-title">
                        <span>Konfirmasi</span>
                        <em>Tinjau dan Kirim Pesanan Anda</em>
                    </div>
                </a>
            </div>

            <div class="order-complete">
                <div class="order-complete__message text-center">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                        <circle cx="40" cy="40" r="40" fill="#B9A16B" />
                        <path d="M54.6667 29.3333L35.3333 48.6667L25.3333 38.6667" stroke="white" stroke-width="5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <h3>PESANAN ANDA TELAH DITERIMA</h3>
                    <p>Terima kasih! Pesanan Anda telah berhasil kami terima dan sedang diproses. Silakan selesaikan
                        pembayaran untuk konfirmasi.</p>
                </div>

                <div class="order-info">
                    <div class="order-info__item"><label>Nomor Pesanan</label><span>{{ $order->id }}</span></div>
                    <div class="order-info__item"><label>Tanggal</label><span>{{ $order->created_at }}</span></div>
                    <div class="order-info__item"><label>Total</label><span>{{ formatRupiah($order->total) }}</span></div>
                    <div class="order-info__item"><label>Metode
                            Pembayaran</label>
                        <span>
                            @if ($order->transaction)
                                {{ $order->transaction->mode_display }}
                            @else
                                -
                            @endif
                        </span>
                    </div>
                </div>

                <div class="checkout__totals-wrapper">
                    <div class="checkout__totals">
                        <h3>Detail Pesanan</h3>
                        <table class="checkout-cart-items">
                            <thead>
                                <tr>
                                    <th>PRODUK</th>
                                    <th>SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name }} x {{ $item->quantity }}</td>
                                        <td class="text-right">{{ formatRupiah($item->price) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <table class="checkout-totals">
                            <tbody>
                                <tr>
                                    <th>SUBTOTAL</th>
                                    <td class="text-right">{{ formatRupiah($order->subtotal) }}</td>
                                </tr>
                                <tr>
                                    <th>DISKON</th>
                                    <td class="text-right">{{ formatRupiah($order->discount) }}</td>
                                </tr>
                                <tr>
                                    <th>PENGIRIMAN</th>
                                    <td class="text-right">Gratis Ongkos Kirim</td>
                                </tr>
                                <tr>
                                    <th>PPN</th>
                                    <td class="text-right">{{ formatRupiah($order->tax) }}</td>
                                </tr>
                                <tr>
                                    <th>TOTAL</th>
                                    <td class="text-right">{{ formatRupiah($order->total) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tombol Bayar Sekarang -->
                    <div class="text-center mt-4">
                        <button id="pay-button" class="btn btn-primary px-5 py-3"
                            style="background-color: #956a3b; border-color: #956a3b;">Bayar Sekarang</button>
                    </div>
                </div>
            </div>
        </section>
    </main>


    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>


    <script type="text/javascript">
        document.getElementById('pay-button').addEventListener('click', function() {
            snap.pay('{{ $snaptoken }}', {
                onSuccess: function(result) {
                    console.log("Success", result);
                    alert("Pembayaran berhasil!");
                    window.location.href = '{{ url('payment_success') }}';
                },
                onPending: function(result) {
                    console.log("Pending", result);
                    alert("Pembayaran Pending.");
                    window.location.href = '{{ url('payment_pending') }}';
                },
                onError: function(result) {
                    console.log("Error", result);
                    alert("Terjadi kesalahan saat pembayaran.");
                },
                onClose: function() {
                    alert("Anda menutup popup tanpa menyelesaikan pembayaran.");
                }
            });
        });
    </script>

    @push('scripts')
        <!-- JavaScript for Step Navigation -->
        <script>
            // Script untuk mengelola navigasi langkah checkout
            document.addEventListener('DOMContentLoaded', function() {
                // Pada halaman konfirmasi, set langkah ke-3
                updateCheckoutStep(3);

                // Fungsi ini sama dengan yang ada di halaman pengiriman dan pembayaran
                function updateCheckoutStep(step) {
                    const checkoutSteps = document.querySelector('.checkout-steps');
                    const stepItems = document.querySelectorAll('.checkout-steps__item');

                    // Update progress bar
                    checkoutSteps.className = 'checkout-steps';
                    checkoutSteps.classList.add(`step-${step}`);

                    // Reset all steps
                    stepItems.forEach((item, index) => {
                        item.classList.remove('active', 'completed');

                        // Mark steps as completed or active
                        if (index + 1 < step) {
                            item.classList.add('completed');
                        } else if (index + 1 === step) {
                            item.classList.add('active');
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection

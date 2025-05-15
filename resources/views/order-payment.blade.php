@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Order Received</h2>
            <div class="checkout-steps">
                <!-- Langkah-langkah checkout -->
                <a href="#" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Shopping Bag</span>
                        <em>Manage Your Items List</em>
                    </span>
                </a>
                <a href="#" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>Shipping and Checkout</span>
                        <em>Checkout Your Items List</em>
                    </span>
                </a>
                <a href="#" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>Confirmation</span>
                        <em>Review And Submit Your Order</em>
                    </span>
                </a>
            </div>

            <div class="order-complete">
                <div class="order-complete__message text-center">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                        <circle cx="40" cy="40" r="40" fill="#B9A16B" />
                        <path d="..." fill="white" />
                    </svg>
                    <h3>Your order is completed!</h3>
                    <p>Thank you. Your order has been received.</p>
                </div>

                <div class="order-info">
                    <div class="order-info__item"><label>Order Number</label><span>{{ $order->id }}</span></div>
                    <div class="order-info__item"><label>Date</label><span>{{ $order->created_at }}</span></div>
                    <div class="order-info__item"><label>Total</label><span>{{ formatRupiah($order->total) }}</span></div>
                    <div class="order-info__item"><label>Payment Method</label><span>{{ $order->transaction->mode }}</span>
                    </div>
                </div>

                <div class="checkout__totals-wrapper">
                    <div class="checkout__totals">
                        <h3>Order Details</h3>
                        <table class="checkout-cart-items">
                            <thead>
                                <tr>
                                    <th>PRODUCT</th>
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
                                    <th>DISCOUNT</th>
                                    <td class="text-right">{{ formatRupiah($order->discount) }}</td>
                                </tr>
                                <tr>
                                    <th>SHIPPING</th>
                                    <td class="text-right">Free shipping</td>
                                </tr>
                                <tr>
                                    <th>VAT</th>
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
                        <button id="pay-button" class="btn btn-primary px-5 py-3">Bayar Sekarang</button>
                        {{-- <button id="pay-button">Bayar Sekarang</button> --}}
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
@endsection

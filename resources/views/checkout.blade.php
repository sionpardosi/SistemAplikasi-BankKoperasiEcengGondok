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

    .form-floating>.form-control,
    .form-floating>.form-select {
        height: 60px;
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
        <h2 class="page-title mb-4" style="letter-spacing:1px; margin-bottom: 3.5rem !important;">Pengiriman dan
            Pembayaran</h2>
        <!-- Modern Checkout Steps - Menggunakan format yang sama seperti di keranjang -->
        <div class="checkout-steps step-2">
            <a href="{{ route('cart.index') }}" class="checkout-steps__item completed">
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
            <a href="{{ route('cart.checkout') }}" class="checkout-steps__item active">
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
            <a href="javascript:void(0);" class="checkout-steps__item">
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
        <form name="checkout-form" action="{{ route('cart.place.order') }}" method="POST">
            @csrf
            <div class="checkout-form">
                <div class="billing-info__wrapper">
                    <div class="row">
                        <div class="col-6">
                            <h4>DETAIL PENGIRIMAN</h4>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('user.address.account-address') }}"
                                class="btn btn-info btn-sm float-right">Kelola Alamat</a>
                            @if ($address)
                            <a href="{{ route('user.address.edit-address', $address->id) }}"
                                class="btn btn-warning btn-sm float-right mr-2">Edit Alamat</a>
                            @endif
                        </div>
                    </div>

                    <!-- Jika user sudah memiliki alamat -->
                    @if (isset($userAddresses) && $userAddresses->count() > 0)
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address_selector">Pilih Alamat Pengiriman</label>
                                <select name="address_id" id="address_selector" class="form-control">
                                    <option value="0">-- Gunakan alamat baru --</option>
                                    @foreach ($userAddresses as $addr)
                                    <option value="{{ $addr->id }}" data-province="{{ $addr->state }}"
                                        data-city="{{ $addr->city }}" {{ $address && $addr->id == $address->id ?
                                        'selected' : '' }}>
                                        {{ $addr->name }} - {{ $addr->address }}, {{ $addr->city }}
                                        {{ $addr->isdefault ? '(Default)' : '' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="existing-address" class="row {{ $address ? '' : 'd-none' }}">
                        <div class="col-md-12">
                            <div class="my-account__address-list">
                                <div class="my-account__address-item">
                                    <div class="my-account__address-item__detail">
                                        @if ($address)
                                        <p>{{ $address->name }}</p>
                                        <p>{{ $address->address }}</p>
                                        <p>{{ $address->locality }}</p>
                                        <p>{{ $address->city }}, {{ $address->state }},
                                            {{ $address->country }}</p>
                                        <p>{{ $address->zip }}</p>
                                        <p>Patokan: {{ $address->landmark }}</p>
                                        <p>Nomor HP: {{ $address->phone }}</p>
                                        <input type="hidden" id="idcitylama" value="{{ $address->idcity }}">
                                        <input type="hidden" id="idstatelama" value="{{ $address->idstate }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Form untuk alamat baru -->
                    <div id="new-address-form"
                        class="{{ isset($userAddresses) && $userAddresses->count() > 0 && $address ? 'd-none' : '' }}">
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    <label for="name">Nama Lengkap *</label>
                                    <span class="text-danger">
                                        @error('name')
                                        {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                                    <label for="phone">Nomor Telepon *</label>
                                    <span class="text-danger">
                                        @error('phone')
                                        {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="zip" value="{{ old('zip') }}">
                                    <label for="zip">Kode Pos *</label>
                                    <span class="text-danger">
                                        @error('zip')
                                        {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mt-3 mb-3">
                                    <select class="form-control" id="province" name="state">
                                        <option value="">Pilih Provinsi *</option>
                                    </select>
                                    <label for="state">Provinsi *</label>
                                    <span class="text-danger">
                                        @error('state')
                                        {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <select class="form-control" id="city" name="city">
                                        <option value="">Pilih Kota / Kabupaten *</option>
                                    </select>
                                    <label for="city">Kota / Kabupaten *</label>
                                    <span class="text-danger">
                                        @error('city')
                                        {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                                    <label for="address">Nomor Rumah, Nama Gedung *</label>
                                    <span class="text-danger">
                                        @error('address')
                                        {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="locality"
                                        value="{{ old('locality') }}">
                                    <label for="locality">Nama Jalan, Area, Kelurahan *</label>
                                    <span class="text-danger">
                                        @error('locality')
                                        {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="landmark"
                                        value="{{ old('landmark') }}">
                                    <label for="landmark">Patokan *</label>
                                    <span class="text-danger">
                                        @error('landmark')
                                        {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="save_address"
                                        name="save_address" value="1" checked>
                                    <label class="custom-control-label" for="save_address">Simpan alamat ini untuk
                                        digunakan nanti</label>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="isdefault" name="isdefault"
                                        value="1">
                                    <label class="custom-control-label" for="isdefault">Jadikan sebagai alamat
                                        utama</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pilihan Jasa Pengiriman -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h4>METODE PENGIRIMAN</h4>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <label for="courier">Pilih Kurir</label>
                                <select name="courier" id="courier" class="form-control">
                                    <option value="">-- Pilih Kurir --</option>
                                    @foreach ($couriers as $code => $name)
                                    <option value="{{ $code }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <label for="shipping_service">Layanan Pengiriman</label>
                                <select name="shipping_service" id="shipping_service" class="form-control" disabled>
                                    <option value="">-- Pilih Layanan --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div id="shipping-info" class="alert alert-info d-none">
                                <p><strong>Informasi Pengiriman:</strong></p>
                                <p id="service-description"></p>
                                <p>Estimasi waktu pengiriman: <span id="etd"></span> hari</p>
                                {{-- <p>Berat: <span>{{ $weight / 1000 }}</span> kg</p> --}}
                                <p>Biaya: <span id="shipping-cost"></span></p>
                                <input type="hidden" name="shipping_cost" id="shipping_cost_input" value="0">
                                <input type="hidden" name="city_id" id="city_id" value="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="checkout__totals-wrapper">
                    <div class="sticky-content">
                        <div class="checkout__totals">
                            <h3>PESANAN ANDA</h3>
                            <table class="checkout-cart-items">
                                <thead>
                                    <tr>
                                        <th>PRODUK</th>
                                        <th class="text-right">SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach (\Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->content()
                                    as
                                    $item)
                                    <tr>
                                        <td>
                                            {{ $item->name }} x {{ $item->qty }}
                                        </td>
                                        <td class="text-right">
                                            {{ formatRupiah($item->subTotal(0, '', '')) }}
                                        </td>
                                    </tr>
                                    @endforeach --}}
                                    @php
                                    $cartItems = \Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->content();
                                    @endphp

                                    @foreach($cartItems as $item)
                                    <tr>
                                        <td>{{ $item->name }} x {{ $item->qty }}</td>
                                        <td class="text-right">{{ formatRupiah($item->subTotal(0, '', '')) }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            @if (Session::has('discounts'))
                            <table class="checkout-totals">
                                <tbody>
                                    <tr>
                                        <th>Subtotal</th>
                                        <td class="text-right">
                                            {{
                                            formatRupiah(\Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->subtotal(0,
                                            '', '')) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Diskon {{ Session('coupon')['code'] }}</th>
                                        <td class="text-right">
                                            -{{ formatRupiah((float) Session('discounts')['discount']) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Subtotal Setelah Diskon</th>
                                        <td class="text-right">
                                            {{ formatRupiah((float) Session('discounts')['subtotal']) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ongkos Kirim</th>
                                        <input type="text" name="ongkir" id="ongkirinput">
                                        <td class="text-right" id="ongkir-display">Rp 0</td>
                                    </tr>
                                    {{-- <tr>
                                        <th>PPN</th>
                                        <td class="text-right">
                                            {{ formatRupiah((float) Session('discounts')['tax']) }}
                                        </td>
                                    </tr> --}}
                                    <tr class="cart-total">
                                        <th>Total</th>
                                        <td class="text-right" id="total-price">
                                            {{ formatRupiah((float) Session('discounts')['total']) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @else
                            <table class="checkout-totals">
                                <tbody>
                                    <tr>
                                        <th>SUBTOTAL</th>
                                        <td class="text-right">
                                            {{
                                            formatRupiah(\Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->subtotal(0,
                                            '', '')) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>ONGKOS KIRIM</th>
                                        <input type="hidden" name="ongkir" id="ongkirinput">
                                        <td class="text-right" id="ongkir-display">Rp 0</td>
                                    </tr>
                                    {{-- <tr>
                                        <th>PPN</th>
                                        <td class="text-right">
                                            {{
                                            formatRupiah(\Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->tax(0,
                                            '', '')) }}
                                        </td>
                                    </tr> --}}
                                    <tr class="cart-total">
                                        <th>TOTAL</th>
                                        <td class="text-right" id="total-price">
                                            {{
                                            formatRupiah(\Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->total(0,
                                            '', '')) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif
                        </div>
                        <div class="checkout__payment-methods">
                            <div class="form-check">
                                <input class="form-check-input form-check-input_fill" type="radio" name="mode"
                                    id="mode_1" value="card" checked>
                                <label class="form-check-label" for="mode_1">
                                    E-Wallet | Pembayaran Online
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input form-check-input_fill" type="radio" name="mode"
                                    id="mode_2" value="bank">
                                <label class="form-check-label" for="mode_2">
                                    Bank BNI
                                </label>
                            </div>
                            <div class="policy-text">
                                Data pribadi Anda akan digunakan untuk memproses pesanan, mendukung pengalaman Anda
                                di situs web ini, dan untuk tujuan lain yang dijelaskan dalam
                                <a href="{{ route('home.privacy-policy') }}" target="_blank">kebijakan privasi</a>
                                kami.
                            </div>
                        </div>
                        <input type="hidden" name="kurir" id="kurirnya">
                        <input type="hidden" name="idcity" id="idcitynya">
                        <input type="hidden" name="idstate" id="idstatenya">
                        <button type="submit" class="btn btn-primary" id="submit-order"
                            style="background-color: #956a3b; border-color: #956a3b;" disabled>BUAT PESANAN</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</main>

@push('scripts')
<script>
    // Script untuk integrasi RajaOngkir di halaman checkout
            $(document).ready(function() {
                let provinceId = '';
                let cityId = '';
                let selectedAddressId = $('#address_selector').val();
                let cartTotal = parseFloat(
                    '{{ str_replace(',', '', \Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->total(0, '', '')) }}'
                );

                // 1. Load provinsi saat halaman dimuat
                loadProvinces();

                // 2. Setup event listener untuk provinsi
                $('#province').on('change', function() {
                    provinceId = $(this).find(':selected').data('province-id');
                    if (provinceId) {
                        $('#idstatenya').val(provinceId);
                        loadCities(provinceId);
                    } else {
                        $('#city').html('<option value="">Pilih Kota / Kabupaten *</option>');
                    }
                    updateShippingOptions();
                });

                // 3. Setup event listener untuk kota
                $('#city').on('change', function() {
                    updateShippingOptions();
                });

                // 4. Setup event listener untuk selector alamat
                $('#address_selector').on('change', function() {
                    selectedAddressId = $(this).val();

                    if (selectedAddressId > 0) {
                        $('#existing-address').removeClass('d-none');
                        $('#new-address-form').addClass('d-none');

                        // Load alamat yang dipilih
                        loadSelectedAddress(selectedAddressId);
                    } else {
                        $('#existing-address').addClass('d-none');
                        $('#new-address-form').removeClass('d-none');

                        // Reset form pengiriman
                        $('#shipping_service').html('<option value="">-- Pilih Layanan --</option>');
                        $('#shipping_service').prop('disabled', true);
                        $('#shipping-info').addClass('d-none');
                        updateTotal(0);
                    }
                });

                // 5. Setup event listener untuk kurir
                $('#courier').on('change', function() {
                    const courier = $(this).val();
                    if (courier) {
                        // Jika ada alamat yang dipilih, gunakan ID kota dari alamat tersebut
                        if (selectedAddressId > 0) {
                            calculateShipping(courier);
                        }
                        // Jika menggunakan alamat baru, periksa apakah kota sudah dipilih
                        else {
                            cityId = $('#city').find(':selected').data('city-id');
                            $('#idcitynya').val(cityId);
                            if (cityId) {
                                calculateShipping(courier);
                            } else {
                                alert('Silakan pilih kota terlebih dahulu');
                                $(this).val('');
                            }
                        }
                    } else {
                        $('#shipping_service').html('<option value="">-- Pilih Layanan --</option>');
                        $('#shipping_service').prop('disabled', true);
                        $('#shipping-info').addClass('d-none');
                        updateTotal(0);
                    }
                });

                // 6. Setup event listener untuk layanan pengiriman
                $('#shipping_service').on('change', function() {
                    const selected = $(this).find('option:selected');
                    const cost = selected.data('cost');
                    const etd = selected.data('etd');
                    const description = selected.data('description');

                    if (cost) {
                        $('#shipping-cost').text(formatRupiah(cost));
                        $('#shipping_cost_input').val(cost);
                        $('#etd').text(etd);
                        $('#service-description').text(description);
                        $('#shipping-info').removeClass('d-none');

                        // Update total harga
                        updateTotal(cost);

                        // Aktifkan tombol submit
                        $('#submit-order').prop('disabled', false);
                    } else {
                        $('#shipping-info').addClass('d-none');
                        updateTotal(0);

                        // Nonaktifkan tombol submit
                        $('#submit-order').prop('disabled', true);
                    }
                });

                // Fungsi untuk memuat provinsi
                function loadProvinces() {
                    $.ajax({
                        url: '{{ url('api/rajaongkirprovinces') }}',
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function() {
                            $('#province').html('<option value="">Memuat provinsi...</option>');
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                let options = '<option value="">Pilih Provinsi *</option>';
                                $.each(response.data, function(index, province) {
                                    options +=
                                        `<option value="${province.province}" data-province-id="${province.province_id}">${province.province}</option>`;
                                });
                                $('#province').html(options);
                            } else {
                                alert('Gagal memuat data provinsi');
                            }
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat memuat data provinsi');
                        }
                    });
                }

                // Fungsi untuk memuat kota berdasarkan provinsi
                function loadCities(provinceId) {
                    $.ajax({
                        url: '{{ url('api/rajaongkircities', '') }}/' + provinceId,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function() {
                            $('#city').html('<option value="">Memuat kota...</option>');
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                let options = '<option value="">Pilih Kota / Kabupaten *</option>';
                                $.each(response.data, function(index, city) {
                                    options +=
                                        `<option value="${city.city_name}" data-city-id="${city.city_id}">${city.type} ${city.city_name}</option>`;
                                });
                                $('#city').html(options);
                            } else {
                                alert('Gagal memuat data kota');
                            }
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat memuat data kota');
                        }
                    });
                }

                // Fungsi untuk memuat alamat yang dipilih
                function loadSelectedAddress(addressId) {
                    $.ajax({
                        url: '{{ url('api/useraddressgetaddress', '') }}/' + addressId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                const address = response.data;

                                // Tampilkan detail alamat
                                const addressDetail = `
                <p>${address.name}</p>
                <p>${address.address}</p>
                <p>${address.locality}</p>
                <p>${address.city}, ${address.state}, ${address.country}</p>
                <p>${address.zip}</p>
                <p>Patokan: ${address.landmark}</p>
                <p>Nomor HP: ${address.phone}</p>
            `;
                                $('.my-account__address-item__detail').html(addressDetail);

                                // Set city_id untuk kalkulasi ongkir
                                cityId = address.city_id;
                                $('#city_id').val(cityId);

                                // Reset opsi pengiriman
                                $('#courier').val('');
                                $('#shipping_service').html(
                                    '<option value="">-- Pilih Layanan --</option>');
                                $('#shipping_service').prop('disabled', true);
                                $('#shipping-info').addClass('d-none');
                                updateTotal(0);
                            } else {
                                alert('Gagal memuat data alamat');
                            }
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat memuat data alamat');
                        }
                    });
                }

                // Fungsi untuk menghitung ongkos kirim
                function calculateShipping(courier) {
                    let city = $('#idcitynya').val();
                    // Jika menggunakan alamat baru, ambil ID kota dari dropdown
                    if (city != '') {
                        cityId = city;
                        $('#city_id').val(cityId);
                    } else {
                        cityId = $('#idcitylama').val();
                        stateId = $('#idstatelama').val();
                    }

                    console.log('City ID:', cityId);

                    $.ajax({
                        url: '{{ url('api/rajaongkircalculate') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            city_id: cityId,
                            courier: courier
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            $('#shipping_service').html('<option value="">Memuat layanan...</option>');
                            $('#shipping_service').prop('disabled', true);
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                let options = '<option value="">-- Pilih Layanan --</option>';
                                $.each(response.data, function(index, service) {
                                    options += `<option value="${service.service}"
                                        data-cost="${service.cost[0].value}"
                                        data-etd="${service.cost[0].etd}"
                                        data-description="${service.description}">
                                        ${service.service} - ${service.description} (${formatRupiah(service.cost[0].value)})
                                    </option>`;
                                });
                                $('#shipping_service').html(options);
                                $('#shipping_service').prop('disabled', false);
                            } else {
                                alert('Gagal menghitung ongkos kirim: ' + response.message);
                                $('#shipping_service').html(
                                    '<option value="">-- Pilih Layanan --</option>');
                            }
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan saat menghitung ongkos kirim');
                            $('#shipping_service').html('<option value="">-- Pilih Layanan --</option>');
                        }
                    });
                }

                // Fungsi untuk memperbarui opsi pengiriman
                function updateShippingOptions() {
                    $('#courier').val('');
                    $('#shipping_service').html('<option value="">-- Pilih Layanan --</option>');
                    $('#shipping_service').prop('disabled', true);
                    $('#shipping-info').addClass('d-none');
                    updateTotal(0);

                    // Nonaktifkan tombol submit
                    $('#submit-order').prop('disabled', true);
                }

                // Fungsi untuk memperbarui total harga
                function updateTotal(shippingCost) {
                    shippingCost = Number(shippingCost); // pastikan bertipe angka
                    const newTotal = cartTotal + shippingCost;
                    let courier = $('#courier').val();

                    $('#ongkir-display').text(formatRupiah(shippingCost));
                    $('#ongkirinput').val(shippingCost);
                    $('#kurirnya').val(courier);
                    $('#total-price').text(formatRupiah(newTotal));
                    $('#shipping_cost_input').val(shippingCost);
                }


                // Fungsi untuk format rupiah
                function formatRupiah(angka) {
                    let number_string = angka.toString();
                    let split = number_string.split('.');
                    let sisa = split[0].length % 3;
                    let rupiah = split[0].substr(0, sisa);
                    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }

                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    return 'Rp ' + rupiah;
                }
            });
</script>
<!-- JavaScript for Step Navigation -->
<script>
    // Script untuk mengelola navigasi langkah checkout
            document.addEventListener('DOMContentLoaded', function() {
                // Pada halaman checkout, set langkah ke-2
                // updateCheckoutStep(2) akan dijalankan secara otomatis

                // Fungsi ini sama dengan yang ada di halaman keranjang
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

                // Set halaman ini ke langkah 2
                updateCheckoutStep(2);
            });
</script>
@endpush
@endsection

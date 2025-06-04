@extends('layouts.app')

@section('content')

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title mb-4" style="letter-spacing:1px; margin-bottom: 3.5rem !important;">Pengiriman dan
                Pembayaran</h2>
            <!-- Modern Checkout Steps - Menggunakan format yang sama seperti di keranjang -->
       
            <form name="checkout-form" action="{{ route('cart.place.order') }}" method="POST">
                @csrf
                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        <!-- Header Bagian -->
                        <div class="shipping-details-header">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h4 class="shipping-title">
                                        <i class="fas fa-map-marker-alt me-2"></i>DETAIL PENGIRIMAN
                                    </h4>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="address-actions">
                                        @if ($address)
                                            <a href="{{ route('user.address.edit-address', $address->id) }}"
                                                class="btn btn-edit">
                                                <i class="fas fa-pen me-1"></i> Edit Alamat
                                            </a>
                                        @endif
                                        <a href="{{ route('user.address.account-address') }}" class="btn btn-manage">
                                            <i class="fas fa-cog me-1"></i> Kelola Alamat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Jika user sudah memiliki alamat -->
                        @if (isset($userAddresses) && $userAddresses->count() > 0)
                            <div class="address-selector-container">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address_selector" class="address-label">
                                                <i class="fas fa-home me-2"></i>Pilih Alamat Pengiriman
                                            </label>
                                            <select name="address_id" id="address_selector"
                                                class="form-select custom-select">
                                                <option value="0">-- Gunakan alamat baru --</option>
                                                @foreach ($userAddresses as $addr)
                                                    <option value="{{ $addr->id }}" data-province="{{ $addr->state }}"
                                                        data-city="{{ $addr->city }}"
                                                        {{ $address && $addr->id == $address->id ? 'selected' : '' }}>
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
                                        <div class="address-card">
                                            <div class="address-card-content">
                                                @if ($address)
                                                    <div class="recipient-name">{{ $address->name }}</div>
                                                    <div class="address-data">
                                                        <p><i class="fas fa-building me-2"></i>{{ $address->address }}</p>
                                                        <p><i class="fas fa-road me-2"></i>{{ $address->locality }}</p>
                                                        <p><i class="fas fa-map me-2"></i>{{ $address->city }},
                                                            {{ $address->state }}, {{ $address->country }}</p>
                                                        <p><i class="fas fa-mailbox me-2"></i>{{ $address->zip }}</p>
                                                        <p><i class="fas fa-landmark me-2"></i>Patokan:
                                                            {{ $address->landmark }}</p>
                                                        <p><i class="fas fa-phone me-2"></i>Nomor HP: {{ $address->phone }}
                                                        </p>
                                                    </div>
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
                                        <input type="text" class="form-control custom-input" name="name"
                                            value="{{ old('name') }}">
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
                                        <input type="text" class="form-control custom-input" name="phone"
                                            value="{{ old('phone') }}">
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
                                        <input type="text" class="form-control custom-input" name="zip"
                                            value="{{ old('zip') }}">
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
                                        <select class="form-select custom-select" id="province" name="state">
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
                                        <select class="form-select custom-select" id="city" name="city">
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
                                        <input type="text" class="form-control custom-input" name="address"
                                            value="{{ old('address') }}">
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
                                        <input type="text" class="form-control custom-input" name="locality"
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
                                        <input type="text" class="form-control custom-input" name="landmark"
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
                                    <div class="custom-checkbox-container">
                                        <input type="checkbox" class="custom-checkbox" id="save_address"
                                            name="save_address" value="1" checked>
                                        <label class="custom-checkbox-label" for="save_address">
                                            <span class="checkbox-icon"></span>
                                            Simpan alamat ini untuk digunakan nanti
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="custom-checkbox-container">
                                        <input type="checkbox" class="custom-checkbox" id="isdefault" name="isdefault"
                                            value="1">
                                        <label class="custom-checkbox-label" for="isdefault">
                                            <span class="checkbox-icon"></span>
                                            Jadikan sebagai alamat utama
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pilihan Jasa Pengiriman -->
                        <div class="shipping-method-section">
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h4 class="shipping-title">
                                        <i class="fas fa-truck me-2"></i>METODE PENGIRIMAN
                                    </h4>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="courier" class="courier-label">
                                            <i class="fas fa-shipping-fast me-2"></i>Pilih Kurir
                                        </label>
                                        <select name="courier" id="courier" class="form-select custom-select">
                                            <option value="">-- Pilih Kurir --</option>
                                            @foreach ($couriers as $code => $name)
                                                <option value="{{ $code }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="shipping_service" class="service-label">
                                            <i class="fas fa-box me-2"></i>Layanan Pengiriman
                                        </label>
                                        <select name="shipping_service" id="shipping_service"
                                            class="form-select custom-select" disabled>
                                            <option value="">-- Pilih Layanan --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div id="shipping-info" class="shipping-info-card d-none">
                                        <div class="shipping-info-header">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>Informasi Pengiriman</strong>
                                        </div>
                                        <div class="shipping-info-content">
                                            <p id="service-description" class="service-desc"></p>
                                            <div class="shipping-details-row">
                                                <div class="shipping-detail-item">
                                                    <i class="fas fa-clock me-2"></i>
                                                    <span>Estimasi: <span id="etd" class="value"></span>
                                                        hari</span>
                                                </div>
                                                <div class="shipping-detail-item">
                                                    <i class="fas fa-money-bill me-2"></i>
                                                    <span>Biaya: <span id="shipping-cost" class="value"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="shipping_cost" id="shipping_cost_input"
                                            value="0">
                                        <input type="hidden" name="city_id" id="city_id" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="checkout__totals-wrapper">
                        <div class="sticky-content">
                            <div class="checkout__totals">
                                <h3>PESANAN ANDA</h3>

                                <!-- Bagian ini menampilkan produk yang dipilih -->
                                <div class="selected-product-list">
                                    @php
                                        // Ambil item yang dipilih dari session
                                        $selectedItems = session()->get('selected_cart_items', []);
                                        $cartItems = \Surfsidemedia\Shoppingcart\Facades\Cart::instance(
                                            'cart',
                                        )->content();
                                        $selectedCartItems = $cartItems->filter(function ($item) use ($selectedItems) {
                                            return in_array($item->rowId, $selectedItems);
                                        });
                                    @endphp

                                    @foreach ($selectedCartItems as $item)
                                        <div class="selected-product-item">
                                            <img src="{{ asset('uploads/products/thumbnails') }}/{{ $item->model->image }}"
                                                alt="{{ $item->name }}" class="product-image-small">
                                            <div class="product-details">
                                                <div class="product-name">{{ $item->name }}</div>
                                                <div class="product-specs">
                                                    <span><i class="fas fa-cubes"></i> Qty: {{ $item->qty }}</span>
                                                    @if (isset($item->options['size_name']))
                                                        <span><i class="fas fa-ruler-combined"></i> Ukuran:
                                                            {{ $item->options['size_name'] }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="product-price">
                                                {{ formatRupiah($item->subtotal(0, '', '')) }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Perhitungan harga berdasarkan item yang dipilih -->
                                @if (Session::has('checkout'))
                                    <table class="checkout-totals">
                                        <tbody>
                                            <tr>
                                                <th>Subtotal</th>
                                                <td class="text-right">
                                                    {{ formatRupiah(session()->get('checkout')['subtotal']) }}
                                                </td>
                                            </tr>
                                            @if (session()->get('checkout')['discount'] > 0)
                                                <tr>
                                                    <th>Diskon
                                                        {{ Session::has('coupon') ? Session('coupon')['code'] : '' }}</th>
                                                    <td class="text-right">
                                                        -{{ formatRupiah(session()->get('checkout')['discount']) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Subtotal Setelah Diskon</th>
                                                    <td class="text-right">
                                                        {{ formatRupiah(session()->get('checkout')['subtotal'] - session()->get('checkout')['discount']) }}
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th>Ongkos Kirim</th>
                                                <input type="hidden" name="ongkir" id="ongkirinput" value="0">
                                                <td class="text-right">
                                                    <div class="shipping-info" id="ongkir-display">
                                                        <span>Dihitung berdasarkan pilihan kurir</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="cart-total">
                                                <th>Total</th>
                                                <td class="text-right" id="total-price">
                                                    {{ formatRupiah(session()->get('checkout')['total']) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-warning">
                                        Terjadi kesalahan dalam menghitung total pembelian.
                                        <a href="{{ route('cart.index') }}">Kembali ke keranjang</a>
                                    </div>
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
                                        id="mode_2" value="manual_atm">
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
                // Menggunakan nilai dari session checkout untuk subtotal yang benar
                let cartTotal = parseFloat(
                    '{{ session()->has('checkout') ? session()->get('checkout')['subtotal'] : 0 }}');

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

                    // Update di bagian JavaScript checkout.blade.php
                    // Tambahkan kode ini di dalam calculateShipping function

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

                        console.log('Calculating shipping from Samosir to City ID:', cityId);

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

                                // Tampilkan info origin city - UPDATE INI
                                console.log('🚚 Menghitung ongkir dari: Kabupaten Samosir, Sumatera Utara');
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    let options = '<option value="">-- Pilih Layanan --</option>';

                                    // Log informasi meta data dari response
                                    if (response.meta) {
                                        console.log('📍 Origin:', response.meta.origin_info);
                                        console.log('📦 Berat:', response.meta.weight);
                                        console.log('🚛 Kurir:', response.meta.courier);
                                    }

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

                                    // Tampilkan notifikasi sukses
                                    showShippingInfo(`Ongkir berhasil dihitung dari Kabupaten Samosir`);
                                } else {
                                    alert('Gagal menghitung ongkos kirim: ' + response.message);
                                    $('#shipping_service').html(
                                        '<option value="">-- Pilih Layanan --</option>');
                                }
                            },
                            error: function(xhr) {
                                console.error('Error calculating shipping:', xhr.responseText);
                                alert('Terjadi kesalahan saat menghitung ongkos kirim');
                                $('#shipping_service').html(
                                '<option value="">-- Pilih Layanan --</option>');
                            }
                        });
                    }

                    // Fungsi tambahan untuk menampilkan info pengiriman
                    function showShippingInfo(message) {
                        // Buat notifikasi sementara
                        const notification = $(`
        <div class="alert alert-info alert-dismissible fade show" style="margin-top: 10px;">
            <i class="fas fa-info-circle"></i> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `);

                        // Tampilkan di bawah dropdown kurir
                        $('#courier').parent().append(notification);

                        // Auto hide setelah 5 detik
                        setTimeout(() => {
                            notification.fadeOut();
                        }, 5000);
                    }
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

                    // Dapatkan subtotal dan discount dari session checkout
                    @if (Session::has('checkout'))
                        let subtotal =
                            {{ session()->get('checkout')['subtotal'] - session()->get('checkout')['discount'] }};
                    @else
                        let subtotal = cartTotal;
                    @endif

                    const newTotal = subtotal + shippingCost;
                    let courier = $('#courier').val();

                    // Update tampilan ongkir
                    if (shippingCost > 0) {
                        $('#ongkir-display').html(formatRupiah(shippingCost));
                    } else {
                        $('#ongkir-display').html(`
                            <span>Dihitung berdasarkan pilihan kurir</span>
                        `);
                    }

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

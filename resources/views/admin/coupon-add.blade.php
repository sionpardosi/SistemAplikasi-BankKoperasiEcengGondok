@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Coupon Information</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('admin.coupons') }}">
                        <div class="text-tiny">Coupons</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">New Coupon</div>
                </li>
            </ul>
        </div>
        <!-- new-coupon -->
        <div class="wg-box">
            <form class="form-new-product form-style-1" method="POST" action="{{ route('admin.coupon.store') }}">
                @csrf
                <fieldset class="name">
                    <div class="body-title">Kode Kupon <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Contoh: DISKON50K" name="code"
                           value="{{ old('code') }}" aria-required="true" style="text-transform: uppercase;">
                    <small class="text-muted">Gunakan huruf besar dan angka, contoh: DISKON50K</small>
                </fieldset>
                @error("code") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Nilai Diskon <span class="tf-color-1">*</span></div>
                    <input class="flex-grow format-rupiah" type="text" placeholder="Rp 50.000" name="discount_amount"
                           value="{{ old('discount_amount') }}" aria-required="true">
                    <small class="text-muted">Masukkan nilai diskon dalam rupiah (minimal Rp 1.000)</small>
                </fieldset>
                @error("discount_amount") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Minimum Order <span class="tf-color-1">*</span></div>
                    <input class="flex-grow format-rupiah" type="text" placeholder="Rp 100.000" name="minimum_order"
                           value="{{ old('minimum_order', '0') }}" aria-required="true">
                    <small class="text-muted">Minimum pembelian untuk menggunakan kupon (0 = tidak ada minimum)</small>
                </fieldset>
                @error("minimum_order") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Tanggal Kadaluarsa <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="date" name="expiry_date"
                           value="{{ old('expiry_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" aria-required="true">
                    <small class="text-muted">Kupon akan otomatis tidak aktif setelah tanggal ini</small>
                </fieldset>
                @error("expiry_date") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Simpan Kupon</button>
                </div>
            </form>
        </div>
        <!-- /new-coupon -->
    </div>
    <!-- /main-content-wrap -->
</div>
@endsection

@push('scripts')
<script>
    // Fungsi formatRupiah (sama seperti yang digunakan di halaman lain)
    function formatRupiah(angka, prefix) {
        var number_string = angka.toString().replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix === undefined ? rupiah : (rupiah ? prefix + rupiah : '');
    }

    $(document).ready(function(){
        $('form').on('submit', function(){
            // Bersihkan field value
            var val = $('input[name="value"]').val();
            val = val.replace(/[^0-9.]/g, '');
            $('input[name="value"]').val(val);
            // Bersihkan field cart_value
            var cartVal = $('input[name="cart_value"]').val();
            cartVal = cartVal.replace(/[^0-9.]/g, '');
            $('input[name="cart_value"]').val(cartVal);
        });
    });
</script>

<script>
    // Format input rupiah
    $(document).ready(function(){
        // Format rupiah saat mengetik
        $('.format-rupiah').on('input', function(){
            let value = this.value.replace(/[^0-9]/g, '');
            this.value = formatRupiah(value);
        });

        // Bersihkan format sebelum submit
        $('form').on('submit', function(){
            $('.format-rupiah').each(function(){
                let cleanValue = this.value.replace(/[^0-9]/g, '');
                this.value = cleanValue;
            });
        });
    });

    function formatRupiah(value) {
        if (!value) return '';
        return 'Rp ' + parseInt(value).toLocaleString('id-ID');
    }
    </script>
@endpush

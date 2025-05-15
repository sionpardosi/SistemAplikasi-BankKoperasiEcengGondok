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
                    <div class="body-title">Coupon Code <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Coupon Code" name="code" tabindex="0" value="{{ old('code') }}" aria-required="true">
                </fieldset>
                @error("code") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="category">
                    <div class="body-title">Coupon Type</div>
                    <div class="select flex-grow">
                        <select class="" name="type">
                            <option value="">Select</option>
                            <option value="fixed" @if(old('type')=="fixed") selected @endif>Fixed</option>
                            <option value="percent" @if(old('type')=="percent") selected @endif>Percent</option>
                        </select>
                    </div>
                </fieldset>
                @error("type") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Value <span class="tf-color-1">*</span></div>
                    <!-- Jika ada nilai lama, format dengan formatRupiah -->
                    <input class="flex-grow" type="text" placeholder="Coupon Value" name="value" tabindex="0" value="{{ old('value') ? formatRupiah(old('value')) : '' }}" aria-required="true">
                </fieldset>
                @error("value") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Cart Value <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Cart Value" name="cart_value" tabindex="0" value="{{ old('cart_value') ? formatRupiah(old('cart_value')) : '' }}" aria-required="true">
                </fieldset>
                @error("cart_value") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Expiry Date <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="date" placeholder="Expiry Date" name="expiry_date" tabindex="0" value="{{ old('expiry_date') }}" aria-required="true">
                </fieldset>
                @error("expiry_date") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Save</button>
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
@endpush

@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Coupon infomation</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('admin.index')}}"><div class="text-tiny">Dashboard</div></a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{route('admin.coupons')}}"><div class="text-tiny">Coupons</div></a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit Coupon</div>
                </li>
            </ul>
        </div>
        <!-- new-category -->
        <div class="wg-box">
            <form class="form-new-product form-style-1" method="POST" action="{{route('admin.coupon.update')}}">
                @csrf
                @method("put")
                <input type="hidden" name="id" value="{{$coupon->id}}" />

                <fieldset class="name">
                    <div class="body-title">Kode Kupon <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Kode Kupon" name="code"
                           value="{{$coupon->code}}" aria-required="true" style="text-transform: uppercase;">
                </fieldset>
                @error("code") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Nilai Diskon <span class="tf-color-1">*</span></div>
                    <input class="flex-grow format-rupiah" type="text" placeholder="Nilai Diskon" name="discount_amount"
                           value="{{ formatRupiah($coupon->discount_amount) }}" aria-required="true">
                </fieldset>
                @error("discount_amount") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Minimum Order <span class="tf-color-1">*</span></div>
                    <input class="flex-grow format-rupiah" type="text" placeholder="Minimum Order" name="minimum_order"
                           value="{{ formatRupiah($coupon->minimum_order) }}" aria-required="true">
                </fieldset>
                @error("minimum_order") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Tanggal Kadaluarsa <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="date" name="expiry_date"
                           value="{{$coupon->expiry_date->format('Y-m-d')}}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" aria-required="true">
                </fieldset>
                @error("expiry_date") <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Perbarui Kupon</button>
                </div>
            </form>
        </div>
        <!-- /new-category -->
    </div>
    <!-- /main-content-wrap -->
</div>

</div>
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
@endsection

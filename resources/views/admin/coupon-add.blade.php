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
            <form class="form-new-product form-style-1" method="POST" action="{{ route('admin.coupon.store') }}" id="couponForm">
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
                           value="{{ old('minimum_order') }}" aria-required="true">
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
    // Fungsi untuk format rupiah
    function formatRupiah(value) {
        if (!value) return '';
        // Hapus semua karakter kecuali angka
        let number = value.toString().replace(/[^0-9]/g, '');
        if (number === '') return '';

        // Format dengan pemisah ribuan
        return 'Rp ' + parseInt(number).toLocaleString('id-ID');
    }

    $(document).ready(function(){
        // Format rupiah saat mengetik
        $('.format-rupiah').on('input', function(){
            let value = this.value.replace(/[^0-9]/g, '');
            if (value !== '') {
                this.value = formatRupiah(value);
            }
        });

        // Tangani paste event
        $('.format-rupiah').on('paste', function(e) {
            setTimeout(() => {
                let value = this.value.replace(/[^0-9]/g, '');
                if (value !== '') {
                    this.value = formatRupiah(value);
                }
            }, 1);
        });

        // Bersihkan format sebelum submit
        $('#couponForm').on('submit', function(e){
            $('.format-rupiah').each(function(){
                let cleanValue = this.value.replace(/[^0-9]/g, '');
                this.value = cleanValue;
            });
        });

        // Set default value untuk minimum order jika kosong
        $('input[name="minimum_order"]').on('blur', function(){
            if (this.value === '' || this.value === 'Rp ') {
                this.value = 'Rp 0';
            }
        });
    });
</script>
@endpush

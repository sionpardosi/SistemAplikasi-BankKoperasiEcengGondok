@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        {{-- ====================================================================================================
             Wrapper Konten Utama
        ==================================================================================================== --}}
        <div class="main-content-wrap">

            {{-- ========================================================================
                 Header & Breadcrumbs
            ======================================================================== --}}
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Tambah Slide Baru</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dasbor</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('admin.slide.add') }}">
                            <div class="text-tiny">Slide</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Slide Baru</div>
                    </li>
                </ul>
            </div>

            {{-- ========================================================================
                 Form Tambah Slide Baru
            ======================================================================== --}}
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('admin.slide.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    {{-- Fieldset Tagline --}}
                    <fieldset class="name">
                        <div class="body-title">Tagline<span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Masukkan tagline" name="tagline" tabindex="0"
                            value="{{ old('tagline') }}" aria-required="true" required="">
                    </fieldset>
                    @error('tagline')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    {{-- Fieldset Judul --}}
                    <fieldset class="name">
                        <div class="body-title">Judul<span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Masukkan judul" name="title" tabindex="0"
                            value="{{ old('title') }}" aria-required="true" required="">
                    </fieldset>
                    @error('title')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    {{-- Fieldset Subjudul --}}
                    <fieldset class="name">
                        <div class="body-title">Subjudul<span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Masukkan subjudul" name="subtitle"
                            tabindex="0" value="{{ old('subtitle') }}" aria-required="true" required="">
                    </fieldset>
                    @error('subtitle')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    {{-- Fieldset Tautan --}}
                    <fieldset class="name">
                        <div class="body-title">Tautan<span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Masukkan tautan" name="link" tabindex="0"
                            value="{{ old('link') }}" aria-required="true" required="">
                    </fieldset>
                    @error('link')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    {{-- Fieldset Unggah Gambar --}}
                    <fieldset>
                        <div class="body-title">Unggah Gambar <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview" style="display: none;">
                                <img src="sample.jpg" class="effect8" alt="" />
                            </div>
                            <div class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">
                                        Tarik gambar ke sini atau <span class="tf-color">klik untuk memilih</span>
                                    </span>
                                    <input type="file" id="myFile" name="image">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('image')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    {{-- Fieldset Status --}}
                    <fieldset class="category">
                        <div class="body-title">Status</div>
                        <div class="select flex-grow">
                            <select class="" name="status">
                                <option>Pilih</option>
                                <option value="1" @if (old('status') == '1') selected @endif>Aktif</option>
                                <option value="0" @if (old('status') == '0') selected @endif>Nonaktif</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('status')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    {{-- Tombol Simpan --}}
                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
            {{-- ========================================================================
                 End Form Tambah Slide Baru
            ======================================================================== --}}
        </div>
        {{-- ========================================================================
             End Wrapper Konten Utama
        ======================================================================== --}}
    </div>
@endsection

{{-- ====================================================================================================
     Script JavaScript untuk Pratinjau Gambar
==================================================================================================== --}}
@push('scripts')
    <script>
        $(function() {
            $("#myFile").on("change", function(e) {
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });
        });
    </script>
@endpush

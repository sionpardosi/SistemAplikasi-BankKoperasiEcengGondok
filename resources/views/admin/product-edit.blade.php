@extends('layouts.admin')

@section('content')
    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Produk</h3>
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
                        <a href="{{ route('admin.products') }}">
                            <div class="text-tiny">Produk</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Edit produk</div>
                    </li>
                </ul>
            </div>
            <!-- form-edit-product -->
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
                action="{{ route('admin.product.update') }}">
                <input type="hidden" name="id" value="{{ $product->id }}" />
                @csrf
                @method('PUT')
                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">Nama Produk <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Masukkan nama produk" name="name"
                            tabindex="0" value="{{ $product->name }}" aria-required="true" required="">
                        <div class="text-tiny">Jangan melebihi 100 karakter saat memasukkan nama produk.</div>
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Masukkan slug produk" name="slug"
                            tabindex="0" value="{{ $product->slug }}" aria-required="true" required="">
                        <div class="text-tiny">Jangan melebihi 100 karakter saat memasukkan slug produk.</div>
                    </fieldset>

                    <div class="gap22 cols">
                        <fieldset class="category">
                            <div class="body-title mb-10">Kategori <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select class="" name="category_id">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="brand">
                            <div class="body-title mb-10">Merek <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select class="" name="brand_id">
                                    <option value="">Pilih Merek</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                    </div>

                    <fieldset class="shortdescription">
                        <div class="body-title mb-10">Deskripsi Singkat <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10 ht-150" name="short_description" placeholder="Deskripsi Singkat" tabindex="0"
                            aria-required="true" required="">{{ $product->short_description }}</textarea>
                        <div class="text-tiny">Jangan melebihi 100 karakter saat memasukkan deskripsi singkat.</div>
                    </fieldset>

                    <fieldset class="description">
                        <div class="body-title mb-10">Deskripsi <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10" name="description" placeholder="Deskripsi" tabindex="0" aria-required="true" required="">{{ $product->description }}</textarea>
                        <div class="text-tiny">Isi dengan deskripsi lengkap produk.</div>
                    </fieldset>
                </div>
                <div class="wg-box">
                    <fieldset>
                        <div class="body-title">Unggah Gambar <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            @if ($product->image)
                                <div class="item" id="imgpreview">
                                    <img src="{{ asset('uploads/products') }}/{{ $product->image }}" class="effect8"
                                        alt="{{ $product->name }}">
                                </div>
                            @endif
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span class="tf-color">click to
                                            browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="body-title mb-10">Unggah Gambar Galeri</div>
                        <div class="upload-image mb-16">
                            @if ($product->images)
                                @foreach (explode(',', $product->images) as $img)
                                    <div class="item gitems">
                                        <img src="{{ asset('uploads/products') }}/{{ trim($img) }}" class="effect8"
                                            alt="{{ $product->name }}">
                                    </div>
                                @endforeach
                            @endif

                            <div id ="galUpload" class="item up-load">
                                <label class="uploadfile" for="gFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="text-tiny">Drop your images here or select <span class="tf-color">click
                                            to browse</span></span>
                                    <input type="file" id="gFile" name="images[]" accept="image/*" multiple>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <div class="cols gap22">
                        <!-- Tampilkan nilai awal dengan format rupiah menggunakan helper -->
                        <fieldset class="name">
                            <div class="body-title mb-10">Harga Normal <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Masukkan harga normal"
                                name="regular_price" tabindex="0" value="{{ formatRupiah($product->regular_price) }}"
                                aria-required="true" required="">
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Harga Diskon <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Masukkan harga diskon" name="sale_price"
                                tabindex="0" value="{{ formatRupiah($product->sale_price) }}" aria-required="true"
                                required="">
                        </fieldset>
                    </div>

                    <!-- Bagian Ukuran Produk yang Diperbarui -->
                    <div class="wg-box">
                        <fieldset>
                            <div class="d-flex align-items-center mb-3">
                                <input type="checkbox" name="has_sizes" id="has_sizes" class="me-2"
                                    {{ $product->sizes && $product->sizes->count() > 0 ? 'checked' : '' }}>
                                <label for="has_sizes" class="body-title mb-0">Produk ini memiliki ukuran</label>
                            </div>

                            <!-- Bagian untuk ukuran dan stok (akan disembunyikan/ditampilkan dengan JavaScript) -->
                            <div id="sizes-container"
                                style="{{ $product->sizes && $product->sizes->count() > 0 ? '' : 'display: none;' }}">
                                <div class="mb-3">
                                    <div class="body-title mb-10">Ukuran Produk</div>
                                    <small class="text-muted d-block mb-2">Pilih ukuran yang tersedia beserta
                                        stoknya.</small>

                                    <!-- Ukuran yang sudah ada dalam database -->
                                    <div class="existing-sizes mb-4">
                                        <div class="body-title mb-2" style="font-size: 14px;">Ukuran yang Tersedia</div>
                                        <div class="row">
                                            @php
                                                $productSizes = $product->sizes
                                                    ? $product->sizes->pluck('pivot.stock', 'id')->toArray()
                                                    : [];
                                            @endphp

                                            @foreach ($sizes as $size)
                                                <div class="col-md-4 mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <input type="checkbox" name="sizes[]"
                                                            id="size_{{ $size->id }}" value="{{ $size->id }}"
                                                            class="size-checkbox me-2"
                                                            {{ isset($productSizes[$size->id]) ? 'checked' : '' }}>
                                                        <label for="size_{{ $size->id }}"
                                                            class="me-2">{{ $size->name }}</label>
                                                    </div>
                                                    <div class="stock-input"
                                                        style="{{ isset($productSizes[$size->id]) ? '' : 'display: none;' }}">
                                                        <input type="number" name="stocks[{{ $size->id }}]"
                                                            min="0" placeholder="Stok" class="form-control"
                                                            value="{{ $productSizes[$size->id] ?? 0 }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Bagian untuk menambahkan ukuran baru -->
                                    <div class="new-sizes-section">
                                        <div class="body-title mb-2" style="font-size: 14px;">Tambah Ukuran Baru</div>
                                        <div id="new-sizes-container">
                                            <div class="new-size-row d-flex align-items-center mb-2">
                                                <input type="text" name="new_sizes[]" placeholder="Ukuran baru"
                                                    class="form-control me-2" style="width: 150px;">
                                                <input type="number" name="new_stocks[]" min="0"
                                                    placeholder="Stok" class="form-control" style="width: 100px;"
                                                    value="0">
                                                <button type="button" class="btn btn-danger ms-2 remove-new-size"
                                                    style="display:none;">Hapus</button>
                                            </div>
                                        </div>
                                        <button type="button" id="add-new-size" class="btn btn-primary btn-sm mt-2">
                                            Tambah Ukuran Baru
                                        </button>
                                    </div>
                                </div>
                            </div>

                            @error('sizes')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @error('stocks')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @error('new_sizes')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @error('new_stocks')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Masukkan SKU" name="SKU"
                                tabindex="0" value="{{ $product->SKU }}" aria-required="true" required="">
                        </fieldset>
                        <fieldset class="name" id="quantity-field"
                            style="{{ $product->sizes && $product->sizes->count() > 0 ? 'display: none;' : '' }}">
                            <div class="body-title mb-10">Kuantitas <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Masukkan kuantitas" name="quantity"
                                tabindex="0" value="{{ $product->quantity }}" aria-required="true" required="">
                        </fieldset>
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Stok</div>
                            <div class="select mb-10">
                                <select class="" name="stock_status">
                                    <option value="instock" {{ $product->stock_status == 'instock' ? 'Selected' : '' }}>
                                        Tersedia</option>
                                    <option value="outofstock"
                                        {{ $product->stock_status == 'outofstock' ? 'Selected' : '' }}>Habis
                                    </option>
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Produk Unggulan</div>
                            <div class="select mb-10">
                                <select class="" name="featured">
                                    <option value="0" {{ $product->featured == '0' ? 'Selected' : '' }}>Tidak
                                    </option>
                                    <option value="1" {{ $product->featured == '1' ? 'Selected' : '' }}>Ya</option>
                                </select>
                            </div>
                        </fieldset>
                    </div>
                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Perbarui Produk</button>
                    </div>
                </div>
            </form>
            <!-- /form-edit-product -->
        </div>
        <!-- /main-content-wrap -->
    </div>
    <!-- /main-content-wrap -->
@endsection
@push('scripts')
    <script>
        $(function() {
            // Preview gambar utama
            $("#myFile").on("change", function(e) {
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });

            // Preview gambar galeri
            $("#gFile").on("change", function(e) {
                $(".gitems").remove();
                const gphotos = this.files;
                $.each(gphotos, function(key, val) {
                    $("#galUpload").prepend(
                        `<div class="item gitems"><img src="${URL.createObjectURL(val)}" alt=""></div>`
                    );
                });
            });

            // Otomatis update slug ketika nama produk diubah
            $("input[name='name']").on("change", function() {
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });

            // Toggle checkbox ukuran
            $("#has_sizes").on("change", function() {
                if ($(this).is(":checked")) {
                    $("#sizes-container").slideDown();
                    // Reset quantity field jika ukuran diaktifkan
                    if ($(".size-checkbox:checked").length > 0 ||
                        $("input[name='new_sizes[]']").filter(function() {
                            return $(this).val() !== "";
                        }).length > 0) {
                        $("#quantity-field").hide();
                    }
                } else {
                    $("#sizes-container").slideUp();
                    $("#quantity-field").show();
                }
            });

            // Tampilkan input stok ketika ukuran dipilih
            $(".size-checkbox").on("change", function() {
                const stockInput = $(this).closest('.col-md-4').find('.stock-input');
                if ($(this).is(":checked")) {
                    stockInput.slideDown();
                } else {
                    stockInput.slideUp();
                }

                // Sembunyikan quantity field jika ada ukuran yang dipilih
                toggleQuantityField();
            });

            // Tambah ukuran baru
            $("#add-new-size").on("click", function() {
                let container = $("#new-sizes-container");
                let newRow = $(`
                    <div class="new-size-row d-flex align-items-center mb-2">
                        <input type="text" name="new_sizes[]" placeholder="Ukuran baru"
                               class="form-control me-2" style="width: 150px;">
                        <input type="number" name="new_stocks[]" min="0" placeholder="Stok"
                               class="form-control" style="width: 100px;" value="0">
                        <button type="button" class="btn btn-danger ms-2 remove-new-size">Hapus</button>
                    </div>
                `);
                container.append(newRow);

                // Tambahkan event listener untuk input ukuran baru
                newRow.find("input[name='new_sizes[]']").on("input", toggleQuantityField);

                // Tambahkan event listener untuk tombol hapus
                newRow.find(".remove-new-size").on("click", function() {
                    $(this).closest('.new-size-row').remove();
                    toggleQuantityField();
                });

                // Update status quantity field
                toggleQuantityField();
            });

            // Event handler untuk tombol hapus pada ukuran baru
            $(".remove-new-size").on("click", function() {
                $(this).closest('.new-size-row').remove();
                toggleQuantityField();
            });

            // Event listener untuk input ukuran baru yang sudah ada
            $("input[name='new_sizes[]']").on("input", toggleQuantityField);

            // Fungsi untuk toggle quantity field berdasarkan status ukuran
            function toggleQuantityField() {
                if ($("#has_sizes").is(":checked")) {
                    const hasExistingSizes = $(".size-checkbox:checked").length > 0;
                    const hasNewSizes = $("input[name='new_sizes[]']").filter(function() {
                        return $(this).val() !== "";
                    }).length > 0;

                    if (hasExistingSizes || hasNewSizes) {
                        $("#quantity-field").hide();
                    } else {
                        $("#quantity-field").show();
                    }
                } else {
                    $("#quantity-field").show();
                }
            }

            // Format input ketika input kehilangan fokus (blur)
            $('input[name="regular_price"], input[name="sale_price"]').on('blur', function() {
                let value = $(this).val();
                // Hapus karakter yang bukan angka atau koma
                let numeric = value.replace(/[^0-9,]/g, '');
                // Ubah nilai input menjadi format Rupiah
                $(this).val(formatRupiah(numeric, 'Rp '));
            });

            // Run once at page load to set correct state
            toggleQuantityField();
        });

        function StringToSlug(Text) {
            return Text.toLowerCase()
                .replace(/[^\w ]+/g, "")
                .replace(/ +/g, "-");
        }

        // Fungsi untuk format Rupiah di JavaScript
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                var separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
        }
    </script>

    <script>
        // Fungsi untuk menghitung total stok secara real-time
        function calculateTotalStock() {
            if ($("#has_sizes").is(":checked")) {
                let totalStock = 0;

                // Hitung dari ukuran yang sudah ada
                $(".size-checkbox:checked").each(function() {
                    let sizeId = $(this).val();
                    let stock = parseInt($("input[name='stocks[" + sizeId + "]']").val()) || 0;
                    totalStock += stock;
                });

                // Hitung dari ukuran baru
                $("input[name='new_stocks[]']").each(function() {
                    let stock = parseInt($(this).val()) || 0;
                    let sizeName = $(this).closest('.new-size-row').find("input[name='new_sizes[]']").val();
                    if (sizeName && sizeName.trim() !== '') {
                        totalStock += stock;
                    }
                });

                // Update display total stok (opsional)
                if ($("#total-stock-display").length === 0) {
                    $("#sizes-container").append(
                        '<div id="total-stock-display" class="alert alert-info mt-2"><strong>Total Stok: <span id="total-stock-value">0</span></strong></div>'
                    );
                }
                $("#total-stock-value").text(totalStock);
            }
        }

        // Event listeners untuk menghitung ulang stok
        $(document).on('input', 'input[name^="stocks"], input[name^="new_stocks"]', calculateTotalStock);
        $(document).on('change', '.size-checkbox', calculateTotalStock);
        $(document).on('input', 'input[name^="new_sizes"]', calculateTotalStock);
    </script>
@endpush

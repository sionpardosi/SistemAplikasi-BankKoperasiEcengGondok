@extends('layouts.admin')

@section('content')
    <style>
        .table-striped th:nth-child(1),
        .table-striped td:nth-child(1) {
            width: 100px;
        }

        .table-striped th:nth-child(2),
        .table-striped td:nth-child(2) {
            width: 250px;
        }
    </style>
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Produk</h3>
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
                        <div class="text-tiny">Produk</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" name="name"
                                    tabindex="2" value="" aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.product.add') }}"><i class="icon-plus"></i>Tambah Produk</a>
                </div>
                <div class="table-responsive">
                    @if (Session::has('status'))
                        <p class="alert alert-success">{{ Session::get('status') }}</p>
                    @endif
                    <table class="table table-striped table-bordered">
                        {{-- ====================== Header Tabel Produk ====================== --}}
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Harga Diskon</th>
                                <th>SKU</th>
                                <th>Kategori</th>
                                <th>Merek</th>
                                <th>Unggulan</th>
                                <th>Stok</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        {{-- ====================== End Header Tabel Produk ====================== --}}

                        {{-- ====================== Data Tabel Produk ====================== --}}
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{ asset('uploads/products/thumbnails') }}/{{ $product->image }}"
                                                alt="{{ $product->name }}" class="image">
                                        </div>
                                        <div class="name">
                                            <a href="#" class="body-title-2">{{ $product->name }}</a>
                                            <div class="text-tiny mt-3">{{ $product->slug }}</div>
                                        </div>
                                    </td>
                                    <td>{{ formatRupiah($product->regular_price) }}</td>
                                    <td>{{ formatRupiah($product->sale_price) }}</td>
                                    <td>{{ $product->SKU }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->brand->name }}</td>
                                    <td>{{ $product->featured == 0 ? 'No' : 'Yes' }}</td>
                                    <td>{{ $product->stock_status }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>
                                        <div class="list-icon-function">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                            <a href="{{ route('admin.product.edit', ['id' => $product->id]) }}">
                                                <div class="item edit">
                                                    <i class="icon-edit-3"></i>
                                                </div>
                                            </a>
                                            <form action="{{ route('admin.product.delete', ['id' => $product->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="item text-danger delete">
                                                    <i class="icon-trash-2"></i>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        {{-- ====================== End Data Tabel Produk ====================== --}}
                    </table>

                </div>

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

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

            $("#gFile").on("change", function(e) {
                $(".gitems").remove();
                const gphotos = this.files;
                $.each(gphotos, function(key, val) {
                    $("#galUpload").prepend(
                        `<div class="item gitems"><img src="${URL.createObjectURL(val)}" alt=""></div>`
                    );
                });
            });

            $("input[name='name']").on("change", function() {
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });

            // Format harga ketika input kehilangan fokus (blur)
            $('input[name="regular_price"], input[name="sale_price"]').on('blur', function() {
                let value = $(this).val();
                let numeric = value.replace(/[^0-9,]/g, '');
                $(this).val(formatRupiah(numeric, 'Rp '));
            });
        });

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

        function StringToSlug(Text) {
            return Text.toLowerCase()
                .replace(/[^\w ]+/g, "")
                .replace(/ +/g, "-");
        }
    </script>

    <script>
        $(function() {
            $(".delete").on('click', function(e) {
                e.preventDefault();
                var selectedForm = $(this).closest('form');
                swal({
                    title: "Are you sure?",
                    text: "Apakah Kamu Ingin Mengapus Produk ini?",
                    type: "warning",
                    buttons: ["No!", "Yes!"],
                    confirmButtonColor: '#dc3545'
                }).then(function(result) {
                    if (result) {
                        selectedForm.submit();
                    }
                });
            });
        });
    </script>
@endpush

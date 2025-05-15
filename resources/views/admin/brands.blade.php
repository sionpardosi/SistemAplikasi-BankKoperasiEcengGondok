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
                <h3>Merek</h3>
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
                        <div class="text-tiny">Merek</div>
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
                    <a class="tf-button style-1 w208" href="{{ route('admin.brand.add') }}"><i class="icon-plus"></i>Tambah
                        Merek</a>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        @if (Session::has('status'))
                            <p class="alert alert-success">{{ Session::get('status') }}</p>
                        @endif
                        <table class="table table-striped table-bordered">
                            {{-- ======================== Header Tabel ======================== --}}
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle; ">#</th>
                                    <th style="text-align: center; vertical-align: middle; ">Nama Merek</th>
                                    <th style="text-align: center; vertical-align: middle; ">Slug</th>
                                    <th style="text-align: center; vertical-align: middle; ">Jumlah Produk</th>
                                    <th style="text-align: center; vertical-align: middle; ">Aksi</th>
                                </tr>
                            </thead>

                            {{-- ======================== Data Tabel ============================ --}}
                            <tbody>
                                @foreach ($brands as $brand)
                                    <tr style="text-align: center;">
                                        {{-- ID Merek --}}
                                        <td style="text-align: center; vertical-align: middle;">{{ $brand->id }}</td>

                                        {{-- Nama Merek & Gambar --}}
                                        <td style="text-align: center; vertical-align: middle;">
                                            <div style="display: flex; flex-direction: column; align-items: center;">
                                                <div style="margin-bottom: 5px;">
                                                    <img src="{{ asset('uploads/brands') }}/{{ $brand->image }}"
                                                        alt="{{ $brand->name }}" style="max-width: 80px; height: auto;">
                                                </div>
                                                <div>
                                                    <a href="#"
                                                        style="font-weight: bold; text-decoration: none; color: #333;">
                                                        {{ $brand->name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Slug Merek --}}
                                        <td style="text-align: center; vertical-align: middle;">{{ $brand->slug }}</td>

                                        {{-- Jumlah Produk --}}
                                        <td style="text-align: center; vertical-align: middle;">
                                            <a href="#" target="_blank"
                                                style="text-decoration: none; color: #007bff;">1</a>
                                        </td>

                                        {{-- Aksi: Edit & Hapus --}}
                                        <td style="text-align: center; vertical-align: middle;">
                                            <div style="display: flex; justify-content: center; gap: 10px;">
                                                {{-- Tombol Edit --}}
                                                <a href="{{ route('admin.brand.edit', ['id' => $brand->id]) }}"
                                                    style="color: #17a2b8; font-size: 18px;">
                                                    <i class="icon-edit-3"></i>
                                                </a>

                                                {{-- Tombol Hapus --}}
                                                <form action="{{ route('admin.brand.delete', ['id' => $brand->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        style="border: none; background: none; color: #dc3545; font-size: 18px;">
                                                        <i class="icon-trash-2"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            {{-- ======================== End Data Tabel ========================= --}}
                        </table>

                    </div>
                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        {{ $brands->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $(".delete").on('click', function(e) {
                e.preventDefault();
                var selectedForm = $(this).closest('form');
                swal({
                    title: "Apakah Anda Yakin?",
                    text: "Data ini akan dihapus secara permanen!",
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

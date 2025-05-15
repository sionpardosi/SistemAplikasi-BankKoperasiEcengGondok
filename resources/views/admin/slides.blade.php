@extends('layouts.admin')

@section('content')
    {{-- ====================================================================================================
     Halaman Slider Admin
==================================================================================================== --}}
    <div class="main-content-inner">

        {{-- ========================================================================
         Wrapper Konten Utama
    ======================================================================== --}}
        <div class="main-content-wrap">

            {{-- ========================================================================
             Header & Breadcrumbs
        ======================================================================== --}}
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Slider</h3>
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
                        <div class="text-tiny">Slides</div>
                    </li>
                </ul>
            </div>

            {{-- ========================================================================
             Konten Utama Box
        ======================================================================== --}}
            <div class="wg-box">

                {{-- ====================================================================
                 Filter & Tambah Data
            ==================================================================== --}}
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
                    <a class="tf-button style-1 w208" href="{{ route('admin.slide.add') }}">
                        <i class="icon-plus"></i> Add new
                    </a>
                </div>

                {{-- ========================================================================
                 Tabel Data Slider
            ======================================================================== --}}
                <div class="wg-table table-all-user">
                    @if (Session::has('status'))
                        <p class="alert alert-success">{{ Session::get('status') }}</p>
                    @endif

                    <table class="table table-striped table-bordered">

                        {{-- ======================== Header Tabel ======================== --}}
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th scope="col" style="width: 5%;">#</th>
                                <th scope="col" style="width: 15%;">Gambar</th>
                                <th scope="col" style="width: 20%;">Tagline</th>
                                <th scope="col" style="width: 20%;">Judul</th>
                                <th scope="col" style="width: 20%;">Subjudul</th>
                                <th scope="col" style="width: 15%;">Tautan</th>
                                <th scope="col" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        {{-- ======================== End Header Tabel ==================== --}}

                        {{-- ======================== Data Tabel ============================ --}}
                        @foreach ($slides as $slide)
                            <tbody>
                                <tr>
                                    <td>{{ $slide->id }}</td>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{ asset('uploads/slides') }}/{{ $slide->image }}" alt=""
                                                class="{{ $slide->title }}">
                                        </div>
                                    </td>
                                    <td>{{ $slide->tagline }}</td>
                                    <td>{{ $slide->title }}</td>
                                    <td>{{ $slide->subtitle }}</td>
                                    <td>{{ $slide->link }}</td>
                                    <td>
                                        {{-- Tombol Edit & Hapus --}}
                                        <div class="list-icon-function">
                                            <a href="{{ route('admin.slide.edit', ['id' => $slide->id]) }}">
                                                <div class="item edit">
                                                    <i class="icon-edit-3"></i>
                                                </div>
                                            </a>
                                            <form action="{{ route('admin.slide.delete', ['id' => $slide->id]) }}"
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
                        {{-- ======================== End Data Tabel ========================= --}}
                        </tbody>
                    </table>
                </div>
                {{-- ========================================================================
                 End Tabel Data Slider
            ======================================================================== --}}

                <div class="divider"></div>

                {{-- ========================================================================
                 Pagination
            ======================================================================== --}}
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $slides->links('pagination::bootstrap-5') }}
                </div>
            </div>
            {{-- ========================================================================
             End Konten Utama Box
        ======================================================================== --}}
        </div>
        {{-- ========================================================================
         End Wrapper Konten Utama
    ======================================================================== --}}
    </div>
@endsection

{{-- ====================================================================================================
     Script JavaScript untuk Fungsi Hapus Data
==================================================================================================== --}}
@push('scripts')
    <script>
        $(function() {
            $(".delete").on('click', function(e) {
                e.preventDefault();
                var selectedForm = $(this).closest('form');
                swal({
                    title: "Are you sure?",
                    text: "You want to delete this record?",
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

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
                <h3>Stok Bahan Baku</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.stok.index') }}">
                            <div class="text-tiny">Stok Bahan Baku</div>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <form action="{{ route('admin.stok.update', $stok->id) }}" method="POST" class="">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ $stok->tanggal }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Jumlah (kg)</label>
                        <input type="number" name="jumlah_kg" class="form-control" value="{{ $stok->jumlah_kg }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control fs-5">{{ $stok->keterangan }}</textarea>
                    </div>

                    <button class="btn btn-primary fs-4">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Tambahkan SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endsection

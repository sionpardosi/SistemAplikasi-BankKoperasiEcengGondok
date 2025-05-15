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
                {{-- <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <input type="text" id="search" class="form-control" placeholder="Cari request pemasok..."
                            style="height: 50px; font-size: 16px;">
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.supplier.request.add') }}">
                        <i class="icon-plus"></i> Tambah Request Pemasok
                    </a>
                </div> --}}

                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <form method="POST" class="mb-4 row g-3" action="{{ route('admin.stok.store') }}">
                            @csrf
                            <div class="col-md-3"><input name="tanggal" type="date" class="form-control" required></div>
                            <div class="col-md-3"><input name="jumlah_kg" type="number" class="form-control"
                                    placeholder="Jumlah (kg)" required></div>
                            <div class="col-md-4"><input name="keterangan" type="text" class="form-control"
                                    placeholder="Keterangan (opsional)"></div>
                            <div class="col-md-2"><button class="btn btn-success w-100 h-100 fs-4">Tambah</button></div>
                        </form>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah (kg)</th>
                                    <th>Sumber</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stok as $s)
                                    <tr>
                                        <td>{{ $s->tanggal }}</td>
                                        <td>{{ $s->jumlah_kg }}</td>
                                        <td>{{ $s->sumber }}</td>
                                        <td>{{ $s->keterangan ?? '-' }}</td>
                                        <td class="flex items-center justify-between flex-wrap">
                                            <a href="{{ route('admin.stok.edit', $s->id) }}"
                                                class="btn btn-primary w-50 fs-4">Edit</a>
                                            <form action="{{ route('admin.stok.delete', $s->id) }}" method="POST"
                                                class="delete-form w-50">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-danger delete-button w-100 fs-4">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $stok->links() }}
                    </div>

                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        <ul id="pagination" class="pagination"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tambahkan SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const form = this.closest('.delete-form');
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data yang dihapus tidak bisa dikembalikan.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

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

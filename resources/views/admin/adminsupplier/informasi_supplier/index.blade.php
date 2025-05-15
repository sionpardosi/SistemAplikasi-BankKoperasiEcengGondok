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
                <h3>Informasi Halaman Deskripsi Pemasok</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.supplier.index') }}">
                            <div class="text-tiny">Pemasok</div>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-end gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <input type="text" id="search" class="form-control" placeholder="Cari informasi pemasok..."
                            style="height: 50px; font-size: 16px;">
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.adminsupplier.informasi_supplier.create') }}">
                        <i class="icon-plus"></i> Tambah informasi
                    </a>
                </div>

                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Gambar</th>
                                    <th>Urutan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($supplierInfos as $index => $info)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $info->title }}</td>
                                        <td>{{ Str::limit($info->description, 100) }}</td>
                                        <td>
                                            @if($info->image)
                                                <img src="{{ asset($info->image) }}" alt="{{ $info->title }}" width="100">
                                            @else
                                                <span class="badge bg-warning">Tidak ada gambar</span>
                                            @endif
                                        </td>
                                        <td>{{ $info->order }}</td>
                                        <td>
                                            @if($info->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-group">
                                                <a href="{{ route('admin.adminsupplier.informasi_supplier.edit', $info->id) }}"
                                                   class="btn btn-sm btn-info">
                                                    <i class="icon-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.adminsupplier.informasi_supplier.delete', $info->id) }}"
                                                      method="POST" class="delete-form d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger delete-button">
                                                        <i class="icon-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada informasi pemasok</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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

            // Filter fungsi untuk pencarian
            document.getElementById('search').addEventListener('keyup', function() {
                const searchValue = this.value.toLowerCase();
                const tableRows = document.querySelectorAll('tbody tr');

                tableRows.forEach(row => {
                    const title = row.cells[1].textContent.toLowerCase();
                    const description = row.cells[2].textContent.toLowerCase();

                    if (title.includes(searchValue) || description.includes(searchValue)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
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

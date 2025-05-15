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
                <h3>Request Pemasok</h3>
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
                    {{-- <div class="wg-filter flex-grow">
                        <input type="text" id="search" class="form-control" placeholder="Cari request pemasok..."
                            style="height: 50px; font-size: 16px;">
                    </div> --}}
                    <a class="tf-button style-1 w208" href="{{ route('admin.supplier.request.add') }}">
                        <i class="icon-plus"></i> Tambah Request Pemasok
                    </a>
                </div>

                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <form method="GET" class="mb-3 row g-2">
                            <div class="col-md-2">
                                <select name="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>
                                        Disetujui</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="kecamatan" class="form-control" placeholder="Kecamatan"
                                    value="{{ request('kecamatan') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="nama" class="form-control" placeholder="Nama"
                                    value="{{ request('nama') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="tanggal_dari" class="form-control"
                                    value="{{ request('tanggal_dari') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="tanggal_sampai" class="form-control"
                                    value="{{ request('tanggal_sampai') }}">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary w-100 mb-3">Filter</button>
                                <a href="{{ route('admin.supplier.request.export', request()->query()) }}"
                                    class="btn btn-success w-100">
                                    📥 Export ke Excel
                                </a>
                            </div>
                        </form>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Lokasi</th>
                                    <th>Jumlah (kg)</th>
                                    <th>Insentif</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($requests as $req)
                                    <tr>
                                        <td>{{ $req->created_at->format('d M Y') }}</td>
                                        <td>{{ $req->nama }}</td>
                                        <td>{{ $req->kecamatan ? $req->kecamatan . ', ' . $req->desa : '-' }}</td>
                                        <td>{{ $req->estimasi_kg }}</td>
                                        <td>{{ $req->insentif == 'diskon' ? 'DISKON 🎟️' : 'CASH 💵' }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $req->status == 'pending' ? 'warning text-dark' : ($req->status == 'disetujui' ? 'success' : 'danger') }}">
                                                {{ ucfirst($req->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.supplier.request.edit', $req->id) }}"
                                                class="btn btn-lg btn-primary">Kelola</a>
                                            <form method="POST"
                                                action="{{ route('admin.supplier.request.delete', $req->id) }}"
                                                class="d-inline-block delete-form">
                                                @csrf @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-lg btn-outline-danger delete-button">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $requests->links() }}
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

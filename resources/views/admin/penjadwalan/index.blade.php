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
                <h3>Manajemen Jadwal Penjemputan</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.penjadwalan.index') }}">
                            <div class="text-tiny">Jadwal Penjemputan</div>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-end gap10 flex-wrap">
                    <a class="tf-button style-1 w208" href="{{ route('admin.penjadwalan.add') }}">
                        <i class="icon-plus"></i> Atur Jadwal Penjemputan
                    </a>
                    <a href="{{ route('admin.penjadwalan.export') }}" class="btn btn-success mb-3 h-100 fs-4">📥 Export
                        Jadwal ke
                        Excel</a>

                </div>

                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <div>
                            <h4 class="my-4">📅 Timeline Penjemputan</h4>

                            <ul class="list-group mb-4">
                                @forelse ($jadwals->sortBy('tanggal_jemput') as $jadwal)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $jadwal->tanggal_jemput }}</strong> -
                                            {{ $jadwal->kecamatan ? $jadwal->kecamatan . ', ' . $jadwal->desa : '-' }}
                                            ({{ $jadwal->estimasi_kg }} kg)
                                            <br><small>Supplier: {{ $jadwal->request->nama ?? '-' }}</small>
                                        </div>
                                        <span
                                            class="badge {{ $jadwal->status_jemput == 'terjadwal' ? 'bg-primary' : ($jadwal->status_jemput == 'dijemput' ? 'bg-success' : 'bg-danger') }}">
                                            {{ ucfirst($jadwal->status_jemput) }}
                                        </span>
                                    </li>
                                @empty
                                    <li class="list-group-item text-center">Belum ada jadwal.</li>
                                @endforelse
                            </ul>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Lokasi</th>
                                    <th>Jumlah (kg)</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwals as $jadwal)
                                    <tr>
                                        <td>{{ $jadwal->tanggal_jemput }}</td>
                                        <td>{{ $jadwal->kecamatan ? $jadwal->kecamatan . ', ' . $jadwal->desa : '-' }}</td>
                                        <td>{{ $jadwal->estimasi_kg }}</td>
                                        <td>{{ ucfirst($jadwal->status_jemput) }}</td>
                                        <td>
                                            <a href="{{ route('admin.penjadwalan.edit', $jadwal->id) }}"
                                                class="btn btn-warning btn-lg fs-4">Edit</a>

                                            <form method="POST"
                                                action="{{ route('admin.penjadwalan.delete', $jadwal->id) }}"
                                                class="d-inline-block delete-form">
                                                @csrf @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-lg btn-outline-danger delete-button">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $jadwals->links() }}
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

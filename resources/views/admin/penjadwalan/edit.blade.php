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

        .form-group label {
            font-size: 16px;
            /* Ukuran font label */
            font-weight: bold;
            margin-bottom: 6px;
            margin-top: 16px;
        }

        .form-control {
            font-size: 14px !important;
            /* Ukuran teks input */
            padding: 10px;
            margin-bottom: 10px;
            /* Ruang padding agar lebih luas */
        }

        .btn-primary {
            font-size: 14px !important;
            /* Ukuran teks tombol */
            padding: 10px 15px;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Jadwal Penjemputan</h3>
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
                <form action="{{ route('admin.penjadwalan.update', $jadwal->id) }}" method="POST" class="">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label style="font-size: 16px;">Permintaan Pemasok</label>
                        <select name="supplier_request_id" class="form-control" required disabled>
                            @foreach ($requests as $req)
                                <option value="{{ $req->id }}"
                                    {{ $jadwal->supplier_request_id == $req->id ? 'selected' : '' }}>
                                    [{{ $req->created_at->format('d M Y') }}] - {{ $req->nama }} ({{ $req->kecamatan }}),
                                    ({{ $req->desa }})
                                    -
                                    {{ $req->estimasi_kg }} kg
                                </option>
                            @endforeach
                        </select>
                        <small style="font-size: 14px; margin-bottom:10px;" class="text-muted">Request tidak bisa
                            diubah.</small>
                    </div>

                    <div class="mb-3" style="margin-top: 16px;">
                        <label style="font-size: 16px;">Tanggal Penjemputan</label>
                        <input type="date" name="tanggal_jemput" class="form-control"
                            value="{{ $jadwal->tanggal_jemput }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Kecamatan</label>
                            <select id="kecamatan" name="kecamatan" class="form-control" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                <option value="Harian" {{ $jadwal->kecamatan == 'Harian' ? 'selected' : '' }}>Harian
                                </option>
                                <option value="Nainggolan" {{ $jadwal->kecamatan == 'Nainggolan' ? 'selected' : '' }}>
                                    Nainggolan</option>
                                <option value="Onan Runggu" {{ $jadwal->kecamatan == 'Onan Runggu' ? 'selected' : '' }}>
                                    Onan Runggu</option>
                                <option value="Palipi" {{ $jadwal->kecamatan == 'Palipi' ? 'selected' : '' }}>Palipi
                                </option>
                                <option value="Pangururan" {{ $jadwal->kecamatan == 'Pangururan' ? 'selected' : '' }}>
                                    Pangururan</option>
                                <option value="Ronggur Nihuta"
                                    {{ $jadwal->kecamatan == 'Ronggur Nihuta' ? 'selected' : '' }}>Ronggur Nihuta</option>
                                <option value="Sianjur Mulamula"
                                    {{ $jadwal->kecamatan == 'Sianjur Mulamul' ? 'selected' : '' }}>Sianjur Mulamula
                                </option>
                                <option value="Simanindo" {{ $jadwal->kecamatan == 'Simanindo' ? 'selected' : '' }}>
                                    Simanindo</option>
                                <option value="Sitio-tio" {{ $jadwal->kecamatan == 'Sitio-tio' ? 'selected' : '' }}>
                                    Sitio-tio</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Desa</label>
                            <select id="desa" name="desa" class="form-control" required disabled>
                                <option value="">-- Pilih Desa --</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Detail Lokasi</label>
                        <input type="text" name="detail_lokasi" class="form-control"
                            placeholder="Contoh: Dekat Pasar, Samping Sekolah" required
                            value="{{ $jadwal->detail_lokasi }}">
                    </div>

                    <div class="mb-3">
                        <label style="font-size: 16px;">Estimasi Berat (kg)</label>
                        <input type="number" name="estimasi_kg" class="form-control" value="{{ $jadwal->estimasi_kg }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label style="font-size: 16px;">Status Penjemputan</label>
                        <select name="status_jemput" class="form-control" required>
                            <option value="terjadwal" {{ $jadwal->status_jemput == 'terjadwal' ? 'selected' : '' }}>
                                Terjadwal</option>
                            <option value="dijemput" {{ $jadwal->status_jemput == 'dijemput' ? 'selected' : '' }}>Dijemput
                            </option>
                            <option value="dibatalkan" {{ $jadwal->status_jemput == 'dibatalkan' ? 'selected' : '' }}>
                                Dibatalkan</option>
                        </select>
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

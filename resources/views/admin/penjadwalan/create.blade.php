@extends('layouts.admin')

@section('content')
    <style>
        .form-group label {
            font-size: 16px;
            /* Ukuran font label */
            font-weight: bold;
            margin-bottom: 6px;
            margin-top: 10px;
        }

        .form-control {
            font-size: 14px !important;
            /* Ukuran teks input */
            padding: 10px;
            margin-bottom: 10px;
            /* Ruang padding agar lebih luas */
        }

        .form-check-inline {}

        .btn-primary {
            font-size: 14px !important;
            /* Ukuran teks tombol */
            padding: 10px 15px;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Atur Jadwal Penjemputan</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.penjadwalan.index') }}">
                            <div class="text-tiny">Jadwal Penjemputan</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Create</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <form action="{{ route('admin.penjadwalan.store') }}" method="POST" class="form-group"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label>Permintaan Pemasok</label>
                        <select name="supplier_request_id" class="form-control" required>
                            <option value="">-- Pilih Request --</option>
                            @foreach ($requests as $req)
                                <option value="{{ $req->id }}">
                                    [{{ $req->created_at->format('d M Y') }}] - {{ $req->nama }} ({{ $req->lokasi }}) -
                                    {{ $req->estimasi_kg }} kg
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Tanggal Penjemputan</label>
                        <input type="date" name="tanggal_jemput" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Kecamatan</label>
                            <select id="kecamatan" name="kecamatan" class="form-control" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                <option value="Harian">Harian</option>
                                <option value="Nainggolan">Nainggolan</option>
                                <option value="Onan Runggu">Onan Runggu</option>
                                <option value="Palipi">Palipi</option>
                                <option value="Pangururan">Pangururan</option>
                                <option value="Ronggur Nihuta">Ronggur Nihuta</option>
                                <option value="Sianjur Mulamula">Sianjur Mulamula</option>
                                <option value="Simanindo">Simanindo</option>
                                <option value="Sitio-tio">Sitio-tio</option>
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
                            placeholder="Contoh: Dekat Pasar, Samping Sekolah" required>
                    </div>

                    <div class="mb-3">
                        <label>Estimasi Berat (kg)</label>
                        <input type="number" name="estimasi_kg" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-lg btn-success fs-3">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tambahkan SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if ($errors->has('error'))
            Swal.fire({
                title: 'Gagal!',
                text: '{{ $errors->first('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endsection


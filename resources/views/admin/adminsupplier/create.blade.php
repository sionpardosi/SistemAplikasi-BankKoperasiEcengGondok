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
                <h3>Create Request Pemasok</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.supplier.index') }}">
                            <div class="text-tiny">Pemasok</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Create</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <form action="{{ route('admin.supplier.request.store') }}" method="POST" class="form-group"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Data Pribadi -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama Anda"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda"
                                required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nomor HP / WhatsApp</label>
                            <input type="text" name="kontak" class="form-control"
                                placeholder="Masukkan nomor HP atau WhatsApp" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="disetujui">Disetujui</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>

                    <!-- Estimasi & Insentif -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Estimasi Jumlah Eceng Gondok (kg)</label>
                            <input type="number" name="estimasi_kg" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Jenis Insentif</label><br>
                            <div class="">
                                <input class="" type="radio" name="insentif" value="diskon" required>
                                <label class="">Diskon Produk</label>
                            </div>
                            <div class="">
                                <input class="" type="radio" name="insentif" value="uang_tunai">
                                <label class="">Uang Tunai</label>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Foto -->
                    <div class="mb-3">
                        <label>Upload Foto Eceng Gondok *</label>
                        <input type="file" name="foto" class="form-control" accept="image/*" required>
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

                    <!-- Catatan -->
                    <div class="mb-3">
                        <label>Catatan Tambahan</label>
                        <textarea name="catatan" rows="3" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Catatan Admin</label>
                        <textarea name="catatan_admin" class="form-control" rows="3"></textarea>
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

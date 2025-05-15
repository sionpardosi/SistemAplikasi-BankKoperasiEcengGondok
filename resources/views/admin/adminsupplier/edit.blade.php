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
                <h3>Edit Request Pemasok</h3>
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
                        <div class="text-tiny">Edit</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <form action="{{ route('admin.supplier.request.update', $request->id) }}" method="POST" class="fs-3">
                    @csrf @method('PUT')

                    <div class="d-flex flex-wrap gap-3">
                        <div class="card flex-fill" style="min-width: 200px;">
                            <div class="card-body">
                                <h5 class="card-title"><strong>Nama</strong></h5>
                                <p class="card-text">{{ $request->nama }}</p>
                            </div>
                        </div>
                        <div class="card flex-fill" style="min-width: 200px;">
                            <div class="card-body">
                                <h5 class="card-title"><strong>Email</strong></h5>
                                <p class="card-text">{{ '✉️ ' . $request->email }}</p>
                            </div>
                        </div>
                        <div class="card flex-fill" style="min-width: 200px;">
                            <div class="card-body">
                                <h5 class="card-title"><strong>Lokasi</strong></h5>
                                <p class="card-text">
                                    {{ $request->kecamatan ? '🏠 ' . $request->kecamatan . ', ' . $request->desa : '-' }}
                                </p>
                            </div>
                        </div>
                        <div class="card flex-fill" style="min-width: 200px;">
                            <div class="card-body">
                                <h5 class="card-title"><strong>Jumlah</strong></h5>
                                <p class="card-text">{{ '⚖️ ' . $request->estimasi_kg }} kg</p>
                            </div>
                        </div>
                        <div class="card flex-fill" style="min-width: 200px;">
                            <div class="card-body">
                                <h5 class="card-title"><strong>Insentif</strong></h5>
                                <p class="card-text">{{ $request->insentif == 'diskon' ? '🎟️ Diskon' : '💵 Uang Tunai' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if ($request->insentif != 'diskon')
                        <div class="mb-3">
                            <label>Perkiraan Total Insentif (Rp)</label>
                            <input type="text" class="form-control"
                                value="Rp {{ number_format($request->estimasi_kg * 60000, 0, ',', '.') }}" readonly>
                        </div>
                    @endif

                    <div style="margin-top: 16px;" class="mb-3">
                        <label>Status Permintaan</label>
                        <select name="status" class="form-control" required>
                            <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="disetujui" {{ $request->status == 'disetujui' ? 'selected' : '' }}>Disetujui
                            </option>
                            <option value="ditolak" {{ $request->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    @if ($request->insentif == 'diskon')
                        <div class="mb-3">
                            <label>Pilih Kupon Diskon</label>
                            <select name="kupon_id" class="form-control">
                                <option value="">-- Pilih Kupon --</option>
                                @foreach ($kupons as $kupon)
                                    <option value="{{ $kupon->id }}"
                                        {{ $request->kupon_id == $kupon->id ? 'selected' : '' }}>
                                        {{ $kupon->code }} - {{ $kupon->type }} - {{ $kupon->value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label>Catatan Admin</label>
                        <textarea name="catatan_admin" class="form-control" rows="3">{{ $request->catatan_admin }}</textarea>
                    </div>

                    <button class="btn btn-lg btn-success fs-3">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
@endsection

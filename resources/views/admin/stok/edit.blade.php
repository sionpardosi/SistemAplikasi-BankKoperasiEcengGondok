@extends('layouts.admin')

@section('content')
<style>
    .edit-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .form-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .form-header {
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }

    .form-group label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 12px 15px;
        font-size: 15px;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .btn-group-custom {
        gap: 10px;
    }

    .btn-modern {
        border-radius: 8px;
        font-weight: 600;
        padding: 12px 25px;
        transition: all 0.3s ease;
    }

    .btn-modern:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
</style>

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3><i class="icon-edit"></i> Edit Stok Bahan Baku</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{ route('admin.stok.index') }}"><div class="text-tiny">Stok Bahan Baku</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Edit</div></li>
            </ul>
        </div>

        <div class="edit-container">
            <div class="form-card">
                <div class="form-header">
                    <h4><i class="icon-layers"></i> Edit Data Stok Bahan Baku</h4>
                    <p class="text-muted mb-0">Ubah informasi stok bahan baku yang sudah ada</p>
                </div>

                <form action="{{ route('admin.stok.update', $stok->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tanggal"><i class="icon-calendar"></i> Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control"
                                       value="{{ $stok->tanggal }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="jumlah_kg"><i class="icon-package"></i> Jumlah (kg)</label>
                                <input type="number" step="0.1" name="jumlah_kg" id="jumlah_kg" class="form-control"
                                       value="{{ $stok->jumlah_kg }}" required>
                                <small class="text-muted">
                                    Gunakan angka negatif (-) untuk pengurangan stok
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="keterangan"><i class="icon-message-square"></i> Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="4"
                                  placeholder="Masukkan keterangan atau catatan tambahan...">{{ $stok->keterangan }}</textarea>
                    </div>

                    <div class="d-flex btn-group-custom justify-content-between">
                        <a href="{{ route('admin.stok.index') }}" class="btn btn-secondary btn-modern">
                            <i class="icon-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary btn-modern">
                            <i class="icon-check"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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

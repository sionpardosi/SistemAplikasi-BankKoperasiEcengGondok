@extends('layouts.admin')

@section('content')
<style>
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 25px;
        color: white;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .stats-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .status-alert {
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .form-section {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 20px;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 10px;
    }

    .table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .table th {
        background: #f8f9fa;
        border: none;
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
    }

    .badge-in {
        background: #d1f2eb;
        color: #0c5460;
        border: 1px solid #7dd3fc;
    }

    .badge-out {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .btn-modern {
        border-radius: 8px;
        font-weight: 600;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-modern:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
</style>

<div class="main-content-inner">
    <div class="main-content-wrap">
        <!-- Header -->
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3><i class="icon-layers"></i> Manajemen Stok Bahan Baku</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Stok Bahan Baku</div></li>
            </ul>
        </div>

        <!-- Dashboard Statistik -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number">{{ number_format($statistik['total_stok'], 1) }}</div>
                    <div class="stats-label"><i class="icon-layers"></i> Total Stok (kg)</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <div class="stats-number">{{ number_format($statistik['total_masuk'], 1) }}</div>
                    <div class="stats-label"><i class="icon-trending-up"></i> Total Masuk (kg)</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card" style="background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);">
                    <div class="stats-number">{{ number_format($statistik['total_keluar'], 1) }}</div>
                    <div class="stats-label"><i class="icon-trending-down"></i> Total Keluar (kg)</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="stats-number">{{ $stok->total() }}</div>
                    <div class="stats-label"><i class="icon-list"></i> Total Transaksi</div>
                </div>
            </div>
        </div>

        <!-- Status Alert -->
        @if(isset($statistik['status_stok']))
        <div class="alert alert-{{ $statistik['status_stok']['warna'] }} status-alert mb-4">
            <div class="d-flex align-items-center">
                <i class="icon-info me-3" style="font-size: 1.5rem;"></i>
                <div>
                    <strong>Status Stok: {{ ucfirst($statistik['status_stok']['status']) }}</strong><br>
                    {{ $statistik['status_stok']['pesan'] }}
                </div>
            </div>
        </div>
        @endif

        <!-- Form Tambah Stok -->
        <div class="form-section">
            <h5 class="section-title"><i class="icon-plus"></i> Tambah Stok Bahan Baku</h5>
            <form method="POST" class="row g-3" action="{{ route('admin.stok.store') }}">
                @csrf
                <div class="col-md-3">
                    <label class="form-label">Tanggal</label>
                    <input name="tanggal" type="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jumlah (kg)</label>
                    <input name="jumlah_kg" type="number" step="0.1" class="form-control" placeholder="0.0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Keterangan</label>
                    <input name="keterangan" type="text" class="form-control" placeholder="Sumber atau keterangan">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button class="btn btn-success btn-modern w-100">
                        <i class="icon-plus"></i> Tambah
                    </button>
                </div>
            </form>
        </div>

        <!-- Form Konsumsi Stok -->
        <div class="form-section">
            <h5 class="section-title"><i class="icon-minus"></i> Konsumsi Stok (Pengurangan)</h5>
            <form method="POST" class="row g-3" action="{{ route('admin.stok.konsumsi') }}">
                @csrf
                <div class="col-md-3">
                    <label class="form-label">Tanggal</label>
                    <input name="tanggal" type="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jumlah Konsumsi (kg)</label>
                    <input name="jumlah_kg" type="number" step="0.1" class="form-control" placeholder="0.0" max="{{ $statistik['total_stok'] }}" required>
                    <small class="text-muted">Maksimal: {{ number_format($statistik['total_stok'], 1) }} kg</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Keperluan Konsumsi</label>
                    <input name="keterangan" type="text" class="form-control" placeholder="Untuk produksi apa..." required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button class="btn btn-warning btn-modern w-100">
                        <i class="icon-minus"></i> Kurangi
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Data -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 120px;">Tanggal</th>
                            <th style="width: 80px;">Jenis</th>
                            <th style="width: 100px;">Jumlah (kg)</th>
                            <th style="width: 150px;">Sumber</th>
                            <th>Keterangan</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stok as $s)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($s->tanggal)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge {{ $s->jumlah_kg > 0 ? 'badge-in' : 'badge-out' }}">
                                    {{ $s->jenis_transaksi }}
                                </span>
                            </td>
                            <td class="fw-bold {{ $s->jumlah_kg > 0 ? 'text-success' : 'text-danger' }}">
                                {{ $s->jumlah_kg > 0 ? '+' : '' }}{{ number_format($s->jumlah_kg, 1) }}
                            </td>
                            <td>{{ $s->sumber }}</td>
                            <td>{{ $s->keterangan ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.stok.edit', $s->id) }}" class="btn btn-sm btn-primary">
                                        <i class="icon-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.stok.delete', $s->id) }}" method="POST" class="delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-button">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="icon-inbox" style="font-size: 3rem; color: #dee2e6;"></i>
                                <p class="mt-2 text-muted">Belum ada data stok bahan baku</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($stok->hasPages())
            <div class="p-3 border-top">
                {{ $stok->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Delete confirmation
    document.querySelectorAll('.delete-button').forEach(button => {
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

// Success/Error messages
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

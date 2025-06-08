{{-- filepath: resources/views/user/pending-order-details.blade.php --}}
@extends('layouts.app')

@section('content')
    <style>
        .card-custom {
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }
        .card-header-custom {
            background-color: #956a3b;
            color: #fff;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .badge-status {
            font-size: 1rem;
            padding: 6px 16px;
            border-radius: 30px;
            font-weight: 600;
        }
        .badge-pending {
            background: rgba(255,193,7,0.15);
            color: #856404;
        }
        .badge-success {
            background: rgba(40,167,69,0.15);
            color: #28a745;
        }
        .badge-danger {
            background: rgba(220,53,69,0.15);
            color: #dc3545;
        }
    </style>

    <main class="pt-90">
        <div class="container mw-930">
            <h2 class="page-title mb-4">Detail Lamaran Pekerjaan</h2>

            @if(isset($pendingOrder))
                <div class="card card-custom">
                    <div class="card-header card-header-custom">
                        <i class="fas fa-clock me-2"></i>Status Lamaran:
                        @if($pendingOrder->status == 'Diterima')
                            <span class="badge badge-status badge-success">Diterima</span>
                        @elseif($pendingOrder->status == 'Ditolak')
                            <span class="badge badge-status badge-danger">Ditolak</span>
                        @else
                            <span class="badge badge-status badge-pending">Diproses</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Posisi:</strong> {{ $pendingOrder->job->title ?? '-' }}
                        </div>
                        <div class="mb-3">
                            <strong>Tanggal Lamar:</strong> {{ $pendingOrder->created_at ? $pendingOrder->created_at->format('d-m-Y H:i') : '-' }}
                        </div>
                        <div class="mb-3">
                            <strong>Nama Pelamar:</strong> {{ $pendingOrder->user->name ?? '-' }}
                        </div>
                        <div class="mb-3">
                            <strong>Email:</strong> {{ $pendingOrder->user->email ?? '-' }}
                        </div>
                        <div class="mb-3">
                            <strong>Nomor Telepon:</strong> {{ $pendingOrder->phone_number ?? '-' }}
                        </div>
                        <div class="mb-3">
                            <strong>Pendidikan:</strong> {{ $pendingOrder->education_level ?? '-' }}
                        </div>
                        <div class="mb-3">
                            <strong>Pengalaman:</strong> {{ $pendingOrder->experience ?? '-' }}
                        </div>
                        <div class="mb-3">
                            <strong>Gaji Diharapkan:</strong> {{ $pendingOrder->expected_salary ? 'Rp' . number_format($pendingOrder->expected_salary, 0, ',', '.') : '-' }}
                        </div>
                        <div class="mb-3">
                            <strong>Keterampilan:</strong> {{ $pendingOrder->skills ?? '-' }}
                        </div>
                        <div class="mb-3">
                            <strong>Surat Lamaran:</strong> <br>
                            <span style="white-space: pre-line;">{{ $pendingOrder->cover_letter ?? '-' }}</span>
                        </div>
                        <div class="mb-3">
                            <strong>Informasi Tambahan:</strong> {{ $pendingOrder->additional_info ?? '-' }}
                        </div>
                        <div class="mb-3">
                            <strong>CV:</strong>
                            @if($pendingOrder->cv)
                                <a href="{{ asset('storage/'.$pendingOrder->cv) }}" target="_blank" class="btn btn-sm btn-info ms-2">Lihat CV</a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </div>
                </div>
                <a href="{{ url()->previous() }}" class="btn apply-btn"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
            @else
                <div class="alert alert-info">
                    Tidak ada data lamaran ditemukan.
                </div>
                <a href="{{ route('user.lamaran_saya') }}" class="btn apply-btn">Lihat Riwayat Lamaran</a>
            @endif
        </div>
    </main>
@endsection

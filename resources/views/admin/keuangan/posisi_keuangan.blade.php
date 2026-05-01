@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">

        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Laporan Posisi Keuangan</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{ route('admin.keuangan.dashboard') }}"><div class="text-tiny">Keuangan</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Posisi Keuangan</div></li>
            </ul>
        </div>

        {{-- Filter & Export --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.keuangan.posisi_keuangan') }}"
                      class="row align-items-end g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Per Tanggal</label>
                        <input type="date" name="sampai" class="form-control" value="{{ $sampai }}">
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="icon-search"></i> Tampilkan
                            </button>
                            <a href="{{ route('admin.keuangan.posisi_keuangan.pdf', ['sampai' => $sampai]) }}"
                               class="btn btn-danger" target="_blank">
                                <i class="icon-doc"></i> PDF
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @php
            $balance = round($totalAset, 2) === round($totalLiabilitasEkuitas, 2);
        @endphp

        {{-- Warning jika tidak balance --}}
        @if(!$balance)
            <div class="alert alert-warning">
                ⚠️ Aset (Rp {{ number_format($totalAset,0,',','.') }})
                tidak sama dengan Liabilitas + Ekuitas
                (Rp {{ number_format($totalLiabilitasEkuitas,0,',','.') }}).
                Periksa jurnal yang belum tercatat.
            </div>
        @endif

        {{-- Laporan --}}
        <div class="card shadow-sm" style="max-width:650px;margin:0 auto">
            <div class="card-header bg-white text-center py-3">
                <h5 class="mb-0 fw-bold">UMKM Lettes Eceng Gondok</h5>
                <div style="font-size:14px;color:#6c757d">Laporan Posisi Keuangan</div>
                <div style="font-size:13px;color:#6c757d">
                    Per Tanggal {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-borderless mb-0" style="font-size:14px">

                    {{-- ASET --}}
                    <thead>
                        <tr style="background:#e3f2fd">
                            <th colspan="2" class="px-4 py-2">ASET</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4">Kas</td>
                            <td class="text-end px-4">{{ number_format($kas, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="px-4">Piutang Usaha</td>
                            <td class="text-end px-4">{{ number_format($piutangUsaha, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="px-4">Persediaan Bahan Baku</td>
                            <td class="text-end px-4">{{ number_format($persediaanBahanBaku, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="fw-bold" style="border-top:2px solid #dee2e6">
                            <td class="px-4">Total Aset</td>
                            <td class="text-end px-4">{{ number_format($totalAset, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>

                    {{-- LIABILITAS --}}
                    <thead>
                        <tr style="background:#fff3e0">
                            <th colspan="2" class="px-4 py-2 pt-3">LIABILITAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4">Utang Usaha</td>
                            <td class="text-end px-4">{{ number_format($utangUsaha, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="fw-bold" style="border-top:2px solid #dee2e6">
                            <td class="px-4">Total Liabilitas</td>
                            <td class="text-end px-4">{{ number_format($totalLiabilitas, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>

                    {{-- EKUITAS --}}
                    <thead>
                        <tr style="background:#e8f5e9">
                            <th colspan="2" class="px-4 py-2 pt-3">EKUITAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4">Modal Pemilik</td>
                            <td class="text-end px-4">{{ number_format($modalPemilik, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="px-4">Laba Ditahan</td>
                            <td class="text-end px-4">{{ number_format($labaDitahan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="px-4">
                                Laba Berjalan
                                <small class="text-muted">(s/d {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }})</small>
                            </td>
                            <td class="text-end px-4"
                                style="color:{{ $labaBerjalan >= 0 ? '#28a745' : '#dc3545' }}">
                                {{ number_format($labaBerjalan, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr class="fw-bold" style="border-top:2px solid #dee2e6">
                            <td class="px-4">Total Ekuitas</td>
                            <td class="text-end px-4">{{ number_format($totalEkuitas, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>

                    {{-- TOTAL L+E --}}
                    <tbody>
                        <tr style="background:{{ $balance ? '#d4edda' : '#f8d7da' }};
                                   font-size:15px;font-weight:700;border-top:3px solid #dee2e6">
                            <td class="px-4 py-3">TOTAL LIABILITAS + EKUITAS</td>
                            <td class="text-end px-4 py-3">
                                {{ number_format($totalLiabilitasEkuitas, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white text-center text-muted" style="font-size:11px">
                Dicetak pada {{ now()->format('d M Y, H:i') }} WIB &nbsp;|&nbsp; Berdasarkan SAK EMKM
            </div>
        </div>

    </div>
</div>
@endsection

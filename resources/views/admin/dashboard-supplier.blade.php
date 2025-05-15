@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">

            {{-- Statistik Ringkasan --}}
            <div class="tf-section-2 mb-30">
                <div class="flex gap20 flex-wrap-mobile">

                    <div class="w-half">
                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-users"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Total Permintaan Pemasok</div>
                                        <h4>{{ $dashboardSupplier['total_request'] }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-package"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Total Stok Tersedia (kg)</div>
                                        <h4>{{ $dashboardSupplier['total_stok'] }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-calendar"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Total Jadwal Penjemputan</div>
                                        <h4>{{ $dashboardSupplier['total_jadwal'] }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-half">
                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-check-circle"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Jadwal Terlaksana</div>
                                        <h4>{{ $dashboardSupplier['total_jemput'] }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-x-circle"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Jadwal Batal</div>
                                        <h4>{{ $dashboardSupplier['total_batal'] }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-clock"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Jadwal Pending</div>
                                        <h4>{{ $dashboardSupplier['total_pending'] }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Filter dan Grafik --}}
                <div class="mt-4">
                    <form class="flex gap20 mb-4" method="GET" action="{{ route('admin.supplier.dashboard') }}">
                        <select name="status" class="form-select w-auto">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui
                            </option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>

                        <input type="date" name="start_date" class="form-control w-auto"
                            value="{{ request('start_date') }}">
                        <input type="date" name="end_date" class="form-control w-auto"
                            value="{{ request('end_date') }}">

                        <button class="btn btn-primary" type="submit">Filter</button>
                    </form>

                    <div id="chart-ringkasan" class="mb-5"></div>
                </div>

                {{-- List Quick Access --}}
                <div class="wg-box mt-4">
                    <div class="flex items-center justify-between">
                        <h5>Permintaan Pemasok Terbaru</h5>
                    </div>
                    <div class="wg-table table-all-user">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Kecamatan</th>
                                        <th class="text-center">Desa</th>
                                        <th class="text-center">Jumlah (kg)</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentRequests as $req)
                                        <tr>
                                            <td class="text-center">{{ $req->nama }}</td>
                                            <td class="text-center">{{ $req->kecamatan }}</td>
                                            <td class="text-center">{{ $req->desa }}</td>
                                            <td class="text-center">{{ $req->estimasi_kg }}</td>
                                            <td class="text-center">
                                                @if ($req->status == 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($req->status == 'disetujui')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @else
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $req->created_at->format('d-m-Y') }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.supplier.request.edit', $req->id) }}"
                                                    class="btn btn-sm btn-primary">Kelola</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada permintaan terbaru.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (document.querySelector("#chart-ringkasan")) {
            var options = {
                series: [{
                    name: 'Jumlah Permintaan',
                    data: {!! json_encode($chartData) !!}
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false,
                    },
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt',
                        'Nov', 'Des'
                    ]
                },
                colors: ['#2377FC'],
                dataLabels: {
                    enabled: true
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart-ringkasan"), options);
            chart.render();
        }
    });
</script>

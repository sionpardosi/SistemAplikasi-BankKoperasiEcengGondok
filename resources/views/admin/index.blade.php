@extends('layouts.admin')
@section('content')
    <style>
        /* Modern Dashboard Styling */
        .wg-chart-default {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }

        .wg-chart-default:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .image.ic-bg {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .image.ic-bg.pending {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        }

        .image.ic-bg.delivered {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
        }

        .image.ic-bg.canceled {
            background: linear-gradient(135deg, #dc3545 0%, #bd2130 100%);
        }

        .image.ic-bg i {
            color: white;
            font-size: 1.5rem;
        }

        .body-text {
            color: #6c757d;
            font-size: 0.875rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        h4 {
            color: #495057;
            font-weight: 700;
            font-size: 1.8rem;
            margin: 0;
        }

        .wg-box {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
        }

        .block-legend {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .dot.t1 { background: #007bff; }
        .dot.t2 { background: #ffc107; }
        .dot.t3 { background: #28a745; }
        .dot.t4 { background: #dc3545; }

        .text-tiny {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
        }

        .box-icon-trending {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .box-icon-trending.up {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table th {
            background: #f8f9fa;
            color: #495057;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border: none;
            padding: 1rem 0.75rem;
        }

        .table td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-top: 1px solid #e9ecef;
        }

        .table tbody tr:hover {
            background: rgba(0, 123, 255, 0.02);
        }

        .list-icon-function {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #f8f9fa;
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .list-icon-function:hover {
            background: #007bff;
            color: white;
            transform: translateY(-1px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .wg-chart-default {
                margin-bottom: 1rem;
            }

            .flex.gap20 {
                flex-direction: column;
            }

            .w-half {
                width: 100%;
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="tf-section-2 mb-30">
                <div class="flex gap20 flex-wrap-mobile">
                    <div class="w-half">

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Total Pesanan</div>
                                        <h4>{{ number_format($dashboardDatas[0]->Total) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-credit-card"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Total Pendapatan</div>
                                        <h4>{{ formatRupiah($dashboardDatas[0]->TotalAmount) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg pending">
                                        <i class="icon-clock"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Pesanan Menunggu</div>
                                        <h4>{{ number_format($dashboardDatas[0]->TotalOrdered) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg pending">
                                        <i class="icon-credit-card"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Nilai Pesanan Menunggu</div>
                                        <h4>{{ formatRupiah($dashboardDatas[0]->TotalOrderedAmount) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="w-half">

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg delivered">
                                        <i class="icon-truck"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Pesanan Terkirim</div>
                                        <h4>{{ number_format($dashboardDatas[0]->TotalDelivered) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg delivered">
                                        <i class="icon-credit-card"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Nilai Pesanan Terkirim</div>
                                        <h4>{{ formatRupiah($dashboardDatas[0]->TotalDeliveredAmount) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg canceled">
                                        <i class="icon-x-circle"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Pesanan Dibatalkan</div>
                                        <h4>{{ number_format($dashboardDatas[0]->TotalCanceled) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg canceled">
                                        <i class="icon-credit-card"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Nilai Pesanan Dibatalkan</div>
                                        <h4>{{ formatRupiah($dashboardDatas[0]->TotalCanceledAmount) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="wg-box">
                    <div class="flex items-center justify-between">
                        <h5>Pendapatan Bulanan</h5>
                        <div class="dropdown default">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="icon-more"><i class="icon-more-horizontal"></i></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a href="javascript:void(0);">Minggu Ini</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">Minggu Lalu</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap40">
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t1"></div>
                                    <div class="text-tiny">Total Pendapatan</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h4>{{ formatRupiah($TotalAmount) }}</h4>
                                <div class="box-icon-trending up">
                                    <i class="icon-trending-up"></i>
                                    <div class="body-title number">0.56%</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t2"></div>
                                    <div class="text-tiny">Menunggu</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h4>{{ formatRupiah($TotalOrderedAmount) }}</h4>
                            </div>
                        </div>
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t3"></div>
                                    <div class="text-tiny">Terkirim</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h4>{{ formatRupiah($TotalDeliveredAmount) }}</h4>
                            </div>
                        </div>
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t4"></div>
                                    <div class="text-tiny">Dibatalkan</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h4>{{ formatRupiah($TotalCanceledAmount) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div id="line-chart-8"></div>
                </div>

            </div>
            <div class="tf-section mb-30">

                <div class="wg-box">
                    <div class="flex items-center justify-between">
                        <h5>Pesanan Terbaru</h5>
                        <div class="dropdown default">
                            <a class="btn btn-secondary dropdown-toggle" href="{{ route('admin.orders') }}">
                                <span class="view-all">Lihat Semua</span>
                            </a>
                        </div>
                    </div>
                    <div class="wg-table table-all-user">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 80px">No. Pesanan</th>
                                        <th class="text-center">Nama Pelanggan</th>
                                        <th class="text-center">No. Telepon</th>
                                        <th class="text-center">Subtotal</th>
                                        <th class="text-center">Pajak</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Tanggal Pesanan</th>
                                        <th class="text-center">Jumlah Item</th>
                                        <th class="text-center">Tanggal Kirim</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="text-center">{{ '1' . str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                            </td>
                                            <td class="text-center">{{ $order->name }}</td>
                                            <td class="text-center">{{ $order->phone }}</td>
                                            <td class="text-center">{{ formatRupiah($order->subtotal) }}</td>
                                            <td class="text-center">{{ formatRupiah($order->tax ?? 0) }}</td>
                                            <td class="text-center"><strong>{{ formatRupiah($order->total) }}</strong></td>
                                            <td class="text-center">
                                                @if ($order->status == 'delivered')
                                                    <span class="badge bg-success">Terkirim</span>
                                                @elseif($order->status == 'canceled')
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                @elseif($order->status == 'pending')
                                                    <span class="badge bg-warning">Menunggu</span>
                                                @elseif($order->status == 'confirmed')
                                                    <span class="badge bg-info">Dikonfirmasi</span>
                                                @elseif($order->status == 'processing')
                                                    <span class="badge bg-primary">Diproses</span>
                                                @elseif($order->status == 'shipped')
                                                    <span class="badge bg-secondary">Dikirim</span>
                                                @elseif($order->status == 'completed')
                                                    <span class="badge bg-success">Selesai</span>
                                                @else
                                                    <span class="badge bg-warning">Dipesan</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
                                            <td class="text-center">{{ $order->orderItems->count() }}</td>
                                            <td class="text-center">
                                                {{ $order->delivered_date ? \Carbon\Carbon::parse($order->delivered_date)->format('d/m/Y') : '-' }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.order.items', ['order_id' => $order->id]) }}">
                                                    <div class="list-icon-function view-icon">
                                                        <div class="item eye">
                                                            <i class="icon-eye"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        (function($) {
            var tfLineChart = (function() {
                var chartBar = function() {
                    var options = {
                        series: [{
                                name: 'Total Pendapatan',
                                data: [{{ $AmountM }}]
                            }, {
                                name: 'Menunggu',
                                data: [{{ $OrderedAmountM }}]
                            },
                            {
                                name: 'Terkirim',
                                data: [{{ $DeliveredAmountM }}]
                            }, {
                                name: 'Dibatalkan',
                                data: [{{ $CanceledAmountM }}]
                            }
                        ],
                        chart: {
                            type: 'bar',
                            height: 325,
                            toolbar: {
                                show: false,
                            },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '10px',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        legend: {
                            show: false,
                        },
                        colors: ['#007bff', '#ffc107', '#28a745', '#dc3545'],
                        stroke: {
                            show: false,
                        },
                        xaxis: {
                            labels: {
                                style: {
                                    colors: '#212529',
                                },
                            },
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep',
                                'Okt', 'Nov', 'Des'
                            ],
                        },
                        yaxis: {
                            show: false,
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return "Rp " + new Intl.NumberFormat('id-ID').format(val);
                                }
                            }
                        }
                    };

                    chart = new ApexCharts(
                        document.querySelector("#line-chart-8"),
                        options
                    );
                    if ($("#line-chart-8").length > 0) {
                        chart.render();
                    }
                };

                /* Function ============ */
                return {
                    init: function() {},

                    load: function() {
                        chartBar();
                    },
                    resize: function() {},
                };
            })();

            jQuery(document).ready(function() {});

            jQuery(window).on("load", function() {
                tfLineChart.load();
            });

            jQuery(window).on("resize", function() {});
        })(jQuery);
    </script>
@endpush

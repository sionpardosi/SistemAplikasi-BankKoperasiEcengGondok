@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Header Section -->
            <div class="mb-4">
                <h3 class="text-primary font-weight-bold">Laporan Penjualan</h3>
            </div>

            <!-- Filter Card -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Filter Data</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ url('admin/laporanpenjualan') }}" class="row align-items-end">
                        <div class="col-md-4 mb-2">
                            <label for="start_date" class="form-label">Tanggal Awal</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request()->start_date }}"
                                class="form-control">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request()->end_date }}"
                                class="form-control">
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="d-flex gap-2">
                                <button type="submit" name="action" value="filter" class="btn btn-primary w-50">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                <button type="submit" name="action" value="pdf" class="btn btn-danger w-50">
                                    <i class="fas fa-file-pdf me-1"></i> PDF
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <!-- Data Table -->
            <div class="card shadow">
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="min-width: 100px;">Order No</th>
                                    <th style="min-width: 150px;">Customer Name</th>
                                    <th style="min-width: 120px;">Phone</th>
                                    <th style="min-width: 300px;">Items</th>
                                    <th style="min-width: 120px;">Tax</th>
                                    <th style="min-width: 120px;">Total</th>
                                    <th style="min-width: 120px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="fw-bold">{{ '1' . str_pad($order->order_id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>{{ $order->customer_phone }}</td>
                                        <td>
                                            <ul class="list-unstyled mb-0 p-2 bg-light rounded" style="font-size: 14px;">
                                                @foreach ($order->items as $item)
                                                    <li class="mb-2 border-bottom pb-1">
                                                        <strong>{{ $item->product_name }}</strong><br>
                                                        Qty: {{ $item->quantity }} |
                                                        Price: Rp. {{ number_format($item->price) }} |
                                                        Total: Rp. {{ number_format($item->price * $item->quantity) }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="text-end">
                                            Rp. {{ number_format($order->tax) }}
                                        </td>
                                        <td class="text-end fw-bold">
                                            Rp. {{ number_format($order->total) }}
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-{{ $order->order_status == 'delivered' ? 'success' : ($order->order_status == 'canceled' ? 'danger' : 'warning') }} rounded-pill px-3 py-2">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-center">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

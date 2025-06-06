@extends('layouts.admin')

@section('content')
    <style>
        .table-striped th:nth-child(1),
        .table-striped td:nth-child(1) {
            width: 100px;
        }

        .table-striped th:nth-child(2),
        .table-striped td:nth-child(2) {
            width: 250px;
        }

        .form-search .select select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-search {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .form-search fieldset {
            margin: 0;
        }

        .form-search input {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Orders</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">All Order</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap-3 flex-wrap mb-4">
                    <div class="wg-filter w-full">
                        <form class="form-search flex flex-wrap md:flex-nowrap items-center gap-3" method="GET"
                            action="{{ route('admin.orders') }}">

                            <input type="text" class="form-control" placeholder="Search name or phone..." name="search"
                                value="{{ request('search') }}" style="max-width: 250px;">

                            <select name="status" class="form-control" style="max-width: 100px; height: 40px;">
                                <option value="">All Status</option>
                                <option value="ordered" {{ request('status') == 'ordered' ? 'selected' : '' }}>Ordered
                                </option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered
                                </option>
                                <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled
                                </option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                            </select>

                            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 flex-shrink-0"
                                style="white-space: nowrap; height: 40px;">
                                <i class="icon-search"></i> <span>Search</span>
                            </button>
                        </form>
                    </div>
                </div>



                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 80px">Order No</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Subtotal</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Order Date</th>
                                    <th class="text-center">Total Items</th>
                                    <th class="text-center">Delivered On</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td class="text-center">{{ '1' . str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td class="text-center">{{ $order->name }}</td>
                                        <td class="text-center">{{ $order->phone }}</td>
                                        <td class="text-center">Rp. {{ number_format($order->subtotal) }}</td>
                                        <td class="text-center">Rp. {{ number_format($order->total) }}</td>
                                        <td class="text-center">
                                            @if ($order->status == 'delivered')
                                                <span class="badge bg-success">Delivered</span>
                                            @elseif($order->status == 'canceled')
                                                <span class="badge bg-danger">Canceled</span>
                                            @elseif($order->status == 'completed')
                                                <span class="badge bg-primary">Completed</span>
                                            @else
                                                <span class="badge bg-warning">Ordered</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $order->created_at }}</td>
                                        <td class="text-center">{{ $order->orderItems->count() }}</td>
                                        <td class="text-center">{{ $order->delivered_date }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.order.items', ['order_id' => $order->id]) }}">
                                                <div class="list-icon-function view-icon">
                                                    <div class="item eye"><i class="icon-eye"></i></div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

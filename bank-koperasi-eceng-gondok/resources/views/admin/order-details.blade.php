@extends('layouts.admin')

@section('content')
    <style>
        .table-transaction>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: #fff !important;
        }
    </style>
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Order Details</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Order Items</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box mt-5 mb-5">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Ordered Details</h5>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.orders') }}">Back</a>
                </div>
                <table class="table table-striped table-bordered table-transaction">
                    <tr>
                        <th>Order No</th>
                        <td>{{ '1' . str_pad($transaction->order->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <th>Mobile</th>
                        <td>{{ $transaction->order->phone }}</td>
                        <th>Pin/Zip Code</th>
                        <td>{{ $transaction->order->zip }}</td>
                    </tr>
                    <tr>
                        <th>Order Date</th>
                        <td>{{ $transaction->order->created_at }}</td>
                        <th>Delivered Date</th>
                        <td>{{ $transaction->order->delivered_date }}</td>
                        <th>Canceled Date</th>
                        <td>{{ $transaction->order->canceled_date }}</td>
                    </tr>
                    <tr>
                        <th>Order Status</th>
                        <td colspan="5">
                            @if ($transaction->order->status == 'delivered')
                                <span class="badge bg-success">Delivered</span>
                            @elseif($transaction->order->status == 'canceled')
                                <span class="badge bg-danger">Canceled</span>
                            @else
                                <span class="badge bg-warning">Ordered</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="wg-box mt-5">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Ordered Items</h5>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">SKU</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Brand</th>
                                <th class="text-center">Options</th>
                                <th class="text-center">Return Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderitems as $orderitem)
                                <tr>

                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{ asset('uploads/products/thumbnails') }}/{{ $orderitem->product->image }}"
                                                alt="{{ $orderitem->product->name }}" class="image">
                                        </div>
                                        <div class="name">
                                            <a href="{{ route('shop.product.details', ['product_slug' => $orderitem->product->slug]) }}"
                                                target="_blank" class="body-title-2">{{ $orderitem->product->name }}</a>
                                        </div>
                                    </td>
                                    <td class="text-center">${{ $orderitem->price }}</td>
                                    <td class="text-center">{{ $orderitem->quantity }}</td>


                                    <td class="text-center">{{ $orderitem->product->SKU }}</td>


                                    <td class="text-center">{{ $orderitem->product->category->name }}</td>
                                    <td class="text-center">{{ $orderitem->product->brand->name }}</td>
                                    <td class="text-center">{{ $orderitem->options }}</td>
                                    <td class="text-center">{{ $orderitem->rstatus == 0 ? 'No' : 'Yes' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('shop.product.details', ['product_slug' => $orderitem->product->slug]) }}"
                                            target="_blank">
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

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $orderitems->links('pagination::bootstrap-5') }}
                </div>
            </div>

            <div class="wg-box mt-5">
                <h5>Shipping Address</h5>
                <div class="my-account__address-item col-md-6">
                    <div class="my-account__address-item__detail">
                        <p>{{ $transaction->order->name }}</p>
                        <p>{{ $transaction->order->address }}</p>
                        <p>{{ $transaction->order->locality }}</p>
                        <p>{{ $transaction->order->city }}, {{ $transaction->order->country }}</p>
                        <p>{{ $transaction->order->landmark }}</p>
                        <p>{{ $transaction->order->zip }}</p>
                        <br />
                        <p>Mobile : {{ $transaction->order->phone }}</p>
                    </div>
                </div>
            </div>

            <div class="wg-box mt-5">
                <h5>Transactions</h5>
                <table class="table table-striped table-bordered table-transaction">
                    <tr>
                        <th>Subtotal</th>
                        <td>${{ $transaction->order->subtotal }}</td>
                        <th>Tax</th>
                        <td>${{ $transaction->order->tax }}</td>
                        <th>Discount</th>
                        <td>${{ $transaction->order->discount }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>${{ $transaction->order->total }}</td>
                        <th>Payment Mode</th>
                        <td>{{ $transaction->mode }}</td>
                        <th>Status</th>
                        <td>
                            @if ($transaction->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($transaction->status == 'declined')
                                <span class="badge bg-danger">Declined</span>
                            @elseif($transaction->status == 'refunded')
                                <span class="badge bg-secondary">Refunded</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection

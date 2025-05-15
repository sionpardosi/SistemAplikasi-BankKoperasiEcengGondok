@extends('layouts.admin')

@section('content')
    <style>
        .table-transaction>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: #fff !important;
        }

        .status-timeline {
            display: flex;
            align-items: center;
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            overflow-x: auto;
        }

        .status-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            flex: 1;
            min-width: 100px;
        }

        .status-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            margin-bottom: 8px;
            z-index: 1;
        }

        .status-active {
            background-color: #198754;
            color: white;
        }

        .status-completed {
            background-color: #0d6efd;
            color: white;
        }

        .status-canceled {
            background-color: #dc3545;
            color: white;
        }

        .status-label {
            font-size: 12px;
            text-align: center;
            white-space: nowrap;
        }

        .status-line {
            position: absolute;
            height: 3px;
            background-color: #e9ecef;
            width: 100%;
            top: 20px;
            left: 50%;
        }

        .status-date {
            font-size: 10px;
            color: #6c757d;
            margin-top: 4px;
        }
    </style>
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Detail Pesanan</h3>
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
                        <div class="text-tiny">Item Pesanan</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box mt-5 mb-5">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Detail Pesanan</h5>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.orders') }}">Kembali</a>
                </div>
                <div class="table-responsive">
                    @if (Session::has('status'))
                        <p class="alert alert-success">{{ Session::get('status') }}</p>
                    @endif
                    <table class="table table-striped table-bordered table-transaction">
                        <tr>
                            <th>No Pesanan</th>
                            <td>{{ '1' . str_pad($transaction->order->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <th>Nomor HP</th>
                            <td>{{ $transaction->order->phone }}</td>
                            <th>Kode Pos</th>
                            <td>{{ $transaction->order->zip }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pesan</th>
                            <td>{{ $transaction->order->created_at }}</td>
                            <th>Status Pesanan</th>
                            <td colspan="3">{!! $transaction->order->status_badge !!}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="wg-box mt-5 mb-5">
                <h5>Status Pesanan</h5>
                <div class="status-timeline">
                    <div class="status-step">
                        <div
                            class="status-icon {{ in_array($transaction->order->status, ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'completed']) ? 'status-completed' : ($transaction->order->status === 'canceled' ? 'status-canceled' : '') }}">
                            <i class="icon-clock"></i>
                        </div>
                        <div class="status-label">Menunggu</div>
                        <div class="status-date">
                            {{ $transaction->order->created_at ? $transaction->order->created_at->format('d/m/Y') : '-' }}
                        </div>
                    </div>
                    <div class="status-line"></div>
                    <div class="status-step">
                        <div
                            class="status-icon {{ in_array($transaction->order->status, ['confirmed', 'processing', 'shipped', 'delivered', 'completed']) ? 'status-completed' : ($transaction->order->status === 'canceled' ? 'status-canceled' : '') }}">
                            <i class="icon-check"></i>
                        </div>
                        <div class="status-label">Dikonfirmasi</div>
                        <div class="status-date">
                            {{ $transaction->order->confirmed_date ? \Carbon\Carbon::parse($transaction->order->confirmed_date)->format('d/m/Y') : '-' }}
                        </div>
                    </div>
                    <div class="status-line"></div>
                    <div class="status-step">
                        <div
                            class="status-icon {{ in_array($transaction->order->status, ['processing', 'shipped', 'delivered', 'completed']) ? 'status-completed' : ($transaction->order->status === 'canceled' ? 'status-canceled' : '') }}">
                            <i class="icon-box"></i>
                        </div>
                        <div class="status-label">Diproses</div>
                        <div class="status-date">
                            {{ $transaction->order->processing_date ? \Carbon\Carbon::parse($transaction->order->processing_date)->format('d/m/Y') : '-' }}
                        </div>
                    </div>
                    <div class="status-line"></div>
                    <div class="status-step">
                        <div
                            class="status-icon {{ in_array($transaction->order->status, ['shipped', 'delivered', 'completed']) ? 'status-completed' : ($transaction->order->status === 'canceled' ? 'status-canceled' : '') }}">
                            <i class="icon-truck"></i>
                        </div>
                        <div class="status-label">Dikirim</div>
                        <div class="status-date">
                            {{ $transaction->order->shipped_date ? \Carbon\Carbon::parse($transaction->order->shipped_date)->format('d/m/Y') : '-' }}
                        </div>
                    </div>
                    <div class="status-line"></div>
                    <div class="status-step">
                        <div
                            class="status-icon {{ in_array($transaction->order->status, ['delivered', 'completed']) ? 'status-completed' : ($transaction->order->status === 'canceled' ? 'status-canceled' : '') }}">
                            <i class="icon-package"></i>
                        </div>
                        <div class="status-label">Paket telah sampai</div>
                        <div class="status-date">
                            {{ $transaction->order->delivered_date ? \Carbon\Carbon::parse($transaction->order->delivered_date)->format('d/m/Y') : '-' }}
                        </div>
                    </div>
                    <div class="status-line"></div>
                    <div class="status-step">
                        <div
                            class="status-icon {{ $transaction->order->status === 'completed' ? 'status-completed' : ($transaction->order->status === 'canceled' ? 'status-canceled' : '') }}">
                            <i class="icon-check-circle"></i>
                        </div>
                        <div class="status-label">Selesai</div>
                        <div class="status-date">
                            {{ $transaction->order->completed_date ? \Carbon\Carbon::parse($transaction->order->completed_date)->format('d/m/Y') : '-' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="wg-box mt-5">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Item Pesanan</h5>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">SKU</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Merek</th>
                                <th class="text-center">Opsi</th>
                                <th class="text-center">Status Return</th>
                                <th class="text-center">Aksi</th>
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
                                    <td class="text-center">Rp.{{ number_format($orderitem->price) }}</td>
                                    <td class="text-center">{{ $orderitem->quantity }}</td>
                                    <td class="text-center">{{ $orderitem->product->SKU }}</td>
                                    <td class="text-center">{{ $orderitem->product->category->name }}</td>
                                    <td class="text-center">{{ $orderitem->product->brand->name }}</td>
                                    <td class="text-center">{{ $orderitem->options }}</td>
                                    <td class="text-center">{{ $orderitem->rstatus == 0 ? 'Tidak' : 'Ya' }}</td>
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
                <h5>Alamat Pengiriman</h5>
                <div class="my-account__address-item col-md-6">
                    <div class="my-account__address-item__detail">
                        <p>{{ $transaction->order->name }}</p>
                        <p>{{ $transaction->order->address }}</p>
                        <p>{{ $transaction->order->locality }}</p>
                        <p>{{ $transaction->order->city }}, {{ $transaction->order->country }}</p>
                        <p>{{ $transaction->order->landmark }}</p>
                        <p>{{ $transaction->order->zip }}</p>
                        <br />
                        <p>Nomor HP : {{ $transaction->order->phone }}</p>
                    </div>
                </div>
            </div>

            <div class="wg-box mt-5">
                <h5>Transaksi</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-transaction">
                        <tr>
                            <th>Subtotal</th>
                            <td>Rp.{{ number_format($transaction->order->subtotal) }}</td>
                            <th>Pajak</th>
                            <td>Rp.{{ number_format($transaction->order->tax) }}</td>
                            <th>Diskon</th>
                            <td>Rp.{{ number_format($transaction->order->discount) }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>Rp.{{ number_format($transaction->order->total) }}</td>
                            <th>Metode Pembayaran</th>
                            <td>{{ $transaction->mode }}</td>
                            <th>Status</th>
                            <td>{!! $transaction->status_badge !!}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="wg-box mt-5">
                <h5>Perbarui Status Pesanan</h5>
                <form action="{{ route('admin.order.status.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="order_id" value="{{ $transaction->order->id }}" />
                    <div class="row">
                        <div class="col-md-3">
                            <div class="select">
                                <select id="order_status" name="order_status" class="form-select">
                                    <option value="pending"
                                        {{ $transaction->order->status == 'pending' ? 'selected' : '' }}>
                                        Menunggu</option>
                                    <option value="confirmed"
                                        {{ $transaction->order->status == 'confirmed' ? 'selected' : '' }}>
                                        Dikonfirmasi</option>
                                    <option value="processing"
                                        {{ $transaction->order->status == 'processing' ? 'selected' : '' }}>
                                        Diproses</option>
                                    <option value="shipped"
                                        {{ $transaction->order->status == 'shipped' ? 'selected' : '' }}>
                                        Dikirim</option>
                                    <option value="delivered"
                                        {{ $transaction->order->status == 'delivered' ? 'selected' : '' }}>
                                        Paket telah sampai</option>
                                    <option value="canceled"
                                        {{ $transaction->order->status == 'canceled' ? 'selected' : '' }}>
                                        Dibatalkan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary tf-button w208">Perbarui Status</button>
                        </div>
                    </div>
                </form>
                <p class="mt-3 text-muted">
                    <small>
                        <strong>Catatan:</strong> Status "Selesai" hanya dapat diperbarui oleh pembeli setelah menerima
                        pesanan.
                        Admin hanya dapat menetapkan status hingga "Paket telah sampai".
                    </small>
                </p>
            </div>

        </div>
    </div>
@endsection

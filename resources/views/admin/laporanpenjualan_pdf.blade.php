<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background: #eee;
        }
    </style>
</head>

<body>
    <h2>Laporan Penjualan</h2>
    @if ($startDate && $endDate)
        <p>Periode: {{ $startDate }} s/d {{ $endDate }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Order No</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Items</th>
                <th>Tax</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ '1' . str_pad($order->order_id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->customer_phone }}</td>
                    <td>
                        @foreach ($order->items as $item)
                            {{ $item->product_name }} (x{{ $item->quantity }}) -
                            Rp.{{ number_format($item->price * $item->quantity) }}<br>
                        @endforeach
                    </td>
                    {{-- <td>Rp.{{ number_format($order->tax) }}</td> --}}
                    <td>Rp.{{ number_format($order->total) }}</td>
                    <td>{{ ucfirst($order->order_status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

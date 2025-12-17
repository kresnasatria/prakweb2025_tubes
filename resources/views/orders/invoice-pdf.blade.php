<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->order_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-section table {
            width: 100%;
        }
        .info-section td {
            padding: 5px 0;
            vertical-align: top;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .items-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        .total-section .total {
            font-size: 16px;
            font-weight: bold;
            color: #2563eb;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .status-pending { background: #fef3c7; color: #d97706; }
        .status-processing { background: #dbeafe; color: #2563eb; }
        .status-completed { background: #d1fae5; color: #059669; }
        .status-cancelled { background: #fee2e2; color: #dc2626; }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <p>Toko Laravel</p>
    </div>

    <div class="info-section">
        <table>
            <tr>
                <td style="width: 50%;">
                    <strong>Nomor Invoice:</strong><br>
                    {{ $order->order_number }}
                </td>
                <td style="width: 50%; text-align: right;">
                    <strong>Tanggal:</strong><br>
                    {{ $order->created_at->format('d F Y, H:i') }}
                </td>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <table>
            <tr>
                <td style="width: 50%;">
                    <strong>Pelanggan:</strong><br>
                    {{ $order->user->name }}<br>
                    {{ $order->user->email }}
                </td>
                <td style="width: 50%;">
                    <strong>Alamat Pengiriman:</strong><br>
                    {{ $order->shipping_address }}<br>
                    Telp: {{ $order->phone }}
                </td>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <strong>Status:</strong>
        <span class="status status-{{ $order->status }}">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 40%;">Produk</th>
                <th style="width: 15%;" class="text-right">Harga</th>
                <th style="width: 15%;" class="text-right">Qty</th>
                <th style="width: 25%;" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-right">{{ $item->quantity }}</td>
                <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <p class="total">TOTAL: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
    </div>

    @if($order->notes)
    <div class="info-section">
        <strong>Catatan:</strong><br>
        {{ $order->notes }}
    </div>
    @endif

    <div class="footer">
        <p>Terima kasih telah berbelanja di Toko Laravel</p>
        <p>Invoice ini digenerate pada {{ now()->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html>
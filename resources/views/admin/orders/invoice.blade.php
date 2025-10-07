<!--resource/views/admin/ordes/invoice.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Boleta #{{ $order->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background: #f4f4f4;
        }
    </style>
</head>

<body>
    <h2>Boleta de Venta #{{ $order->id }}</h2>
    <p><strong>Cliente:</strong> {{ $order->user->name }} {{ $order->user->last_name }}</p>
    <p><strong>DNI:</strong> {{ $order->user->dni }}</p>
    <p><strong>Fecha:</strong> {{ $order->order_date->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cant.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderDetails as $detail)
                <tr>
                    <td>{{ $detail->book->title }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>S/ {{ number_format($detail->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total: S/ {{ number_format($order->orderDetails->sum('subtotal'), 2) }}</h3>
</body>

</html>

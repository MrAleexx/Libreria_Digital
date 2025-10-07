<!--resource/views/admin/ordes/invoice-pdf.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta de Venta - B001-{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            padding: 20px;
        }

        .header {
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 20px;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .header-left {
            display: table-cell;
            width: 65%;
            vertical-align: top;
        }

        .header-right {
            display: table-cell;
            width: 35%;
            vertical-align: top;
            text-align: center;
            border: 2px solid #000;
            padding: 10px;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .invoice-type {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .invoice-number {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }

        .client-info {
            margin-bottom: 20px;
        }

        .info-row {
            margin-bottom: 5px;
        }

        .label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #333;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals {
            float: right;
            width: 50%;
        }

        .total-row {
            padding: 5px 10px;
        }

        .espacio {
            margin-bottom: 5px
        }

        .total-row.final {
            margin-top: 10px;
            border-top: 2px solid #000;
            font-weight: bold;
            font-size: 14px;
            padding: 10px;
            padding-bottom: 20px;
        }

        .amount-words {
            background-color: #f5f5f5;
            padding: 10px;
            margin-bottom: 20px;
            clear: both;
        }

        .payment-info {
            margin-bottom: 20px;
        }

        .footer {
            border-top: 2px solid #ddd;
            padding-top: 15px;
            text-align: center;
            font-size: 10px;
            color: #666;
            margin-top: 30px;
        }

        .product-description {
            font-weight: bold;
        }

        .product-author {
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>
    <!-- Encabezado -->
    <div class="header">
        <div class="header-content">
            <div class="header-left">
                <div class="company-name">GRUPOA&T</div>
                <div class="info-row">RUC: 10154316189</div>
                <div class="info-row">Urb. Libertad Mz. I Lt. 5 Calle las Moras S/N San Vicente</div>
                <div class="info-row">Teléfono: 942784270</div>
                <div class="info-row">Email: alextaya@hotmail.com</div>
            </div>
            <div class="header-right">
                <div class="invoice-type">BOLETA DE VENTA</div>
                <div class="invoice-type">ELECTRÓNICA</div>
                <div class="invoice-number">B001-{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>
    </div>

    <!-- Información del cliente -->
    <div class="client-info">
        <div class="info-row">
            <span class="label">Cliente:</span>
            {{ $order->user->name }} {{ $order->user->last_name }}
        </div>
        <div class="info-row">
            <span class="label">DNI:</span>
            {{ $order->user->dni }}
        </div>
        <div class="info-row">
            <span class="label">Teléfono:</span>
            {{ $order->user->phone }}
        </div>
        <div class="info-row">
            <span class="label">Email:</span>
            {{ $order->user->email }}
        </div>
        <div class="info-row">
            <span class="label">Fecha de Emisión:</span>
            {{ $order->created_at->format('d/m/Y') }}
        </div>
        <div class="info-row">
            <span class="label">Hora:</span>
            {{ $order->created_at->format('H:i:s') }}
        </div>
    </div>

    <!-- Tabla de productos -->
    <table>
        <thead>
            <tr>
                <th style="width: 12%;">Código</th>
                <th style="width: 43%;">Descripción</th>
                <th style="width: 10%;" class="text-center">Cant.</th>
                <th style="width: 15%;" class="text-right">P. Unit.</th>
                <th style="width: 20%;" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderDetails as $detail)
                <tr>
                    <td>LIB{{ str_pad($detail->book_id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div class="product-description">{{ $detail->book->title }}</div>
                        <div class="product-author">{{ $detail->book->author }}</div>
                    </td>
                    <td class="text-center">{{ $detail->quantity }}</td>
                    <td class="text-right">S/ {{ number_format($detail->subtotal / $detail->quantity, 2) }}</td>
                    <td class="text-right">S/ {{ number_format($detail->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totales -->
    <div class="totals">
        <div class="total-row espacio">
            <span style="float: left; font-weight: bold;">OP. EXONERADAS:</span>
            <span style="float: right;">S/ {{ number_format($order->orderDetails->sum('subtotal'), 2) }}</span>
            <div style="clear: both;"></div>
        </div>
        <div class="total-row espacio">
            <span style="float: left; font-weight: bold;">OP. GRAVADAS:</span>
            <span style="float: right;">S/ 0.00</span>
            <div style="clear: both;"></div>
        </div>
        <div class="total-row espacio">
            <span style="float: left; font-weight: bold;">IGV (18%):</span>
            <span style="float: right;">S/ 0.00</span>
            <div style="clear: both;"></div>
        </div>
        <div class="total-row final">
            <span style="float: left;">TOTAL:</span>
            <span style="float: right; color: #059669;">S/
                {{ number_format($order->orderDetails->sum('subtotal'), 2) }}</span>
            <div style="clear: both;"></div>
        </div>
    </div>

    <!-- Total en letras -->
    <div class="amount-words">
        <strong>Son:</strong>
        @php
            $total = $order->orderDetails->sum('subtotal');
            $entero = floor($total);
            $decimales = round(($total - $entero) * 100);

            // Función simple para convertir números a letras
            $unidades = ['', 'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
            $especiales = [
                'DIEZ',
                'ONCE',
                'DOCE',
                'TRECE',
                'CATORCE',
                'QUINCE',
                'DIECISÉIS',
                'DIECISIETE',
                'DIECIOCHO',
                'DIECINUEVE',
            ];
            $decenas = [
                '',
                '',
                'VEINTE',
                'TREINTA',
                'CUARENTA',
                'CINCUENTA',
                'SESENTA',
                'SETENTA',
                'OCHENTA',
                'NOVENTA',
            ];
            $centenas = [
                '',
                'CIENTO',
                'DOSCIENTOS',
                'TRESCIENTOS',
                'CUATROCIENTOS',
                'QUINIENTOS',
                'SEISCIENTOS',
                'SETECIENTOS',
                'OCHOCIENTOS',
                'NOVECIENTOS',
            ];

            $letras = '';

            if ($entero == 0) {
                $letras = 'CERO';
            } elseif ($entero == 100) {
                $letras = 'CIEN';
            } else {
                // Miles
                if ($entero >= 1000) {
                    $miles = floor($entero / 1000);
                    $letras .= $miles == 1 ? 'MIL ' : ($miles < 10 ? $unidades[$miles] : '') . ' MIL ';
                    $entero %= 1000;
                }

                // Centenas
                if ($entero >= 100) {
                    $letras .= $centenas[floor($entero / 100)] . ' ';
                    $entero %= 100;
                }

                // Decenas y unidades
                if ($entero >= 20) {
                    $letras .= $decenas[floor($entero / 10)];
                    if ($entero % 10 > 0) {
                        $letras .= ' Y ' . $unidades[$entero % 10];
                    }
                } elseif ($entero >= 10) {
                    $letras .= $especiales[$entero - 10];
                } elseif ($entero > 0) {
                    $letras .= $unidades[$entero];
                }
            }

            echo 'SON ' . trim($letras) . " CON {$decimales}/100 SOLES";
        @endphp
    </div>

    <!-- Información de pago -->
    <div class="payment-info">
        <div class="info-row">
            <span class="label">Forma de Pago:</span>
            Contado
        </div>
        <div class="info-row">
            <span class="label">Método de Pago:</span>
            {{ strtoupper(str_replace('_', ' ', $order->payment->payment_method)) }}
        </div>
        <div class="info-row">
            <span class="label">Fecha de Pago:</span>
            {{ $order->payment->payment_date->format('d/m/Y H:i') }}
        </div>
    </div>

    <!-- Pie de página -->
    <div class="footer">
        <p style="margin-bottom: 5px;">
            * BIENES TRANSFERIDOS EN LA AMAZONÍA PARA SER CONSUMIDOS EN LA MISMA - LEY N° 27037 *
        </p>
        <p style="margin-bottom: 5px;">
            <strong>Representación impresa de la Boleta de Venta Electrónica</strong>
        </p>
        <p style="margin-bottom: 5px;">
            Consulte su documento en: alextaya@hotmail.com
        </p>
        <p style="margin-top: 10px;">
            Hash: {{ md5($order->id . $order->created_at) }}
        </p>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Confirmación de Tu Pedido - GrupoA&T</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; background: #f9f9f9; padding: 20px;">
    <div
        style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">

        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="color: #ff6b00; margin: 0;">¡Hola {{ $user->name }}! 🎉</h2>
            <p style="color: #666; margin: 5px 0;">Tu pedido fue recibido con éxito</p>
        </div>

        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <h3 style="color: #333; margin-top: 0;">📦 Resumen de tu pedido:</h3>

            @foreach ($cart as $item)
                <div
                    style="display: flex; justify-content: between; margin: 10px 0; padding: 10px; background: white; border-radius: 5px;">
                    <div style="flex: 2;">
                        <strong>{{ $item['title'] }}</strong>
                    </div>
                    <div style="flex: 1; text-align: right;">
                        Cantidad: {{ $item['quantity'] }}
                    </div>
                    <div style="flex: 1; text-align: right; color: #ff6b00; font-weight: bold;">
                        S/ {{ number_format($item['price'] * $item['quantity'], 2) }}
                    </div>
                </div>
            @endforeach

            <div style="border-top: 2px solid #ff6b00; padding-top: 15px; margin-top: 15px;">
                <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: bold;">
                    <span>Total:</span>
                    <span style="color: #ff6b00;">S/ {{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>

        <div style="background: #e7f4e4; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <p style="margin: 0; color: #2e7d32;">
                <strong>📋 Estado actual:</strong> Pendiente de confirmación<br>
                <strong>⏰ Próximo paso:</strong> Validaremos tu comprobante de pago y te notificaremos por correo.
            </p>
        </div>

        <div style="background: #fff3e0; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <p style="margin: 0; color: #ef6c00;">
                <strong>📎 Comprobante:</strong> Hemos recibido tu comprobante de pago correctamente.
            </p>
        </div>

        <div
            style="text-align: center; color: #666; font-size: 14px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
            <p style="margin: 0;">
                Gracias por confiar en <strong>GrupoA&T</strong><br>
                Si tienes alguna duda, contáctanos:
                <a href="mailto:soporte@mattinnovasolution.com" style="color: #ff6b00; text-decoration: none;">
                    soporte@mattinnovasolution.com
                </a>
            </p>
        </div>

    </div>
</body>

</html>

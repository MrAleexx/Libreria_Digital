<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Confirmación de Reclamo - Libro de Reclamaciones</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; background: #f9f9f9; padding: 20px;">
    <div
        style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">

        <!-- Encabezado -->
        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="color: #ff6b00; margin: 0;">📢 Reclamo recibido</h2>
            <p style="color: #666; margin: 5px 0;">Hemos registrado tu reclamo correctamente</p>
        </div>

        <!-- Datos del Reclamo -->
        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <h3 style="color: #333; margin-top: 0;">📝 Detalles del reclamo:</h3>

            <div style="margin: 10px 0; padding: 10px; background: white; border-radius: 5px;">
                <strong>Nombre:</strong> {{ $data['name'] }}
            </div>

            <div style="margin: 10px 0; padding: 10px; background: white; border-radius: 5px;">
                <strong>DNI:</strong> {{ $data['dni'] }}
            </div>

            <div style="margin: 10px 0; padding: 10px; background: white; border-radius: 5px;">
                <strong>Correo:</strong> {{ $data['email'] }}
            </div>

            <div style="margin: 10px 0; padding: 10px; background: white; border-radius: 5px;">
                <strong>Tipo de Reclamo:</strong> {{ $data['tipo_reclamo'] }}
            </div>

            <div style="margin: 10px 0; padding: 10px; background: white; border-radius: 5px;">
                <strong>Asunto:</strong> {{ $data['subject'] }}
            </div>

            <div style="margin: 10px 0; padding: 10px; background: white; border-radius: 5px;">
                <strong>Descripción:</strong><br>
                {{ $data['description'] }}
            </div>
        </div>

        <!-- Estado -->
        <div style="background: #e7f4e4; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <p style="margin: 0; color: #2e7d32;">
                <strong>📋 Estado:</strong> Pendiente de revisión<br>
                <strong>⏰ Próximo paso:</strong> Nuestro equipo se comunicará contigo para darte una respuesta.
            </p>
        </div>

        <!-- Pie de página -->
        <div
            style="text-align: center; color: #666; font-size: 14px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
            <p style="margin: 0;">
                Gracias por confiar en <strong>Libro de Reclamaciones</strong><br>
                Si tienes alguna duda, contáctanos:
                <a href="mailto:soporte@mattinnovasolution.com" style="color: #ff6b00; text-decoration: none;">
                    soporte@mattinnovasolution.com
                </a>
            </p>
        </div>

    </div>
</body>

</html>

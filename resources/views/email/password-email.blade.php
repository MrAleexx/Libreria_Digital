<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
</head>

<body>
    <h1>Recupera tu Contraseña</h1>
    <a href="{{ route('password.recover.index', ['token' => $data['token'], 'email' => $data['email']]) }}">
        Da click aquí para recuperar tu contraseña
    </a>
</body>

</html>

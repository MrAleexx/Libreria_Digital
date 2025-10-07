@props(['message' => ''])

<div id="successMessage" class="success-message">
    <p class="mb-3">
        🎉 {{ $message ?: 'Tu compra se ha realizado correctamente.' }}
        <br>
        Una vez enviado el mensaje, habilitaremos el libro de tu compra en la plataforma.
    </p>
</div>

@props(['action' => route('login.store')])

<form id="loginForm" class="auth-form" action="{{ $action }}" method="POST">
    @csrf

    <!-- Alertas de sesión -->
    @if (session('mensaje'))
        <x-auth.auth-alert type="error" :message="session('mensaje')" />
    @endif

    @if (session('mensaje_correcto'))
        <x-auth.auth-alert type="success" :message="session('mensaje_correcto')" />
    @endif

    <!-- Campos del formulario -->
    <x-auth.auth-input name="email" label="Correo electrónico" type="email" placeholder="correo@ejemplo.com"
        required="true" value="{{ old('email') }}" :error="$errors->first('email')" />

    <x-auth.auth-input name="password" label="Contraseña" type="password" placeholder="••••••" required="true"
        :error="$errors->first('password')" />

    <!-- Enlace de contraseña olvidada -->
    <a href="{{ route('password') }}" class="forgot-link">
        ¿Olvidaste tu contraseña?
    </a>

    <!-- Botón de envío -->
    <button type="submit" class="submit-button">
        Iniciar Sesión
    </button>

    <!-- Enlace de registro -->
    <div class="register-link">
        <p class="register-text">
            ¿No tienes una cuenta?
            <a href="{{ route('register') }}">Regístrate aquí</a>
        </p>
    </div>
</form>

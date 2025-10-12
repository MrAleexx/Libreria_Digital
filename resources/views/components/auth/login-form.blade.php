{{-- resources/views/components/auth/login-form.blade.php --}}
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

    <!-- Botón Microsoft Institucional -->
    <div class="microsoft-auth-section mb-6">
        <a href="{{ route('microsoft.login') }}"
            class="microsoft-btn w-full flex justify-center items-center px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 shadow-sm">
            <svg class="w-5 h-5 mr-3" viewBox="0 0 23 23" fill="currentColor">
                <path d="M0 0h11v11H0V0zm12 0h11v11H12V0zM0 12h11v11H0V12zm12 0h11v11H12V12z" />
            </svg>
            Cuenta Institucional Microsoft
        </a>
    </div>

    <!-- Separador -->
    <div class="separator mb-6">
        <span class="separator-text">O continúa con email</span>
    </div>

    <!-- Campos del formulario existentes -->
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

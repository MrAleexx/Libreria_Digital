@extends('layouts.app')

@section('titulo', 'Registrarse')

@section('contenido')
    <div class="register-container">
        <!-- Sidebar izquierdo con fondo -->
        <div class="register-background" style="--banner-image: url('{{ asset('img/banners/banner_AyT.jpg') }}')">
            <div class="fallback-text">
                <div class="banner-logo">BookSwap</div>
                <h1 class="banner-title">Únete a nuestra comunidad de lectores y descubre un mundo de libros compartidos</h1>
                <p class="banner-subtitle">"Donde las páginas encuentran nuevos lectores"</p>
            </div>
            <div id="particles" class="particles"></div>
        </div>

        <!-- Sidebar derecho con formulario MÁS ANCHO -->
        <div class="register-sidebar">
            <div class="register-card">
                <!-- Header -->
                <div class="register-header">
                    <h1 class="register-title">Crear Cuenta</h1>
                    <p class="register-subtitle">Únete a nuestra comunidad de lectores</p>
                </div>

                <form id="registerForm" class="auth-form register-form" action="{{ route('register.store') }}"
                    method="POST">
                    @csrf

                    <!-- Alertas de sesión -->
                    @if (session('mensaje'))
                        <x-auth.auth-alert type="error" :message="session('mensaje')" />
                    @endif

                    @if (session('mensaje_correcto'))
                        <x-auth.auth-alert type="success" :message="session('mensaje_correcto')" />
                    @endif

                    <!-- Campos del formulario en grid responsive -->
                    <div class="form-grid">
                        <div class="form-row">
                            <x-auth.auth-input name="name" label="Nombres" type="text" placeholder="Pedro Cesar"
                                required="true" value="{{ old('name') }}" :error="$errors->first('name')" />

                            <x-auth.auth-input name="last_name" label="Apellidos" type="text" placeholder="San Julio"
                                required="true" value="{{ old('last_name') }}" :error="$errors->first('last_name')" />
                        </div>

                        <div class="form-row">
                            <x-auth.auth-input name="dni" label="DNI" type="text" placeholder="60606060"
                                required="true" value="{{ old('dni') }}" :error="$errors->first('dni')" />

                            <x-auth.auth-input name="phone" label="Teléfono" type="tel" placeholder="987654321"
                                required="true" value="{{ old('phone') }}" :error="$errors->first('phone')" />
                        </div>
                    </div>

                    <div class="form-full-width">
                        <x-auth.auth-input name="email" label="Correo electrónico" type="email"
                            placeholder="correo@ejemplo.com" required="true" value="{{ old('email') }}"
                            :error="$errors->first('email')" />

                        <x-auth.auth-input name="password" label="Contraseña" type="password" placeholder="••••••"
                            required="true" :error="$errors->first('password')" />

                        <x-auth.auth-input name="password_confirmation" label="Confirmar Contraseña" type="password"
                            placeholder="••••••" required="true" />
                    </div>

                    <!-- Botones -->
                    <div class="form-actions">
                        <button type="submit" class="submit-button">
                            Registrar Cuenta
                        </button>

                        <a href="{{ route('login') }}" class="cancel-button">
                            Cancelar
                        </a>
                    </div>

                    <!-- Enlace de login -->
                    <div class="auth-link">
                        <p class="auth-text">
                            ¿Ya tienes una cuenta?
                            <a href="{{ route('login') }}">Inicia sesión aquí</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

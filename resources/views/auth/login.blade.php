@extends('layouts.app')

@section('titulo', 'Iniciar Sesión - Biblioteca Digital A&T')

@section('contenido')
    <x-auth.layouts.auth-container title="Iniciar Sesión" subtitle="Accede a tu cuenta de Biblioteca Digital">
        <x-auth.login-form />
    </x-auth.layouts.auth-container>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar formulario de login
            new LoginForm();

            // Inicializar alertas
            new AuthAlert();

            // Inicializar partículas del fondo
            new LoginParticles();
        });
    </script>
@endpush

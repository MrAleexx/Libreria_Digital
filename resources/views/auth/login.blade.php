{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('titulo', 'Iniciar Sesión - OpenReads')

@section('contenido')
    <x-auth.layouts.auth-container title="Iniciar Sesión" subtitle="Accede a tu cuenta de OpenReads">
        <div class="space-y-6">
            <x-auth.login-form />
        </div>
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

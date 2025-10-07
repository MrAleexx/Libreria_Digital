@extends('admin.layout')

{{-- El título de la página será dinámico --}}
@section('title', $pageTitle ?? 'Página en Construcción')
@section('subtitle', 'Esta sección estará disponible próximamente')

@section('content')
    <div class="flex items-center justify-center h-96 bg-white rounded-lg shadow">
        <div class="text-center">
            <div class="text-6xl mb-4">
                🚧
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                ¡Estamos trabajando en ello!
            </h2>
            <p class="text-gray-600 mb-6">
                La sección de <span class="font-semibold">{{ $pageTitle ?? 'esta página' }}</span> aún está en desarrollo.
            </p>
            <button onclick="window.history.back()"
                class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition-colors duration-200">
                Volver
            </button>
        </div>
    </div>
@endsection

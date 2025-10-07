@extends('admin.layout')

@section('title', 'Detalle del Reclamo')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">Reclamo #{{ $claim->id }}</h3>
                <span class="px-3 py-1 bg-orange-100 text-orange-800 text-sm rounded-full">
                    {{ $claim->created_at->format('d/m/Y H:i') }}
                </span>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Información del Usuario -->
            <div>
                <h4 class="text-md font-semibold mb-3 text-gray-700">Información del Usuario</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Nombre</p>
                        <p class="font-medium">{{ $claim->name }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">DNI</p>
                        <p class="font-medium">{{ $claim->dni }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-medium">{{ $claim->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Información del Reclamo -->
            <div>
                <h4 class="text-md font-semibold mb-3 text-gray-700">Información del Reclamo</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Tipo de Reclamo</p>
                        <p class="font-medium">
                            @php
                                $tipos = [
                                    'problema_descarga' => 'Problema con la descarga',
                                    'cobro_indebido' => 'Cobro indebido',
                                    'acceso_cuenta' => 'Problema de acceso',
                                    'otro' => 'Otro',
                                ];
                            @endphp
                            {{ $tipos[$claim->tipo_reclamo] ?? $claim->tipo_reclamo }}
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Asunto</p>
                        <p class="font-medium">{{ $claim->subject }}</p>
                    </div>
                </div>
            </div>

            <!-- Descripción -->
            <div>
                <h4 class="text-md font-semibold mb-3 text-gray-700">Descripción</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $claim->description }}</p>
                </div>
            </div>

            <!-- Acciones -->
            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                <a href="{{ route('admin.claims.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    Volver al listado
                </a>

                <form action="{{ route('admin.claims.destroy', $claim) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors"
                        onclick="return confirm('¿Estás seguro de eliminar este reclamo?')">
                        Eliminar Reclamo
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

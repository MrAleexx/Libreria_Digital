@extends('admin.layout')

@section('title', 'Gestión de Órdenes')
@section('subtitle', 'Lista de todas las órdenes')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
            <p class="font-medium">¡Éxito!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <livewire:admin.orders-table />
@endsection

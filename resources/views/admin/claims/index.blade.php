@extends('admin.layout')

@section('title', 'Gestión de Reclamos')
@section('subtitle', 'Listado de todos los reclamos recibidos')

@section('content')
    <livewire:admin.claims-table />
@endsection

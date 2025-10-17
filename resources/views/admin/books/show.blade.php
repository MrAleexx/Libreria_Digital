{{-- resources/views/admin/books/show.blade.php --}}
@extends('admin.layout')

@section('title', $book->title)

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header con acciones -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4">
                                <img class="h-20 w-16 rounded object-cover shadow"
                                    src="{{ $book->cover_image ? Storage::url($book->cover_image) : '/images/default-book.png' }}"
                                    alt="{{ $book->title }}">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">{{ $book->title }}</h1>
                                    <p class="text-gray-600 mt-1">{{ $book->publisher->name ?? 'Sin editorial' }} •
                                        {{ $book->publication_year }}</p>
                                    <div class="flex items-center space-x-4 mt-2">
                                        @if ($book->book_type === 'digital')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Digital
                                            </span>
                                        @elseif($book->book_type === 'physical')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                Físico
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                Mixto
                                            </span>
                                        @endif

                                        @if ($book->is_active)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Activo
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Inactivo
                                            </span>
                                        @endif

                                        @if ($book->featured)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Destacado
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.books.edit', $book) }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-edit mr-2"></i>
                                Editar
                            </a>
                            <a href="{{ route('admin.books.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i class="fas fa-eye text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Vistas</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $book->total_views }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-download text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Descargas</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $book->total_downloads }}</p>
                        </div>
                    </div>
                </div>
                @if (in_array($book->book_type, ['physical', 'both']))
                    <div class="bg-white p-6 rounded-lg shadow-sm border">
                        <div class="flex items-center">
                            <div class="p-3 bg-orange-100 rounded-lg">
                                <i class="fas fa-book text-orange-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Ejemplares</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $book->total_physical_copies }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm border">
                        <div class="flex items-center">
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <i class="fas fa-hand-holding text-purple-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Préstamos</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $book->total_loans }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Información en pestañas -->
            <div class="bg-white shadow-sm sm:rounded-lg" x-data="{ activeTab: 'info' }">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button type="button" @click="activeTab = 'info'"
                            :class="activeTab === 'info' ? 'border-blue-500 text-blue-600' :
                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                            <i class="fas fa-info-circle mr-2"></i>
                            Información General
                        </button>
                        <button type="button" @click="activeTab = 'contributors'"
                            :class="activeTab === 'contributors' ? 'border-blue-500 text-blue-600' :
                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                            <i class="fas fa-users mr-2"></i>
                            Contribuidores
                        </button>
                        <button type="button" @click="activeTab = 'content'"
                            :class="activeTab === 'content' ? 'border-blue-500 text-blue-600' :
                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                            <i class="fas fa-list-ol mr-2"></i>
                            Índice
                        </button>
                        @if (in_array($book->book_type, ['physical', 'both']))
                            <button type="button" @click="activeTab = 'physical'"
                                :class="activeTab === 'physical' ? 'border-blue-500 text-blue-600' :
                                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                                <i class="fas fa-book mr-2"></i>
                                Ejemplares Físicos
                            </button>
                        @endif
                    </nav>
                </div>
                <div class="p-6">
                    <!-- Contenido de cada pestaña -->
                    <div x-show="activeTab === 'info'">
                        @include('admin.books.form.show.show-info')
                    </div>
                    <div x-show="activeTab === 'contributors'" style="display: none;">
                        @include('admin.books.form.show.show-contributors')
                    </div>
                    <div x-show="activeTab === 'content'" style="display: none;">
                        @include('admin.books.form.show.show-content')
                    </div>
                    @if (in_array($book->book_type, ['physical', 'both']))
                        <div x-show="activeTab === 'physical'" style="display: none;">
                            @include('admin.books.form.show.show-physical')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

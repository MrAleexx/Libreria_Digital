{{-- resources/views/layouts/includes/navegacion.blade.php --}}
@php
    $links = [
        [
            'nombre' => 'Inicio',
            'ruta' => route('bookmart'),
            'activo' => request()->routeIs('bookmart'),
            'icono' => 'fas fa-home',
        ],
        [
            'nombre' => 'Biblioteca',
            'ruta' => route('homebook'),
            'activo' => request()->routeIs('homebook'),
            'icono' => 'fas fa-book-open',
        ],
        [
            'nombre' => 'Nuestra Misión',
            'ruta' => route('homeabout'),
            'activo' => request()->routeIs('homeabout'),
            'icono' => 'fas fa-bullseye',
        ],
        [
            'nombre' => 'Contacto',
            'ruta' => route('homecontact'),
            'activo' => request()->routeIs('homecontact'),
            'icono' => 'fas fa-envelope',
        ],
    ];

    $cartCount = count(Session::get('cart', []));
@endphp

<!-- Navigation Container -->
<nav class="bg-white shadow-lg sticky top-0 z-50 transition-all duration-300 border-b border-slate-100"
    x-data="{ isScrolled: false, mobileMenuOpen: false, userMenuOpen: false }" @scroll.window="isScrolled = window.scrollY > 50">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center flex-shrink-0">
                <a href="{{ route('bookmart') }}"
                    class="font-extrabold text-3xl transition-transform duration-300 hover:scale-105 flex items-center gap-3">
                    <!-- Logo OpenReads -->
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-blue-600 to-green-500 rounded-lg flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span
                        class="bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent font-bold text-2xl">
                        OpenReads
                    </span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-1">
                @foreach ($links as $link)
                    <a href="{{ $link['ruta'] }}"
                        class="relative px-4 py-2 text-slate-700 font-medium rounded-lg transition-all duration-300
                              hover:text-blue-600 hover:bg-blue-50 group
                              {{ $link['activo'] ? 'text-blue-600 bg-blue-50 font-semibold' : '' }}">
                        {{ $link['nombre'] }}
                        @if ($link['activo'])
                            <span
                                class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-3/4 h-0.5 bg-blue-600 rounded-full"></span>
                        @else
                            <span
                                class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-blue-600 rounded-full transition-all duration-300 group-hover:w-3/4"></span>
                        @endif
                    </a>
                @endforeach

                <!-- Panel Admin Desktop -->
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="px-4 py-2 text-green-600 font-semibold rounded-lg transition-all duration-300
                                  hover:text-green-700 hover:bg-green-50 flex items-center gap-2">
                            <i class="fas fa-cog text-sm"></i>
                            Panel Admin
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Right Side Actions -->
            <div class="flex items-center space-x-3 md:space-x-4">
                <!-- Search Button -->
                <button class="p-2 text-slate-600 hover:text-blue-600 transition-colors duration-300"
                    @click="$dispatch('open-search')">
                    <i class="fas fa-search text-lg"></i>
                </button>

                @auth
                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}"
                        class="relative p-3 bg-blue-600 hover:bg-blue-700 rounded-lg cursor-pointer
                              transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105 group">
                        <i class="fas fa-shopping-cart text-white text-lg group-hover:scale-110 transition-transform"></i>
                        @if ($cartCount > 0)
                            <span
                                class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full w-5 h-5
                                        flex items-center justify-center text-xs font-bold shadow-sm">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- User Menu -->
                    <div class="relative" x-data="{ userMenuOpen: false }">
                        <button @click="userMenuOpen = !userMenuOpen"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-slate-100 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-blue-500 to-green-400 rounded-full flex items-center justify-center shadow-sm">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <span class="hidden md:block text-slate-700 font-medium text-sm">
                                {{ auth()->user()->name }}
                            </span>
                            <i class="fas fa-chevron-down text-slate-500 text-xs transition-transform duration-300"
                                :class="{ 'rotate-180': userMenuOpen }"></i>
                        </button>

                        <!-- User Dropdown Menu -->
                        <div x-show="userMenuOpen" @click.away="userMenuOpen = false"
                            class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-200 py-2 z-50"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95" style="display: none;">

                            <!-- User Info -->
                            <div class="px-4 py-2 border-b border-slate-100">
                                <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <!-- Menu Items -->
                            <a href="{{ route('orders.index') }}"
                                class="flex items-center px-4 py-2 text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-clipboard-list mr-3 text-blue-500 w-4 text-center"></i>
                                Mis Pedidos
                            </a>

                            <a href="{{ route('perfil') }}"
                                class="flex items-center px-4 py-2 text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-user mr-3 text-blue-500 w-4 text-center"></i>
                                Mi Perfil
                            </a>

                            <!-- Panel Admin en dropdown -->
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex items-center px-4 py-2 text-green-600 hover:bg-green-50 transition-colors duration-200 border-t border-slate-100 mt-1">
                                    <i class="fas fa-cog mr-3 text-green-500 w-4 text-center"></i>
                                    Panel Admin
                                </a>
                            @endif

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout.store') }}"
                                class="border-t border-slate-100 mt-1">
                                @csrf
                                <button type="submit"
                                    class="flex items-center w-full px-4 py-2 text-slate-700 hover:bg-slate-100 transition-colors duration-200 text-left">
                                    <i class="fas fa-sign-out-alt mr-3 text-slate-400 w-4 text-center"></i>
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Guest State -->
                    <div class="flex items-center space-x-2">
                        <!-- Disabled Cart -->
                        <button class="relative p-2 bg-slate-200 rounded-lg cursor-not-allowed shadow-sm"
                            title="Inicia sesión para acceder al carrito">
                            <i class="fas fa-shopping-cart text-slate-400 text-lg"></i>
                        </button>

                        <!-- Login Button -->
                        <a href="{{ route('login') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-300 font-medium text-sm shadow-md hover:shadow-lg flex items-center gap-2">
                            <i class="fas fa-sign-in-alt text-sm"></i>
                            Iniciar Sesión
                        </a>
                    </div>
                @endauth

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden p-2 rounded-lg text-slate-700 hover:bg-slate-100 transition-colors duration-300
                               focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <i class="fas fa-bars text-xl" x-show="!mobileMenuOpen"></i>
                    <i class="fas fa-times text-xl" x-show="mobileMenuOpen"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="lg:hidden transition-all duration-300 overflow-hidden" x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-4" style="display: none;">
            <div class="bg-white border-t border-slate-200 mt-3 py-4 shadow-lg rounded-lg">
                <!-- Navigation Links -->
                <div class="space-y-1 px-2">
                    @foreach ($links as $link)
                        <a href="{{ $link['ruta'] }}" @click="mobileMenuOpen = false"
                            class="flex items-center px-4 py-3 text-slate-700 rounded-lg transition-all duration-200
                                  hover:bg-blue-50 hover:text-blue-600 group
                                  {{ $link['activo'] ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                            <i
                                class="{{ $link['icono'] }} w-5 mr-3 text-blue-500 group-hover:scale-110 transition-transform"></i>
                            {{ $link['nombre'] }}
                            @if ($link['activo'])
                                <i class="fas fa-chevron-right ml-auto text-blue-500 text-sm"></i>
                            @endif
                        </a>
                    @endforeach

                    <!-- Panel Admin Mobile -->
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" @click="mobileMenuOpen = false"
                                class="flex items-center px-4 py-3 text-green-600 rounded-lg transition-all duration-200
                                      hover:bg-green-50 hover:text-green-700 font-semibold">
                                <i class="fas fa-cog w-5 mr-3 text-green-500"></i>
                                Panel Admin
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- User Actions Mobile -->
                @auth
                    <div class="border-t border-slate-200 mt-3 pt-4 px-2">
                        <!-- User Info Mobile -->
                        <div class="px-3 py-2 bg-slate-50 rounded-lg mb-2">
                            <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>

                        <!-- Mobile Menu Items -->
                        <a href="{{ route('orders.index') }}" @click="mobileMenuOpen = false"
                            class="flex items-center px-4 py-3 text-slate-700 rounded-lg hover:bg-blue-50 transition-colors duration-200">
                            <i class="fas fa-clipboard-list mr-3 text-blue-500"></i>
                            Mis Pedidos
                        </a>

                        <a href="{{ route('perfil') }}" @click="mobileMenuOpen = false"
                            class="flex items-center px-4 py-3 text-slate-700 rounded-lg hover:bg-blue-50 transition-colors duration-200">
                            <i class="fas fa-user mr-3 text-blue-500"></i>
                            Mi Perfil
                        </a>

                        <!-- Logout Mobile -->
                        <form method="POST" action="{{ route('logout.store') }}">
                            @csrf
                            <button type="submit" @click="mobileMenuOpen = false"
                                class="flex items-center w-full px-4 py-3 text-slate-700 rounded-lg hover:bg-slate-100 transition-colors duration-200 text-left">
                                <i class="fas fa-sign-out-alt mr-3 text-slate-400"></i>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Guest Mobile -->
                    <div class="border-t border-slate-200 mt-3 pt-4 px-2">
                        <a href="{{ route('login') }}" @click="mobileMenuOpen = false"
                            class="flex items-center justify-center bg-blue-600 text-white px-4 py-3 rounded-lg transition-colors duration-200 font-medium mt-2">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Iniciar Sesión
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Search Modal (para implementar después) -->
<div x-data="{ searchOpen: false }" x-on:open-search.window="searchOpen = true" class="relative z-50">
    <div x-show="searchOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-start justify-center pt-20 px-4"
        style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl p-6" @click.away="searchOpen = false">
            <div class="flex items-center gap-4 mb-4">
                <div class="flex-1 relative">
                    <input type="text" placeholder="Buscar libros, autores, categorías..."
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <i class="fas fa-search absolute right-3 top-3 text-slate-400"></i>
                </div>
                <button @click="searchOpen = false" class="p-2 text-slate-500 hover:text-slate-700 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="text-sm text-slate-500 text-center">
                Presiona ESC para cerrar
            </div>
        </div>
    </div>
</div>

<style>
    /* Smooth transitions for mobile menu */
    [x-cloak] {
        display: none !important;
    }

    /* Custom scroll behavior */
    html {
        scroll-behavior: smooth;
    }

    /* Focus states for accessibility */
    .focus\:ring-blue-400:focus {
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
    }

    /* Smooth rotations */
    .rotate-180 {
        transform: rotate(180deg);
    }

    /* Gradient text animation */
    .gradient-text {
        background: linear-gradient(135deg, #2563eb 0%, #059669 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>

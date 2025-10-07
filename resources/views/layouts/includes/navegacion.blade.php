@php
    $links = [
        [
            'nombre' => 'Inicio',
            'ruta' => route('bookmart'),
            'activo' => request()->routeIs('bookmart'),
            'icono' => 'fas fa-home',
        ],
        [
            'nombre' => 'Nuestros Libros',
            'ruta' => route('homebook'),
            'activo' => request()->routeIs('homebook'),
            'icono' => 'fas fa-book',
        ],
        [
            'nombre' => 'Sobre Nosotros',
            'ruta' => route('homeabout'),
            'activo' => request()->routeIs('homeabout'),
            'icono' => 'fas fa-users',
        ],
        [
            'nombre' => 'Contáctanos',
            'ruta' => route('homecontact'),
            'activo' => request()->routeIs('homecontact'),
            'icono' => 'fas fa-envelope',
        ],
    ];

    $cartCount = count(Session::get('cart', []));
@endphp

<!-- Navigation Container -->
<nav class="bg-white shadow-lg sticky top-0 z-50 transition-all duration-300" x-data="{ isScrolled: false, mobileMenuOpen: false, userMenuOpen: false }"
    @scroll.window="isScrolled = window.scrollY > 50">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center flex-shrink-0">
                <a href="{{ route('bookmart') }}"
                    class="font-extrabold text-3xl transition-transform duration-300 hover:scale-105">
                    <img src="{{ asset('img/logoAYT.png') }}" class="h-12 md:h-14 w-auto" alt="Grupo A&T Logo">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-1">
                @foreach ($links as $link)
                    <a href="{{ $link['ruta'] }}"
                        class="relative px-4 py-2 text-gray-700 font-medium rounded-lg transition-all duration-300
                              hover:text-orange-500 hover:bg-orange-50 group
                              {{ $link['activo'] ? 'text-orange-500 bg-orange-50 font-semibold' : '' }}">
                        {{ $link['nombre'] }}
                        @if ($link['activo'])
                            <span
                                class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-3/4 h-0.5 bg-orange-500 rounded-full"></span>
                        @else
                            <span
                                class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-orange-500 rounded-full transition-all duration-300 group-hover:w-3/4"></span>
                        @endif
                    </a>
                @endforeach

                <!-- Panel Admin Desktop -->
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="px-4 py-2 text-blue-600 font-semibold rounded-lg transition-all duration-300
                                  hover:text-blue-700 hover:bg-blue-50 flex items-center gap-2">
                            <i class="fas fa-cog text-sm"></i>
                            Panel Admin
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Right Side Actions -->
            <div class="flex items-center space-x-3 md:space-x-4">
                @auth
                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}"
                        class="relative p-4 bg-orange-400 hover:bg-orange-500 rounded-lg cursor-pointer
                              transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                        <i class="fas fa-shopping-cart text-white text-lg"></i>
                        @if ($cartCount > 0)
                            <span
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5
                                        flex items-center justify-center text-xs font-bold shadow-sm">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- User Menu -->
                    <div class="relative" x-data="{ userMenuOpen: false }">
                        <button @click="userMenuOpen = !userMenuOpen"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-orange-400">
                            <div class="w-8 h-8 bg-orange-400 rounded-full flex items-center justify-center shadow-sm">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <span class="hidden md:block text-gray-700 font-medium text-sm">
                                {{ auth()->user()->name }}
                            </span>
                            <i class="fas fa-chevron-down text-gray-500 text-xs transition-transform duration-300"
                                :class="{ 'rotate-180': userMenuOpen }"></i>
                        </button>

                        <!-- User Dropdown Menu -->
                        <div x-show="userMenuOpen" @click.away="userMenuOpen = false"
                            class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95" style="display: none;">

                            <!-- User Info -->
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <!-- Menu Items -->
                            <a href="{{ route('orders.index') }}"
                                class="flex items-center px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-500 transition-colors duration-200">
                                <i class="fas fa-clipboard-list mr-3 text-orange-400 w-4 text-center"></i>
                                Mis Pedidos
                            </a>

                            <a href="{{ route('perfil') }}"
                                class="flex items-center px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-500 transition-colors duration-200">
                                <i class="fas fa-user mr-3 text-orange-400 w-4 text-center"></i>
                                Mi Perfil
                            </a>

                            <!-- Panel Admin en dropdown -->
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex items-center px-4 py-2 text-blue-600 hover:bg-blue-50 transition-colors duration-200 border-t border-gray-100 mt-1">
                                    <i class="fas fa-cog mr-3 text-blue-500 w-4 text-center"></i>
                                    Panel Admin
                                </a>
                            @endif

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout.store') }}"
                                class="border-t border-gray-100 mt-1">
                                @csrf
                                <button type="submit"
                                    class="flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors duration-200 text-left">
                                    <i class="fas fa-sign-out-alt mr-3 text-gray-400 w-4 text-center"></i>
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Guest State -->
                    <div class="flex items-center space-x-2">
                        <!-- Disabled Cart -->
                        <button class="relative p-2 bg-gray-300 rounded-lg cursor-not-allowed shadow-sm"
                            title="Inicia sesión para acceder al carrito">
                            <i class="fas fa-shopping-cart text-gray-500 text-lg"></i>
                        </button>

                        <!-- Login Button -->
                        <a href="{{ route('login') }}"
                            class="bg-orange-400 hover:bg-orange-500 text-white px-4 py-2 rounded-lg transition-colors duration-300 font-medium text-sm shadow-md hover:shadow-lg">
                            Iniciar Sesión
                        </a>
                    </div>
                @endauth

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden p-2 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-300
                               focus:outline-none focus:ring-2 focus:ring-orange-400">
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
            <div class="bg-white border-t border-gray-200 mt-3 py-4 shadow-lg rounded-lg">
                <!-- Navigation Links -->
                <div class="space-y-1 px-2">
                    @foreach ($links as $link)
                        <a href="{{ $link['ruta'] }}" @click="mobileMenuOpen = false"
                            class="flex items-center px-4 py-3 text-gray-700 rounded-lg transition-all duration-200
                                  hover:bg-orange-50 hover:text-orange-500 group
                                  {{ $link['activo'] ? 'bg-orange-50 text-orange-500 font-semibold' : '' }}">
                            <i
                                class="{{ $link['icono'] }} w-5 mr-3 text-orange-400 group-hover:scale-110 transition-transform"></i>
                            {{ $link['nombre'] }}
                            @if ($link['activo'])
                                <i class="fas fa-chevron-right ml-auto text-orange-400 text-sm"></i>
                            @endif
                        </a>
                    @endforeach

                    <!-- Panel Admin Mobile -->
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" @click="mobileMenuOpen = false"
                                class="flex items-center px-4 py-3 text-blue-600 rounded-lg transition-all duration-200
                                      hover:bg-blue-50 hover:text-blue-700 font-semibold">
                                <i class="fas fa-cog w-5 mr-3 text-blue-500"></i>
                                Panel Admin
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- User Actions Mobile -->
                @auth
                    <div class="border-t border-gray-200 mt-3 pt-4 px-2">
                        <!-- User Info Mobile -->
                        <div class="px-3 py-2 bg-gray-50 rounded-lg mb-2">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                        </div>

                        <!-- Logout Mobile -->
                        <form method="POST" action="{{ route('logout.store') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200 text-left">
                                <i class="fas fa-sign-out-alt mr-3 text-gray-400"></i>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Guest Mobile -->
                    <div class="border-t border-gray-200 mt-3 pt-4 px-2">
                        {{-- <div class="flex items-center px-4 py-3 text-gray-400 rounded-lg">
                            <i class="fas fa-shopping-cart mr-3"></i>
                            Carrito (Inicia sesión)
                        </div> --}}
                        <a href="{{ route('login') }}" @click="mobileMenuOpen = false"
                            class="flex items-center justify-center bg-orange-400 text-white px-4 py-3 rounded-lg transition-colors duration-200 font-medium mt-2">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Iniciar Sesión
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

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
    .focus\:ring-orange-400:focus {
        box-shadow: 0 0 0 2px rgba(234, 146, 22, 0.5);
    }

    /* Smooth rotations */
    .rotate-180 {
        transform: rotate(180deg);
    }
</style>

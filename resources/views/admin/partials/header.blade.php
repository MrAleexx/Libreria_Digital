{{-- resources/views/admin/partials/header.blade.php --}}
<header class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-30">
    <div class="flex items-center justify-between px-4 lg:px-6 py-4">
        <!-- Lado Izquierdo - Botón Menú y Título -->
        <div class="flex items-center space-x-4">
            <!-- Botón Menú Móvil -->
            <button @click="sidebarOpen = true"
                class="lg:hidden p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200">
                <i class="fas fa-bars text-lg"></i>
            </button>

            <div class="flex flex-col">
                <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight flex items-center flex-wrap gap-2">
                    @yield('title', 'Dashboard')
                    @if (request()->routeIs('admin.categories.*'))
                        <span
                            class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-medium rounded-full border border-blue-200">
                            Categorías
                        </span>
                    @endif
                    @if (request()->routeIs('admin.users.*'))
                        <span
                            class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-medium rounded-full border border-green-200">
                            Usuarios
                        </span>
                    @endif
                    @if (request()->routeIs('admin.books.*'))
                        <span
                            class="px-2 py-0.5 bg-purple-100 text-purple-700 text-xs font-medium rounded-full border border-purple-200">
                            Libros
                        </span>
                    @endif
                    @if (request()->routeIs('admin.orders.*'))
                        <span
                            class="px-2 py-0.5 bg-indigo-100 text-indigo-700 text-xs font-medium rounded-full border border-indigo-200">
                            Órdenes
                        </span>
                    @endif
                    @if (request()->routeIs('admin.claims.*'))
                        <span
                            class="px-2 py-0.5 bg-red-100 text-red-700 text-xs font-medium rounded-full border border-red-200">
                            Reclamos
                        </span>
                    @endif
                </h1>
                <p class="text-sm text-gray-600 mt-1 flex items-center">
                    <i class="fas fa-compass text-blue-500 mr-2 text-xs"></i>
                    @yield('subtitle', 'Panel de administración')
                </p>
            </div>
        </div>

        <!-- Lado Derecho - User Info -->
        <div class="flex items-center space-x-3 lg:space-x-4">
            <!-- User Profile Minimalista -->
            <div class="relative group" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center space-x-2 lg:space-x-3 p-2 rounded-xl hover:bg-gray-50 transition-all duration-200">
                    <!-- Avatar -->
                    <div class="relative">
                        <div
                            class="w-8 h-8 lg:w-9 lg:h-9 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white font-semibold text-sm shadow-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div
                            class="absolute -bottom-1 -right-1 w-2 h-2 bg-green-500 rounded-full border-2 border-white">
                        </div>
                    </div>

                    <!-- User Info (Solo en Desktop) -->
                    <div class="hidden lg:block text-left">
                        <p class="text-sm font-medium text-gray-900 leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                    </div>

                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                        :class="{ 'rotate-180': open }"></i>
                </button>

                <!-- Dropdown Menu Compacto -->
                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">

                    <!-- Header del Dropdown -->
                    <div class="px-3 py-2 border-b border-gray-100">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</span>
                            <span
                                class="px-1.5 py-0.5 bg-blue-100 text-blue-700 text-xs font-medium rounded capitalize">
                                {{ auth()->user()->role }}
                            </span>
                        </div>
                    </div>

                    <!-- Menu Items Compactos -->
                    <div class="py-1">
                        <a href="{{ route('bookmart') }}" target="_blank"
                            class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors duration-200 group">
                            <i
                                class="fas fa-external-link-alt text-gray-400 group-hover:text-green-500 mr-2.5 w-4 text-center text-xs"></i>
                            Ir al Sitio Web
                        </a>

                        <div class="my-1 border-t border-gray-100"></div>

                        <a href="#"
                            class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition-colors duration-200 group">
                            <i
                                class="fas fa-cog text-gray-400 group-hover:text-purple-500 mr-2.5 w-4 text-center text-xs"></i>
                            Preferencias
                        </a>
                    </div>

                    <!-- Footer del Dropdown -->
                    <div class="px-3 py-1 border-t border-gray-100">
                        <form method="POST" action="{{ route('logout.store') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full px-2 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200 group">
                                <i class="fas fa-sign-out-alt mr-2.5 w-4 text-center text-xs"></i>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Bar Sutil -->
    <div class="h-0.5 bg-gray-100">
        <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 w-0 transition-all duration-500 ease-out"
            id="page-progress"></div>
    </div>
</header>

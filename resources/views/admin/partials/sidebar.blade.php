{{-- resources/views/admin/partials/sidebar.blade.php --}}
<aside id="sidebar"
    class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-gray-800 to-gray-900 text-white transform transition-transform duration-300 ease-in-out h-screen flex flex-col"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    x-transition:enter="transform transition-transform duration-300" x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0" x-transition:leave="transform transition-transform duration-300"
    x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">

    <!-- Botón para cerrar (solo visible en móvil) -->
    <button @click="sidebarOpen = false"
        class="lg:hidden absolute -right-3 top-4 bg-gray-800 hover:bg-gray-700 text-white p-2 rounded-full shadow-lg border border-gray-600 transition-all duration-200 z-50">
        <i class="fas fa-times text-sm"></i>
    </button>

    <!-- Header del Sidebar -->
    <div class="p-6 border-b border-gray-700 bg-gradient-to-r from-gray-800 to-gray-750">
        <div class="flex items-center space-x-3">
            <div class="bg-gradient-to-r from-blue-600 to-green-600 p-3 rounded-lg shadow-lg">
                <i class="fas fa-book-open text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                    OpenReads
                </h1>
                <p class="text-gray-400 text-xs font-medium">Panel de Administración</p>
            </div>
        </div>
    </div>

    <!-- Navegación -->
    <nav
        class="flex-1 overflow-y-auto py-4 px-3 [scrollbar-width:none] [-ms-overflow-style:none] [-webkit-overflow-scrolling:touch]">
        <!-- Dashboard -->
        <div class="mb-6">
            <a href="{{ route('admin.dashboard') }}" @click="if (window.innerWidth < 1024) { sidebarOpen = false; }"
                class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-orange-500 to-orange-600 shadow-lg shadow-orange-500/25' : 'hover:bg-gray-700/50 hover:shadow-lg' }}">
                <div
                    class="{{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-gray-700 group-hover:bg-orange-500' }} p-2 rounded-lg transition-colors duration-200">
                    <i
                        class="fas fa-chart-bar w-4 text-center {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}"></i>
                </div>
                <span
                    class="ml-3 font-medium {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}">Dashboard</span>
                @if (request()->routeIs('admin.dashboard'))
                    <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                @endif
            </a>
        </div>

        <!-- Gestión de Contenido -->
        <div class="mb-6">
            <h3 class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center">
                <i class="fas fa-cube mr-2 text-gray-500"></i>
                Gestión de Contenido
            </h3>
            <div class="space-y-1">
                <a href="{{ route('admin.books.index') }}"
                    @click="if (window.innerWidth < 1024) { sidebarOpen = false; }"
                    class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.books.*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg shadow-blue-500/25' : 'hover:bg-gray-700/50 hover:shadow-lg' }}">
                    <div
                        class="{{ request()->routeIs('admin.books.*') ? 'bg-white/20' : 'bg-gray-700 group-hover:bg-blue-500' }} p-2 rounded-lg transition-colors duration-200">
                        <i
                            class="fas fa-book w-4 text-center {{ request()->routeIs('admin.books.*') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}"></i>
                    </div>
                    <span
                        class="ml-3 font-medium {{ request()->routeIs('admin.books.*') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}">Libros</span>
                    @if (request()->routeIs('admin.books.*'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    @click="if (window.innerWidth < 1024) { sidebarOpen = false; }"
                    class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-green-500 to-green-600 shadow-lg shadow-green-500/25' : 'hover:bg-gray-700/50 hover:shadow-lg' }}">
                    <div
                        class="{{ request()->routeIs('admin.categories.*') ? 'bg-white/20' : 'bg-gray-700 group-hover:bg-green-500' }} p-2 rounded-lg transition-colors duration-200">
                        <i
                            class="fas fa-folder-tree w-4 text-center {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}"></i>
                    </div>
                    <span
                        class="ml-3 font-medium {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}">Categorías</span>
                    @if (request()->routeIs('admin.categories.*'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>
            </div>
        </div>

        <!-- Gestión de Usuarios -->
        <div class="mb-6">
            <h3 class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center">
                <i class="fas fa-users-cog mr-2 text-gray-500"></i>
                Gestión de Usuarios
            </h3>
            <div class="space-y-1">
                <a href="{{ route('admin.orders.index') }}"
                    @click="if (window.innerWidth < 1024) { sidebarOpen = false; }"
                    class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-gradient-to-r from-purple-500 to-purple-600 shadow-lg shadow-purple-500/25' : 'hover:bg-gray-700/50 hover:shadow-lg' }}">
                    <div
                        class="{{ request()->routeIs('admin.orders.*') ? 'bg-white/20' : 'bg-gray-700 group-hover:bg-purple-500' }} p-2 rounded-lg transition-colors duration-200">
                        <i
                            class="fas fa-shopping-cart w-4 text-center {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}"></i>
                    </div>
                    <span
                        class="ml-3 font-medium {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}">Órdenes</span>
                    @if (request()->routeIs('admin.orders.*'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>

                <a href="{{ route('admin.users.index') }}"
                    @click="if (window.innerWidth < 1024) { sidebarOpen = false; }"
                    class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-indigo-500 to-indigo-600 shadow-lg shadow-indigo-500/25' : 'hover:bg-gray-700/50 hover:shadow-lg' }}">
                    <div
                        class="{{ request()->routeIs('admin.users.*') ? 'bg-white/20' : 'bg-gray-700 group-hover:bg-indigo-500' }} p-2 rounded-lg transition-colors duration-200">
                        <i
                            class="fas fa-users w-4 text-center {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}"></i>
                    </div>
                    <span
                        class="ml-3 font-medium {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}">Usuarios</span>
                    @if (request()->routeIs('admin.users.*'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>
            </div>
        </div>

        <!-- Soporte -->
        <div class="mb-6">
            <h3 class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center">
                <i class="fas fa-headset mr-2 text-gray-500"></i>
                Soporte
            </h3>
            <div class="space-y-1">
                <a href="{{ route('admin.claims.index') }}"
                    @click="if (window.innerWidth < 1024) { sidebarOpen = false; }"
                    class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.claims.*') ? 'bg-gradient-to-r from-red-500 to-red-600 shadow-lg shadow-red-500/25' : 'hover:bg-gray-700/50 hover:shadow-lg' }}">
                    <div
                        class="{{ request()->routeIs('admin.claims.*') ? 'bg-white/20' : 'bg-gray-700 group-hover:bg-red-500' }} p-2 rounded-lg transition-colors duration-200">
                        <i
                            class="fas fa-exclamation-triangle w-4 text-center {{ request()->routeIs('admin.claims.*') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}"></i>
                    </div>
                    <span
                        class="ml-3 font-medium {{ request()->routeIs('admin.claims.*') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}">Reclamos</span>
                    @if (request()->routeIs('admin.claims.*'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>

                <a href="{{ route('admin.contacts') }}" @click="if (window.innerWidth < 1024) { sidebarOpen = false; }"
                    class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.contacts') ? 'bg-gradient-to-r from-cyan-500 to-cyan-600 shadow-lg shadow-cyan-500/25' : 'hover:bg-gray-700/50 hover:shadow-lg' }}">
                    <div
                        class="{{ request()->routeIs('admin.contacts') ? 'bg-white/20' : 'bg-gray-700 group-hover:bg-cyan-500' }} p-2 rounded-lg transition-colors duration-200">
                        <i
                            class="fas fa-phone w-4 text-center {{ request()->routeIs('admin.contacts') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}"></i>
                    </div>
                    <span
                        class="ml-3 font-medium {{ request()->routeIs('admin.contacts') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}">Contactos</span>
                    @if (request()->routeIs('admin.contacts'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>
            </div>
        </div>
    </nav>

    <!-- Footer del Sidebar -->
    <div class="p-4 border-t border-gray-700 bg-gradient-to-t from-gray-800 to-gray-750 space-y-2">
        <!-- Acciones Rápidas -->
        <a href="{{ route('bookmart') }}" target="_blank"
            @click="if (window.innerWidth < 1024) { sidebarOpen = false; }"
            class="group flex items-center px-4 py-3 rounded-xl bg-gray-700/50 hover:bg-gray-600 transition-all duration-200 hover:shadow-lg">
            <div class="bg-gray-600 group-hover:bg-green-500 p-2 rounded-lg transition-colors duration-200">
                <i class="fas fa-home w-4 text-center text-gray-300 group-hover:text-white"></i>
            </div>
            <span class="ml-3 font-medium text-gray-300 group-hover:text-white">Ir al Sitio Web</span>
            <i class="fas fa-external-link-alt ml-auto text-gray-400 group-hover:text-green-400 text-xs"></i>
        </a>

        <!-- Cerrar Sesión -->
        <form method="POST" action="{{ route('logout.store') }}" class="w-full">
            @csrf
            <button type="submit" @click="if (window.innerWidth < 1024) { sidebarOpen = false; }"
                class="group flex items-center w-full px-4 py-3 rounded-xl bg-gray-700/50 hover:bg-red-600/80 transition-all duration-200 hover:shadow-lg text-left">
                <div class="bg-gray-600 group-hover:bg-red-700 p-2 rounded-lg transition-colors duration-200">
                    <i class="fas fa-sign-out-alt w-4 text-center text-gray-300 group-hover:text-white"></i>
                </div>
                <span class="ml-3 font-medium text-gray-300 group-hover:text-white">Cerrar Sesión</span>
                <i class="fas fa-arrow-right ml-auto text-gray-400 group-hover:text-red-300 text-xs"></i>
            </button>
        </form>
    </div>
</aside>

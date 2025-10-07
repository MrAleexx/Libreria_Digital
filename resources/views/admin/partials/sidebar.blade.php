<aside class="w-64 bg-gray-800 text-white">
    <div class="p-4">
        <h1 class="text-2xl font-bold">Grupo A&T Admin</h1>
        <p class="text-gray-400 text-sm">Panel de Administración</p>
    </div>

    <nav class="mt-6">
        <div class="px-4 py-2 text-gray-400 text-sm uppercase font-semibold">Navegación</div>

        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : '' }}">
            📊 Dashboard
        </a>

        <a href="{{ route('admin.books.index') }}"
            class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.books.*') ? 'bg-gray-700 text-white' : '' }}">
            📚 Libros
        </a>

        <a href="{{ route('admin.orders.index') }}"
            class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700 text-white' : '' }}">
            🛒 Órdenes
        </a>

        <a href="{{ route('admin.users.index') }}"
            class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700 text-white' : '' }}">
            👥 Usuarios
        </a>

        <a href="{{ route('admin.claims.index') }}"
            class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.claims.*') ? 'bg-gray-700 text-white' : '' }}">
            ⚠️ Reclamos
        </a>

        <a href="{{ route('admin.contacts') }}"
            class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.contacts') ? 'bg-gray-700 text-white' : '' }}">
            📞 Contactos
        </a>

        <div class="mt-6 px-4 py-2 text-gray-400 text-sm uppercase font-semibold">Acciones</div>

        <a href="{{ route('bookmart') }}"
            class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
            🏠 Ir al Sitio Web
        </a>

        <form method="POST" action="{{ route('logout.store') }}" class="px-4 py-3">
            @csrf
            <button type="submit"
                class="flex items-center w-full text-gray-300 hover:text-white transition-colors duration-200">
                🚪 Cerrar Sesión
            </button>
        </form>
    </nav>
</aside>

<header class="bg-white shadow">
    <div class="flex items-center justify-between p-4">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
            <p class="text-sm text-gray-600">@yield('subtitle', 'Panel de administración')</p>
        </div>

        <div class="flex items-center space-x-4">
            <span class="text-gray-700">Hola, {{ auth()->user()->name }}</span>
            <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center text-white font-semibold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>
    </div>
</header>

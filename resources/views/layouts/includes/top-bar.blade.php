<section class="bg-gray-50 border-b border-gray-200 hidden md:block">
    <div class="container mx-auto px-4 py-2">
        <div class="flex justify-between items-center text-sm">
            <!-- Contacto simplificado -->
            <div class="flex items-center space-x-4 text-gray-600">
                <a href="tel:942784270" class="flex items-center hover:text-orange-500 transition-colors duration-200">
                    <i class="fas fa-phone-alt mr-2 text-orange-400 text-xs"></i>
                    <span class="text-xs">942 784 270</span>
                </a>
                <a href="mailto:alextaya@hotmail.com"
                    class="flex items-center hover:text-orange-500 transition-colors duration-200">
                    <i class="fas fa-envelope mr-2 text-orange-400 text-xs"></i>
                    <span class="text-xs">alextaya@hotmail.com</span>
                </a>
            </div>

            <!-- Indicador de estado de sesión mínima -->
            <div class="text-xs text-gray-500">
                @auth
                    <span class="flex items-center">
                        <i class="fas fa-circle text-green-400 mr-1 text-[8px]"></i>
                        Conectado como {{ Str::limit(auth()->user()->name, 15) }}
                    </span>
                @else
                    <a href="{{ route('login') }}" class="hover:text-orange-500 transition-colors duration-200">
                        <i class="fas fa-user mr-1"></i>
                        Acceder a mi cuenta
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

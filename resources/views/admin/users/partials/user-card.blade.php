{{-- resources/views/admin/users/partials/user-card.blade.php --}}
<div class="bg-white p-6 rounded-lg border border-gray-200">
    <div class="flex items-center mb-6">
        <div
            class="w-20 h-20 bg-orange-500 rounded-full flex items-center justify-center text-white text-3xl font-semibold mr-6">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }} {{ $user->last_name }}</h2>
            <p class="text-gray-600">{{ $user->email }}</p>
            <div class="flex items-center mt-2 space-x-2">
                <span
                    class="px-3 py-1 text-sm rounded-full 
                    {{ $user->role === 'admin'
                        ? 'bg-purple-100 text-purple-800'
                        : ($user->role === 'moderator'
                            ? 'bg-blue-100 text-blue-800'
                            : 'bg-green-100 text-green-800') }}">
                    {{ ucfirst($user->role) }}
                </span>
                @if ($user->is_temp_password)
                    <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800 flex items-center">
                        <i class="fas fa-key mr-1"></i>
                        Contraseña Temporal
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-sm font-medium text-gray-500 mb-1">DNI</h4>
            <p class="text-lg font-semibold text-gray-900">{{ $user->dni }}</p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-sm font-medium text-gray-500 mb-1">Teléfono</h4>
            <p class="text-lg font-semibold text-gray-900">{{ $user->phone }}</p>
        </div>
        @if ($user->institutional_email)
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-sm font-medium text-gray-500 mb-1">Email Institucional</h4>
                <p class="text-lg font-semibold text-gray-900">{{ $user->institutional_email }}</p>
            </div>
        @endif
        @if ($user->microsoft_id)
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-sm font-medium text-gray-500 mb-1">Microsoft ID</h4>
                <p class="text-lg font-semibold text-gray-900 truncate">{{ $user->microsoft_id }}</p>
            </div>
        @endif
    </div>
</div>

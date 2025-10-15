{{-- resources/views/components/book-image.blade.php --}}
@props(['image', 'title', 'class' => '', 'defaultClass' => 'w-full object-cover'])

@php
    use Illuminate\Support\Facades\Storage;

    // Función helper para manejar imágenes de forma segura
    function getSafeImageSrc($image)
    {
        if (empty($image)) {
            return null;
        }

        if (filter_var($image, FILTER_VALIDATE_URL) !== false) {
            return $image;
        }

        try {
            return Storage::exists($image) ? Storage::url($image) : null;
        } catch (Exception $e) {
            return null;
        }
    }

    $imageSrc = getSafeImageSrc($image);
    $allClasses = trim("$defaultClass $class");
@endphp

<div class="relative">
    @if ($imageSrc)
        <div class="overflow-hidden {{ $allClasses }}">
            <img src="{{ $imageSrc }}" alt="{{ $title ?? 'Book cover' }}"
                class="w-full h-full object-cover transition-opacity duration-300"
                onerror="this.style.opacity='0'; this.nextElementSibling?.classList.remove('hidden')">
        </div>
    @endif

    {{-- Fallback image --}}
    <div
        class="{{ $imageSrc ? 'hidden' : 'flex' }} absolute inset-0 bg-gray-200 items-center justify-center {{ explode(' ', $allClasses)[0] }}">
        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
            </path>
        </svg>
    </div>
</div>

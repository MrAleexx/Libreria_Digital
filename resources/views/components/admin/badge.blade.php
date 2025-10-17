<!-- resources/views/components/badge.blade.php -->
@props(['type' => 'default', 'label' => null])

@php
    $styles = [
        'digital' => 'bg-blue-100 text-blue-800',
        'physical' => 'bg-orange-100 text-orange-800',
        'both' => 'bg-purple-100 text-purple-800',
        'success' => 'bg-green-100 text-green-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'info' => 'bg-blue-100 text-blue-800',
        'error' => 'bg-red-100 text-red-800',
        'free' => 'bg-green-100 text-green-800',
        'premium' => 'bg-yellow-100 text-yellow-800',
        'institutional' => 'bg-purple-100 text-purple-800',
        'default' => 'bg-gray-100 text-gray-800',
    ];

    $labels = [
        'digital' => 'Digital',
        'physical' => 'Físico',
        'both' => 'Mixto',
        'free' => 'Gratuito',
        'premium' => 'Premium',
        'institutional' => 'Institucional',
    ];

    $style = $styles[$type] ?? $styles['default'];
    $text = $label ?? ($labels[$type] ?? ucfirst($type));
@endphp

<span
    {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$style}"]) }}>
    {{ $text }}
</span>

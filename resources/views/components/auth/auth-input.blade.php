@props([
    'name',
    'label',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'value' => '',
    'error' => null,
])

<div class="form-group">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <div class="relative">
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
            placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}" {{ $required ? 'required' : '' }}
            class="form-input {{ $error ? 'error' : '' }} pr-10" {{ $attributes }} />

        @if ($type === 'password')
            <button type="button"
                class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-eye" data-show-icon="fa-eye" data-hide-icon="fa-eye-slash"></i>
            </button>
        @endif
    </div>

    @if ($error)
        <span class="form-error">{{ $error }}</span>
    @endif
</div>

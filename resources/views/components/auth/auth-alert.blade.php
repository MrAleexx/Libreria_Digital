@props(['type' => 'info', 'message' => '', 'duration' => 5000, 'autoDismiss' => true])

@if ($message)
    <div class="alert alert-{{ $type }}" data-duration="{{ $autoDismiss ? $duration : 0 }}">
        {{ $message }}
        <button class="alert-close">&times;</button>
    </div>
@endif

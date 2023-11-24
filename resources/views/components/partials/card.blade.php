@props([
    'bodyClasses' => 'flex-auto p-6',
])

<div {{ $attributes->merge(['class' => 'relative flex flex-col rounded-lg bg-white break-words shadow-xl']) }}>
    <div class="{{ $bodyClasses }}">
        
        @if(isset($title))
        <h4 class="text-lg font-bold mb-3">
            {{ $title }}
        </h4>
        @endif

        @if(isset($subtitle))
        <h5 class="text-gray-600 text-sm">
            {{ $subtitle }}
        </h5>
        @endif

        {{ $slot }}
    </div>
</div>
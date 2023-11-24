@props([
    'name',
    'label',
])

@if($label ?? null)
    @include('components.inputs.partials.label')
@endif

<textarea 
    id="{{ $name }}"
    name="{{ $name }}" 
    rows="3"
    {{ ($required ?? false) ? 'required' : '' }}
    {{ $attributes->merge(['class' => 'block appearance-none w-full py-1 px-2 text-base leading-normal text-gray-800 border border-gray-200 rounded']) }}
    autocomplete="off"
>{{$slot}}</textarea>

@error($name)
    @include('components.inputs.partials.error')
@enderror
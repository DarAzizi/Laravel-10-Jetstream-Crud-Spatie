@props([
    'name',
    'label',
    'value',
])

<x-inputs.basic type="email" :name="$name" label="{{ $label ?? ''}}" :value="$value ?? ''" :attributes="$attributes"></x-inputs.basic>
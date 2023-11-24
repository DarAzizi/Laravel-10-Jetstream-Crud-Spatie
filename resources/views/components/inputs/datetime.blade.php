@props([
    'name',
    'label',
    'value',
])

<x-inputs.basic type="datetime-local" :name="$name" label="{{ $label ?? ''}}" :value="$value ?? ''" :attributes="$attributes"></x-inputs.basic>
@props([
    'name',
    'value',
])

<x-inputs.basic type="hidden" :name="$name" :value="$value ?? ''" :attributes="$attributes"></x-inputs.basic>
@props([
    'name',
    'label',
    'value',
    'min' => null,
    'max' => null,
    'step' => null,
])

<x-inputs.basic type="number" :name="$name" label="{{ $label ?? ''}}" :value="$value ?? ''" :attributes="$attributes" :min="$min" :max="$max" :step="$step"></x-inputs.basic>
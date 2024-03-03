@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-system-500 focus:ring-system-500 rounded-md shadow-sm']) !!}>

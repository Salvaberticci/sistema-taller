@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-blue-100']) }}>
    {{ $value ?? $slot }}
</label>

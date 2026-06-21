@props(['value', 'required' => false])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-blue-100']) }}>
    {{ $value ?? $slot }}
    @if($required || $attributes->has('required'))
        <span class="text-red-500 ml-0.5">*</span>
    @endif
</label>

@props(['value'])

<label {{ $attributes->merge(['class' => 'label-airbnb']) }}>
    {{ $value ?? $slot }}
</label>

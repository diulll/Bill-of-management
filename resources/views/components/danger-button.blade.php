<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-rausch border border-transparent rounded-airbnb-sm font-medium text-body-sm text-white hover:bg-rausch-active focus:outline-none active:scale-[0.97] transition-all duration-150']) }}>
    {{ $slot }}
</button>

@props(['href' => '#'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'block w-full ps-3 pe-4 py-2 text-start text-sm leading-5 text-ink-600 hover:text-ink-800 hover:bg-paper focus:outline-none focus:text-ink-800 focus:bg-paper transition duration-150 ease-in-out']) }}>
    {{ $slot }}
</a>
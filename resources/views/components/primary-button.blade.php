<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-ink border border-transparent rounded-md font-semibold text-xs text-paper uppercase tracking-widest hover:bg-ink-600 focus:bg-ink-600 active:bg-ink-800 focus:outline-none focus:ring-2 focus:ring-brass focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
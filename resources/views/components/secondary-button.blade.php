<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-5 py-2.5 bg-white border border-ink-200 rounded-md font-semibold text-xs text-ink-600 uppercase tracking-widest shadow-sm hover:bg-paper-dark focus:outline-none focus:ring-2 focus:ring-brass focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
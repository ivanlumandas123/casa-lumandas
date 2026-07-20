@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-ink-200 focus:border-brass focus:ring-brass rounded-md shadow-sm bg-white text-ink-700 placeholder:text-ink-300']) }}>
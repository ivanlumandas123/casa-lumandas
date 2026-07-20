@props(['disabled' => false])

<input @disabled($disabled) type="checkbox" {{ $attributes->merge(['class' => 'rounded border-ink-200 text-brass shadow-sm focus:ring-brass']) }}>
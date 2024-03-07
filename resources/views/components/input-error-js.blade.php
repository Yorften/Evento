    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400']) }}>
        <li>{{ $slot }}</li>
    </ul>

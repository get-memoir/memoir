@props([
  'variant' => 'primary',
])

<nav {{ $attributes->class(['flex min-h-auto flex-col overflow-visible']) }}>
  {{ $slot }}
</nav>

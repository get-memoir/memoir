@props([
  'current' => false,
  'before' => '',
  'after' => '',
])

<a aria-current="{{ $current ? 'page' : '' }}" {{
  $attributes->class([
    'relative flex h-8 items-center justify-center space-x-3 rounded-lg',
    'text-gray-500 dark:text-white/80',
    'hover:text-gray-800 dark:hover:text-white',
    'aria-current:after:absolute aria-current:after:inset-x-0 aria-current:after:-bottom-3 aria-current:after:h-[2px]',
    'hover:bg-gray-800/5 aria-current:text-(--color-accent-content) hover:aria-current:bg-transparent hover:aria-current:text-(--color-accent-content) dark:hover:bg-white/10',
    'aria-current:after:bg-(--color-accent-content)',
    $slot->isNotEmpty() ? 'px-3' : 'size-10',
  ])
}}>
  <?php if (is_string($before) && $before !== ''): ?>

  <x-dynamic-component :component="$before" aria-hidden="true" width="20" height="20" class="shrink-0" />

  <?php else: ?>

  {{ $before }}

  <?php endif; ?>

  <?php if ($slot->isNotEmpty()): ?>

  <div class="flex-1 text-sm leading-none font-medium whitespace-nowrap [[data-nav-footer]_&]:hidden [[data-nav-sidebar]_[data-nav-footer]_&]:block">{{ $slot }}</div>

  <?php endif; ?>

  <?php if (is_string($after) && $after !== ''): ?>

  <x-dynamic-component :component="$after" aria-hidden="true" width="20" height="20" class="ml-1 shrink-0" />

  <?php else: ?>

  {{ $after }}

  <?php endif; ?>
</a>

@aware(['variant' => 'primary'])

@props([
  'current' => false,
  'before' => '',
  'after' => '',
])

<a
  aria-current="{{ $current ? 'page' : '' }}"
  {{
    $attributes->class([
      'relative flex h-10 items-center space-x-2 rounded-lg lg:h-8',
      'my-px w-full px-3 py-0 text-left',
      'text-gray-500 dark:text-white/80',
      'border border-transparent',
      'aria-current:text-(--color-accent-content) hover:aria-current:text-(--color-accent-content)',
      match (
        $variant // Hover...
      ) {
        'primary' => 'hover:bg-gray-800/5 hover:text-gray-800 dark:hover:bg-white/[7%] dark:hover:text-white',
        'secondary' => 'hover:bg-gray-800/[4%] hover:text-gray-800 dark:hover:bg-white/[7%] dark:hover:text-white',
      },
      match (
        $variant // Current...
      ) {
        'primary' => 'aria-current:border aria-current:border-gray-200 aria-current:bg-white dark:aria-current:border-transparent dark:aria-current:bg-white/[7%]',
        'secondary' => 'aria-current:bg-gray-800/[4%] dark:aria-current:bg-white/[7%]',
      },
    ])
  }}>
  <?php if (is_string($before) && $before !== ''): ?>

  <x-dynamic-component :component="$before" aria-hidden="true" width="16" height="16" class="shrink-0" />

  <?php else: ?>

  {{ $before }}

  <?php endif; ?>

  <?php if ($slot->isNotEmpty()): ?>

  <div class="flex-1 text-sm leading-none font-medium whitespace-nowrap">{{ $slot }}</div>

  <?php endif; ?>

  <?php if (is_string($after) && $after !== ''): ?>

  <x-dynamic-component :component="$after" aria-hidden="true" width="16" height="16" class="ml-1 shrink-0" />

  <?php else: ?>

  {{ $after }}

  <?php endif; ?>
</a>

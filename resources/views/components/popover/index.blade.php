@props([
  'justify' => 'right',
  'align' => 'end',
])

@php
  $x = match ($justify) {
    'left' => 'left-0 origin-left rtl:origin-right',
    'right' => 'right-0 origin-right rtl:origin-left',
  };
  $y = match ($align) {
    'top' => 'top-full mt-1.5',
    'bottom' => 'bottom-full mb-1.5',
  };
@endphp

<div x-data="popover" class="relative">
  {{ $slot }}
  <div x-cloak {{
    $menu->attributes->class([
      $x,
      $y,
      'absolute z-50',
      'p-[.3125rem] [:where(&)]:min-w-48',
      'rounded-lg shadow-xs',
      'border border-gray-200 dark:border-gray-600',
      'bg-white dark:bg-gray-700',
      'focus:outline-hidden',
    ])
  }}>
    {{ $menu }}
  </div>
</div>

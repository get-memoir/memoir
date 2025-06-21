<div {{
    $attributes->class([
      'group/button flex -space-x-px',
      '[&>button:not(:first-child):not(:last-child)]:rounded-none',
      '[&>button:first-child:not(:last-child)]:rounded-r-none',
      '[&>button:last-child:not(:first-child)]:rounded-l-none',
      '[&>button:last-child:not(:first-child)]:rounded-l-none',
    ])
  }} data-button-group>
  {{ $slot }}
</div>

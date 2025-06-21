@props([
  'id',
  'open' => false,
  'closable' => true,
])

<dialog id="{{ $id }}" {{
  $attributes->merge([
    'x-init' => $open ? '$el.showModal()' : '',
    'x-on:modal:open.document' => "\$event.detail == '{$id}' && \$el.showModal()",
  ])
}}>
  {{ $slot }}

  <?php if ($closable): ?>

  <form id="{{ $id }}_close" method="dialog" class="absolute top-0 right-0 p-4">
    <button class="inline-flex rounded-md bg-transparent p-1.5 text-sm text-gray-400 hover:bg-gray-800/5 hover:text-gray-800 dark:text-gray-500 dark:hover:bg-white/15 dark:hover:text-white">
      <x-phosphor-x aria-hidden="true" width="20" height="20" />
      <span class="sr-only">Close modal</span>
    </button>
  </form>

  <?php endif; ?>
</dialog>

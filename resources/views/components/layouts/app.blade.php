<x-layouts.app.sidebar :title="$title ?? null">
  <x-container class="max-w-full py-6 [grid-area:main] lg:py-8">
    {{ $slot }}
  </x-container>
</x-layouts.app.sidebar>

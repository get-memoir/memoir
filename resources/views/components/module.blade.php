@props([
  'padding' => 'p-4',
])

<div class="flex flex-col gap-2">
  <div {{ $attributes->merge(['class' => 'rounded-lg border border-gray-200 bg-white ']) }}>
    <div class="border-b border-gray-200 px-4 py-2">
      <div class="flex items-center gap-x-2">
        <div class="rounded-md bg-violet-600 text-white p-1">
          <x-phosphor-mastodon-logo class="size-4" />
        </div>

        <div class="">
          Mastodon
        </div>
      </div>

    </div>
    <div class="{{ $padding }}">
      {{ $slot }}
    </div>
  </div>
</div>

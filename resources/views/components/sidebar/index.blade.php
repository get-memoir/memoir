@props([
  'stashable' => null,
  'sticky' => null,
])

@php
  if ($sticky) {
    $attributes = $attributes->class(['sticky top-0 max-h-dvh overflow-y-auto overscroll-contain lg:sticky!']);
  }

  if ($stashable) {
    $attributes = $attributes->class([
      'max-lg:data-mobile-cloak:hidden [[data-show-stashed-sidebar]_&]:data-mobile-cloak:block',
      'fixed! top-0 left-0 z-20 max-h-dvh min-h-dvh',
      '-translate-x-full transition-transform',
      'lg:translate-x-0! [[data-show-stashed-sidebar]_&]:translate-x-0!',
    ]);
  }
@endphp

<?php if($stashable) : ?>

<div class="fixed inset-0 z-10 hidden bg-black/10 [[data-show-stashed-sidebar]_&]:block lg:[[data-show-stashed-sidebar]_&]:hidden" x-init="" x-on:click="document.body.removeAttribute('data-show-stashed-sidebar')"></div>

<?php endif; ?>

<div {{
  $attributes->class([
    '[grid-area:sidebar]',
    'z-1 flex flex-col gap-4 p-4 [:where(&)]:w-64',
  ])
}}>
  {{ $slot }}
</div>

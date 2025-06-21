@props([
  'size' => 'base',
])

@php
  $classes = [
    'block w-full appearance-none',
    'pr-3 pl-3',
    'bg-white dark:bg-white/10 dark:disabled:bg-white/[7%]',
    'text-gray-700 placeholder-gray-400 disabled:text-gray-500 disabled:placeholder-gray-400/70 dark:text-gray-300 dark:placeholder-gray-400 dark:disabled:text-gray-400 dark:disabled:placeholder-gray-500',
    'rounded-lg border border-gray-200 border-b-gray-300/80 disabled:border-b-gray-200 dark:border-white/10 dark:disabled:border-white/5',
    'shadow-xs disabled:shadow-none dark:shadow-none',
    'aria-invalid:border-red-500',
    match ($size) {
      'base' => 'h-10 py-2 text-base leading-[1.375rem] sm:text-sm',
      'sm' => 'h-8 py-1.5 text-sm leading-[1.125rem]',
      'xs' => 'h-6 py-1.5 text-xs leading-[1.125rem]',
    },
  ];
@endphp

<?php if ($label): ?>

<x-field>
  <x-label :for="$id" :value="$label" />
  <input {{ $formControlAttributes }} {{ $attributes->class($classes) }} value="{{ $value }}" />
  <x-error :for="$id" />
</x-field>

<?php else: ?>

<input {{ $formControlAttributes }} {{ $attributes->class($classes) }} value="{{ $value }}" />

<?php endif; ?>

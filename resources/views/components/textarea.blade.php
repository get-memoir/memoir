@props([
  'placeholder' => '',
  'height' => 'h-auto min-h-[80px]',
  'xRef' => '',
])

<div class="w-full">
  <textarea type="text" {{ $xRef ? "x-ref=$xRef" : '' }} x-data="{
    resize() {
      $el.style.height = '0px'
      $el.style.height = $el.scrollHeight + 'px'
    },
  }" x-init="resize()" @input="resize()" placeholder="{{ $placeholder }}" {!!
    $attributes->merge([
      'class' => 'block w-full appearance-none px-3 py-2 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-gray-700 placeholder-gray-400 disabled:text-gray-500 disabled:placeholder-gray-400/70 dark:text-gray-300 dark:placeholder-gray-400 dark:disabled:text-gray-400 dark:disabled:placeholder-gray-500 rounded-lg border border-gray-200 border-b-gray-300/80 disabled:border-b-gray-200 dark:border-white/10 dark:disabled:border-white/5 shadow-xs disabled:shadow-none dark:shadow-none aria-invalid:border-red-500 ' . $height,
    ])
  !!}>{{ $slot }}</textarea>
</div>

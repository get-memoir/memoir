@props([
  'src',
  'alt',
  'width',
  'height',
  'loading' => 'lazy',
])

<img src="{{ asset($src . '.webp') }}" srcset="{{ asset($src . '.webp') }} 1x, {{ asset($src . '@2x.webp') }} 2x" alt="{{ $alt }}" width="{{ $width }}" height="{{ $height }}" loading="{{ $loading }}" {{ $attributes }} />

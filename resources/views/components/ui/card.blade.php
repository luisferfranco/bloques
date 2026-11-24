
@props([
  'padding' => 'md',
])

@php
  $paddingClasses = [
    'sm' => 'p-4',
    'md' => 'p-6',
    'lg' => 'p-8',
  ];

  $paddingClass = $paddingClasses[$padding] ?? $paddingClasses['md'];
@endphp

<div
  {{ $attributes->class([
    'flex flex-col overflow-hidden shadow-sm',
  ]) }}
  style="
    background-color: var(--card-background, var(--background));
    color: var(--foreground);
    border: 1px solid color-mix(in srgb, var(--foreground) 12%, transparent);
    border-radius: var(--card-radius, 0.75rem);
  "
>
  @isset($header)
    <div
      class="{{ $paddingClass }}"
      style="border-bottom: 1px solid color-mix(in srgb, var(--foreground) 12%, transparent);"
    >
      {{ $header }}
    </div>
  @endisset

  <div class="{{ $paddingClass }}">
    {{ $slot }}
  </div>

  @isset($footer)
    <div
      class="{{ $paddingClass }}"
      style="border-top: 1px solid color-mix(in srgb, var(--foreground) 12%, transparent);"
    >
      {{ $footer }}
    </div>
  @endisset
</div>

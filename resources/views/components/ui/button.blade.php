@props([
  'variant'   => 'primary',
  'size'      => 'md',
  'type'      => 'button',
  'href'      => null,
  'disabled'  => false,
  'loading'   => false,
  'label'     => 'button',
])

@php
  $isDisabled = $disabled || $loading;

  $baseClasses = '
    inline-flex items-center justify-center gap-2
    whitespace-nowrap font-medium
    rounded-[var(--button-radius)]
    transition-colors
    focus-visible:outline-2
    focus-visible:outline-offset-2
    focus-visible:outline-[var(--primary)]
    disabled:pointer-events-none
    disabled:opacity-50
  ';

  $variants = [
    'primary' => '
      bg-[var(--primary)]
      text-[var(--primary-foreground)]
      hover:opacity-90
    ',
    'secondary' => '
      bg-[var(--secondary)]
      text-[var(--secondary-foreground)]
      hover:opacity-90
    ',
    'outline' => '
      border border-[var(--border)]
      text-[var(--foreground)]
      hover:bg-[var(--accent)]
    ',
    'link' => '
      text-[var(--primary)]
      underline-offset-4
      hover:underline
    ',
  ];

  $sizes = [
    'sm' => '
      h-[var(--button-height-sm)]
      px-3 text-sm
    ',
    'md' => '
      h-[var(--button-height-md)]
      px-4 text-sm
    ',
    'lg' => '
      h-[var(--button-height-lg)]
      px-6 text-base
    ',
  ];

  $classes = [
    $baseClasses,
    $variants[$variant] ?? $variants['primary'],
    $sizes[$size] ?? $sizes['md'],
  ];
@endphp

@if ($href)
  <a
    href="{{ $href }}"
    {{ $attributes->class($classes) }}
    @if ($isDisabled)
      aria-disabled="true"
      tabindex="-1"
    @endif
  >
    @if ($loading)
      <svg
        class="size-4 animate-spin"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        aria-hidden="true"
      >
        <circle
          class="opacity-25"
          cx="12"
          cy="12"
          r="10"
          stroke="currentColor"
          stroke-width="4"
        />
        <path
          class="opacity-75"
          fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"
        />
      </svg>
    @endif

    {{ $label ?? $slot }}
  </a>
@else
  <button
    type="{{ $type }}"
    {{ $attributes->class($classes) }}
    @disabled($isDisabled)
    @if ($loading)
      aria-busy="true"
    @endif
  >
    @if ($loading)
      <svg
        class="size-4 animate-spin"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        aria-hidden="true"
      >
        <circle
          class="opacity-25"
          cx="12"
          cy="12"
          r="10"
          stroke="currentColor"
          stroke-width="4"
        />
        <path
          class="opacity-75"
          fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"
        />
      </svg>
    @endif

    {{ $label ?? $slot }}
  </button>
@endif

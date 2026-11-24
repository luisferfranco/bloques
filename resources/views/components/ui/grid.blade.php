@props([
  'cols' => [
    'default' => 1,
    'sm' => 2,
    'lg' => 3,
  ],
  'gap' => 6,
])

@php
  $columnClasses = [
    'default' => [
      1 => 'grid-cols-1',
      2 => 'grid-cols-2',
      3 => 'grid-cols-3',
      4 => 'grid-cols-4',
      5 => 'grid-cols-5',
      6 => 'grid-cols-6',
    ],
    'sm' => [
      1 => 'sm:grid-cols-1',
      2 => 'sm:grid-cols-2',
      3 => 'sm:grid-cols-3',
      4 => 'sm:grid-cols-4',
      5 => 'sm:grid-cols-5',
      6 => 'sm:grid-cols-6',
    ],
    'md' => [
      1 => 'md:grid-cols-1',
      2 => 'md:grid-cols-2',
      3 => 'md:grid-cols-3',
      4 => 'md:grid-cols-4',
      5 => 'md:grid-cols-5',
      6 => 'md:grid-cols-6',
    ],
    'lg' => [
      1 => 'lg:grid-cols-1',
      2 => 'lg:grid-cols-2',
      3 => 'lg:grid-cols-3',
      4 => 'lg:grid-cols-4',
      5 => 'lg:grid-cols-5',
      6 => 'lg:grid-cols-6',
    ],
    'xl' => [
      1 => 'xl:grid-cols-1',
      2 => 'xl:grid-cols-2',
      3 => 'xl:grid-cols-3',
      4 => 'xl:grid-cols-4',
      5 => 'xl:grid-cols-5',
      6 => 'xl:grid-cols-6',
    ],
  ];

  $gapClasses = [
    0 => 'gap-0',
    1 => 'gap-1',
    2 => 'gap-2',
    3 => 'gap-3',
    4 => 'gap-4',
    5 => 'gap-5',
    6 => 'gap-6',
    8 => 'gap-8',
    10 => 'gap-10',
    12 => 'gap-12',
  ];

  $classes = [
    'grid',
    $gapClasses[$gap] ?? 'gap-6',
  ];

  foreach ($cols as $breakpoint => $count) {
    $class = $columnClasses[$breakpoint][$count] ?? null;

    if ($class) {
      $classes[] = $class;
    }
  }
@endphp

<div {{ $attributes->class($classes) }}>
  {{ $slot }}
</div>

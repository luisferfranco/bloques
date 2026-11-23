<?php

return [
  'display' => [
    'oswald' => [
      'name' => 'Oswald',
      'family' => 'Oswald',
      'weights' => [400, 500, 600, 700],
    ],
    'inter' => [
      'name' => 'Inter',
      'family' => 'Inter',
      'weights' => [400, 500, 600, 700],
    ],
    'anton' => [
      'name' => 'Anton',
      'family' => 'Anton',
      'weights' => [400],
    ],
    'bebas-neue' => [
      'name' => 'Bebas Neue',
      'family' => 'Bebas Neue',
      'weights' => [400],
    ],
    'playfair-display' => [
      'name' => 'Playfair Display',
      'family' => 'Playfair Display',
      'weights' => [400, 500, 600, 700],
    ],
  ],

  'text' => [
    'inter' => [
      'name' => 'Inter',
      'family' => 'Inter',
      'weights' => [400, 500, 600, 700],
    ],
    'roboto' => [
      'name' => 'Roboto',
      'family' => 'Roboto',
      'weights' => [400, 500, 700],
    ],
    'montserrat' => [
      'name' => 'Montserrat',
      'family' => 'Montserrat',
      'weights' => [400, 500, 600, 700],
    ],
    'comic-neue' => [
      'name' => 'Comic Neue',
      'family' => 'Comic Neue',
      'weights' => [400, 700],
    ],
    'open-sans' => [
      'name' => 'Open Sans',
      'family' => 'Open Sans',
      'weights' => [400, 500, 600, 700],
    ],
  ],

  'mono' => [
    'inter' => [
      'name' => 'Inter',
      'family' => 'Inter',
      'weights' => [400, 500, 600, 700],
    ],
    'roboto-mono' => [
      'name' => 'Roboto Mono',
      'family' => 'Roboto Mono',
      'weights' => [400, 500, 700],
    ],
    'source-code-pro' => [
      'name' => 'Source Code Pro',
      'family' => 'Source Code Pro',
      'weights' => [400, 500, 600, 700],
    ],
    'space-mono' => [
      'name' => 'Space Mono',
      'family' => 'Space Mono',
      'weights' => [400, 700],
    ],
  ],

'default' => 'inter',

'presets' => [
  'inter' => [
    'name' => 'Inter',
    'tier' => 'default',
    'heading' => 'inter',
    'body' => 'inter',
    'mono' => 'roboto-mono',
  ],

  'oswald-inter' => [
    'name' => 'Oswald + Inter',
    'tier' => 'premium',
    'heading' => 'oswald',
    'body' => 'inter',
    'mono' => 'roboto-mono',
  ],

  'roboto-condensed-roboto' => [
    'name' => 'Roboto Condensed + Roboto',
    'tier' => 'premium',
    'heading' => 'roboto-condensed',
    'body' => 'roboto',
    'mono' => 'roboto-mono',
  ],

  'playfair-open-sans' => [
    'name' => 'Playfair Display + Open Sans',
    'tier' => 'premium',
    'heading' => 'playfair-display',
    'body' => 'open-sans',
    'mono' => 'roboto-mono',
  ],

  'anton-inter' => [
    'name' => 'Anton + Inter',
    'tier' => 'premium',
    'heading' => 'anton',
    'body' => 'inter',
    'mono' => 'roboto-mono',
  ],
],
];
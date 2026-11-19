<?php

namespace Database\Seeders;

use App\Models\DesignTokenSchema;
use App\Models\Theme;
use App\Models\ThemeVersion;
use Illuminate\Database\Seeder;

class ThemeVersionSeeder extends Seeder
{
  public function run(): void
  {
    $theme = Theme::where('slug', 'default')->firstOrFail();

    $schema = DesignTokenSchema::where('name', 'default')
      ->where('version', '1.0.0')
      ->firstOrFail();

    $tokens = [
      // Colors
      'primary' => '#2563eb',
      'primary-foreground' => '#ffffff',
      'secondary' => '#e2e8f0',
      'secondary-foreground' => '#0f172a',
      'accent' => '#0ea5e9',
      'accent-foreground' => '#ffffff',
      'background' => '#ffffff',
      'foreground' => '#0f172a',
      'muted' => '#f1f5f9',
      'muted-foreground' => '#64748b',
      'border' => '#e2e8f0',
      'input' => '#e2e8f0',
      'ring' => '#2563eb',
      'success' => '#16a34a',
      'warning' => '#d97706',
      'danger' => '#dc2626',
      'info' => '#0284c7',

      // Surfaces
      'surface' => '#ffffff',
      'surface-raised' => '#ffffff',
      'surface-sunken' => '#f8fafc',
      'surface-overlay' => '#ffffff',
      'surface-inverted' => '#0f172a',

      // Typography
      'font-heading' => 'Inter, sans-serif',
      'font-body' => 'Inter, sans-serif',
      'font-mono' => 'monospace',

      // Shapes
      'radius-none' => '0',
      'radius-sm' => '0.25rem',
      'radius-md' => '0.5rem',
      'radius-lg' => '0.75rem',
      'radius-xl' => '1rem',
      'radius-full' => '9999px',

      // Buttons
      'button-radius' => '0.5rem',
      'button-height-sm' => '2rem',
      'button-height-md' => '2.5rem',
      'button-height-lg' => '3rem',

      // Shadows
      'shadow-sm' => '0 1px 2px rgb(0 0 0 / 0.05)',
      'shadow-md' => '0 4px 6px -1px rgb(0 0 0 / 0.1)',
      'shadow-lg' => '0 10px 15px -3px rgb(0 0 0 / 0.1)',
      'shadow-xl' => '0 20px 25px -5px rgb(0 0 0 / 0.1)',
      'shadow-glow' => '0 0 20px rgb(37 99 235 / 0.2)',

      // Layout
      'container-width' => '1280px',
      'section-spacing' => '5rem',
      'content-spacing' => '1.5rem',
      'grid-gap' => '1.5rem',
      'page-padding-x' => '1.5rem',
      'page-padding-y' => '2rem',

      // Components
      'card-background' => '#ffffff',
      'card-border' => '#e2e8f0',
      'card-radius' => '0.75rem',
      'card-shadow' => '0 1px 3px rgb(0 0 0 / 0.1)',
      'input-background' => '#ffffff',
      'input-radius' => '0.5rem',
      'badge-radius' => '9999px',
      'divider-color' => '#e2e8f0',
    ];

    ThemeVersion::firstOrCreate(
      [
        'theme_id' => $theme->id,
        'version' => '1.0.0',
      ],
      [
        'design_token_schema_id' => $schema->id,
        'tokens' => $tokens,
        'is_published' => true,
        'published_at' => now(),
      ],
    );
  }
}

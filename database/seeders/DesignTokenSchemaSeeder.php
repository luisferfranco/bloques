<?php

namespace Database\Seeders;

use App\Models\DesignTokenSchema;
use Illuminate\Database\Seeder;

class DesignTokenSchemaSeeder extends Seeder
{
  public function run(): void
  {
    $definition = [
      'tokens' => [
        // Colors
        'primary' => ['type' => 'color', 'required' => true],
        'primary-foreground' => ['type' => 'color', 'required' => true],
        'secondary' => ['type' => 'color', 'required' => true],
        'secondary-foreground' => ['type' => 'color', 'required' => true],
        'accent' => ['type' => 'color', 'required' => true],
        'accent-foreground' => ['type' => 'color', 'required' => true],
        'background' => ['type' => 'color', 'required' => true],
        'foreground' => ['type' => 'color', 'required' => true],
        'muted' => ['type' => 'color', 'required' => true],
        'muted-foreground' => ['type' => 'color', 'required' => true],
        'border' => ['type' => 'color', 'required' => true],
        'input' => ['type' => 'color', 'required' => true],
        'ring' => ['type' => 'color', 'required' => true],
        'success' => ['type' => 'color', 'required' => true],
        'warning' => ['type' => 'color', 'required' => true],
        'danger' => ['type' => 'color', 'required' => true],
        'info' => ['type' => 'color', 'required' => true],

        // Surfaces
        'surface' => ['type' => 'color', 'required' => true],
        'surface-raised' => ['type' => 'color', 'required' => true],
        'surface-sunken' => ['type' => 'color', 'required' => true],
        'surface-overlay' => ['type' => 'color', 'required' => true],
        'surface-inverted' => ['type' => 'color', 'required' => true],

        // Typography
        'font-heading' => ['type' => 'font-family', 'required' => true],
        'font-body' => ['type' => 'font-family', 'required' => true],
        'font-mono' => ['type' => 'font-family', 'required' => true],

        // Shapes
        'radius-none' => ['type' => 'length', 'required' => true],
        'radius-sm' => ['type' => 'length', 'required' => true],
        'radius-md' => ['type' => 'length', 'required' => true],
        'radius-lg' => ['type' => 'length', 'required' => true],
        'radius-xl' => ['type' => 'length', 'required' => true],
        'radius-full' => ['type' => 'length', 'required' => true],

        // Buttons
        'button-radius' => ['type' => 'length', 'required' => true],
        'button-height-sm' => ['type' => 'length', 'required' => true],
        'button-height-md' => ['type' => 'length', 'required' => true],
        'button-height-lg' => ['type' => 'length', 'required' => true],

        // Shadows
        'shadow-sm' => ['type' => 'shadow', 'required' => true],
        'shadow-md' => ['type' => 'shadow', 'required' => true],
        'shadow-lg' => ['type' => 'shadow', 'required' => true],
        'shadow-xl' => ['type' => 'shadow', 'required' => true],
        'shadow-glow' => ['type' => 'shadow', 'required' => true],

        // Layout
        'container-width' => ['type' => 'length', 'required' => true],
        'section-spacing' => ['type' => 'length', 'required' => true],
        'content-spacing' => ['type' => 'length', 'required' => true],
        'grid-gap' => ['type' => 'length', 'required' => true],
        'page-padding-x' => ['type' => 'length', 'required' => true],
        'page-padding-y' => ['type' => 'length', 'required' => true],

        // Components
        'card-background' => ['type' => 'color', 'required' => true],
        'card-border' => ['type' => 'color', 'required' => true],
        'card-radius' => ['type' => 'length', 'required' => true],
        'card-shadow' => ['type' => 'shadow', 'required' => true],
        'input-background' => ['type' => 'color', 'required' => true],
        'input-radius' => ['type' => 'length', 'required' => true],
        'badge-radius' => ['type' => 'length', 'required' => true],
        'divider-color' => ['type' => 'color', 'required' => true],
      ],
    ];

    DesignTokenSchema::updateOrCreate(
      [
        'name' => 'default',
        'version' => '1.0.0',
      ],
      [
        'definition' => $definition,
        'is_active' => true,
        'published_at' => now(),
      ],
    );
  }
}

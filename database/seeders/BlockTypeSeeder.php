<?php

namespace Database\Seeders;

use App\Models\BlockType;
use Illuminate\Database\Seeder;

class BlockTypeSeeder extends Seeder
{
  public function run(): void
  {
    $types = [
      [
        'name' => 'Hero',
        'slug' => 'hero',
        'description' => 'Sección principal de presentación.',
        'component' => 'blocks.hero',
        'configuration_class' => 'Hero',
        'is_active' => true,
        'is_premium' => false,
      ],
      [
        'name' => 'Misión y Visión',
        'slug' => 'mission-vision',
        'description' => 'Sección para presentar la misión y visión.',
        'component' => 'blocks.mission-vision',
        'configuration_class' => 'MissionVision',
        'is_active' => true,
        'is_premium' => false,
      ],
      [
        'name' => 'Texto',
        'slug' => 'texto',
        'description' => 'Sección de contenido textual.',
        'component' => 'blocks.texto',
        'configuration_class' => 'Text',
        'is_active' => true,
        'is_premium' => false,
      ],
      [
        'name' => 'Servicios',
        'slug' => 'services',
        'description' => 'Sección para mostrar los servicios ofrecidos.',
        'component' => 'blocks.services',
        'configuration_class' => 'Services',
        'is_active' => true,
        'is_premium' => false,
      ],
    ];

    foreach ($types as $type) {
      BlockType::updateOrCreate(
        ['slug' => $type['slug']],
        $type,
      );
    }
  }
}
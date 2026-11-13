<?php

namespace Database\Seeders;

use App\Models\BlockType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlockTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $types = [
      [
        'name' => 'Hero',
        'slug' => 'hero',
        'description' => 'Hero Component',
        'component' => 'hero',
      ],
      [
        'name' => 'Misión/Visión',
        'slug' => 'mission',
        'description' => 'Mission Component',
        'component' => 'mission',
      ],
      [
        'name' => 'Text',
        'slug' => 'text',
        'description' => 'Text Component',
        'component' => 'text',
      ],
    ];

    foreach ($types as $type) {
      BlockType::updateOrCreate(
        ['slug' => $type['slug']],
        $type
      );
    }
  }
}

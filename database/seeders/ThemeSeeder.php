<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
  public function run(): void
  {
    Theme::updateOrCreate(
      ['slug'           => 'default'],
      [
        'name'          => 'Default',
        'description'   => 'Tema gratuito predeterminado de Blocks.',
        'preview_image' => null,
        'is_active'     => true,
        'is_premium'    => false,
      ],
    );
  }
}

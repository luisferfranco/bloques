<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PageType;

class PageTypeSeeder extends Seeder
{
  public function run(): void {
    $types = [
      [
        'slug' => 'inicio',
        'name' => 'Inicio',
        'description' => 'Inicio',
        'is_active' => true,
      ],
      [
        'slug' => 'nosotros',
        'name' => 'Nosotros',
        'description' => 'Nosotros',
        'is_active' => true,
      ],
      [
        'slug' => 'contacto',
        'name' => 'Contacto',
        'description' => 'Contacto',
        'is_active' => true,
      ],
      [
        'slug' => 'servicios',
        'name' => 'Servicios',
        'description' => 'Servicios',
        'is_active' => true,
      ],
    ];

    foreach ($types as $type) {
      PageType::create($type);
    }
  }
}

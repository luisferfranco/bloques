<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\TenantSeeder;
use Database\Seeders\PageTypeSeeder;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
  use WithoutModelEvents;

  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $user = User::updateOrCreate([
      'email'     => 'luisferfranco@gmail.com',
    ], [
      'name'      => 'Luis F. Franco',
      'password'  => bcrypt('password'),
    ]);

    $this->call([
      // Temas
      ThemeSeeder::class,
      DesignTokenSchemaSeeder::class,
      ThemeVersionSeeder::class,

      PageTypeSeeder::class,
      TenantSeeder::class,
      BlockTypeSeeder::class,
      TenantThemeSeeder::class,
      RoleSeeder::class,
    ]);

    $user->assignRole('SUPER_ADMIN');
  }
}

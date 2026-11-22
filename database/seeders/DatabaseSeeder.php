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
    $user = User::firstOrCreate([
      'name'      => 'Luis F. Franco',
    ], [
      'email'     => 'luisferfranco@gmail.com',
      'password'  => bcrypt('password'),
    ]);

    $this->call([
      PageTypeSeeder::class,
      TenantSeeder::class,
      BlockTypeSeeder::class,
      DesignTokenSchemaSeeder::class,
      ThemeSeeder::class,
      ThemeVersionSeeder::class,
      TenantThemeSeeder::class,
      RoleSeeder::class,
    ]);

    $user->assignRole('SUPER_ADMIN');
  }
}

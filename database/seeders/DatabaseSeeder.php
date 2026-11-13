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
    User::factory()->create([
      'name'  => 'Luis F. Franco',
      'email' => 'luisferfranco@gmail.com',
    ]);

    $this->call([
      TenantSeeder::class,
      PageTypeSeeder::class,
      BlockTypeSeeder::class,
    ]);
  }
}

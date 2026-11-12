<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $tenant = Tenant::firstOrCreate([
      'slug' => 'default-tenant',
    ], [
      'name' => 'Default Tenant',
    ]);

    $tenant->users()->attach(1);
  }
}

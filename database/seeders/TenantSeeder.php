<?php

namespace Database\Seeders;

use App\Models\PageType;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $tenant = Tenant::updateOrCreate([
      'slug'          => 'default-tenant',
    ], [
      'name'          => 'Default Tenant',
      'meta'          => [
        'typography'  => [
          'preset'    => 'oswald-inter',
      ]],
    ]);

    if (!$tenant->users()->where('user_id', 1)->exists()) {
      $tenant->users()->attach(1, ['is_owner' => true]);
    }

    $initialPages = ['inicio', 'nosotros', 'servicios', 'contacto'];
    foreach ($initialPages as $index => $page) {
      $tenant->pages()->updateOrCreate([
        'slug'          => $page,
      ], [
        'name'          => $page,
        'is_active'     => true,
        'is_system'     => $page == 'contacto',
        'sort_order'    => $index+1,
      ]);
    }


  }
}

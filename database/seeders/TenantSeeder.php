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
    $tenant = Tenant::firstOrCreate([
      'slug' => 'default-tenant',
    ], [
      'name' => 'Default Tenant',
    ]);

    $tenant->users()->attach(1, ['is_owner' => true]);

    $initialPages = ['inicio', 'nosotros', 'servicios', 'contacto'];
    foreach ($initialPages as $index => $page) {
      $pageType = PageType::where('slug', $page)
        ->first();

      $tenant->pages()->create([
        'page_type_id'  => $pageType->id,
        'name'          => $pageType->name,
        'slug'          => $pageType->slug,
        'description'   => $pageType->description,
        'is_active'     => true,
        'is_system'     => true,
        'sort_order'    => $index+1,
      ]);
    }


  }
}

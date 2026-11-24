<?php

namespace App\Filament\Dashboard\Pages;

use App\Models\PageType;
use App\Models\Tenant;
use App\Models\ThemeVersion;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;

class CreateTenant extends RegisterTenant
{
  public static function getLabel(): string
  {
    return 'Crear Tenant';
  }

  public function form(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextInput::make('name')
          ->label('Nombre del Tenant')
          ->required()
          ->maxLength(255),

        TextInput::make('slug')
          ->label('Identificador URL')
          ->required()
          ->maxLength(255)
          ->rules([
            'alpha_dash',
            'unique:tenants,slug',
          ]),
      ]);
  }

  protected function handleRegistration(array $data): Tenant
  {
    return DB::transaction(function () use ($data): Tenant {
      // 1. Crear tenant

    $themeVersion = ThemeVersion::query()
      ->latest('version')
      ->firstOrFail();

      $tenant = Tenant::create([
        'name' => $data['name'],
        'slug' => $data['slug'],
        'is_active' => true,
        'theme_version_id' => $themeVersion->id,
      ]);

      // 2. Asociar usuario autenticado
      $tenant->users()->attach(auth()->id(), [
          'is_owner' => true,
      ]);

      // 3. Obtener los cuatro tipos de página
      $initialPages = ['inicio', 'nosotros', 'servicios', 'contacto'];
      $pageTypes = PageType::query()
        ->whereIn('slug', $initialPages)
        ->get();

      if ($pageTypes->count() !== count($initialPages)) {
        throw new \LogicException(
          'No se encontraron todos los tipos de página iniciales.'
        );
      }

      // 4. Crear las cuatro páginas asociadas al tenant
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

      return $tenant;
    });
  }
}
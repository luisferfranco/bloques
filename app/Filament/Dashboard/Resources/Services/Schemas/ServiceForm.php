<?php

namespace App\Filament\Dashboard\Resources\Services\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class ServiceForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->columns(1)
      ->components([
        Toggle::make('help')
          ->label('Mostrar Ayuda para los Campos')
          ->live()
          ->dehydrated(false),

        TextInput::make('name')
          ->label('Nombre')
          ->helperText(fn ($get) => $get('help')
            ? 'Nombre del grupo de servicios, no se usa en el sitio, es para tu identificación.'
            : null
          )
          ->required(),
        Textarea::make('description')
          ->label('Descripción')
          ->helperText(fn ($get) => $get('help')
            ? 'Descripción del servicio, no se usa en el sitio, es para tu información.'
            : null
          )
          ->rows(4),
      ]);
  }
}

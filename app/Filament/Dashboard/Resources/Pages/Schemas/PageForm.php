<?php

namespace App\Filament\Dashboard\Resources\Pages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PageForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Toggle::make('ayuda')
          ->label('Mostrar ayuda para los campos')
          ->live()
          ->default(true)
          ->columnSpanFull(),
        TextInput::make('name')
          ->label('Nombre')
          // Desplegar el helper solo si ayuda es true
          ->helperText(fn ($get) =>
            $get('ayuda')
            ? 'Este es el nombre que le quieras dar a la página, se utiliza en el menú, en el título y en otros lugares según la configuración del sitio'
            : null
          )
          ->required(),
        TextInput::make('slug')
          ->label('Slug')
          ->helperText(fn ($get) =>
            $get('ayuda')
            ? 'Este es el nombre de la dirección que se utilizará en la URL de la página, por ejemplo en https://.../slug'
            : null
          )
          ->required(),
        Textarea::make('description')
          ->label('Descripción')
          ->helperText(fn ($get) =>
            $get('ayuda')
            ? 'Esta es la descripción de la página, es para ti, no se usa en ningún lugar en el sitio'
            : null
          )
          ->columnSpanFull(),
        Toggle::make('is_active')
          ->label('Activo')
          ->helperText(fn ($get) =>
            $get('ayuda')
            ? 'Indica si la página está activa y visible en el sitio'
            : null
          )
          ->required(),
      ]);
  }
}

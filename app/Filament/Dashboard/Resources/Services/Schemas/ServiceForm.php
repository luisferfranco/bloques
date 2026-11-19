<?php

namespace App\Filament\Dashboard\Resources\Services\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextInput::make('name')
          ->label('Nombre')
          ->required(),
        TextInput::make('price')
          ->label('Precio')
          ->required()
          ->numeric()
          ->prefix('$'),
        Textarea::make('description')
          ->label('Descripción')
          ->rows(4)
          ->required()
          ->helperText('Si se trata de un \'pack\' de servicios, describe los servicios incluidos, uno por cada línea.')
          ->columnSpanFull(),
        FileUpload::make('image_url')
          ->image()
          ->label('Imagen')
          ->disk('public')
          ->directory('services')
          ->visibility('public')
          ->columnSpanFull(),
      ]);
  }
}

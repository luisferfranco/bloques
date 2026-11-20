<?php

namespace App\Filament\Resources\Themes\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ThemeForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextInput::make('name')
          ->required(),
        TextInput::make('slug')
          ->required(),
        Textarea::make('description')
          ->rows(4)
          ->columnSpanFull(),
        FileUpload::make('preview_image')
          ->image()
          ->columnSpanFull(),
        Toggle::make('is_active'),
        Toggle::make('is_premium'),
      ]);
  }
}

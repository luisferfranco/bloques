<?php

namespace App\Filament\Resources\ThemeVersions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ThemeVersionForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Select::make('design_token_schema_id')
          ->relationship('designTokenSchema', 'name')
          ->required(),
        TextInput::make('version')
          ->required(),
        Textarea::make('tokens')
          ->rows(20)
          ->required()
          ->rules(['json'])
          ->formatStateUsing(fn ($state) => json_encode(
            $state,
            JSON_PRETTY_PRINT |
            JSON_UNESCAPED_UNICODE |
            JSON_UNESCAPED_SLASHES |
            JSON_THROW_ON_ERROR
          ))
          ->dehydrateStateUsing(fn (string $state) => json_decode(
            $state,
            true,
            512,
            JSON_THROW_ON_ERROR
          ))
          ->columnSpanFull(),
      ]);
  }
}

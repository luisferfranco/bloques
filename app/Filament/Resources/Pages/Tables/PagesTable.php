<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ToggleColumn;

class PagesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->reorderable('sort_order')
      ->columns([
        TextColumn::make('pageType.name')
          ->label('Tipo')
          ->searchable(),
        TextColumn::make('name')
          ->label('Nombre')
          ->searchable(),
        TextColumn::make('slug')
          ->searchable(),
        ToggleColumn::make('is_active')
          ->label('Activa'),
        IconColumn::make('is_system')
          ->label('Sistema')
          ->boolean(),
        TextColumn::make('sort_order')
          ->label('Orden')
          ->numeric()
          ->sortable(),
        TextColumn::make('created_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
        TextColumn::make('updated_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->filters([
        //
      ])
      ->recordActions([
        EditAction::make(),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}

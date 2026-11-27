<?php

namespace App\Filament\Dashboard\Resources\Services\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class ServicesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name')
          ->label('Nombre'),
        TextColumn::make('description')
          ->label('Descripción')
          ->wrap()
          ->limit(75)
          ->tooltip(fn ($state) => $state),
        ToggleColumn::make('is_active')
          ->label('Activo'),
        IconColumn::make('blockType.is_premium')
          ->label('Premium')
          ->boolean(),
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

<?php

namespace App\Filament\Resources\ThemeVersions\Tables;

use App\Models\ThemeVersion;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ThemeVersionsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('theme.name')
          ->searchable(),

        TextColumn::make('designTokenSchema.name')
          ->searchable(),

        TextColumn::make('version')
          ->searchable(),

        TextColumn::make('publication_status')
          ->label('Estado')
          ->state(fn (ThemeVersion $record): string => match (true) {
            $record->is_published => 'Publicada',
            $record->published_at !== null => 'Retirada',
            default => 'Borrador',
          })
          ->badge()
          ->color(fn (string $state): string => match ($state) {
            'Publicada' => 'success',
            'Retirada' => 'gray',
            default => 'warning',
          }),

        TextColumn::make('published_at')
          ->dateTime()
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
      ]);
  }
}

<?php

namespace App\Filament\Resources\ThemeVersions\Tables;

use App\Actions\ThemeVersions\ValidateThemeVersionTokens;
use App\Models\ThemeVersion;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
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

        Action::make('publish')
          ->label('Publicar')
          ->icon('lucide-square-check-big')
          ->color('success')
          ->requiresConfirmation()
          ->visible(fn (ThemeVersion $record): bool => ! $record->is_published)
          ->action(function (ThemeVersion $record): void {
            app(ValidateThemeVersionTokens::class)->handle($record);

            $record->is_published = true;
            $record->published_at ??= now();
            $record->save();

            Notification::make()
              ->title('Versión publicada correctamente')
              ->success()
              ->send();
          }),

        Action::make('retire')
          ->label('Retirar')
          ->icon('lucide-archive')
          ->color('danger')
          ->requiresConfirmation()
          ->visible(fn (ThemeVersion $record): bool => $record->is_published)
          ->disabled(fn (ThemeVersion $record): bool => $record->tenant()->exists())
          ->action(function (ThemeVersion $record): void {
            if ($record->tenant()->exists()) {
              Notification::make()
                ->title('No se puede retirar esta versión')
                ->body('Está asignada a uno o más tenants.')
                ->danger()
                ->send();

              return;
            }

            $record->is_published = false;
            $record->save();

            Notification::make()
              ->title('Versión retirada correctamente')
              ->success()
              ->send();
          }),
      ])
      ->toolbarActions([
      ]);
  }
}

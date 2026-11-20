<?php

namespace App\Filament\Resources\ThemeVersions;

use App\Filament\Resources\ThemeVersions\Pages\CreateThemeVersion;
use App\Filament\Resources\ThemeVersions\Pages\EditThemeVersion;
use App\Filament\Resources\ThemeVersions\Pages\ListThemeVersions;
use App\Filament\Resources\ThemeVersions\Schemas\ThemeVersionForm;
use App\Filament\Resources\ThemeVersions\Tables\ThemeVersionsTable;
use App\Models\ThemeVersion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ThemeVersionResource extends Resource
{
  protected static ?string $model = ThemeVersion::class;
  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
  protected static ?string $recordTitleAttribute = 'version';
  protected static bool $shouldRegisterNavigation = false;

  public static function form(Schema $schema): Schema
  {
    return ThemeVersionForm::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return ThemeVersionsTable::configure($table);
  }

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => ListThemeVersions::route('/'),
      'create' => CreateThemeVersion::route('/create'),
      'edit' => EditThemeVersion::route('/{record}/edit'),
    ];
  }
}

<?php

namespace App\Filament\Dashboard\Resources\Services;

use App\Filament\Dashboard\Resources\Services\Pages\CreateService;
use App\Filament\Dashboard\Resources\Services\Pages\EditService;
use App\Filament\Dashboard\Resources\Services\Pages\ListServices;
use App\Filament\Dashboard\Resources\Services\Schemas\ServiceForm;
use App\Filament\Dashboard\Resources\Services\Tables\ServicesTable;
use App\Models\Block;
use App\Models\Service;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ServiceResource extends Resource
{
  protected static ?string $model = Block::class;
  protected static ?string $modelLabel = 'servicio';
  protected static ?string $pluralModelLabel = 'servicios';
  protected static string|BackedEnum|null $navigationIcon = "lucide-engine";
  protected static string | UnitEnum | null $navigationGroup = 'Bloques';
  protected static ?int $navigationSort = 1;

  protected static ?string $recordTitleAttribute = 'name';

  public static function form(Schema $schema): Schema
  {
    return ServiceForm::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return ServicesTable::configure($table);
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
      'index' => ListServices::route('/'),
      'create' => CreateService::route('/create'),
      'edit' => EditService::route('/{record}/edit'),
    ];
  }
}

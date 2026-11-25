<?php

namespace App\Filament\Dashboard\Resources\Pages;
use App\Filament\Dashboard\Resources\Pages\Pages\CreatePage;
use App\Filament\Dashboard\Resources\Pages\Pages\EditPage;
use App\Filament\Dashboard\Resources\Pages\Pages\ListPages;
use App\Filament\Dashboard\Resources\Pages\Schemas\PageForm;
use App\Filament\Dashboard\Resources\Pages\Tables\PagesTable;
use App\Models\Page;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Dashboard\Resources\Pages\RelationManagers\BlocksRelationManager;

class PageResource extends Resource
{
  protected static ?string $model = Page::class;
  protected static ?string $modelLabel = 'página';
  protected static ?string $pluralModelLabel = 'páginas';
  protected static string|BackedEnum|null $navigationIcon = 'lucide-layers';

  protected static ?string $recordTitleAttribute = 'name';

  public static function form(Schema $schema): Schema
  {
    return PageForm::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return PagesTable::configure($table);
  }

  public static function getRelations(): array
  {
    return [
      BlocksRelationManager::class,
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => ListPages::route('/'),
      'create' => CreatePage::route('/create'),
      'edit' => EditPage::route('/{record}/edit'),
    ];
  }

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()
      ->orderBy('sort_order');
  }


}

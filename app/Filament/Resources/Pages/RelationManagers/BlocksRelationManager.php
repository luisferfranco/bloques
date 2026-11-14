<?php

namespace App\Filament\Resources\Pages\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Actions\Action;
use App\Models\Block;
use App\Filament\Pages\Blocks\Hero;
use App\Filament\Pages\Blocks\MissionVision;

class BlocksRelationManager extends RelationManager
{
  protected static string $relationship = 'blocks';

  public function form(Schema $schema): Schema
  {
    return $schema
      ->components([
        Select::make('block_type_id')
          ->relationship('blockType', 'name')
          ->required(),
        TextInput::make('name')
          ->required(),
        Textarea::make('description')
          ->columnSpanFull(),
        Textarea::make('params')
          ->columnSpanFull(),
        Toggle::make('is_active')
          ->required(),
        TextInput::make('sort_order')
          ->required()
          ->numeric()
          ->default(0),
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->reorderable('sort_order')
      ->recordTitleAttribute('id')
      ->columns([
        TextColumn::make('blockType.name')
          ->label('Tipo de Bloque')
          ->searchable(),
        TextColumn::make('name')
          ->label('Nombre')
          ->searchable(),
        ToggleColumn::make('is_active')
          ->label('Activo'),
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
      ->headerActions([
        CreateAction::make(),
        AssociateAction::make(),
      ])
      ->recordActions([
        EditAction::make()
          ->iconButton(),
        DissociateAction::make()
          ->iconButton(),
        DeleteAction::make()
          ->iconButton(),
        Action::make('config')
          ->iconButton()
          ->icon('heroicon-o-cog-8-tooth')
          ->tooltip('Configurar Bloque')
          ->url(fn (Block $record): string => match($record->blockType->slug) {
            'hero' => Hero::getUrl([
              'block' => $record->getKey(),
            ]),
            'mission-vision' => MissionVision::getUrl([
              'block' => $record->getKey(),
            ]),
            default => '#',
          })
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DissociateBulkAction::make(),
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}

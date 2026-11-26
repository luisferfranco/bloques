<?php

namespace App\Filament\Dashboard\Resources\Pages\RelationManagers;

use App\Filament\Dashboard\Pages\Blocks\Hero;
use App\Filament\Dashboard\Pages\Blocks\MissionVision;
use App\Models\Block;
use App\Models\BlockType;
use Filament\Actions\Action;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BlocksRelationManager extends RelationManager
{
  protected static string $relationship = 'blocks';

  public function form(Schema $schema): Schema
  {
    return $schema
      ->components([
        Toggle::make('ayuda')
          ->label('Ayuda para los campos')
          ->live()
          ->columnSpanFull(),

        Select::make('block_type_id')
          ->label('Tipo de Bloque')
          ->relationship('blockType', 'name')
          ->helperText(fn ($get) =>
            $get('ayuda')
              ? 'Selecciona el tipo de bloque que deseas agregar'
              : null
          )
          ->required(),
        TextInput::make('name')
          ->label('Nombre')
          ->helperText(fn ($get) =>
            $get('ayuda')
              ? 'Ingresa el nombre del bloque. Este valor es para que tu lo identifiques y puedas usarlo en otras páginas. No se despliega en ningún lugar del sitio.'
              : null
          ),
        Textarea::make('description')
          ->label('Descripción')
          ->helperText(fn ($get) =>
            $get('ayuda')
              ? 'Ingresa una descripción para el bloque. Este valor es para ti y que sepas que hace este bloque. No se despliega en ningún lugar del sitio.'
              : null
          )
          ->columnSpanFull(),
        Toggle::make('is_active')
          ->label('Activo')
          ->helperText(fn ($get) =>
            $get('ayuda')
              ? 'Activa o desactiva el bloque'
              : null
          )
          ->columnSpanFull(),
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
        CreateAction::make()
          ->label('Crear Bloque')
          ->icon('lucide-grid-2x2-plus')
          ->mutateDataUsing(function (array $data) {
              unset($data['ayuda']);

              if (blank($data['name'] ?? null)) {
                $data['name'] = BlockType::find($data['block_type_id'])->name ?? null;
              }

              return $data;
          })
          ->using(function (CreateAction $action, array $data): Model {
            $relationship = $action->getRelationship();

            $sortOrder = $relationship->count() + 1;

            $record = new Block();
            $record->fill($data);

            return $relationship->save($record, [
              'sort_order' => $sortOrder,
            ]);
          }),
        AssociateAction::make()
          ->label('Asociar Bloque Existente')
          ->icon('lucide-blocks'),
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
          ->url(function (Block $record): ?string {
            $page = $record->blockType->configuration_class ?? null;

            if (!$page) return null;

            $config = "App\\Filament\\Dashboard\\Pages\\Blocks\\{$page}";
            if (!class_exists($config)) return null;

            return $config::getUrl([
              'block' => $record->getKey(),
            ]);
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

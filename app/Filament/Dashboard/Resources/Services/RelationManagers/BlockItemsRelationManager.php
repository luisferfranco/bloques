<?php

namespace App\Filament\Dashboard\Resources\Services\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class BlockItemsRelationManager extends RelationManager
{
  protected static string $relationship = 'BlockItems';
  protected static ?string $title = 'Servicios';

  public function form(Schema $schema): Schema
  {
    return $schema
      ->components([
        Toggle::make('help')
          ->label('Ayuda con los campos')
          ->live()
          ->columnSpanFull()
          ->dehydrated(false),

        TextInput::make('title')
          ->label('Título')
          ->required()
          ->helperText(fn ($get) => $get('help')
            ? 'Nombre del servicio (una descripción muy corta y entendible)'
            : null)
          ->columnSpanFull(),
        TextInput::make('meta.pretitle')
          ->label('Pretítulo')
          ->helperText(fn ($get) => $get('help')
            ? 'Texto que aparece antes del título, en letras más pequeñas, generalmente usado para categorizar o dar contexto'
            : null),
        Select::make('meta.pretitle_color')
          ->label('Color del Pretítulo')
          ->options([
            'primary'   => 'Primario',
            'secondary' => 'Secundario',
            'accent'    => 'Acento',
            'success'   => 'Éxito',
            'danger'    => 'Peligro',
            'warning'   => 'Advertencia',
            'info'      => 'Información',
          ])
          ->helperText(fn ($get) => $get('help')
            ? 'Color del texto del pretítulo, si no lo seleccionas se usará uno neutro por default. Puedes usar un color diferente para cada pretítulo para darle un toque de color a tu servicio'
            : null),
        TextInput::make('meta.price')
          ->label('Precio')
          ->helperText(fn ($get) => $get('help')
            ? 'Precio "desde" si no lo especificas, no se mostrará en la vista del servicio'
            : null)
          ->columnSpanFull(),
        Textarea::make('description')
          ->helperText(fn ($get) => $get('help')
            ? 'Describe qué incluye el servicio. Usa una línea por cada punto, intenta que sea un máximo de cinco puntos.'
            : null)
          ->rows(4)
          ->columnSpanFull(),
        FileUpload::make('image')
          ->helperText(fn ($get) => $get('help')
            ? 'Sube una imagen representativa del servicio, procura que sea clara, de buena calidad y no mayor a 500KB (se presentará en un tamaño pequeño)'
            : null)
          ->disk('public')
          ->directory('services')
          ->visibility('public')
          ->image(),
        Select::make('icon')
          ->label('Icono')
          ->options([
            'lucide-engine'               => 'Motor',
            'lucide-toolbox'              => 'Caja de herramientas',
            'lucide-wrench'               => 'Llave inglesa',
            'lucide-drill'                => 'Herramienta Pneumática',
            'lucide-paintbrush-vertical'  => 'Pintura',
            'lucide-sparkles'             => 'Brillo',
            'lucide-car-battery'          => 'Batería de coche',
            'lucide-car'                  => 'Coche',
            'lucide-zap'                  => 'Electricidad',
            'lucide-fuel'                 => 'Gasolina',
            'lucide-cylinder'             => 'Aceite',
          ])
          ->suffixIcon(fn (?string $state) => $state)
          ->live()
          ->helperText(fn ($get) => $get('help')
            ? 'Si lo deseas, selecciona un icono que represente el servicio, este se usará en la vista de "lista", si decides utilizarla, si no lo incluyes, se usará una imagen genérica de herramientas.'
            : null),
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('name')
      ->columns([
        TextColumn::make('title')
          ->label('Título')
          ->searchable(),
        TextColumn::make('description')
          ->label('Descripción')
          ->limit(50)
          ->tooltip(fn ($state) => $state),
        ImageColumn::make('image')
          ->label('Imagen'),
        TextColumn::make('icon')
          ->label('Icono'),
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
          ->label('Nuevo Servicio')
          ->icon('lucide-engine'),
      ])
      ->recordActions([
        EditAction::make(),
        DeleteAction::make()
          ->requiresConfirmation()
          ->modalHeading('Borrar un servicio')
          ->modalDescription('¿Estás seguro de que deseas borrar este servicio? Esta acción no se puede deshacer')
          ->modalSubmitActionLabel('Si, borrar')
          ->modalIcon('lucide-trash')
          ->modalIconColor('danger'),
      ])
      ->toolbarActions([
        // BulkActionGroup::make([
        // ]),
      ]);
  }
}

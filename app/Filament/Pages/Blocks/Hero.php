<?php

namespace App\Filament\Pages\Blocks;

use App\Models\Block;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Illuminate\Database\Eloquent\Builder;

class Hero extends Page
{
  protected static ?string $slug = 'blocks/hero';
  protected static ?string $title = 'Configurar Hero';
  protected static bool $shouldRegisterNavigation = false;
  public ?int $blockId = null;
  public ?array $data = [];

  public function mount(): void
  {
    $this->blockId = (int) request()->query('block');

    abort_if($this->blockId <= 0, 404);

    $this->form->fill(
      $this->getBlock()->params ?? []
    );
  }

  public function defaultForm(Schema $schema): Schema
  {
    return $schema->statePath('data');
  }

  public function form(Schema $schema): Schema
  {
    return $schema->components([
      Section::make('Contenido')
        ->columns(2)
        ->schema([
          TextInput::make('title')
            ->label('Título')
            ->maxLength(255)
            ->columnSpanFull(),

          TextInput::make('subtitle')
            ->label('Subtítulo')
            ->maxLength(255)
            ->columnSpanFull(),

          Textarea::make('description')
            ->label('Descripción')
            ->rows(4)
            ->columnSpanFull(),
        ]),

      Section::make('Imagen')
        ->columns(2)
        ->schema([
          FileUpload::make('background_image')
            ->label('Imagen de fondo')
            ->image()
            ->disk('public')
            ->directory('blocks/hero')
            ->visibility('public')
            ->columnSpanFull(),

          Select::make('image_position')
            ->label('Posición de imagen')
            ->options([
              'center' => 'Centro',
              'top' => 'Superior',
              'bottom' => 'Inferior',
              'left' => 'Izquierda',
              'right' => 'Derecha',
            ])
            ->default('center'),

          Toggle::make('overlay')
            ->label('Superposición oscura')
            ->default(false),
        ]),

      Section::make('Presentación')
        ->schema([
          Select::make('alignment')
            ->label('Alineación del contenido')
            ->options([
              'left' => 'Izquierda',
              'center' => 'Centro',
              'right' => 'Derecha',
            ])
            ->default('center'),
        ]),

      Section::make('Botón')
        ->columns(2)
        ->schema([
          TextInput::make('button_text')
            ->label('Texto del botón')
            ->maxLength(255),

          TextInput::make('button_url')
            ->label('URL del botón')
            ->maxLength(2048),

          Select::make('button_style')
            ->label('Estilo del botón')
            ->options([
              'primary' => 'Principal',
              'secondary' => 'Secundario',
              'outline' => 'Contorno',
              'link' => 'Enlace',
            ])
            ->default('primary')
            ->columnSpanFull(),
        ]),
    ]);
  }

  public function content(Schema $schema): Schema
  {
    return $schema->components([
      $this->getFormContentComponent(),
    ]);
  }

  protected function getFormContentComponent(): Component
  {
    return Form::make([
      EmbeddedSchema::make('form'),
    ])
      ->id('form')
      ->livewireSubmitHandler('save')
      ->footer([
        Actions::make([
          Action::make('save')
            ->label('Guardar configuración')
            ->icon('heroicon-o-check')
            ->submit('save'),
        ])
          ->alignment(Alignment::End)
          ->key('form-actions'),
      ]);
  }

  public function save(): void
  {
    $data = $this->form->getState();

    $block = $this->getBlock();

    $block->update([
      'params' => array_replace(
        $block->params ?? [],
        $data
      ),
    ]);

    Notification::make()
      ->title('Configuración guardada')
      ->success()
      ->send();
  }

  protected function getBlock(): Block
  {
    $tenant = Filament::getTenant();

    abort_unless($tenant, 404);

    return Block::query()
      ->whereKey($this->blockId)
      ->whereHas(
        'blockType',
        fn (Builder $query) => $query->where(
          'component',
          'blocks.hero'
        )
      )
      ->whereHas(
        'page.tenant',
        fn (Builder $query) => $query->whereKey(
          $tenant->getKey()
        )
      )
      ->firstOrFail();
  }
}

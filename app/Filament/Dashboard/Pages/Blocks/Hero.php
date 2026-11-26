<?php

namespace App\Filament\Dashboard\Pages\Blocks;

use App\Models\Block;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
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

    $block = $this->getBlock();
    logger()->debug('Loaded block', ['block' => $block]);

    $this->form->fill($block->meta ?? []);
  }

  protected function getBlock(): Block
  {
    // Verificar que el bloque corresponda al tenant y sea del tipo correcto
    $tenant = Filament::getTenant();
    abort_unless($tenant, 404);

    $block = Block::find($this->blockId);
    abort_unless($block && $block->blockType->slug === 'hero', 404);

    abort_unless($block->pages()->where('tenant_id', $tenant->id)->exists(), 404);

    return $block;
  }

  public function defaultForm(Schema $schema): Schema
  {
    return $schema->statePath('data');
  }

  public function form(Schema $schema): Schema
  {
    return $schema->components([
      Toggle::make('help')
        ->live()
        ->label('Mostrar ayuda')
        ->default(false),

      Section::make('Contenido')
        ->columns(2)
        ->schema([
          TextInput::make('title')
            ->label('Título')
            ->helperText(fn ($get) =>
              $get('help')
              ? 'El título principal son las palabras mas grandes que aparecerán en el bloque'
              : null
            )
            ->maxLength(255)
            ->columnSpanFull(),

          TextInput::make('subtitle')
            ->label('Subtítulo')
            ->helperText(fn ($get) =>
              $get('help')
              ? 'El subtítulo es un texto secundario que aparece debajo del título principal'
              : null
            )
            ->maxLength(255)
            ->columnSpanFull(),

          Textarea::make('description')
            ->label('Descripción')
            ->helperText(fn ($get) =>
              $get('help')
              ? 'La descripción proporciona información adicional al título, es un texto explicativo que se pone en una letra de menor tamaño'
              : null
            )
            ->rows(4)
            ->columnSpanFull(),

          Toggle::make('claro')
            ->label('Letras Claras')
            ->default(false)
            ->columnSpanFull()
            ->helperText(fn ($get) =>
              $get('help')
              ? 'Si tienes un fondo oscuro, activa esta opción para que el tema sea claro y sea visible'
              : null
            )
        ]),

      Section::make('Fondo')
        ->columns(4)
        ->schema([
          Grid::make()
            ->columns(1)
            ->schema([
              FileUpload::make('background_image')
                ->label('Imagen de fondo')
                ->helperText(fn ($get) =>
                  $get('help')
                  ? 'La imagen de fondo se mostrará detrás del contenido del bloque, deberá tener un tamaño máximo de 1MB. Ten en cuenta que la imagen se adapta al tamaño del bloque, prueba cómo se ve la imagen en diferentes dispositivos y haz los ajustes necesarios'
                  : null
                )
                ->image()
                ->disk('public')
                ->directory('blocks/hero')
                ->visibility('public'),
              Select::make('image_position')
                ->label('Posición de imagen')
                ->helperText(fn ($get) =>
                  $get('help')
                  ? 'Selecciona la posición de la imagen de fondo dentro del bloque'
                  : null
                )
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
                ->default(false)
                ->helperText(fn (callable $get) => $get('help') ? 'Activa esta opción para añadir una superposición oscura sobre la imagen de fondo. Si lo haces, recomendamos que utilices un texto claro para que sea claramente visible' : null),
            ])
            ->columnSpan(3),
          ColorPicker::make('background_color')
            ->label('Color de fondo')
            ->helperText(fn ($get) =>
              $get('help')
              ? 'Indica el color de fondo del bloque, se usa si no existe una imagen de fondo'
              : null
            ),
          ]),


      Section::make('Presentación')
        ->schema([
          Select::make('alignment')
            ->label('Alineación del contenido')
            ->helperText(fn ($get) =>
              $get('help')
              ? 'Selecciona la alineación del texto dentro del bloque'
              : null
            )
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
      'meta' => array_replace(
        $block->meta ?? [],
        $data
      ),
    ]);

    Notification::make()
      ->title('Configuración guardada')
      ->success()
      ->send();
  }
}

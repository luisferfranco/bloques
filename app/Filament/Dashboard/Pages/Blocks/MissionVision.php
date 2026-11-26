<?php

namespace App\Filament\Dashboard\Pages\Blocks;

use App\Models\Block;
use App\Models\BlockType;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Callout;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class MissionVision extends Page
{
  protected static ?string $slug = 'blocks/mission-vision';
  protected static ?string $title = 'Configurar Misión y Visión';
  protected static bool $shouldRegisterNavigation = false;

  public ?int $blockId = null;
  public ?array $data = [];

  public function mount(): void
  {
    $this->blockId = (int) request()->query('block');
    abort_if($this->blockId <= 0, 404);

    $block = $this->getBlock();

    $params = is_string($block->meta)
      ? (json_decode($block->meta, true) ?? [])
      : ($block->meta ?? []);

    // Hidrata el schema 'form' apuntando a $this->data
    $this->form->fill([
      'mission' => $params['mission'] ?? null,
      'vision'  => $params['vision'] ?? null,
    ]);
  }

  protected function getBlock(): Block
  {
    // Verificar que el bloque corresponda al tenant y sea del tipo correcto
    $tenant = Filament::getTenant();
    abort_unless($tenant, 404);

    $block = Block::find($this->blockId);
    abort_unless($block && $block->blockType->slug === 'mission-vision', 404);

    abort_unless($block->pages()->where('tenant_id', $tenant->id)->exists(), 404);

    return $block;
  }

  public function form(Schema $schema): Schema
  {
    return $schema
      ->statePath('data')
      ->columns(2)
      ->components([
        Callout::make('Misión y Visión')
          ->description('Escribe un par de renglones sobre la misión y visión de tu empresa')
          ->info()
          ->columnSpanFull(),
        Textarea::make('mission')
          ->label('Misión')
          ->rows(5),
        Textarea::make('vision')
          ->label('Visión')
          ->rows(5),
      ]);
  }

  public function content(Schema $schema): Schema
  {
    return $schema
      ->components([
        Form::make([
          EmbeddedSchema::make('form'),
        ])
          ->id('form')
          ->livewireSubmitHandler('save')
          ->footer([
            Actions::make([
              Action::make('save')
                ->label('Guardar')
                ->icon('heroicon-o-check')
                ->submit('save'),
            ]),
          ]),
      ]);
  }

  public function save(): void
  {
    $state = $this->form->getState();

    $block = Block::findOrFail($this->blockId);

    $currentParams = is_string($block->meta)
      ? (json_decode($block->meta, true) ?? [])
      : ($block->meta ?? []);

    // Conserva cualquier otra llave previa en params y actualiza mission y vision
    $block->update([
      'meta' => array_merge($currentParams, [
        'mission' => $state['mission'] ?? null,
        'vision'  => $state['vision'] ?? null,
      ]),
    ]);

    Notification::make()
      ->title('Guardado correctamente')
      ->success()
      ->send();
  }
}
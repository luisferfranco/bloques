<?php

namespace App\Filament\Dashboard\Pages;

use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use BackedEnum;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;

class Config extends Page implements HasSchemas
{
  use InteractsWithSchemas;

  protected static ?string $navigationLabel = 'Configuración';
  protected static ?string $title = 'Configuración';
  protected string $view = 'filament.dashboard.pages.config';
  protected static string|BackedEnum|null $navigationIcon = 'lucide-cog';

  public ?array $data = [];

  public function mount(): void
  {
    $tenant = Filament::getTenant();

    $this->form->fill([
      'typography' => [
        'preset' => data_get(
          $tenant->settings,
          'typography.preset',
          config('theme-fonts.default'),
        ),
      ],
    ]);
  }

  public function form(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('Tipografía')
          ->description('Selecciona la combinación tipográfica de tu sitio.')
          ->schema([
            Select::make('typography.preset')
              ->label('Combinación tipográfica')
              ->options(
                collect(config('theme-fonts.presets'))
                  ->mapWithKeys(fn (array $preset, string $key) => [
                    $key => $preset['name'],
                  ])
                  ->all()
              )
              ->required(),
          ]),
      ])
      ->statePath('data');
  }

  public function save(): void
  {
    $data = $this->form->getState();

    $tenant = Filament::getTenant();
    $settings = $tenant->settings ?? [];

    $settings['typography']['preset'] = $data['typography']['preset'];

    $tenant->update([
      'meta' => $settings,
    ]);

    Notification::make()
      ->title('Configuración guardada')
      ->success()
      ->send();
  }
}

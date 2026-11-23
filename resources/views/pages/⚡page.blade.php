<?php

use App\Models\Page;
use App\Models\Tenant;
use App\Models\ThemeVersion;
use App\Support\CurrentTenant;
use Livewire\Component;

new class extends Component
{
  public Tenant $tenant;
  public Page $page;
  public ThemeVersion $themeVersion;
  public $blocks;
  public array $themeTokens = [];
  public $googleFontsUrl = '';

  public function mount(Tenant $tenant, ?string $page = null):void
  {
    $this->tenant = $tenant->load('themeVersion');
    app(CurrentTenant::class)->set($this->tenant);

    $this->themeVersion = $this->tenant->themeVersion
      ?? abort(404, 'El tenant no tiene un tema asignado');

    $this->themeTokens = $this->tenant->themeVersion->tokens ?? [];
    $this->resolveThemeFonts();

    $this->page = $page
      ? $tenant->pages()
        ->where('slug', $page)
        ->where('is_active', true)
        ->firstOrFail()
      : $tenant->pages()
        ->where('is_active', true)
        ->firstOrFail();

    $this->blocks = $this->page->blocks()
      ->where('is_active', true)
      ->with('blockType')
      ->orderBy('sort_order')
      ->get();
  }

  public function hydrate(): void
  {
    app(CurrentTenant::class)->set($this->tenant);
  }

  private function resolveThemeFonts(): void
  {
    $this->googleFontsUrl = null;

    $defaultPreset = config('theme-fonts.default', 'inter');
    $presetId = $this->tenant->settings['typography']['preset'] ?? $defaultPreset;

    logger()->info('Preset ID: ' . $presetId);

    $preset = config("theme-fonts.presets.{$presetId}")
      ?? config("theme-fonts.presets.{$defaultPreset}");

    if (! $preset) {
      return;
    }

    $fontCategories = [
      'heading' => 'display',
      'body' => 'text',
      'mono' => 'mono',
    ];

    $families = [];

    foreach ($fontCategories as $key => $category) {
      $fontId = $preset[$key] ?? null;

      if (! $fontId) {
        continue;
      }

      $font = config("theme-fonts.{$category}.{$fontId}");

      if (! $font) {
        continue;
      }

      $families[$font['family']] = $font;

      $this->themeTokens["font-{$key}"] = sprintf(
        '"%s", %s',
        $font['family'],
        $category === 'mono' ? 'monospace' : 'sans-serif',
      );
    }

    $queries = [];

    foreach ($families as $font) {
      $weights = implode(';', $font['weights']);

      $queries[] = 'family='
        . rawurlencode($font['family'])
        . ':wght@'
        . $weights;
    }

    if ($queries !== []) {
      $this->googleFontsUrl = 'https://fonts.googleapis.com/css2?'
        . implode('&', $queries)
        . '&display=swap';
    }
  }

};
?>

<div
  style="{{ collect($themeTokens)
    ->map(fn ($value, $key) => "--{$key}: {$value}")
    ->implode('; ') }}"
  >
  @foreach ($this->blocks as $block)
    <livewire:dynamic-component
      :is="$block->blockType->component"
      :block="$block"
      :wire:key="'block-'.$block->id"
    />
  @endforeach
</div>

@assets
  @if ($googleFontsUrl !== '')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ $googleFontsUrl }}">
  @endif
@endassets
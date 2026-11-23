<?php

use App\Models\Page;
use App\Models\Tenant;
use App\Models\ThemeVersion;
use Livewire\Component;

new class extends Component
{
  public Tenant $tenant;
  public Page $page;
  public ThemeVersion $themeVersion;
  public $blocks;
  public array $themeTokens = [];
  public string $googleFontsUrl = '';

  public function mount(Tenant $tenant, ?string $page = null):void
  {
    $this->tenant = $tenant->load('themeVersion');
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

  private function resolveThemeFonts(): void
  {
    $fontCategories = [
      'heading' => 'display',
      'body' => 'text',
      'mono' => 'mono',
    ];

    $families = [];
    $typography = $this->tenant->settings['typography'] ?? [];

    foreach ($fontCategories as $key => $category) {
      $fontId = $typography[$key] ?? null;

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
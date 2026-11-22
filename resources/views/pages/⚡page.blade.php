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

  public function mount(Tenant $tenant, ?string $page = null):void
  {
    $this->tenant = $tenant->load('themeVersion');
    $this->themeVersion = $this->tenant->themeVersion
      ?? abort(404, 'El tenant no tiene un tema asignado');

    $this->themeTokens = $this->tenant->themeVersion->tokens ?? [];

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
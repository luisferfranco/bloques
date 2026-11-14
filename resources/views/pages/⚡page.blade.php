<?php

use Livewire\Component;
use App\Models\Tenant;
use App\Models\Page;

new class extends Component
{
  public Tenant $tenant;
  public Page $page;
  public $blocks;

  public function mount(Tenant $tenant, ?string $page = null):void
  {
    $this->tenant = $tenant;
    $this->page = $page
      ? $tenant->pages()
        ->where('slug', $page)
        ->where('is_active', true)
        ->firstOrFail()
      : $tenant->pages()
        ->where('is_active', true)
        ->firstOrFail();

    logger()->debug('Page loaded', ['page' => $this->page]);

    $this->blocks = $this->page->blocks()
      ->where('is_active', true)
      ->with('BlockType')
      ->orderBy('sort_order')
      ->get();

    logger()->debug('Blocks loaded', ['blocks' => $this->blocks]);
  }
};
?>

<div>
  @foreach ($this->blocks as $block)
    <livewire:dynamic-component
      :is="$block->blockType->component"
      :block="$block"
      :wire:key="'block-'.$block->id"
    />
  @endforeach
</div>
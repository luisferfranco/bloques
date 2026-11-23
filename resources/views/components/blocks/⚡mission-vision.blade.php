<?php

use Livewire\Component;
use App\Models\Block;

new class extends Component
{
  public $params;

  public function mount(Block $block): void
  {
    $this->params = (object) ($block->params ?? []);
  }
};
?>

<section
  class="mx-auto grid w-full max-w-[var(--container-width)] grid-cols-1 md:grid-cols-2 gap-6 py-8 px-4 md:px-8 text-(--foreground)"
  style="font-family: var(--font-body)"
  >

  <article
    class="rounded-[var(--radius-md)] border border-[var(--border)] bg-[var(--background)] p-6 shadow-sm"
    >

    <h2 class="text-2xl font-bold text-[var(--primary)] mb-4"
      style="font-family: var(--font-heading)"
      >
      Misión
    </h2>

    <p class="leading-relaxed">
      {{ $params->mission ?? '' }}
    </p>
  </article>

  <article
    class="rounded-[var(--radius-md)] border border-[var(--border)] bg-[var(--background)] p-6 shadow-sm"
    >

    <h2 class="text-2xl font-bold text-[var(--primary)] mb-4"
      style="font-family: var(--font-heading)"
      >
      Visión
    </h2>

    <p class="leading-relaxed">
      {{ $params->vision ?? '' }}
    </p>
  </article>
</section>

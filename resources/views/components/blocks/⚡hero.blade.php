
<?php

use App\Models\Block;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

new class extends Component
{
  public $meta;

  public function mount(Block $block): void
  {
    $this->meta = (object) ($block->meta ?? []);
  }
};
?>

<section
  class="relative flex items-center w-full px-6 py-12 overflow-hidden isolate min-h-162"
  style="background-color: {{ $meta->background_color ?? 'var(--background)' }}; color: {{ isset($meta->claro) ? '#eeeeee' : 'var(--foreground)' }}; font-family: var(--font-body);"
  >
  {{-- Imagen de fondo --}}
  @if ($meta->background_image ?? false)
    <img
      src="{{ Storage::disk('public')->url($meta->background_image) }}"
      alt=""
      class="absolute inset-0 object-cover w-full h-full -z-10"
      style="object-position: {{ $meta->image_position ?? 'center' }};"
    >
  @endif

  {{-- Superposición oscura --}}
  @if ($meta->overlay ?? false)
    <div class="absolute inset-0 -z-0 bg-black/50"></div>
  @endif

  {{-- Contenido --}}
  <div
    @class([
      'relative z-10 mx-auto w-full max-w-6xl',
      'text-left' => ($meta->alignment ?? 'center') === 'left',
      'text-center' => ($meta->alignment ?? 'center') === 'center',
      'text-right' => ($meta->alignment ?? 'center') === 'right',
    ])
  >
    @if ($meta->subtitle ?? false)
      <p class="mb-3 text-lg font-medium tracking-wide">
        {{ $meta->subtitle }}
      </p>
    @endif

    @if ($meta->title ?? false)
      <h1
        style="font-family: var(--font-heading)"
        class="text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl"
        >
        {{ $meta->title }}
      </h1>
    @endif

    @if ($meta->description ?? false)
      <p class="max-w-3xl mx-auto mt-5 text-base leading-relaxed sm:text-lg">
        {{ $meta->description }}
      </p>
    @endif

    @if (($meta->button_text ?? false) && ($meta->button_url ?? false))
      <div
        @class([
          'mt-8 flex',
          'justify-start' => ($meta->alignment ?? 'center') === 'left',
          'justify-center' => ($meta->alignment ?? 'center') === 'center',
          'justify-end' => ($meta->alignment ?? 'center') === 'right',
        ])
        >
        <x-ui.button
          href="{{ $meta->button_url }}"
          :variant="$meta->button_style ?? 'primary'"
          size="lg"
          :label="$meta->button_text"
          />
      </div>
    @endif
  </div>
</section>
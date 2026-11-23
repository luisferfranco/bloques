
<?php

use App\Models\Block;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

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
  class="relative flex items-center w-full px-6 py-12 overflow-hidden isolate min-h-162"
  style="background-color: var(--background); color: var(--foreground); font-family: var(--font-body);"
>
  {{-- Imagen de fondo --}}
  @if ($params->background_image ?? false)
    <img
      src="{{ Storage::disk('public')->url($params->background_image) }}"
      alt=""
      class="absolute inset-0 object-cover w-full h-full -z-10"
      style="object-position: {{ $params->image_position ?? 'center' }};"
    >
  @endif

  {{-- Superposición oscura --}}
  @if ($params->overlay ?? false)
    <div class="absolute inset-0 -z-0 bg-black/50"></div>
  @endif

  {{-- Contenido --}}
  <div
    @class([
      'relative z-10 mx-auto w-full max-w-6xl',
      'text-left' => ($params->alignment ?? 'center') === 'left',
      'text-center' => ($params->alignment ?? 'center') === 'center',
      'text-right' => ($params->alignment ?? 'center') === 'right',
    ])
  >
    @if ($params->subtitle ?? false)
      <p class="mb-3 text-lg font-medium tracking-wide">
        {{ $params->subtitle }}
      </p>
    @endif

    @if ($params->title ?? false)
      <h1
        style="font-family: var(--font-heading)"
        class="text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl"
        >
        {{ $params->title }}
      </h1>
    @endif

    @if ($params->description ?? false)
      <p class="max-w-3xl mx-auto mt-5 text-base leading-relaxed sm:text-lg">
        {{ $params->description }}
      </p>
    @endif

    @if (($params->button_text ?? false) && ($params->button_url ?? false))
      <div
        @class([
          'mt-8 flex',
          'justify-start' => ($params->alignment ?? 'center') === 'left',
          'justify-center' => ($params->alignment ?? 'center') === 'center',
          'justify-end' => ($params->alignment ?? 'center') === 'right',
        ])
      >
        <a
          href="{{ $params->button_url }}"
          @class([
            'inline-flex items-center px-6 py-3 font-semibold transition',
            'hover:opacity-90' => in_array(
              $params->button_style ?? 'primary',
              ['primary', 'secondary']
            ),
            'underline underline-offset-4 hover:opacity-80' =>
              ($params->button_style ?? 'primary') === 'link',
          ])
          @style([
            'background-color: var(--primary); color: var(--primary-foreground); border-radius: var(--button-radius);' =>
              ($params->button_style ?? 'primary') === 'primary',
            'background-color: var(--secondary); color: var(--secondary-foreground); border-radius: var(--button-radius);' =>
              ($params->button_style ?? 'primary') === 'secondary',
            'background-color: transparent; color: var(--primary); border: 2px solid var(--primary); border-radius: var(--button-radius);' =>
              ($params->button_style ?? 'primary') === 'outline',
            'background-color: transparent; color: var(--primary);' =>
              ($params->button_style ?? 'primary') === 'link',
          ])
        >
          {{ $params->button_text }}
        </a>
      </div>
    @endif
  </div>
</section>
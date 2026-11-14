
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

<section class="relative isolate flex min-h-56 w-full items-center overflow-hidden bg-indigo-600 px-6 py-12 text-white">

  {{-- Imagen de fondo --}}
  @if ($params->background_image ?? false)
    <img
      src="{{ Storage::disk('public')->url($params->background_image) }}"
      alt=""
      class="absolute inset-0 -z-10 h-full w-full object-cover"
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
      <h1 class="text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
        {{ $params->title }}
      </h1>
    @endif

    @if ($params->description ?? false)
      <p class="mx-auto mt-5 max-w-3xl text-base leading-relaxed sm:text-lg">
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
            'inline-flex items-center rounded-lg px-6 py-3 font-semibold transition',
            'bg-white text-indigo-700 hover:bg-gray-100' => ($params->button_style ?? 'primary') === 'primary',
            'bg-gray-900 text-white hover:bg-gray-800' => ($params->button_style ?? 'primary') === 'secondary',
            'border-2 border-white text-white hover:bg-white hover:text-indigo-700' => ($params->button_style ?? 'primary') === 'outline',
            'text-white underline underline-offset-4 hover:text-gray-200' => ($params->button_style ?? 'primary') === 'link',
          ])
        >
          {{ $params->button_text }}
        </a>
      </div>
    @endif
  </div>


</section>
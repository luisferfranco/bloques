
<?php

use App\Models\Service;
use App\Support\CurrentTenant;
use Livewire\Component;

new class extends Component
{
  public $services;

  public function mount(): void
  {
    $tenant = $request->route('tenant');

    app(CurrentTenant::class)->set($tenant);
    $this->services = Service::query()->get();
  }
};
?>

<div
  class="mx-auto grid w-full max-w-[var(--container-width)] grid-cols-1 gap-6 px-6 py-8 sm:grid-cols-2 lg:grid-cols-3"
  style="font-family: var(--font-body);"
  >

  @forelse ($services as $service)
    <article
      class="group flex flex-col overflow-hidden border shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg"
      style="
        background: var(--card-background, var(--background));
        color: var(--foreground);
        border-color: color-mix(in srgb, var(--foreground) 12%, transparent);
        border-radius: var(--card-radius, 0.75rem);
      "
    >

      {{-- Imagen --}}
      @if ($service->image_url)
        <div class="aspect-[16/10] overflow-hidden">
          <img
            src="{{ $service->image_url }}"
            alt="{{ $service->name }}"
            class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
          >
        </div>
      @else
        <div
          class="flex aspect-[16/10] items-center justify-center"
          style="background: color-mix(in srgb, var(--foreground) 5%, var(--background));"
        >
          <svg
            class="h-12 w-12"
            style="color: color-mix(in srgb, var(--foreground) 30%, transparent);"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="1.5"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M3 7.5A2.5 2.5 0 0 1 5.5 5h13A2.5 2.5 0 0 1 21 7.5v9a2.5 2.5 0 0 1-2.5 2.5h-13A2.5 2.5 0 0 1 3 16.5v-9Z"
            />
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="m3.5 16 5-5 4 4 3-3 5 5"
            />
          </svg>
        </div>
      @endif

      {{-- Contenido --}}
      <div class="flex flex-1 flex-col p-6">

        {{-- Estado --}}
        <div class="mb-3">
          <span
            class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium"
            style="
              background: {{ $service->is_active
                ? 'color-mix(in srgb, var(--primary) 12%, var(--background))'
                : 'color-mix(in srgb, var(--foreground) 7%, var(--background))' }};
              color: {{ $service->is_active
                ? 'var(--primary)'
                : 'color-mix(in srgb, var(--foreground) 55%, transparent)' }};
            "
          >
            {{ $service->is_active ? 'Disponible' : 'No disponible' }}
          </span>
        </div>

        {{-- Nombre --}}
        <h3
          class="text-lg font-semibold"
          style="font-family: var(--font-heading);"
        >
          {{ $service->name }}
        </h3>

        {{-- Descripción --}}
        <p
          class="mt-2 flex-1 text-sm leading-relaxed"
          style="
            font-family: var(--font-body);
            color: color-mix(in srgb, var(--foreground) 65%, transparent);
          "
        >
          {{ $service->description }}
        </p>

        {{-- Precio --}}
        <div
          class="mt-5 border-t pt-4"
          style="border-color: color-mix(in srgb, var(--foreground) 12%, transparent);"
        >
          <span
            class="text-xs font-medium uppercase tracking-wide"
            style="color: color-mix(in srgb, var(--foreground) 50%, transparent);"
          >
            Precio
          </span>

          <p class="mt-1 text-2xl font-bold">
            ${{ number_format($service->price, 2) }}
          </p>
        </div>

      </div>
    </article>

  @empty
    <div
      class="col-span-full rounded-xl border p-8 text-center"
      style="
        background: var(--card-background, var(--background));
        color: var(--foreground);
        border-color: var(--border);
      "
    >
      <p class="text-base font-medium">
        No hay servicios disponibles
      </p>

      <p
        class="mt-2 text-sm"
        style="color: color-mix(in srgb, var(--foreground) 60%, transparent);"
      >
        Próximamente encontrarás aquí nuestros servicios.
      </p>
    </div>
  @endforelse

</div>

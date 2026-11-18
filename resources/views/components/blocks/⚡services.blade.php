<?php

use App\Models\Service;
use Livewire\Component;

new class extends Component
{
  public $services;

  public function mount(): void {
    $this->services = Service::all();
  }
};
?>


<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 py-8 px-16">

    @foreach ($services as $service)
        <article class="group flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

            {{-- Imagen --}}
            @if ($service->image_url)
                <div class="aspect-[16/10] overflow-hidden bg-gray-100">
                    <img
                        src="{{ $service->image_url }}"
                        alt="{{ $service->name }}"
                        class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                    >
                </div>
            @else
                <div class="flex aspect-[16/10] items-center justify-center bg-gray-100">
                    <svg
                        class="h-12 w-12 text-gray-300"
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
            <div class="flex flex-1 flex-col p-5">

                {{-- Estado --}}
                <div class="mb-3">
                    <span @class([
                        'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium',
                        'bg-green-50 text-green-700' => $service->is_active,
                        'bg-gray-100 text-gray-500' => !$service->is_active,
                    ])>
                        {{ $service->is_active ? 'Disponible' : 'No disponible' }}
                    </span>
                </div>

                {{-- Nombre --}}
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ $service->name }}
                </h3>

                {{-- Descripción --}}
                <p class="mt-2 flex-1 text-sm leading-relaxed text-gray-500">
                    {{ $service->description }}
                </p>

                {{-- Precio --}}
                <div class="mt-5 border-t border-gray-100 pt-4">
                    <span class="text-xs font-medium uppercase tracking-wide text-gray-400">
                        Precio
                    </span>

                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        ${{ number_format($service->price, 2) }}
                    </p>
                </div>

            </div>
        </article>
    @endforeach

</div>

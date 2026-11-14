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

<div class="grid grid-cols-2 gap-4 bg-indigo-400 py-4 px-8 min-h-56">

  <div class="bg-gray-200 rounded-xl shadow-xl text-black w-full h-full py-4 px-8">

    <h1 class="font-bold text-red-800 text-2xl">
      Misión
    </h1>
    <p>{{ $params->mission ?? null }}</p>
  </div>

  <div class="bg-gray-200 rounded-xl shadow-xl text-black w-full h-full py-4 px-8">

    <h1 class="font-bold text-red-800 text-2xl">
      Visión
    </h1>
    <p>{{ $params->vision ?? null }}</p>
  </div>

</div>
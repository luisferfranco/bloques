<?php

namespace App\Filament\Dashboard\Resources\Services\Pages;

use App\Filament\Dashboard\Resources\Services\ServiceResource;
use App\Models\BlockType;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
  protected static string $resource = ServiceResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['block_type_id'] = BlockType::query()
      ->where('slug', 'services')
      ->firstOrFail()
      ->id;

    return $data;
  }
}

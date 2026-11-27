<?php

namespace App\Filament\Dashboard\Resources\Services\Pages;

use App\Filament\Dashboard\Resources\Services\ServiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
  protected static string $resource = ServiceResource::class;
}

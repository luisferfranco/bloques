<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Guarded;

#[Guarded([])]
class PageType extends Model
{
  public function casts(): array
  {
    return [
      'is_active' => 'boolean',
    ];
  }
}

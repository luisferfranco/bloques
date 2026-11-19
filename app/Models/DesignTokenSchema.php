<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Guarded([])]
class DesignTokenSchema extends Model
{
  public function casts(): array
  {
    return [
      'is_active' => 'boolean',
      'published_at' => 'datetime',
      'definition' => 'array',
    ];
  }
}

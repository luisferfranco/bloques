<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Guarded([])]
class BlockItem extends Model
{
  public function casts(): array {
    return [
      'meta'        => 'array',
      'is_active'   => 'boolean',
    ];
  }

  public function block(): BelongsTo {
    return $this->belongsTo(Block::class);
  }
}

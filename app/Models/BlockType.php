<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use App\Models\Block;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Guarded([])]
class BlockType extends Model
{
  public function casts(): array {
    return [
      'is_active' => 'boolean',
      'is_premium' => 'boolean',
    ];
  }
  public function blocks(): HasMany
  {
    return $this->hasMany(Block::class);
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Page;
use App\Models\BlockType;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Guarded;

#[Guarded([])]
class Block extends Model
{
  public function casts(): array
  {
    return [
      'params' => 'array',
      'is_active' => 'boolean',
      'sort_order' => 'integer',
    ];
  }

  public function page(): BelongsTo
  {
    return $this->belongsTo(Page::class);
  }
  public function blockType(): BelongsTo
  {
    return $this->belongsTo(BlockType::class);
  }
}

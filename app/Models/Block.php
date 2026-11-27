<?php

namespace App\Models;

use App\Models\BlockItem;
use App\Models\BlockType;
use App\Models\Page;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Guarded([])]
class Block extends Model
{
  public function casts(): array
  {
    return [
      'meta'        => 'array',
      'is_active'   => 'boolean',
    ];
  }

  public function blockType(): BelongsTo {
    return $this->belongsTo(BlockType::class);
  }
  public function pages(): BelongsToMany {
    return $this->belongsToMany(Page::class)
      ->withPivot(['sort_order', 'meta', 'display_mode'])
      ->withTimestamps();
  }
  public function blockItems(): HasMany {
    return $this->hasMany(BlockItem::class);
  }
  public function tenant(): BelongsTo {
    return $this->belongsTo(Tenant::class);
  }
}

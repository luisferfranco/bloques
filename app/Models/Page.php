<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Guarded([])]
class Page extends Model
{
  public function casts(): array {
    return [
      'is_active' => 'boolean',
      'is_system' => 'boolean',
    ];
  }
  public function tenant(): BelongsTo {
    return $this->belongsTo(Tenant::class);
  }
  public function blocks(): BelongsToMany {
    return $this->belongsToMany(Block::class);
  }
}

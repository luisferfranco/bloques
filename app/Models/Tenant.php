<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Guarded([])]
class Tenant extends Model
{
  public function casts(): array
  {
    return [
      'is_active' => 'boolean',
      'meta'      => 'array',
    ];
  }

  public function users(): BelongsToMany
  {
    return $this->belongsToMany(User::class)
      ->withPivot('is_owner')
      ->withTimestamps();
  }
  public function pages(): HasMany {
    return $this->hasMany(Page::class);
  }
  public function themeVersion(): BelongsTo {
    return $this->belongsTo(ThemeVersion::class);
  }
}

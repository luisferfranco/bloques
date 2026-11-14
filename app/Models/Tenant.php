<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Guarded([])]
class Tenant extends Model
{
  public function casts(): array
  {
    return [
      'is_active' => 'boolean',
    ];
  }

  public function users(): BelongsToMany {
    return $this->belongsToMany(User::class)
      ->withTimestamps();
  }
  public function pages(): HasMany {
    return $this->hasMany(Page::class);
  }
  public function services(): HasMany {
    return $this->hasMany(Service::class);
  }
}

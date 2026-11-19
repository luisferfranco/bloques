<?php

namespace App\Models;

use App\Models\Theme;
use App\Models\DesignTokenSchema;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Guarded([])]
class ThemeVersion extends Model
{
  public function casts(): array
  {
    return [
      'tokens' => 'array',
      'published_at' => 'datetime',
      'is_published' => 'boolean',
    ];
  }

  public function theme(): BelongsTo
  {
    return $this->belongsTo(Theme::class);
  }
  public function designTokenSchema(): BelongsTo
  {
    return $this->belongsTo(DesignTokenSchema::class);
  }
  public function tenant(): HasMany
  {
    return $this->hasMany(Tenant::class);
  }
}

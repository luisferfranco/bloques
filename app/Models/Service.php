<?php

namespace App\Models;
use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Guarded([])]
class Service extends Model
{
  protected $casts = [
    'is_active' => 'boolean',
  ];

  protected static function booted(): void {
    static::addGlobalScope(new TenantScope());
  }

  public function tenant(): BelongsTo
  {
    return $this->belongsTo(Tenant::class);
  }
}

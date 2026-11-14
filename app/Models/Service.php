<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

#[Guarded([])]
class Service extends Model
{
  protected $casts = [
    'is_active' => 'boolean',
  ];

  public function tenant(): BelongsTo
  {
    return $this->belongsTo(Tenant::class);
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Guarded([])]
class Theme extends Model
{
  public function casts(): array
  {
    return [
      'is_active' => 'boolean',
      'is_premium' => 'boolean',
    ];
  }
  public function versions() {
    return $this->hasMany(ThemeVersion::class);
  }
}

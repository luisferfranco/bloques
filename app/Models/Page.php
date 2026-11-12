<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Guarded([])]
class Page extends Model
{
  public function pageType(): BelongsTo {
    return $this->belongsTo(PageType::class);
  }

  public function tenant(): BelongsTo {
    return $this->belongsTo(Tenant::class);
  }
}

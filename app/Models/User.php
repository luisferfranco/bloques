<?php

namespace App\Models;

use App\Models\Tenant;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, HasTenants
{
  /** @use HasFactory<UserFactory> */
  use HasFactory, Notifiable, HasRoles;

  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function tenants(): BelongsToMany
  {
    return $this->belongsToMany(Tenant::class)
      ->withPivot('is_owner')
      ->withTimestamps();
  }

  public function getTenants(Panel $panel): Collection
  {
    return $this->tenants()
      ->where('tenants.is_active', true)
      ->get();
  }

  public function canAccessTenant(Model $tenant): bool
  {
    return $tenant instanceof Tenant
      && $tenant->is_active
      && $this->tenants()
        ->whereKey($tenant)
        ->exists();
  }

  public function canAccessPanel(Panel $panel): bool
  {
    return match ($panel->getId()) {
      'admin' => $this->hasRole('SUPER_ADMIN'),
      'dashboard' => $this->hasRole(['SUPER_ADMIN', 'OWNER']),
      default => false,
    };
  }
}

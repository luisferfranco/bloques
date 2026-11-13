<?php

namespace App\Models;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Tenant;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, HasTenants
{
  /** @use HasFactory<UserFactory> */
  use HasFactory, Notifiable;

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function tenants(): BelongsToMany {
    return $this->belongsToMany(Tenant::class)
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
    return true; // Sustituir por tus reglas de acceso.
  }
}

<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\Theme;
use App\Models\ThemeVersion;
use Illuminate\Database\Seeder;

class TenantThemeSeeder extends Seeder
{
  public function run(): void
  {
    $theme = Theme::where('slug', 'default')->firstOrFail();

    $themeVersion = ThemeVersion::where('theme_id', $theme->id)
      ->where('version', '1.0.0')
      ->firstOrFail();

    Tenant::whereNull('theme_version_id')
      ->update([
        'theme_version_id' => $themeVersion->id,
      ]);
  }
}

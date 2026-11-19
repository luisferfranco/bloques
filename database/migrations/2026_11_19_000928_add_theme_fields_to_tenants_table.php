<?php

use App\Models\ThemeVersion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('tenants', function (Blueprint $table) {
      $table->foreignIdFor(ThemeVersion::class)
        ->nullable()
        ->constrained()
        ->restrictOnDelete();
      $table->string('logo')->nullable();
      $table->string('favicon')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('tenants', function (Blueprint $table) {
      $table->dropForeignIdFor(ThemeVersion::class);
      $table->dropColumn('logo');
      $table->dropColumn('favicon');
    });
  }
};

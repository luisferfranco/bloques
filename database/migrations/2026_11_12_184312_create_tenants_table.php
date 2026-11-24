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
    Schema::create('tenants', function (Blueprint $table) {
      $table->id();

      $table->string('name');
      $table->string('slug')->unique();
      $table->foreignIdFor(ThemeVersion::class)
        ->nullable()
        ->constrained()
        ->restrictOnDelete();
      $table->string('logo')->nullable();
      $table->string('favicon')->nullable();
      $table->json('meta')->nullable();
      $table->boolean('is_active')->default(true);

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tenants');
  }
};

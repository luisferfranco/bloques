<?php

use App\Models\DesignTokenSchema;
use App\Models\Theme;
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
    Schema::create('theme_versions', function (Blueprint $table) {
      $table->id();

      $table->foreignIdFor(Theme::class)
        ->constrained()
        ->cascadeOnDelete();
      $table->foreignIdFor(DesignTokenSchema::class)
        ->constrained()
        ->cascadeOnDelete();
      $table->string('version');
      $table->json('tokens');
      $table->boolean('is_published')->default(false);
      $table->datetime('published_at')->nullable();

      $table->timestamps();

      $table->unique(['theme_id', 'version']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('theme_versions');
  }
};

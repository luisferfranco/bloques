<?php

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
    Schema::create('design_token_schemas', function (Blueprint $table) {
      $table->id();

      $table->string('name');
      $table->string('version');
      $table->json('definition');
      $table->boolean('is_active')->default(true);
      $table->datetime('published_at')->nullable();

      $table->timestamps();

      $table->unique(['name', 'version']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('design_token_schemas');
  }
};

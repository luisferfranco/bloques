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
    Schema::create('pages', function (Blueprint $table) {
      $table->id();

      $table->foreignIdFor(\App\Models\PageType::class)->constrained()->onDelete('cascade');
      $table->foreignIdFor(\App\Models\Tenant::class)->constrained()->onDelete('cascade');
      $table->string('name');
      $table->string('slug');
      $table->text('description')->nullable();
      $table->boolean('is_active')->default(true);
      $table->boolean('is_system')->default(true);
      $table->integer('sort_order')->default(0);

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pages');
  }
};

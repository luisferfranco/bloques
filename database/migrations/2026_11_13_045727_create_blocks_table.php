<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Page;
use App\Models\BlockType;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('blocks', function (Blueprint $table) {
      $table->id();

      $table->foreignIdFor(Page::class)
        ->constrained()
        ->onDelete('cascade');
      $table->foreignIdFor(BlockType::class)
        ->constrained()
        ->onDelete('cascade');
      $table->string('name');
      $table->text('description')->nullable();
      $table->json('params')->nullable();
      $table->boolean('is_active')->default(true);
      $table->integer('sort_order')->default(0);

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('blocks');
  }
};

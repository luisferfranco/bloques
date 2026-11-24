<?php

use App\Models\Block;
use App\Models\Page;
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
    Schema::create('block_page', function (Blueprint $table) {
      $table->id();

      $table->foreignIdFor(Block::class)
        ->constrained()
        ->onDelete('cascade');
      $table->foreignIdFor(Page::class)
        ->constrained()
        ->onDelete('cascade');
      $table->integer('sort_order')->default(0);
      $table->json('meta')->nullable();
      $table->enum('display_mode', ['grid', 'list', 'carousel'])
        ->nullable();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('block_page');
  }
};

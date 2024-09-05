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
    Schema::create('beat_feedback', function (Blueprint $table) {
      $table->id();
      $table->foreignId('beat_id');
      $table->foreignId('staff_id');
      $table->text('feedback');
      $table->timestamps();
      $table->foreign('staff_id')->references('id')->on('staff');
      $table->foreign('beat_id')->references('id')->on('beats');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('beat_feedback');
  }
};

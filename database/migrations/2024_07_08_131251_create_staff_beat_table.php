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
    Schema::create('staff_beat_history', function (Blueprint $table) {
      $table->id();
      $table->foreignId('staff_id');
      $table->foreignId('shift_id');
      $table->foreignId('beat_id');
      $table->foreignId('beat_branch_id');
      $table->text('comment');
      $table->timestamps();
      $table->foreign('staff_id')->references('id')->on('staff');
      $table->foreign('shift_id')->references('id')->on('shifts');
      $table->foreign('beat_id')->references('id')->on('beats');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('staff_beat');
  }
};

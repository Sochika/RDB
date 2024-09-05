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
    Schema::create('shift_history', function (Blueprint $table) {
      $table->id();
      $table->foreignId('staff_id');
      $table->foreignId('shift_id');
      $table->foreignId('beat_id');
      $table->date('start_date');
      $table->time('shift_start');
      $table->time('shift_end');
      $table->foreignId('shift_type_id')->nullable();
      $table->text('comment');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('shift_history');
  }
};

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
    Schema::create('seat_rep', function (Blueprint $table) {
      $table->id();
      $table->foreignId('staff_id');
      $table->foreignId('beat_id')->nullable();
      $table->foreignId('supervisor_id')->nullable();
      $table->integer('rate');
      $table->text('comment');
      $table->timestamps();
      $table->foreign('staff_id')->references('id')->on('staff');
      $table->foreign('beat_id')->references('id')->on('beats');
      $table->foreign('supervisor_id')->references('id')->on('staff');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('seat_rep');
  }
};

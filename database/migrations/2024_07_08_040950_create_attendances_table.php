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
    Schema::create('attendances', function (Blueprint $table) {
      $table->id();
      $table->foreignId('staff_id');
      $table->date('attendance_date');
      $table->time('clock_in_time')->nullable();
      $table->time('clock_out_time')->nullable();
      $table->text('comment')->nullable();
      $table->enum('status', ['on_time', 'late', 'early', 'absent'])->default('on_time');
      $table->integer('minutes_of_lateness')->nullable();
      $table->timestamps();

      $table->foreign('staff_id')->references('id')->on('staff');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('attendances');
  }
};

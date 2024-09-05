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
    Schema::create('shifts', function (Blueprint $table) {
      $table->id();
      // $table->foreignId('staff_id')->constrained()->onDelete('cascade');
      // $table->foreignId('beat_id')->constrained()->onDelete('cascade');
      // $table->foreignId('beat_branches_id')->constrained()->onDelete('cascade');
      $table->date('start_date');
      $table->time('shift_start');
      $table->time('shift_end');
      $table->string('shift_on');
      $table->foreignId('shift_type_id')->nullable();
      // $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
      $table->timestamps();
      $table->foreign('shift_type_id')->references('id')->on('shift_types');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('shifts');
  }
};

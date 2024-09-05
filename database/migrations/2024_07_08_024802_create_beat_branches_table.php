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
    Schema::create('beat_branches', function (Blueprint $table) {
      $table->id();
      $table->foreignId('beat_id');
      $table->string('name')->nullable();
      $table->string('phone_number')->nullable();
      $table->text('address');
      $table->text('landmark')->nullable();
      $table->string('area');
      $table->string('city')->nullable();
      $table->string('state')->nullable();
      $table->string('country')->nullable()->default("Nigeria");
      $table->decimal('latitude', 10, 8)->nullable();
      $table->decimal('longitude', 11, 8)->nullable();
      $table->timestamps();
      $table->foreign('beat_id')->references('id')->on('beats');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('beat_branches');
  }
};

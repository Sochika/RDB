<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('settings', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->string('value');
      $table->foreignId('user_id')->nullable();
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users');

    });
    DB::table('settings')->insert(['title' => 'staff_radius', 'value' => 1000]);
    DB::table('settings')->insert(['title' => 'view_off_beats', 'value' => 1]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('settings');
  }
};

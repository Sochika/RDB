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
    Schema::table('attendances', function (Blueprint $table) {
      //
      $table->foreignId('created_by')->after('minutes_of_lateness')->default(1);
      $table->foreign('created_by')->references('id')->on('users');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('attendances', function (Blueprint $table) {
      //
      $table->dropColumn('created_by');
    });
  }
};

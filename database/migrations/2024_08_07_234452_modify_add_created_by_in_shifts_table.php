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
    Schema::table('shifts', function (Blueprint $table) {
      //
      $table->foreignId('created_by')->after('rate')->default(1);
      $table->foreignId('ended_by')->after('rate')->nullable();
      $table->foreign('created_by')->references('id')->on('users');
      $table->foreign('ended_by')->references('id')->on('users');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('shifts', function (Blueprint $table) {
      //
      $table->dropColumn('created_by');
      $table->dropColumn('ended_by');
    });
  }
};

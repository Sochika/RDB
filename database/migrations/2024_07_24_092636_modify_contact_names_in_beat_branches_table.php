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
    Schema::table('beat_branches', function (Blueprint $table) {
      $table->string('first_name')->after('name')->default('');
      // $table->string('middle_name')->nullable();
      $table->string('last_name')->after('first_name')->default('');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('beat_branches', function (Blueprint $table) {
      //
      $table->dropColumn('first_name');
      $table->dropColumn('last_name');
    });
  }
};

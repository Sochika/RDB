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
      // Check if 'shift_on' column exists before dropping it
      if (Schema::hasColumn('shifts', 'shift_on')) {
        $table->dropColumn('shift_on');
      }

      // Check if 'main_assign' column exists before dropping it
      if (Schema::hasColumn('shifts', 'main_assign')) {
        $table->dropColumn('main_assign');
      }

      // Add new boolean columns with default values
      $table->boolean('main_assign')->default(false)->after('shift_type_id');
      $table->boolean('shift_on')->default(false)->after('main_assign');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
    Schema::table('shifts', function (Blueprint $table) {
      // Check if 'shift_on' column exists before dropping it
      if (Schema::hasColumn('shifts', 'shift_on')) {
        $table->dropColumn('shift_on');
      }

      // Check if 'main_assign' column exists before dropping it
      if (Schema::hasColumn('shifts', 'main_assign')) {
        $table->dropColumn('main_assign');
      }

      // Recreate columns with previous types and defaults
      $table->enum('main_assign', [1, 0])->default(1)->after('shift_type_id');
      $table->string('shift_on')->nullable()->after('main_assign');
    });
  }
};

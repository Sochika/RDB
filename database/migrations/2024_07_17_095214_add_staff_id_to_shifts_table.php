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

      $table->foreignId('staff_id')->after('id');
      $table->foreignId('beat_id')->after('staff_id');
      $table->foreignId('beat_branch_id')->nullable()->after('beat_id');
      $table->enum('main_assign', [1, 0])->default(1)->after('shift_type_id');
      $table->date('expires')->nullable()->after('main_assign');

      $table->foreign('staff_id')->references('id')->on('staff');
      $table->foreign('beat_id')->references('id')->on('beats');
      $table->foreign('beat_branch_id')->references('id')->on('beat_branches');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('shifts', function (Blueprint $table) {
      $table->dropForeign(['staff_id']);
      $table->dropForeign(['beat_id']);
      $table->dropForeign(['beat_branch_id']);

      $table->dropColumn(['staff_id', 'beat_id', 'beat_branch_id', 'main_assign', 'expires']);
    });
  }
};

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

    Schema::rename('role_has_permissions', 'office_has_permissions');
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {

    Schema::rename('office_has_permissions', 'role_has_permissions');
  }
};

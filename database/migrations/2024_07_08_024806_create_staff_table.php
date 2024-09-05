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
    Schema::create('staff', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->nullable()->index();
      $table->string('first_name');
      $table->string('middle_name')->nullable();
      $table->string('last_name');
      $table->string('avatar')->nullable();
      $table->string('email')->unique()->nullable();
      $table->string('phone_number')->nullable();
      $table->date('date_of_birth');
      $table->enum('gender', ['male', 'female', 'binary'])->default('binary');
      $table->text('address')->nullable();
      $table->string('area')->nullable();
      $table->string('city')->nullable();
      $table->string('state')->nullable();
      $table->string('country')->nullable();
      $table->decimal('latitude', 10, 8)->nullable();
      $table->decimal('longitude', 11, 8)->nullable();
      $table->foreignId('role_id');
      $table->foreignId('spervisor_id')->nullable();
      $table->foreignId('department_id')->nullable();
      $table->foreignId('beat_id')->nullable();
      $table->foreignId('beat_branch_id')->nullable();
      $table->foreignId('shifts_id')->nullable();
      $table->date('graduated')->nullable();
      $table->enum('status', ['on', 'off'])->default('off');
      $table->date('hire_date');
      $table->string('bank_account')->nullable();
      $table->string('created_by');
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users');
      $table->foreign('beat_branch_id')->references('id')->on('beat_branches');
      $table->foreign('beat_id')->references('id')->on('beats');
      $table->foreign('role_id')->references('id')->on('roles');
      $table->foreign('shifts_id')->references('id')->on('shifts');
    });
  }
  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('staff');
  }
};

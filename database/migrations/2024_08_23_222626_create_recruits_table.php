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
    Schema::create('recruits', function (Blueprint $table) {
      $table->id();
      $table->string('first_name');
      $table->string('middle_name')->nullable();
      $table->string('last_name');
      $table->string('phone_number')->nullable();
      $table->string('email')->nullable();
      $table->enum('gender', ['male', 'female', 'binary'])->default('binary');
      $table->string('sourced_area')->nullable();
      $table->string('area')->nullable();
      $table->string('city')->nullable();
      $table->string('state')->nullable();
      $table->foreignId('created_by')->nullable()->references('id')->on('users');
      $table->string('referral')->nullable();
      $table->text('note')->nullable();
      $table->enum('approve', [1, 2, 3])->default(1); // 1 => not approved, 3=> Approved, 2=>Rejected
      $table->foreignId('staff_id')->nullable()->references('id')->on('staff');
      $table->foreignId('office_id')->nullable()->references('id')->on('offices');
      $table->date('recruit_date');
      $table->timestamps();
      $table->unique(['first_name', 'middle_name', 'last_name', 'gender']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('recruits');
  }
};

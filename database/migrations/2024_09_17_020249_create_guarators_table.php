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
    Schema::create('guarators', function (Blueprint $table) {
      $table->id();
      $table->foreignId('staff_id')->constrained()->onDelete('cascade'); // links to the 'staff' table
      $table->string('first_name');
      $table->string('middle_name')->nullable();
      $table->string('last_name');
      $table->string('phone_number');
      $table->string('email')->nullable();
      $table->text('address');
      $table->string('area')->nullable();
      $table->enum('gender', ['male', 'female', 'binary'])->default('binary');
      $table->string('avatar')->nullable(); // stores image path
      $table->string('ID_document')->nullable(); // stores ID (image/pdf path)
      $table->integer('verified')->nullable();
      $table->foreignId('created_by')->constrained('users', 'id')->onDelete('cascade'); // links to the 'user' table
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('guarators');
  }
};

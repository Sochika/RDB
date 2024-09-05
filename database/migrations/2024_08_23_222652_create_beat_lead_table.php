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
    Schema::create('beat_leads', function (Blueprint $table) {
      $table->id();
      $table->string('contact_name');
      $table->string('companyName')->nullable();
      $table->string('address')->nullable();
      $table->string('area')->nullable();
      $table->string('city')->nullable();
      $table->string('state')->nullable();
      $table->string('phone_number');
      $table->string('email')->nullable();
      $table->string('type')->nullable();
      $table->integer('agreed_num_operatives')->nullable();
      $table->date('lead_date');
      $table->foreignId('beat_id')->nullable()->references('id')->on('beats');
      $table->foreignId('created_by')->nullable()->references('id')->on('users');
      $table->string('referral')->nullable();
      $table->date('onboard_date')->nullable();
      $table->enum('approve', [1, 2, 3])->default(1); // 1 => not approved, 3=> Approved, 2=>Rejected
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('beat_leads');
  }
};

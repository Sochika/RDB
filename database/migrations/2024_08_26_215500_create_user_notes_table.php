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
    Schema::create('user_notes', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->references('id')->on('users');
      $table->foreignId('office_id')->references('id')->on('offices');
      $table->foreignId('lead_id')->nullable()->references('id')->on('beat_leads');
      $table->foreignId('recruit_id')->nullable()->references('id')->on('recruits');
      $table->integer('num_operatives')->nullable();
      $table->integer('amount')->nullable();
      $table->text('note');
      $table->string('onboard');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('user_notes');
  }
};

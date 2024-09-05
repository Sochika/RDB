<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('states', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->timestamps();
    });
    // Insert states of Nigeria
    $states = [
      'Abia', 'Adamawa', 'Akwa Ibom', 'Anambra', 'Bauchi', 'Bayelsa', 'Benue', 'Borno',
      'Cross River', 'Delta', 'Ebonyi', 'Edo', 'Ekiti', 'Enugu', 'Gombe', 'Imo', 'Jigawa',
      'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Kwara', 'Lagos', 'Nasarawa', 'Niger',
      'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau', 'Rivers', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara'
    ];

    foreach ($states as $state) {
      DB::table('states')->insert(['name' => $state]);
    }

    //   DB::table('states')->insert([
    //     ['name' => 'Abia'],
    //     ['name' => 'Adamawa'],
    //     ['name' => 'Akwa Ibom'],
    //     ['name' => 'Anambra'],
    //     ['name' => 'Bauchi'],
    //     ['name' => 'Bayelsa'],
    //     ['name' => 'Benue'],
    //     ['name' => 'Borno'],
    //     ['name' => 'Cross River'],
    //     ['name' => 'Delta'],
    //     ['name' => 'Ebonyi'],
    //     ['name' => 'Edo'],
    //     ['name' => 'Ekiti'],
    //     ['name' => 'Enugu'],
    //     ['name' => 'FCT'],
    //     ['name' => 'Gombe'],
    //     ['name' => 'Imo'],
    //     ['name' => 'Jigawa'],
    //     ['name' => 'Kaduna'],
    //     ['name' => 'Kano'],
    //     ['name' => 'Katsina'],
    //     ['name' => 'Kebbi'],
    //     ['name' => 'Kogi'],
    //     ['name' => 'Kwara'],
    //     ['name' => 'Lagos'],
    //     ['name' => 'Nasarawa'],
    //     ['name' => 'Niger'],
    //     ['name' => 'Ogun'],
    //     ['name' => 'Ondo'],
    //     ['name' => 'Osun'],
    //     ['name' => 'Oyo'],
    //     ['name' => 'Plateau'],
    //     ['name' => 'Rivers'],
    //     ['name' => 'Sokoto'],
    //     ['name' => 'Taraba'],
    //     ['name' => 'Yobe'],
    //     ['name' => 'Zamfara'],

    // ]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('states');
  }
};

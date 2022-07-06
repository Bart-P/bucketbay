<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('addresses', function (Blueprint $table) {
      $table->id();
      $table->string('name1');
      $table->string('name2');
      $table->string('name3');
      $table->string('street');
      $table->string('street_nr');
      $table->string('city');
      $table->string('city_code');
      $table->string('country');
      $table->mediumText('address_info');
      $table->string('user_id');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('addresses');
  }
};

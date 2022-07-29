<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grafics', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('name')->unique();
            $table->string('file');
            $table->string('type');
            $table->string('size_in_mb');
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
        Schema::dropIfExists('grafics');
    }
};

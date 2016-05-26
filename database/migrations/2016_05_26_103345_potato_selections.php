<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PotatoSelections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('potato_selections', function (Blueprint $table) {
            $table->increments('id');

            $table->enum('vote', ['potato', 'camera']);
            $table->string('ip');

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
        \Schema::drop('potato_selections');
    }
}

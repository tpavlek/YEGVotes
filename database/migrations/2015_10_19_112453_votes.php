<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Votes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('votes', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');

            $table->string('motion_id');
            $table->foreign('motion_id')->references('id')->on('motions');

            $table->string('voter');
            $table->string('vote');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::drop('votes');
    }
}

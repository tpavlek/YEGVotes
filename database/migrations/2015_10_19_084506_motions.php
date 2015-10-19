<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Motions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create("motions", function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');

            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('agenda_items');

            $table->string('mover')->nullable();
            $table->string('seconder')->nullable();
            $table->text('description');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::drop('motions');
    }
}

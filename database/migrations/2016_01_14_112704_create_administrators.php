<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministrators extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('administrators', function(Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->primary('id');

            $table->string('password', 60);

            $table->string('remember_token', 100);

            $table->string('username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::drop('administrators');
    }
}

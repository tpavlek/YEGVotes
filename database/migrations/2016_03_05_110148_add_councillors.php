<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCouncillors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('councillors', function(Blueprint $table) {
            $table->string('name');
            $table->primary('name');

            $table->string('img_url');

            $table->string('ward')->nullable();
            $table->integer('term')->unsigned()->nullable();

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
        \Schema::drop('councillors');
    }
}

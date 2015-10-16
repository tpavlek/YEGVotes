<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('meetings', function(Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->primary('id');

            $table->string('meeting_type');
            $table->string('record_type');
            $table->dateTime('date');
            $table->string('location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::drop('meetings');
    }
}

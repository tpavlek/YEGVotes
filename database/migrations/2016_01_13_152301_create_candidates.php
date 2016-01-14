<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('election_candidates', function(Blueprint $table) {
            $table->increments('id');

            $table->string('election_id');
            $table->foreign('election_id')->references('id')->on('elections')->onDelete('cascade');

            $table->string('first_name');
            $table->string('last_name');

            $table->string('img_url')->nullable();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

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
        \Schema::drop('election_candidates');
    }
}

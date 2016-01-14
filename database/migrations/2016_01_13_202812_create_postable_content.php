<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostableContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('election_postable_content', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('candidate_id')->unsigned();
            $table->foreign('candidate_id')->references('id')->on('election_candidates')->onDelete('cascade');

            $table->integer('postable_id')->unsigned();
            $table->string('postable_type');

            $table->dateTime('approved_at')->nullable()->default(null);
            $table->dateTime('rejected_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::drop('election_postable_content');
    }
}

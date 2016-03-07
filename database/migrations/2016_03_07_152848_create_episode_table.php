<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title");
            $table->string("pubDate");
            $table->string("link");
            $table->string("duration");
            $table->string("author");
            $table->tinyInteger("explicit");
            $table->string("summary");
            $table->string("subtitle");
            $table->string("description");
            $table->string("content_link");
            $table->string("enclosure_link");
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
        Schema::drop('episodes');
    }
}

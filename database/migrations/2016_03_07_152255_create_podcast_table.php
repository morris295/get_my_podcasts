<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePodcastTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podcasts', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title");
            $table->string("description");
            $table->string("webMaster");
            $table->string("copyright");
            $table->string("subtitle");
            $table->string("image_url");
            $table->string("link");
            $table->string("author");
            $table->tinyInteger("explicit");
            $table->timestamp("last_published");
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
        Schema::drop('podcasts');
    }
}

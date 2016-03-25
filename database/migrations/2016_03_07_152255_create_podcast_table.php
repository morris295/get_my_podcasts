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
            $table->string('title')->unique();
            $table->string('description');
            $table->string('copyright');
            $table->string('subtitle');
            $table->longText('image_url');
            $table->string('resource');
            $table->string('author');
            $table->tinyInteger('explicit');
            $table->timestamp('last_published');
            $table->integer('top_show');
            $table->integer('tastemaker');
            $table->timestamp('last_top_show_date');
            $table->bigInteger('as_id');
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

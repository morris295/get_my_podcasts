<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

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
            $table->string("media_url");
            $table->integer("podcast_id")->unsigned();
            $table->string("enclosure_link");
            $table->integer("as_id");
            $table->timestamps();
           
            // Add foreign key referencing podcast ID.
            $table->foreign("podcast_id")->references("id")->on("podcasts");
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

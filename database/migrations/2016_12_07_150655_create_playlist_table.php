<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreatePlaylistTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('playlists', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->string('contents', 10000);
			$table->string('playlist_name')->default('Default');
			$table->tinyInteger('keep_current')->default(0);
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
		Schema::drop('playlists');
	}
}
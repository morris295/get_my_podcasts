<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{

	protected $table = "podcasts";
	
	protected $fillable = [
		'title', 'description', 'copyright', 'subtitle',
		'image_url', 'resource', 'media_file', 'author', 'explicit',
		'last_published', 'top_show', 'last_top_show_date',
		'as_id', 'total_episodes'
	];
	
	protected $hidden = [
		'id'
	];
	
}

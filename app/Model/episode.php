<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model {
	protected $table = "episodes";
	protected $fillable = [ 
			'title',
			'pub_date',
			'link',
			'duration',
			'author',
			'explicit',
			'summary',
			'subtitle',
			'description',
			'source',
			'podcast_id',
			'enclosure_link',
			'as_id' 
	];
	protected $hidden = [ 
			'id' 
	];
}

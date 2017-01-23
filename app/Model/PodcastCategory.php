<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PodcastCategory extends Model
{
	protected $table = 'podcast_category';
	protected $fillable = [
		'podcast_id',
		'category_id'
	];
	protected $hidden = [
			'id'
	];
}

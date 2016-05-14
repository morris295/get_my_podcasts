<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class subscription extends Model {
	
	protected $table = "subscription";
	
	protected $fillable = [
		'user_id', 'podcast_id'
	];
	
	protected $hidden = [
		'id'
	];
}
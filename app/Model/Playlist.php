<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $table = "playlists";

    protected $fillable = [
    	'user_id', 'contents', 'playlist_name', 'keep_current'
    ];
}

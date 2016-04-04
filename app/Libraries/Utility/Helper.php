<?php

namespace App\Libraries\Utility;

use Illuminate\Support\Facades\URL;

class Helper {
	
	/**
	 * Parses podcast information to retrieve included artwork image
	 * or returns a default image if none was made available.
	 */	
	public static function getArtworkImage($showMetaData) {
		
		$image = "";
		
		if (isset($showMetaData["image_files"][0]["url"]["thumb"])) {
			$image = $showMetaData["image_files"][0]["url"]["thumb"];
		} else {
			$image = URL::to('/')."/image/play.png";
		}
		
		return $image;		
	}
	
}
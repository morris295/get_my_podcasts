<?php

namespace App\Libraries\Utility;

use ColorThief\ColorThief;
use \Requests;

class ColorThiefUtility {
	
	private static $colorThief;
	
	public static function getPrimaryColor($image) {
		
		$imageStatusCheck = Requests::get($image);

		$colors = [];

		if ($imageStatusCheck->status_code === 200) {
			$fileName = FileUtility::downloadFile($image);
		
			$colorThief = new ColorThief();
			
			$color = $colorThief->getColor($fileName);
			$contrast = self::getContrast($color);
			
			if (!empty($color)) {
				FileUtility::removeFile($fileName);
				$colors["primaryColor"] = implode(",", $color);
				$colors["contrast"] = $contrast;
			}
		} else {
			$colors["primaryColor"] = "0, 0, 0";
			$colors["contrast"] = "255, 255, 255";
		}

		return $colors;
	}	
	
	private static function getContrast($primaryColor) {
		$total = 0;
		$contrast = "";
		
		foreach($primaryColor as $val) {
			$total+= $val;
		}
		
		$avg = $total/3;
		
		if ($avg >= 128) {
			$contrast = "53,66,75";
		} else {
			$contrast = "178,219,251";
		}
		
		return $contrast;
	}
}
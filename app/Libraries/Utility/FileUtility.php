<?php

namespace App\Libraries\Utility;

class FileUtility {
	
	public static function downloadFile($fileUrl) {
		$path = "/tmp/".uniqid("img", true);
		copy($fileUrl, $path);
		return $path;
	}
	
	public static function removeFile($filePath) {
		unlink($filePath);
	}
	
}
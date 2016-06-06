<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Utility\DbUtility;
use App\Libraries\Utility\ApiUtility;
use App\Model\Episode;
use App\Model\Podcast;
use Illuminate\Support\Facades\Auth;

class ShowController extends Controller {
	
	public function __construct() {
		ApiUtility::init();
	}
	
	public function getShow($id) {
		
		$authorized = false;
		
		if (!Auth::guest()) {
			$authorized = true;
		}
		
		return view("show", ["showResource" => $id, "auth" => $authorized]);
	}
}
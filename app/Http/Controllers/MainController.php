<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Utility\ApiUtility;
use App\Libraries\Utility\DbUtility;
use App\Libraries\Utility\Helper;
use App\Model\Podcast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class MainController extends Controller {
	
	public function __construct() {
		ApiUtility::init();
	}
	
	/**
	 * Return application main page.
	 */
	public function index() {
		return view('index');
	}
	
	public function about() {
		return view('about');
	}
	
	public function contact() {
		return view('contact');
	}
	
	/**
	 * Search for a podcast.
	 */
	public function search() {
		
		$searchTerm = Input::get("term");
		$response = ApiUtility::getSearch($searchTerm);
		$items = [];
		
		foreach ($response["results"] as $result) {
			$item = [
				"title" => $result["title"],
				"description" => $result["description"],
				"as_id" => $result["id"],
			];
			array_push($items, $item);
		}
		
		return view('search', ["items" => $items]);
	}
}
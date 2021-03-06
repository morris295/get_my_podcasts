<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Utility\ApiUtility;
use App\Model\Podcast;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class MainController extends Controller {
	public function __construct() {
		ApiUtility::init ();
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
		$timeStart = microtime(true);
		$searchTerm = Input::get("term");
		$items = [ ];
		
		if ($searchTerm) {
			$response = ApiUtility::getSearch($searchTerm);
			
			foreach ( $response ["results"] as $result ) {
				$item = [ 
						"title" => $result ["title"],
						"description" => $result ["description"],
						"as_id" => $result ["id"] 
				];
				array_push ( $items, $item );
			}
			$timeEnd = microtime(true);
			$executionTime = $timeEnd - $timeStart;
			
			return view ('search', [ 
					"term" => $searchTerm,
					"count" => count($items),
					"items" => $items,
					"execution" => number_format($executionTime, 2, '.', ''),
					"noAudio" => true
			]);
		} else {
			$data = ["items" => $items];
			return view('search', $data);
		}
	}
}
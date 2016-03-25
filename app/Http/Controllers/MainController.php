<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Podcast;
use Illuminate\Support\Facades\Input;
use App\Libraries\Utility\Utility;
use App\Libraries\Utility\ApiUtility;

class MainController extends Controller {
	
	public function __construct() {
		ApiUtility::init();
		//$this->middleware('auth');
	}
	
	/**
	 * Return application main page.
	 */
	public function index() {
		
		$data = $this->getTopShows();
		
		return view('index', $data);
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
			Utility::insertPodcast($result);
			$item = [
				"title" => $result["title"],
				"description" => $result["description"],
				"as_id" => $result["id"],
			];
			array_push($items, $item);
		}
		
		return view('search', ["items" => $items]);
	}
	
	private function getTopShows() {
		
		$lastUpdated = Podcast::where("top_show", 1)->max("last_top_show_date");
		$threeDaysAgo = strtotime("-3 days");
		
		$topShows = [];
		$tastemakers = [];
		
		if ($lastUpdated == null || strtotime($lastUpdated) < $threeDaysAgo) {
			
			$yesterday = date("Y-m-d",strtotime("yesterday"));
			
			$topShowsResponse = ApiUtility::getTopShows($yesterday);
			$tastemakerResponse = ApiUtility::getTastemakers();
			
			foreach($topShowsResponse["shows"] as $show) {
				$showDetails = ApiUtility::getPodcast($show["id"]);
				Utility::insertPodcast($showDetails);
				$show = [
						"as_id" => $showDetails["id"],
						"title" => $showDetails["title"],
						"image_url" => $showDetails["image_files"][0]["url"]["thumb"],
						"resource" => "shows/".$showDetails["id"]
				];
				array_push($topShows, $show);
			}
	
			foreach($tastemakerResponse["results"] as $show) {
				$showDetails = ApiUtility::getPodcast($show["id"]);
				Utility::insertPodcast($showDetails);
				$show = [
						"as_id" => $showDetails["id"],
						"title" => $showDetails["title"],
						"image_url" => $showDetails["image_files"][0]["url"]["thumb"],
						"resource" => "shows/".$showDetails["id"]
				];
				array_push($tastemakers, $show);
			}
		} else {
			$topShows = Podcast::where("top_show", 1)->get()->toArray();
			$tastemakers = Podcast::where("tastemaker", 1)->get()->toArray();
		}
		
		return ["topShows" => $topShows, "tastemakers" => $tastemakers];
	}
}
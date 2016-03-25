<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Audiosearch\lib\Audiosearch\Audiosearch_Client;
use App\Model\Podcast;
use Illuminate\Support\Facades\Input;

class MainController extends Controller {
	
	private $audiosearchClient;
	
	public function __construct() {
		//$this->middleware('auth');
		$this->audiosearchClient = Audiosearch_Client::getInstance();
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
	
	public function search() {
		$searchTerm = Input::get("term");
		$response = $this->audiosearchClient->get("/search/shows/$searchTerm");
		/*echo "<pre>";
		print_r($response["results"]);
		echo "</pre>";*/
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
	
	private function getTopShows() {
		
		$lastUpdated = Podcast::where("top_show", 1)->max("last_top_show_date");
		$threeDaysAgo = strtotime("-3 days");
		
		$topShows = [];
		$tastemakers = [];
		
		if ($lastUpdated == null || strtotime($lastUpdated) < $threeDaysAgo) {
			
			$yesterday = date("Y-m-d",strtotime("yesterday"));
			
			$topShowsResponse = $this->audiosearchClient->get(
					"chart_daily?start_date=$yesterday&limit=10&country=us");
			$tastemakerResponse = $this->audiosearchClient->get_tastemakers(
					["n"=>"10",
					 "type"=>"shows"]);
			
			foreach($topShowsResponse["shows"] as $show) {
				$showDetails = $this->audiosearchClient->get_show($show["id"]);
				$this->insertPodcast($showDetails);
				$show = [
						"as_id" => $showDetails["id"],
						"title" => $showDetails["title"],
						"image_url" => $showDetails["image_files"][0]["url"]["thumb"],
						"resource" => "shows/".$showDetails["id"]
				];
				array_push($topShows, $show);
			}
	
			foreach($tastemakerResponse["results"] as $show) {
				$showDetails = $this->audiosearchClient->get_show($show["id"]);
				$this->insertPodcast($showDetails);
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
	
	/**
	 * Determine if podcast has already been saved, if so update the last top date.
	 * If not, save it.
	 * @param unknown $showDetails
	 */
	private function insertPodcast($showDetails) {
		
		$show = Podcast::where("title", $showDetails["title"])->first();
		
		if ($show === null) {
			$show = new Podcast();
			$show->as_id = $showDetails["id"];
			$show->title = $showDetails["title"];
			$show->image_url = $showDetails["image_files"][0]["url"]["thumb"];
			$show->explicit = 0;
			$show->last_published = date("Y-m-d H:i:s");
			$show->top_show = 0;
			$show->tastemaker = 1;
			$show->resource = "shows/".$showDetails["id"];
			$show->last_top_show_date = date("Y-m-d H:i:s");
			$show->save();
		} else {
			Podcast::where("title", $showDetails["title"])->update(["last_top_show_date" => date("Y-m-d H:i:s")]);
		}
	}
}
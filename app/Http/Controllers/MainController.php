<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Audiosearch\lib\Audiosearch\Audiosearch_Client;

class MainController extends Controller {
	
	private $audiosearchClient;
	
	public function __construct() {
		$this->audiosearchClient = Audiosearch_Client::getInstance();
	}
	
	public function index() {
		
		$topShowsResponse = $this->audiosearchClient->get(
				"chart_daily?start_date=2016-03-09&limit=10&country=us");
		$tastemakerResponse = $this->audiosearchClient->get_tastemakers(
				["n"=>"10",
				"type"=>"shows"]);
				
		$topShows = [];
		$tastemakers = [];
		
		foreach($topShowsResponse["shows"] as $show) {
			$showDetails = $this->audiosearchClient->get_show($show["id"]);
			$show = [
				"id" => $showDetails["id"],
				"title" => $showDetails["title"],
				"image" => $showDetails["image_files"][0]["url"]["thumb"],
				"url" => "shows/".$showDetails["id"]
			];
			array_push($topShows, $show);
		}
		
		foreach($tastemakerResponse["results"] as $show) {
			$showDetails = $this->audiosearchClient->get_show($show["id"]);
			$show = [
				"id" => $showDetails["id"],
				"title" => $showDetails["title"],
				"image" => $showDetails["image_files"][0]["url"]["thumb"],
				"url" => "shows/".$showDetails["id"]
			];
			array_push($tastemakers, $show);
		}
		
		return view('index', ["topShows" => $topShows,
				"tastemakers" => $tastemakers]);
	}
	
	public function about() {
		return view('about');
	}
	
	public function contact() {
		return view('contact');
	}
	
}
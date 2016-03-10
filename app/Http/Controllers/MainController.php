<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\RestCurl;
use \SimpleXMLElement;
use App\Libraries\FeedParser;
use App\Libraries\Audiosearch\lib\Audiosearch\Audiosearch_Client;

class MainController extends Controller {
	
	private $audiosearchClient;
	
	public function __construct() {
		
		$this->audiosearchClient = new Audiosearch_Client([
				"key" => "55388f355298550af1c51462af1198c45b38c626958bec58e4ac1e872dd2f8ca",
				"secret" => "f315a0619e97b1cddeeb2daf96b336aa86ec1c697b8827928bd81cebeebaf63b",
				"host" => "https://www.audiosear.ch",
				"debug" => false
		]);
		
	}
	
	public function index() {
		
		$topShowsResponse = $this->audiosearchClient->get(
				"chart_daily?start_date=2016-03-09&limit=10&country=us");
		$tastemakerResponse = $this->audiosearchClient->get_tastemakers(["n"=>"10", "type"=>"shows"]);
				
		$topShows = [];
		$tastemakers = [];
		
		foreach($topShowsResponse["shows"] as $key=>$value) {
			$topShows[] = $key;
		}
		
		foreach($tastemakerResponse["results"] as $show) {
			array_push($tastemakers, ["title"=>$show["title"], "url"=>$show["sc_feed"]]);
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
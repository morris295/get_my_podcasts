<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Audiosearch\lib\Audiosearch\Audiosearch_Client;

class ShowController extends Controller {
	
	private $audiosearchClient;
	
	public function __construct() {
		$this->audiosearchClient = Audiosearch_Client::getInstance();
	}
	
	public function getShow($id) {
		$show = $this->audiosearchClient->get_show($id);
		$image = $show["image_files"][0]["url"]["thumb"];
		$episodes = [];
		
		for ($i = 0; $i<10; $i++) {
			$episodeId = $show["episode_ids"][$i];
			$episodeListing = $this->audiosearchClient->get_episode($episodeId);
// 			echo "<pre>";
// 			print_r($episodeListing);
// 			echo "</pre>";
// 			exit;
			$episode = [
				"title"=>$episodeListing["title"],
				"description"=>$episodeListing["description"],
				"source"=>$episodeListing["audio_files"][0]["url"][0]
			];
			array_push($episodes, $episode);
		}
		
		return view("show", ["show" => $show, "image" => $image, "episodes" => $episodes]);
	}
	
}
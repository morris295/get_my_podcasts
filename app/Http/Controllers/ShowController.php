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
		$image = $show["image_files"][0]["url"]["full"];
		$episodes = [];
		$totalEpisodes = count($show["episode_ids"]);
		$filesToGet = ($totalEpisodes > 10) ? 10 : $totalEpisodes;
		
		for ($i = 0; $i<$filesToGet; $i++) {
			$episodeId = $show["episode_ids"][$i];
			$episodeListing = $this->audiosearchClient->get_episode($episodeId);
			$episode = [
				"title"=>$episodeListing["title"],
				"description"=>$episodeListing["description"],
				"source"=>$episodeListing["audio_files"][0]["url"][0],
				"episode_num"=>$i+1
			];
			array_push($episodes, $episode);
		}
		
		return view("show", ["show" => $show, "image" => $image, "episodes" => $episodes]);
	}
	
	private function saveShow() {
		
	}
	
	private function saveEpisodes() {
		
	}
	
}
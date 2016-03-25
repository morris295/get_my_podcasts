<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Utility\Utility;
use App\Libraries\Utility\ApiUtility;
use App\Model\Episode;
use App\Model\Podcast;

class ShowController extends Controller {
	
	public function __construct() {
		ApiUtility::init();
	}
	
	public function getShow($id) {
		
		$show = Podcast::where("as_id", $id)->first();
		$podcast = ApiUtility::getPodcast($id);
		
		if ($show === null) {
			$show = Utility::insertPodcast($show);
		}
		
		$podcastId = $show->id;
		
		$image = $podcast["image_files"][0]["url"]["full"];
		$episodes = [];
		$totalEpisodes = $show->total_episodes;
		$filesToGet = ($totalEpisodes > 10) ? 10 : $totalEpisodes;
		
		for ($i = 0; $i<$filesToGet; $i++) {
			$episodeId = $podcast["episode_ids"][$i];
			
			$dbEpisode = Episode::where("as_id", $episodeId)->first();
			$episode = null;
			
			if ($dbEpisode === null) {
				$episodeListing = ApiUtility::getEpisode($episodeId);
				$episode = Utility::insertEpisode($podcastId, $episodeListing);
				$episode["episode_num"] = $i+1;
			} else {
				$episode = [
					"title"=>$dbEpisode->title,
					"description"=>$dbEpisode->description,
					"source"=>$dbEpisode->source,
					"episode_num"=>$i+1
				];
			}
			
			array_push($episodes, $episode);
		}
		
		return view("show", ["show" => $show, "image" => $image, "episodes" => $episodes]);
	}
	
	private function saveShow() {
		
	}
	
	private function insertEpisode() {
		
	}
	
}
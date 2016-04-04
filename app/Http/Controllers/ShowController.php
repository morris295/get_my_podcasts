<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Utility\DbUtility;
use App\Libraries\Utility\ApiUtility;
use App\Model\Episode;
use App\Model\Podcast;

class ShowController extends Controller {
	
	public function __construct() {
		ApiUtility::init();
	}
	
	public function getShow($id) {
		
		// Check if the podcast is in the DB.
		$show = Podcast::where("as_id", $id)->first();
		
		// Retrieve podcast details from API.
		$podcast = ApiUtility::getPodcast($id);
		
		// If the podcast is not in the DB
		// save it in the DB.
		if ($show === null) {
			$show = DbUtility::insertPodcast($podcast);
		}
		
		// Get the id of the podcast.
		$podcastId = $show->id;
		
		$image = ($show === null) ? $podcast["image_files"][0]["url"]["full"] : $show->image_url;
		$episodes = [];
		$totalEpisodes = $show->total_episodes;
		$filesToGet = ($totalEpisodes > 10) ? 10 : $totalEpisodes;
		
		if ($totalEpisodes === 0) {
			return view("show", ["show" => $show, "image" => $image, "episodes" => []]);
		}
		
		for ($i = 0; $i<$filesToGet; $i++) {
			
			$episodeId = $podcast["episode_ids"][$i];
			
			$dbEpisode = Episode::where("as_id", $episodeId)->first();
			$episode = null;
			
			if ($dbEpisode === null) {
				$episodeListing = ApiUtility::getEpisode($episodeId);
				$episode = DbUtility::insertEpisode($podcastId, $episodeListing);
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
}
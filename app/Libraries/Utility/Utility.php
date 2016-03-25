<?php

namespace App\Libraries\Utility;

use App\Model\Podcast;
use App\Model\Episode;
use App\Libraries\Audiosearch\lib\Audiosearch\Audiosearch_Client;

class Utility {
	
	/**
	 * Determine if podcast has already been saved, if so
	 * update the last top date.  If not, save it.
	 * @param unknown $podcastDetails
	 */
	public static function insertPodcast($podcastDetails) {
		
		$show = Podcast::where("title", $podcastDetails["title"])->first();
		
		if ($show === null) {
			$show = new Podcast();
			$show->as_id = $podcastDetails["id"];
			$show->title = $podcastDetails["title"];
			$show->image_url = $podcastDetails["image_files"][0]["url"]["thumb"];
			$show->explicit = 0;
			$show->last_published = date("Y-m-d H:i:s");
			$show->top_show = 0;
			$show->tastemaker = 1;
			$show->resource = "shows/".$podcastDetails["id"];
			$show->last_top_show_date = date("Y-m-d H:i:s");
			$show->total_episodes = count($podcastDetails["episode_ids"]);
			$show->save();
		} else {
			Podcast::where("title", $podcastDetails["title"])->update(["last_top_show_date" => date("Y-m-d H:i:s")]);
		}
		
		return $show;
	}
	
	public static function insertEpisode($podcastId, $episodeDetails) {
		$episode = Episode::where(
				["as_id" => $episodeDetails["id"],
				"id" => $podcastId])->first();
		
		if ($episode === null) {
			$episode = new Episode();
			$episode->title = $episodeDetails["title"];
			$episode->pub_date = date("Y-m-d H:i:s", strtotime($episodeDetails["date_created"]));
			$episode->link = $episodeDetails["digital_location"];
			$episode->duration = $episodeDetails["duration"];
			$episode->author = null;
			$episode->explicit = null;
			$episode->summary = null;
			$episode->subtitle = null;
			$episode->description = $episodeDetails["description"];
			$episode->source = $episodeDetails["audio_files"][0]["url"][0];
			$episode->podcast_id = $podcastId;
			$episode->enclosure_link = null;
			$episode->as_id = $episodeDetails["id"];
			$episode->save();
		}
		
		return [
				"title"=>$episode->title,
				"description"=>$episode->description,
				"source"=>$episode->source
		];
	}
}

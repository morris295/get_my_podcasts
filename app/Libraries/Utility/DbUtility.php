<?php

namespace App\Libraries\Utility;

use App\Model\Category;
use App\Model\Episode;
use App\Model\Podcast;
use App\Model\PodcastCategory;
use App\Model\subscription;
use Illuminate\Support\Facades\DB;
use App\Model\Playlist;

class DbUtility {
	
	/**
	 * Determine if podcast has already been saved, if so
	 * update the last top date.
	 * If not saved, save it.
	 * 
	 * @param unknown $podcastDetails        	
	 */
	public static function insertPodcast($podcastDetails) {
		$show = Podcast::where ("title", $podcastDetails["title"])->first();
		
		if ($show === null) {
			$show = new Podcast ();
			$show->as_id = $podcastDetails ["id"];
			$show->title = $podcastDetails ["title"];
			$image = isset ( $podcastDetails ["image_files"] [0] ["url"] ["full"] ) ? $podcastDetails ["image_files"] [0] ["url"] ["full"] : "";
			$show->image_url = $image;
			$show->description = isset ( $podcastDetails ["description"] ) ? $podcastDetails ["description"] : "";
			$show->explicit = 0;
			$show->last_published = date ( "Y-m-d H:i:s" );
			$show->resource = "shows/" . $podcastDetails ["id"];
			$show->total_episodes = isset ( $podcastDetails ["number_of_episodes"] ) ? $podcastDetails ["number_of_episodes"] : 0;
			$show->save ();
		} else {
			$image = isset ( $podcastDetails ["image_files"] [0] ["url"] ["full"] ) ? $podcastDetails ["image_files"] [0] ["url"] ["full"] : "";
			Podcast::where ( "title", $podcastDetails ["title"] )->update ( [ 
					"image_url" => $image,
					"description" => $podcastDetails ["description"] 
			] );
		}
		
		return $show;
	}
	
	public static function insertCategories($podcastId, $categories) {
		foreach ($categories as $item) {
			$category = Category::firstOrNew(["name" => $item]);
			$category->save();
			$podcastCategory = PodcastCategory::firstOrNew(["podcast_id" => $podcastId, "category_id" => $category->id]);
			$podcastCategory->save();
		}
	}
	
	public static function insertTopPodcast($podcastDetails, $topShow = 0, $tastemaker = 0) {
		$show = Podcast::where ( "title", $podcastDetails ["title"] )->first ();
		
		if ($show === null) {
			$show = new Podcast ();
			$show->as_id = $podcastDetails ["id"];
			$show->title = $podcastDetails ["title"];
			$image = isset ( $podcastDetails ["image_files"] [0] ["url"] ["full"] ) ? $podcastDetails ["image_files"] [0] ["url"] ["full"] : "";
			$show->image_url = $image;
			$show->description = isset ( $podcastDetails ["description"] ) ? $podcastDetails ["description"] : "";
			$show->explicit = 0;
			$show->last_published = date ( "Y-m-d H:i:s" );
			$show->top_show = $topShow;
			$show->tastemaker = $tastemaker;
			$show->resource = "shows/" . $podcastDetails ["id"];
			$show->last_top_show_date = date ( "Y-m-d H:i:s" );
			$show->total_episodes = isset ( $podcastDetails ["number_of_episodes"] ) ? $podcastDetails ["number_of_episodes"] : 0;
			$show->save ();
		} else {
			$image = isset ( $podcastDetails ["image_files"] [0] ["url"] ["full"] ) ? $podcastDetails ["image_files"] [0] ["url"] ["full"] : "";
			Podcast::where ( "title", $podcastDetails ["title"] )->update ( [ 
					"last_top_show_date" => date ( "Y-m-d H:i:s" ),
					"image_url" => $image,
					"description" => $podcastDetails ["description"] 
			] );
		}
		
		return $show;
	}
	
	
	public static function insertEpisode($podcastId, $episodeDetails) {
		$episode = Episode::where ( [ 
				"as_id" => $episodeDetails["id"],
				"id" => $podcastId 
		] )->first();
		
		if ($episode === null) {
			$episode = new Episode ();
			$episode->title = $episodeDetails ["title"];
			$episode->pub_date = date ("Y-m-d H:i:s", strtotime($episodeDetails["date_created"]));
			$episode->link = isset($episodeDetails["digital_location"])?$episodeDetails["digital_location"]:"";
			$episode->duration = $episodeDetails["duration"];
			$episode->author = null;
			$episode->explicit = null;
			$episode->summary = null;
			$episode->subtitle = null;
			$episode->description = isset($episodeDetails["description"])?$episodeDetails["description"]:"";
			if (isset($episodeDetails["audio_files"][0]["url"]) && is_array($episodeDetails["audio_files"][0]["url"])) {
				$episode->source = $episodeDetails["audio_files"][0]["url"][0];
			} else {
				$episode->source = isset($episodeDetails["audio_files"][0]["url"])?$episodeDetails["audio_files"][0]["url"]:"";
			}
			$episode->podcast_id = $podcastId;
			$episode->enclosure_link = null;
			$episode->as_id = $episodeDetails["id"];
			$episode->save();
		}
		
		return $episode;
	}
	
	public static function getTopShows() {
		return Podcast::where("top_show", 1)->orderBy(DB::raw("RAND()"))->take(60)->get();
	}
	
	public static function getEpisodeCount($id) {
		return Episode::where("podcast_id", $id)->count();
	}
	
	//DEPRECATED - REMOVE
	public static function getTastemakers() {
		return Podcast::where("tastemaker", 1)->orderBy('last_top_show_date', 'desc')->take(10)->get();
	}
	
	public static function updateArtwork($asId, $image) {
		Podcast::where("as_id", $asId )->update([ 
				"image_url" => $image 
		]);
	}
	
	public static function subscribeUser($podcastId, $userId) {
		subscription::create([ 
				"user_id" => $userId,
				"podcast_id" => $podcastId 
		]);
	}
	
	public static function unsubscribeUser($podcastId, $userId) {
		subscription::where([ 
			"user_id" => $userId,
			"podcast_id" => $podcastId 
		])->delete();
	}
	
	public static function deletePlaylist($id) {
		Playlist::where([
			"id" => $id
		])->delete();
	}
}

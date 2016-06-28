<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Utility\ApiUtility;
use App\Libraries\Utility\DbUtility;
use App\Libraries\Utility\Helper;
use App\Model\Episode;
use App\Model\Podcast;
use App\Model\subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use \DateTime;

class AsyncController extends Controller {
	
	public function __construct() {
		ApiUtility::init();
	}
	
	/**
	 * Endpoint to retrieve front-page content.
	 */
	public function getIndexContent() {
		$data = $this->getTopShows();
	
		return View::make('async.index', $data)->render();
	}
	
	/**
	 * Endpoint to retrieve show content.
	 * @param unknown $id
	 */
	public function getShowContent($id) {
		$data = $this->getShow($id);
		
		return View::make('async.show', $data)->render();
	}
	
	/**
	 * Endpoint to subscribe to a podcast.
	 */
	public function subscribeUser() {
		$user = Input::get("user_id");
		$show = Input::get("podcast_id");
	
		subscription::create(["user_id" => $user, "podcast_id" => $show]);
	
		return json_encode(["code" => 200, "message" => "", "data" => ""]);
	}
	
	/**
	 * Endpoint to unsubscribe from a podcast.
	 */
	public function unsubscribeUser() {
		$user = Input::get("user_id");
		$show = Input::get("podcast_id");
	
		subscription::where(["user_id" => $user, "podcast_id" => $show])->delete();
	
		return json_encode(["code" => 200, "message" => "", "data" => ""]);
	}
	
	/**
	 * Get the most recent episodes for a subscription
	 * @param unknown $id
	 */
	public function refreshSubscription($id) {
		$data = $this->getRecentEpisodes($id);
		
		return View::make('async.subscription.episodes', $data)->render();
	}
	
	/**
	 * Get top shows for front-page content.
	 */
	private function getTopShows() {
	
		$lastUpdated = new DateTime(Podcast::where("top_show", 1)->max("last_top_show_date"));
		$sevenDaysAgo = new DateTime("-7 days");
		$interval = $lastUpdated->diff($sevenDaysAgo);
		
 		$topShows = [];
		$tastemakers = [];
		
		if ($lastUpdated == null || $interval->days >= 7) {
			
			$lastWeek = date("Y-m-d", strtotime("-7 days"));
			
 			$topShowsResponse = ApiUtility::getTopShows($lastWeek);
			$tastemakerResponse = ApiUtility::getTastemakers();
			$counter = 0;
			
			foreach($topShowsResponse["shows"] as $show) {
				
				$showDetails = ApiUtility::getPodcast($show["id"]);
				DbUtility::insertPodcast($showDetails, 1, 0);
				$show = [
						"as_id" => $showDetails["id"],
						"title" => $showDetails["title"],
						"image_url" => Helper::getArtworkImage($showDetails),
						"resource" => "shows/".$showDetails["id"]
				];
				if ($counter > 9) {
					break;
				} else {
					array_push($topShows, $show);
					$counter++;
				}
			}
	
			foreach($tastemakerResponse["results"] as $show) {
				
				$showDetails = ApiUtility::getPodcast($show["id"]);
				DbUtility::insertPodcast($showDetails, 0, 1);
				$show = [
						"as_id" => $showDetails["id"],
						"title" => $showDetails["title"],
						"image_url" => Helper::getArtworkImage($showDetails),
						"resource" => "shows/".$showDetails["id"]
				];
				array_push($tastemakers, $show);
				
			}
		} else {
			$topShows = Podcast::where("top_show", 1)
								->orderBy('last_top_show_date', 'desc')
								->take(10)
								->get()
								->toArray();
			$tastemakers = Podcast::where("tastemaker", 1)
								->orderBy('last_top_show_date', 'desc')
								->take(10)
								->get()
								->toArray();
		}
		
			return ["topShows" => $topShows, "tastemakers" => $tastemakers];
	}
	
	/**
	 * Get an individual show's data and its most recent episodes 
	 * @param integer $id
	 */
	private function getRecentEpisodes($id) {
	
		// Check if the podcast is in the DB.
		$show = Podcast::where("id", $id)->first();
	
		// Retrieve podcast details from API.
		$podcast = ApiUtility::getPodcast($show->as_id);
	
		$episodes = [];
		$totalEpisodes = $podcast["number_of_episodes"];
		$filesToGet = ($totalEpisodes > 5) ? 5 : $totalEpisodes;
		
		for ($i = 0; $i<$filesToGet; $i++) {
				
			$episodeId = $podcast["episode_ids"][$i];
			$episode = null;
				
			$episodeListing = ApiUtility::getEpisode($episodeId);
			$episode = DbUtility::insertEpisode($id, $episodeListing);

			$episodeItem = [
					"title"=>$episode["title"],
					"description"=>$episode["description"],
					"source"=>$episode["source"],
					"episode_num"=>$i+1
			];
				
			array_push($episodes, $episodeItem);
		}
	
		return ["episodes" => $episodes];
	}
	
	private function getShow($id) {
		
		$subscribed = false;
		
		// Check if the podcast is in the DB.
		$show = Podcast::where("as_id", $id)->first();
		
		if (Auth::check()) {
			$userId = Auth::id();
			
			$subscribed = false;
			$isSubbed = null;
			
			if ($show == null) {
				$subscribed = false;
			} else {
				$isSubbed = subscription::where(["user_id" => $userId, "podcast_id" => $show->id])->first();
				$subscribed = ($isSubbed !== null) ? true : false;
			}
		}
		
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
						"episode_num"=>$i+1,
						"length"=>gmdate("H:i:s", $dbEpisode->duration)
				];
			}
				
			array_push($episodes, $episode);
		}
		
		return ["show" => $show, "image" => $image, "episodes" => $episodes, "podcastId" => $podcastId, "subscribed" => $subscribed];
	}
	
	public function artworkImage() {
		$show = Podcast::all()->random(1);
		$image = $show->image_url;
		$link = $show->resource;
		$data = [ "image" => $image, "resource" => $link];
		return json_encode($data, JSON_UNESCAPED_SLASHES);
	}
}
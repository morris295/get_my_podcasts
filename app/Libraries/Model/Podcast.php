<?php

namespace App\Libraries\Model;

use \DateTime;
use App\Libraries\Utility\ApiUtility;
use App\Libraries\Utility\DbUtility;
use App\Libraries\Utility\Helper;
use App\Model\Episode;
use App\Model\Podcast;
use App\Model\subscription;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class Podcast {
	
	public function __construct() {
		ApiUtility::init();
	}
	
	public function getTopPodcasts() {
		$lastUpdated = new DateTime ( Podcast::where ( "top_show", 1 )->max ( "last_top_show_date" ) );
		$sevenDaysAgo = new DateTime ( "-7 days" );
		$interval = $lastUpdated->diff ( $sevenDaysAgo );
	
		$topShows = [ ];
		$tastemakers = [ ];
	
		if ($lastUpdated == null || $interval->days >= 7) {
				
			$lastWeek = date ( "Y-m-d", strtotime ( "-7 days" ) );
				
			$topShowsResponse = ApiUtility::getTopShows ( $lastWeek );
			$tastemakerResponse = ApiUtility::getTastemakers ();
			$counter = 0;
				
			foreach ( $topShowsResponse ["shows"] as $show ) {
	
				$showDetails = ApiUtility::getPodcast ( $show ["id"] );
				DbUtility::insertTopPodcast ( $showDetails, 1, 0 );
				$show = [
						"as_id" => $showDetails ["id"],
						"title" => $showDetails ["title"],
						"image_url" => Helper::getArtworkImage ( $showDetails ),
						"resource" => "shows/" . $showDetails ["id"]
				];
				if ($counter > 9) {
					break;
				} else {
					array_push ( $topShows, $show );
					$counter ++;
				}
			}
				
			foreach ( $tastemakerResponse ["results"] as $show ) {
	
				$showDetails = ApiUtility::getPodcast ( $show ["id"] );
				DbUtility::insertTopPodcast ( $showDetails, 0, 1 );
				$show = [
						"as_id" => $showDetails ["id"],
						"title" => $showDetails ["title"],
						"image_url" => Helper::getArtworkImage ( $showDetails ),
						"resource" => "shows/" . $showDetails ["id"]
				];
				array_push ( $tastemakers, $show );
			}
		} else {
			$topShows = DbUtility::getTopShows ();
			$tastemakers = DbUtility::getTastemakers ();
		}
	
		return [
			"topShows" => $topShows,
			"tastemakers" => $tastemakers
		];
	}
	
	public function getPodcast($id) {
		$subscribed = false;
	
		// Check if the podcast is in the DB.
		$dbPodcast = Podcast::where ( "as_id", $id )->first ();
	
		if (Auth::check ()) {
			$userId = Auth::id ();
				
			$subscribed = false;
			$isSubbed = null;
				
			if ($dbPodcast == null) {
				$subscribed = false;
			} else {
				$isSubbed = subscription::where ( [
						"user_id" => $userId,
						"podcast_id" => $dbPodcast->id
				] )->first ();
				$subscribed = ($isSubbed !== null) ? true : false;
			}
		}
	
		// Retrieve podcast details from API.
		$wsPodcast = ApiUtility::getPodcast ($id);
		$dbPodcast = DbUtility::insertPodcast ($wsPodcast);
	
		// Get the id of the podcast.
		$podcastId = $dbPodcast->id;
	
		$image = ($dbPodcast === null) ? $wsPodcast ["image_files"] [0] ["url"] ["full"] : $dbPodcast->image_url;
	
		$episodes = $this->getRecentEpisodes ($id, $dbPodcast, $wsPodcast, $podcastId);
	
		return [
			"show" => $dbPodcast,
			"image" => $image,
			"episodes" => $episodes,
			"podcastId" => $podcastId,
			"subscribed" => $subscribed
		];
	}
	
	public function getRecentEpisodes($id, $dbPodcast, $wsPodcast, $dbPodcastId) {
		$episodes = [];
		$totalEpisodes = $dbPodcast->total_episodes;
		$filesToGet = ($totalEpisodes > 10) ? 10 : $totalEpisodes;
	
		for($i = 0; $i < $filesToGet; $i ++) {
				
			$episodeId = $wsPodcast ["episode_ids"] [$i];
				
			$dbEpisode = Episode::where ( "as_id", $episodeId )->first ();
			$episode = null;
				
			if ($dbEpisode === null) {
				$episodeListing = ApiUtility::getEpisode($episodeId);
				$episode = DbUtility::insertEpisode($dbPodcastId, $episodeListing);
				$episode["episode_num"] = $i + 1;
				$episode["length"] = gmdate("H:i:s", $episodeListing ["duration"]);
				$episode["published"] = gmdate("m/d/Y", strtotime($episodeListing["date_created"]));
			} else {
				$episode = [
					"title" => $dbEpisode->title,
					"description" => $dbEpisode->description,
					"source" => $dbEpisode->source,
					"episode_num" => $i + 1,
					"length" => gmdate("H:i:s", $dbEpisode->duration),
					"published" => gmdate("m/d/Y", strtotime($dbEpisode->pub_date))
				];
			}
				
			array_push($episodes, $episode);
		}
	
		uasort($episodes, array($this, 'comparePublishedDates'));
		$episodes = array_reverse($episodes);
		return $episodes;
	}
	
	public function getAllEpisodes($id) {
		$show = Podcast::where ( "as_id", $id )->first ();
	
		// Retrieve podcast details from API.
		$wsPodcast = ApiUtility::getPodcast ( $show->as_id );
		$wsEpisodes = $wsPodcast ["episode_ids"];
	
		// Diff current catalogue against web service catalogue.
		if ($show !== null) {
			$storedEpisodes = Episode::where ( "podcast_id", $show->id )->get ();
			foreach ( $storedEpisodes as $episode ) {
				if (in_array ( $episode->as_id, $wsEpisodes )) {
					$key = array_search ( $episode->as_id, $wsEpisodes );
					unset ( $wsEpisodes [$key] );
				}
			}
		}
	
		$totalEpisodes = count ( $wsEpisodes );
	
		if ($totalEpisodes > 0) {
			foreach ( $wsEpisodes as $episode ) {
				$episodeListing = ApiUtility::getEpisode ( $episode );
				$episode = DbUtility::insertEpisode ( $show->id, $episodeListing );
			}
		}
	
		return json_encode([
			"code" => 200,
			"message" => "successfully updated episode catalogue"
		]);
	}
	
	public function getPagedEpisodes($id, $page) {
		$pageNum = $page;
		Paginator::currentPageResolver(function() use($page) {
			return $page;
		});
	
			$page = [];
			$podcast = Podcast::where ("as_id", $id)->first ();
			$episodes = Episode::where ("podcast_id", $podcast->id)->orderBy("pub_date", "DESC")->paginate(10);
			$i = ($pageNum == 2)?10:($pageNum*10);
	
			foreach ($episodes as $episode) {
				$item = [
					"title" => $episode->title,
					"description" => $episode->description,
					"source" => $episode->source,
					"episode_num" => ++$i,
					"length" => gmdate ( "H:i:s", $episode->duration ),
					"published" => gmdate("m/d/Y", strtotime($episode->pub_date))
				];
				array_push($page, $item);
			}
			
			uasort($page, array($this, 'comparePublishedDates'));
			$page = array_reverse($page);
	
			return json_encode(["episodes" => $page], JSON_UNESCAPED_SLASHES);
	}
	
	public function getTotalEpisodePages($id) {
		$podcast = Podcast::where ("as_id", $id)->first ();
		$episodes = Episode::where ("podcast_id", $podcast->id)->orderBy("pub_date", "DESC")->paginate(10);
		return $episodes->lastPage();
	}
	
	/**
	 * Get an individual show's data and its most recent episodes
	 *
	 * @param integer $id
	 */
	public function refreshPodcast($id) {
	
		// Check if the podcast is in the DB.
		$show = Podcast::where ("id", $id)->first();
	
		// Retrieve podcast details from API.
		$podcast = ApiUtility::getPodcast($show->as_id);
	
		$episodes = [];
		$totalEpisodes = $podcast["number_of_episodes"];
		$filesToGet = ($totalEpisodes > 10) ? 10 : $totalEpisodes;
	
		for($i = 0; $i < $filesToGet; $i ++) {
				
			$episodeId = $podcast["episode_ids"][$i];
			$episode = null;
				
			$episodeListing = ApiUtility::getEpisode($episodeId);
			$episode = DbUtility::insertEpisode ($id, $episodeListing);
				
			$episodeItem = [
				"title" => $episode["title"],
				"description" => $episode["description"],
				"source" => $episode["source"],
				"episode_num" => $i + 1
			];
				
			array_push($episodes, $episodeItem);
		}
	
		return [
			"episodes" => $episodes
		];
	}
	
	public function refreshPodcastArtwork($id) {
		$podcastData = ApiUtility::getPodcast($id);
		if (empty($podcastData["error"])) {
			$image = $podcastData["image_files"][0]["url"]["full"];
			if ($image) {
				DbUtility::updateArtwork($id, $image);
				return ["message" => "Image recovered successfully", "image" => $image, "code" => 200];
			}
		} else {
			return ["message" => "Image ".$podcastData["error"], "image" => null, "code" => $podcastData["status"]];
		}
	}
	
	public function getRandomPodcast() {
		return Podcast::all()->random(1);
	}
	
	private function comparePublishedDates($a, $b) {
		//return strnatcmp($a["published"], $b["published"]);
		return strtotime($a["published"]) - strtotime($b["published"]);
	}
}
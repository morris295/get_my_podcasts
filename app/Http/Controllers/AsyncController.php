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
use Illuminate\Pagination\Paginator;
use \DateTime;

class AsyncController extends Controller {
	public function __construct() {
		ApiUtility::init ();
	}
	
	/**
	 * Endpoint to retrieve front-page content.
	 */
	public function getIndexContent() {
		$data = $this->getTopShows ();
		
		return View::make ( 'async.index', $data )->render ();
	}
	
	/**
	 * Endpoint to retrieve show content.
	 * 
	 * @param unknown $id        	
	 */
	public function getShowContent($id) {
		$data = $this->getShow ( $id );
		
		return View::make ( 'async.show', $data )->render ();
	}
	
	/**
	 * Endpoint to subscribe to a podcast.
	 */
	public function subscribeUser() {
		$user = Input::get ( "user_id" );
		$show = Input::get ( "podcast_id" );
		
		DbUtility::subscribeUser ( $show, $user );
		
		return json_encode ( [ 
				"code" => 200,
				"message" => "",
				"data" => "" 
		] );
	}
	
	/**
	 * Endpoint to unsubscribe from a podcast.
	 */
	public function unsubscribeUser() {
		$user = Input::get ( "user_id" );
		$show = Input::get ( "podcast_id" );
		
		DbUtility::unsubscribeUser ( $show, $user );
		
		return json_encode ( [ 
				"code" => 200,
				"message" => "",
				"data" => "" 
		] );
	}
	
	/**
	 * Get the most recent episodes for a subscription
	 * 
	 * @param unknown $id        	
	 */
	public function refreshSubscription($id) {
		$data = $this->refreshShow ( $id );
		
		return View::make ( 'async.subscription.episodes', $data )->render ();
	}
	
	public function artworkImage() {
		$show = Podcast::all()->random(1);
		$image = $show->image_url;
		$link = $show->resource;
		$metaId = $show->as_id;
		$data = [ 
				"image" => $image,
				"resource" => $link,
				"dataValue" => $metaId
		];
		return json_encode ( $data, JSON_UNESCAPED_SLASHES );
	}
	
	public function getAllPodcastEpisodes($id) {
		$data = $this->getAllEpisodes ( $id );
		
		// return View::make('async.episodes', $data)->render();
		return $data;
	}
	
	public function getEpisodePages($id, $page) {
		$data = $this->getPagedEpisodes ( $id, $page );
		return View::make ( 'async.episodes', $data )->render ();
	}
	
	public function recoverArtwork($id) {
		$imgSource = $this->refreshArtwork($id);
		$data = [
			"code" => 200,
			"image" => $imgSource,
			"message" => "Image recovered successfully"
		];
		return json_encode($data, JSON_UNESCAPED_SLASHES);
	}
	
	/**
	 * Get top shows for front-page content.
	 */
	private function getTopShows() {
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
	
	/**
	 * Get an individual show's data and its most recent episodes
	 * 
	 * @param integer $id        	
	 */
	private function refreshShow($id) {
		
		// Check if the podcast is in the DB.
		$show = Podcast::where ( "id", $id )->first ();
		
		// Retrieve podcast details from API.
		$podcast = ApiUtility::getPodcast ( $show->as_id );
		
		$episodes = [ ];
		$totalEpisodes = $podcast ["number_of_episodes"];
		$filesToGet = ($totalEpisodes > 10) ? 10 : $totalEpisodes;
		
		for($i = 0; $i < $filesToGet; $i ++) {
			
			$episodeId = $podcast ["episode_ids"] [$i];
			$episode = null;
			
			$episodeListing = ApiUtility::getEpisode ( $episodeId );
			$episode = DbUtility::insertEpisode ( $id, $episodeListing );
			
			$episodeItem = [ 
					"title" => $episode["title"],
					"description" => $episode["description"],
					"source" => $episode["source"],
					"episode_num" => $i + 1 
			];
			
			array_push ( $episodes, $episodeItem );
		}
		
		return [ 
				"episodes" => $episodes 
		];
	}
	
	private function getShow($id) {
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
		$wsPodcast = ApiUtility::getPodcast ( $id );
		$dbPodcast = DbUtility::insertPodcast ( $wsPodcast );
		
		// Get the id of the podcast.
		$podcastId = $dbPodcast->id;
		
		$image = ($dbPodcast === null) ? $wsPodcast ["image_files"] [0] ["url"] ["full"] : $dbPodcast->image_url;
		
		$episodes = $this->getRecentEpisodes ( $id, $dbPodcast, $wsPodcast, $podcastId );
		
		return [ 
				"show" => $dbPodcast,
				"image" => $image,
				"episodes" => $episodes,
				"podcastId" => $podcastId,
				"subscribed" => $subscribed 
		];
	}
	
	private function getRecentEpisodes($id, $dbPodcast, $wsPodcast, $dbPodcastId) {
		$episodes = [ ];
		$totalEpisodes = $dbPodcast->total_episodes;
		$filesToGet = ($totalEpisodes > 10) ? 10 : $totalEpisodes;
		
		for($i = 0; $i < $filesToGet; $i ++) {
			
			$episodeId = $wsPodcast ["episode_ids"] [$i];
			
			$dbEpisode = Episode::where ( "as_id", $episodeId )->first ();
			$episode = null;
			
			if ($dbEpisode === null) {
				$episodeListing = ApiUtility::getEpisode ( $episodeId );
				$episode = DbUtility::insertEpisode ( $dbPodcastId, $episodeListing );
				$episode ["episode_num"] = $i + 1;
				$episode ["length"] = gmdate ( "H:i:s", $episodeListing ["duration"] );
			} else {
				$episode = [ 
						"title" => $dbEpisode->title,
						"description" => $dbEpisode->description,
						"source" => $dbEpisode->source,
						"episode_num" => $i + 1,
						"length" => gmdate ( "H:i:s", $dbEpisode->duration ) 
				];
			}
			
			array_push ( $episodes, $episode );
		}
		
		return $episodes;
	}
	
	private function getAllEpisodes($id) {
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
		
		return json_encode ( [ 
				"code" => 200,
				"message" => "successfully updated episode catalogue" 
		] );
	}
	
	private function getPagedEpisodes($id, $page) {
		Paginator::currentPageResolver ( function () use ($page) {
			return $page;
		} );
		
		$page = [ ];
		$podcast = Podcast::where ( "as_id", $id )->first ();
		$episodes = Episode::where ( "podcast_id", $podcast->id )->paginate ( 10 );
		$i = 0;
		
		foreach ( $episodes as $episode ) {
			$item = [ 
					"title" => $episode->title,
					"description" => $episode->description,
					"source" => $episode->source,
					"episode_num" => $i + 1,
					"length" => gmdate ( "H:i:s", $episode->duration ) 
			];
			array_push ( $page, $item );
		}
		
		return [ 
				"episodes" => $page 
		];
	}
	
	private function refreshArtwork($id) {
		$podcastData = ApiUtility::getPodcast($id);
		$image = $podcastData["image_files"][0]["url"]["full"];
		if ($image) {
			DbUtility::updateArtwork($id, $image);
			return $image;
		}
	}
}
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\subscription;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use App\Libraries\Model\PodcastWorker;
use App\Libraries\Model\UserWorker;
use \Illuminate\Http\Response;

class WebApiController extends Controller {
	
	/**
	 * Internal Podcast Model.
	 * @var unknown
	 */
	protected $podcastWorker;
	
	/**
	 * Internal User Model.
	 * @var unknown
	 */
	protected $userWorker;
	
	public function __construct() {
		$this->podcastWorker = new PodcastWorker();
		$this->userWorker = new UserWorker();
	}
	
	/**
	 * Endpoint to retrieve front-page content.
	 */
	public function getIndexContent() {
		$data = $this->podcastWorker->getTopPodcasts();
		
		return View::make('async.index', $data)->render();
	}
	
	/**
	 * Endpoint to retrieve show content.
	 *
	 * @param unknown $id
	 */
	public function getShowContent($id) {
		$data = $this->podcastWorker->getPodcast($id);
	
		return View::make ('async.show', $data)->render();
	}
	
	/**
	 * Endpoint to subscribe to a podcast.
	 */
	public function subscribeUser() {
		$user = Input::get("user_id");
		$podcast = Input::get("podcast_id");
	
		$this->userWorker->subscribeUser($podcast, $user);
		
		return response()->json([
			"message" => "User subscribed successfully.",
			], 200);
		
		//TODO: Add try/catch for error checking.
	}
	
	/**
	 * Endpoint to unsubscribe from a podcast.
	 */
	public function unsubscribeUser() {
		$user = Input::get("user_id");
		$podcast = Input::get("podcast_id");
	
		$this->userWorker->unsubscribeUser($podcast, $user);

		return response()->json(["message" => "User unsubscribed"], 200);
		
		//TODO: Add try/catch for error checking.
	}
	
	/**
	 * Get the most recent episodes for a subscription
	 *
	 * @param unknown $id
	 */
	public function refreshSubscription($id) {
		$data = $this->podcastWorker->refreshPodcast($id);
	
		return View::make('async.subscription.episodes', $data)->render();
	}
	
	public function artworkImage() {
		$podcast = $this->podcastWorker->getRandomPodcast();
		$image = $podcast->image_url;
		$link = $podcast->resource;
		$metaId = $podcast->as_id;
		
		$data = [
			"image" => $image,
			"resource" => $link,
			"dataValue" => $metaId
		];

		response()->json($data);
	}
	
	public function getAllPodcastEpisodes($id) {
		$data = $this->podcastWorker->getAllEpisodes($id);
		return $data;
	}
	
	public function getLatestEpisode($id) {
		$data = $this->podcastWorker->getLatestEpisode($id);
		return $data;
	}
	
	public function getEpisodePages($id, $page) {
		$data = $this->podcastWorker->getPagedEpisodes($id, $page);
		return $data;
	}
	
	public function getTotalEpisodePages($id) {
		return $this->podcastWorker->getTotalEpisodePages($id);
	}
	
	public function recoverArtwork($id) {
		$result = $this->podcastWorker->refreshPodcastArtwork($id);
		return response()->json($result, $result["code"]);
	}
	
	public function getRelated($id) {
		$result = $this->podcastWorker->getRelatedPodcasts($id);
		return response()->json($result);
	}
}

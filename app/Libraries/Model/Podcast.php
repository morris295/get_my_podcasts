<?php

namespace App\Libraries\Model;

use \DateTime;
use \Requests;
use App\Libraries\Utility\ApiUtility;
use App\Libraries\Utility\ColorThiefUtility;
use App\Libraries\Utility\DbUtility;
use App\Model\Episode;
use App\Model\Podcast;
use App\Model\Playlist;
use App\Model\subscription;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class PodcastWorker {
	
	public function __construct() {
		ApiUtility::init();
	}
	
	public function getTopPodcasts() {
		$lastUpdated = new DateTime (Podcast::where("top_show", 1)->max ("last_top_show_date"));
		$sevenDaysAgo = new DateTime ("-7 days");
		$interval = $lastUpdated->diff($sevenDaysAgo);
	
		$topShows = [];
		$tastemakers = [];
	
		if ($lastUpdated == null || $interval->days >= 7) {
				
			$lastWeek = date ("Y-m-d", strtotime("-7 days"));
				
			$topShowsResponse = ApiUtility::getTopShows($lastWeek);
				
			foreach ($topShowsResponse["shows"] as $show) {
				$showDetails = ApiUtility::getPodcast($show["id"]);
				$topShow = DbUtility::insertTopPodcast($showDetails, 1, 0);
				array_push ($topShows, $topShow);
			}
		} else {
			$topShows = DbUtility::getTopShows();
			foreach ($topShows as $show) {
				$count = DbUtility::getEpisodeCount($show->id);
				if ($count > 0) {
					$show->total_episodes = $count;
				}
			}
		}
	
		return [
			"topShows" => $topShows,
		];
	}
	
	public function getPodcast($id) {
		$subscribed = false;
	
		// Check if the podcast is in the DB.
		$dbPodcast = Podcast::where ( "as_id", $id )->first();
	
		if (Auth::check()) {
			$userId = Auth::id ();
				
			$subscribed = false;
			$isSubbed = null;
				
			if ($dbPodcast == null) {
				$subscribed = false;
			} else {
				$isSubbed = subscription::where([
						"user_id" => $userId,
						"podcast_id" => $dbPodcast->id
				])->first();
				$subscribed = ($isSubbed !== null) ? true : false;
			}
		}
	
		// Retrieve podcast details from API.
		$wsPodcast = ApiUtility::getPodcast($id);
		$related = ApiUtility::getCategories($id);
		$categories = [];
		
		foreach ($related as $item) {
			foreach ($item["categories"] as $category) {
				if (!in_array($category["name"], $categories)) {
					$categories[] = $category["name"];
				}
			}
		}
		
		DbUtility::insertCategories($id, $categories);
		
		$wsPodcast["categories"] = $categories;
		$dbPodcast = DbUtility::insertPodcast($wsPodcast);
		
		// Get the id of the podcast.
		$podcastId = $dbPodcast->id;
	
		$image = ($dbPodcast === null)?$wsPodcast["image_files"][0]["url"]["full"]:$dbPodcast->image_url;
		$colors = ColorThiefUtility::getPrimaryColor($image);
		$imageCheck = Requests::get($image);
		$followers = subscription::where("podcast_id", $podcastId)->count();

		if ($imageCheck->status_code !== 200) {
			$image = URL::to('/') . "/image/play.png";
		}
	
		$episodes = $this->getRecentEpisodes($id, $dbPodcast, $wsPodcast, $podcastId);
	
		return [
			"show" => $dbPodcast,
			"image" => $image,
			"primaryColor" => $colors["primaryColor"],
			"contrast" => $colors["contrast"],
			"episodes" => $episodes,
			"podcastId" => $podcastId,
			"subscribed" => $subscribed,
			"followers" => $followers
		];
		
	}
	
	public function getRecentEpisodes($id, $dbPodcast, $wsPodcast, $dbPodcastId) {
		$episodes = [];
		$totalEpisodes = count($wsPodcast["episode_ids"]);
		$filesToGet = ($totalEpisodes > 20) ? 20 : $totalEpisodes;
	
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
	
	public function getLatestEpisode($id) {
		$episode = null;
		
		$podcast = ApiUtility::getPodcast($id);
		$dbPodcast = DbUtility::insertPodcast($podcast);
		$podcastId = $dbPodcast->id;
		
 		$episodeId = $podcast["episode_ids"][0];
		
		if ($episodeId) {
			$episode = ApiUtility::getEpisode($episodeId);
			$response = DbUtility::insertEpisode($podcastId, $episode);
			return json_encode([ "showTitle" => $podcast["title"], "episode" => $response ]);
		} else {
			$response = new stdClass();
			$response->code = "400";
			$response->message = "Unable to find episode.";
			$response->data = null;
			return json_encode($response);
		}
	}
	
	public function getAllEpisodes($id) {
		$show = Podcast::where("as_id", $id)->first();
	
		// Retrieve podcast details from API.
		$wsPodcast = ApiUtility::getPodcast($show->as_id);
		$wsEpisodes = $wsPodcast["episode_ids"];
		$retEpisodes = [];
	
		// Diff current catalogue against web service catalogue.
		if ($show !== null) {
			$storedEpisodes = Episode::where("podcast_id", $show->id)->get();
			foreach ($storedEpisodes as $episode) {
				if (in_array($episode->as_id, $wsEpisodes)) {
					$key = array_search($episode->as_id, $wsEpisodes);
					unset($wsEpisodes[$key]);
				}
			}
		}
	
		$totalEpisodes = count($wsEpisodes);
	
		if ($totalEpisodes > 0) {
			foreach ($wsEpisodes as $episode) {
				$episodeListing = ApiUtility::getEpisode($episode);
				DbUtility::insertEpisode($show->id, $episodeListing);
			}
		}
		
		$data = DB::table('episodes')->
			select(DB::raw('title, DATE_FORMAT(pub_date,\'%m/%d/%Y\') as \'published\', source, SEC_TO_TIME(duration*60) as \'length\', id as episode_num'))->
			where("podcast_id", $show->id)->
			orderBy("pub_date", "DESC")->
			orderBy("title", "DESC")->
			get();
	
		return json_encode([
			"code" => 200,
			"message" => "successfully updated episode catalogue",
			"data" => $data
		]);
	}
	
	public function getPagedEpisodes($id, $page) {
		$pageNum = $page;
		Paginator::currentPageResolver(function() use($page) {
			return $page;
		});
	
			$page = [];
			$podcast = Podcast::where ("as_id", $id)->first ();
			$max = Episode::where ("podcast_id", $podcast->id)->orderBy("pub_date", "DESC")->count();
			$episodes = Episode::where("podcast_id", $podcast->id)->orderBy("pub_date", "DESC")->paginate(10);
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
				$request = Requests::get($image);

				if ($request->status_code !== 200) {
					return ["message" => "Image not found", "image" => null, "code" => $request->status_code];
				} else {
					DbUtility::updateArtwork($id, $image);
					return ["message" => "Image recovered successfully", "image" => $image, "code" => 200];
				}
			}
			
		} else {
			return ["message" => "Image ".$podcastData["error"], "image" => null, "code" => $podcastData["status"]];
		}
	}
	
	public function getRelatedPodcasts($id) {
		$query = "select distinct p.title, p.description," .
		" p.image_url, p.resource from podcasts as p inner join" .
		" podcast_category as pc on p.as_id = pc.podcast_id WHERE" .
		" pc.category_id in (SELECT distinct category_id FROM" . 
		" get_my_podcasts.podcast_category WHERE podcast_id = {$id})" .
		" ORDER BY RAND() LIMIT 5;";
		
		$result = DB::select(DB::raw($query));
		return $result;
	}
	
	public function getRandomPodcast() {
		return Podcast::all()->random(1);
	}
	
	public function getGenres() {
		$query = "select distinct c.id as `id`, `name`, MIN(p.image_url) as `image`" .
				" from categories as c".
				" Inner Join podcast_category as pc on pc.category_id = c.id" .
				" Left Join podcasts as p on pc.podcast_id = p.id" .
				" where p.image_url is not null" .
				" group by `name`;";
				
		$result = DB::select(DB::raw($query));
		return $result;
	}
	
	public function getShowsByGenre($id) {
		$query = "select p.*" .
				 " from podcasts as p" .
				 " Inner Join podcast_category as pc on p.id = pc.podcast_id".
			     " Where pc.category_id = $id;";
		
		$result = DB::select(DB::raw($query));
		return $result;
	}
	
	private function comparePublishedDates($a, $b) {		
		return strtotime($a["published"]) - strtotime($b["published"]);
	}
}
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Episode;
use App\Model\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Libraries\Utility\ApiUtility;
use Illuminate\Support\Facades\Auth;
use App\Model\Podcast;
use App\Libraries\Model\PodcastWorker;

class AccountController extends Controller {
	
	protected $podcastWorker;

	public function __construct() {
		$this->podcastWorker = new PodcastWorker();
	}
	
	public function index($userId) {
		if (Auth::guest()) {
			return redirect('/');
		}
		
		$followed = $this->getSubscriptions($userId);
		$followingShows = $this->compileShows($followed);
		$top = $this->getTopPodcasts();
		
		return view ('account', [
				'userSubs' => $followingShows,
				"totalFollowing" => count($followingShows), 
				"topShows" => $top
		]);
	}
	
	private function getTopPodcasts() {
		return Podcast::where("top_show", 1)
			->select("title", "resource", "image_url")
			->orderBy(DB::raw("RAND()"))
			->limit(10)
			->get()
			->toArray();
	}
	
	private function getSubscriptions($id) {
		return DB::table('subscriptions')
			->join('users', 'users.id', '=', 'subscriptions.user_id')
			->join('podcasts', 'podcasts.id', '=', 'subscriptions.podcast_id')
			->where('subscriptions.user_id', $id)
			->select ('podcasts.id',
				'podcasts.title',
				'podcasts.image_url',
				'podcasts.as_id',
				'podcasts.resource')
			->get();
	}
	
	private function compileShows($shows) {
		$compiledShows = [ ];
		
		$i = 0;
		$j = 0;
		$row = 1;
		foreach ( $shows as $show ) {
			$episodes = DB::table('episodes')
				->where('podcast_id', $show->id)
				->orderBy('pub_date', 'DESC')
				->select ('title', 'source')->take(10)->get();
			
			$podcast = new \stdClass ();
			$podcast->id = $show->id;
			$podcast->title = $show->title;
			$podcast->image_url = $show->image_url;
			$podcast->podcast_num = $i;
			$podcast->as_id = $show->as_id;
			$podcast->resource = $show->resource;
			$podcast->episodes = [];
			
			foreach ( $episodes as $episode ) {
				array_push ( $podcast->episodes, [ 
						"episode_title" => $episode->title,
						"audio_link" => $episode->source,
						"episode_num" => $j 
				] );
				$j ++;
			}
			
			array_push ( $compiledShows, $podcast );
			$i ++;
		}
		
		return $compiledShows;
	}
}
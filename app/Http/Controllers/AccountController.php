<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Episode;
use App\Model\subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Libraries\Utility\ApiUtility;

class AccountController extends Controller {
	
	public function __construct() {
		//Default constructor.
	}
	
	public function index($userId) {
		$subs = $this->getSubscriptions($userId);
		$subscriptions = $this->compileShows($subs);
		
// 		echo "<pre>";
// 		print_r($subscriptions);
// 		echo "</pre>";
// 		exit;
		
		return view('account', ['userSubs' => $subscriptions]);
	}
	
	private function getSubscriptions($id) {
		return DB::table('subscription')
			->join('users', 'users.id', '=', 'subscription.user_id')
			->join('podcasts', 'podcasts.id', '=', 'subscription.podcast_id')
			->where('subscription.user_id', $id)
			->select('podcasts.id', 'podcasts.title', 'podcasts.image_url')
			->get();
	}
	
	public function subscribeUser() {
		$user = Input::get("user_id");
		$show = Input::get("podcast_id");
		
		subscription::create(["user_id" => $user, "podcast_id" => $show]);
		
		return json_encode(["code" => 200, "message" => "", "data" => ""]);
	}
	
	private function compileShows($shows) {
		
		$compiledShows = [];
		
		$i = 0;
		$j = 0;
		foreach ($shows as $show) {
			$episodes = DB::table('episodes')
			->where('podcast_id', $show->id)
			->select('title', 'source')
			->take(5)
			->get();
			
			$podcast = new \stdClass();
			$podcast->title = $show->title;
			$podcast->image_url = $show->image_url;
			$podcast->podcast_num = $i;
			$podcast->episodes = [];
			
			foreach ($episodes as $episode) {
				array_push($podcast->episodes, [
					"episode_title" => $episode->title,
					"audio_link" => $episode->source,
					"episode_num" => $j
				]);
				$j++;
			}
			
			array_push($compiledShows, $podcast);
			$i++;
		}
		
		return $compiledShows;
	}
}
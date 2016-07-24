<?php

namespace App\Libraries\Utility;

use App\Libraries\Audiosearch\lib\Audiosearch\Audiosearch_Client;

class ApiUtility {
	private static $audiosearchClient;
	public static function init() {
		self::$audiosearchClient = Audiosearch_Client::getInstance ();
	}
	public static function getPodcast($id) {
		return self::$audiosearchClient->get_show ( $id );
	}
	public static function getEpisode($id) {
		return self::$audiosearchClient->get_episode ( $id );
	}
	public static function getTopShows($yesterday) {
		return self::$audiosearchClient->get ( "chart_daily?start_date=$yesterday&limit=10&country=us" );
	}
	public static function getTastemakers() {
		return self::$audiosearchClient->get_tastemakers ( [ 
				"n" => "10",
				"type" => "shows" 
		] );
	}
	public static function getSearch($term) {
		return self::$audiosearchClient->get ( "search/shows/$term" );
	}
}

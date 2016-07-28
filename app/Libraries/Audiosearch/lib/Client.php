<?php

namespace App\Libraries\Audiosearch\lib\Audiosearch;

use \Exception;
use Requests;
use Requests_Session;

/*
 * PHP Client for Audiosear.ch API
 * Copyright 2015 Pop Up Archive
 * Licensed under the Apache 2 terms -- see LICENSE
 */
class Audiosearch_Client {
	private $access_token;
	private $host;
	private $version = '1.0.1';
	private $user_agent = 'audiosearch-client-php';
	private static $instance;
	
	/**
	 *
	 * @param unknown $args
	 *        	(optional)
	 */
	protected function __construct($args = array()) {
		$client_key = isset ( $args ['id'] ) ? $args ['id'] : (isset ( $args ['key'] ) ? $args ['key'] : getenv ( 'AS_ID' ));
		$client_secret = isset ( $args ['secret'] ) ? $args ['secret'] : getenv ( 'AS_SECRET' );
		$this->host = isset ( $args ['host'] ) ? $args ['host'] : (getenv ( 'AS_HOST' ) ? getenv ( 'AS_HOST' ) : 'https://www.audiosear.ch');
		
		if (! $client_key or ! $client_secret) {
			throw new Exception ( "Must define client key and secret" );
		}
		
		// get auth token
		$signature = base64_encode ( "$client_key:$client_secret" );
		$auth_url = $this->host . '/oauth/token';
		$params = array (
				'grant_type' => 'client_credentials' 
		);
		$resp = Requests::post ( $auth_url, array (
				'Authorization' => "Basic $signature" 
		), $params );
		$resp_json = json_decode ( $resp->body );
		$this->access_token = $resp_json->access_token;
		
		// create persistent agent for convenience
		$this->agent = new Requests_Session ( $this->host );
		$this->agent->useragent = $this->user_agent . '/' . $this->version;
		$this->agent->headers ['Authorization'] = "Bearer " . $this->access_token;
		
		static::$instance = $this->agent;
	}
	
	/**
	 *
	 * @param string $path        	
	 * @param array $params
	 *        	(optional)
	 * @return object
	 */
	public function get($path, $params = false) {
		$uri = $path;
		if (! preg_match ( '/^https?:/', $uri )) {
			$uri = sprintf ( "%s/api/%s", $this->host, $path );
		}
		if ($params) {
			$uri .= '?' . http_build_query ( $params );
		}
		$resp = $this->agent->get ( $uri );
		return json_decode ( $resp->body, true );
	}
	
	/**
	 *
	 * @param integer $show_id        	
	 * @return unknown
	 */
	public function get_show($show_id) {
		return $this->get ( "/shows/$show_id" );
	}
	
	/**
	 *
	 * @param integer $ep_id        	
	 * @return unknown
	 */
	public function get_episode($ep_id) {
		return $this->get ( "/episodes/$ep_id" );
	}
	
	/**
	 *
	 * @param array $params        	
	 * @param string $type
	 *        	(optional) defaults to 'episodes'
	 * @return object
	 */
	public function search($params, $type = 'episodes') {
		return $this->get ( "/search/$type", $params );
	}
	
	/**
	 *
	 * @return unknown
	 */
	public function get_trending() {
		return $this->get ( "/trending" );
	}
	
	/**
	 *
	 * @return unknown
	 */
	public function get_tastemakers($params = array()) {
		$type = (array_key_exists ( 'type', $params ) ? $params ['type'] : 'episodes');
		$n = (array_key_exists ( 'n', $params ) ? $params ['n'] : '10');
		return $this->get ( "/tastemakers/$type/$n" );
	}
	
	/**
	 *
	 * @param integer $p_id        	
	 * @return unknown
	 */
	public function get_person($p_id) {
		return $this->get ( "/people/$p_id" );
	}
	
	/**
	 *
	 * @param integer $id        	
	 * @param array $params        	
	 * @return unknown
	 */
	public function get_related($id, $params = array()) {
		$type = (array_key_exists ( 'type', $params ) ? $params ['type'] : 'episodes');
		return $this->get ( "/$type/$id/related", $params );
	}
	
	/**
	 * Retrieve client instance.
	 */
	public static function getInstance() {
		if (static::$instance == null) {
			static::$instance = new static ();
		}
		
		return static::$instance;
	}
}

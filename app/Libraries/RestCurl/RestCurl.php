<?php

namespace App\Libraries;

use App\Libraries\ExternalService\ExternalResponse;

/**
 * PHP Rest CURL
 * https://github.com/jmoraleda/php-rest-curl
 * (c) 2014 Jordi Moraleda
 */
Class RestCurl {

	private static $curl;
	
	private static $response;
	
	/**
	 * Exec method, handles submitting curl requests.
	 */
	public static function exec($method, $url, $obj = array(), $customHeaders = array()) {
	
		$curl = curl_init();
		 
		switch($method) {
			case 'GET':
				if(strrpos($url, "?") === FALSE) {
					$url .= '?' . http_build_query($obj);
				}
				break;

			case 'POST':
				curl_setopt($curl, CURLOPT_POST, TRUE);
				curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($obj));
				break;

			case 'PUT':
			case 'DELETE':
			default:
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method)); // method
				curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($obj)); // body
		}

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($curl, CURLOPT_ENCODING, "gzip, deflate");
		//curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3");
		/*curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json',
		 'Content-Type: application/json')); */
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, TRUE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
		
		curl_setopt($curl, CURLOPT_HTTPHEADER, $customHeaders);

		// Exec
		$result = curl_exec($curl);

		if(curl_error($curl) != '') {
			 
			$error = curl_error($curl);
			$response = new ExternalResponse(500, null, null, $error);
			
			return $response;
			 
		} else {

			$info = curl_getinfo($curl);
			curl_close($curl);
			 
			// Data
			$header = trim(substr($result, 0, $info['header_size']));
			$body = substr($result, $info['header_size']);
			
			$response = new ExternalResponse(200, $header, $body);

			return $response;
		}
	}

	/**
	 * Method to handle GET requests.
	 */
	public static function get($url, $obj = array(), $customHeaders = array()) {
		return RestCurl::exec("GET", $url, $obj, $customHeaders);
	}

	/**
	 * Method to handle POST requests.
	 */
	public static function post($url, $obj = array(), $customHeaders = array()) {
		return RestCurl::exec("POST", $url, $obj, $customHeaders);
	}

	/**
	 * Method to handle PUT requests.
	 */
	public static function put($url, $obj = array(), $customHeaders = array()) {
		return RestCurl::exec("PUT", $url, $obj, $customHeaders);
	}

	/**
	 * Method to handle DELETE requests.
	 */
	public static function delete($url, $obj = array(), $customHeaders = array()) {
		return RestCurl::exec("DELETE", $url, $obj, $customHeaders);
	}
}
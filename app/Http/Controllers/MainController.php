<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\RestCurl;
use \SimpleXMLElement;
use App\Libraries\FeedParser;

class MainController extends Controller {
	
	public function index() {
		
		$result = new SimpleXMLElement(
				RestCurl::get("http://feeds.feedburner.com/SModcasts?format=xml")->getContent());
		
		FeedParser::parse($result);	
	
		var_dump($result);
	}
	
}
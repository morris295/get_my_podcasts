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
		
		return view('index');
	}
	
	public function about() {
		return view('about');
	}
	
	public function contact() {
		return view('contact');
	}
	
}
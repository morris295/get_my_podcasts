<?php

namespace App\Libraries\Model;

use App\Libraries\Utility\DbUtility;
use App\Model\User;

class User {
	
	public function __construct() {
		//Placeholder, may not be necessary to do anything here.
	}
	
	public function subscribeUser($podcastId, $userId) {
		DbUtility::subscribeUser($podcastId, $userId);
	}
	
	public function unsubscribeUser($podcastId, $userId) {
		DbUtility::unsubscribeUser($podcastId, $userId);
	}
}
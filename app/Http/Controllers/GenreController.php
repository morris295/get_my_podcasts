<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\Model\PodcastWorker;

use App\Http\Requests;

class GenreController extends Controller
{
	protected $podcastWorker;
	
	public function __construct() {
		$this->podcastWorker = new PodcastWorker();
	}
	
	public function getAll() {
		$data = $this->podcastWorker->getGenres();
		$genres = [];
		foreach ($data as $k=>$v) {
			if (in_array($v->name, $genres)) {
				continue;
			}
			$genres[] = ["id" => $v->id, "name" => $v->name, "image" => $v->image];
		}
		return view('genres', ["genres" => $genres]);
	}
	
	public function getGenre($id) {
		$data = $this->podcastWorker->getShowsByGenre($id);
		
		return view('genres', ["genres" => [],"shows" => $data]);
	}
}

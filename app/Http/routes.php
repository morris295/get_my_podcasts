<?php

/*
 * |--------------------------------------------------------------------------
 * | Routes File
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you will register all of the routes in an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 */
Route::controllers ( [ 
		'auth' => 'Auth\AuthController',
		'password' => 'Auth\PasswordController' 
] );

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | This route group applies the "web" middleware group to every route
 * | it contains. The "web" middleware group is defined in your HTTP
 * | kernel and includes session state, CSRF protection, and more.
 * |
 */

Route::get ("/artwork", "WebApiController@artworkImage");
Route::get ("/artwork/refresh/{id}", "WebApiController@recoverArtwork");
Route::get("/player/open/{source}", "WebApiController@openPlayer");

Route::group (['middleware' => 'web'], function (){
	
	Route::auth ();
	
	Route::get("/", "MainController@index");
	Route::get("/about", "MainController@about");
	Route::get("/contact", "MainController@contact");
	Route::get("/shows/{id}", "ShowController@getShow");
	Route::get("/search", "MainController@search");
	Route::get("/my-account/{id}", "AccountController@index");
	Route::get("/genres/", "GenreController@getAll");
	Route::get("/genre/{id}", "GenreController@getGenre");
	
	/* Ajax routes */
	Route::post("/account/subscribe", "WebApiController@subscribeUser");
	Route::post("/account/unsubscribe", "WebApiController@unsubscribeUser");
	Route::get("/index/content", "WebApiController@getIndexContent");
	Route::get("/subscription/refresh/{id}", "WebApiController@refreshSubscription");
	Route::get("/show/get/{id}", "WebApiController@getShowContent");
	Route::get("/show/episodes/{id}", "WebApiController@getAllPodcastEpisodes");
	Route::get("/show/episodes/latest/{id}", "WebApiController@getLatestEpisode");
	Route::get("/show/episodes/paged/{id}/{page}", "WebApiController@getEpisodePages");
	Route::get("/show/episodes/page-count/{id}", "WebApiController@getTotalEpisodePages");
	Route::get("/show/related/{id}", "WebApiController@getRelated");
	
	/* Playlist routes */
	Route::get("/playlists/", "PlaylistsController@getAll");
	Route::get("/playlists/{id}", "PlaylistsController@show");
	Route::post("/playlists/create", "PlaylistsController@create");
	Route::put("/playlists/update/{id}", "PlaylistsController@update");
	Route::delete("/playlists/delete/{id}", "PlaylistsController@destroy");
});

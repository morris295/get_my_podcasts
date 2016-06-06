<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
]);

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    
		Route::auth();

    Route::get("/", "MainController@index");
    Route::get("/about", "MainController@about");
    Route::get("/contact", "MainController@contact");
    Route::get("/shows/{id}", "ShowController@getShow");
    Route::get("/search", "MainController@search");
    Route::get("/my-account/{id}", "AccountController@index");
    
    /*Ajax routes*/
    Route::post("/account/subscribe", "AsyncController@subscribeUser");
    Route::post("/account/unsubscribe", "AsyncController@unsubscribeUser");
    Route::get("/index/content", "AsyncController@getIndexContent");
    Route::get("/subscription/refresh/{id}", "AsyncController@refreshSubscription");
    Route::get("/show/get/{id}", "AsyncController@getShowContent");
    
});

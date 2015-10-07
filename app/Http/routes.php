<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    $listings = \App\Listing::all();
    return view('index')->withListings($listings);
});

Route::resource('listings', 'ListingsController');

Route::get('/search', ['uses' => 'ListingsController@search', 'as' => 'listings.search']);
Route::post('/search', ['uses' => 'ListingsController@search_results', 'as' => 'listings.search_results']);
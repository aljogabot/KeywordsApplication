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

Route::get( '/', [ 'as' => 'keywords', 'uses' => 'KeywordsController@index' ] );

Route::post( '/keywords/preview-selection', [ 'as' => 'keyword-preview-selection', 'uses' => 'KeywordsController@preview' ] );
Route::post( '/keywords/multiplied', [ 'as' => 'keyword-multiplied', 'uses' => 'KeywordsController@multiplied' ] );
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

Route::post( '/keywords/process-user-input', [ 'as' => 'keywords-process-user-input', 'uses' => 'KeywordsController@processUserInput' ] );
Route::post( '/keywords/first-selection-preview', [ 'as' => 'keywords-first-selection-preview', 'uses' => 'KeywordsController@firstSelectionPreview' ] );
Route::post( '/keywords/second-selection-preview', [ 'as' => 'keywords-second-selection-preview', 'uses' => 'KeywordsController@secondSelectionPreview' ] );
Route::post( '/keywords/multiplied', [ 'as' => 'keyword-multiplied', 'uses' => 'KeywordsController@multiplied' ] );
Route::get( '/keywords/save-to-file', [ 'as' => 'keywords-save-to-file', 'uses' => 'KeywordsController@saveToFile' ] );
<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('web/index');
});

Auth::routes();

// Define global parameter patterns
Route::pattern('iCompetitionId', '[0-9]+');
Route::pattern('iMatchId', '[0-9]+');
Route::pattern('iUserId', '[0-9]+');

// Define routes
Route::get('/home', 'HomeController@index')->name('home.index');

Route::group(
	[
		'prefix' => '/{iCompetitionId}',
		'middleware' => 'check-competition'
	],
	function() {
		Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');

		Route::get('/ranking', 'RankingController@index')->name('ranking.index');

		Route::get('/match-predictions/{iMatchId}', 'MatchPredictionController@index')->name('match-predictions.index');

		Route::get('/match-prediction/{iMatchId}', 'MatchPredictionController@edit')->name('match-prediction.edit');

		Route::get('/user-statistics/{iUserId}', 'UserStatisticsController@index')->name('user-statistics.index');
	}
);

Route::post('/match-prediction', 'MatchPredictionController@update')->name('match-prediction.update');




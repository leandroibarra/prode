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

Route::get('/', function() {
    return view('web/index');
})->middleware(['check-locale']);

Auth::routes();

// Define global parameter patterns
Route::pattern('iCompetitionId', '[0-9]+');
Route::pattern('iMatchId', '[0-9]+');
Route::pattern('iUserId', '[0-9]+');

// Define routes
Route::get('/locale/{sLocale}', 'LocaleController@edit')
	->name('locale.edit');

Route::get('/home', 'HomeController@index')
	->name('home.index')
	->middleware([
		'auth',
		'check-locale'
	]);

Route::group(
	[
		'prefix' => '/{iCompetitionId}',
		'middleware' => [
			'auth',
			'check-competition',
			'check-locale'
		]
	],
	function() {
		Route::get('/dashboard', 'DashboardController@index')
			->name('dashboard.index');

		Route::get('/ranking', 'RankingController@index')
			->name('ranking.index');

		Route::get('/match-predictions/{iMatchId}', 'MatchPredictionController@index')
			->name('match-predictions.index')
			->middleware(['check-match-schedule']);

		Route::get('/match-prediction/{iMatchId}', 'MatchPredictionController@edit')
			->name('match-prediction.edit')
			->middleware(['check-match-schedule']);

		Route::post('/match-prediction/{iMatchId}', 'MatchPredictionController@update')
			->name('match-prediction.update')
			->middleware(['check-match-schedule']);

		Route::get('/user-statistics/{iUserId}', 'UserStatisticsController@index')
			->name('user-statistics.index')
			->middleware(['check-user']);
	}
);




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
    return view('index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home.index');

Route::get('/{iCompetitionId}/dashboard', 'DashboardController@index')->name('dashboard.index');

Route::get('/{iCompetitionId}/ranking', 'RankingController@index')->name('ranking.index');

Route::get('/{iCompetitionId}/match-predictions/{iMatchId}', 'MatchPredictionController@index')->name('match-predictions.index');

Route::get('/{iCompetitionId}/match-prediction/{iMatchId}', 'MatchPredictionController@edit')->name('match-prediction.edit');

Route::post('/match-prediction', 'MatchPredictionController@update')->name('match-prediction.update');

Route::get('/{iCompetitionId}/user-statistics/{iUserId}', 'UserStatisticsController@index')->name('user-statistics.index');

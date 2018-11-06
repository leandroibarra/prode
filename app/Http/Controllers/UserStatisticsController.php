<?php

namespace App\Http\Controllers;

use App\Models\MatchPrediction;
use App\Models\MatchSchedule;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserStatisticsController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index($piCompetitionId, $piUserId, MatchPrediction $oModelPrediction, MatchSchedule $oModelSchedule, Request $request) {
		$aUser = current($request->attributes)['aUser'];

		if (Auth::user()->id == $aUser['id']) {
			Flash()->error('User is not valid')->important();

			return redirect()->route('ranking.index', ['iCompetitionId'=>current($request->attributes)['aCompetition']['id']]);
		}

		return view('game/user-statistics')->with([
			'aCompetition' => current($request->attributes)['aCompetition'],
			'aUser' => $aUser,
			'aStatistics' => $oModelPrediction->getStatisticsByUser($piUserId),
			'iTotalMatches' => $oModelSchedule->getTotal(),
			'aHitsAndMisses' => $oModelPrediction->getHitsAndMissesByUser($piUserId)
		]);
	}
}

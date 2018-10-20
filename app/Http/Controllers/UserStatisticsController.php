<?php

namespace App\Http\Controllers;

use App\MatchPrediction;
use App\MatchSchedule;
use App\User;

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
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index($piCompetitionId, $piUserId, User $oModelUser, MatchPrediction $oModelPrediction, MatchSchedule $oModelSchedule) {
		$aUser = current($oModelUser->getOne($piUserId)->toArray());

		if (!(bool) $aUser || Auth::user()->id==$aUser['id']) {
			Flash()->error('User is not valid')->important();

			return redirect()->route('ranking.index', ['iCompetitionId'=>1]);
		}

		return view('user-statistics')->with([
			'aUser' => $aUser,
			'aStatistics' => $oModelPrediction->getStatisticsByUser($piUserId),
			'iTotalMatches' => $oModelSchedule->getTotal(),
			'aHitsAndMisses' => $oModelPrediction->getHitsAndMissesByUser($piUserId)
		]);
	}
}

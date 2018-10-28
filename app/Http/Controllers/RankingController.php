<?php

namespace App\Http\Controllers;

use App\MatchPrediction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RankingController extends Controller
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
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index($piConpetitionId, MatchPrediction $oModelPrediction, Request $request)
	{
		return view('game/ranking')->with([
			'aCompetition' => current($request->attributes)['aCompetition'],
			'iUserId' => Auth::user()->id,
			'aRanking' => $oModelPrediction->getRanking()
		]);
	}
}

<?php

namespace App\Http\Controllers;

use App\MatchPrediction;

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
	public function index($piConpetitionId, MatchPrediction $oModelPrediction)
	{
		return view('game/ranking')->with([
			'iUserId' => Auth::user()->id,
			'aRanking' => $oModelPrediction->getRanking()
		]);
	}
}

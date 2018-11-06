<?php

namespace App\Http\Controllers;

use App\MatchPrediction;
use App\MatchSchedule;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($piCompetitionId, MatchPrediction $oModelPrediction, MatchSchedule $oModelSchedule, Request $request)
    {
        return view('game/dashboard')->with([
        	'aCompetition' => current($request->attributes)['aCompetition'],
        	'aStatistics' => $oModelPrediction->getStatisticsByUser(Auth::user()->id),
        	'aRanking' => $oModelPrediction->getRanking(3),
        	'iTotalMatches' => $oModelSchedule->getTotal(),
        	'aNextMatches' => $oModelSchedule->getNexts(Auth::user()->id)->toArray(),
        	'aLastMatches' => $oModelSchedule->getLasts(Auth::user()->id)->toArray()
		]);
    }
}

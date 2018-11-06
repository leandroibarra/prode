<?php

namespace App\Http\Controllers;

use App\Models\MatchPrediction;
use App\Models\MatchSchedule;

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
        	'aStatistics' => $oModelPrediction->getStatisticsByUser($piCompetitionId, Auth::user()->id),
        	'aRanking' => $oModelPrediction->getRanking($piCompetitionId, 3),
        	'iTotalMatches' => $oModelSchedule->getTotalByCompetition($piCompetitionId),
        	'aNextMatches' => $oModelSchedule->getNexts($piCompetitionId, Auth::user()->id)->toArray(),
        	'aLastMatches' => $oModelSchedule->getLasts($piCompetitionId, Auth::user()->id)->toArray()
		]);
    }
}

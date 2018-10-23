<?php

namespace App\Http\Controllers;

use App\MatchPrediction;
use App\MatchSchedule;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatchPredictionController extends Controller
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
    public function index($piCompetitionId, $piMatchScheduleId, MatchPrediction $oModelPrediction, MatchSchedule $oModelSchedule) {
		$aMatchSchedule = current($oModelSchedule->getOne($piMatchScheduleId)->toArray());

		// Match schedule ID not valid or utc datetime has no reached
		if (!(bool) $aMatchSchedule || ($aMatchSchedule['utc_datetime']>date('Y-m-d H:i:s'))) {
			Flash()->error('Match is not valid or datetime has no reached')->important();

			return redirect()->route('dashboard.index', ['iCompetitionId'=>1]);
		}

		return view('game/match-predictions')->with([
			'aMatchSchedule' => $aMatchSchedule,
			'aMatchPredictions' => $oModelPrediction->getPredictionsByMatch($piMatchScheduleId)
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($piCompetitionId, $piMatchScheduleId, MatchPrediction $oModelPrediction, MatchSchedule $oModelSchedule)
	{
		$aMatchSchedule = current($oModelSchedule->getOne($piMatchScheduleId)->toArray());

		// Match schedule ID not valid or utc datetime has reached
		if (!(bool) $aMatchSchedule || ($aMatchSchedule['utc_datetime']<=date('Y-m-d H:i:s'))) {
			Flash()->error('Match is not valid or datetime has reached')->important();

			return redirect()->route('dashboard.index', ['iCompetitionId'=>1]);
		}

		return view('game/match-prediction')->with([
			'aMatchSchedule' => $aMatchSchedule,
			'aMatchPrediction' => current($oModelPrediction->getPredictionsByMatchAndUser($piMatchScheduleId, Auth::user()->id)->toArray())
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, MatchSchedule $oModelSchedule)
	{
		$aMatchSchedule = current($oModelSchedule->getOne($request->input('match_schedule_id'))->toArray());

		// Match schedule ID not valid or utc datetime has reached
		if (!(bool) $aMatchSchedule || ($aMatchSchedule['utc_datetime']<=date('Y-m-d H:i:s'))) {
			Flash()->error('Match is not valid or datetime has reached')->important();

			return redirect()->route('dashboard.index', ['iCompetitionId'=>1]);
		}

		$aIn = ['home', 'away'];

		if ($aMatchSchedule['instance_id'] == 1)
			$aIn[] = 'draw';

		$request->validate([
			'result' => 'required|in:'.implode(',', $aIn)
		]);

		$oMatchPrediction = MatchPrediction::find($request->input('match_prediction_id'));

		if (is_null($oMatchPrediction))
			$oMatchPrediction = new MatchPrediction([
				'match_schedule_id' => $request->input('match_schedule_id'),
				'user_id' => Auth::user()->id,
				'result' => $request->input('result')
			]);
		else
			$oMatchPrediction->result = $request->input('result');

		$oMatchPrediction->save();

		Flash()->success('Prediction has been saved successfully')->important();

		return redirect()->route('dashboard.index', ['iCompetitionId'=>1]);
	}
}

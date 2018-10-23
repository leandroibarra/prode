<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchPrediction extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'matches_predictions';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['match_schedule_id', 'user_id', 'result'];

	/*
	 * BEGIN - Relationships
	 */

	/**
	 * The match schedule which belongs to the match prediction.
	 */
	public function matchSchedule()
	{
		return $this->hasOne('App\MatchSchedule', 'id', 'match_schedule_id');
	}

	/**
	 * The user which belongs to the match prediction.
	 */
	public function user()
	{
		return $this->hasOne('App\User', 'id', 'user_id');
	}

	/*
	 * END - Relationships
	 */

	/**
	 * Retrieve hits and misses belonging to an user.
	 *
	 * @param integer $piUserId
	 * @return array $aHitsAndMatches
	 */
	public function getHitsAndMissesByUser($piUserId) {
		$aHitsAndMatches = [
			'hits' => [],
			'misses' => []
		];

		$oModelSchedule = new \App\MatchSchedule();

		foreach ($oModelSchedule->getLasts($piUserId)->toArray() as $aLastMatch) {
			if (!is_null($aLastMatch['final_result'])) {
				if ((bool) $aLastMatch['user_prediction']) {
					if ($aLastMatch['user_prediction']['result'] == $aLastMatch['final_result'])
						$aHitsAndMatches['hits'][] = $aLastMatch;
					else
						$aHitsAndMatches['misses'][] = $aLastMatch;
				}
			}
		}

		return $aHitsAndMatches;
	}

	/**
	 * Retrieve predictions belonging to a match schedule and belonging to an user.
	 *
	 * @param integer $piMatchScheduleId
	 * @param integer $piUserId
	 * @return mixed
	 */
	public function getPredictionsByMatchAndUser($piMatchScheduleId, $piUserId) {
		return $this
			->where([
				['match_schedule_id', '=', $piMatchScheduleId],
				['user_id', '=', $piUserId]
			])
			->get();
	}

	/**
	 * Retrieve predictions belonging to a match schedule for each user.
	 *
	 * @param integer $piMatchScheduleId
	 * @return array $aMatchPredictions
	 */
	public function getPredictionsByMatch($piMatchScheduleId) {
		$aMatchPredictions = [];

		foreach (\App\User::all() as $iKey=>$aUser) {
			$aMatchPredictions[] = array_merge(
				[
					'user_prediction' => current($this->getPredictionsByMatchAndUser($piMatchScheduleId, $aUser->id)->toArray())
				],
				[
					'iUserId' => $aUser->id,
					'sUserName' => $aUser->name
				]
			);
		}

		return $aMatchPredictions;
	}

	/**
	 * Retrieve statistics belonging to the user.
	 *
	 * @param integer $piUserId
	 * @return array
	 */
	public function getStatisticsByUser($piUserId) {
		$oModelSchedule = new \App\MatchSchedule();

		$aStatistics = [
			'iTotalMatches' => 0,
			'iFinishedMatches' => 0,
			'iPoints' => 0, // User points
			'iTotalPoints' => 0, // Finished matches points summary
			'iPredictions' => 0, // User predictions
			'iHits' => 0, // User hited predictions
			'iMisses' => 0, // User failed predictions
			'fAccuracy' => 0 // User accuracy
		];

		foreach (\App\MatchSchedule::all() as $aMatchSchedule) {
			$aStatistics['iTotalMatches']++;
			$aStatistics['iTotalPoints'] += $aMatchSchedule->points;

			$aMatchPrediction = current($this->getPredictionsByMatchAndUser($aMatchSchedule->id, $piUserId)->toArray());

			if ((bool) $aMatchPrediction) {
				$aStatistics['iPredictions']++;

				if ($aMatchSchedule->final_result) {
					$aStatistics['iFinishedMatches']++;

					if ($aMatchSchedule->final_result == $aMatchPrediction['result']) {
						$aStatistics['iHits']++;

						$aStatistics['iPoints'] += $aMatchSchedule->points;
					} else {
						$aStatistics['iMisses']++;
					}
				}
			}
		}

		if ($aStatistics['iFinishedMatches'] > 0)
			$aStatistics['fAccuracy'] = round(($aStatistics['iHits']*100) / $aStatistics['iFinishedMatches']);

		return $aStatistics;
	}

	/**
	 * Retrieve ranking of users.
	 *
	 * @param integer $piLimit OPTIONAL
	 * @return array $aRanking
	 */
	public function getRanking($piLimit=null) {
		$aPositions = $aPoints = $aPredictions = [];

		$aUsers = \App\User::all();

		$aRanking = [
			'iTotalUsers' => count($aUsers),
			'iRankingUsers' => 0,
			'aRankingUsers' => []
		];

		foreach ($aUsers as $iKey=>$aUser) {
			// Validate limit of users in ranking
			if (!is_null($piLimit) && $piLimit<$iKey+1)
				break;

			$aPositions[] = array_merge(
				$this->getStatisticsByUser($aUser->id),
				array(
					'iUserId' => $aUser->id,
					'sUserName' => $aUser->name
				)
			);
		}

		foreach ($aPositions as $iKey=>$aPosition) {
			$aPoints[$iKey] = $aPosition['iPoints'];
			$aPredictions[$iKey] = $aPosition['iPredictions'];
		}

		// Sort by points and predictions
		array_multisort($aPoints, SORT_DESC, $aPredictions, SORT_ASC, $aPositions);

		$aRanking['iRankingUsers'] = count($aPositions);
		$aRanking['aRankingUsers'] = $aPositions;

		return $aRanking;
	}
}

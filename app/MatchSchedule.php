<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchSchedule extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'matches_schedules';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['home_team_id', 'away_team_id', 'instance_id', 'group_id', 'match_day', 'home_goals', 'away_goals', 'home_goals_penalties', 'away_goals_penalties', 'final_result', 'utc_datetime'];

	/**
	 * BEGIN - Relationships
	 */
	public function homeTeam() {
		return $this->hasOne('App\Team', 'id', 'home_team_id');
	}

	public function awayTeam() {
		return $this->hasOne('App\Team', 'id', 'away_team_id');
	}

	public function instance() {
		return $this->hasOne('App\Instance', 'id', 'instance_id');
	}

	public function group() {
		return $this->hasOne('App\Group', 'id', 'group_id');
	}

	public function matchesPredictions() {
		return $this->hasMany('App\MatchPrediction', 'match_schedule_id', 'id');
	}
	/**
	 * END - Relationships
	 */

	/**
	 * Retrieve amount of matches schedules.
	 *
	 * @return integer
	 */
	public function getTotal() {
		return $this->all()->count();
	}

	/**
	 * Retrieve all matches schedules.
	 *
	 * @return array $aMatchSchedules
	 */
	public function getAll() {
		$aMatchSchedules = $this->all();

		foreach ($aMatchSchedules as $aMatchSchedule)
			$aMatchSchedule['points'] = $this->aPointsByInstance[$aMatchSchedule->instance_id];

		return $aMatchSchedules;
	}

	/**
	 * TODO :: REMOVE
	 * @var array
	 */
	public $aPointsByInstance = array(
		1 => 1,
		2 => 4,
		3 => 6,
		4 => 8,
		5 => 10,
		6 => 10
	);

	/**
	 * Retrieve one match schedule by id.
	 *
	 * @return array $aMatchSchedule
	 */
	public function getOne($piMatchScheduleId) {
		$aMatchSchedule = $this
			->where(['id'=>$piMatchScheduleId])
			->get();

		foreach ($aMatchSchedule as $aMatch) {
			$aMatch->homeTeam;
			$aMatch->awayTeam;
			$aMatch->instance;
			$aMatch->group;
		}

		return $aMatchSchedule;
	}

	/**
	 * Retrieve finished scheduled matches.
	 *
	 * @param integer $piUserId OPTIONAL
	 * @return mixed
	 */
	public function getLasts($piUserId=null) {
		$aLasts = $this
			->where('utc_datetime', '<', date('Y-m-d H:i'))
			->orderBy('utc_datetime', 'desc')
			->get();

		$oMatchPrediction = new \App\MatchPrediction();

		// Complete related data
		foreach ($aLasts as $aLast) {
			$aLast->homeTeam;
			$aLast->awayTeam;
			$aLast->instance;
			$aLast->group;

			$aLast['user_prediction'] = current($oMatchPrediction->getPredictionsByMatchAndUser($aLast->id, $piUserId)->toArray());
			$aLast['points'] = $this->aPointsByInstance[$aLast['instance_id']];
		}

		return $aLasts;
	}

	/**
	 * Retrieve upcoming scheduled matches.
	 *
	 * @param integer $piUserId OPTIONAL
	 * @return mixed
	 */
	public function getNexts($piUserId=null) {
		$aNexts = $this
			->where('utc_datetime', '>', date('Y-m-d H:i'))
			->orderBy('utc_datetime', 'asc')
			->get();

		$oMatchPrediction = new \App\MatchPrediction();

		// Complete related data
		foreach ($aNexts as $aNext) {
			$aNext->homeTeam;
			$aNext->awayTeam;
			$aNext->instance;
			$aNext->group;

			$aNext['user_prediction'] = current($oMatchPrediction->getPredictionsByMatchAndUser($aNext->id, $piUserId)->toArray());
			$aNext['points'] = $this->aPointsByInstance[$aNext['instance_id']];
		}

		return $aNexts;
	}
}

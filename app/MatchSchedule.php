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
	protected $fillable = [
		'competition_id', 'home_team_id', 'away_team_id', 'instance_id',
		'group_id', 'match_day', 'home_goals', 'away_goals',
		'home_goals_penalties', 'away_goals_penalties',
		'points', 'final_result', 'utc_datetime'
	];

	/*
	 * BEGIN - Relationships
	 */

	/**
	 * The competition to which the record belongs.
	 */
	public function competition()
	{
		return $this->hasOne('App\Competition', 'id', 'competition_id');
	}

	/**
	 * The home team to which the record belongs.
	 */
	public function homeTeam()
	{
		return $this->hasOne('App\Team', 'id', 'home_team_id');
	}

	/**
	 * The away team to which the record belongs.
	 */
	public function awayTeam()
	{
		return $this->hasOne('App\Team', 'id', 'away_team_id');
	}

	/**
	 * The instance to which the record belongs.
	 */
	public function instance()
	{
		return $this->hasOne('App\Instance', 'id', 'instance_id');
	}

	/**
	 * The group to which the record belongs.
	 */
	public function group()
	{
		return $this->hasOne('App\Group', 'id', 'group_id');
	}

	/**
	 * The matches predictions that belongs to the match schedule.
	 */
	public function matchesPredictions()
	{
		return $this->hasMany('App\MatchPrediction');
	}

	/*
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
		return $this->all();
	}

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
		}

		return $aNexts;
	}
}

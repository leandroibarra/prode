<?php

namespace App\Models;

class Team extends Localizable
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'teams';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['code', 'name_en', 'name_es'];

	/**
	 * Localized attributes.
	 *
	 * @var array
	 */
	protected $localizable = ['name'];

	/**
	 * The competitions to which the team belongs.
	 */
	public function teamsCompetitions()
	{
		return $this->hasMany('App\Models\TeamCompetition');
	}

	/**
	 * The matches schedules as home team.
	 */
	public function matchesSchedulesHomes()
	{
		return $this->hasMany('App\Models\MatchSchedule','home_team_id', 'id');
	}

	/**
	 * The matches schedules as away team.
	 */
	public function matchesSchedulesAways()
	{
		return $this->hasMany('App\Models\MatchSchedule','away_team_id', 'id');
	}

//	public function matchesSchedules() {
//		$aMatchesSchedules = array_merge($this->matchesSchedulesHomes(), $this->matchesSchedulesAways());
//
//		return $aMatchesSchedules;
//	}
}

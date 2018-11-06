<?php

namespace App\Models;

class Competition extends Localizable
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'competitions';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name_en', 'name_es', 'icon'];

	/**
	 * Localized attributes.
	 *
	 * @var array
	 */
	protected $localizable = ['name'];

	/**
	 * The teams that belongs to the competition.
	 */
	public function teamsCompetitions()
	{
		return $this->hasMany('App\Models\TeamCompetition');
	}

	/**
	 * The matches schedules assigned to the competition.
	 */
	public function matchesSchedules()
	{
		return $this->hasMany('App\Models\MatchSchedule');
	}
}

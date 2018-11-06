<?php

namespace App;

use App\Models\Localizable;

class Group extends Localizable
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'groups';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name_en', 'name_es'];

	/**
	 * Localized attributes.
	 *
	 * @var array
	 */
	protected $localizable = ['name'];

	/**
	 * The competitions to which the group belongs.
	 */
	public function teamsCompetitions()
	{
		return $this->hasMany('App\TeamCompetition');
	}

	/**
	 * The matches schedules assigned to the group.
	 */
	public function matchesSchedules()
	{
		return $this->hasMany('App\MatchSchedule');
	}
}

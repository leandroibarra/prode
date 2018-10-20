<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
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
	protected $fillable = ['name', 'icon'];

	/**
	 * The teams that belongs to the competition.
	 */
	public function teamsCompetitions()
	{
		return $this->hasMany('App\TeamCompetition');
	}

	/**
	 * The matches schedules assigned to the competition.
	 */
	public function matchesSchedules()
	{
		return $this->hasMany('App\MatchSchedule');
	}
}

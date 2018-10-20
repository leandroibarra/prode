<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
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
	protected $fillable = ['name'];

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

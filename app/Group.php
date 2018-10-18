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
	 * The teams groups belongs to the group.
	 */
	public function teamsGroups() {
		return $this->hasMany('App\TeamGroup');
	}

	/**
	 * The matches schedules belongs to the group.
	 */
	public function matchesSchedules() {
		return $this->hasMany('App\MatchSchedule');
	}

	/**
	 * The teams belongs to group.
	 */
//	public function teams() {
//		return $this->hasManyThrough('App\Team', 'App\TeamGroup', 'team_id', 'group_id', 'id', 'id');
//	}
}

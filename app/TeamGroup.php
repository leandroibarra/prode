<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamGroup extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'teams_groups';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['order'];

	/**
	 * The team that belong to the group.
	 */
	public function team()
	{
		return $this->hasOne('App\Team', 'id', 'team_id');
	}

	/**
	 * The group that belong to the team.
	 */
	public function group()
	{
		return $this->hasOne('App\Group', 'id', 'group_id');
	}
}

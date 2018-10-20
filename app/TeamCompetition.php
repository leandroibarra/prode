<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamCompetition extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'teams_competitions';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['team_id', 'competition_id', 'group_id', 'order'];

	/**
	 * The team to which the record belongs.
	 */
	public function team()
	{
		return $this->hasOne('App\Team', 'id', 'team_id');
	}

	/**
	 * The competition to which the record belongs.
	 */
	public function competition()
	{
		return $this->hasOne('App\Competition', 'id', 'competition_id');
	}

	/**
	 * The group to which the record belongs.
	 */
	public function group()
	{
		return $this->hasOne('App\Group', 'id', 'group_id');
	}
}

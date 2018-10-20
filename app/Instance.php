<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'instances';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name'];

	/**
	 * The matches schedules assigned to the instance.
	 */
	public function matchesSchedules()
	{
		return $this->hasMany('App\MatchSchedule');
	}
}

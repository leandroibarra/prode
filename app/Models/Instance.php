<?php

namespace App\Models;

class Instance extends Localizable
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
	protected $fillable = ['name_en', 'name_es'];

	/**
	 * Localized attributes.
	 *
	 * @var array
	 */
	protected $localizable = ['name'];

	/**
	 * The matches schedules assigned to the instance.
	 */
	public function matchesSchedules()
	{
		return $this->hasMany('App\Models\MatchSchedule');
	}
}

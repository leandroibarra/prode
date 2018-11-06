<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/*
	 * BEGIN - Relationships
	 */

	/**
	 * The matches predictions assigned to the user.
	 */
	public function matchesPredictions()
	{
		return $this->hasMany('App\Models\MatchPrediction');
	}

	/*
	 * END - Relationships
	 */

	/**
	 * Retrieve one user by id.
	 *
	 */
	public function getOne($piUserId) {
		return $this
			->where(['id'=>$piUserId])
			->get();
	}
}

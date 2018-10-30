<?php

namespace App\Http\Controllers;

use App\Competition;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	}

    public function index() {
		return view('game/home')->with([
			'aCompetitions' => Competition::all()->toArray()
		]);
    }
}

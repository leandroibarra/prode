<?php

namespace App\Http\Middleware;

use Closure;

class CheckCompetition
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	$oCompetition = \App\Models\Competition::find($request->route()->iCompetitionId);

    	if (!(bool) $oCompetition) {
			Flash()->error(__('The competition is not valid'))->important();

			return redirect('/home');
		}

		$request->attributes->set('aCompetition', $oCompetition->toArray());

        return $next($request);
    }
}

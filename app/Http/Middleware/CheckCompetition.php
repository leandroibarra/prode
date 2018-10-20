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
    	if (!(bool) \App\Competition::find($request->route()->iCompetitionId)) {
			Flash()->error('Competition is not valid')->important();

			return redirect('/home');
		}

        return $next($request);
    }
}

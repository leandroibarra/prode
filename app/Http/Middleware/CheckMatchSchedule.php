<?php

namespace App\Http\Middleware;

use Closure;

class CheckMatchSchedule
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
		$oMatchSchedule = \App\Models\MatchSchedule::where(['id'=>$request->route()->iMatchId, 'competition_id'=>$request->route()->iCompetitionId])->get();

		if (!(bool) $oMatchSchedule) {
			Flash()->error('Match is not valid')->important();

			return redirect()->route('dashboard.index', ['iCompetitionId'=>$request->route()->iCompetitionId]);
		}

		foreach ($oMatchSchedule as $aMatch) {
			$aMatch->homeTeam;
			$aMatch->awayTeam;
			$aMatch->instance;
			$aMatch->group;
		}

		$request->attributes->set('aMatchSchedule', $oMatchSchedule->toArray());

        return $next($request);
    }
}

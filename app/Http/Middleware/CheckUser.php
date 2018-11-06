<?php

namespace App\Http\Middleware;

use Closure;

class CheckUser
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
		$oUser = \App\Models\User::find($request->route()->iUserId);

		if (!(bool) $oUser) {
			Flash()->error('User is not valid')->important();

			return redirect('/home');
		}

		$request->attributes->set('aUser', $oUser->toArray());

        return $next($request);
    }
}

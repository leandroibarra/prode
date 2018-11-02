<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckLocale
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
    	// Cleaned session handling
    	$sLocale = (Session::has('locale')) ? Session::get('locale') : locale()->current();

    	locale()->set($sLocale);

        return $next($request);
    }
}

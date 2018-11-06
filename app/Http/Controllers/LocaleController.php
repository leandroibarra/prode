<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function edit($psLocale) {
    	if (locale()->isSupported($psLocale))
    		Session::put('locale', $psLocale);
    	else
			Session::put('locale', locale()->current());

		return redirect()->back();
	}
}

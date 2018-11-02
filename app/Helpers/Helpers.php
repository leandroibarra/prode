<?php
/**
 * Retrieve our Locale instance
 *
 * @return App\Classes\Locale
 */
function locale()
{
	return app()->make(App\Classes\Locale::class);
}
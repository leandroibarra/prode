<?php
namespace App\Listeners;

class TimezoneOffsetMinutes
{
	/**
	 * Handle user login events.
	 */
	public function handleTimezoneOffsetMinutes($event)
	{
		$iTimezoneOffsetMinutes = request()->input('timezone_offset_minutes');
		$iTimezoneOffsetMinutes = (empty($iTimezoneOffsetMinutes)) ? date('Z') / 60 : $iTimezoneOffsetMinutes;

		if (auth()->user()->timezone_offset_minutes != $iTimezoneOffsetMinutes) {
			$oUser = auth()->user();

			$oUser->timezone_offset_minutes = $iTimezoneOffsetMinutes;

			$oUser->save();
		}
	}

	/**
	 * Register the listeners for the subscriber.
	 *
	 * @param  \Illuminate\Events\Dispatcher  $events
	 */
	public function subscribe($events)
	{
		$events->listen(
			'Illuminate\Auth\Events\Login',
			'App\Listeners\TimezoneOffsetMinutes@handleTimezoneOffsetMinutes'
		);

		$events->listen(
			'Illuminate\Auth\Events\PasswordResetPasswordReset',
			'App\Listeners\TimezoneOffsetMinutes@handleTimezoneOffsetMinutes'
		);
	}
}
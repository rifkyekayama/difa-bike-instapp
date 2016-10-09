<?php

namespace App\Helpers;

use App\Models\Notification\Notif;

class Helpers{

	public static function notifCount()
	{
		return Notif::where('read_at', '=', NULL)->count();
	}

}
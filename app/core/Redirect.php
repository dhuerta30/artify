<?php

namespace App\core;

class Redirect
{
	public static function to($url)
	{
		header("Location: " . $_ENV["BASE_URL"] . $url);
		return $url;
	}
}
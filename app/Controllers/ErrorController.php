<?php

namespace App\Controllers;

use App\core\View;

class ErrorController
{
	public function __construct()
	{
	}

	public function index()
	{
		View::render(
			"error"
		);
	}
}

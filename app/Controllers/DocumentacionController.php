<?php

namespace App\Controllers;

use App\core\SessionManager;
use App\core\Token;
use App\core\Request;
use App\core\View;
use App\core\Redirect;
use App\core\DB;

class DocumentacionController
{
    public function index()
    {
        View::render("documentacion");
    }
}
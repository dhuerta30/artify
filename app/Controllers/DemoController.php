<?php

namespace App\Controllers;

use App\core\SessionManager;
use App\core\Token;
use App\core\DB;
use App\core\View;
use App\core\Redirect;

class DemoController
{
    public $token;

    public function __construct()
    {
        SessionManager::startSession();
        $Sesusuario = SessionManager::get('usuario');
        if (!isset($Sesusuario)) {
            Redirect::to('login/index');
        }
        $this->token = Token::generateFormToken('send_message');
    }

    public function index()
    {
        $pdocrud = DB::PDOCrud();
        $pdocrud->tableHeading("demo");
        $render = $pdocrud->setQuery('SELECT id as ID, name as Name FROM demo')->render('SQL');

        View::render(
            'demo', 
            [
                'render' => $render
            ]
        );
    }
}
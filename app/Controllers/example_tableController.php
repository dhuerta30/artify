<?php

namespace App\Controllers;

use App\core\SessionManager;
use App\core\Token;
use App\core\DB;
use App\core\View;
use App\core\Redirect;

class example_tableController
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
        $render = $pdocrud->dbTable('example_table')->render();

        View::render(
            'example_view', 
            [
                'render' => $render
            ]
        );
    }
}
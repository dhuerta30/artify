<?php

namespace App\Controllers;

use App\core\SessionManager;
use App\core\Token;
use App\core\Request;
use App\core\View;
use App\core\Redirect;
use App\core\DB;

class LicenciaController
{
    public $token;

	public function __construct()
	{
		SessionManager::startSession();
		$Sesusuario = SessionManager::get('usuario');
		if (!isset($Sesusuario)) {
			Redirect::to("login/index");
		}
        $this->token = Token::generateFormToken('send_message');
	}

    public function index()
    {
        $artify = DB::ArtifyCrud();
        $artify->fieldRenameLable("license_key", "Código de Licencia");
        $artify->formFields(array("license_key"));
        $render = $artify->dbTable("licenses")->render("insertform");   
        View::render('licencia', [
            'render' => $render
        ]);
    }
}
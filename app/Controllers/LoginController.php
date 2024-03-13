<?php 

namespace App\Controllers;

use App\core\SessionManager;
use App\core\Token;
use App\core\Redirect;
use App\core\View;
use App\core\DB;
use App\Models\UserModel;

class LoginController {

    public function __construct()
	{
		SessionManager::startSession();

		if (isset($_SESSION["data"]["usuario"]["usuario"])) {
			$pdocrud = DB::PDOCrud();
			$pdomodel = $pdocrud->getPDOModelObj();
			$pdomodel->where("usuario", $_SESSION["data"]["usuario"]["usuario"]);
			$sesion_users = $pdomodel->select("usuario");
			$_SESSION["usuario"] = $sesion_users;
		}

		$Sesusuario = SessionManager::get('usuario');
		if (isset($Sesusuario)) {
			Redirect::to("home/usuarios");
		}
	}

    public function index(){
        $pdocrud = DB::PDOCrud();
		$pdocrud->fieldDisplayOrder(array("usuario", "password"));
		$pdocrud->fieldRenameLable("email", "Correo");
		$pdocrud->fieldRenameLable("password", "Contraseña");
        $pdocrud->fieldAddOnInfo("usuario", "before", '<div class="input-group-append"><span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span></div>');
        $pdocrud->fieldAddOnInfo("password", "before", '<div class="input-group-append"><span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></span></div>');
		$pdocrud->addCallback("before_select", "beforeloginCallback");
		$pdocrud->formFields(array("usuario", "password"));
		$pdocrud->setLangData("login", "Ingresar");
		$login = $pdocrud->dbTable("usuario")->render("selectform");

        View::render('login', ['login' => $login]);
    }

	public function users()
	{
		$users = new UserModel();
		$result = $users->select_users();

		echo json_encode($result);
	}

    public function salir()
	{
		SessionManager::startSession();
		SessionManager::destroy();
		Redirect::to("login/index");
	}

    public function reset()
	{
		$pdocrud = DB::PDOCrud();
		$pdocrud->fieldRenameLable("email", "Correo");
		$pdocrud->fieldAddOnInfo("email", "before", '<div class="input-group-append"><span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope-o"></i></span></div>');
		$pdocrud->addCallback("before_select", "resetloginCallback");
		$pdocrud->formFields(array("email"));
		$pdocrud->setLangData("login", "Recuperar");
		$reset = $pdocrud->dbTable("usuario")->render("selectform");

		View::render('reset', ['reset' => $reset]);
	}
}